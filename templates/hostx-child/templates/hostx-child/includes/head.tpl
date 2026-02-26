{\WHMCS\View\Asset::fontCssInclude('open-sans-family.css')}
<link href="{assetPath file='all.min.css'}?v={$versionHash}" rel="stylesheet">
<link href="{assetPath file='theme.min.css'}?v={$versionHash}" rel="stylesheet">
<link href="{$WEB_ROOT}/assets/css/fontawesome-all.min.css" rel="stylesheet">
{assetExists file="owl.carousel.css"}
  <link href="{$__assetPath__}" rel="stylesheet">
{/assetExists}
{assetExists file="slick.css"}
  <link href="{$__assetPath__}" rel="stylesheet">
{/assetExists}
{assetExists file="hostx-header-area.css"}
  <link href="{$__assetPath__}?v={$versionHash}" rel="stylesheet">
{/assetExists}
{assetExists file="hostx.css"}
  <link href="{$__assetPath__}?v={$versionHash}" rel="stylesheet">
{/assetExists}
{if $whmcsDefaultPagesHostx eq 'true'}
  {assetExists file="hostx-client-area.css"}
    <link href="{$__assetPath__}?v={$versionHash}&t=20260226j" rel="stylesheet">
  {/assetExists}
{/if}
{if $isPageDedicated}
  <link href="{$BASE_PATH_CSS}/ion.rangeSlider.css" rel="stylesheet">
  <link href="{$BASE_PATH_CSS}/ion.rangeSlider.skinModern.css" rel="stylesheet">
{/if}
{assetExists file="hostx-responsive.css"}
  <link href="{$__assetPath__}?v={$versionHash}" rel="stylesheet">
{/assetExists}
{if $whmcsDefaultPagesHostx eq 'true'}
  {assetExists file="hostx-client-area-responsive.css"}
    <link href="{$__assetPath__}?v={$versionHash}&t=20260226j" rel="stylesheet">
  {/assetExists}
{/if}
<script>
    var csrfToken = '{$token}',
        markdownGuide = '{lang|addslashes key="markdown.title"}',
        locale = '{if !empty($mdeLocale)}{$mdeLocale}{else}en{/if}',
        saved = '{lang|addslashes key="markdown.saved"}',
        saving = '{lang|addslashes key="markdown.saving"}',
        whmcsBaseUrl = "{\WHMCS\Utility\Environment\WebHelper::getBaseUrl()}",
        hostxCurrentmenustyle = "{$hostx_theme_settings.menu_layout}",
        hostxHeaderSticky = "{$hostx_theme_settings.enable_sticky_header}",
        hostxHeaderMenuOpenEvent = "{$hostx_theme_settings.dropdown_event}",
        hostxPriceV2TldSetting = "{$hostx_theme_settings.disable_tld_dropdown_block}",
        hostxVpsPricingSlideSetting = "{$hostx_theme_settings.slide_setting}",
        hostxProductListSlideSetting = "{$hostx_theme_settings.productlist_slide_setting}",
        hostxTemplateActivePath ="{$WEB_ROOT}/templates/{$template}/",
        hostxImageLayoutMarketConnectPath ="{$WEB_ROOT}/templates/{$template}/marketconnect/",
        hostxLayoutActiveFolderName = "{$layoutStyle}",
        whmcsDefaultPagesActive ="{if $whmcsDefaultPagesHostx eq 'true'}on{else}off{/if}",
        rtlHostx = false;
        {if $captcha && method_exists($captcha, 'getPageJs')}{$captcha->getPageJs()}{/if}
</script>
{if $LANG.locale == 'ar_AR' || $LANG.locale == 'fa_IR' || $LANG.locale == 'he_IL'}
  {assetExists file="style-rtl.css"}
    <link href="{$__assetPath__}" rel="stylesheet">
  {/assetExists}
  <script>
    var rtlHostx = true;
  </script>
{/if}
{if $hostx_color_layout neq '' && $hostx_color_layout neq 'hostx-child-red-mode'}
  {if $layoutStyle eq 'layouttwo'}
    {assetExists file="hostx-color-scheme-layout-two.css"}
      <link href="{$__assetPath__}" rel="stylesheet">
    {/assetExists}
  {elseif $layoutStyle eq 'layoutthree'}
    {assetExists file="hostx-color-scheme-layout-three.css"}
      <link href="{$__assetPath__}" rel="stylesheet">
    {/assetExists}
  {elseif $layoutStyle eq 'layoutfour'}
    {assetExists file="hostx-color-scheme-layout-four.css"}
      <link href="{$__assetPath__}" rel="stylesheet">
    {/assetExists}
  {elseif $layoutStyle eq 'layoutfive'}
    {assetExists file="hostx-color-scheme-layout-five.css"}
      <link href="{$__assetPath__}" rel="stylesheet">
    {/assetExists}
  {elseif $layoutStyle eq 'layoutsix'}
    {assetExists file="hostx-color-scheme-layout-six.css"}
      <link href="{$__assetPath__}" rel="stylesheet">
    {/assetExists}
  {/if}
{/if}
{if $hostx_theme_settings.enable_colors_front_end eq 'on'}
  {$colorDataCustom}
{/if}
{assetExists file="override.css"}
  <link href="{$__assetPath__}?v={$versionHash}&t=20260226j" rel="stylesheet">
{/assetExists}
<script src="{assetPath file='scripts.min.js'}?v={$versionHash}"></script>
{if $templatefile == "viewticket" && !$loggedin}
  <meta name="robots" content="noindex" />
{/if}
