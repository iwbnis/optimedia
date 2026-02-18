{* Loop Projects *}
<div id="whmcms" class="whmcms-portfolio whmcms-portfolio-default">
    <div class="row">
        {foreach $projects as $project}
            <div class="col-12 col-sm-6 col-lg-{$gridcolumns}">
                <div class="card portfolio-project-item">
                    {if $project.introvideo}
                        <div class="embed-responsive embed-responsive-16by9">
                            <video class="embed-responsive-item" controls>
                                <source src="{WHMCMS::getSystemURL()}videos/{$project.introvideo}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                    {else}
                        <img
                            src="{if $project.logo}{WHMCMS::getSystemURL()}modules/addons/whmcms/resize.php?src={$project.logo}&w={$logowidth}{/if}"
                            data-src="holder.js/{$logowidth}x{$logoheight}?theme=gray&text={$project.title}"
                            alt="{$project.title}" class="card-img-top" style="width:100%; height: {$logoheight}px;">
                    {/if}
                    <div class="card-body">
                        <h4 class="card-title">
                            <a href="{$project.social.url}" class="title">{$project.title}</a>
                        </h4>
                    </div>
                </div>
            </div>
        {/foreach}
    </div>
    <div class="clear"></div>
</div>
