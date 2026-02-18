{if $twitterusername}

    <h2>{$LANG.twitterlatesttweets}</h2>

    <div id="twitterFeedOutput">
        <p class="text-center"><img src="{$BASE_PATH_IMG}/loading.gif" /></p>
    </div>

    <script type="text/javascript" src="{assetPath file='twitter.js'}"></script>

{elseif $announcements}
    <div class="row justify-content-center d-flex" id="latest-news">
        <div class="col-md-12 col-lg-12">
            <div class="section-heading-center text-center">
                <h2>{$LANG.ourlatestnews}</h2>
                <p class="lead">{$LANG.newsdesc}</p>
            </div>
        </div>
    </div>
    <div class="row" id="myflex">
        {foreach $announcements as $announcement}
        {if $announcement@index < 3}
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="announcement-single home-news">
                    <div class="article-heading">
                        <h3>
                            <a href="{routePath('announcement-view', $announcement.id, $announcement.urlfriendlytitle)}">{$announcement.title}</a>
                        </h3>
                        <div class="article-items">
                            <i class="fal fa-calendar-alt fa-fw"></i>
                            {$carbon->translatePassedToFormat($announcement.rawDate, 'jS M Y')}
                        </div>
                    </div>
                    <span class="border-shape"></span>
                    <p>
                        {if $announcement.text|strip_tags|strlen < 350}
                            {$announcement.text}
                        {else}
                            {$announcement.summary}</br>

                        {/if}
                    </p>
                    <a href="{routePath('announcement-view', $announcement.id, $announcement.urlfriendlytitle)}" class="detail-link">{$LANG.readmore} <span class="fas fa-arrow-right"></span></a>

                    {if $announcementsFbRecommend}
                        <script>
                            (function(d, s, id) {
                                var js, fjs = d.getElementsByTagName(s)[0];
                                if (d.getElementById(id)) {
                                    return;
                                }
                                js = d.createElement(s); js.id = id;
                                js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
                                fjs.parentNode.insertBefore(js, fjs);
                            }(document, 'script', 'facebook-jssdk'));
                        </script>
                        <div class="fb-like hidden-sm hidden-xs" data-layout="standard" data-href="{fqdnRoutePath('announcement-view', $announcement.id, $announcement.urlfriendlytitle)}" data-send="true" data-width="450" data-show-faces="true" data-action="recommend"></div>
                        <div class="fb-like hidden-lg hidden-md" data-layout="button_count" data-href="{fqdnRoutePath('announcement-view', $announcement.id, $announcement.urlfriendlytitle)}" data-send="true" data-width="450" data-show-faces="true" data-action="recommend"></div>
                    {/if}
                </div>
            </div>
        {/if}
    {/foreach}
    </div>
{/if}

