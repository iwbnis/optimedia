<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use WHMCS\Database\Capsule;

define("CLIENTAREA", true);
require __DIR__ . '/init.php';

// Function to extract all image URLs from content
function getImageUrls($content) {
    $decodedContent = htmlspecialchars_decode($content);
    preg_match_all('/<img[^>]+src="(.*?)"/', $decodedContent, $matches);
    
    // Return the matched URLs or an empty array
    return isset($matches[1]) ? $matches[1] : [];
}

// Fetch data from the mod_whmcms_pages table where enable=1
$enabledPages = Capsule::table('mod_whmcms_pages')->where('enable', 1)->get();

$results = [];

$domainPrefix = (isset($_SERVER['HTTPS']) ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'];

foreach ($enabledPages as $page) {
    $imageUrls = getImageUrls($page->content);
    
    $strippedContent = htmlspecialchars_decode(strip_tags(str_replace(["\r\n", "\t"], ' ', $page->content)));
    
    $results[] = [
        "pageid" => $page->pageid,
        "title" => $page->title,
        "subtitle" => $page->subtitle,
        "content" => $strippedContent,
        "info" => $strippedContent, // This line removes HTML tags from "info"
        "coverimage" => $imageUrls[0] ?? null,
        "imageurls" => $imageUrls,
        "alias" => $domainPrefix . '/' . $page->alias,
        "metadescription" => $page->metadescription,
        "metakeywords" => $page->metakeywords,
        "datecreate" => date('Y-m-d', strtotime($page->datecreate)),
        "hits" => $page->hits
    ];
}

header('Content-Type: application/json');
echo json_encode($results, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

//$ca->setTemplate('whmcms_blogs');

//$ca->output();
