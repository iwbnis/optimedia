<!-- Announcement Top Bar -->
<div class="iptv-announcement-bar">
    <div class="container">
        <div class="iptv-announce-inner">
            <div class="iptv-announce-left d-none d-md-flex">
                <a href="https://t.me/+Uhi6IVd8S27Iiile" target="_blank"><i class="bi bi-telegram"></i> Telegram</a>
                <a href="{$WEB_ROOT}/affiliates.php"><i class="bi bi-gift"></i> Earn as Affiliate</a>
                <a href="http://webtv.tel" target="_blank"><i class="bi bi-broadcast"></i> Watch Live TV</a>
            </div>
            <div class="iptv-announce-center">
                <i class="bi bi-lightning-charge-fill"></i>
                <span>Limited Time: Get <strong>12 Months</strong> for the price of 8!</span>
                <a href="{$WEB_ROOT}/order.php" class="iptv-announce-cta">Claim Deal <i class="bi bi-arrow-right"></i></a>
            </div>
        </div>
    </div>
</div>

<!-- Main Navigation -->
<nav class="iptv-navbar" id="iptvNavbar">
    <div class="container">
        <div class="iptv-nav-inner">
            <!-- Logo -->
            <a href="{if $hostx_theme_settings.header_logo_link neq ''}{$hostx_theme_settings.header_logo_link}{else}{$systemurl}{/if}" class="iptv-logo" {if $hostx_theme_settings.enable_header_target eq 'on'}target="_blank"{/if}>
                {if !empty($hostx_theme_settings.header_logo)}
                    <img src="{$hostx_theme_settings.header_logo}" alt="{$companyname}" {if $hostx_theme_settings.header_logo_height neq ''}height="{$hostx_theme_settings.header_logo_height}"{/if} {if $hostx_theme_settings.header_logo_width neq ''}width="{$hostx_theme_settings.header_logo_width}"{/if}>
                {else}
                    <img src="{$WEB_ROOT}/templates/{$template}/imagenew/whitelogo.png" alt="{$companyname}" height="38">
                {/if}
            </a>

            <!-- Desktop Navigation -->
            <ul class="iptv-nav-menu d-none d-lg-flex">
                <li>
                    <a href="{$WEB_ROOT}/order.php" class="iptv-nav-link">
                        <i class="bi bi-bag-plus"></i> Order Now
                    </a>
                </li>
                <li>
                    <a href="{$WEB_ROOT}/channel-list.php" class="iptv-nav-link">
                        <i class="bi bi-list-ul"></i> Channel List
                    </a>
                </li>
                <li class="iptv-nav-dropdown">
                    <a href="javascript:void(0)" class="iptv-nav-link">
                        Support <i class="bi bi-chevron-down"></i>
                    </a>
                    <div class="iptv-dropdown-simple">
                        <a href="{$WEB_ROOT}/submitticket.php" class="iptv-drop-item">
                            <i class="bi bi-envelope-plus"></i> Open Ticket
                        </a>
                        <a href="{$WEB_ROOT}/supporttickets.php" class="iptv-drop-item">
                            <i class="bi bi-ticket-detailed"></i> My Tickets
                        </a>
                        <div class="iptv-drop-divider"></div>
                        <a href="{$WEB_ROOT}/knowledgebase.php" class="iptv-drop-item">
                            <i class="bi bi-book"></i> Knowledge Base
                        </a>
                        <a href="{$WEB_ROOT}/announcements.php" class="iptv-drop-item">
                            <i class="bi bi-megaphone"></i> Announcements
                        </a>
                    </div>
                </li>
            </ul>

            <!-- Right Actions -->
            <div class="iptv-nav-actions">
                <!-- Theme Toggle -->
                <button class="iptv-nav-icon-btn mode-toggle d-none d-lg-flex" id="toggleModeBtn" aria-label="Toggle theme">
                    <i class="bi bi-moon-stars-fill"></i>
                </button>

                <!-- Cart -->
                <a href="{$WEB_ROOT}/cart.php?a=view" class="iptv-nav-icon-btn iptv-cart-btn">
                    <i class="bi bi-bag-fill"></i>
                    {if $cartitemcount > 0}<span class="iptv-cart-badge">{$cartitemcount}</span>{/if}
                </a>

                {if $languagechangeenabled && count($locales) > 1}
                <div class="iptv-nav-dropdown d-none d-lg-block">
                    <button class="iptv-nav-icon-btn" aria-label="Language">
                        <img src="{$WEB_ROOT}/templates/{$template}/images/blank.gif" class="flag flag-{$hxselectedlanguage.flagcode}" alt="{$hxselectedlanguage.localisedName}" />
                    </button>
                    <div class="iptv-dropdown-simple iptv-dropdown-right">
                        {foreach $hxlanguagesflags as $locale}
                            <a class="iptv-drop-item" href="{$currentpagelinkback}language={$locale.language}">
                                <img src="{$WEB_ROOT}/templates/{$template}/images/blank.gif" class="flag flag-{$locale.flagcode}" alt="{$locale.localisedName}" /> {$locale.localisedName}
                            </a>
                        {/foreach}
                    </div>
                </div>
                {/if}

                <!-- Account / Login -->
                <div class="iptv-nav-dropdown d-none d-lg-block">
                    {if $loggedin}
                        <button class="iptv-nav-account-btn">
                            <i class="bi bi-person-circle"></i> My Account <i class="bi bi-chevron-down"></i>
                        </button>
                        <div class="iptv-dropdown-simple iptv-dropdown-right">
                            {foreach $secondaryNavbar as $item}
                                {if $item->hasChildren()}
                                    {foreach $item->getChildren() as $childItem}
                                        {if $childItem->getClass() && in_array($childItem->getClass(), ['dropdown-divider', 'nav-divider'])}
                                            <div class="iptv-drop-divider"></div>
                                        {else}
                                            <a href="{$childItem->getUri()}" class="iptv-drop-item">
                                                {if $childItem->hasIcon()}<i class="{$childItem->getIcon()}"></i>{/if}
                                                {$childItem->getLabel()}
                                            </a>
                                        {/if}
                                    {/foreach}
                                {else}
                                    <a href="{$item->getUri()}" class="iptv-drop-item">
                                        {if $item->hasIcon()}<i class="{$item->getIcon()}"></i>{/if}
                                        {$item->getLabel()}
                                    </a>
                                {/if}
                            {/foreach}
                        </div>
                    {else}
                        <a href="{$WEB_ROOT}/login.php" class="iptv-nav-account-btn">
                            <i class="bi bi-person-circle"></i> Login
                        </a>
                    {/if}
                </div>

                <!-- CTA Button -->
                <a href="{$WEB_ROOT}/order.php" class="iptv-nav-cta d-none d-lg-inline-flex">
                    Get Started <i class="bi bi-arrow-right"></i>
                </a>

                <!-- Mobile: Theme Toggle -->
                <button class="iptv-nav-icon-btn mode-toggle d-flex d-lg-none" id="toggleModeBtnMobile" aria-label="Toggle theme">
                    <i class="bi bi-moon-stars-fill"></i>
                </button>

                <!-- Mobile Toggle -->
                <button class="iptv-mobile-toggle d-flex d-lg-none" id="iptvMobileToggle" aria-label="Menu">
                    <span class="iptv-hamburger">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div class="iptv-mobile-menu" id="iptvMobileMenu">
        <div class="iptv-mobile-menu-inner">
            <div class="iptv-mobile-nav-group">
                <a href="{$WEB_ROOT}/order.php" class="iptv-mobile-link"><i class="bi bi-bag-plus"></i> Order Now</a>
                <a href="{$WEB_ROOT}/channel-list.php" class="iptv-mobile-link"><i class="bi bi-list-ul"></i> Channel List</a>
            </div>
            <div class="iptv-mobile-nav-group">
                <h6 class="iptv-mobile-group-title">Support</h6>
                <a href="{$WEB_ROOT}/submitticket.php" class="iptv-mobile-link"><i class="bi bi-envelope-plus"></i> Open Ticket</a>
                <a href="{$WEB_ROOT}/knowledgebase.php" class="iptv-mobile-link"><i class="bi bi-book"></i> Knowledge Base</a>
            </div>
            <div class="iptv-mobile-nav-footer">
                {if $loggedin}
                    <a href="{$WEB_ROOT}/clientarea.php" class="btn-iptv-primary w-100 justify-content-center">
                        <i class="bi bi-person-circle"></i> My Account
                    </a>
                {else}
                    <a href="{$WEB_ROOT}/login.php" class="btn-iptv-outline w-100 justify-content-center mb-2">
                        <i class="bi bi-person-circle"></i> Login
                    </a>
                    <a href="{$WEB_ROOT}/order.php" class="btn-iptv-primary w-100 justify-content-center">
                        Get Started <i class="bi bi-arrow-right"></i>
                    </a>
                {/if}
            </div>
        </div>
    </div>
</nav>

<script>
// Sticky navbar on scroll
(function() {
    var navbar = document.getElementById('iptvNavbar');
    var announceBar = document.querySelector('.iptv-announcement-bar');
    if (!navbar) return;

    var lastScroll = 0;
    window.addEventListener('scroll', function() {
        var scrollY = window.scrollY || window.pageYOffset;

        if (scrollY > 80) {
            navbar.classList.add('iptv-navbar-sticky');
            if (announceBar) announceBar.classList.add('iptv-announce-hidden');
        } else {
            navbar.classList.remove('iptv-navbar-sticky');
            if (announceBar) announceBar.classList.remove('iptv-announce-hidden');
        }
        lastScroll = scrollY;
    });

    // Mobile menu toggle
    var toggle = document.getElementById('iptvMobileToggle');
    var mobileMenu = document.getElementById('iptvMobileMenu');
    if (toggle && mobileMenu) {
        toggle.addEventListener('click', function() {
            toggle.classList.toggle('active');
            mobileMenu.classList.toggle('open');
            document.body.classList.toggle('iptv-menu-open');
        });
    }
})();
</script>
