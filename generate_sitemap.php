<?php
// Define your WHMCS root URL
$whmcsBaseUrl = 'https://optimedia.tv/';

// Define the sitemap filename
$sitemapFilename = 'sitemap.xml';

// Define an array of URLs to include in the sitemap
$urls = [
    '', // Add your WHMCS homepage URL
    'clientarea.php', // Add your client area URL
    'cart.php', // Add your shopping cart URL
    'order.php', // Add your order page URL
    'login.php', // Add your login page URL
    'register.php', // Add your registration page URL
    'knowledgebase.php', // Add your knowledgebase URL
    'contact.php', // Add your contact page URL
    'products.php', // Add your products listing page URL
    // Add more client pages as needed

];

// Generate the sitemap XML
$sitemap = '<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
';

foreach ($urls as $url) {
    $fullUrl = $whmcsBaseUrl . $url;
    $sitemap .= "<url>\n";
    $sitemap .= "  <loc>{$fullUrl}</loc>\n";
    $sitemap .= "  <lastmod>" . date('c', time()) . "</lastmod>\n";
    $sitemap .= "  <changefreq>weekly</changefreq>\n";
    $sitemap .= "  <priority>0.8</priority>\n";
    $sitemap .= "</url>\n";
}

$sitemap .= '</urlset>';

// Save the sitemap to a file
file_put_contents($sitemapFilename, $sitemap);

echo "Sitemap generated successfully and saved as '{$sitemapFilename}'.";
?>
