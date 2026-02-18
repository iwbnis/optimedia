
<div class="search-form-wrap">
    <form role="form" method="post" action="{routePath('download-search')}">
        <div class="input-group input-group-lg kb-search margin-bottom mb-0">
            <input type="text" name="search" id="inputDownloadsSearch" class="form-control" placeholder="{$LANG.downloadssearch}" value="{$search}" />
            <span class="input-group-btn">
                <input type="submit" id="btnDownloadsSearch" class="btn primary-solid-btn btn-input-padded-responsive" value="{$LANG.search}" />
            </span>
        </div>
    </form>
</div>
<p>{$LANG.downloadsintrotext}</p>

{if $dlcats}

    <h2 class="font-25">{$LANG.knowledgebasecategories}</h2>

    <div class="kbcategories">
        {foreach $dlcats as $dlcat}
            <a href="{routePath('download-by-cat', $dlcat.id, $dlcat.urlfriendlyname)}" class="knowledge-categorie">
                <i class="far fa-folder-open"></i>
                {$dlcat.name} ({$dlcat.numarticles})
                <p>{$dlcat.description}</p>
            </a>
        {foreachelse}
            <div class="col-sm-12">
                <p class="text-center fontsize3">{$LANG.downloadsnone}</p>
            </div>
        {/foreach}
    </div>
{/if}

<h2  class="font-25">{$LANG.downloadsfiles}</h2>

<div class="kbarticles">
    {foreach $downloads as $download}
        <div class="single-knowledge">
            <a href="{$download.link}">
                <strong>
                    <i class="fas fa-download"></i> {$download.title}
                    {if $download.clientsonly}
                        <i class="fas fa-lock text-muted"></i>
                    {/if}
                </strong>
                {$download.description}
                <p>{$LANG.downloadsfilesize}: {$download.filesize}</p>
            </a>
        </div>
    {foreachelse}
        <span class="single-knowledge text-center">
            {$LANG.downloadsnone}
        </span>
    {/foreach}
</div>
