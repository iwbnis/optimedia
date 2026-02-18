{* Loop Projects *}
<div id="whmcms" class="whmcms-portfolio whmcms-portfolio-default">
    <div class="row">
        {foreach $projects as $project}
        <div class="col-xs-12 col-sm-6 col-lg-{$gridcolumns}">
            <div class="portfolio-project-item">
                <div class="thumbnail">
                    <img src="{if $project.logo}{WHMCMS::getSystemURL()}modules/addons/whmcms/resize.php?src={$project.logo}&w={$logowidth}{/if}" data-src="holder.js/{$logowidth}x{$logoheight}?theme=gray&text={$project.title}" alt="{$project.title}" style="width:100%; height: {$logoheight}px;">
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