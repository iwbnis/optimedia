<div class="search-form-wrap">
    <form role="form" method="post" action="{routePath('knowledgebase-search')}">
        <div class="input-group input-group-lg kb-search">
            <input type="text"  id="inputKnowledgebaseSearch" name="search" class="form-control" placeholder="{$LANG.clientHomeSearchKb}" value="{$searchterm}" />
            <span class="input-group-btn">
                <input type="submit" id="btnKnowledgebaseSearch" class="btn primary-solid-btn btn-input-padded-responsive" value="{$LANG.search}" />
            </span>
        </div>
    </form>
</div>



{if $kbcats}
    <h2 class="font-25">{$LANG.knowledgebasecategories}</h2>

    <div class="kbcategories">
        {foreach name=kbasecats from=$kbcats item=kbcat}
            <a href="{routePath('knowledgebase-category-view',{$kbcat.id},{$kbcat.urlfriendlyname})}" class="knowledge-categorie">
                <i class="fas fa-folder"></i> {$kbcat.name} <span class="badge badge-info">{$kbcat.numarticles}</span>
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
{/if}

{if $kbarticles || !$kbcats}
    {if $tag}
        <h2 class="font-25">{$LANG.kbviewingarticlestagged} '{$tag}'</h2>
    {else}
        <h2 class="font-25">{$LANG.knowledgebasearticles}</h2>
    {/if}

    <div class="kbarticles">
        {foreach from=$kbarticles item=kbarticle}
            <div class="single-knowledge">
                <a href="{routePath('knowledgebase-article-view', {$kbarticle.id}, {$kbarticle.urlfriendlytitle})}">
                    {$kbarticle.title}
                </a>
                {if $kbarticle.editLink}
                    <a href="{$kbarticle.editLink}" class="admin-inline-edit">
                        <i class="fas fa-pencil-alt fa-fw"></i>
                        {$LANG.edit}
                    </a>
                {/if}
                <p>{$kbarticle.article|truncate:100:"..."}</p>
            </div>
        {foreachelse}
            {include file="$template/includes/alert.tpl" type="info" msg=$LANG.knowledgebasenoarticles textcenter=true}
        {/foreach}
    </div>
{/if}
