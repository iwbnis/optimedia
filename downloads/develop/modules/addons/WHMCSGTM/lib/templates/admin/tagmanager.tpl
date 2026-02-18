{include file="includes/navbar.tpl"}
<div class="row">
	<div class="col-sm-6 col-sm-offset-3">
		<div class="panel panel-default">
		  <div class="panel-heading">
		    <h3 class="panel-title">Google Tag Manager</h3>
		  </div>
		  <div class="panel-body">
				<div class="row">
				  <div class="col-sm-12">
						<p>Configure the Google Tag Manager Container ID to enable the container on WHMCS pages. <a href="https://manage.mimirtech.co/link.php?id=50" target="_blank"><span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span></a></p>
				  </div>
				</div>

				    	<div class="row">
				    	  <div class="col-sm-12 text-center">
									<form id="whmcs_gtml" class="form-horizontal" name="whmcs_gtml" method="post" action="{$action}">
											<div class="form-group">
												<label for="gtm_container" class="col-sm-4 control-label">Container ID</label>
												<div class="col-sm-4">
												<input type="text" name="gtm_container" id="gtm_container" class="form-control" value="{$gtm_container}" placeholder="GTM-XXXXXX" required>

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


		  </div>
		</div>
	</div>
</div>
