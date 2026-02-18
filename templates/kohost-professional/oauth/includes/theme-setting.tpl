{if $smarty.server.HTTP_HOST == 'themetags.net'}
<div class="theme-switcher-wrap">
    <div class="overlay"></div>
     <a href="#" class="settingTriggerSidebar">
        <i class="fas fa-cog fa-spin"></i> 
      </a>
    <div class="theme-switcher-content">
        <a href="#" class="hideSidebar"><i class="fas fa-times"></i></a>
        <div class="switcherContainer">
            <div class="row mb-20">
                <div class="col-sm-12"><h5>Choose Style</h5></div>
                <div class="col-md-12"> 
                    <a href="https://themetags.net/whmcs/index.php?systpl=kohost-professional" class="kohost-professional theme-switcher-box" onclick="switchTheme('kohost-professional');">
                        <img src="https://kohost.themetags.com/kohost-professional.jpg" class="img-responsive" alt="Default">
                    </a>
                    <h6 class="theme-switcher-title">WHMCS Professional</h6>
                </div>
                <div class="col-md-12"> 
                    <a href="https://themetags.net/whmcs/index.php?systpl=kohost-professional-rtl" class="kohost-professional-rtl theme-switcher-box" onclick="switchTheme('kohost-professional-rtl');">
                        <img src="https://kohost.themetags.com/kohost-professional-rtl.jpg" class="img-responsive" alt="Default">
                    </a>
                    <h6 class="theme-switcher-title">WHMCS Professional RTL</h6>
                </div>
            </div>
         </div>
    </div>
</div>
<style>
/* Sidebar */
.theme-switcher-wrap{
    position: relative;
    width: 100%;
    display: block;
}
.theme-switcher-wrap .settingTriggerSidebar{
    position: fixed;
    right: 0;
    width: 40px;
    height: 40px;
    line-height: 40px;
    text-align: center;
    background: #00255f;
    color: #fff;
    z-index: 3;
    top: 20%;
    border-radius: 4px 0 0 4px;
}

.theme-switcher-wrap .hideSidebar{
    width: 40px;
    height: 40px;
    line-height: 40px;
    color: #00255f;
    display: block;
    text-align: center;
    margin-left: auto;
    font-size: 20px;
}
.theme-switcher-wrap .overlay {
    display: none;
    cursor: pointer;
    position: fixed;
    left: 0;
    top: 0;
    z-index: 1001;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,.5);
}

.theme-switcher-content {
    width: 500px;
    background: #f5f5f5;
    border-right: 1px solid #ebebeb;
    position: fixed;
    right: -500px;
    height: 100%;
    transition: .3s;
    z-index: 999999;
    padding: 25px;
    overflow-y: scroll;
}
.switcherContainer{
    width: 100%;
}
.theme-switcher-box.active, .theme-switcher-box:hover {
    border-color: #1062fe;
}

.theme-switcher-box {
    display: block;
    border: 1px solid #cae3fc;
    border-radius: 4px;
    transition: border .24s ease;
    overflow: hidden;
    position: relative;
}
.theme-switcher-title{
    display: block;
    text-align: center;
        font-weight: 500;
    font-family: 'Roboto', sans-serif;
    font-size: 14px;
}

.theme-switcher-box.active:before {
    opacity: 1;
    transform: translateY(0);
}

.theme-switcher-box:before {
    z-index: 2;
    font-family: "Font Awesome 5 Pro";
    font-weight: 900;
    content: "\f00c";
    display: flex;
    justify-content: center;
    align-items: center;
    opacity: 0;
    position: absolute;
    top: 50%;
    left: 50%;
    width: 24px;
    height: 24px;
    border-radius: 100%;
    background: #0067e2;
    color: #fff;
    transform: translateY(20px);
    transition: .24s ease;
    margin-top: -12px;
    margin-left: -12px;
}
.theme-switcher-box.active:after {
    opacity: 1;
}

.theme-switcher-box:after {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: hsla(0,0%,100%,.7);
    content: "";
    opacity: 0;
    transition: .24s ease;
    z-index: 1;
}
.body-wraper.active{
    overflow-y: hidden;
}
</style>
<script>
$('.settingTriggerSidebar').click(function() {
    $(".body-wraper").addClass("active");
    $('.theme-switcher-content').css('right', '0px');
    $('.theme-switcher-wrap .overlay').css('display', 'block');
})

var sembunyikan = function() {
    $('.theme-switcher-wrap .overlay').css('display', 'none');
    $('.theme-switcher-content').css('right', '-500px');
    $(".body-wraper").removeClass("active");
}

$('.theme-switcher-wrap .hideSidebar').click(sembunyikan);
$('.theme-switcher-wrap .overlay').click(sembunyikan);

function switchTheme(templateStr = '') {
    var cookieName = 'defaultKohostWhmcsTemplate';
    var defaultWhmcsTemplateName = readCookie(cookieName);
    
    $(".theme-switcher-box").removeClass("active");
    if(templateStr && defaultWhmcsTemplateName && defaultWhmcsTemplateName != templateStr) {
        $(".theme-switcher-content ." + templateStr).addClass("active");
        createCookie(cookieName, templateStr, 1);
    } else if(defaultWhmcsTemplateName && !templateStr) {
        $(".theme-switcher-content ." + defaultWhmcsTemplateName).addClass("active");
    } else if(!defaultWhmcsTemplateName && templateStr) {
        $(".theme-switcher-content ." + templateStr).addClass("active");
        createCookie(cookieName, templateStr, 1);
    } else if(!defaultWhmcsTemplateName && !templateStr) {
        createCookie(cookieName, 'kohost-professional', 1);
        $(".theme-switcher-content .kohost-professional").addClass("active");
    } else {
        $(".theme-switcher-content ." + templateStr).addClass("active");
    }
}

switchTheme();

// Cookies
function createCookie(name, value, days) {
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        var expires = "; expires=" + date.toGMTString();
    }
    else var expires = "";               

    document.cookie = name + "=" + value + expires + "; path=/";
}

function readCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
    }
    return false;
}

function eraseCookie(name) {
    createCookie(name, "", -1);
}

</script>
{/if}