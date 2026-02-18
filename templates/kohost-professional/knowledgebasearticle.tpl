{if $kbarticle.voted && $kbarticle.votes}
    {include file="$template/includes/alert.tpl" type="success alert-bordered-left" msg="{lang key="knowledgebaseArticleRatingThanks"}" textcenter=true}
{/if}

<div class="kb-wrap mb-40">
    <div class="kb-article-title">
        <div class="kb-title">
            <h2>{$kbarticle.title}</h2>
            {if $kbarticle.editLink}
                <a href="{$kbarticle.editLink}">
                    <i class="fas fa-pencil-alt fa-fw"></i>
                    {$LANG.edit}
                </a>
            {/if}
        </div>
        <a href="#" class="btn btn-link btn-print" onclick="window.print();return false"><i class="fas fa-print"></i></a>
    </div>

    <div class="kb-article-content">
        {$kbarticle.text}
    </div>

    <div class="kb-rate-article hidden-print">
        <form action="{routePath('knowledgebase-article-view', {$kbarticle.id}, {$kbarticle.urlfriendlytitle})}" method="post">
            <input type="hidden" name="useful" value="vote">
            <div class="kb-vote">
                <h5 class="mb-0">{$LANG.knowledgebasehelpful}</h5>
                {if $kbarticle.voted}
                <p><i class="fas fa-heart"></i> {$kbarticle.useful} {$LANG.knowledgebaseratingtext} ({$kbarticle.votes} {$LANG.knowledgebasevotes})</p>
                {/if}
            </div>
            <div>
                {if !$kbarticle.voted || !$kbarticle.votes}
                <button type="submit" name="vote" value="yes" class="btn outline-btn vot-btn"><i class="far fa-thumbs-up"></i> {$LANG.knowledgebaseyes}</button>
                <button type="submit" name="vote" value="no" class="btn outline-btn vot-btn"><i class="far fa-thumbs-down"></i> {$LANG.knowledgebaseno}</button>
                {/if}
            </div>
        </form>
    </div>
</div>

{if $kbarticles}
    <div class="kb-also-read">
        <h3>{$LANG.knowledgebaserelated}</h3>
        <div class="kbarticles">
            {foreach key=num item=kbarticle from=$kbarticles}
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
    </div>
{/if}
