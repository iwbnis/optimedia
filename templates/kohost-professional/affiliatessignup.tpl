{if $affiliatesystemenabled}
    <div class="custom-card-block affliate-sign-up mb-20">

        {include file="$template/includes/alert.tpl" type="info" title=$LANG.affiliatesignuptitle msg=$LANG.affiliatesignupintro|cat:'<br/>' textcenter=false}

        <ul>
            <li>{$LANG.affiliatesignupinfo1}</li>
            <li>{$LANG.affiliatesignupinfo2}</li>
            <li>{$LANG.affiliatesignupinfo3}</li>
        </ul>

    </div>

    <form method="post" action="affiliates.php">
        <input type="hidden" name="activate" value="true" />
        <p><input type="submit" value="{$LANG.affiliatesactivate}" class="btn primary-solid-btn" /></p>
    </form>

{else}
    {include file="$template/includes/alert.tpl" type="warning" msg=$LANG.affiliatesdisabled textcenter=true}
{/if}
