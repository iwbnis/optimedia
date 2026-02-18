<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use WHMCS\Database\Capsule;

define("CLIENTAREA", true);
require __DIR__ . '/init.php';

// Get the data from the mod_whmcms_portfolio table
$portfolioData = Capsule::table('mod_whmcms_portfolio')
    ->select('projectid', 'topid', 'client', 'title', 'alias', 'details', 'logo', 'tags', 'datecreate', 'datemodify', 'hits')
    ->get();

$imageUrl1 = Capsule::table('mod_whmcms_photos')
    ->select('parentid', 'source')
    ->get();

$imageMap =  new stdClass();
foreach ($imageUrl1 as $row) {
	$imagekey = $row->parentid;
	$imagesource = $row->source;
	$imageMap->$imagekey = $imagesource;
}

// Create an array to store projectid-categoryid mappings
$projectCategoryMap = [];

// Get the data from the mod_whmcms_portfoliorelations table
$relationsData = Capsule::table('mod_whmcms_portfoliorelations')
    ->select('projectid', 'categoryid')
    ->get();

// Populate the projectid-categoryid mapping array
foreach ($relationsData as $row) {
    $projectCategoryMap[$row->projectid] = $row->categoryid;
}

// Get the data from the mod_whmcms_portfoliocategories table
$categoryData = Capsule::table('mod_whmcms_portfoliocategories')
    ->select('categoryid', 'title', 'enable')
    ->get();

// Create an array to store categoryid-title-enable mappings
$categoryInfoMap = [];

// Populate the categoryid-title-enable mapping array
foreach ($categoryData as $row) {
    $categoryInfoMap[$row->categoryid] = [
        'title' => $row->title,
        'enable' => $row->enable,
    ];
}

// Get the current domain name of the website
$domainName = $_SERVER['HTTP_X_REAL_HOST'] ?? $_SERVER['HTTP_HOST'];

// Convert the data to an array with category information
$portfolioArray = [];

foreach ($portfolioData as $row) {
    $projectid = $row->projectid;
    $categoryid = isset($projectCategoryMap[$projectid]) ? $projectCategoryMap[$projectid] : null;

    // Get category information based on categoryid
    $categoryInfo = isset($categoryInfoMap[$categoryid]) ? $categoryInfoMap[$categoryid] : null;

    if ($categoryInfo && isset($categoryInfo['title']) && $categoryInfo['title'] === $domainName) {
        // If category_title matches the domain name, include the data in the array
        $alias = $row->alias;
        $url = "https://{$domainName}/articles/{$alias}";

        // Search for all URLs in the details parameter
        $details = $row->details;
        $urls = extractUrlsFromDetails($details);

        // Filter URLs to include only image URLs
        $imageUrls = filterImageUrls($urls);
        $videoUrl = findVideoUrl($urls);
	$returnImageArr = [];
	array_push($returnImageArr, '/modules/addons/whmcms/resize.php?src='.$imageMap->$projectid);
        $portfolioArray[] = [
            'projectid' => $projectid,
            'topid' => $row->topid,
            'client' => $row->client,
            'title' => $row->title,
            'alias' => $alias,
            'details' => $row->details,
            'logo' => $row->logo,
            'tags' => $row->tags,
            'datecreate' => $row->datecreate,
            'datemodify' => $row->datemodify,
            'hits' => $row->hits,
            'categoryid' => $categoryid,
            'category_title' => isset($categoryInfo['title']) ? $categoryInfo['title'] : null,
            'category_enable' => isset($categoryInfo['enable']) ? $categoryInfo['enable'] : null,
            'url' => $url,
            // Include all URLs in all_urls
            'image_url' => $returnImageArr, // Include all URLs in all_urls
            'video_url' => $videoUrl, // Include video URL if found
        ];
    }
}

// Function to extract all URLs from HTML content
function extractUrlsFromDetails($html) {
    $pattern = '/\bhttps?:\/\/\S+\b/';
    preg_match_all($pattern, $html, $matches);
    return $matches[0];
}

// Function to filter out image URLs
function filterImageUrls($urls) {
    $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp'];
    $filteredUrls = [];

    foreach ($urls as $url) {
        $extension = pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION);
        if (in_array(strtolower($extension), $imageExtensions)) {
            $filteredUrls[] = $url;
        }
    }

    return $filteredUrls;
}

// Function to find a video URL in the given array of URLs
function findVideoUrl($urls) {
    $videoExtensions = ['mp4', 'avi', 'mkv', 'mov', 'flv', 'wmv'];

    foreach ($urls as $url) {
        foreach ($videoExtensions as $extension) {
            if (stripos($url, '.' . $extension) !== false) {
                return $url;
            }
        }
    }

    return null;
}

// Check if there is matching data to display
if (!empty($portfolioArray)) {
    // Convert the array to a JSON string with pretty formatting and unescaped slashes
    $jsonData = json_encode($portfolioArray, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

    // Display the JSON data
    echo "<pre>" . $jsonData . "</pre>";
} else {
    echo "No matching data found for the domain: " . $domainName;
}
?>
