<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
use WHMCS\Database\Capsule;
define("CLIENTAREA", true);
require __DIR__ . '/init.php';

// Function to retrieve alias data
function getCMSAliasData() {
    try {
        $aliasData = Capsule::table('mod_whmcms_pages')
            ->select('alias')
            ->get();

        return $aliasData;
    } catch (\Exception $e) {
        logActivity('Error fetching data from mod_whmcms_pages: ' . $e->getMessage());
        return [];
    }
}

// Generate sitemap.xml
function generateSitemapXML() {
    $aliasData = getCMSAliasData();

    // Create a new SimpleXML object
    $sitemap = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"></urlset>');

    // Loop through alias data and add URLs to the sitemap with line breaks
    foreach ($aliasData as $row) {
        $url = $sitemap->addChild('url');
        $url->addChild('loc', 'https://optimedia.tv/' . $row->alias); // Replace with your website URL and alias data source
        $url->addChild('changefreq', 'weekly'); // Add any other elements as needed
        $url->addChild('priority', '0.8');    // Add any other elements as needed
    }

    // Format the XML with line breaks
    $xmlString = $sitemap->asXML();
    $xmlString = str_replace('</url>', '</url>' . PHP_EOL, $xmlString);

    // Save the XML to sitemap.xml
    file_put_contents('sitemap_whmcms.xml', $xmlString);
}

// Generate and save the sitemap
generateSitemapXML();

echo 'Sitemap generated successfully.';
?>
