{include file="orderforms/kohost_professional/common.tpl"}

<div id="order-standard_cart">
    <div class="row">
        <div class="cart-sidebar">
            {include file="orderforms/kohost_professional/sidebar-categories.tpl"}
        </div>
        <div class="cart-body">
            <div class="header-lined">
                <h2 class="font-size-24">
                    {$LANG.thereisaproblem}
                </h2>
            </div>
            {include file="orderforms/kohost_professional/sidebar-categories-collapsed.tpl"}

            <div class="alert alert-danger error-heading">
                <i class="fas fa-exclamation-triangle"></i>
                {$errortitle}
            </div>

            <div class="row">
                <div class="col-sm-8 col-sm-offset-2 offset-2">

                    <p class="margin-bottom">{$errormsg}</p>

                    <div class="text-center">
                        <a href="javascript:history.go(-1)" class="btn outline-btn">
                            <i class="fas fa-arrow-left"></i>&nbsp;
                            {$LANG.problemgoback}
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
