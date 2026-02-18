{if $days}<div>{$MGLANG->T('Days')}: <code>{$days}</code></div>{/if}
{if $pages}<div>{$MGLANG->T('Pages')}: <code>{$pages}</code></div>{/if}
{if $notLogged}<div>{$MGLANG->T('Non-logged')}: <code>{$notLogged}</code></div>{/if}
{if $logged}<div>{$MGLANG->T('Logged')}: <code>{$logged}</code></div>{/if}
{if $languages}<div>{$MGLANG->T('Languages')}: <code>{$languages}</code></div>{/if}
{if $userGroups}<div>{$MGLANG->T('User Groups')}: <code>{$userGroups}</code></div>{/if}
{if $products}<div>{$MGLANG->T('Products')}: <code>{$products}</code></div>{/if}
{if $hasProducts}<div>{$MGLANG->T('Have No Products')}: <code>{$hasProducts}</code></div>{/if}
{if $productGroup}<div>{$MGLANG->T('Product Groups')}: <code>{$productGroup}</code></div>{/if}
{if $addons}<div>{$MGLANG->T('Addons')}: <code>{$addons}</code></div>{/if}
{if $hasAddons}<div>{$MGLANG->T('Have No Addons')}: <code>{$hasAddons}</code></div>{/if}
{if $domains}<div>{$MGLANG->T('Domains')}: <code>{$domains}</code></div>{/if}
{if $hasDomains}<div>{$MGLANG->T('Have No Domains')}: <code>{$hasDomains}</code></div>{/if}
{if $servers}<div>{$MGLANG->T('Servers')}: <code>{$servers}</code></div>{/if}
{if $invoiceToPay}<div>{$MGLANG->T('noPayInvoice')}: <code>{$invoiceToPay}</code></div>{/if}
{if $urlContains}<div>{$MGLANG->T('urlContains')}: <code>{$urlContains}</code></div>{/if}
{if $dueDateRestrictions}
    <div><b>{$MGLANG->T('Due Date Restrictions')}:</b></div>
    {if $dueDateRestrictions.types} 
        <div>{$MGLANG->T('Types')}:
            {foreach from=$dueDateRestrictions.types item=type}
                <code>{$type}</code>
            {/foreach}
        </div>
    {/if}
    {if $dueDateRestrictions.conditions} 
        <div>{$MGLANG->T('Conditions')}:
            {foreach from=$dueDateRestrictions.conditions item=condition}
                <code>{$condition}</code>
            {/foreach}
        </div>
    {/if}
    {if $dueDateRestrictions.days}  <div>{$MGLANG->T('Days')}:<code>{$dueDateRestrictions.days}</code></div>{/if}

    {if $dueDateRestrictions.products} 
        <div>{$MGLANG->T('Product Services')}:
            {foreach from=$dueDateRestrictions.products item=products}
                <code>{$products}</code>
            {/foreach}
        </div>
    {/if}
    {if $dueDateRestrictions.services} 
        <div>{$MGLANG->T('Services')}:<code>{$dueDateRestrictions.services}</code></div>
    {/if}
    {if $dueDateRestrictions.addons} 
        <div>{$MGLANG->T('Addon Services')}:
            {foreach from=$dueDateRestrictions.addons item=addons}
                <code>{$addons}</code>
            {/foreach}
        </div>
    {/if}
    {if $dueDateRestrictions.domains} 
        <div>{$MGLANG->T('Domain Services')}:
            {foreach from=$dueDateRestrictions.domains item=domains}
                <code>{$domains}</code>
            {/foreach}
        </div>
    {/if}
    {if $dueDateRestrictions.servicesStatus} 
        <div>{$MGLANG->T('Services Status')}:
            {foreach from=$dueDateRestrictions.servicesStatus item=servicesStatus}
                <code>{$servicesStatus}</code>
            {/foreach}
        </div>
    {/if}
{/if}