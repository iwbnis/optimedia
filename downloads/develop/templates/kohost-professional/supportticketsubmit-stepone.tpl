<div class="sub-heading">
    <h3>Choose Department</h3>
</div>
<p>{$LANG.supportticketsheader}</p>
<div class="row">
    {foreach from=$departments key=num item=department}
        <div class="col-md-6">
            <div class="ticket-departments">
                <a href="{$smarty.server.PHP_SELF}?step=2&amp;deptid={$department.id}">
                    <span><i class="fas fa-envelope"></i></span>
                    <div class="department-info">
                        <span>{$department.name}</span>

                        {if $department.description}
                            <p>{$department.description}</p>
                        {/if}
                    </div>
                </a>
            </div>
        </div>
        {if $num % 2 == true}
            <div class="clearfix"></div>
        {/if}
    {foreachelse}
        {include file="$template/includes/alert.tpl" type="info" msg=$LANG.nosupportdepartments textcenter=true}
    {/foreach}
</div>
