// Define a function to update meta tags based on the current domain
function updateMetaTags() {
    var currentDomain = window.location.hostname;
    
    // Define meta information for different domains
    var metaInfo = {
        "iptvuk.vip": {
            title: "IPTV in UK Articles List",
            description: "IPTV UK: Learn how to maximimize your streaming with tutorials and guides on IPTV in the UK.",        
			keywords: "iptv uk, best iptv in uk, best iptv uk, best uk iptv, uk iptv, best iptv uk reddit, iptv providers uk",
			},
         "iptvcanada.vip": {
            title: "IPTV in Canada Articles List",
            description: "Learn how to maximimize your streaming with tutorials and guides on IPTV Canada.",
			keywords: "iptv canada, iptv canada reddit, best iptv canada, canada iptv, iptv in canada, iptv providers canada",
        },
        "iptvquebec.vip": {
            title: "Meilleur IPTV Quebec Articles & Guides for IPTV Services in the Quebec",
            description: "Meilleur IPTV Quebec: Learn how to maximimize your streaming with tutorials and guides",
			keywords: "iptv quebec, iptv montreal, Meilleur IPTV Quebec, quebec iptv",
        },
        "choiceiptv.net": {
            title: "Choice IPTV - Your Choice for Streaming",
            description: "Choose the best streaming experience with Choice IPTV. Access a variety of channels and content.",
        }
    };

    // Check if the current domain has associated meta information
    if (metaInfo.hasOwnProperty(currentDomain)) {
        var info = metaInfo[currentDomain];
        document.title = info.title;

        // Update the meta description tag (if available)
        var metaDescriptionTag = document.querySelector("meta[name='description']");
        if (metaDescriptionTag) {
            metaDescriptionTag.setAttribute("content", info.description);
        }
		
		 // Update the meta keywords tag (if available)
        var metaKeywordsTag = document.querySelector("meta[name='keywords']");
        if (metaKeywordsTag) {
            metaKeywordsTag.setAttribute("content", info.keywords);
        }
    }
}

// Call the updateMetaTags function when the page loads
window.onload = updateMetaTags;
