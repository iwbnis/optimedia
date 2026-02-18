{$debug}
<h2>{$translate_service_details}</h2>

<p>Here you can see details related to iptv service.</p>


<hr>

<div class="row">
    <div class="col-sm-5">
        {$translate_product_service}
    </div>
    <div class="col-sm-7">
        {$groupname} - {$product}
    </div>
</div>
{if ($moduleParams['configoption1'] != "MAG") }
	<div class="row">
		<div class="col-sm-5">
			{$translate_username}
		</div>
		<div class="col-sm-7">
			{$extraVariable1}
		</div>
	</div>
	<div class="row">
		<div class="col-sm-5">
			{$translate_password}
		</div>
		<div class="col-sm-7">
			{$extraVariable2}
		</div>
	</div>
{/if}
<!-- Reseller panel link -->
{if ($moduleParams['configoption1'] == "Reseller Account") }
<div class="row">
    <div class="col-sm-5">
        {$translate_reseller_panel}
    </div>
    <div class="col-sm-7">
                <a href="{$reseller_link}">Enter</a>
    </div>
</div>
{/if}
<!--- ISP LOCK -->
{if !empty($isplock)}
<div class="row">
    <div class="col-sm-5">
        {$translate_isplock}
    </div>
    <div class="col-sm-7">
        {$isplock}
    </div>
</div>
{/if}

{if $magAllowed == "Yes"}
	<div class="row">
		<div class="col-sm-5">
			{$translate_mag_portal}
		</div>
		<div class="col-sm-7">
			{$magPortal}
		</div>
	</div>
{/if}

<hr>

<div class="row">
    <div class="col-sm-4">
        <form method="post" action="clientarea.php?action=productdetails">
            <input type="hidden" name="id" value="{$serviceid}" />
            <button type="submit" class="btn btn-default btn-block">
                <i class="fa fa-arrow-circle-left"></i>
                {$translate_back_to_overview}
            </button>
        </form>
    </div>
	{if !empty($isplock)}
	<div class="col-sm-4">
			<form method="post" action="clientarea.php?action=productdetails">
            <input type="hidden" name="id" value="{$serviceid}" />
			<input type="hidden" name="customAction" value="resetisp" />
			
            <button type="submit" class="btn btn-default btn-block">
                <i class="fa fa-refresh" aria-hidden="true"></i>
                {$translate_reset_btn}
            </button>
        </form>
	</div>
	{/if}
</div>
