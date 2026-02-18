<?php
// Define the website URL
$website_url = "https://iptvcanada.vip";

// Function to fetch and parse the webpage
function fetch_and_parse_url($url) {
    try {
        $content = file_get_contents($url);
        return $content;
    } catch (Exception $e) {
        echo "Error fetching the webpage: " . $e->getMessage();
        return null;
    }
}

try {
    // Fetch the webpage content
    $webpage_content = fetch_and_parse_url($website_url);

    if ($webpage_content !== null) {
        // Get the last modified date (you may need to customize this)
        $last_modified = date('c');

        // Create the sitemap content
        $sitemap_content = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc>{$website_url}</loc>
        <lastmod>{$last_modified}</lastmod>
    </url>
</urlset>
XML;

        // Define the file path and name for the sitemap
        $sitemap_file_path = "sitemap-iptvcanada.xml";

        // Save the sitemap to a file
        $result = file_put_contents($sitemap_file_path, $sitemap_content);

        if ($result !== false) {
            echo "Sitemap generated successfully and saved to '{$sitemap_file_path}'.";
        } else {
            echo "Error saving the sitemap file.";
        }
    } else {
        echo "No data to generate a sitemap.";
    }
} catch (Exception $e) {
    echo "An error occurred: " . $e->getMessage();
}
?>
