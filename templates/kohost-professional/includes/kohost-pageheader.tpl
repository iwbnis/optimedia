{if !in_array($templatefile, ['login', 'clientregister', 'password-reset-container', 'logout', 'store/ox/index', 'store/sitelockvpn/index', 'store/sitelock/index'])}
<section class="page-header-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-7 col-lg-6">
                <div class="page-header-content text-white">
                    <h1 class="text-white mb-2">
                        {if $clientareaaction === '' && $clientareaaction !== NULL}
                        {lang key="My Dashboard"}
                        {else}
                        {$displayTitle}
                        {/if}
                        </h1>
                    {if $tagline} <p>{$tagline}</p>{/if}
                </div>
                <div class="custom-breadcrumb">
                    <ol class="d-inline-block bg-transparent list-inline py-0 pl-0">
                        {foreach $breadcrumb as $item}
                            <li class="list-inline-item breadcrumb-item{if $item@last} active{/if}">
                                {if !$item@last}<a href="{$item.link}">{/if}
                                {$item.label}
                                {if !$item@last}</a> <i class="far fa-angle-right"></i> {/if}
                            </li>
                        {/foreach}
                    </ol>
                </div>
            </div>
        </div>
    </div>
</section>
{/if}