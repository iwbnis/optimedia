<style>
.swal2-container {
  z-index: 9999999999 !important;
}
</style>
<div class="card">
	<div class="card-body">
		<form class="form-horizontal" autocomplete="off" method="post" action=""  enctype="multipart/form-data" id="setting-form">
			<div class="row">
				<div class="col-sm-12">
					<ul class="nav nav-pills nav-stacked setting-nnnav" role="tablist">
						<li class="nav-item">
							<a class="nav-link active show" data-toggle="tab" href="#site-setting" role="tab">
								<?= __('admin.site_setting') ?></a>
						</li>
						<li class="nav-item">
							<a class="nav-link" data-toggle="tab" href="#email-setting" role="tab">
								<?= __('admin.email_setting') ?></a>
						</li>
						<li class="nav-item">
							<a class="nav-link" data-toggle="tab" href="#tnc-page" role="tab">
								<?= __('admin.terms_and_condition') ?></a>
						</li>
						<li class="nav-item">
							<a class="nav-link" data-toggle="tab" href="#tracking" role="tab">
								<?= __('admin.tracking') ?></a>
						</li>
						<li class="nav-item">
							<a class="nav-link" data-toggle="tab" href="#googlerecaptcha-setting" role="tab">
								<?= __('admin.googlerecaptcha') ?></a>
						</li>

						<li class="nav-item">
							<a class="nav-link" data-toggle="tab" href="#cron_jobs-setting" role="tab">
								<?= __('admin.cron_jobs') ?></a>
						</li>

						<li class="nav-item">
							<a class="nav-link" data-toggle="tab" href="#user-dashboard-setting" role="tab">
								<?= __('admin.user_dashboard') ?></a>
						</li>
					</ul>
				</div>
				<div class="col-sm-12">
					<div class="tab-content">
						<?php if($this->session->flashdata('success')){?>
							<div class="alert alert-success alert-dismissable"> <?php echo $this->session->flashdata('success'); ?> </div>
						<?php } ?>
						<div class="tab-pane p-3" id="cron_jobs-setting" role="tabpanel">
							<div class="row">
								<div class="col-sm-6">
									<h5><?= __('admin.what_is_cron_job') ?></h5>
									<p><?= __('admin.what_is_cron_job_answer') ?></p>

									<h6><?= __('admin.to_add_cron_job_steps') ?>:</h6>

									<ol>
										<li><?= __('admin.to_add_cron_job_step1') ?></li>
										<li><?= __('admin.to_add_cron_job_step2') ?></li>
										<li><?= __('admin.to_add_cron_job_step3') ?></li>
										<li><?= __('admin.to_add_cron_job_step4') ?>  <b><?= __('admin.once_per_minute') ?>(* * * * *)</b>.</li>
										<li><?= __('admin.to_add_cron_job_step5') ?> <div> <code>curl <?= base_url('/cronJob/transaction') ?></code></div> </li>
										<li><?= __('admin.to_add_cron_job_step6') ?></li>
									</ol>
								</div>
								<div class="col-sm-6">
									<img src="<?= base_url('assets/images/cronjob.png') ?>" class='img-responsive'>
								</div>
							</div>
						</div>

						<div class="tab-pane p-3" id="user-dashboard-setting" role="tabpanel">
								<div class="form-group">
									<label  class="control-label"><?= __('admin.top_affiliate') ?></label>
									<select class="form-control" name="userdashboard[top_affiliate]">
										<option value="0"><?= __('admin.disable') ?></option>
										<option value="1" <?= $userdashboard['top_affiliate'] ? 'selected' : '' ?>><?= __('admin.enable') ?></option>
									</select>
								</div>
						</div>

						<div class="tab-pane p-3 active show" id="site-setting" role="tabpanel">
							<div class="form-group">
								<label  class="control-label"><?= __('admin.website_name') ?></label>
								<input name="site[name]" value="<?php echo $site['name']; ?>" class="form-control" type="text">
							</div>
							<div class="form-group">
								<label  class="control-label"><?= __('admin.front_site_maintainance_mode') ?></label>
								<select class="form-control" name="site[maintenance_mode]">
									<option value="0"><?= __('admin.disable') ?></option>
									<option value="1" <?= $site['maintenance_mode'] ? 'selected' : '' ?>><?= __('admin.enable') ?></option>
								</select>
							</div>
							<div class="form-group">
								<label  class="control-label"><?= __('admin.store_maintenance_mode') ?></label>
								<select class="form-control" name="site[store_maintenance_mode]">
									<option value="0"><?= __('admin.disable') ?></option>
									<option value="1" <?= $site['store_maintenance_mode'] ? 'selected' : '' ?>><?= __('admin.enable') ?></option>
								</select>
							</div>
							<div class="form-group">
								<label class="control-label"><?= __('admin.registration_form') ?></label>
								<select class="form-control" name="store[registration_status]">
									<option value="1" <?= ($store['registration_status'] == 1) ? 'selected' : '' ?>>
										<?= __('admin.enable_affiliate_vendor_registration') ?>
									</option>
									<option value="0" <?= ($store['registration_status'] == 0) ? 'selected' : '' ?>>
										<?= __('admin.disable_affiliate_vendor_registration') ?>
										</option>
									<option value="2" <?= ($store['registration_status'] == 2) ? 'selected' : '' ?>>
										<?= __('admin.disable_affiliate_registration') ?>
									</option>
									<option value="3" <?= ($store['registration_status'] == 3) ? 'selected' : '' ?>>
										<?= __('admin.disable_vendor_registration') ?>
									</option>
								</select>
							</div>
							<div class="form-group">
								<label class="control-label"><?= __('admin.approval_for_registration') ?></label>
								<select class="form-control" name="store[registration_approval]">
									<option value="1"><?= __('admin.enable') ?></option>
									<option value="0" <?= (isset($store['registration_approval']) && $store['registration_approval'] == 0) ? 'selected' : '' ?> ><?= __('admin.disable') ?></option>
								</select>
							</div>
							<div class="form-group">
								<label  class="control-label"><?= __('admin.notification_email') ?></label>
								<input name="site[notify_email]" value="<?php echo $site['notify_email']; ?>" class="form-control" type="email">
							</div>

							<div class="form-group">
								<label  class="control-label"><?= __('admin.session_timeout_timing_in_seconds') ?></label>
								<input  name="site[session_timeout]" value="<?php echo $site['session_timeout']; ?>" class="form-control" placeholder="<?= __('admin.default_timeout_is_1800_seconds') ?>" onkeypress="return isNumeric(event)" oninput="maxLengthCheck(this)" type="number" maxlength="6" min = "1" max = "999999">
							</div>

							<div class="form-group">
								<label  class="control-label"><?= __('admin.user_session_timeout_timing_in_seconds') ?></label>
								<input  name="site[user_session_timeout]" value="<?php echo $site['user_session_timeout']; ?>" class="form-control" placeholder="<?= __('admin.default_timeout_is_1800_seconds') ?>" onkeypress="return isNumeric(event)" oninput="maxLengthCheck(this)" type="number" maxlength="6" min = "1" max = "999999">
							</div>

							<div class="form-group">
								<label  class="control-label"><?= __('admin.footer_text') ?></label>
								<input name="site[footer]" value="<?php echo $site['footer']; ?>" class="form-control" type="text">
							</div>
							<?php
								$zones_array = array();
								$timestamp = time();
								foreach(timezone_identifiers_list() as $key => $zone) {
									date_default_timezone_set($zone);
									$zones_array[$zone] = date('P', $timestamp) . " {$zone} ";
								}
							?>
							<div class="form-group">
								<label  class="control-label"><?= __('admin.time_zone') ?></label>
								<select class="form-control select2-input" name="site[time_zone]">
									<?php foreach ($zones_array as $key => $value) { ?>
										<option value="<?= $key ?>" <?= $site['time_zone'] == $key ? 'selected' : '' ?> > <?= $value ?></option>
									<?php } ?>
								</select>
							</div>

							<div class="row">
								<div class="col-sm-12">
									<div class="form-group">
										<label class="control-label"><?= __('admin.show_language_dropdown') ?></label>
										<select class="form-control" name="store[language_status]">
											<option value="0"><?= __('admin.disable') ?></option>
											<option value="1" <?= $store['language_status'] ? 'selected' : '' ?>><?= __('admin.enable') ?></option>
										</select>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-sm-12">
									<div class="form-group">
										<label class="control-label"><?= __('admin.hide_currency_from') ?></label>
										<br/>

										<?php

										$hcf = [];

										if(isset($site['hide_currency_from']) && !empty($site['hide_currency_from'])) {
											$hcf = explode(',', $site['hide_currency_from']);
										}

										?>

										<label class="checkbox-inline"><input type="checkbox" name="site[hide_currency_from][]" value="admin" <?= (in_array('admin', $hcf)) ? "checked" : ""; ?>>&nbsp;&nbsp;<?= __('admin.admin_dashboard') ?></label>
										&nbsp;&nbsp;&nbsp;

										<label class="checkbox-inline"><input type="checkbox" name="site[hide_currency_from][]" value="user" <?= (in_array('user', $hcf)) ? "checked" : ""; ?>>&nbsp;&nbsp;<?= __('admin.user_dashboard') ?></label>

									</div>
								</div>
							</div>								


							<fieldset>
								<legend><?= __('admin.admin_side_logo') ?></legend>
								<div class="row">
									<div class="col-sm-2">
										<div class="fileUpload btn btn-sm btn-primary">
											<span><?= __('admin.choose_file') ?></span>
											<input name="site_admin-side-logo" class="upload" type="file" onchange="readURLAndSetValue(this,'site[admin-side-logo]','#admin-side-logo')">
										</div>
										<p class="logo-info-text"><?= __('admin.admin_side_logo_recommended_size') ?></p>
									</div>
									<div class="col-sm-10">
										<input type="hidden" name="site[admin-side-logo]" value="<?= $site['admin-side-logo'] ?>">
										<?php $admin_side_logo = $site['admin-side-logo'] ? base_url('assets/images/site/'. $site['admin-side-logo']) : base_url('assets/vertical/assets/images/no_image_yet.png'); ?>

										<img id="admin-side-logo" class='img-responsive_setting' src="<?= $admin_side_logo ?>" style="width: 150px;">

										<?php if($site['admin-side-logo']) { ?>
											<span class="btn btn-sm btn-danger btn-delete-image" data-img_input="site[admin-side-logo]" data-img_ele="admin-side-logo" data-img_placeholder="<?= base_url('assets/vertical/assets/images/no_image_yet.png');?>"><i class="fa fa-trash"></i></span>
										<?php } ?>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-4">
										<div class="form-group">
											<label  class="control-label"><?= __('admin.site_setting_logo_custom_size') ?></label>
											<select name="site[custom_logo_size]" class="form-control">
												<option value="0"><?= __('admin.disable') ?></option>
												<option <?php echo ($site['custom_logo_size'] == 1) ? "selected" :""; ?> value="1"><?= __('admin.user_dashboard') ?></option>
											</select>
										</div>
									</div>
									<div class="col-sm-4 logo_cust_size_inp" <?php echo ($site['custom_logo_size'] != 1) ? 'style="display:none;"':""; ?>>
										<div class="form-group">
										<label  class="control-label"><?= __('admin.site_setting_logo_height') ?></label>
										<input name="site[log_custom_height]" value="<?php echo $site['log_custom_height']; ?>" class="form-control" type="number">
										</div>
									</div>
									<div class="col-sm-4 logo_cust_size_inp" <?php echo ($site['custom_logo_size'] != 1) ? 'style="display:none;"' :""; ?>>
										<div class="form-group">
										<label  class="control-label"><?= __('admin.site_setting_logo_width') ?></label>
										<input name="site[log_custom_width]" value="<?php echo $site['log_custom_width']; ?>" class="form-control" type="number">
										</div>
									</div>
									<script type="text/javascript">
										$(document).on('change', 'select[name="site[custom_logo_size]"]', function() {
												if($(this).val() == 1) {
													$('.logo_cust_size_inp').show();
												} else {
													$('.logo_cust_size_inp').hide();
												}
										});
									</script>
								</div>
							</fieldset>
							<br>
							<fieldset>
								<legend><?= __('admin.front_side_themes_logo') ?></legend>
								<div class="row">
									<div class="col-sm-2">
										<div class="fileUpload btn btn-sm btn-primary">
											<span><?= __('admin.choose_file') ?></span>
											<input name="site_front-side-themes-logo" class="upload" type="file" onchange="readURLAndSetValue(this,'site[front-side-themes-logo]','#front-side-themes-logo')">
										</div>
										<p class="logo-info-text"><?= __('admin.front_side_themes_logo_recommended_size') ?></p>
									</div>
									<div class="col-sm-10">
										<input type="hidden" name="site[front-side-themes-logo]" value="<?= $site['front-side-themes-logo'] ?>">

										<?php $front_side_themes_logo = $site['front-side-themes-logo'] ? base_url('assets/images/site/'. $site['front-side-themes-logo']) : base_url('assets/vertical/assets/images/no_image_yet.png'); ?>

										<img id="front-side-themes-logo" class='img-responsive_setting' src="<?= $front_side_themes_logo ?>" style="width: 150px;">

										<?php if($site['front-side-themes-logo']) { ?>
											<span class="btn btn-sm btn-danger btn-delete-image" data-img_input="site[front-side-themes-logo]" data-img_ele="front-side-themes-logo" data-img_placeholder="<?= base_url('assets/vertical/assets/images/no_image_yet.png');?>"><i class="fa fa-trash"></i></span>
										<?php } ?>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-4">
										<div class="form-group">
											<label  class="control-label"><?= __('admin.site_setting_logo_custom_size') ?></label>
											<select name="site[front_custom_logo_size]" class="form-control">
												<option value="0"><?= __('admin.disable') ?></option>
												<option <?php echo ($site['front_custom_logo_size'] == 1) ? "selected" :""; ?> value="1"><?= __('admin.front_side_themes') ?></option>
											</select>
										</div>
									</div>
									<div class="col-sm-4 front_logo_cust_size_inp" <?php echo ($site['front_custom_logo_size'] != 1) ? 'style="display:none;"':""; ?>>
										<div class="form-group">
										<label  class="control-label"><?= __('admin.site_setting_logo_height') ?></label>
										<input name="site[front_log_custom_height]" value="<?php echo $site['front_log_custom_height']; ?>" class="form-control" type="number">
										</div>
									</div>
									<div class="col-sm-4 front_logo_cust_size_inp" <?php echo ($site['front_custom_logo_size'] != 1) ? 'style="display:none;"' :""; ?>>
										<div class="form-group">
										<label  class="control-label"><?= __('admin.site_setting_logo_width') ?></label>
										<input name="site[front_log_custom_width]" value="<?php echo $site['front_log_custom_width']; ?>" class="form-control" type="number">
										</div>
									</div>
									<script type="text/javascript">
										$(document).on('change', 'select[name="site[front_custom_logo_size]"]', function() {
												if($(this).val() == 1) {
													$('.front_logo_cust_size_inp').show();
												} else {
													$('.front_logo_cust_size_inp').hide();
												}
										});
									</script>
								</div>
							</fieldset>
							<br>
							<fieldset>
								<legend><?= __('admin.website_favicon') ?></legend>
								<div class="row">
									<div class="col-sm-2">
										<div class="fileUpload btn btn-sm btn-primary">
											<span><?= __('admin.choose_file') ?></span>
											<input name="site_favicon" class="upload" type="file" onchange="readURLAndSetValue(this,'site[favicon]','#site-favicon')">
										</div>
									</div>
									<div class="col-sm-10">
										<input type="hidden" name="site[favicon]" value="<?= $site['favicon'] ?>">
										<?php $img = $site['favicon'] ? base_url('assets/images/site/'. $site['favicon']) : base_url('assets/vertical/assets/images/no_image_yet.png'); ?>
										
										<img id='site-favicon' class='img-responsive_setting' src="<?= $img ?>" style="width: 150px;">

										<?php if($site['favicon']) { ?>
											<span class="btn btn-sm btn-danger btn-delete-image" data-img_input="site[favicon]" data-img_ele="site-favicon" data-img_placeholder="<?= base_url('assets/vertical/assets/images/no_image_yet.png');?>"><i class="fa fa-trash"></i></span>
										<?php } ?>
									</div>
								</div>
							</fieldset>
							<br>	
							<fieldset>
								<legend><?= __('admin.meta_tag') ?></legend>
								<div class="form-group">
									<label  class="control-label"><?= __('admin.description') ?></label>
									<input name="site[meta_description]" value="<?php echo $site['meta_description']; ?>" class="form-control" type="text">
								</div>
								<div class="form-group">
									<label  class="control-label"><?= __('admin.keywords') ?></label>
									<input name="site[meta_keywords]" value="<?php echo $site['meta_keywords']; ?>" class="form-control" type="text">
								</div>
								<div class="form-group">
									<label  class="control-label"><?= __('admin.author') ?></label>
									<input name="site[meta_author]" value="<?php echo $site['meta_author']; ?>" class="form-control" type="text">
								</div>
							</fieldset>
							
							<br>
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<label class="control-label"><?= __('admin.google_analytics_for_site_page') ?></label>
										<textarea rows="8" name="site[google_analytics]" class="form-control site-google_analytics"><?php echo $site['google_analytics']; ?></textarea>

										<a href="https://support.google.com/analytics/answer/1008080?hl=en" target="_blank"><?= __('admin.get_analytics_code') ?></a>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label class="control-label"><?= __('admin.example') ?></label>
										<img class="img-responsive_setting w-100" src="<?= base_url('assets/images/google_analytics.png') ?>">
									</div>
								</div>
							</div>

							<br>
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<label class="control-label"><?= __('admin.faceboook_pixel_for_site_page') ?></label>
										<textarea rows="8" name="site[faceboook_pixel]" class="form-control site-faceboook_pixel"><?php echo $site['faceboook_pixel']; ?></textarea>

										<a href="https://developers.facebook.com/docs/facebook-pixel/implementation" target="_blank"><?= __('admin.get_facebook_pixel_code') ?></a>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label class="control-label"><?= __('admin.example') ?></label>
										<img class="img-responsive_setting w-100" src="<?= base_url('assets/images/faceboook_pixel.png') ?>">
									</div>
								</div>
							</div>
							<br>

							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<label class="control-label"><?= __('admin.facebook_chat_plugin_script') ?></label>
										<textarea rows="8" name="site[fbmessager_script]" class="form-control site-fbmessager_script"><?php echo $site['fbmessager_script']; ?></textarea>
									</div>
									<?php  $fbmessager_status = (array)json_decode($site['fbmessager_status'],1); ?>
									<div class="form-group">
										<label class="control-label"><?= __('admin.show_facebook_chat_code') ?> :</label>
										<div>
											<div style="display:inline-block;">
												<label>
													<input type="checkbox" <?= in_array('admin', $fbmessager_status) ? 'checked' : '' ?> name="site[fbmessager_status][]" value="admin"> <?= __('admin.option_admin_side') ?>
												</label>
											</div>&nbsp;&nbsp;
											<div style="display:inline-block;">
												<label>
													<input type="checkbox" <?= in_array('affiliate', $fbmessager_status) ? 'checked' : '' ?> name="site[fbmessager_status][]" value="affiliate"> <?= __('admin.option_affiliate_side') ?>
												</label>
											</div>&nbsp;&nbsp;
											<div style="display:inline-block;">
												<label>
													<input type="checkbox" <?= in_array('front', $fbmessager_status) ? 'checked' : '' ?> name="site[fbmessager_status][]" value="front"> <?= __('admin.option_front_side') ?>
												</label>
											</div>&nbsp;&nbsp;
											<div style="display:inline-block;">
												<label>
													<input type="checkbox" <?= in_array('store', $fbmessager_status) ? 'checked' : '' ?> name="site[fbmessager_status][]" value="store"> <?= __('admin.option_store_side') ?>
												</label>
											</div>&nbsp;&nbsp;
										</div>
									</div>
									<a class="mt-2" href="https://developers.facebook.com/docs/messenger-platform/discovery/facebook-chat-plugin/#setup_tool" target="_blank"><?= __('admin.get_facebook_chat_code') ?></a>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label class="control-label"><?= __('admin.example') ?></label>
										<img class="img-responsive_setting w-100" src="<?= base_url('assets/images/fb_chat_script.png') ?>">
									</div>
								</div>
							</div>
							<br>
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<label class="control-label"><?= __('admin.global_script') ?></label>
										<textarea rows="8" name="site[global_script]" class="form-control site-global_script"><?php echo $site['global_script']; ?></textarea>
									</div>
								</div>
								<div class="col-sm-6">
									<?php  $global_script_status = (array)json_decode($site['global_script_status'],1); ?>
									<div class="form-group">
										<label class="control-label"><?= __('admin.show_global_script') ?></label>
										<div>
											<div>
												<label>
													<input type="checkbox" <?= in_array('admin', $global_script_status) ? 'checked' : '' ?> name="site[global_script_status][]" value="admin"> <?= __('admin.option_admin_side') ?>
												</label>
											</div>
											<div>
												<label>
													<input type="checkbox" <?= in_array('affiliate', $global_script_status) ? 'checked' : '' ?> name="site[global_script_status][]" value="affiliate"> <?= __('admin.option_affiliate_side') ?>
												</label>
											</div>
											<div>
												<label>
													<input type="checkbox" <?= in_array('front', $global_script_status) ? 'checked' : '' ?> name="site[global_script_status][]" value="front"> <?= __('admin.option_front_side') ?>
												</label>
											</div>
											<div>
												<label>
													<input type="checkbox" <?= in_array('store', $global_script_status) ? 'checked' : '' ?> name="site[global_script_status][]" value="store"> <?= __('admin.option_store_side') ?>
												</label>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						
						<div class="tab-pane p-3" id="login-2" role="tabpanel">	
						</div>

						<div class="tab-pane p-3" id="email-setting" role="tabpanel">

							<div class="form-group">
								<label class="control-label"><?= __('admin.mail_type') ?></label>
								<select class="form-control" name="email[mail_type]">
									<option value="smtp" <?= $email['mail_type'] == 'smtp' ? 'selected' : '' ?>><?= __('admin.smtp') ?></option>
									<option value="php_mailer" <?= $email['mail_type'] == 'php_mailer' ? 'selected' : '' ?>><?= __('admin.php_mailer') ?></option>
								</select>
							</div>

							<div class="form-group">
								<label  class="control-label"><?= __('admin.from_email') ?></label>
								<input name="email[from_email]" value="<?php echo $email['from_email']; ?>" class="form-control" type="text">
							</div>
							
							<div class="form-group">
								<label  class="control-label"><?= __('admin.from_name') ?></label>
								<input name="email[from_name]" value="<?php echo $email['from_name']; ?>" class="form-control" type="text">
							</div>
							
							<div class="form-group for-smtp-mail">
								<label  class="control-label"><?= __('admin.smtp_hostname') ?></label>
								<input name="email[smtp_hostname]" value="<?php echo $email['smtp_hostname']; ?>" class="form-control" type="text">
							</div>
							<div class="form-group for-smtp-mail">
								<label  class="control-label"><?= __('admin.smtp_username') ?></label>
								<input name="email[smtp_username]" value="<?php echo $email['smtp_username']; ?>" class="form-control" type="text">
							</div>
							
							<div class="form-group for-smtp-mail">
								<label  class="control-label"><?= __('admin.smtp_password') ?></label>
								<div class="input-group password-group">
									
								  	<input readonly="" onfocus="this.removeAttribute('readonly');" onblur="this.setAttribute('readonly','readonly');" autocomplete="off" type="password" class="form-control" name="email[smtp_password]" value="<?php echo $email['smtp_password']; ?>">
								  	<div class="input-group-prepend">
									    <button class="btn btn-outline-secondary" type="button"><i class="fa fa-eye"></i></button>
								 	</div>
								</div>
							</div>
							<div class="form-group for-smtp-mail">
								<label  class="control-label"><?= __('admin.smtp_port') ?></label>
								<input name="email[smtp_port]" value="<?php echo $email['smtp_port']; ?>" class="form-control" type="text">
							</div>

							<div class="form-group for-smtp-mail">
								<label class="control-label"><?= __('admin.smtp_crypto') ?></label>
								<select class="form-control" name="email[smtp_crypto]">
									<option value=""><?= __('admin.none') ?></option>
									<option value="tls" <?= $email['smtp_crypto'] == 'tls' ? 'selected' : '' ?>><?= __('admin.tls') ?></option>
									<option value="ssl" <?= $email['smtp_crypto'] == 'ssl' ? 'selected' : '' ?>><?= __('admin.ssl') ?></option>
								</select>
							</div>

							<div class="form-group">
								<label  class="control-label"><?= __('admin.unsubscribed_page_title') ?></label>
								<input name="email[unsubscribed_page_title]" value="<?php echo $email['unsubscribed_page_title']; ?>" class="form-control" type="text">
							</div>

							<div class="form-group">
								<label  class="control-label"><?= __('admin.unsubscribed_page_message') ?></label>
								<textarea name="email[unsubscribed_page_message]" class="form-control"><?php echo $email['unsubscribed_page_message']; ?></textarea>
							</div>

							<fieldset>
								<legend><?= __('admin.testing') ?></legend>
								<div class="input-group mb-3">
								  <input type="text" class="form-control testingemail" placeholder="<?= __('admin.test_email_send_on') ?>" aria-label="Recipient's username" aria-describedby="basic-addon2">
								  <div class="input-group-append cp">
								    <span class="input-group-text send-test-mail" id="basic-addon2"><?= __('admin.send_test_mail') ?></span>
								  </div>
								</div>
							</fieldset>
						</div>

						<div class="tab-pane p-3" id="tnc-page" role="tabpanel">
							<div class="form-group">
								<label  class="control-label"><?= __('admin.page_title') ?></label>
								<input placeholder="<?= __('admin.enter_page_title') ?>" name="tnc[heading]" value="<?php echo $tnc['heading']; ?>" class="form-control"  type="text">
							</div>
							<div class="form-group">
								<label  class="control-label"><?= __('admin.page_content') ?></label>
								<textarea name="tnc[content]" class="form-control summernote"><?php echo $tnc['content']; ?></textarea>
							</div>
						</div>

						<div class="tab-pane p-3" id="tracking" role="tabpanel">
						    <div class="form-group">
								<label class="control-label"><?= __('admin.affiliate_tracking') ?></label>
								<select class="form-control" name="site[affiliate_tracking_place]">
									<option value="0" selected><?= __('admin.use_cookies') ?></option>
									<option <?= $site['affiliate_tracking_place'] == 1 ? 'selected' : ''; ?> value="1"><?= __('admin.use_local_storage') ?></option>
									<option <?= $site['affiliate_tracking_place'] == 2 ? 'selected' : ''; ?> value="2"><?= __('admin.use_cookies_and_local_storage_both') ?></option>
								</select>
							</div>
							<div class="form-group">
								<label  class="control-label"><?= __('admin.affiliate_cookie') ?></label>
								<input class="form-control input-affiliate_cookie" type="number" value="<?= $store['affiliate_cookie'] ?>" name="store[affiliate_cookie]">
							</div>
							<div class="form-group">
								<label class="control-label"><?= __('admin.block_click_across_browser') ?></label>
								<select class="form-control" name="site[block_click_across_browser]">
									<option value="0"><?= __('admin.disable') ?></option>
									<option <?= $site['block_click_across_browser'] == 1 ? 'selected' : ''; ?> value="1"><?= __('admin.enable') ?></option>
								</select>
							</div>
						</div>

						<div class="tab-pane p-3" id="googlerecaptcha-setting" role="tabpanel">
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<label  class="control-label"><?= __('admin.text_site_key') ?></label>
										<input class="form-control" type="text" value="<?= $googlerecaptcha['sitekey'] ?>" name="googlerecaptcha[sitekey]">
									</div>
									<div class="form-group">
										<label  class="control-label"><?= __('admin.text_secret_key') ?></label>
										<input class="form-control" type="text" value="<?= $googlerecaptcha['secretkey'] ?>" name="googlerecaptcha[secretkey]">
									</div>

									<div class="form-group">
										<label class="control-label"><?= __('admin.admin_login') ?></label>
										<select class="form-control" name="googlerecaptcha[admin_login]">
											<option value="0"><?= __('admin.disable') ?></option>
											<option value="1" <?= $googlerecaptcha['admin_login'] ? 'selected' : '' ?>><?= __('admin.enable') ?></option>
										</select>
									</div>

									<div class="row">
										<div class="col-sm-6">
											<div class="form-group">
												<label class="control-label"><?= __('admin.affiliate_login') ?></label>
												<select class="form-control" name="googlerecaptcha[affiliate_login]">
													<option value="0"><?= __('admin.disable') ?></option>
													<option value="1" <?= $googlerecaptcha['affiliate_login'] ? 'selected' : '' ?>><?= __('admin.enable') ?></option>
												</select>
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
												<label class="control-label"><?= __('admin.affiliate_register') ?></label>
												<select class="form-control" name="googlerecaptcha[affiliate_register]">
													<option value="0"><?= __('admin.disable') ?></option>
													<option value="1" <?= $googlerecaptcha['affiliate_register'] ? 'selected' : '' ?>><?= __('admin.enable') ?></option>
												</select>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-sm-6">
											<div class="form-group">
												<label class="control-label"><?= __('admin.client_login') ?></label>
												<select class="form-control" name="googlerecaptcha[client_login]">
													<option value="0"><?= __('admin.disable') ?></option>
													<option value="1" <?= $googlerecaptcha['client_login'] ? 'selected' : '' ?>><?= __('admin.enable') ?></option>
												</select>
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
												<label class="control-label"><?= __('admin.client_register') ?></label>
												<select class="form-control" name="googlerecaptcha[client_register]">
													<option value="0"><?= __('admin.disable') ?></option>
													<option value="1" <?= $googlerecaptcha['client_register'] ? 'selected' : '' ?>><?= __('admin.enable') ?></option>
												</select>
											</div>
										</div>
									</div>
								</div>
								<div class="col-sm-6">
									<h4 class="mb-3 mt-3"><?= __('admin.how_to_get_site_key_secret_key') ?></h4>

									<p><?= __('admin.how_to_get_site_key_secret_key_s1') ?> <a href="https://accounts.google.com" class="link" target="_blank"><?= __('admin.how_to_get_site_key_secret_key_s2') ?></a>. <?= __('admin.how_to_get_site_key_secret_key_s3') ?> <a href="https://www.google.com/recaptcha/" class="link" target="_blank"><?= __('admin.how_to_get_site_key_secret_key_s4') ?></a>, <?= __('admin.how_to_get_site_key_secret_key_s5') ?> <strong><?= __('admin.how_to_get_site_key_secret_key_s6') ?></strong> <?= __('admin.how_to_get_site_key_secret_key_s7') ?></p>

									<p><?= __('admin.how_to_get_site_key_secret_key_s8') ?> <strong><?= __('admin.how_to_get_site_key_secret_key_s9') ?></strong> <?= __('admin.how_to_get_site_key_secret_key_s10') ?></p>

									<img src="<?= base_url("assets/images/grecaptcha/grecaptcha-2.png") ?>" class='img-thumbnail'>

									<p><?= __('admin.how_to_get_site_key_secret_key_s11') ?></p>

									<img src="<?= base_url("assets/images/grecaptcha/grecaptcha-3.png") ?>" class='img-thumbnail'>
								</div>
							</div>

							
						</div>
					</div>
				</div>
				<div class="col-sm-12 text-right">
					<button type="submit" class="btn btn-sm btn-primary btn-submit"><?= __('admin.save_settings') ?></button>
				</div>
			</div>
		</form>
	</div>
