{include file="orderforms/kohost_professional/common.tpl"}

<div id="order-standard_cart">

    <div class="row">

        <div class="cart-sidebar">

            {include file="orderforms/kohost_professional/sidebar-categories.tpl"}

        </div>
        <div class="cart-body">
            <div class="header-lined">
                <h2 class="font-size-24">{$LANG.cartproductaddons}</h2>
            </div>

            {include file="orderforms/kohost_professional/sidebar-categories-collapsed.tpl"}

            {if count($addons) == 0}
                {include file="$template/includes/no-data.tpl" msg=$LANG.cartproductaddonsnone btnText=$LANG.orderForm.returnToClientArea btnUrl="{$WEB_ROOT}/clientarea.php" btnClass="outline-btn" btnIcon="fas fa-reply"}
            {/if}

            <div class="products">
                <div class="row row-eq-height">
                    {foreach $addons as $num => $addon}
                    <div class="col-md-6">
                        <div class="product addon-package" id="product{$num}">
                            <form method="post" action="{$smarty.server.PHP_SELF}?a=add" class="form-inline">
                                <input type="hidden" name="aid" value="{$addon.id}" />
                                <h5>{$addon.name}</h5>

                                <div class="product-pricing">
                                    {if $addon.free}
                                        {$LANG.orderfree}
                                    {else}
                                        <span class="price">{$addon.recurringamount} {$addon.billingcycle}</span>
                                        {if $addon.setupfee}<br />+ {$addon.setupfee} {$LANG.ordersetupfee}{/if}
                                    {/if}
                                </div>

                                <div class="product-desc">
                                    <p>{$addon.description|nl2br}</p>
                                </div>
                                <div class="select-group">
                                    <div class="input-group">
                                        <select name="productid" id="inputProductId{$num}" class="form-control">
                                            {foreach $addon.productids as $product}
                                                <option value="{$product.id}">
                                                    {$product.product}{if $product.domain} - {$product.domain}{/if}
                                                </option>
                                            {/foreach}
                                        </select>
                                    </div>
                                </div>
                                <div class="package-footer">
                                    <button type="submit" class="btn primary-solid-btn">
                                        {$LANG.ordernowbutton}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    {if $num % 2 != 0}
                </div>
                <div class="row row-eq-height">
                    {/if}
                    {/foreach}
                </div>
            </div>
        </div>
    </div>
</div>
