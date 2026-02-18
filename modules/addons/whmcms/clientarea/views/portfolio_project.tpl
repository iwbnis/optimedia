<div id="whmcms">
    <div class="row project">
        <div class="col-lg-7">

            {* Project Photos *}
            <div id="whmcms-project-slider" class="carousel slide" data-ride="carousel" data-pause="hover">
                <!-- Indicators -->
                <ol class="carousel-indicators">
                    {if $introvideo}
                        <li data-target="#project-slider" data-slide-to="0" class="active"></li>
                    {/if}
                    {foreach $photos as $photo name=projectphotos}
                    <li data-target="#project-slider" data-slide-to="{$photo.photoid}"{if $smarty.foreach.projectphotos.first and !$introvideo} class="active"{/if}></li>
                    {/foreach}
                </ol>
                <!-- Wrapper for slides -->
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="embed-responsive embed-responsive-16by9">
                            <video class="embed-responsive-item" controls>
                                <source src="{WHMCMS::getSystemURL()}videos/{$introvideo}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                    </div>
                    {foreach $photos as $photo name=projectphotos}
                    <div class="carousel-item{if $smarty.foreach.projectphotos.first and !$introvideo} active{/if}">
                        <img src="{$photo.url}&w=653" alt="{$photo.title}" class="d-block- w-100- img-fluid">
                    </div>
                    {/foreach}
                </div>
                <!-- Controls -->
                <a class="carousel-control-prev" href="#whmcms-project-slider" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">{WHMCMS::__("projectSliderPrevious")}</span>
                </a>
                <a class="carousel-control-next" href="#whmcms-project-slider" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">{WHMCMS::__("projectSliderNext")}</span>
                </a>
            </div>
        </div>

        <div class="col-lg-5">
            <h4 class="project-heading">{WHMCMS::__("projectCaseStudy")}</h4>
            <p>{$details}</p>
            <br>

            <h4 class="project-heading">{WHMCMS::__("projectOverView")}</h4>
            {if $client neq ""}<p><b>{WHMCMS::__("projectClient")}</b> {$client}</p>{/if}
            {if $datepublished neq ""}<p><b>{WHMCMS::__("projectPublished")}</b> {$datepublished}</p>{/if}
            <br>

            {if $categories}
            <h4 class="project-heading">{WHMCMS::__("projectPageCategories")}</h4>
            <div>
                <ul class="list">
                	{foreach $categories as $category}
                	<li><a href="{$category.url}" title="{$category.title}">{$category.title}</a></li>
					{/foreach}
                </ul>
            </div>
            <br>
            {/if}

            {if $tags}
            <h4 class="project-heading">{WHMCMS::__("projectPageTags")}</h4>
            <div>
                {foreach $tags as $tag}
                <a href="{$tag.url}" class="portfolio-projects-tags">{$tag.name}</a>&nbsp;
				{/foreach}
            </div>
            <br>
            {/if}

            <br>
            <a href="{$portfolioindex}" class="btn btn-sm btn-info"><i class="fa fa-chevron-left"></i> {WHMCMS::__("backToPortfolio")}</a>
            {if $url neq ""}<a href="{$url}" class="btn btn-sm btn-warning" target="_blank"><i class="fa fa-external-link"></i> {WHMCMS::__("projectLaunch")}</a>{/if}

        </div>
    </div>

</div>
<div class="clear"></div>
