{if $template eq "twenty-one"}
    {include file="modules/addons/agreeterms/templates/clienthome-twenty-one.tpl"}
{else}
{literal}
<script>
    function agreeContinueOrder() {
        if (document.getElementById('agreeterms').checked) {
             {/literal}{if $contactnoaccess}return false;{/if}{literal}
            document.forms["agreetermssuccess"].submit();            
        } else {
            document.getElementById('ermsg').style.display = "block";
        }
    }

    function emptyShoppingCart() {
        if (confirm('{/literal}{$ATLANG.surewantemptycart}{literal}'))
            window.location.href = 'cart.php?a=empty';
    }
function PrintElem(elem)
{
 var divToPrint=document.getElementById(elem);
   newWin= window.open("");
   newWin.document.write(divToPrint.outerHTML);
   newWin.print();
   newWin.close();
}   
    function sendemail(){
            $.ajax({
            type: 'POST', url: 'index.php?m=agreeterms', data: {
                sendemail: {/literal}{$agreeid}{literal}
            }
            , success: function (data) {
                alert(data);
            }
        }
        );
    }
</script>
{/literal}
{if $template eq "dash"}
<style>
    .checkbox{
        display: initial;        
    }
    #agreeterms{
        display: inline;        
    }    
</style>
{/if}
{if $template eq "GigaTick"}
<style>
    h1, h2, h3, h4, h5, h6 {
        color: #f5f5f5;
        font-weight: normal;
    }
</style>
{/if}
{if $template eq "flare" || $template eq "croster"}
<style>
    .panel-heading {
        padding: 10px 15px !important;
        background-color: #337ab7 !important;
    }
    .col-center-block {
        float: none !important;
        display: block !important;
        margin: 0 auto !important;
        /* margin-left: auto; margin-right: auto; */
    }
</style>
{/if}
{if $template eq "GigaTick" || $template eq "BoxChat" || $template eq "HostHub2" || $template eq "aceorbit"}<section id="whmcscontentarea">
<div class="container">
<div class="row">
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
<div class="whmcscontentbox">
<div id="whmcsthemes">
<section id="main-body">
{/if}    
{if $template eq "flare" || $template eq "croster"}
<div class="col-md-12">
<div class="col-md-9 col-center-block">
{/if}   
<div class="panel panel-primary">
    <div class="panel-heading" align="center">
        <h4>{$ATLANG.accepttermsconditions}</h4></div>
    <div class="panel-body pre-scrollable" id="termsarea">{$terms}</div>
    <div class="panel-footer" align="center">
        <form name="agreetermssuccess" id="agreetermssuccess" method="post" action="" class="text-center">
            <input type="hidden" name="agreeterms" value="true">
            <input type="hidden" name="productid" value="{$productid}">
            <input type="hidden" name="redirectto" value="{$redirectto}">
            <input type="hidden" name="enforcement" value="{$enforcement}">
            <div>
                <label class="checkbox" {if $template == "lagom"}style="margin-left: 15px;display: block"{/if}><input type="checkbox" {if $contactnoaccess}disabled="disabled"{/if} name="agreeterms" id="agreeterms" value="1">{$ATLANG.iagree}</label>
                <div id="ermsg" style="display:none;color:#FF0000;">{$ATLANG.accepttermsconditions}</div>
            </div>
            <input type="button" class="btn btn-danger" onclick="emptyShoppingCart()" value="{$ATLANG.emptycart}">
            {if $printbutton}<a class="btn btn-primary" target="_blank" href="modules/addons/agreeterms/PDFgen.php?pid={$productid}">{$ATLANG.print}</a>{/if}      
            {if $loggedin}{if $emailoption}<input type="button" class="btn btn-warning" onclick="sendemail()"  value="{$ATLANG.email}">{/if}{/if}                                                               
            <input type="button" class="btn btn-success" {if $contactnoaccess}disabled="disabled"{/if} onclick="agreeContinueOrder()" value="{$ATLANG.continue}">
        </form>
    </div>
</div>
{if $template eq "GigaTick" || $template eq "BoxChat" || $template eq "HostHub2" || $template eq "aceorbit"}</section></div></div></div></div></div></section> {/if}    
{if $template eq "flare" || $template eq "croster"}</div></div>{/if} 
{/if}