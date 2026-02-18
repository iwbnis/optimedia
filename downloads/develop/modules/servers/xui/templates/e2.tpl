<h3>{$translate_e2_desc}</h3>
<hr>
<div class="row">
	{if $e2}
		<div class="col-sm-6">
			<label for="currentMAC" class="control-label">{$translate_current_e2}</label>
			<input class="form-control" width="25" type="text" id="currentMAC" name="currentMAC" value="{$e2}" disabled />
			<form method="post" action="clientarea.php?action=productdetails">
				<label for="MAC" class="control-label">{$translate_new_e2}</label>
				<input class="form-control" maxlength="17" size="17" type="text" id="new_e2_mac" name="new_e2_mac" value="00:11:22:33:44:55" />
				<input type="hidden" name="customAction" value="change_e2_mac" />
				<button type="submit" class="btn btn-default btn-block">
					{$translate_change_e2_button}
				</button>
		</div>
		{else}
		<div class="col-sm-6">
			<label for="currentMAC" class="control-label">{$translate_current_e2}</label>
			<input class="form-control" width="25" type="text" id="currentMAC" name="currentMAC" value="None" disabled />
			<form method="post" action="clientarea.php?action=productdetails">
				<label for="MAC" class="control-label">{$translate_new_e2}</label>
				<input class="form-control" maxlength="17" size="17" type="text" id="new_e2_mac" name="new_e2_mac" value="00:11:22:33:44:55" />
				<input type="hidden" name="customAction" value="add_e2" />
				<button type="submit" class="btn btn-default btn-block">
					{$translate_add_e2_button}
				</button>
		</div>
		{/if}
</div>
<hr>
<!--div class="row">
		<div class="col-sm-4">
			<form method="post" action="clientarea.php?action=productdetails">
				<input type="hidden" name="id" value="{$serviceid}" />
				<input type="hidden" name="customAction" value="overview" />
				<button type="submit" class="btn btn-default btn-block">
					<i class="fa fa-arrow-circle-left"></i>
					Back to Overview
				</button>
				</form>
			
		</div>
	</div--!>