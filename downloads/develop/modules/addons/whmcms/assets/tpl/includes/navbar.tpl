<li{if in_array($action, ["listpages", "updatepage", "addpage"])} class="active"{/if}><a href="{$modurl}&action=listpages">{WHMCMS::__("dashboardPages")}</a></li>
<li{if in_array($action, ["menu", "listmenu", "addmenu", "updatemenu", "addmenudivider", "updatemenudivider"])} class="active"{/if}><a href="{$modurl}&action=menu">{WHMCMS::__("dashboardMenuManager")}</a></li>
<li{if in_array($action, ["faq", "listfaq", "addfaq", "updatefaq"])} class="active"{/if}><a href="{$modurl}&action=faq">{WHMCMS::__("dashboardFaqManager")}</a></li>
<li{if in_array($action, ["errorpages", "updateerrorpage", "logerrors"])} class="active"{/if}><a href="{$modurl}&action=errorpages">{WHMCMS::__("dashboardErrorPages")}</a></li>
<li{if in_array($action, ["portfolio", "listprojects", "addproject", "updateproject"])} class="active"{/if}>
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{WHMCMS::__("dashboardPortfolio")} <span class="caret"></span></a>
    <ul class="dropdown-menu">
        <li{if in_array($action, ["listprojects"])} class="active"{/if}><a href="{$modurl}&action=listprojects">{WHMCMS::__("dashboardPortfolioProjects")}</a></li>
        <li{if in_array($action, ["portfolio"])} class="active"{/if}><a href="{$modurl}&action=portfolio">{WHMCMS::__("dashboardPortfolioCategories")}</a></li>
    </ul>
</li>
<li{if in_array($action, ["customize"])} class="active"{/if}>
    <a href="{$modurl}&action=customize" title="{WHMCMS::__("dashboardCustomize")}"><i class="fa fa-code"></i></a>
</li>
<li{if in_array($action, ["settings"])} class="active"{/if}>
    <a href="{$modurl}&action=settings" title="{WHMCMS::__("dashboardSettings")}"><i class="fa fa-cog fa-gear"></i></a>
</li>
<li{if in_array($action, ["support", "updates"])} class="active"{/if}>
    <a href="{$modurl}&action=support" title="{WHMCMS::__("dashboardSupport")}"><i class="fa fa-question-circle"></i></a>
</li>