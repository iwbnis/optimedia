<?php

class Socialshare {

    private $CI;

    public function __construct(){

        $this->CI =& get_instance();

    }

    private function parse_share_data($data) {
        $current_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        return array(
            'url' => (isset($data['url']) && !empty($data['url'])) ? urldecode($data['url']) : $current_link,
            'title' => (isset($data['title']) && !empty($data['title'])) ? urldecode($data['title']) : $current_link,
            'desc' => (isset($data['desc']) && !empty($data['desc'])) ? urldecode($data['desc']) : '',
        );
    }

    public function get_dynamic_social_share_btns($data = null) {
        $base_url = base_url();
        $socialBtnsHtml = '
        <link rel="stylesheet" type="text/css" href="'.$base_url.'assets/plugins/social-share/social-share.css">
        <div id="social-share-modal" class="modal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">'.__('admin.share_on_social_network').'</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            
                        </div>
                    </div>
                </div>
            </div>

            <script type="text/javascript">
                $(document).on("click", "[data-social-share]", function(){
                    
                    let url = encodeURIComponent($(this).data("share-url"));
                    let title = $(this).data("share-title") ? encodeURIComponent($(this).data("share-title")) : url ;
                    let desc = $(this).data("share-desc") ? encodeURIComponent($(this).data("share-desc")) : "" ;

                    $(\'#social-share-modal .modal-body\').html(`
                        <!-- Sharingbutton Facebook -->
                        <a class="resp-sharing-button__link" href="https://facebook.com/sharer/sharer.php?u=`+url+`&description=" target="_blank" rel="noopener" aria-label="Facebook">
                        <div class="resp-sharing-button resp-sharing-button--facebook resp-sharing-button--medium"><div aria-hidden="true" class="resp-sharing-button__icon resp-sharing-button__icon--solidcircle"><i class="fab fa-facebook-square"></i>&nbsp;</div>Facebook</div></a>

                        <!-- Sharingbutton Twitter -->
                        <a class="resp-sharing-button__link" href="https://twitter.com/intent/tweet/?text=`+title+`%20`+desc+`&amp;url=`+url+`" target="_blank" rel="noopener" aria-label="Twitter"><div class="resp-sharing-button resp-sharing-button--twitter resp-sharing-button--medium"><div aria-hidden="true" class="resp-sharing-button__icon resp-sharing-button__icon--solidcircle"><i class="fab fa-twitter" aria-hidden="true"></i>&nbsp;</div>Twitter</div></a>

                        <!-- Sharingbutton Tumblr -->
                        <a class="resp-sharing-button__link" href="https://www.tumblr.com/widgets/share/tool?posttype=link&amp;title=`+title+`&amp;caption=`+title+`&amp;content=`+desc+`&amp;canonicalUrl=`+url+`&amp;shareSource=tumblr_share_button" target="_blank" rel="noopener" aria-label="Tumblr"><div class="resp-sharing-button resp-sharing-button--tumblr resp-sharing-button--medium"><div aria-hidden="true" class="resp-sharing-button__icon resp-sharing-button__icon--solidcircle"><i class="fab fa-tumblr-square" aria-hidden="true"></i>&nbsp;</div>Tumblr</div></a>

                        <!-- Sharingbutton E-Mail -->
                        <a class="resp-sharing-button__link" href="mailto:?subject=`+title+`&amp;body=`+title+`%20`+url+`%20`+desc+`" target="_self" rel="noopener" aria-label="E-Mail"><div class="resp-sharing-button resp-sharing-button--email resp-sharing-button--medium"><div aria-hidden="true" class="resp-sharing-button__icon resp-sharing-button__icon--solidcircle"><i class="fa fa-envelope" aria-hidden="true"></i>&nbsp;</div>E-Mail</div></a>

                        <!-- Sharingbutton LinkedIn -->
                        <a class="resp-sharing-button__link" href="https://www.linkedin.com/shareArticle?mini=true&amp;url=`+url+`&amp;title=`+title+`&amp;summary=`+desc+`&amp;source=`+url+`" target="_blank" rel="noopener" aria-label="LinkedIn"><div class="resp-sharing-button resp-sharing-button--linkedin resp-sharing-button--medium"><div aria-hidden="true" class="resp-sharing-button__icon resp-sharing-button__icon--solidcircle"><i class="fab fa-linkedin" aria-hidden="true"></i>&nbsp;</div>LinkedIn</div></a>

                        <!-- Sharingbutton WhatsApp -->
                        <a class="resp-sharing-button__link" href="https://api.whatsapp.com://send?text=`+url+`" target="_blank" rel="noopener" aria-label="WhatsApp"><div class="resp-sharing-button resp-sharing-button--whatsapp resp-sharing-button--medium"><div aria-hidden="true" class="resp-sharing-button__icon resp-sharing-button__icon--solidcircle"><i class="fab fa-whatsapp" aria-hidden="true"></i>&nbsp;</div>WhatsApp</div></a>

                        <!-- Sharingbutton Telegram -->
                        <a class="resp-sharing-button__link" href="https://telegram.me/share/url?text=`+title+`&amp;url=`+url+`" target="_blank" rel="noopener" aria-label="Telegram"><div class="resp-sharing-button resp-sharing-button--telegram resp-sharing-button--medium"><div aria-hidden="true" class="resp-sharing-button__icon resp-sharing-button__icon--solidcircle"><i class="fa fa-telegram" aria-hidden="true"></i>&nbsp;</div>Telegram</div></a>
                        
                        <!-- Sharingbutton Pinterest -->
                        <a class="resp-sharing-button__link" href="https://pinterest.com/pin/create/button/?url=`+url+`&amp;media=`+url+`&amp;description=`+title+`." target="_blank" rel="noopener" aria-label="Share on Pinterest"><div class="resp-sharing-button resp-sharing-button--pinterest resp-sharing-button--large"><div aria-hidden="true" class="resp-sharing-button__icon resp-sharing-button__icon--solid"><i class="fab fa-pinterest" aria-hidden="true"></i>&nbsp;</div>Share on Pinterest</div></a>

                        <!-- Sharingbutton Reddit -->
                        <a class="resp-sharing-button__link" href="https://reddit.com/submit/?url=`+url+`&amp;resubmit=true&amp;title=`+title+`." target="_blank" rel="noopener" aria-label="Share on Reddit"><div class="resp-sharing-button resp-sharing-button--reddit resp-sharing-button--large"><div aria-hidden="true" class="resp-sharing-button__icon resp-sharing-button__icon--solid"><i class="fab fa-pinterest" aria-hidden="true"></i>&nbsp;</div>Share on Reddit</div></a>

                        <!-- Sharingbutton XING -->
                        <a class="resp-sharing-button__link" href="https://www.xing.com/app/user?op=share;url=`+url+`;title=`+title+`." target="_blank" rel="noopener" aria-label="Share on XING"><div class="resp-sharing-button resp-sharing-button--xing resp-sharing-button--large"><div aria-hidden="true" class="resp-sharing-button__icon resp-sharing-button__icon--solid"><i class="fab fa-xing" aria-hidden="true"></i>&nbsp;</div>Share on XING</div></a>

                        <!-- Sharingbutton Hacker News -->
                        <a class="resp-sharing-button__link" href="https://news.ycombinator.com/submitlink?u=`+url+`&amp;t=`+title+`." target="_blank" rel="noopener" aria-label="Share on Hacker News"><div class="resp-sharing-button resp-sharing-button--hackernews resp-sharing-button--large"><div aria-hidden="true" class="resp-sharing-button__icon resp-sharing-button__icon--solid"><i class="fab fa-hacker-news"></i>&nbsp;</div>Share on Hacker News</div></a>

                        <!-- Sharingbutton VK -->
                        <a class="resp-sharing-button__link" href="http://vk.com/share.php?title=`+title+`.&amp;url=`+url+`" target="_blank" rel="noopener" aria-label="Share on VK"><div class="resp-sharing-button resp-sharing-button--vk resp-sharing-button--large"><div aria-hidden="true" class="resp-sharing-button__icon resp-sharing-button__icon--solid"><i class="fab fa-vk" aria-hidden="true"></i>&nbsp;</div>Share on VK</div></a>
                    `);

                    $(\'#social-share-modal\').modal(\'show\');
                });
            </script>
        ';
        return $socialBtnsHtml;
    }
}