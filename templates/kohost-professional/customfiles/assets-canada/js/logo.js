(() => {
  const DOMAINS_LOGO = {
    "iptvuk.vip": "/templates/kohost-professional/customfiles/assets-canada/iptv-uk-logo.png",

    "iptvcanada.vip":
      "/templates/kohost-professional/customfiles/assets-canada/iptv-canada-logo.png",

    "iptvquebec.vip": "/templates/kohost-professional/customfiles/assets-canada/quebecflag2.png",

    "choiceiptv.net": "/templates/kohost-professional/customfiles/assets-canada/tvhub_logo.png",
  };

  const { host } = window.location;
  let defaultLogo = DOMAINS_LOGO["iptvquebec.vip"];
  let logoToApply = DOMAINS_LOGO[host] || defaultLogo;

  const siteLogos = document.querySelectorAll(".site-logo");

  siteLogos.forEach((logoElement) => {
    logoElement.setAttribute("src", logoToApply);
  });
})();
