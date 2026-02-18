{* Loop Projects *}
<div id="whmcms" class="whmcms-portfolio whmcms-portfolio-filterable">
    <div class="row">
        <div class="col-xs-12">
            <div class="pull-left">
                <div id="whmcms-portfolio-filters" class="clearfix">
                    <a href="{$portfolioindex}" data-filter="*"{if $selectedfilter eq ""} class="active"{/if}>{WHMCMS::__("portfolioFilterAll")}</a>
                    {foreach $filterbuttons as $filter}
                    <a href="{$filter.url}" data-filter=".{$filter.filter}"{if $selectedfilter eq $filter.filter} class="active"{/if}>{$filter.title}</a>
                    {/foreach}
                </div>
            </div>
            <div class="clear"></div>
        </div>
    </div>
    
    <div id="whmcms-filterable-items" class="row">
        {foreach $projects as $project}
        <div class="col-xs-12 col-sm-6 col-lg-{$gridcolumns}{foreach $project.filterclasses as $filterclass} {$filterclass}{/foreach}">
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

{literal}
<script type="text/javascript">
$(function(){
    // Cache container
    var $portfolio = $('#whmcms-filterable-items');
    if ($portfolio.length){
        // initialize isotope
        $portfolio.isotope();
        // filter items when filter link is clicked
        $('#whmcms-portfolio-filters a').click(function(){
            $('#whmcms-portfolio-filters a').removeClass('active');
            $(this).addClass('active');
            var portfolioFilter = $(this).attr('data-filter');
            $portfolio.isotope({filter: portfolioFilter});
            return false;
        });
    }
});
</script>
{/literal}