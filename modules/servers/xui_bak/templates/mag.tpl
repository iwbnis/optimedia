<h3>{$translate_mag_desc}</h3>
<hr>
<div class="row">
	{if $mag}
		<div class="col-sm-6">
			<label for="currentMAC" class="control-label">{$translate_current_mag}</label>
			<input class="form-control" width="25" type="text" id="currentMAC" name="currentMAC" value="{$mag}" disabled />
			<form method="post" action="clientarea.php?action=productdetails">
				<label for="MAC" class="control-label">{$translate_new_mag}</label>
				<input class="form-control" maxlength="17" size="17" type="text" id="newMAC" name="newMAC" value="00:1A:79:xx:xx:xx" required/>
				<input type="hidden" name="customAction" value="change_mag_mac" />
				<button type="submit" class="btn btn-default btn-block">
					{$translate_change_mag_button}
				</button>
		</div>
	{else}
		<div class="col-sm-6">
			<label for="currentMAC" class="control-label">{$translate_current_mag}</label>
			<input class="form-control" width="25" type="text" id="currentMAC" name="currentMAC" value="None" disabled />
			<form method="post" action="clientarea.php?action=productdetails">
				<label for="MAC" class="control-label">{$translate_new_mag}</label>
				<input class="form-control" maxlength="17" size="17" type="text" id="newMAC" name="newMAC" value="00:1A:79:xx:xx:xx" required/>
				<input type="hidden" name="customAction" value="add_mag_mac" />
				<button type="submit" class="btn btn-default btn-block">
					{$translate_add_mag_button}
				</button>
		</div>
	{/if}
</div>
<hr>
