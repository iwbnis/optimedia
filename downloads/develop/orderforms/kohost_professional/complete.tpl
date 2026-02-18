{include file="orderforms/kohost_professional/common.tpl"}

<div id="order-standard_cart">

    <div class="row">
        <div class="cart-sidebar">
            {include file="orderforms/kohost_professional/sidebar-categories.tpl"}
        </div>

        <div class="cart-body">
            <div class="header-lined">
                <h2 class="font-size-24">{$LANG.orderconfirmation}</h2>
            </div>

            {include file="orderforms/kohost_professional/sidebar-categories-collapsed.tpl"}

            <div class="row">
                <div class="col-sm-12">
                    <div class="alert alert-info order-confirmation">
                        <p>{$LANG.orderreceived} {$LANG.ordernumberis} <strong>{$ordernumber}</strong></p> 
                    </div>
                </div>
            </div>

            <div class="available-block gray-bg">
                <p>{$LANG.orderfinalinstructions}</p>
    
                {if $expressCheckoutInfo}
                    <div class="alert alert-info">
                        {$expressCheckoutInfo}
                    </div>
                {elseif $expressCheckoutError}
                    <div class="alert alert-danger">
                        {$expressCheckoutError}
                    </div>
                {elseif $invoiceid && !$ispaid}
                    <div class="alert alert-warning">
                        {$LANG.ordercompletebutnotpaid}
                        <a href="{$WEB_ROOT}/viewinvoice.php?id={$invoiceid}" target="_blank" class="alert-link">
                            {$LANG.invoicenumber}{$invoiceid}
                        </a>
                    </div>
                {/if}
    
                {foreach $addons_html as $addon_html}
                    <div class="order-confirmation-addon-output">
                        {$addon_html}
                    </div>
                {/foreach}
    
                {if $ispaid}
                    <!-- Enter any HTML code which should be displayed when a user has completed checkout here -->
                    <!-- Common uses of this include conversion and affiliate tracking scripts -->
                {/if}
    
               <a href="{$WEB_ROOT}/clientarea.php" class="btn primary-solid-btn">
                    {$LANG.orderForm.continueToClientArea}
                    &nbsp;<i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>
</div>
