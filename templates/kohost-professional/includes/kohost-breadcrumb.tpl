<div class="breadcrumb-bar py-3 gray-light-bg border-bottom">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="custom-breadcrumb">
                    <ol class="breadcrumb d-inline-block bg-transparent list-inline py-0 pl-0">
                        {foreach $breadcrumb as $item}
                            <li class="list-inline-item breadcrumb-item{if $item@last} active{/if}">
                                {if !$item@last}<a href="{$item.link}">{/if}
                                {$item.label}
                                {if !$item@last}</a> <i class="fas fa-angle-right"></i> {/if}
                            </li>
                        {/foreach}
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>