</div>

<link href="<?php echo base_url(); ?>assets/js/summernote-0.8.12-dist/summernote-bs4.css" rel="stylesheet">
<script src="<?php echo base_url(); ?>assets/js/summernote-0.8.12-dist/summernote-bs4.js"></script>

<script>
function maxLengthCheck(object) {
if (object.value.length > object.maxLength)
  object.value = object.value.slice(0, object.maxLength)
}

function isNumeric (evt) {
	var theEvent = evt || window.event;
	var key = theEvent.keyCode || theEvent.which;
	key = String.fromCharCode (key);
	var regex = /[0-9]|\./;
	if ( !regex.test(key) ) {
	  theEvent.returnValue = false;
	  if(theEvent.preventDefault) theEvent.preventDefault();
	}
}
</script>
<script type="text/javascript">

	$('select[name="email[mail_type]"]').on('change', function(){
		if($(this).val() == 'smtp') {
			$('.for-smtp-mail').show();
		} else {
			$('.for-smtp-mail').hide();
		}
	});

	$('select[name="email[mail_type]"]').trigger('change');

$('.setting-nnnav li a').on('shown.bs.tab', function(event){
    var x = $(event.target).attr('href');
	$(".btn-submit").hide();

    if(x != '#site-fronttemplate'){
    	$(".btn-submit").show();
    }
    localStorage.setItem("last_pill", x);
});


