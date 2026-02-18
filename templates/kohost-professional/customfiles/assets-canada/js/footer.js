(() => {
  const footerCSS = `
    .footer {
      font-size: 1.5rem;
      display: flex;
      flex-flow: row wrap;
      gap: 2rem;
      padding: 30px 30px 20px 30px;
      color: var(--color-secondary);
      background-color: var(--color-primary);
      border-top: 1px solid var(--color-tertiary-2);
    }
    
    .footer > * {
      flex: 1 100%;
    }
    
    .footer__logo {
      font-weight: 400;
      text-transform: lowercase;
      font-size: 1.5rem;
      width: 8rem;
    }
    
    .footer__addr h2 {
      margin-top: 1.3em;
      font-size: 15px;
      font-weight: 400;
    }
    
    .nav__title {
      font-weight: 400;
      font-size: 15px;
    }
    
    .footer address {
      font-style: normal;
    }
    
    .footer ul {
      list-style: none;
      padding-left: 0;
    }
    
    .footer li {
      line-height: 2em;
    }
    
    .footer a {
      text-decoration: none;
    }
    
    .footer__nav {
      display: flex;
      flex-flow: row wrap;
      gap: 4rem;
    }
    
    .footer__nav > * {
      flex: 1 50%;
    }
    
    .nav__ul--extra {
      column-count: 2;
      column-gap: 1.25em;
    }
    
    .legal__links {
      display: flex;
      align-items: center;
    }
    
    @media screen and (min-width: 24.375em) {
      .legal .legal__links {
        margin-left: auto;
      }
    }
    
    @media screen and (min-width: 40.375em) {
      .footer__nav > * {
        flex: 1;
      }
    
      .nav__item--extra {
        flex-grow: 2;
      }
    
      .footer__addr {
        flex: 1 0px;
      }
    
      .footer__nav {
        flex: 2 0px;
      }
    }
  `;

  const canadaFooterHTML = `
 <footer class="footer">
      <div class="footer__addr">
        <h1 class="logo">
          <a href="/">
            <h3>IPTVCanada.VIP</h3>
            <img
              src="/templates/kohost-professional/customfiles/assets-canada/Maple_Leaf.svg.webp"
              alt="IPTV in Canada"
            />
          </a>
        </h1>


        <p>Your Premier Source for Premium </br>IPTV Services in Canada.</p>
      </div>

      <ul class="footer__nav">
        <li class="nav__item">
		<h2 class="nav__title"><strong>Plans</strong></h2>

          <ul class="nav__ul">
            <li>
              <a href="/index.php?rp=/store/choice-no-adult-packages&currency=3">Canada IPTV Plans without Adult</a>
            </li>
            <li>
              <a href="/index.php?rp=/store/choice-adult-packages&currency=3">Canada IPTV Plans witht Adult</a>
            </li>
            <li>
              <a href="/index.php?rp=/store/iptv-box">Android IPTV Box & Player</a>
            </li>

          </ul>
        </li>

        <li class="nav__item nav__item--extra">
          <h2 class="nav__title"><strong>Resources</strong></h2>

          <ul class="nav__ul nav__ul--extra">
			<li>
              <a href="/about-us.php">About us</a>
            </li>
		     <li>
              <a href="/contact.php">Contact us</a>
            </li>
			 
			 <li>
              <a href="https://t.me/+Uhi6IVd8S27Iiile" target="_blank">Telegram Group</a>
            </li>

            <li>
              <a href="/index.php/download">App Downloads</a>
            </li>

            <li>
              <a href="/supporttickets.php">My Tickets</a>
            </li>

            <li>
              <a href="/index.php/channel-list.php">Channel List</a>
            </li>
			<li>
              <a href="/affiliates-program.php">Affiliates Program</a>
            </li>
          </ul>
        </li>

        <li class="nav__item">
          <h2 class="nav__title"><strong>Legal</strong></h2>

          <ul class="nav__ul">
            <li>
              <a href="/privacy-policy">Privacy Policy</a>
            </li>

            <li>
              <a href="/terms-and-conditions">Terms & Conditions</a>
            </li>

            <li>
              <a href="/refund-policy">Refund Policy</a>
            </li>
			<li>
              <a href="/dmca-policy">DMCA</a>
            </li>
		</ul>
        </li>
      </ul>

      <div class="text-center">
        <p>&copy; 2024 IPTVCanda.vip. All rights reserved.</p>
      </div>
    </footer>
  `;

  const ukFooterHTML = `
    <footer class="footer">
      <div class="footer__addr">
        <h1 class="logo">
          <a href="/">
            <h3>IPTVUK.VIP</h3>
            <img
              src="/templates/kohost-professional/customfiles/assets-canada/iptv-uk-logo.webp"
              alt="IPTV in UK"
            />
          </a>
        </h1>


        <p>Your Premier Source for Premium </br>IPTV Services in UK.</p>
      </div>

      <ul class="footer__nav">
        <li class="nav__item">
		<h2 class="nav__title"><strong>Plans</strong></h2>

          <ul class="nav__ul">
            <li>
              <a href="/index.php?rp=/store/english-countries-tv&currency=4">IPTV UK Plans without Adult</a>
            </li>
            <li>
              <a href="/index.php?rp=/store/store/english-countries-tv-adult&currency=4">IPTV UK Plans with Adult</a>
            </li>
            <li>
              <a href="/index.php?rp=/store/iptv-box&currency=4">Android IPTV Box & Player</a>
            </li>

          </ul>
        </li>

        <li class="nav__item nav__item--extra">
          <h2 class="nav__title"><strong>Resources</strong></h2>

          <ul class="nav__ul nav__ul--extra">
			<li>
              <a href="/about-us.php">About us</a>
            </li>
		     <li>
              <a href="/contact.php">Contact us</a>
            </li>
			 
			 <li>
              <a href="https://t.me/+Uhi6IVd8S27Iiile" target="_blank">Telegram Group</a>
            </li>

            <li>
              <a href="/index.php/download">App Downloads</a>
            </li>

            <li>
              <a href="/supporttickets.php">My Tickets</a>
            </li>

            <li>
              <a href="/index.php/channel-list.php">Channel List</a>
            </li>
			<li>
              <a href="/affiliates-program.php">Affiliates Program</a>
            </li>
          </ul>
        </li>

        <li class="nav__item">
          <h2 class="nav__title"><strong>Legal</strong></h2>

          <ul class="nav__ul">
            <li>
              <a href="/privacy-policy">Privacy Policy</a>
            </li>

            <li>
              <a href="/terms-and-conditions">Terms & Conditions</a>
            </li>

            <li>
              <a href="/refund-policy">Refund Policy</a>
            </li>
			<li>
              <a href="/dmca-policy">DMCA</a>
            </li>
		</ul>
        </li>
      </ul>

      <div class="text-center">
        <p>&copy; 2024 IPTVUK.vip. All rights reserved.</p>
      </div>
    </footer>
  `;

  const quebecFooterHTML = `
    <footer class="footer">
      <div class="footer__addr">
        <h1 class="logo">
          <a href="/">
            <img
              src="/templates/kohost-professional/customfiles/assets-canada/quebecflag2.webp"
              alt="IPTV in Quebec"
            />  <h3>IPTVQuebec.VIP</h3>
          </a>
        </h1>


        <p>Your Premier Source for Premium </br>IPTV Services in Quebec.</p>
      </div>

      <ul class="footer__nav">
        <li class="nav__item">
		<h2 class="nav__title"><strong>Plans</strong></h2>

          <ul class="nav__ul">
            <li>
              <a href="/index.php?rp=/store/choice-no-adult-packages&currency=3">IPTV Quebec Plans without Adult</a>
            </li>
            <li>
              <a href="/index.php?rp=/store/choice-adult-packages&currency=3">IPTV Quebec Plans with Adult</a>
            </li>
            <li>
              <a href="/index.php?rp=/store/iptv-box">Android IPTV Box & Player</a>
            </li>

          </ul>
        </li>

        <li class="nav__item nav__item--extra">
          <h2 class="nav__title"><strong>Resources</strong></h2>

          <ul class="nav__ul nav__ul--extra">
			<li>
              <a href="/about-us.php">About us</a>
            </li>
		     <li>
              <a href="/contact.php">Contact us</a>
            </li>
			 
			 <li>
              <a href="https://t.me/+Uhi6IVd8S27Iiile" target="_blank">Telegram Group</a>
            </li>

            <li>
              <a href="/index.php/download">App Downloads</a>
            </li>

            <li>
              <a href="/supporttickets.php">My Tickets</a>
            </li>

            <li>
              <a href="/index.php/channel-list.php">Channel List</a>
            </li>
			<li>
              <a href="/affiliates-program.php">Affiliates Program</a>
            </li>
          </ul>
        </li>

        <li class="nav__item">
          <h2 class="nav__title"><strong>Legal</strong></h2>

          <ul class="nav__ul">
            <li>
              <a href="/privacy-policy">Privacy Policy</a>
            </li>

            <li>
              <a href="/terms-and-conditions">Terms & Conditions</a>
            </li>

            <li>
              <a href="/refund-policy">Refund Policy</a>
            </li>
			<li>
              <a href="/dmca-policy">DMCA</a>
            </li>
		</ul>
        </li>
      </ul>

      <div class="text-center">
        <p>&copy; 2024 IPTVQuebec.vip. All rights reserved.</p>
      </div>
    </footer>
  `;

  const choiceFooterHTML = `
<footer class="footer">
    <div class="footer__addr">
        <h1 class="logo">
            <a href="#">
            <h3>IPTVCanada.VIP</h3>
            <img
                src="/templates/kohost-professional/customfiles/assets-canada/iptv-canada-logo.webp"
                alt="Choice IpTv Logo"
                class='site-logo'
            />
            </a>
        </h1>

        <h2>Contact</h2>

        <address>5534 Somewhere In. The World 22193-10212</address>
    </div>

    <ul class="footer__nav">
        <li class="nav__item">
            <h2 class="nav__title">Media</h2>

            <ul class="nav__ul">
            <li>
                <a href="#">Online</a>
            </li>

            <li>
                <a href="#">Print</a>
            </li>

            <li>
                <a href="#">Alternative Ads</a>
            </li>
            </ul>
        </li>

        <li class="nav__item">
            <h2 class="nav__title">Technology</h2>

            <ul class="nav__ul nav__ul--extra">
            <li>
                <a href="#">Hardware Design</a>
            </li>

            <li>
                <a href="#">Software Design</a>
            </li>

            <li>
                <a href="#">Digital Signage</a>
            </li>

            <li>
                <a href="#">Automation</a>
            </li>

            <li>
                <a href="#">Artificial Intelligence</a>
            </li>

            <li>
                <a href="#">IoT</a>
            </li>
            </ul>
        </li>

        <li class="nav__item">
            <h2 class="nav__title">Legal</h2>

            <ul class="nav__ul">
            <li>
                <a href="#">Privacy Policy</a>
            </li>

            <li>
                <a href="#">Terms of Use</a>
            </li>

            <li>
                <a href="#">Sitemap</a>
            </li>
            </ul>
        </li>
    </ul>

    <div class="text-center">
        <p>&copy; 2024 Choice IPTV. All rights reserved.</p>
    </div>
</footer>
  `;

  // INSERT CSS
  let footerStyle = document.createElement("style");
  footerStyle.innerHTML = footerCSS;
  document.head.appendChild(footerStyle);

  const DOMAINS_FOOTER = {
    "iptvuk.vip": ukFooterHTML,

    "iptvcanada.vip": canadaFooterHTML,

    "iptvquebec.vip": quebecFooterHTML,

    "choiceiptv.net": choiceFooterHTML,
  };

  let defaultFooter = DOMAINS_FOOTER["iptvcanada.vip"];
  let activeFooter = DOMAINS_FOOTER[window.location.host] || defaultFooter;

  document.body.insertAdjacentHTML("beforeend", activeFooter);
})();
