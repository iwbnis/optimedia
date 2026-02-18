<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use WHMCS\Database\Capsule;

define("CLIENTAREA", true);
require './init.php';

$currencies = Capsule::table('tblcurrencies')
    ->select('id', 'code', 'prefix', 'suffix')
    ->get()
    ->keyBy('id');

// Fetch products with order column included
$products = Capsule::table('tblproducts')
    ->where('hidden', 0)
    ->orderBy('order', 'asc') // Sort by the 'order' column in ascending order
    ->get();

$categories = Capsule::table('tblproductgroups')
    ->select('id', 'name', 'order', 'hidden', 'headline', 'tagline')
    ->orderBy('order', 'asc')
    ->get()
    ->keyBy('id');

if (!$products->count()) {
    echo json_encode(["message" => "No products found."], JSON_PRETTY_PRINT);
    exit;
}

$groupedProducts = [];
$uniqueProductIdentifiers = [];

foreach ($products as $product) {
    $groupId = $product->gid;

    // Ensure category is set, not hidden, and has a non-empty name
    if (!isset($categories[$groupId]) || $categories[$groupId]->hidden == 1 || empty($categories[$groupId]->name)) {
        continue;
    }

    $description = strip_tags($product->description);
    $productPrice = Capsule::table('tblpricing')
        ->leftJoin('tblcurrencies', 'tblpricing.currency', '=', 'tblcurrencies.id')
        ->where('tblpricing.type', 'product')
        ->where('tblpricing.relid', $product->id)
        ->select('tblpricing.*', 'tblcurrencies.code as currency_code', 'tblcurrencies.prefix as currency_prefix', 'tblcurrencies.suffix as currency_suffix', 'tblcurrencies.id as currency_id') // Include currency ID
        ->get();

    foreach ($productPrice as $price) {
        $durations = ['monthly', 'quarterly', 'semiannually', 'annually', 'biennially', 'triennially'];
        $durationPrice = null;
        $durationName = '';

        foreach ($durations as $duration) {
            if ($price->$duration >= 0) {
                $durationPrice = $price->$duration;
                $durationName = $duration;
                break;
            }
        }

        // Check if the product has a matching relid in tblcustomfields
        $customField = Capsule::table('tblcustomfields')
            ->where('relid', $product->id)
            ->first();

        // Determine the value of no_customfield based on the presence of a matching relid
        $noCustomField = ($customField === null) ? 1 : 0;

        // Generate the product URL based on the domain name, product ID, and currency ID
        $currentDomain = $_SERVER['HTTP_HOST'];
        $productURL = "https://{$currentDomain}/cart.php?a=add&pid={$product->id}&amp;currency={$price->currency_id}"; // Use &amp; to encode the ampersand correctly

        $productIdentifier = $product->name . '|' . $description . '|' . $price->currency_code;

        if (!in_array($productIdentifier, $uniqueProductIdentifiers)) {
            $uniqueProductIdentifiers[] = $productIdentifier;

            $productEntry = [
                "productid" => $product->id,
                "productname" => $product->name,
                "productdescription" => $description,
                "productprice" => $price->currency_prefix . $durationPrice . " " . $price->currency_code . ' ' . ucfirst($durationName),
                "billingcycle" => ucfirst($durationName),
                "currencycode" => $price->currency_code,
                "currencyid" => $price->currency_id, // Include the currency ID
                "category_name" => $categories[$groupId]->name,
                "product_order" => $product->order, // Include the 'order' column
                "no_customfield" => $noCustomField, // Set no_customfield based on relid existence
                "url" => $productURL, // Add the product URL with currency ID
            ];

            if (!isset($groupedProducts[$groupId])) {
                $groupedProducts[$groupId] = [
                    "gid" => $groupId,
                    "category_name" => $categories[$groupId]->name,
                    "category_order" => $categories[$groupId]->order,
                    "category_headline" => $categories[$groupId]->headline,
                    "category_tagline" => $categories[$groupId]->tagline,
                    "products" => []
                ];
            }

            $groupedProducts[$groupId]['products'][] = $productEntry;
        }
    }
}

// Sort the grouped products by 'category_order' in ascending order
usort($groupedProducts, function ($a, $b) {
    return $a['category_order'] - $b['category_order'];
});

function get_client_ip() {
    return $_SERVER['HTTP_X_FORWARDED_FOR']
        ?? $_SERVER['REMOTE_ADDR']
        ?? $_SERVER['HTTP_CLIENT_IP']
        ?? '';
}
$clientIP = get_client_ip();

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "http://localhost/getCountry.php");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, "ipAddress={$clientIP}");
curl_setopt($ch, CURLOPT_VERBOSE, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$currency = curl_exec($ch);
curl_close($ch);
$currency1 = json_decode($currency);
$currency2 = [];
foreach ($currencies as $data) {
    $currency2[] = $data->code;
}

if (in_array($currency1->currency, $currency2)) {
    for ($i = 0; $i < count($groupedProducts); $i++) {
        usort($groupedProducts[$i]['products'], function ($a, $b) use ($currency1) {
            $diff = $a['product_order'] - $b['product_order'];
            if ($diff == 0) {
                if ($a['currencycode'] == $currency1->currency) {
                    return -1;
                } else {
                    return 1;
                }
            } else {
                return $diff;
            }
        });
    }
} else {
    for ($i = 0; $i < count($groupedProducts); $i++) {
        usort($groupedProducts[$i]['products'], function ($a, $b) {
            $diff = $a['product_order'] - $b['product_order'];
            if ($diff == 0) {
                if ($a['currencycode'] == 'USD') {
                    return -1;
                } else {
                    return 1;
                }
            } else {
                return $diff;
            }
        });
    }
}

// Encode JSON with unescaped slashes
echo json_encode($groupedProducts, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
