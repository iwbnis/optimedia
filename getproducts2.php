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
$upgradableId = [ 250, 261, 249, 265, 260, 251, 262, 252, 266, 253, 254, 263, 255, 267, 256, 257,
  264, 258, 268, 259, 38, 73, 37, 164, 53, 40, 74, 41, 206, 42, 43, 75, 44, 247,
  45, 46, 76, 47, 248, 48, 128, 278, 129, 289, 130, 179, 280, 180, 281, 181,
  182, 282, 183, 283, 291, 284, 285, 286, 287, 184, 118, 269, 119, 270, 120,
  121, 271, 122, 272, 123, 292, 273, 126, 125, 127, 274, 275, 276, 277, 288,
  227, 228, 229, 230, 231, 232, 233, 234, 235, 236, 237, 238, 239, 240, 241,
  242, 243, 244, 245, 246, 207, 208, 209, 210, 211, 212, 213, 214, 215, 216,
  217, 218, 219, 220, 221, 222, 223, 224, 225, 226, 293, 294, 300, 301, 302,
  303, 304, 305, 306, 307, 308, 309, 310, 311, 312, 313, 314, 315, 316, 317,
  295, 319, 320, 321, 322, 323, 324, 325, 326, 327, 328, 329, 330, 331, 332,
  333, 334, 335, 336, 337, 296, 338, 339, 340, 341, 342, 343, 344, 345, 346,
  347, 348, 349, 350, 351, 352, 353, 354, 355, 356, 297, 357, 358, 359, 360,
  361, 362, 363, 364, 365, 366, 367, 368, 369, 370, 371, 372, 373, 374, 375,
  199, 394, 432, 435, 436, 437, 438, 439, 440, 441, 442, 443, 444, 445, 446,
  447, 448, 454, 451, 455, 395, 392, 396, 397, 398, 399, 400, 401, 402, 403,
  404, 405, 406, 407, 408, 409, 410, 411, 412, 413 ];
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
        $currentDomain =  $_SERVER['HTTP_X_REAL_HOST'] ?? $_SERVER['HTTP_HOST'];
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
	for ($t = 0; $t < count($groupedProducts[$i]['products']); $t++) {
	if (in_array($groupedProducts[$i]['products'][$t]['productid'], $upgradableId, true)) {
	$groupedProducts[$i]['products'][$t]['upgradable'] = 1;
	}
}
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
