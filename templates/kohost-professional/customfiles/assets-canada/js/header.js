(() => {
  const headerCSS = `
    nav {
        padding: 1vh 2.5vw;
        width: 100%;
        background-color: var(--color-primary);
        box-shadow: 0 3px 20px rgba(0, 0, 0, 0.2);
        position: fixed;
        top: 0;
        display: flex;
        z-index: 100;
        min-height: 7vh;
    }

    /*Styling logo*/
    .logo {
        text-align: center;
    }
    .logo a {
        display: flex;
        gap: 5px;
        align-items: center;
    }

    .logo a {
        font-size: 2rem;
    }
    .logo img {
        width: 4rem;
    }
    /*Styling Links*/
    .nav-links {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 2rem;

        list-style: none;
        width: 88vw;
        padding: 0 0.7vw;

        text-transform: uppercase;
    }
    .nav-links li a {
        text-decoration: none;
        margin: 0 0.7vw;
        font-size: 1.4rem;
        border-bottom: 2px solid transparent;
    }
    .nav-links li a:hover {
        border-bottom: 2px solid var(--color-secondary);
    }

    /*Styling Hamburger Icon*/
    .hamburger div {
        width: 30px;
        height: 3px;
        background: var(--color-secondary);
        margin: 5px;
        transition: all 0.3s ease;
    }
    .hamburger {
        display: none;
    }

    /*Stying for small screens*/
    @media screen and (max-width: 800px) {
        nav {
        z-index: 100;
        }
        .hamburger {
        display: block;
        position: absolute;
        cursor: pointer;
        right: 2.5vw;
        top: 50%;
        transform: translate(-5%, -50%);
        z-index: 2;
        transition: all 0.7s ease;
        }
        .nav-links {
        position: fixed;
        inset: 0;
        background: rgba(var(--color-tertiary), 0.9);
        height: 100vh;
        width: 100%;
        flex-direction: column;
        clip-path: circle(50px at 120% 0%);
        -webkit-clip-path: circle(50px at 120% 0%);
        transition: all 1s ease-out;
        pointer-events: none;
        }
        .nav-links.open {
        clip-path: circle(1000px at 90% 10%);
        -webkit-clip-path: circle(1000px at 90% 10%);
        pointer-events: all;
        }
        .nav-links li a {
        font-size: 1.8rem;
        }
        .nav-links li {
        opacity: 0;
        }
        .nav-links li:nth-child(1) {
        transition: all 0.5s ease 0.2s;
        }
        .nav-links li:nth-child(2) {
        transition: all 0.5s ease 0.4s;
        }
        .nav-links li:nth-child(3) {
        transition: all 0.5s ease 0.6s;
        }
        .nav-links li:nth-child(4) {
        transition: all 0.5s ease 0.7s;
        }
        .nav-links li:nth-child(5) {
        transition: all 0.5s ease 0.8s;
        }
        .nav-links li:nth-child(6) {
        transition: all 0.5s ease 0.9s;
        margin: 0;
        }
        .nav-links li:nth-child(7) {
        transition: all 0.5s ease 1s;
        margin: 0;
        }
        li.fade {
        opacity: 1;
        }
    }
    @media only screen and (max-width: 500px) {
        .nav-links li a {
        font-size: 2.4rem;
        }
    }

    /*Animating Hamburger Icon on Click*/
    .toggle .line1 {
        transform: rotate(-45deg) translate(-5px, 6px);
    }
    .toggle .line2 {
        transition: all 0.7s ease;
        width: 0;
    }
    .toggle .line3 {
        transform: rotate(45deg) translate(-5px, -6px);
    }
`;

  const ukHeaderHTML = `
    <nav>
      <div class="logo">
        <a href="/">
          <h3>IPTVUK.VIP</h3>
          <img
            src="/templates/kohost-professional/customfiles/assets-canada/iptv-uk-logo.webp"
            alt="IPTV UK"
            class="site-logo"
          />
        </a>
      </div>

      <div class="hamburger">
        <div class="line1"></div>
        <div class="line2"></div>
        <div class="line3"></div>
      </div>

      <ul class="nav-links">
	    <li><a href="https://iptvuk.vip/index.php?rp=/store/english-countries-tv-adult&currency=4">IPTV UK Plans</a></li>
        <li><a href="https://iptvuk.vip/index.php?rp=/store/iptv-box&currency=4">Android IPTV Box</a></li>
        <li><a href="https://iptvuk.vip/iptv-reseller.php&currency=3">IPTV Reseller</a></li>
        <li><a href="https://iptvuk.vip/articles.html">Articles</a></li>
        <li><a href="#FAQs">FAQs</a></li>
		<li><a href="/index.php?rp=/login">My Account</a></li>
      </ul>
    </nav>
`;

  const canadaHeaderHTML = `
    <nav>
      <div class="logo">
        <a href="/">
          <h3>IPTVCanada.VIP</h3>
          <img
            src="/templates/kohost-professional/customfiles/assets-canada/iptv-canada-logo.webp"
            alt="IPTV Canada"
            class="site-logo"
          />
        </a>
      </div>

      <div class="hamburger">
        <div class="line1"></div>
        <div class="line2"></div>
        <div class="line3"></div>
      </div>

      <ul class="nav-links">
	    <li><a href="https://iptvcanada.vip/index.php?rp=/store/canada-premium-tv-no-adult&currency=3">IPTV Canada Plans</a></li>
        <li><a href="https://iptvcanada.vip/index.php?rp=/store/iptv-box&currency=3">Android IPTV Box</a></li>
        <li><a href="https://iptvcanada.vip/iptv-reseller.php&currency=3">IPTV Reseller</a></li>
        <li><a href="https://iptvcanada.vip/articles.html">Articles</a></li>
        <li><a href="#FAQs">FAQs</a></li>
		<li><a href="/index.php?rp=/login">My Account</a></li>
      </ul>
    </nav>
`;

  const quebecHeaderHTML = `
    <nav>
      <div class="logo">
        <a href="/">
          
          <img
            src="/templates/kohost-professional/customfiles/assets-canada/quebecflag2.webp"
            alt="Meilleur IPTV Quebec"
            class="site-logo"

          /> <h3>IPTVQuebec.VIP</h3>
        </a>
      </div>

      <div class="hamburger">
        <div class="line1"></div>
        <div class="line2"></div>
        <div class="line3"></div>
      </div>

      <ul class="nav-links">
	    <li><a href="https://iptvquebec.vip/index.php?rp=/store/canada-premium-tv-no-adult&currency=3">IPTV Quebec Plans</a></li>
        <li><a href="https://iptvquebec.vip/index.php?rp=/store/iptv-box&currency=3">Android IPTV Box</a></li>
        <li><a href="https://iptvquebec.vip/iptv-reseller.php&currency=3">IPTV Reseller</a></li>
        <li><a href="https://iptvquebec.vip/articles.html">Articles</a></li>
        <li><a href="#FAQs">FAQs</a></li>
		<li><a href="/index.php?rp=/login">My Account</a></li>
      </ul>
    </nav>
`;

  const choiceHeaderHTML = `
    <nav>
        <div class="logo">
            <a href="#">
                <h3>IPTVCanada.VIP</h3>
                <img
                    src="/templates/kohost-professional/customfiles/assets-canada/iptv-canada-logo.webp"
                    alt="Logo Image"
                    class="site-logo"
                />
            </a>
        </div>

        <div class="hamburger">
            <div class="line1"></div>
            <div class="line2"></div>
            <div class="line3"></div>
        </div>

      <ul class="nav-links">
	    <li><a href="https://iptvcanada.vip/index.php?rp=/store/canada-premium-tv-no-adult">IPTV Plans</a></li>
        <li><a href="https://iptvcanada.vip/index.php?rp=/store/iptv-box">Android IPTV Box</a></li>
        <li><a href="https://iptvcanada.vip/iptv-reseller.php">IPTV Reseller</a></li>
        <li><a href="https://iptvcanada.vip/articles.html">Articles</a></li>
        <li><a href="#FAQs">FAQs</a></li>
		<li><a href="/index.php?rp=/login">My Account</a></li>
      </ul>
`;

  // INSERT CSS
  let headerStyle = document.createElement("style");
  headerStyle.innerHTML = headerCSS;
  document.head.appendChild(headerStyle);

  const DOMAINS_HEADER = {
    "iptvuk.vip": ukHeaderHTML,

    "iptvcanada.vip": canadaHeaderHTML,

    "iptvquebec.vip": quebecHeaderHTML,

    "choiceiptv.net": choiceHeaderHTML,
  };

  let defaultHeader = DOMAINS_HEADER["iptvcanada.vip"];
  let activeHeader = DOMAINS_HEADER[window.location.host] || defaultHeader;

  // INSERT HTML
  document.body.insertAdjacentHTML("afterbegin", activeHeader);

  // INSERT JS
  setTimeout(() => {
    const hamburger = document.querySelector(".hamburger");
    const navLinks = document.querySelector(".nav-links");
    const links = document.querySelectorAll(".nav-links li");

    hamburger.addEventListener("click", () => {
      //Animate Links
      let menuOpened = navLinks.classList.toggle("open");

      if (menuOpened) document.body.style.overflowY = "hidden";
      else document.body.style.overflowY = "auto";

      links.forEach((link) => {
        link.classList.toggle("fade");
      });

      //Hamburger Animation
      hamburger.classList.toggle("toggle");
    });
  }, 0);

  const DOMAINS_ICON = {
    "iptvuk.vip": "/templates/kohost-professional/customfiles/assets-canada/iptv-uk-favicon.ico",

    "iptvcanada.vip": "/templates/kohost-professional/customfiles/assets-canada/iptvcanada.ico",

    "iptvquebec.vip":
      "/templates/kohost-professional/customfiles/assets-canada/iptv-quebec-favicon.ico",

    "choiceiptv.net": "/templates/kohost-professional/customfiles/assets-canada/iptvchoice.ico",
  };

  var linkElement = document.createElement("link");

  // Set the attributes
  linkElement.rel = "icon";
  linkElement.type = "image/x-icon";
  linkElement.href = DOMAINS_ICON[window.location.host] || DOMAINS_ICON["iptvquebec.vip"];

  // Append the link element to the head of the document
  document.head.appendChild(linkElement);
})();
