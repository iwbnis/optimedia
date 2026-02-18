{* Loop Projects *}
<div id="whmcms" class="whmcms-portfolio whmcms-portfolio-category">
    <div class="row">
        <div class="col-xs-12">
            <div class="pull-right">
                <div class="btn-group">
                    <button class="btn btn-default btn-lg dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {$selectedcategory.title} <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <li{if $selectedcategory.id eq 0} class="active"{/if}><a href="{$portfolioindex}">{WHMCMS::__("portfolioAllCategory")}</a></li>
                        {foreach $categories as $category}
                        <li{if $category.id eq $selectedcategory.id} class="active"{/if}><a href="{$category.url}">{$category.title}</a></li>
                        {/foreach}
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="clearline"></div>
    
    <div class="row">
        {foreach $projects as $project}
        <div class="col-xs-12 col-sm-6 col-lg-{$gridcolumns}">
            <div class="portfolio-project-item">
                <div class="thumbnail">
                    <img src="{if $project.logo}{WHMCMS::getSystemURL()}modules/addons/whmcms/resize.php?src={$project.logo}&w={$logowidth}{/if}" data-src="holder.js/{$logowidth}x{$logoheight}?theme=gray&text={$project.title}" alt="{$project.title}" style="width:100%; height: {$logoHeight}px;">
                    <div class="caption">
                        <h4 class="text-center">
                            <a href="{$project.social.url}" class="title">{$project.title}</a>
                        </h4>
                        <div class="text-center project-tags">
                            {foreach $project.tags as $tag}
                            <a href="{$tag.url}" class="portfolio-projects-tags">{$tag.name}</a>&nbsp;
                            {/foreach}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {/foreach}
    </div>
    
    <div class="clear"></div>
</div>