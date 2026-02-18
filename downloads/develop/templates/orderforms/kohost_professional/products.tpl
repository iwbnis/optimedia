{include file="orderforms/kohost_professional/common.tpl"}

<div id="order-standard_cart">
    <div class="row">
        <div class="cart-sidebar sidebar">
            {include file="orderforms/kohost_professional/sidebar-categories.tpl"}
        </div>
        <div class="cart-body">
            <div class="header-lined">
                <h2 class="font-size-24">
                    {if $productGroup.headline}
                        {$productGroup.headline}
                    {else}
                        {$productGroup.name}
                    {/if}
                </h2>
                {if $productGroup.tagline}
                    <p>{$productGroup.tagline}</p>
                {/if}
            </div>
            {if $errormessage}
                <div class="alert alert-danger">
                    {$errormessage}
                </div>
            {elseif !$productGroup}
                <div class="alert alert-info">
                    {lang key='orderForm.selectCategory'}
                </div>
            {/if}

            {include file="orderforms/standard_cart/sidebar-categories-collapsed.tpl"}

            <div class="products" id="products">
                <div class="row row-eq-height">
                    {foreach $products as $key => $product}
                        <div class="col-lg-4 col-md-4 col-sm-6 col-4">
                            <div class="products price-table card text-center single-pricing-pack {if $product.isFeatured == true}popular-price{/if}" id="product{$product@iteration}">
                                <header class="pricing-header">
                                    <h5 id="product{$product@iteration}-name">{$product.name}
                                        {if $product.tagLine}
                                            <p id="product{$product@iteration}-tag-line">{$product.tagLine}</p>
                                        {/if}
                                        {if $product.stockControlEnabled}
                                            <span class="qty">
                                                    {$product.qty} {$LANG.orderavailable}
                                                </span>
                                        {/if}
                                    </h5>
                                    {if $product.isFeatured}
                                        <div class="feature-badge">
                                            <span class="badge">{$LANG.featuredProduct|upper}</span>
                                        </div>
                                    {/if}
                                    <div class="product-pricing" id="product{$product@iteration}-price">
                                        {if $product.bid}
                                            {$LANG.bundledeal}<br />
                                            {if $product.displayprice}
                                                <span class="price">{$product.displayprice}</span>
                                            {/if}
                                        {else}
                                            {if $product.pricing.hasconfigoptions}
                                                <p class="mb-4">{$LANG.startingfrom}</p>
                                            {/if}
                                            <span class="price">{$product.pricing.minprice.price}</span>
                                            <br/>
                                            {if $product.pricing.minprice.cycle eq "monthly"}
                                                {$LANG.orderpaymenttermmonthly}
                                            {elseif $product.pricing.minprice.cycle eq "quarterly"}
                                                {$LANG.orderpaymenttermquarterly}
                                            {elseif $product.pricing.minprice.cycle eq "semiannually"}
                                                {$LANG.orderpaymenttermsemiannually}
                                            {elseif $product.pricing.minprice.cycle eq "annually"}
                                                {$LANG.orderpaymenttermannually}
                                            {elseif $product.pricing.minprice.cycle eq "biennially"}
                                                {$LANG.orderpaymenttermbiennially}
                                            {elseif $product.pricing.minprice.cycle eq "triennially"}
                                                {$LANG.orderpaymenttermtriennially}
                                            {/if}
                                            <br>
                                            {if $product.pricing.minprice.setupFee}
                                                <small>{$product.pricing.minprice.setupFee->toPrefixed()} {$LANG.ordersetupfee}</small>
                                            {/if}
                                        {/if}
                                    </div>
                                </header>
                                <div class="card-body">
                                    <ul class="list-unstyled pricing-feature-list">
                                        {foreach $product.features as $feature => $value}
                                            <li id="product{$product@iteration}-feature{$value@iteration}">
                                                <span>{$value}</span> {$feature}
                                            </li>
                                            {foreachelse}
                                            <li id="product{$product@iteration}-description">
                                                {$product.description}
                                            </li>
                                        {/foreach}
                                    </ul>
                                </div>
                                <footer>

                                    {if $product.qty eq "0"}
                                        <span id="product{$product@iteration}-unavailable" class="order-button unavailable">{$LANG.outofstock}</span>
                                    {else}
                                        <a href="{$WEB_ROOT}/cart.php?a=add&amp;{if $product.bid}bid={$product.bid}{else}pid={$product.pid}{/if}" class="btn {if $product.isFeatured == true}primary-solid-btn{else}outline-btn{/if}" id="product{$product@iteration}-order-button">
                                           {$LANG.ordernowbutton}
                                        </a>
                                    {/if}
                                </footer>
                            </div>
                        </div>
                    {/foreach}
                </div>
            </div>
        </div>
    </div>
</div>