$("#setting-form").on('submit',function(){
	$("#setting-form .alert-error").remove();
	var affiliate_cookie = parseInt($(".input-affiliate_cookie").val());
	if(affiliate_cookie <= 0 || affiliate_cookie > 365){
		$(".input-affiliate_cookie").after("<div class='alert alert-danger alert-error'><?= __('admin.days_between_1_and_365') ?></div>");
	}
	if($("#setting-form .alert-error").length == 0) return true;
	return false;
})
$(".items-holder").delegate(".remove-items",'click',function(){
	$(this).parent(".input-group").remove();
})
$(".add-items").on('click',function(){
	$(".items-holder").append('\
		<div class="input-group mb-3">\
		<input type="text" name="login[text_list][]" class="form-control" placeholder="<?= __('admin.list_items') ?>" >\
		<div class="input-group-append remove-items">\
		<span class="input-group-text"><i class="fa fa-trash"></i></span>\
		</div>\
		</div>\
		');
})
$(document).on('ready',function() {
	$('.summernote').summernote({
		tabsize: 2,
		height: 400
	});
	var last_pill = localStorage.getItem("last_pill");
	if(last_pill){ $('[href="'+ last_pill +'"]').click() }
});
$('.send-test-mail').on('click',function(){
	$this = $(this);
	$.ajax({
		type:'POST',
		dataType:'json',
		data:{send_test_mail:$(".testingemail").val()},
		beforeSend:function(){ $this.btn("loading"); },
		complete:function(){$this.btn("reset"); },
		success:function(json){ },
	});
})

