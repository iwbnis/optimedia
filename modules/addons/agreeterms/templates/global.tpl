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
            var divToPrint = document.getElementById(elem);
            newWin = window.open("");
            newWin.document.write(divToPrint.outerHTML);
            newWin.print();
            newWin.close();
        }
        function sendemail() {
            $.ajax({
                type: 'POST', url: 'index.php?m=agreeterms', data: {
                    sendemail: {/literal}-1{literal},
                    agree_optional: {/literal}{$agree_optional}{literal},
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
{if $template eq "GigaTick" || $template eq "BoxChat" || $template eq "HostHub2"}<section id="whmcscontentarea">
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
                                            <h4>{if $contactnoaccess}{$ATLANG.noaccess}{else}{$ATLANG.accepttermsconditions}{/if}</h4></div>
                                        <div class="panel-body pre-scrollable" id="termsarea">{$terms}</div>
                                        <div class="panel-footer" align="center">
                                            <form name="agreetermssuccess" id="agreetermssuccess" method="post" action="" class="text-center">
                                                <input type="hidden" name="agreeterms" value="true">
                                                <input type="hidden" name="productid" value="{$productid}">
                                                <input type="hidden" name="redirectto" value="{$redirectto}">
                                                <input type="hidden" name="enforcement" value="{$enforcement}">
                                                <input type="hidden" name="agree_optional" value="{$agree_optional}">
                                                <div>
                                                    <label class="checkbox"><input {if $contactnoaccess}disabled="disabled"{/if} type="checkbox" name="agreeterms" id="agreeterms" value="1">{$ATLANG.iagree}</label>
                                                    <div id="ermsg" style="display:none;color:#FF0000;">{$ATLANG.accepttermsconditions}</div>
                                                </div>
                                                    {if $printbutton}<a class="btn btn-primary" {if $loggedin} target="_blank" href="modules/addons/agreeterms/PDFgen.php?global=true{if $agree_optional}&agree_optional=1{/if}" {else}  href="#" onclick="PrintElem('termsarea')"{/if}>{$ATLANG.print}</a>{/if}                                                      
                                            {if $loggedin}{if $emailoption}<input type="button" class="btn btn-warning" onclick="sendemail()"  value="{$ATLANG.email}">{/if}{/if}                                                               
                                            <input type="button" {if $contactnoaccess}disabled="disabled"{/if} class="btn btn-success" onclick="agreeContinueOrder()" value="{$ATLANG.backhome}">
                                        </form>
                                    </div>
                                </div>
                                {if $template eq "GigaTick" || $template eq "BoxChat" || $template eq "HostHub2"}</section></div></div></div></div></div></section> {/if}    
        {if $template eq "flare" || $template eq "croster"}</div></div>{/if}    
