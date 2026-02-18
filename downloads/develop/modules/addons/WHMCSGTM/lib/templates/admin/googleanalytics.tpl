{include file="includes/navbar.tpl"}
<div class="row">
	<div class="col-sm-6 col-sm-offset-3">
		<div class="panel panel-default">
		  <div class="panel-heading">
			  <h3 class="panel-title">Google Analytics</h3>
		  </div>
		  <div class="panel-body">
			  <div class="row">
				  <div class="col-sm-12">
					  <p class="text-left">Configure your Google Analytics version, property ID and API Secret (v4 only). This configuration allows the use of the Measurement Protocol to record purchases and refunds offline (without user interaction). <a href="https://manage.mimirtech.co/link.php?id=49" target="_blank"><span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span></a> </p>
					  <div class="alert alert-info text-left">
						  Please <strong>use the same Tracking Id</strong> that you have configured on your container. Using a different Google Analytics Tracking Id can cause tracking inconsistency.
					  </div>
				  </div>
			  </div>

				<div class="row">
				  <div class="col-sm-12 text-center">
						<form id="whmcs_gtml" class="form-horizontal" name="whmcs_gtml" method="post" action="{$action}">
							<div class="form-group">
								<label class="col-sm-4 control-label" for="ga_version">Google Analytics Version</label>
								<div class="col-sm-4">
									<select class="form-control" name="ga_version" id="ga_version" required onchange="checkGaVersion(this)">
										<option value="3" {if $ga_version == '3'}selected{/if}>Google Analytics UA (v3)</option>
										<option value="4" {if $ga_version == '4'}selected{/if}>Google Analytics 4</option>
									</select>
								</div>
							</div>
								<div class="form-group">
									<label for="ga_trackingid" class="col-sm-4 control-label" id="gaTrackingIdLabel">{if $ga_version == '4'}MEASUREMENT ID{else}PROPERTY ID{/if}</label>
									<div class="col-sm-4">
										<input type="text" name="ga_trackingid" id="ga_trackingid" class="form-control" value="{$ga_trackingid}" placeholder="{if $ga_version == '4'}G-XXXXXXXXXX{else}UA-XXXXXX-X{/if}" required>
									</div>
								</div>

							<div class="form-group" id="apiSecretDiv">
								<label for="ga_apisecret" class="col-sm-4 control-label">API SECRET</label>
								<div class="col-sm-4">
									<input type="text" name="ga_apisecret" id="ga_apisecret" class="form-control" value="{$ga_apisecret}" placeholder="05z9ppRjTKiF79rhKq8YUg" required>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-6 col-sm-offset-3">
									<button type="submit" class="btn btn-primary btn-lg btn-block">Save</button>
								</div>
							</div>
						</form>

				  </div>
				</div>
				<div class="clearfix">

				</div>
		  </div>
		</div>
	</div>
</div>

<script>

	var gaVersion = {if $ga_version eq ''}null{else}{$ga_version}{/if};
	{literal}
			if (gaVersion !== 4) {
				$("#ga_apisecret").removeAttr("required").val('');
				$("#apiSecretDiv").hide();
			}
			function checkGaVersion(selectObject) {
				var value = selectObject.value;

				if (value === '4') {
					$("#apiSecretDiv").show();
					$("#ga_trackingid").val('');
					$("#ga_trackingid").attr("placeholder", "G-XXXXXXXXXX");
					$("#gaTrackingIdLabel").text("MEASUREMENT ID");
				}
				if (value === '3') {
					$("#ga_apisecret").removeAttr("required").val('');
					$("#apiSecretDiv").hide();
					$("#ga_trackingid").val('');
					$("#ga_trackingid").attr("placeholder", "UA-XXXXXX-X");
					$("#ga_apisecret").val('');
					$("#gaTrackingIdLabel").text("PROPERTY ID");
				}
			}
	{/literal}




</script>