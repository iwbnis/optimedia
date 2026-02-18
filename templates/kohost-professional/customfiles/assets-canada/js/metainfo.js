// Define a function to update meta tags based on the current domain
function updateMetaTags() {
    var currentDomain = window.location.hostname;

    // Define meta information for different domains
    var metaInfo = {
        "iptvuk.vip": {
            title: "Best IPTV in UK | Best IPTV UK Provider - IPTVUK.vip",
            description: "Best IPTV in UK and UK IPTV Provider. 100% RELIABLE.NO BUFFER",
            keywords: "iptv uk, best iptv in uk, best iptv uk, best uk iptv, uk iptv, best iptv uk reddit, iptv providers uk",
        },
        "iptvcanada.vip": {
            title: "IPTV Canada | Best IPTV Providers in Canada - IPTVCanada.vip",
            description: "The best IPTV Canada Provider & IPTV Canada Reddit recommendation. 100% RELIABLE, NO BUFFER Canadian IPTV.",
            keywords: "iptv canada, iptv canada reddit, best iptv canada, canada iptv, iptv in canada, iptv providers canada",
        },
        "iptvquebec.vip": {
            title: "Meilleur IPTV Quebec | IPTV Montreal - IPTVQuebec.vip",
            description: "Best IPTV Quebec and Montreal & meilleur IPTV Quebec. 100% RELIABLE. NO BUFFER!",
            keywords: "iptv quebec, iptv montreal, Meilleur IPTV Quebec, quebec iptv",
        },
        "choiceiptv.net": {
            title: "Choice IPTV - Your Choice for Streaming",
            description: "Choose the best streaming experience with Choice IPTV. Access a variety of channels and content.",
            keywords: "choice iptv, streaming, IPTV, channels, content",
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
