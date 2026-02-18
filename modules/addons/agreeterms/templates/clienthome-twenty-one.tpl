
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

<div class="card">
    <div class="card-header">
        {$ATLANG.accepttermsconditions}
    </div>
    <div class="card-body pre-scrollable" id="termsarea">
        {$terms}
    </div>
    <div class="card-footer">
        <form name="agreetermssuccess" id="agreetermssuccess" method="post" action="" class="text-center">
            <input type="hidden" name="agreeterms" value="true">
            <input type="hidden" name="productid" value="{$productid}">
            <input type="hidden" name="redirectto" value="{$redirectto}">
            <input type="hidden" name="enforcement" value="{$enforcement}">
            <div>
                <label class="checkbox"><input  style="margin-right:5px;" type="checkbox" {if $contactnoaccess}disabled="disabled"{/if} name="agreeterms" id="agreeterms" value="1">{$ATLANG.iagree}</label>
                <div id="ermsg" style="display:none;color:#FF0000;">{$ATLANG.accepttermsconditions}</div>
            </div>
            <input type="button" class="btn btn-danger" onclick="emptyShoppingCart()" value="{$ATLANG.emptycart}">
            {if $printbutton}<a class="btn btn-primary" target="_blank" href="modules/addons/agreeterms/PDFgen.php?pid={$productid}">{$ATLANG.print}</a>{/if}      
        {if $loggedin}{if $emailoption}<input type="button" class="btn btn-warning" onclick="sendemail()"  value="{$ATLANG.email}">{/if}{/if}                                                               
        <input type="button" class="btn btn-success" {if $contactnoaccess}disabled="disabled"{/if} onclick="agreeContinueOrder()" value="{$ATLANG.continue}">
    </form>
</div>
</div>