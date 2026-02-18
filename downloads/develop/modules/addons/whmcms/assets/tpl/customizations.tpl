{* Adding FAQ HTML Form *}
<form action="{$modurl}&action=doupdatecustomize" method="post" class="validform formPage" enctype="multipart/form-data">
    <ul class="nav nav-pills" id="tabOptions">
        <li {if ($tab=='css' || $tab=='')}class="active"{/if}><a href="#css">{WHMCMS::__("customTabCss")}</a></li>
        <li {if ($tab=='js')}class="active"{/if}><a href="#js">{WHMCMS::__("customTabJS")}</a></li>
        <li {if ($tab=='htaccess')}class="active"{/if}><a href="#htaccess">{WHMCMS::__("customTabHtaccess")}</a></li>
    </ul>
    <div class="clearline"></div>
    <div class="tab-content">
        <div class="tab-pane {if ($tab=='css' || $tab=='')}active{/if}" id="css">
            <p class="custom-text">{WHMCMS::__("customTabCssDescription")}</p>
            {$cssForm}
            <div class="form-group">
                <button type="submit" class="btn btn-sm btn-info span2">{WHMCMS::__("customSaveButton")}</button>
            </div>
        </div>
        <div class="tab-pane {if ($tab=='js')}active{/if}" id="js">
            <p class="custom-text">{WHMCMS::__("customJSDescription")}</p>
			{$jsForm}
            <div class="form-group">
                <button type="submit" class="btn btn-sm btn-info span2">{WHMCMS::__("customSaveButton")}</button>
            </div>
        </div>
        <div class="tab-pane {if ($tab=='htaccess')}active{/if}" id="htaccess">
            <p class="custom-text">{WHMCMS::__("customHtaccessDescription")}</p>
			{$htaccessForm}
        </div>
    </div>
</form>