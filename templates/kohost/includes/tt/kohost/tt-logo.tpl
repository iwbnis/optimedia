{if !$tt_debug_mode}
    <a class="navbar-brand mr-3 mb-4" href="{$WEB_ROOT}/index.php">
        {if $assetLogoPath}
            <img src="{$assetLogoPath}" alt="{$companyname}" class="logo-img">
        {else}
            {$companyname}
        {/if}
    </a>
{else}
    <a href="{$WEB_ROOT}/index.php" class="navbar-brand mr-3 mb-4">
        <img src="{$WEB_ROOT}/templates/{$template}/includes/tt/kohost/img/logo-color.png" class="logo-img" alt="{$companyname}">
    </a>
{/if}
