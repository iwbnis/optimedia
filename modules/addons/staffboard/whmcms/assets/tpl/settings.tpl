<div class="row">
    <div class="col-lg-12">
        <form action="{$modurl}&action=updatesettings" method="post" class="validform">
            <ul class="nav nav-pills" id="tabOptions">
                <li class="active"><a href="#general">{WHMCMS::__("settingsTabGeneral")}</a></li>
                <li><a href="#friendlyurls">{WHMCMS::__("settingsTabFriendlyURLs")}</a></li>
                <li><a href="#portfolio">{WHMCMS::__("settingsTabPortfolio")}</a></li>
                <li><a href="#errorpages">{WHMCMS::__("settingsTabErrorPages")}</a></li>
                <li><a href="#meta">{WHMCMS::__("settingsTabMetaTags")}</a></li>
                <li><a href="#upload">{WHMCMS::__("settingsTabUpload")}</a></li>
                <li><a href="#menus">{WHMCMS::__("settingsTabMenu")}</a></li>
            </ul>
            <div class="clearline"></div>
            <div class="tab-content well">
                <div class="tab-pane active" id="general">
                    {$generalSettings}
                </div>
                <div class="tab-pane" id="friendlyurls">
                    <div class="row">
                        <div class="col-xs-6">
                            <div class="form-group">
                                <label for="FriendlyURLsMode">{WHMCMS::__("settingsFriendlyURLsModeLabel")}</label>
                                <select name="FriendlyURLsMode" id="FriendlyURLsMode" class="form-control">
                                    <option value="fully"{if WHMCMS::getConfig('FriendlyURLsMode') eq "fully"} selected{/if}>{WHMCMS::__("FriendlyURLsModeFully")}</option>
                                    <option value="friendly"{if WHMCMS::getConfig('FriendlyURLsMode') eq "friendly"} selected{/if}>{WHMCMS::__("FriendlyURLsModeFriendly")}</option>
                                    <option value="basic"{if WHMCMS::getConfig('FriendlyURLsMode') eq "basic"} selected{/if}>{WHMCMS::__("FriendlyURLsModeBasic")}</option>
                                </select>
                                <small class="text-mute">{WHMCMS::__("settingsFriendlyURLsModeDesc")}<br>{WHMCMS::__("settingsFriendlyURLsModeDesc_1")}<br>{WHMCMS::__("settingsFriendlyURLsModeDesc_2")}<br>{WHMCMS::__("settingsFriendlyURLsModeDesc_3")}</small>
                            </div>
                            <div class="form-group">
                                <label for="AutoApplyRewriteRules">{WHMCMS::__("settingsAutoApplyRewriteRules")}</label>
                                <select name="AutoApplyRewriteRules" id="AutoApplyRewriteRules" class="form-control">
                                    <option value="yes"{if WHMCMS::getConfig('AutoApplyRewriteRules') eq "yes"} selected{/if}>{WHMCMS::__("settingsAutoApplyRewriteRulesYes")}</option>
                                    <option value="no"{if WHMCMS::getConfig('AutoApplyRewriteRules') eq "no"} selected{/if}>{WHMCMS::__("settingsAutoApplyRewriteRulesNo")}</option>
                                </select>
                                <small class="text-mute">{WHMCMS::__("settingsAutoApplyRewriteRulesDescription")}</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="portfolio">
                    {$portfolioSettings}
                </div>
                <div class="tab-pane" id="errorpages">
                    {$errorpagesSettings}
                </div>
                <div class="tab-pane" id="meta">
                    {$metaSettings}
                </div>
                <div class="tab-pane" id="upload">
                    <div class="row">
                        <div class="col-xs-6">
                            <div class="form-group">
                                <label for="UploadEnableCache">{WHMCMS::__("settingsCacheEnableLabel")}</label>
                                <select name="UploadEnableCache" id="UploadEnableCache" class="form-control">
                                    <option value="yes"{if WHMCMS::getConfig('UploadEnableCache') eq "yes"} selected{/if}>{WHMCMS::__("settingsCacheEnableYes")}</option>
                                    <option value="no"{if WHMCMS::getConfig('UploadEnableCache') eq "no"} selected{/if}>{WHMCMS::__("settingsCacheEnableNo")}</option>
                                </select>
                                <small class="text-mute">{WHMCMS::__("settingsCacheEnableDesc")}</small>
                            </div>
                            <div class="form-group">
                                <label for="UploadCachePeriod">{WHMCMS::__("settingsCachePeriodLabel")}</label>
                                <input type="number" name="UploadCachePeriod" id="UploadCachePeriod" value="{WHMCMS::getConfig('UploadCachePeriod')}" min="0" step="1" class="form-control">
                                <small class="text-mute">{WHMCMS::__("settingsCachePeriodDesc")}</small>
                            </div>
                            <div class="form-group">
                                <label for="UploadDirectory">{WHMCMS::__("settingsUploadDirLabel")}</label>
                                <select name="UploadDirectory" id="UploadDirectory" class="form-control">
                                    <option value="attachments"{if WHMCMS::getConfig('UploadDirectory') eq "attachments"} selected{/if}>{WHMCMS::__("settingsUploadDirAttachments")}</option>
                                    <option value="custom"{if WHMCMS::getConfig('UploadDirectory') eq "custom"} selected{/if}>{WHMCMS::__("settingsUploadDirCustomDir")}</option>
                                </select>
                                <small class="text-mute">{WHMCMS::__("settingsUploadDirDesc")}</small>
                            </div>
                            <div class="form-group">
                                <label for="UploadCustomDirectory">{WHMCMS::__("settingsCustomUploadDirLabel")}</label>
                                <input type="text" name="UploadCustomDirectory" id="UploadCustomDirectory" value="{WHMCMS::getConfig('UploadCustomDirectory')}" class="form-control">
                                <small class="text-mute">{WHMCMS::__("settingsCustomUploadDirDesc")}</small>
                            </div>
                            <div class="form-group">
                                <label for="UploadResizeWidth">{WHMCMS::__("settingsDefaultResizeWidthLabel")}</label>
                                <input type="number" name="UploadResizeWidth" id="UploadResizeWidth" value="{WHMCMS::getConfig('UploadResizeWidth')}" min="0" step="1" class="form-control">
                                <small class="text-mute">{WHMCMS::__("settingsDefaultResizeWidthDesc")}</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="menus">
                    <div class="row">
                        <div class="col-xs-6">
                            <div class="form-group">
                                <label for="PrimaryNavbarCategoryid">{WHMCMS::__("settingsPrimaryNavbarLabel")}</label>
                                <select name="PrimaryNavbarCategoryid" id="PrimaryNavbarCategoryid" class="form-control">
                                    <option value="0"{if WHMCMS::getConfig('PrimaryNavbarCategoryid') eq 0} selected{/if}>{WHMCMS::__("settingsPrimaryNavbarSelectCategory")}</option>
                                    {foreach item=category from=$menuCategories}
                                    <option value="{$category.categoryid}"{if WHMCMS::getConfig('PrimaryNavbarCategoryid') eq $category.categoryid} selected{/if}>{$category.title}</option>
                                    {/foreach}
                                </select>
                                <small class="text-mute">{WHMCMS::__("settingsPrimaryNavbarDesc")}</small>
                            </div>
                            <div class="form-group">
                                <label for="SecondaryNavbarCategoryid">{WHMCMS::__("settingsSecondaryNavbarLabel")}</label>
                                <select name="SecondaryNavbarCategoryid" id="SecondaryNavbarCategoryid" class="form-control">
                                    <option value="0"{if WHMCMS::getConfig('SecondaryNavbarCategoryid') eq 0} selected{/if}>{WHMCMS::__("settingsSecondaryNavbarSelectCategory")}</option>
                                    {foreach item=category from=$menuCategories}
                                    <option value="{$category.categoryid}"{if WHMCMS::getConfig('SecondaryNavbarCategoryid') eq $category.categoryid} selected{/if}>{$category.title}</option>
                                    {/foreach}
                                </select>
                                <small class="text-mute">{WHMCMS::__("settingsSecondaryNavbarDesc")}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
	    <div class="clearline"></div>
            <div>
                <button type="submit" class="btn btn-sm btn-info span2">{WHMCMS::__("settingSaveButton")}</button>
                <div class="clear"></div>
            </div>
        </form>
    </div>
</div>
