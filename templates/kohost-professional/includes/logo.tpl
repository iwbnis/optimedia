{if $logo|lower == "primary"}
    <a href="{$WEB_ROOT}/index.php" class="logo {$aClass}"><img src="{$WEB_ROOT}/templates/{$template}/img/logo-primary.png" class="img-responsive" alt="{$companyname}"></a>
{elseif $logo|lower == "secondary"}
    <a href="{$WEB_ROOT}/index.php" class="logo {$aClass}"><img src="{$WEB_ROOT}/templates/{$template}/img/logo-primary.png" class="img-responsive" alt="{$companyname}"></a>
{elseif $assetLogoPath}
    <a href="{$WEB_ROOT}/index.php" class="logo {$aClass}"><img src="{$assetLogoPath}" class="img-responsive" alt="{$companyname}"></a>
{else}
    <a href="{$WEB_ROOT}/index.php" class="logo logo-text {$aClass}">{$companyname}</a>
{/if}