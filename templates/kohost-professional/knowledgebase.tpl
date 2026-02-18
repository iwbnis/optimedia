
<div class="search-form-wrap">
    <form role="form" method="post" action="{routePath('knowledgebase-search')}">
        <div class="input-group input-group-lg kb-search">
            <input type="text" id="inputKnowledgebaseSearch" name="search" class="form-control" placeholder="{$LANG.clientHomeSearchKb}" />
            <span class="input-group-btn">
                <input type="submit" id="btnKnowledgebaseSearch" class="btn primary-solid-btn" value="{$LANG.search}" />
            </span>
        </div>
    </form>
</div>

<h2 class="font-25">{$LANG.knowledgebasecategories}</h2>

{if $kbcats}
    <div class="kbcategories">
        {foreach from=$kbcats name=kbcats item=kbcat}
            <a href="{routePath('knowledgebase-category-view', {$kbcat.id}, {$kbcat.urlfriendlyname})}" class="knowledge-categorie">
                <i class="fas fa-folder"></i>
                {$kbcat.name} ({$kbcat.numarticles})
                <p>{$kbcat.description}</p>
            </a>
            {if $kbcat.editLink}
                <a href="{$kbcat.editLink}" class="admin-inline-edit cat-edit">
                    <i class="fas fa-pencil-alt fa-fw"></i>
                    {$LANG.edit}
                </a>
            {/if}

        {/foreach}
    </div>
{else}
    {include file="$template/includes/no-data.tpl" msg=$LANG.knowledgebasenoarticles }
{/if}

{if $kbmostviews}

    <h2 class="font-25">{$LANG.knowledgebasepopular}</h2>

    <div class="kbarticles">
        {foreach from=$kbmostviews item=kbarticle}
            <div class="single-knowledge">
                <a href="{routePath('knowledgebase-article-view', {$kbarticle.id}, {$kbarticle.urlfriendlytitle})}">
                    <i class="fas fa-file-alt"></i> {$kbarticle.title}
                </a>
                {if $kbarticle.editLink}
                    <a href="{$kbarticle.editLink}" class="admin-inline-edit">
                        <i class="fas fa-pencil-alt fa-fw"></i>
                        {$LANG.edit}
                    </a>
                {/if}
                <p>{$kbarticle.article|truncate:100:"..."}</p>
            </div>
        {/foreach}
    </div>

{/if}
