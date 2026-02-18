<div class="mg-wrapper body" data-target=".body" data-spy="scroll" data-twttr-rendered="true">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600&subset=all" rel="stylesheet" type="text/css"/> 
    <link rel="stylesheet" type="text/css" href="{$assetsURL}/css/font-awesome.css" />
    <link rel="stylesheet" type="text/css" href="{$assetsURL}/css/simple-line-icons.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{$assetsURL}/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{$assetsURL}/css/uniform.default.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{$assetsURL}/css/components-rounded.css" rel="stylesheet">

    {if !$isWHMCS72}
        <link rel="stylesheet" type="text/css" href="{$assetsURL}/css/jquery.dataTables.css" />
    {/if}

    <link rel="stylesheet" type="text/css" href="{$assetsURL}/css/select2.css" />
    <link rel="stylesheet" type="text/css" href="{$assetsURL}/css/onoffswitch.css" />
    <link rel="stylesheet" type="text/css" href="{$assetsURL}/css/jquery-ui.min.css" />
    <link rel="stylesheet" type="text/css" href="{$assetsURL}/css/bootstrap-datetimepicker.min.css" />

    <link rel="stylesheet" type="text/css" href="{$assetsURL}/css/mg-style.css" rel="stylesheet">    
    <link rel="stylesheet" type="text/css" href="{$assetsURL}/css/icheck/minimal.css" rel="stylesheet">   
    <script type="text/javascript" src="{$assetsURL}/js/mgLibs.js"></script>
    {if !$isWHMCS6}
        <script type="text/javascript" src="{$assetsURL}/js/bootstrap.js"></script>
    {/if}
    <script type="text/javascript" src="{$assetsURL}/js/jquery.dataTables.js"></script>
    <script type="text/javascript" src="{$assetsURL}/js/dataTables.bootstrap.js"></script>
    <script type="text/javascript" src="{$assetsURL}/js/select2.min.js"></script>
    <script type="text/javascript" src="{$assetsURL}/js/bootstrap-hover-dropdown.min.js"></script>
    <script type="text/javascript" src="{$assetsURL}/js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="{$assetsURL}/js/moment.js"></script>
    <script type="text/javascript" src="{$assetsURL}/js/bootstrap-datetimepicker.min.js"></script>
    {if $isWHMCS76}
        <script type="text/javascript" src="{$assetsURL}/js/tiny_mce/tiny_mce.js"></script>
        <script type="text/javascript" src="{$assetsURL}/js/tiny_mce/jquery.tinymce.js"></script>
    {else}
        <script type="text/javascript" src="../assets/js/tiny_mce/jquery.tinymce.js"></script>
    {/if}
    <script src="{$assetsURL}/js/validator.js" type="text/javascript"></script>
    <script type="text/javascript" src="{$assetsURL}/js/popup-form.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.2.3/ace.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript" src="{$assetsURL}/js/icheck.js"></script>
    <script type="text/javascript">
        JSONParser.create('{$JSONCurrentUrl}');{literal}
        jQuery(document).ready(function () {
            $("input[data-datepicker]").datepicker({
                dateFormat: 'yy-mm-dd'
            });
                //used to change positioning inside of module navbar
                var handleNavigationCollapseOnResize = function() {
                    var navbar_in_two_lines    = false;                     
                    var navbarOnlyIcons         = false;                
                    var moduleLogoSmall         = false;
                    var hideModuleLogo          = false;

                    
                    var navbar_max_menu_width = jQuery('.nav-menu:not(.nav-menu-right)').width();
                    var navbar_logo_width = jQuery('.logo-default').width();
                    var navbar_logo_cog_width = jQuery('.logo-default-cog').width();
                    var navbar_title_width = jQuery('.modulename > a').width() + 36;
                    
                    function NavigationSet() {
                        var navbar_height = jQuery('.page-header').height();
                        var navbar_width = jQuery('.page-header').width();
                        var navbar_menu_width = jQuery('.nav-menu:not(.nav-menu-right)').width();
                        var navbar_logo = jQuery('.modulename-logo').width();
                        
                        
                        var buffor = 60;
                        
                        if (navbar_width <= (navbar_max_menu_width + navbar_logo + navbar_title_width + buffor) && !navbar_in_two_lines) {
                            navbar_in_two_lines = true;
                            jQuery('.page-container').addClass('centered');
                        }
                        else if (navbar_width > (navbar_max_menu_width + navbar_logo + navbar_title_width + buffor) && navbar_in_two_lines) {
                            navbar_in_two_lines=false; 
                            jQuery('.page-container').removeClass('centered');
                        }

                        if(navbar_width         <= (navbar_max_menu_width + navbar_logo_width + buffor) && !moduleLogoSmall) {
                            moduleLogoSmall = true;
                            $('.logo-default-cog').css('display','inline-block');
                            $('.logo-default').css('display','none');
                        } else if(navbar_width   > (navbar_max_menu_width + navbar_logo_width + buffor) && moduleLogoSmall) {
                            moduleLogoSmall = false;
                            $('.logo-default').css('display','inline-block');
                            $('.logo-default-cog').css('display','none');
                        }

                        if(navbar_width         <= (navbar_max_menu_width + navbar_logo_cog_width + buffor) && !navbarOnlyIcons) {
                            navbarOnlyIcons = true;
                            jQuery('.navbar-nav').addClass('short');
                        } else if(navbar_width   > (navbar_max_menu_width + navbar_logo_cog_width + buffor) && navbarOnlyIcons) {
                            navbarOnlyIcons = false;
                            jQuery('.navbar-nav').removeClass('short');
                        }


                        if(navbar_width <= (navbar_menu_width + navbar_logo_cog_width + buffor) && !hideModuleLogo ){
                            hideModuleLogo = true;
                            jQuery('.modulename-logo').hide();
                        } else  if(navbar_width > (navbar_menu_width + navbar_logo_cog_width + buffor) && hideModuleLogo){
                            hideModuleLogo = false;
                            jQuery('.modulename-logo').show();
                        }
                      }

                      $(document).ready(NavigationSet);
                      $(window).resize(NavigationSet);
                }
                handleNavigationCollapseOnResize();
                
                jQuery('.close-mg-alert').on('click',function(event){
                    jQuery(event.target).parent().parent().remove();
                });
        });

        {/literal}
        </script>

        <div class="full-screen-module-container">
            <div class="page-header">  
                <div class="top-menu">
                    <div class="page-container">
                        <div class="modulename">
                            <a href="{$mainURL}">{$mainName}</a>
                        </div>
                        <div class="line-separator"></div>
                        <div class="nav-menu">
                            <ul class="nav navbar-nav">
                                {foreach from=$menu key=catName item=category}
                                    {if $category.submenu}
                                        <li class="menu-dropdown">
                                            {if $category.disableLink}
                                                <a href="#"  data-hover="dropdown" data-close-others="true">
                                                    {if $category.icon}<i class="{$category.icon}"></i>{/if}
                                                    {if $category.label}
                                                        {$subpage.label} 
                                                    {else}
                                                        <span class="mg-pages-label">{$MGLANG->T('pagesLabels','label' , $catName)}</span>
                                                    {/if}
                                                    <i class="fa fa-angle-down dropdown-angle"></i>
                                                </a>
                                            {else}   
                                                <a href="{$category.url}" data-hover="dropdown" data-close-others="true">
                                                    {if $category.icon}<i class="{$category.icon}"></i>{/if}
                                                    {if $category.label}
                                                        {$subpage.label}
                                                    {else}
                                                        <span class="mg-pages-label">{$MGLANG->T('pagesLabels','label', $catName)}</span>
                                                    {/if}
                                                    <i class="fa fa-angle-down dropdown-angle"></i>
                                                </a>
                                            {/if}
                                            <ul class="dropdown-menu pull-left">
                                                {foreach from=$category.submenu key=subCatName item=subCategory}
                                                    <li>
                                                        {if $subCategory.externalUrl}
                                                            <a href="{$subCategory.externalUrl}" target="_blank">
                                                                {if $subCategory.icon}<i class="{$subCategory.icon}"></i>{/if} 
                                                                {if $subCategory.label}
                                                                    {$subCategory.label}
                                                                {else}
                                                                    {$MGLANG->T('pagesLabels',$catName,$subCatName)}
                                                                {/if}
                                                            </a>
                                                        {else}
                                                            <a href="{$subCategory.url}">
                                                                {if $subCategory.icon}<i class="{$subCategory.icon}"></i>{/if} 
                                                                {if $subCategory.label}
                                                                    {$subCategory.label}
                                                                {else}
                                                                    {$MGLANG->T('pagesLabels',$catName,$subCatName)}
                                                                {/if}
                                                            </a>
                                                        {/if}
                                                    </li>
                                                {/foreach}
                                            </ul>
                                        </li>
                                    {else}
                                        <li>
                                            <a href="{if $category.externalUrl}{$category.externalUrl}{else}{$category.url}{/if}" {if $category.externalUrl}target="_blank"{/if}>
                                                {if $category.icon}<i class="{$category.icon}"></i>{/if} 
                                                {if $category.label}
                                                    <span>{$subpage.label}</span>
                                                {else}
                                                    <span>{$MGLANG->T('pagesLabels', 'label', $catName)}</span>
                                                {/if}
                                            </a>
                                        </li>
                                    {/if}
                                {/foreach}{*
                                <li class="droddown dropdown-separator">
                                <span class="separator"></span>
                                </li>
                                <li><a href="#" class="full-screen-module-toogle"><i class="icon-size-fullscreen"></i>&nbsp;</a></li> *}
                            </ul>
                        </div>

                        <div class="modulename-logo">
                            <a href="http://www.modulesgarden.com" style="display: inline-block;" target="_blank"><img src="{$assetsURL}/img/mg-logo.png" alt="logo" class="logo-default"></a>
                            <a href="http://www.modulesgarden.com" style="display: inline-block;" target="_blank"><img src="{$assetsURL}/img/mg-logo-cog.png" alt="logo" class="logo-default-cog"></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>              
            <div class="page-container">
                <div class="row-fluid" id="MGAlerts">
                    {if $error}
                        <div class="mg-alert">
                            <div class="note note-danger">
                                <button type="button" class="close close-mg-alert" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only"></span></button>
                                <p><strong>{$error}</strong></p>
                            </div>
                        </div>
                    {/if}
                    {if $success}
                        <div class="mg-alert">
                            <div class="note note-success">
                                <button type="button" class="close close-mg-alert" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only"></span></button>
                                <p><strong>{$success}</strong></p>
                            </div>
                        </div>
                    {/if}
                    <div style="display:none;" data-prototype="error">
                        <div class="note note-danger">
                            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only"></span></button>
                            <strong></strong>
                            <a style="display:none;" class="errorID" href=""></a>
                        </div>
                    </div>
                    <div style="display:none;" data-prototype="success">
                        <div class="note note-success">
                            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only"></span></button>
                            <strong></strong>
                        </div>
                    </div>
                </div>
                <div class="page-content" id="MGPage{$currentPageName}">
                    <div class="container-fluid">
                        <ul class="breadcrumb">
                            <li>
                                <a href="{$mainURL}"><i class="fa fa-home"></i></a>
                            </li>
                            {if $breadcrumbs[0]}
                                <li><a href="{$breadcrumbs[0].url}">{$MGLANG->T('pagesLabels','label', $breadcrumbs[0].name)}</a></li>
                                {/if}
                                {if $breadcrumbs[1]}
                                <li><a href="{$breadcrumbs[1].url}">{$MGLANG->T('pagesLabels',$breadcrumbs[0].name,$breadcrumbs[1].name)}</a></li> 
                                {/if}
                        </ul>

                        {$content}
                    </div>
                </div>
            </div>
        </div>
        <div id="MGLoader" style="display:none;" >
            <div>
                <img src="{$assetsURL}/img/ajax-loader.gif" alt="Loading ..." />
            </div>
        </div>   
    </div>