{if !empty($success)}
<div class="alert alert-success">
    <p><strong>Success:</strong> {$success}</p>
</div>
{/if}
{if $moduleParams['status'] == 'Terminated' OR $moduleParams['status'] == 'Suspended' OR $moduleParams['status'] == 'Pending'}
	{$disabled = 'Disabled'}
{/if}
<h2>{$translate_overview}</h2>
<p></p>


<h3>{$LANG.clientareaproductdetails}</h3>

<hr>


<div class="row">
    <div class="col-sm-5">
        {$LANG.clientareahostingregdate}
    </div>
    <div class="col-sm-7">
        {$regdate}
    </div>
</div>







{foreach from=$configurableoptions item=configoption}
    <div class="row">
        <div class="col-sm-5">
            {$configoption.optionname}
        </div>
        <div class="col-sm-7">
            {if $configoption.optiontype eq 3}
                {if $configoption.selectedqty}
                    {$LANG.yes}
                {else}
                    {$LANG.no}
                {/if}
            {elseif $configoption.optiontype eq 4}
                {$configoption.selectedqty} x {$configoption.selectedoption}
            {else}
                {$configoption.selectedoption}
            {/if}
        </div>
    </div>
{/foreach}



<div class="row">
    <div class="col-sm-5">
        {$LANG.orderpaymentmethod}
    </div>
    <div class="col-sm-7">
        {$paymentmethod}
    </div>
</div>

<div class="row">
    <div class="col-sm-5">
        {$LANG.firstpaymentamount}
    </div>
    <div class="col-sm-7">
        {$firstpaymentamount}
    </div>
</div>

<div class="row">
    <div class="col-sm-5">
        {$LANG.recurringamount}
    </div>
    <div class="col-sm-7">
        {$recurringamount}
    </div>
</div>

<div class="row">
    <div class="col-sm-5">
        {$LANG.clientareahostingnextduedate}
    </div>
    <div class="col-sm-7">
        {$nextduedate}
    </div>
</div>

<div class="row">
    <div class="col-sm-5">
        {$LANG.orderbillingcycle}
    </div>
    <div class="col-sm-7">
        {$billingcycle}
    </div>
</div>

<div class="row">
    <div class="col-sm-5">
        {$LANG.clientareastatus}
    </div>
    <div class="col-sm-7">
        {$status}
    </div>
</div>

{if $suspendreason}
    <div class="row">
        <div class="col-sm-5">
            {$LANG.suspendreason}
        </div>
        <div class="col-sm-7">
            {$suspendreason}
        </div>
    </div>
{/if}

<hr>
{if ($moduleParams['configoption1'] != "Reseller Credits") }
<div class="row">
    <div class="col-sm-4">
        <form method="post" action="clientarea.php?action=productdetails">
            <input type="hidden" name="id" value="{$serviceid}" />
            <input type="hidden" name="customAction" value="manage" />
            <button type="submit" class="btn btn-default btn-block" {$disabled}>
                {$service_details_btn}
            </button>
        </form>
    </div>

    {if $packagesupgrade}
        <div class="col-sm-4">
            <a href="upgrade.php?type=package&amp;id={$id}" class="btn btn-success btn-block">
                {$LANG.upgrade}
            </a>
        </div>
    {/if}
	{if ($moduleParams['configoption1'] == "Streaming Line" or $moduleParams['configoption1'] == "MAG") }
		<div class="col-sm-4">
			<form method="post" action="clientarea.php?action=productdetails">
				<input type="hidden" name="id" value="{$serviceid}" />
				<input type="hidden" name="customAction" value="devices" />
				<button type="submit" class="btn btn-default btn-block" {$disabled}>
					{$playlists_btn}
				</button>
			</form>
		</div>
	{/if}
	{if ($magAllowed == "Yes")}
		<div class="col-sm-4">
			<form method="post" action="clientarea.php?action=productdetails">
				<input type="hidden" name="id" value="{$serviceid}" />
				<input type="hidden" name="customAction" value="managemag" />
				<button type="submit" class="btn btn-default btn-block" {$disabled}>
					{$mag_btn}
				</button>
			</form>
		</div>
	{/if}
	{if ($e2Allowed == "Yes")}
		<div class="col-sm-4">
			<form method="post" action="clientarea.php?action=productdetails">
				<input type="hidden" name="id" value="{$serviceid}" />
				<input type="hidden" name="customAction" value="managee2" />
				<button type="submit" class="btn btn-default btn-block" {$disabled}>
					{$e2_btn}
				</button>
			</form>
		</div>
	{/if}

 
</div>
{/IF}
