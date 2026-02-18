// Define a function to update the favicon based on the current domain
function updateFavicon() {
    var currentDomain = window.location.hostname;

    // Define favicon URLs for different domains
    var faviconUrls = {
        "iptvuk.vip": "/templates/kohost-professional/customfiles/assets-canada/iptv-uk-favicon.ico",
        "iptvcanada.vip": "/templates/kohost-professional/customfiles/assets-canada/iptvcanada.ico",
        "iptvquebec.vip": "/templates/kohost-professional/customfiles/assets-canada/iptv-quebec-favicon.ico",
        "choiceiptv.net": "/templates/kohost-professional/customfiles/assets-canada/iptvchoice.ico"
    };

    // Check if the current domain has an associated favicon URL
    if (faviconUrls.hasOwnProperty(currentDomain)) {
        var faviconUrl = faviconUrls[currentDomain];

        // Append a random query parameter to the favicon URL to force a refresh
        faviconUrl += "?v=" + Math.random();

        // Create a new favicon link element
        var linkElement = document.createElement("link");
        linkElement.rel = "icon";
        linkElement.type = "image/x-icon";
        linkElement.href = faviconUrl;

        // Replace the existing favicon (if any)
        var existingFavicon = document.querySelector("link[rel='icon']");
        if (existingFavicon) {
            existingFavicon.parentNode.removeChild(existingFavicon);
        }

        // Append the new favicon link element to the head of the document
        document.head.appendChild(linkElement);
    }
}

// Call the updateFavicon function when the page loads
window.onload = updateFavicon;
