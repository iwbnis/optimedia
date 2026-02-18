<div class="clear-line-20"></div>
<form method="post" action="{MODURL}&action=save" name="configfrm">
	
		<div id="tab-content admin-tabs">
			<div class="tab-pane active" id="tab5">
			<table class="form" width="100%" border="0" cellspacing="2" cellpadding="3">
				<tr>
					<td class="fieldlabel">Module Enable</td>
					<td class="fieldarea">
						<label class="radio-inline">
							<input type="radio" name="modulestatus" id="modulestatus-yes" value="Y" {if $variables['modulestatus'] == 'Y'} checked="" {/if}> Yes
						</label>
						<label class="radio-inline">
							<input type="radio" name="modulestatus" id="modulestatus-no" value="N" {if $variables['modulestatus'] == 'N'} checked="" {/if}> No
						</label>
					</td>
				</tr>
				<tr>
					<td class="fieldlabel">Email Subject</td>
					<td class="fieldarea">
						<input type="text" name="emailsubject" value="{$variables['emailsubject']}" class="form-control input-inline input-300" />
					</td>
				</tr>
				<tr>
					<td class="fieldlabel">Email Content</td>
					<td class="fieldarea">
						<textarea name="emailcontent" rows="5" class="form-control bottom-margin-5">{$variables['emailcontent']}</textarea>
						use {literal}{CODE}{/literal} in message, to mention code in message.<br>
						ex. code = "123456"<br>
						Message = "Your verification code is {literal}{CODE}{/literal}."<br>
						will be shown as <br>
						Your verification code is <b>123456</b>.
					</td>
				</tr>
				
				 
				<tr>
					<td class="fieldlabel">Emails From Name</td>
					<td class="fieldarea">
						<input type="text" name="fromname" value="{$variables['fromname']}" class="form-control input-inline input-300" />
					</td>
				</tr>
				 
				<tr>
					<td class="fieldlabel">From Email</td>
					<td class="fieldarea">
						<input type="text" name="fromemail" value="{$variables['fromemail']}" class="form-control input-inline input-400" />
					</td>
				</tr>
				
				<tr>
					<td class="fieldlabel">Checkout validation message</td>
					<td class="fieldarea">
						<input type="text" name="validation_message" value="{$variables['validation_message']}" class="form-control input-inline input-400" />
					</td>
				</tr>
			</table>
		
			</div>
		</div>
	
		<div class="btn-container">
			<input id="saveChanges" type="submit" value="Save Changes" class="btn btn-primary">
			<input type="reset" value="Cancel Changes" class="btn btn-default">
		</div>
	
</form>