$(".btn-submit").on('click',function(evt){
    evt.preventDefault();

    $(".site-global_script").val( window.btoa(unescape(encodeURIComponent($(".site-global_script").val() ))) );
    $(".site-fbmessager_script").val( window.btoa(unescape(encodeURIComponent($(".site-fbmessager_script").val() ))) );
    $(".site-faceboook_pixel").val( window.btoa(unescape(encodeURIComponent($(".site-faceboook_pixel").val() ))) );
    $(".site-google_analytics").val( window.btoa(unescape(encodeURIComponent($(".site-google_analytics").val() ))) );

    var formData = new FormData($("#setting-form")[0]);

    $(".site-global_script").val( decodeURIComponent(escape(window.atob( $(".site-global_script").val() ))) );
    $(".site-fbmessager_script").val( decodeURIComponent(escape(window.atob( $(".site-fbmessager_script").val() ))) );
    $(".site-faceboook_pixel").val( decodeURIComponent(escape(window.atob( $(".site-faceboook_pixel").val() ))) );
    $(".site-google_analytics").val( decodeURIComponent(escape(window.atob( $(".site-google_analytics").val() ))) );

    $(".btn-submit").btn("loading");
    formData = formDataFilter(formData);
    $this = $("#setting-form");
    
    $.ajax({
        type:'POST',
        dataType:'json',
        cache:false,
        contentType: false,
        processData: false,
        data:formData,
        success:function(result){
            $(".btn-submit").btn("reset");
            $(".alert-dismissable").remove();

            $this.find(".has-error").removeClass("has-error");
            $this.find("span.text-danger").remove();
            
            if(result['location']){
                window.location = result['location'];
            }

            if(result['success']){
                $(".tab-content").prepend('<div class="alert mt-4 alert-info alert-dismissable">'+ result['success'] +'</div>');
                var body = $("html, body");
				body.stop().animate({scrollTop:0}, 500, 'swing', function() { });
            }

            if(result['errors']){
                $.each(result['errors'], function(i,j){
                    $ele = $this.find('[name="'+ i +'"]');
                    if($ele){
                        $ele.parents(".form-group").addClass("has-error");
                        $ele.after("<span class='d-block text-danger'>"+ j +"</span>");
                    }
                });
            }
        },
    })
    return false;
});
var levels = {};

