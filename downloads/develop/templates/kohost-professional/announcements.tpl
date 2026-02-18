{if $announcementsFbRecommend}
    <script>
        (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) {
                return;
            }
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/{$LANG.locale}/all.js#xfbml=1";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>
{/if}
{foreach from=$announcements item=announcement}

    <div class="announcement-single">
        <div class="article-items">
            <a href="{routePath('announcement-view', $announcement.id, $announcement.urlfriendlytitle)}" class="title">
                {$announcement.title}
            </a>
            {if $announcement.editLink}
                <a href="{$announcement.editLink}" class="admin-inline-edit">
                    <i class="fal fa-pencil-alt fa-fw"></i>
                    {$LANG.edit}
                </a>
            {/if}
        </div>
        {if $announcement.text|strip_tags|strlen < 350}
            <p>{$announcement.text}</p>
        {else}
            <p>{$announcement.summary}</p>
        {/if}
        <div class="article-footer">
            <span><i class="fal fa-calendar-alt"></i> {$carbon->createFromTimestamp($announcement.timestamp)->format('jS M Y')}</span>
            <a href="{routePath('announcement-view', $announcement.id, $announcement.urlfriendlytitle)}" class="detail-link">{$LANG.readmore} <span class="fas fa-arrow-right"></span></a>
        </div>


        {if $announcementsFbRecommend}
            <div class="fb-like hidden-sm hidden-xs" data-layout="standard" data-href="{fqdnRoutePath('announcement-view', $announcement.id, $announcement.urlfriendlytitle)}" data-send="true" data-width="450" data-show-faces="true" data-action="recommend"></div>
            <div class="fb-like hidden-lg hidden-md" data-layout="button_count" data-href="{fqdnRoutePath('announcement-view', $announcement.id, $announcement.urlfriendlytitle)}" data-send="true" data-width="450" data-show-faces="true" data-action="recommend"></div>
        {/if}

    </div>

{foreachelse}
    {include file="$template/includes/no-data.tpl" msg="{$LANG.noannouncements}"}
{/foreach}

{if $prevpage || $nextpage}

    <div class="col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3">
        <form class="form-inline" role="form">
            <div class="form-group">
                <div class="input-group">
                    <span class="btn-group">
                        {foreach $pagination as $item}
                            <a href="{$item.link}" class="btn btn-default{if $item.active} active{/if}"{if $item.disabled} disabled="disabled"{/if}>{$item.text}</a>
                        {/foreach}
                    </span>
                </div>
            </div>
        </form>
    </div>
{/if}