<?php 
	for ($i=1; $i <= 10; $i++) { 
		$v = 'referlevel_'.$i;
		if (isset($$v)) { ?>
				levels['<?= $i ?>'] = <?= json_encode($$v) ?>;
		<?php }
	}
?>
$('#referlevel_select').on('change',function(){
	var level =  $(this).val();
	
	var html = '';
	for(var i = 1; i <= level; i++){
		html += '<tr>';
			html += '<td>'+i+'</td>';
			html += '<td><input type="number" step="any" name="referlevel_'+i+'[commition]" value="'+(levels[i] ? levels[i]['commition'] : '' )+'" class="form-control" /></td>';
			html += '<td><div class="input-group"><input type="number" step="any" name="referlevel_'+i+'[sale_commition]" value="'+(levels[i] ? levels[i]['sale_commition'] : '' )+'" class="form-control" /><div class="input-group-append"><span class="input-group-text refer-symball"></span></div>															</div></td>';
			html += '<td><div class="input-group"><input type="number" step="any" name="referlevel_'+i+'[ex_commition]" value="'+(levels[i] ? levels[i]['ex_commition'] : '' )+'" class="form-control" /><div class="input-group-append"><span class="input-group-text"><?= $CurrencySymbol ?></span></div></div></td>';
			html += '<td><div class="input-group"><input type="number" step="any" name="referlevel_'+i+'[ex_action_commition]" value="'+(levels[i] ? levels[i]['ex_action_commition'] : '' )+'" class="form-control" /><div class="input-group-append"><span class="input-group-text"><?= $CurrencySymbol ?></span></div></div></td>';
		html += '</tr>';
	}
	$('#tbl_refer_level tbody').html(html);

	chnage_teigger();
});

$(document).on('click','.btn-delete-image', function(){
	let input_name = $(this).data('img_input');
	$('input[name="'+input_name+'"]').val('');

	let image_ele_id = $(this).data('img_ele');
	let placeholder_image = $(this).data('img_placeholder');
	$('#'+image_ele_id).attr('src', placeholder_image);

	$(this).remove()
});

</script>
