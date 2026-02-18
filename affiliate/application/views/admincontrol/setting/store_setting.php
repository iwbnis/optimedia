<style>
	.jscolor-picker-wrap{
		z-index:999999 !important;
	}

	#theme_section .table > tbody > tr > td, #theme_section .table > tfoot > tr > td, #theme_section .table > thead > tr > td,
	#menu_items_list.table > tbody > tr > td, #menu_items_list.table > tfoot > tr > td, #menu_items_list.table > thead > tr > td {
		padding: 5px 12px;
		vertical-align: middle !important;
	}

	.table td, .table th {
		vertical-align: middle !important;
	}

	.swal2-container {
		z-index:999999!important;
	}
</style>

<?php include(APPPATH.'/views/admincontrol/includes/store.php'); ?>
<br>

<div class="row">
	<div class="col-lg-12 col-md-12">
		<?php if($this->session->flashdata('success')){?>
			<div class="alert alert-success">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			<?php echo $this->session->flashdata('success'); ?> </div>
		<?php } ?>
		<?php if($this->session->flashdata('error')){?>
			<div class="alert alert-danger">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			<?php echo $this->session->flashdata('error'); ?> </div>
		<?php } ?>
	</div>
</div>

<form class="form-horizontal" method="post" action=""  enctype="multipart/form-data" id="setting-form">
	<div class="row">
		<div class="col-sm-12">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title"><?= __('admin.page_title_store_setting') ?></h4>
				</div>
				<div class="card-body p-0">
					<div class="tab-pane p-3" id="store-setting" role="tabpanel">
						<div role="tabpanel">
						
							<ul class="nav nav-pills setting-nnnav" role="tablist">
								<li role="presentation" class="active nav-item">
									<a class="nav-link active show" href="#store_main" aria-controls="store_main" role="tab" data-toggle="tab"><?= __('admin.store_setting') ?></a>
								</li>
								<li role="presentation" class="nav-item">
									<a class="nav-link" href="#product_setting" aria-controls="product_setting" role="tab" data-toggle="tab"><?= __('admin.product_setting') ?></a>
								</li>
							
								<li role="presentation" class="nav-item">
									<a class="nav-link" href="#form_setting" aria-controls="form_setting" role="tab" data-toggle="tab"><?= __('admin.form_setting') ?></a>
								</li>
								<li role="presentation" class="nav-item">
									<a class="nav-link" href="#vendor_setting" aria-controls="vendor_setting" role="tab" data-toggle="tab"><?= __('admin.vendor_setting') ?></a>
								</li>
								<li role="presentation" class="nav-item">
									<a class="nav-link" href="#payment_api_documentation" aria-controls="payment_api_documentation" role="tab" data-toggle="tab"><?= __('admin.payment_api_documentation') ?></a>
								</li>
								<li role="presentation" class="nav-item">
									<a class="nav-link" href="#shipping_setting" aria-controls="shipping_setting" role="tab" data-toggle="tab"><?= __('admin.shipping_setting') ?></a>
								</li>
								<li role="presentation" class="nav-item">
									<a class="nav-link" href="#tax_setting" aria-controls="tax_setting" role="tab" data-toggle="tab"><?= __('admin.tax_setting') ?></a>
								</li>
								<li role="presentation" class="nav-item">
									<a class="nav-link" href="#order_comment" aria-controls="order_comment" role="tab" data-toggle="tab"><?= __('admin.order_comment') ?></a>
								</li>
								<li role="presentation" class="nav-item">
									<a class="nav-link" href="#theme_section" aria-controls="theme_section" role="tab" data-toggle="tab"><?= __('admin.theme_section') ?></a>
								</li>
								<li role="presentation" class="nav-item">
									<a class="nav-link" href="#pages_menu_section" aria-controls="pages_menu_section" role="tab" data-toggle="tab"><?= __('admin.pages_and_menu') ?></a>
								</li>
							</ul>
							<hr>
						
							<div class="tab-content">
								<div role="tabpanel" class="tab-pane" id="shipping_setting">
									<div class="card">
										<div class="card-header"><h6 class="m-0"><?= __('admin.shipping_charge') ?></h6></div>
										<div class="card-body">
											<div class="form-group">
												<label class="control-label"><?= __('admin.allow_shipping_in_all_country') ?></label>
												<div>
													<label class="radio-inline"><input type="radio" <?= (int)$shipping_setting['shipping_in_limited'] == 0 ? 'checked' : '' ?> class="shipping_in_limited" name="shipping_setting[shipping_in_limited]" value="0"> 
														<?= __('admin.yes_all_country') ?>
													</label>
													<label class="radio-inline"><input type="radio" <?= (int)$shipping_setting['shipping_in_limited'] == 1 ? 'checked' : '' ?> class="shipping_in_limited" name="shipping_setting[shipping_in_limited]" value="1"> 
														<?= __('admin.no_custom_country') ?>
													</label>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label"><?= __('admin.shipping_error_message') ?></label>
												<input type="text" value="<?= $shipping_setting['shipping_error_message'] ?>" name="shipping_setting[shipping_error_message]" class="form-control">
											</div>
											<table class="table table-striped shipping-table">
												<thead>
													<tr>
														<th><?= __('admin.country') ?></th>
														<th width="180px"><?= __('admin.shipping_cost') ?></th>
														<th width="50px"></th>
													</tr>
												</thead>
												<tbody>
												
												</tbody>
												<tfoot>
													<tr>
														<td colspan="3" class="text-right">
															<button class="btn btn-shipping-rule btn-sm" type="button" ><?= __('admin.add_new_rule') ?></button>
														</td>
													</tr>
												</tfoot>
											</table>
										</div>
									</div>
								
									<script type="text/javascript">
										var shipping_index = 0;
										<?php 
											$country_options = '';
											foreach ($country as $key => $value) { 
												$country_options .= '<option value="'. $value->id .'">'. str_replace("'", '', $value->name) .'</option>';
											} 
										?>
										$(".shipping_in_limited").on("change",function(){
											var val = $(this).val();
											$(".shipping-country-table").hide();
											if(val == 1){
												$(".shipping-country-table").show();
											}
										})
										$(".shipping_in_limited:checked").trigger("change");
										function addShippingCountry(country) {
											var shipping_html = '';
											shipping_html += '<tr>';
											shipping_html += '	<td>';
											shipping_html += '		<select name="shipping_setting[allow_country][]" class="form-control">';
											shipping_html += '			<option value=""><?= __('admin.choose_country') ?></option>';
											shipping_html += '			<?= $country_options ?>';
											shipping_html += '		</select>';
											shipping_html += '	</td>';
											shipping_html += '	<td>';
											shipping_html += '		<button class="btn btn-danger remove-tr" type="button"><i class="fa fa-trash"></i></button>';
											shipping_html += '	</td>';
											shipping_html += '</tr>';
											$ship = $(shipping_html);
											$ship.find("select").val(country);
											$ship.appendTo(".shipping-country-table tbody");
											shipping_index++;
										}
										$(".btn-shipping-country").click(function(){
											addShippingCountry('');
										})
										$(".shipping-country-table, .shipping-table").delegate(".remove-tr","click", function(){
											$(this).parents("tr").remove();
										})
										$(".btn-shipping-rule").click(function(){
											addShippingRule('',0);
										})
										function addShippingRule(country,cost) {
											var shipping_html = '';
											shipping_html += '<tr>';
											shipping_html += '	<td>';
											shipping_html += '		<select name="shipping_setting[cost]['+ shipping_index +'][country]" class="form-control taxc-'+ shipping_index +'">';
											shipping_html += '			<option value=""><?= __('admin.choose_country') ?></option>';
											shipping_html += '			<?= $country_options ?>';
											shipping_html += '		</select>';
											shipping_html += '	</td>';
											shipping_html += '	<td><input type="" name="shipping_setting[cost]['+ shipping_index +'][cost]" onkeydown="if(event.key===\'.\'){event.preventDefault();}"  oninput="event.target.value = event.target.value.replace(/[^0-9]*/g,\'\');" class="form-control ssv-'+ shipping_index +'"></td>';
											shipping_html += '	<td>';
											shipping_html += '		<button class="btn btn-danger  remove-tr" type="button"><i class="fa fa-trash"></i></button>';
											shipping_html += '	</td>';
											shipping_html += '</tr>';
											$ship = $(shipping_html);
											$ship.find("select").val(country);
											$ship.find("input").val(cost);
											$ship.appendTo(".shipping-table tbody");
											shipping_index++;
										}
										<?php 
											$allow_country = (array)(isset($shipping_setting['allow_country']) ? json_decode($shipping_setting['allow_country'],1) : []);
											foreach (array_unique($allow_country) as $key => $value) {
												echo "addShippingCountry('". (int)$value ."');";
											}
											$cost = (array)(isset($shipping_setting['cost']) ? json_decode($shipping_setting['cost'],1) : []);
											foreach ($cost as $key => $value) {
												echo "addShippingRule('". (int)$value['country'] ."','". (float)$value['cost'] ."');";
											}
										?>
									</script>
								</div>
								<div role="tabpanel" class="tab-pane" id="tax_setting">
									<div class="card">
										<div class="card-header"><h6 class="m-0"><?= __('admin.shipping_charge') ?></h6></div>
										<div class="card-body">
											<div class="form-group">
												<label class="control-label"><?= __('admin.allow_tax_in_all_country') ?></label>
												<div>
													<label class="radio-inline"><input type="radio" <?= (int)$tax_setting['tax_status'] == 0 ? 'checked' : '' ?> class="tax_status" name="tax_setting[tax_status]" value="0"> 
														<?= __('admin.tax_disable') ?>
													</label>
													<label class="radio-inline"><input type="radio" <?= (int)$tax_setting['tax_status'] == 1 ? 'checked' : '' ?> class="tax_status" name="tax_setting[tax_status]" value="1"> 
														<?= __('admin.yes_all_country') ?>
													</label>
													<label class="radio-inline"><input type="radio" <?= (int)$tax_setting['tax_status'] == 2 ? 'checked' : '' ?> class="tax_status" name="tax_setting[tax_status]" value="2"> 
														<?= __('admin.no_custom_country') ?>
													</label>
												</div>
											</div>
											<div class="form-group common_tax_percentage_inp">
												<label class="control-label"><?= __('admin.tax_cost') ?></label>
												<input type="text" name="tax_setting[common_tax_percentage]" onkeydown="if(event.key==='.'){event.preventDefault();}" oninput="event.target.value = event.target.value.replace(/[^0-9]*/g,'');" class="form-control common_tax_percentage" value="<?= $tax_setting['common_tax_percentage']; ?>"/>
											</div>
											<table class="table table-striped tax-table">
												<thead>
													<tr>
														<th><?= __('admin.country') ?></th>
														<th width="180px"><?= __('admin.tax_cost') ?></th>
														<th width="50px"></th>
													</tr>
												</thead>
												<tbody>
												
												</tbody>
												<tfoot>
													<tr>
														<td colspan="3" class="text-right">
															<button class="btn btn-tax-rule btn-sm" type="button" ><?= __('admin.add_new_rule') ?></button>
														</td>
													</tr>
												</tfoot>
											</table>
										</div>
									</div>
								
									<script type="text/javascript">
										var tax_index = 0;
										<?php 
											$country_options = '';
											foreach ($country as $key => $value) { 
												$country_options .= '<option value="'. $value->id .'">'. str_replace("'", '', $value->name) .'</option>';
											} 
										?>
										
										$(".tax_status").on("change",function(){
											var val = $(this).val();
											$(".common_tax_percentage_inp").hide();
											$(".tax-table").hide();
											if(val == 1){
												$(".common_tax_percentage_inp").show();
											}
											if(val == 2){
												$(".tax-table").show();
											}
										})

										$(".tax_status:checked").trigger("change");

										$(".tax-table").delegate(".remove-tr","click", function(){
											$(this).parents("tr").remove();
										})
										$(".btn-tax-rule").click(function(){
											addtaxRule('',0);
										})
										function addtaxRule(country,cost) {
											var tax_html = '';
											tax_html += '<tr>';
											tax_html += '	<td>';
											tax_html += '		<select name="tax_setting[cost]['+ tax_index +'][country]" class="form-control taxc-'+ tax_index +'">';
											tax_html += '			<option value=""><?= __('admin.choose_country') ?></option>';
											tax_html += '			<?= $country_options ?>';
											tax_html += '		</select>';
											tax_html += '	</td>';
											tax_html += '	<td><input type="" name="tax_setting[cost]['+ tax_index +'][cost]" onkeydown="if(event.key===\'.\'){event.preventDefault();}"  oninput="event.target.value = event.target.value.replace(/[^0-9]*/g,\'\');" class="form-control taxv-'+ tax_index +'"></td>';
											tax_html += '	<td>';
											tax_html += '		<button class="btn btn-danger  remove-tr" type="button"><i class="fa fa-trash"></i></button>';
											tax_html += '	</td>';
											tax_html += '</tr>';
											$ship = $(tax_html);
											$ship.find("select").val(country);
											$ship.find("input").val(cost);
											$ship.appendTo(".tax-table tbody");
											tax_index++;
										}
										<?php 
											$allow_country = (array)(isset($tax_setting['allow_country']) ? json_decode($tax_setting['allow_country'],1) : []);

											$cost = (array)(isset($tax_setting['cost']) ? json_decode($tax_setting['cost'],1) : []);
											foreach ($cost as $key => $value) {
												echo "addtaxRule('". (int)$value['country'] ."','". (float)$value['cost'] ."');";
											}
										?>
									</script>
								</div>

								<div role="tabpanel" class="tab-pane active" id="store_main">
									<div class="form-group">
										<label  class="control-label"><?= __('admin.store_name') ?></label>
										<input  name="store[name]" value="<?php echo $store['name']; ?>" class="form-control"  type="text">
									</div>

									<div class="row">
										<div class="col-4">
											<div class="form-group">
												<label class="control-label"><?= __('admin.status') ?></label>
												<select class="form-control" name="store[status]">
													<option value="0"><?= __('admin.disable') ?></option>
													<option value="1" <?= $store['status'] ? 'selected' : '' ?>><?= __('admin.enable') ?></option>
												</select>
											</div>
										</div>
										<div class="col-4">
											<div class="form-group">
												<label class="control-label"><?= __('admin.display_store_menu_on_front_side') ?></label>
												<select class="form-control" data-existing-value="<?= $store['menu_on_front'];?>" name="store[menu_on_front]" <?= $store['status'] ? '' : 'disabled' ?>>
													<option value="0"><?= __('admin.disable') ?></option>
													<option value="1" <?= $store['menu_on_front'] ? 'selected' : '' ?>><?= __('admin.enable') ?></option>
												</select>
											</div>
										</div>

										<div class="col-4">
											<div class="form-group">
												<label class="control-label"><?= __('admin.open_in_new_tab') ?></label>
												<select class="form-control" name="store[menu_on_front_blank]">
													<option value="0"><?= __('admin.disable') ?></option>
													<option value="1" <?= $store['menu_on_front_blank'] ? 'selected' : '' ?>><?= __('admin.enable') ?></option>
												</select>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label"><?= __('admin.store_theme') ?></label>
										<select class="form-control" name="store[theme]">
											<option value="0"><?= __('admin.default') ?></option>
											<option value="theme1" <?= $store['theme'] == 'theme1' ? 'selected' : '' ?>><?= __('admin.theme_1') ?></option>
										</select>
									</div>
									<div class="form-group">
										<label  class="control-label"><?= __('admin.google_analytics_for_store_page') ?></label>
										<textarea name="store[google_analytics]" class="form-control"><?php echo $store['google_analytics']; ?></textarea>
									</div>



									<div class="per-task-parent">
										<?php
										$per_tasks = isset($store['per_task']) && !empty($store['per_task']) ? json_decode($store['per_task'],true) : [];
										$tcount = 1;
										if(!empty($per_tasks)) {
											
											foreach($per_tasks as $per_task){

												?>
												<div class="form-group row task-item">
													<div class="col-md-11">
														<label  class="control-label"><?= __('admin.script') ?> <?=$tcount?></label>
														<textarea name="store[per_task][]" class="form-control" ><?= $per_task?></textarea>
													</div>												
													<div class="col-md-1">
														<button type="button" class="btn btn-danger btn-md remove-per-task-btn" style="position: absolute; top: 30px; right: 11px;"><i class="fa fa-trash"></i></button>
													</div>
												</div>
												<?php 
												$tcount++;
											}
										}
									?>
											
									</div>
									<div class="col-md-12">

										<button id="add-more-per-task-btn" type="button" class="btn btn-default btn-md"><i class="fa fa-plus"></i> <?= __('admin.add_script') ?></button>
										<span class="script-count" data-value="<?=$tcount?>"></span>
									</div>
									<script type="text/javascript">
										$(document).on('click', '#add-more-per-task-btn', function(){

											let countt = parseInt($('.script-count').attr('data-value'));
											$('.per-task-parent').append(`
											<div class="form-group row task-item">
												<div class="col-md-11">
														<label  class="control-label">Script `+(countt)+`</label>
														<textarea name="store[per_task][]" class="form-control"></textarea>														
													</div>
												
												<div class="col-md-1">
													<button type="button" class="btn btn-danger btn-md remove-per-task-btn" style="position: absolute; top: 30px; right: 11px;"><i class="fa fa-trash"></i></button>
												</div>
											</div>`);
											$('.script-count').attr('data-value',(countt+1))
										});
										$(document).on('click', '.remove-per-task-btn', function(){
											$(this).parents('.task-item').remove();
										});
									</script>
									<fieldset>
										<legend><?= __('admin.store_logo') ?></legend>
										<div class="row">
											<div class="col-sm-6 p-4">
												<?php $img = $store['logo'] ? base_url('assets/images/site/'. $store['logo']) : base_url('assets/vertical/assets/images/users/avatar-1.jpg'); ?>
												<img style="width: 150px;" src="<?= $img ?>" class='img-responsive'>
											</div>
											<div class="col-sm-6">
												<input type="file" name="store_logo">
											</div>
										</div>
									</fieldset>
									<fieldset>
										<legend><?= __('admin.store_favicon_icon') ?></legend>
										<div class="row">
											<div class="col-sm-6 p-4">
												<?php $img = $store['favicon'] ? base_url('assets/images/site/'. $store['favicon']) : base_url('assets/vertical/assets/images/users/avatar-1.jpg'); ?>
												<img style="width: 150px;" src="<?= $img ?>" class='img-responsive'>
											</div>
											<div class="col-sm-6">
												<input type="file" name="store_favicon">
											</div>
										</div>
									</fieldset>
							
									<div class="form-group">
										<label  class="control-label"><?= __('admin.footer_text') ?></label>
										<input name="store[footer]" value="<?php echo $store['footer']; ?>" class="form-control"  type="text">
									</div>
								
									<div class="form-group">
										<label class="control-label"><?= __('admin.recaptcha') ?></label>
										<input name="formsetting[recaptcha]" value="<?php echo $formsetting['recaptcha']; ?>" class="form-control"  type="text">
									</div>
									<a href="https://www.google.com/recaptcha/admin#list" target="_blank"><?= __('admin.google_captcha') ?></a>

									<div class="form-group">
										<label  class="control-label"><?= __('admin.contact_us_map') ?></label>
										<textarea name="store[contact_us_map]" class="form-control"><?php echo $store['contact_us_map']; ?></textarea> 
									</div>


									<div class="form-group">
										<label  class="control-label"><?= __('admin.store_address') ?></label>
										<textarea name="store[address]" class="form-control"><?php echo $store['address']; ?></textarea> 
									</div>

									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label  class="control-label"><?= __('admin.store_email') ?></label>
												<input  name="store[email]" value="<?php echo $store['email']; ?>" class="form-control"  type="email"> 
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label  class="control-label"><?= __('admin.store_mobile_phone_number') ?></label>
												<input  name="store[contact_number]" value="<?php echo $store['contact_number']; ?>" class="form-control"  type="text"> 
											</div>
										</div>
									</div>
								</div>
								<div role="tabpanel" class="tab-pane" id="vendor_setting">
									<div class="form-group">
										<label class="control-label"><?= __('admin.vendor_store_status') ?></label>
										<select class="form-control" name="vendor[storestatus]">
											<option value="0"><?= __('admin.disable') ?></option>
											<option value="1" <?= $vendor['storestatus'] ? 'selected' : '' ?>><?= __('admin.enable') ?></option>
										</select>
									</div>
									<div class="form-group">
										<label class="control-label"><?= __('admin.click_commission'); ?></label>
										<div class="form-group">
											<div class="comm-group">
												<div>
													<div class="input-group mt-2">
														<div class="input-group-prepend"><span class="input-group-text"><?= __('admin.click'); ?></span></div>
														<input name="vendor[admin_click_count]"  class="form-control" value="<?php echo $vendor['admin_click_count']; ?>" type="text" placeholder='<?= __('admin.clicks') ?>'>
													</div>
												</div>
												<div>
													<div class="input-group mt-2">
														<div class="input-group-prepend"><span class="input-group-text">$</span></div>
														<input name="vendor[admin_click_amount]" class="form-control" value="<?php echo $vendor['admin_click_amount']; ?>" type="text" placeholder='<?= __('admin.amount') ?>'>
													</div>
												</div>
											</div>
										</div>							
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-sm-6">
												<label class="control-label"><?= __('admin.sale_commission'); ?></label>
												<div>
													<?php
														$commission_type= array(
															'percentage' => __('admin.percentage').' (%)',
															'fixed'      => __('admin.fixed'),
														);
													?>
													<select name="vendor[admin_sale_commission_type]" class="form-control admin_sale_commission_type">
														<?php foreach ($commission_type as $key => $value) { ?>
															<option <?= $vendor['admin_sale_commission_type'] == $key ? 'selected' : '' ?> value="<?= $key ?>"><?= $value ?></option>
														<?php } ?>
													</select>
												</div>
											</div>
											<div class="col-sm-6">
												<div class="toggle-container">
													<div class="percentage-value d-none">									
														<div class="form-group">
															<label class="control-label m-0 d-block">&nbsp;</label>
															<input name="vendor[admin_commission_value]" id="admin_commission_value" class="form-control mt-2" value="<?php echo $vendor['admin_commission_value']; ?>" type="text" placeholder='<?= __('admin.sale_commission') ?>'>
														</div>
													</div>
												</div>
											</div>
										</div>
									
										<script type="text/javascript">
											$("select.admin_sale_commission_type").on("change",function(){
												$con = $(this).parents(".form-group");
												$con.find(".toggle-container .percentage-value, .toggle-container .default-value").addClass('d-none');
												if($(this).val() == 'default'){
													$con.find(".toggle-container .default-value").removeClass("d-none");
												}else{
													$con.find(".toggle-container .percentage-value").removeClass("d-none");
												}
											})
											$("select.admin_sale_commission_type").trigger("change");
										</script>
									</div>
								</div>
								<div role="tabpanel" class="tab-pane" id="product_setting">
									<div class="form-group">
										<label class="control-label"><?= __('admin.click_allow') ?></label>
										<select name="productsetting[click_allow]" class="form-control">
											<option <?php if($productsetting['click_allow'] == 'single') { ?> selected <?php } ?> value="single"><?= __('admin.allow_single_click') ?></option>
											<option <?php if($productsetting['click_allow'] == 'multiple') { ?> selected <?php } ?>  value="multiple"><?= __('admin.allow_multi_click') ?></option>
										</select>
									</div>
									<div class="form-group">
										<label class="control-label"><?= __('admin.commission_type') ?></label>
										<select name="productsetting[product_commission_type]" class="form-control">
											<option value=""><?= __('admin.select_product_commission_type') ?></option>
											<option <?php if($productsetting['product_commission_type'] == 'percentage') { ?> selected <?php } ?> value="percentage">Percentage(%)</option>
											<option <?php if($productsetting['product_commission_type'] == 'Fixed') { ?> selected <?php } ?>  value="<?= __('admin.fixed') ?>">Fixed</option>
										</select>
									</div>
									<div class="form-group">
										<label class="control-label"><?= __('admin.commission_for_sale') ?></label>
										<input name="productsetting[product_commission]" value="<?php echo $productsetting['product_commission']; ?>" class="form-control"  type="text">
									</div>
									<div class="form-group">
										<label class="control-label"><?= __('admin.commission_for_ppc_visits_view') ?> (<?= $CurrencySymbol ?>)</label>
										<input  name="productsetting[product_ppc]" value="<?php echo $productsetting['product_ppc']; ?>" class="form-control"  type="text">
									</div>
									<div class="form-group">
										<label class="control-label"><?= __('admin.number_of_clicks_per_commission') ?></label>
										<input  name="productsetting[product_noofpercommission]" value="<?php echo $productsetting['product_noofpercommission']; ?>" class="form-control"  type="text">
									</div>
								
									<div class="form-group">
										<label class="control-label"><?= __('admin.number_of_clicks_per_commission') ?></label>							
										<select name="productsetting[product_recursion]" class="form-control form-group" id="recursion_type">
											<option value=""><?= __('admin.select_recursion') ?></option>
											<option <?php if($productsetting['product_recursion'] == 'every_day') { ?> selected <?php } ?> value="every_day"><?=  __('admin.every_day') ?></option>
											<option <?php if($productsetting['product_recursion'] == 'every_week') { ?> selected <?php } ?>  value="every_week"><?=  __('admin.every_week') ?></option>
											<option <?php if($productsetting['product_recursion'] == 'every_month') { ?> selected <?php } ?>  value="every_month"><?=  __('admin.every_month') ?></option>
											<option <?php if($productsetting['product_recursion'] == 'every_year') { ?> selected <?php } ?>  value="every_year"><?=  __('admin.every_year') ?></option>
											<option <?php if($productsetting['product_recursion'] == 'custom_time') { ?> selected <?php } ?>  value="custom_time"><?=  __('admin.custom_time') ?></option>
										</select>
									<div class="custom_time <?php echo ($productsetting['product_recursion'] != 'custom_time') ? 'hide' : '';  ?>">
																		
										<?php
										$minutes = $productsetting['recursion_custom_time'];
										$day = floor ($minutes / 1440);
										$hour = floor (($minutes - $day * 1440) / 60);
										$minute = $minutes - ($day * 1440) - ($hour * 60);
										?>
										<input type="hidden" name="productsetting[recursion_custom_time]" value="<?php echo $minutes; ?>" class="recursion_custom_time">
										<div class="row">
											<div class="col-sm-4">
												<label class="control-label"><?= __('admin.days') ?> : </label>
												<input placeholder="Days" type="number" class="form-control recur_day" value="<?= $day ? $day : '' ?>" onkeydown="if(event.key==='.'){event.preventDefault();}"  oninput="event.target.value = event.target.value.replace(/[^0-9]*/g,'');">
											
											</div>					
											<div class="col-sm-4">
												<label class="control-label"><?= __('admin.hours') ?> : </label>
												<select class="form-control recur_hour">
													<?php 
													for ($x = 0; $x <= 23; $x++) {
														$selected = ($x == $hour ) ? 'selected="selected"' : '';
														echo '<option value="'.$x.'" '.$selected.'>'.$x.'</option>';
													}
													?>
												</select>
											</div>					
											<div class="col-sm-4">
												<label class="control-label"><?= __('admin.minutes') ?> : </label>
												<select class="form-control recur_minute">
													<?php 
													for ($x = 0; $x <= 59; $x++) {
														$selected = ($x == $minute ) ? 'selected="selected"' : '';
														echo '<option value="'.$x.'" '.$selected.'>'.$x.'</option>';
													}
													?>
												</select>
											</div>					
										</div>
										<small class="error productsetting_error"></small>
									</div>
										<br>
										<div class="endtime-chooser row">
											<div class="col-sm-12">
												<div class="form-group">
													<label class="control-label d-block"><?= __('admin.choose_custom_endtime') ?> <input <?= $productsetting['recursion_endtime'] ? 'checked' : '' ?>  class='setCustomTime' name='recursion_endtime_status' type="checkbox"> </label>
													<div style="<?= !$productsetting['recursion_endtime'] ? 'display:none' : '' ?>" class='custom_time_container'>
														<input type="text" class="form-control" value="<?= $productsetting['recursion_endtime'] ? date("d-m-Y H:i",strtotime($productsetting['recursion_endtime'])) : '' ?>" name="productsetting[recursion_endtime]" id="endtime" placeholder="<?= __('admin.choose_endtime') ?>" >
													</div>
												</div>
											</div>
										</div>

									</div>
											
								</div>
								<div role="tabpanel" class="tab-pane" id="form_setting">
									<div class="form-group">
										<label class="control-label"><?= __('admin.commission_type') ?></label>
										<select name="formsetting[product_commission_type]" class="form-control">
											<option value=""><?= __('admin.select_product_commission_type') ?></option>
											<option <?php if($formsetting['product_commission_type'] == 'percentage') { ?> selected <?php } ?> value="percentage">Percentage(%)</option>
											<option <?php if($formsetting['product_commission_type'] == 'Fixed') { ?> selected <?php } ?>  value="Fixed">Fixed</option>
										</select>
									</div>
									<div class="form-group">
										<label class="control-label"><?= __('admin.commission_for_sale') ?></label>
										<input name="formsetting[product_commission]" value="<?php echo $formsetting['product_commission']; ?>" class="form-control"  type="text">
									</div>
									<div class="form-group">
										<label class="control-label"><?= __('admin.commission_for_ppc_visits_view') ?> (<?= $CurrencySymbol ?>)</label>
										<input  name="formsetting[product_ppc]" value="<?php echo $formsetting['product_ppc']; ?>" class="form-control"  type="text">
									</div>
									<div class="form-group">
										<label class="control-label"><?= __('admin.number_of_clicks_per_commission') ?></label>
										<input  name="formsetting[product_noofpercommission]" value="<?php echo $formsetting['product_noofpercommission']; ?>" class="form-control"  type="text">
									</div>
									<div class="form-group">
										<label class="control-label"><?= __('admin.form_recursion') ?></label>							
										<select name="formsetting[form_recursion]" class="form-control form-group" id="form_recursion_type">
											<option value=""><?= __('admin.select_recursion') ?></option>
											<option <?php if($formsetting['form_recursion'] == 'every_day') { ?> selected <?php } ?> value="every_day"><?=  __('admin.every_day') ?></option>
											<option <?php if($formsetting['form_recursion'] == 'every_week') { ?> selected <?php } ?>  value="every_week"><?=  __('admin.every_week') ?></option>
											<option <?php if($formsetting['form_recursion'] == 'every_month') { ?> selected <?php } ?>  value="every_month"><?=  __('admin.every_month') ?></option>
											<option <?php if($formsetting['form_recursion'] == 'every_year') { ?> selected <?php } ?>  value="every_year"><?=  __('admin.every_year') ?></option>
											<option <?php if($formsetting['form_recursion'] == 'custom_time') { ?> selected <?php } ?>  value="custom_time"><?=  __('admin.custom_time') ?></option>
										</select>
									<div class="custom_time <?php echo ($formsetting['form_recursion'] != 'custom_time') ? 'hide' : '';  ?>">
																		
										<?php
										$form_minutes = $formsetting['recursion_custom_time'];
										$f_day = floor ($form_minutes / 1440);
										$f_hour = floor (($form_minutes - $f_day * 1440) / 60);
										$f_minute = $form_minutes - ($f_day * 1440) - ($f_hour * 60);
										?>
										<input type="hidden" name="formsetting[recursion_custom_time]" value="<?php echo $form_minutes; ?>" class="recursion_custom_time">
										<div class="row">
											<div class="col-sm-4">
												<label class="control-label"><?=  __('admin.days') ?> : </label>
												<input placeholder="<?=  __('admin.days') ?>" type="number" class="form-control recur_day" value="<?= $f_day ? $f_day : '' ?>" onkeydown="if(event.key==='.'){event.preventDefault();}"  oninput="event.target.value = event.target.value.replace(/[^0-9]*/g,'');">
											</div>					
											<div class="col-sm-4">
												<label class="control-label"><?=  __('admin.hours') ?> : </label>
												<select class="form-control recur_hour">
													<?php 
													for ($x = 0; $x <= 23; $x++) {
														$selected = ($x == $f_hour ) ? 'selected="selected"' : '';
														echo '<option value="'.$x.'" '.$selected.'>'.$x.'</option>';
													}
													?>
												</select>
											</div>					
											<div class="col-sm-4">
												<label class="control-label"><?=  __('admin.minutes') ?> : </label>
												<select class="form-control recur_minute">
													<?php 
													for ($x = 0; $x <= 59; $x++) {
														$selected = ($x == $f_minute ) ? 'selected="selected"' : '';
														echo '<option value="'.$x.'" '.$selected.'>'.$x.'</option>';
													}
													?>
												</select>
											</div>					
										</div>
										<small class="error formsetting_error"></small>
									</div>
									<br>
									<div class="endtime-chooser row">
										<div class="col-sm-12">
											<div class="form-group">
												<label class="control-label d-block"><?= __('admin.choose_custom_endtime') ?> <input <?= $formsetting['recursion_endtime'] ? 'checked' : '' ?>  class='setCustomTime' name='recursion_endtime_form_status' type="checkbox"> </label>
												<div style="<?= !$formsetting['recursion_endtime'] ? 'display:none' : '' ?>" class='custom_time_container'>
													<input type="text" class="form-control datetime-picker" value="<?= $formsetting['recursion_endtime'] ? date("d-m-Y H:i",strtotime($formsetting['recursion_endtime'])) : '' ?>" name="formsetting[recursion_endtime]" id="endtime" placeholder="<?= __('admin.choose_endtime') ?>" >
												</div>
											</div>
										</div>
									</div>
									</div>
								
								</div>
								<div role="tabpanel" class="tab-pane" id="payment_api_documentation">
									<div class="clearfix text-right">
										<button type="button" onclick="download()" class="btn btn-export-pdf btn-primary btn-sm"><?=  __('admin.download_as_pdf') ?></button>
									</div>
									<br>
									<link rel="stylesheet" type="text/css" href="<?= base_url('assets/integration/prism/css.css') ?>?v=<?= av() ?>">
									<script type="text/javascript" src="<?= base_url('assets/integration/prism/js.js') ?>"></script>
									<script type="text/javascript" src="<?= base_url('assets/plugins/html2canvas/html2canvas.js') ?>"></script>
									<script type="text/javascript" src="<?= base_url('assets/plugins/html2canvas/jspdf.debug.js') ?>"></script>
									<script type="text/javascript">
										function download(){
											$(".no-pdf").hide();
											$(".btn-export-pdf").btn("loading");
											var HTML_Width = $("#doc-html").width();
											var HTML_Height = $("#doc-html").height();
											var top_left_margin = 15;
											var PDF_Width = HTML_Width+(top_left_margin*2);
											var PDF_Height = (PDF_Width*1.5)+(top_left_margin*2);
											var canvas_image_width = HTML_Width;
											var canvas_image_height = HTML_Height;
										
											var totalPDFPages = Math.ceil(HTML_Height/PDF_Height)-1;
											html2canvas($("#doc-html")[0],{allowTaint:true}).then(function(canvas) {
												canvas.getContext('2d');
											
												var imgData = canvas.toDataURL("image/jpeg", 1.0);
												var pdf = new jsPDF('p', 'pt',  [PDF_Width, PDF_Height]);
												pdf.addImage(imgData, 'JPG', top_left_margin, top_left_margin,canvas_image_width,canvas_image_height);
											
												for (var i = 1; i <= totalPDFPages; i++) { 
													pdf.addPage(PDF_Width, PDF_Height);
													pdf.addImage(imgData, 'JPG', top_left_margin, -(PDF_Height*i)+(top_left_margin*4),canvas_image_width,canvas_image_height);
												}
											
												pdf.save("<?= __('admin.payment_api_documentation') ?>.pdf");
												$(".no-pdf").show();
												$(".btn-export-pdf").btn("reset");
											});
										}
									</script>

									<?php 
										function ___h($text,$lan){
											$text = implode("\n", $text);
											$text = htmlentities($text);
											$text = '<pre class="language-'.$lan.'"><code class="language-'.$lan.'">'.$text.'</code></pre>';
											return $text;
										}
										$base_url  = base_url();
									?>
									<div id="doc-html">
										<div class="row">
											<div class="col-sm-12">
												<div class="card">
													<div class="card-header">
														<h4 class="card-title">How to create payment method</h4>
													</div>
													<div class="card-body payment-doc">
														<p>There are 3 payment methods available in the local store itself and. Although sometimes you'll find yourself in the situation where you need something different, either there is no method available for your choice of payment gateway or you want some different logic. In either case, you're left with the only option: To create a new payment method module in Store.</p>
														<p>We'll assume that our custom payment method name is "custom". There are at least three files you need to create in order to set up the things. Let's check the same in detail.</p>
														<p>You need to create three file. each file are required</p>
														<ol>
															<li>controller</li>
															<li>views</li>
															<li>setting</li>
														</ol>
														<div class="steps">
															<div class="steps-header"><h3>Setting Up the Setting File</h3></div>
															<div class="steps-body">
																<p>Go ahead and create the setting file at <code>application/payment_gateway/settings/custom.php</code>. Paste the following contents in the newly created setting file custom.php.</p>
																<?php
																	$code = array();
																	$code[] = '<div class="form-group">';
																	$code[] = '	<label class="control-label">Status</label>';
																	$code[] = '	<select class="form-control" name="status">';
																	$code[] = '		<option <?= (int)$setting_data[\'status\'] == "0" ? "selected" : "" ?> value="0">Disabled</option>';
																	$code[] = '		<option <?= (int)$setting_data[\'status\'] == "1" ? "selected" : "" ?> value="1">Enabled</option>';
																	$code[] = '	</select>';
																	$code[] = '</div>';
																	echo ___h($code,'php');
																?>
																<p>in this file you can define all setting for admin. like get status, api key, sanbbox details etc.. all setting data you will get inside <code>setting_data</code> variable. and all your setting are save under setting group name conversation like "payment_gateway_[payment_method_name]" you can get inside controller file</p>
															</div>
														</div>
														<div class="steps">
															<div class="steps-header"><h3>Setting Up the View</h3></div>
															<div class="steps-body">
																<p>Go ahead and create the view file at <code>application/payment_gateway/views/custom.php</code>. Paste the following contents in the newly created view file custom.php.</p>
																<?php
																	$code = array();
																	$code[] = '<button class="btn btn-default" onclick="backCheckout()">Back</button>';
																	$code[] = '<button class="btn btn-primary" id="button-confirm">Confirm</button>';
																	$code[] = '<script type="text/javascript">';
																	$code[] = '	$("#button-confirm").click(function(){';
																	$code[] = '		$this = $(this);';

																	$code[] = '		$.ajax({';
																	$code[] = '			url:\'<?= base_url("/store/payment_confirmation") ?>\',';
																	$code[] = '			type:\'POST\',';
																	$code[] = '			dataType:\'json\',';
																	$code[] = '			data:$(\'[name^="comment"]\').serialize(),';
																	$code[] = '			beforeSend:function(){$("#button-confirm").btn("loading");},';
																	$code[] = '			complete:function(){$("#button-confirm").btn("reset");},';
																	$code[] = '			success:function(json){';
																	$code[] = '				$container = $("#checkout-confirm");';
																	$code[] = '				$container.find(".has-error").removeClass("has-error");';
																	$code[] = '				$container.find("span.text-danger").remove();';
																	$code[] = '				if(json[\'errors\']){';
																	$code[] = '					$.each(json[\'errors\'][\'comment\'], function(ii,jj){';
																	$code[] = '					$ele = $container.find(\'#comment_textarea\'+ ii);';
																	$code[] = '					if($ele){';
																	$code[] = '						$ele.parents(".form-group").addClass("has-error");';
																	$code[] = '						$ele.after("<span class=\'text-danger\'>"+ jj +"</span>");';
																	$code[] = '					}';
																	$code[] = '				});';
																	$code[] = '			}';
																	$code[] = '			if(json[\'success\']){';
																	$code[] = '				$.ajax({';
																	$code[] = '					url:\'<?= $base_url ?>/store/confirm_payment\',';
																	$code[] = '					type:"POST",';
																	$code[] = '					dataType:"json",';
																	$code[] = '					data:{';
																	$code[] = '						payment_method: $(\'input[name="payment_method"]:checked\').val()';
																	$code[] = '					},';
																	$code[] = '					beforeSend:function(){';
																	$code[] = '						$this.btn("loading");';
																	$code[] = '					},';
																	$code[] = '					complete:function(){';
																	$code[] = '						$this.btn("reset");';
																	$code[] = '					},';
																	$code[] = '					success:function(json){';
																	$code[] = '						if(json[\'redirect\']){';
																	$code[] = '							window.location = json[\'redirect\'];';
																	$code[] = '						}';
																	$code[] = '						if(json[\'warning\']){';
																	$code[] = '							alert(json[\'warning\'])';
																	$code[] = '						}';
																	$code[] = '					},';
																	$code[] = '				})';
																	$code[] = '			 }';
																	$code[] = '		  },';
																	$code[] = '	   });';
																	$code[] = '	})';
																	$code[] = '</script>';

																	echo ___h($code,'php');
																?>
																<p>this file is last step of checkout. its confirm order you have to do confirm order on <code>/store/confirm_paymen</code> this url call your confirm method on controller file</p>
															</div>
														</div>
														<div class="steps">
															<div class="steps-header"><h3>Setting Up the Controller</h3></div>
															<div class="steps-body">
																<p>Go ahead and create the controller file at <code>application/payment_gateway/controllers/custom.php</code>. Paste the following contents in the newly created controller file custom.php.</p>
																<?php
																	$code = array();
																	$code[] = 'class custom {';
																	$code[] = '	public $title = \'Custom name\';';
																	$code[] = '	public $icon = "assets/images/payments/custom.png";';
																	$code[] = '	public $website = "http:://custom.com";';
																	$code[] = '';
																	$code[] = '	function __construct($api){ $this->api = $api; }';
																	$code[] = '';
																	$code[] = '	public function confirm($data) {';
																	$code[] = '		$json[\'success\'] = true;';
																	$code[] = '		$json[\'redirect\'] = $data[\'thankyou_url\'];';
																	$code[] = '		$this->api->confirm_api($data[\'order_info\'][\'id\'],7);';
																	$code[] = '		return $json;';
																	$code[] = '	}';
																	$code[] = '';
																	$code[] = '	public function getConfirm($data) {';
																	$code[] = '		$view = APPPATH.\'payments/views/custom.php\';';
																	$code[] = '		require $view;';
																	$code[] = '	}';
																	$code[] = '';
																	$code[] = '	public function getMethod($data){';
																	$code[] = '		return array(';
																	$code[] = '			\'html\' => \'<p>Custom name</p>\',';
																	$code[] = '			\'image\' => \'\',';
																	$code[] = '		);';
																	$code[] = '	}';
																	$code[] = '}';
																	echo ___h($code,'php');
																?>
																<div class="func-desc">
																	<?php
																		$code = array();
																		$code[] = 'public function getMethod($data){}';
																		echo ___h($code,'php');
																	?>
																	<p>This function use to get a name or image of payment gateway. image param is optional</p>
																	Inside <code>getMethod($data)</code> you will get following values in side $data array
																	<ol>
																		<li><code>products</code> : cart products list</li>
																		<li><code>is_logged</code> : customer is login on not</li>
																		<li><code>base_url</code> : base url of store</li>
																		<li><code>sub_total</code> : sub total of cart</li>
																	</ol>
																</div>
																<div class="func-desc">
																	<?php
																		$code = array();
																		$code[] = 'public function getConfirm($data){}';
																		echo ___h($code,'php');
																	?>
																	<p>This function use to get a confirm step of your payment method.</p>
																	Inside <code>getConfirm($data)</code> you will get following values in side $data array
																	<ol>
																		<li><code>products</code> : cart products list</li>
																		<li><code>is_logged</code> : customer is login on not</li>
																		<li><code>base_url</code> : base url of store</li>
																		<li><code>sub_total</code> : sub total of cart</li>
																	</ol>
																</div>
																<div class="func-desc">
																	<?php
																		$code = array();
																		$code[] = 'public function confirm($data){}';
																		echo ___h($code,'php');
																	?>
																	<p>This function use to confirm order. functon is call from view file</p>
																	Inside <code>confirm($data)</code> you will get following values in side $data array
																	<ol>
																		<li><code>base_url</code> : base url of application</li>
																		<li><code>thankyou_url</code> : url of thank you page</li>
																		<li><code>order_info</code> : array of order info</li>
																		<li><code>products</code> : array of order products</li>
																	</ol>
																</div>
																<div class="func-desc">
																	<?php
																		$code = array();
																		$code[] = '$this->api->confirm_api($order_id, $status, $transaction_id = "", $comment = "")';
																		echo ___h($code,'php');
																	?>
																	<p>this function Use to confirm order. add order history</p>
																	<ol>
																		<li><code>order_id</code> : order id you can get from $data['order_info']['id']</li>
																		<li><code>status</code> : status id you can get from below list</li>
																		<li><code>transaction_id</code> : its optional. if you have transaction_id than pass it</li>
																		<li><code>comment</code> : its optional. if have any comment for order than pass it</li>
																	</ol>
																</div>
																<div class="func-desc">
																	<p>How to get config setting data</p>
																	<?php
																		$code = array();
																		$code[] = '$setting = $this->api->Product_model->getSettings(\'payment_gateway_custom\');';
																		echo ___h($code,'php');
																	?>
																</div>
																<div class="func-desc">
																	<p>How to call your custom method outside from controllers file</p>
																	<p>
																		[base_url]/callbackfunctions/[payment_method_name]/[custom_function_name]/[function_argument]
																	</p>
																	<p> 
																		For example inside your controller have notify($order_id) method. than your calling url is like this
																		<?php
																			$code = array();
																			$code[] = '$url = base_url("store/callbackfunctions/custom/notify/1");';
																			echo ___h($code,'php');
																		?>
																	</p>
																</div>
															</div>
														</div>
														<div class="steps">
															<div class="steps-header"><h3>Order Status ID and Titles</h3></div>
															<div class="steps-body p-0">
																<table class="table-striped table table-sm">
																	<tr><th width="90px">Status ID</th><th>Title</th></tr>
																	<tr><td>0</td><td>Waiting For Payment</td></tr>
																	<tr><td>1</td><td>Complete</td></tr>
																	<tr><td>2</td><td>Total not match</td></tr>
																	<tr><td>3</td><td>Denied</td></tr>
																	<tr><td>4</td><td>Expired</td></tr>
																	<tr><td>5</td><td>Failed</td></tr>
																	<tr><td>6</td><td>Pending</td></tr>
																	<tr><td>7</td><td>Processed</td></tr>
																	<tr><td>8</td><td>Refunded</td></tr>
																	<tr><td>9</td><td>Reversed</td></tr>
																	<tr><td>10</td><td>Voided</td></tr>
																	<tr><td>11</td><td>Canceled Reversal</td></tr>
																</table>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>							
								</div>
								<div role="tabpanel" class="tab-pane" id="order_comment">
									<div class="form-group">
										<label class="control-label"><?= __('admin.enable_comment') ?></label>
										<select class="form-control" name="order_comment[status]">
											<option value="0"><?= __('admin.disable') ?></option>
											<option value="1" <?= $order_comment['status'] ? 'selected' : '' ?>><?= __('admin.enable') ?></option>
										</select>
									</div>
									<div class="comment-titles">
										<table class="table table-borderd">
											<thead>
												<th><?= __('admin.title') ?></th>
												<th class="text-right"><?= __('admin.action') ?></th>
											</thead>
											<tbody>
												<?php foreach ($order_comment['title'] as $key => $value) { ?>
												<tr>
													<td>
														<input type="text" name="order_comment[title][<?= $key ?>]" value="<?= $value ?>" class="form-control" placeholder="<?= __('admin.comment_title') ?>" aria-describedby="title-<?= $key ?>" />
													</td>
													<td class="text-right">
														<button type="button" class="btn btn-danger" onclick="$(this).closest('tr').remove()"><i class="fa fa-trash"></i></button>
													</td>
												</tr>
												<?php } ?>
											</tbody>
											<tfoot>
												<tr>
													<td colspan="2" class="text-right">
														<button type="button" class="btn btn-primary btn-add-comment"><i class="fa fa-plus"></i></button>
													</td>
												</tr>
											</tfoot>	
										</table>
									</div>
								</div>
								<div role="tabpanel" class="tab-pane" id="theme_section">
									<div class="form-group">
										<label class="control-label"><?= __('admin.categories_color_box_filter') ?></label>
										<select class="form-control" name="store[is_variation_filter]">
											<option value="0"><?= __('admin.disable') ?></option>
											<option value="1" <?= $store_setting['is_variation_filter'] ? 'selected' : '' ?>><?= __('admin.enable') ?></option>
										</select>
									</div>
									<div class="form-group">
										<label class="control-label"><?= __('admin.top_tags_limit') ?></label>
										<input type="number" name="store[top_tags_limit]" class="form-control"value="<?= $store_setting['top_tags_limit'] ? $store_setting['top_tags_limit'] : 10 ?>">
									</div>
									<fieldset class="mb-3">
										<legend class="bg-light px-2"><?= __('admin.store_notifications') ?></legend>
										<div id="notifications-list" class="row">
											<?php
											$notis = json_decode($store_setting['notification']);
											for ($i=0; $i < sizeOf($notis); $i++) { 
											?>
											<div class="col-md-12">
												<div class="form-group">
													<label class="control-label"><?= __('admin.notification') ?> <?= ($i+1) ?></label>
													<input name="store[notification][]" class="form-control" type="text" value="<?= $notis[$i] ?>">
												</div>
												<button type="button" class="btn btn-danger btn-md remove-notification-btn" style="position: absolute; top: 30px; right: 11px;"><i class="fa fa-trash"></i></button>
											</div>
											<?php	
											}
											?>										
										</div>
										<button type="button" class="btn btn-md btn-primary btn-add-more"><?= __('admin.add_more') ?></button>
									</fieldset>
									<fieldset class="mb-3">
										<legend class="bg-light px-2"><?= __('admin.homepage_slider') ?></legend>
										<div class="row">
											<div class="col-12">
												<table class="table">
													<tbody id="homepage_sliders_list">
													<?php
													$homepage_slider = json_decode($store_setting['homepage_slider']);

													if(!sizeof($homepage_slider) > 0) {
														echo "<tr class='empty'><td colspan='1oo%'><h6 class='text-center text-muted'>".__('admin.sliders_not_available')."</h6></td></tr>";
													}

													foreach($homepage_slider as $hs){
													?>
														<tr>
															<td scope="row"><?= $hs->index; ?></td>
															<td scope="row"><?= $hs->title; ?></td>
															<td scope="row"><?= $hs->sub_title; ?></td>
															<?php $img = (!empty($hs->slider_background_image)) ? base_url('assets/images/site/'. $hs->slider_background_image) : base_url('assets/store/default/img/banner.png'); ?>
															<td style="width: 200px;"><img style="width: 100px; height: 50px;" src="<?= $img; ?>" class='img-responsive'></td>
															<td style="width: 87px; padding: 5px 0px !important;">
																<input type="hidden" name="store[homepage_slider][edited][]" value="0">
																<input type="hidden" name="store[homepage_slider][index][]" value="<?= $hs->index; ?>">
																<input type="hidden" name="store[homepage_slider][title][]" value="<?= $hs->title; ?>">
																<input type="hidden" name="store[homepage_slider][sub_title][]" value="<?= $hs->sub_title; ?>">
																<textarea name="store[homepage_slider][content][]" style="display:none;"><?= $hs->content; ?></textarea>
																<input type="hidden" name="store[homepage_slider][slider_background_image][]" value="<?= $hs->slider_background_image; ?>">
																<input type="hidden" name="store[homepage_slider][button_text][]" value="<?= $hs->button_text; ?>">
																<input type="hidden" name="store[homepage_slider][button_link][]" value="<?= $hs->button_link; ?>">
																<input type="hidden" name="store[homepage_slider][slider_text_color][]" value="<?= $hs->slider_text_color; ?>">
																<input type="hidden" name="store[homepage_slider][button_text_color][]" value="<?= $hs->button_text_color; ?>">
																<input type="hidden" name="store[homepage_slider][button_bg_color][]" value="<?= $hs->button_bg_color; ?>">
																<button type="button" class="btn btn-primary btn-slider-form-modal-edit"><i class="fa fa-pencil"></i></button>
																<button type="button" class="btn btn-danger remove-slider-btn"><i class="fa fa-trash"></i></button>
															</td>
														</tr>
													<?php	
													}
													?>
													</tbody>
												</table>
											</div>
										</div>
										<button type="button" class="btn btn-md btn-primary btn-slider-form-modal"><?= __('admin.add_more') ?></button>
									</fieldset>
									<fieldset class="mb-3">
										<legend class="bg-light px-2"><?= __('admin.homepage_features') ?></legend>
										<div class="row">
											<div class="col-12">
												<table class="table">
													<tbody id="homepage_features_list">
														<?php
														$homepage_features = json_decode($store_setting['homepage_features']);

														if(!sizeof($homepage_features) > 0) {
															echo "<tr class='empty'><td colspan='1oo%'><h6 class='text-center text-muted'>".__('admin.features_not_available')."</h6></td></tr>";
														}
		
														foreach($homepage_features as $hf){
														?>
															<tr>
																<td scope="row"><?= $hf->index; ?></td>
																<td scope="row"><?= $hf->title; ?></td>
																<td scope="row"><?= $hf->sub_title; ?></td>
																<?php $img = (!empty($hf->feature_image)) ? base_url('assets/images/site/'. $hf->feature_image) : base_url('assets/store/default/img/banner.png'); ?>
																<td style="width: 200px;"><img style="width: 100px; height: 50px;" src="<?= $img; ?>" class='img-responsive'></td>
																<td style="width: 87px; padding: 5px 0px !important;">
																	<input type="hidden" name="store[homepage_features][edited][]" value="0">
																	<input type="hidden" name="store[homepage_features][index][]" value="<?= $hf->index; ?>">
																	<input type="hidden" name="store[homepage_features][title][]" value="<?= $hf->title; ?>">
																	<input type="hidden" name="store[homepage_features][sub_title][]" value="<?= $hf->sub_title; ?>">
																	<input type="hidden" name="store[homepage_features][feature_image][]" value="<?= $hf->feature_image; ?>">
																	<button type="button" class="btn btn-primary btn-features-form-modal-edit"><i class="fa fa-pencil"></i></button>
																	<button type="button" class="btn btn-danger remove-features-btn"><i class="fa fa-trash"></i></button>
																</td>
															</tr>
														<?php	
														}
														?>
													</tbody>
												</table>
											</div>
										</div>
										<button type="button" class="btn btn-md btn-primary btn-features-form-modal"><?= __('admin.add_more') ?></button>
									</fieldset>
									<fieldset class="mb-3">
										<legend class="bg-light px-2"><?= __('admin.homepage_bottom_banner') ?></legend>
										<div class="row">
											<?php $homepage_banner = json_decode($store_setting['homepage_banner']); ?>
											<div class="col-12">
												<div class="form-group">
													<label  class="control-label"><?= __('admin.banner_title') ?></label>
													<input  name="store[homepage_banner][title]" value="<?= $homepage_banner->title; ?>" class="form-control"  type="text">
												</div>
											</div>
											<div class="col-12">
												<div class="form-group">
													<label  class="control-label"><?= __('admin.banner_content') ?></label>
													<textarea name="store[homepage_banner][content]" class="form-control"><?= $homepage_banner->content; ?></textarea>
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
													<label  class="control-label"><?= __('admin.banner_bottom_text') ?></label>
													<input  name="store[homepage_banner][button_text]" value="<?= $homepage_banner->button_text; ?>" class="form-control"  type="text">
												</div>
											</div>
											<div class="col-md-8">
												<div class="form-group">
													<label  class="control-label"><?= __('admin.banner_bottom_link') ?></label>
													<input  name="store[homepage_banner][button_link]" value="<?= $homepage_banner->button_link; ?>" class="form-control"  type="text">
												</div>
											</div>
										</div>
									</fieldset>
									<fieldset class="mb-3">
										<legend class="bg-light px-2"><?= __('admin.homepage_bottom_section') ?></legend>
										<div class="row">
											<div class="col-12 mb-4">
												<label  class="control-label"><?= __('admin.section_cards') ?></label>
												<table class="table">
													<tbody id="bs_cards_list">
														<?php
														$bs_cards = json_decode($store_setting['bs_cards']);

														if(!sizeof($bs_cards) > 0) {
															echo "<tr class='empty'><td colspan='1oo%'><h6 class='text-center text-muted'>".__('admin.cards_not_available')."</h6></td></tr>";
														}

														foreach($bs_cards as $bsc){
														?>
															<tr>
																<td scope="row"><?= $bsc->index; ?></td>
																<td scope="row"><?= $bsc->title; ?></td>
																<td scope="row"><?= $bsc->sub_title; ?></td>
																<?php $img = (!empty($bsc->feature_image)) ? base_url('assets/images/site/'. $bsc->feature_image) : base_url('assets/store/default/img/banner.png'); ?>
																<td style="width: 200px;"><img style="width: 100px; height: 50px;" src="<?= $img; ?>" class='img-responsive'></td>
																<td style="width: 87px; padding: 5px 0px !important;">
																	<input type="hidden" name="store[bs_cards][edited][]" value="0">
																	<input type="hidden" name="store[bs_cards][index][]" value="<?= $bsc->index; ?>">
																	<input type="hidden" name="store[bs_cards][title][]" value="<?= $bsc->title; ?>">
																	<input type="hidden" name="store[bs_cards][sub_title][]" value="<?= $bsc->sub_title; ?>">
																	<input type="hidden" name="store[bs_cards][feature_image][]" value="<?= $bsc->feature_image; ?>">
																	<input type="hidden" name="store[bs_cards][bg_color][]" value="<?= $bsc->bg_color; ?>">
																	<button type="button" class="btn btn-primary btn-bs-cards-form-modal-edit"><i class="fa fa-pencil"></i></button>
																	<button type="button" class="btn btn-danger remove-bs-cards-btn"><i class="fa fa-trash"></i></button>
																</td>
															</tr>
														<?php	
														}
														?>
													</tbody>
												</table>
												<button type="button" class="btn btn-md btn-primary btn-bs-cards-form-modal"><?= __('admin.add_more') ?></button>
											</div>
											<div class="col-12">
												<div class="form-group">
													<label  class="control-label"><?= __('admin.section_content') ?></label>
													<textarea name="store[homepage_bottom_section][content]" class="form-control summernote"><?= json_decode($store_setting['homepage_bottom_section'])->content; ?></textarea>
												</div>
											</div>
										</div>
									</fieldset>
								</div>
								<div role="tabpanel" class="tab-pane" id="pages_menu_section">
									<fieldset class="mb-3">
										<legend class="bg-light px-2"><?= __('admin.footer_menu_sections') ?></legend>
										<div class="row">
											<div class="col-12">
												<table class="table">
													<tbody id="footer_menu_list">
														<?php
														$footer_menu = json_decode($store_setting['footer_menu']);
														if(!sizeof($footer_menu) > 0) {
															echo "<tr class='empty'><td colspan='1oo%'><h6 class='text-center text-muted'>".__('admin.menu_not_available')."</h6></td></tr>";
														}
														foreach($footer_menu as $fm){
															$letpreIndex = $fm->index - 1;
														?>
															<tr>
																<td scope="row"><?= $fm->index; ?></td>
																<td scope="row"><?= $fm->title; ?></td>
																<td scope="row">
																	<?php
																		if(!sizeof($fm->links) > 0) {
																			$text = "<i class='muted'>".__('admin.not_available')."</i>";
																		} else {
																			$text = "";
																		}
																		for ($i=0; $i < sizeOf($fm->links); $i++) { 
																			$text .= ($i == 0) ? $fm->links[$i]->title : ", ".$fm->links[$i]->title;
																		}
																		echo $text;
																	?>
																</td>
																<td style="width: 87px; padding: 5px 0px !important;">
																	<input type="hidden" name="store[footer_menu][index][<?= $letpreIndex ?>]" value="<?= $fm->index; ?>">
																	<input type="hidden" name="store[footer_menu][title][<?= $letpreIndex ?>]" value="<?= $fm->title; ?>">
																	<?php
																		for ($i=0; $i < sizeOf($fm->links); $i++) { 
																			$text .= ($i == 0) ? $fm->links[$i]->title : ", ".$fm->links[$i]->title;
																			?>
																			<input type="hidden" name="store[footer_menu][links][<?= $letpreIndex ?>][title][]" value="<?= $fm->links[$i]->title; ?>">
																			<input type="hidden" name="store[footer_menu][links][<?= $letpreIndex ?>][url][]" value="<?= $fm->links[$i]->url; ?>">
																			<input type="hidden" name="store[footer_menu][links][<?= $letpreIndex ?>][type][]" value="<?= $fm->links[$i]->type; ?>">
																			<?php
																		}
																	?>
																	<button data-letpreindex="<?= $letpreIndex ?>" type="button" class="btn btn-primary btn-footer-menu-form-modal-edit"><i class="fa fa-pencil"></i></button>
																	<button type="button" class="btn btn-danger remove-footer-menu"><i class="fa fa-trash"></i></button>
																</td>
															</tr>
														<?php	
														}
														?>
													</tbody>
												</table>
											</div>
										</div>
										<button type="button" class="btn btn-md btn-primary btn-footer-menu-form-modal"><?= __('admin.add_more') ?></button>
									</fieldset>

									<fieldset class="mb-3">
										<legend class="bg-light px-2"><?= __('admin.manage_custom_pages') ?></legend>
										<div class="row">
											<div class="col-12">
												<table class="table">
													<tbody id="custom_page_list">
														<?php
														$custom_page = json_decode($store_setting['custom_page']);
														if(!sizeof($custom_page) > 0) {
															echo "<tr class='empty'><td colspan='1oo%'><h6 class='text-center text-muted'>".__('admin.pages_not_available')."</h6></td></tr>";
														}
														foreach($custom_page as $page){
														?>
															<tr>
																<td scope="row"><?= $page->title; ?></td>
																<td scope="row"><?= $page->slug; ?></td>
																<?php $img = (!empty($page->image)) ? base_url('assets/images/site/'. $page->image) : base_url('assets/store/default/img/banner.png'); ?>
																<td style="width: 200px;"><img style="width: 100px; height: 50px;" src="<?= $img; ?>" class='img-responsive'></td>
																<td style="width: 87px; padding: 5px 0px !important;">
																	<input type="hidden" name="store[custom_page][index][]" value="<?= $page->index; ?>">
																	<input type="hidden" name="store[custom_page][edited][]" value="0">
																	<input type="hidden" name="store[custom_page][title][]" value="<?= $page->title; ?>">
																	<input type="hidden" name="store[custom_page][slug][]" value="<?= $page->slug; ?>">
																	<input type="hidden" name="store[custom_page][image][]" value="<?= $page->image; ?>">
																	<input type="hidden" name="store[custom_page][meta_id][]" value="<?= $page->meta_id; ?>">
																	<textarea name="store[custom_page][content][]" style="display:none"><?= $page->content; ?></textarea>
																	<button type="button" class="btn btn-primary btn-custom-page-modal-form-edit"><i class="fa fa-pencil"></i></button>
																	<button type="button" class="btn btn-danger remove-custom-page"><i class="fa fa-trash"></i></button>
																</td>
															</tr>
														<?php	
														}
														?>
													</tbody>
												</table>
											</div>
										</div>
										<button type="button" class="btn btn-md btn-primary btn-custom-page-modal-form"><?= __('admin.add_more') ?></button>
									</fieldset>
									
									<fieldset class="mb-3">
										<legend class="bg-light px-2"><?= __('admin.manage_social_links') ?></legend>
										<div class="row">
											<div class="col-12">
												<table class="table">
													<tbody id="social_links_list">
														<?php
														$social_links = json_decode($store_setting['social_links']);
														if(!sizeof($social_links) > 0) {
															echo "<tr class='empty'><td colspan='1oo%'><h6 class='text-center text-muted'>".__('admin.links_not_available')."</h6></td></tr>";
														}
														foreach($social_links as $link){
														?>
															<tr>
																<td scope="row"><?= $link->title; ?></td>
																<td scope="row"><?= $link->url; ?></td>
																<?php $img = (!empty($link->image)) ? base_url('assets/images/site/'. $link->image) : base_url('assets/store/default/img/banner.png'); ?>
																<td style="width: 200px; text-align:right;">
																	<img style="width: 50px; height: 50px; background-color:grey;" src="<?= $img; ?>" class='img-responsive'>
																</td>
																<td style="width: 87px; padding: 5px 0px !important;">
																	<input type="hidden" name="store[social_links][index][]" value="<?= $link->index; ?>">
																	<input type="hidden" name="store[social_links][edited][]" value="0">
																	<input type="hidden" name="store[social_links][title][]" value="<?= $link->title; ?>">
																	<input type="hidden" name="store[social_links][url][]" value="<?= $link->url; ?>">
																	<input type="hidden" name="store[social_links][image][]" value="<?= $link->image; ?>">
																	<button type="button" class="btn btn-primary btn-social-links-form-edit"><i class="fa fa-pencil"></i></button>
																	<button type="button" class="btn btn-danger remove-social-links"><i class="fa fa-trash"></i></button>
																</td>
															</tr>
														<?php	
														}
														?>
													</tbody>
												</table>
											</div>
										</div>
										<button type="button" class="btn btn-md btn-primary btn-social-links-form"><?= __('admin.add_more') ?></button>
									</fieldset>

									<div class="form-group">
										<label  class="control-label"><?= __('admin.about_page_content') ?></label>
										<textarea name="store[about_content]" class="form-control summernote"><?php echo $store['about_content']; ?></textarea>
									</div>


									<div class="col-md-7">
											<div class="form-group">
												<label  class="control-label"><?= __('admin.about_page_image') ?></label>
												<br/>
												<input type="file" name="store_aboutimage">
											</div>
										</div>
										<div class="col-md-4">
											<?php
											if(!empty($store['aboutimage']))
											{
												?>
												<img id="store_aboutimage_container"  style="width: 150px;" src="<?= base_url('assets/images/site/'.$store['aboutimage'].''); ?>" class='img-responsive'>
												<?php	
											}
											else
											{
												?>
												<img id="store_aboutimage_container"  style="width: 150px;" src="<?= base_url('assets/vertical/assets/images/users/avatar-1.jpg'); ?>" class='img-responsive'>
												<?php
											}
											?>
											
										</div>

									<div class="form-group">
										<label  class="control-label"><?= __('admin.contact_page_content') ?></label>
										<textarea name="store[contact_content]" class="form-control summernote"><?php echo $store['contact_content']; ?></textarea>
									</div>
									<div class="col-md-7">
											<div class="form-group">
												<label  class="control-label"><?= __('admin.contact_page_image') ?></label>
												<br/>
												<input type="file" name="store_contactimage">
											</div>
										</div>
										<div class="col-md-4">
											<?php
											if(!empty($store['contactimage']))
											{
												?>
												<img id="store_contactimage_container"  style="width: 150px;" src="<?= base_url('assets/images/site/'.$store['contactimage'].''); ?>" class='img-responsive'>
												<?php	
											}
											else
											{
												?>
												<img id="store_contactimage_container"  style="width: 150px;" src="<?= base_url('assets/vertical/assets/images/users/avatar-1.jpg'); ?>" class='img-responsive'>
												<?php
											}
											?>
											
										</div>
									<div class="form-group">
										<label  class="control-label"><?= __('admin.policy_page_content') ?></label>
										<textarea name="store[policy_content]" class="form-control summernote"><?php echo $store['policy_content']; ?></textarea>
									</div>
									<div class="col-md-7">
										<div class="form-group">
											<label  class="control-label"><?= __('admin.policy_page_image') ?></label>
											<br/>
											<input type="file" name="store_policyimage">
										</div>
									</div>
									<div class="col-md-4">
										<?php
										if(!empty($store['policyimage']))
										{
											?>
											<img id="store_policyimage_container"  style="width: 150px;" src="<?= base_url('assets/images/site/'.$store['policyimage'].''); ?>" class='img-responsive'>
											<?php	
										}
										else
										{
											?>
											<img id="store_policyimage_container"  style="width: 150px;" src="<?= base_url('assets/vertical/assets/images/users/avatar-1.jpg'); ?>" class='img-responsive'>
											<?php
										}
										?>
										
									</div>
								</div>
							</div>
						</div>	
					</div>
				</div>
				<div class="card-footer text-right">
					<button type="submit" class="btn btn-sm btn-primary btn-submit"><?= __('admin.save_settings') ?></button>
				</div>
			</div>
		</div>
	</div>

	<!-- modal -->
	<div class="modal fade slider-form-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"><?= __('admin.manage_homepage_slide') ?></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body" style="max-height:70vh; overflow-y:auto;">
					<input  id="hs_index" value="" class="form-control"  type="hidden">
					<input type="hidden" id="hs_slider_background_image" value="">
					<div class="form-group">
						<label  class="control-label"><?= __('admin.slider_title') ?></label>
						<input  id="hs_title" value="" class="form-control"  type="text">
					</div>
					<div class="form-group">
						<label  class="control-label"><?= __('admin.slider_sub_title') ?></label>
						<input  id="hs_sub_title" value="" class="form-control"  type="text">
					</div>
					<div class="form-group">
						<label  class="control-label"><?= __('admin.slider_content') ?></label>
						<textarea id="hs_content" class="form-control"></textarea>
					</div>
					<div class="row border p-2 m-1">
						<div class="col-md-7">
							<div class="form-group">
								<label  class="control-label"><?= __('admin.slider_background_image') ?></label>
								<br/>
								<input type="file" name="store_hsbackgroundimage">
							</div>
						</div>
						<div class="col-md-4">
							<img id="store_hsbackgroundimage_container" style="width: 100%; height:100px;" src="<?= base_url('assets/store/default/img/banner.png'); ?>" class='img-responsive'>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label  class="control-label"><?= __('admin.slider_button_text') ?></label>
								<input  id="hs_button_text" value="" class="form-control"  type="text">
							</div>
						</div>
						<div class="col-md-8">
							<div class="form-group">
								<label  class="control-label"><?= __('admin.slider_button_link') ?></label>
								<input  id="hs_button_link" value="" class="form-control"  type="text">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label  class="control-label"><?= __('admin.slider_text_color') ?></label>
								<input id="hs_text_color" value="#FFFFFF" class="form-control jscolor" data-jscolor type="text">
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label  class="control-label"><?= __('admin.slider_button_text_color') ?></label>
								<input id="hs_button_text_color" value="#000000" class="form-control jscolor" data-jscolor type="text">
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label  class="control-label"><?= __('admin.slider_button_background_color') ?></label>
								<input id="hs_button_bg_color" value="#FFFFFF" class="form-control jscolor" data-jscolor type="text">
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<span id="slider-form-submit" class="btn btn-md btn-primary"><?= __('admin.save_settings') ?></span>
				</div>
			</div>
		</div>
	</div>

	<!-- modal -->
	<div class="modal fade features-form-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"><?= __('admin.manage_homepage_features') ?></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body" style="max-height:70vh; overflow-y:auto;">
					<input type="hidden" id="hf_index" value="">
					<input type="hidden" id="hf_feature_image" value="">
					<div class="form-group">
						<label  class="control-label"><?= __('admin.feature_title') ?></label>
						<input  id="hf_title" value="" class="form-control"  type="text">
					</div>
					<div class="form-group">
						<label  class="control-label"><?= __('admin.feature_subtitle') ?></label>
						<input  id="hf_sub_title" value="" class="form-control"  type="text">
					</div>
					<div class="row border p-2 m-1">
						<div class="col-md-7">
							<div class="form-group">
								<label  class="control-label"><?= __('admin.feature_image') ?></label>
								<br/>
								<input type="file" name="store_hfimage">
							</div>
						</div>
						<div class="col-md-4">
							<img id="store_hfimage_container" src="" style="width: 100%; height:100px;" class='img-responsive'>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<span id="features-form-submit" class="btn btn-md btn-primary"><?= __('admin.save_settings') ?></span>
				</div>
			</div>
		</div>
	</div>

	<!-- modal -->
	<div class="modal fade bs-cards-form-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"><?= __('admin.manage_bottom_sections_cards') ?></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body" style="max-height:70vh; overflow-y:auto;">
					<input type="hidden" id="bsc_index" value="">
					<input type="hidden" id="bsc_feature_image" value="">
					<div class="form-group">
						<label  class="control-label"><?= __('admin.feature_title') ?></label>
						<input  id="bsc_title" value="" class="form-control"  type="text">
					</div>
					<div class="form-group">
						<label  class="control-label"><?= __('admin.feature_subtitle') ?></label>
						<input  id="bsc_sub_title" value="" class="form-control"  type="text">
					</div>
					<div class="row border p-2 m-1">
						<div class="col-md-7">
							<div class="form-group">
								<label  class="control-label"><?= __('admin.feature_image') ?></label>
								<br/>
								<input type="file" name="store_bscimage">
							</div>
						</div>
						<div class="col-md-4">
							<img id="store_bscimage_container" src="" style="width: 100%; height:100px;" class='img-responsive'>
						</div>
					</div>
					<div class="form-group">
						<label  class="control-label"><?= __('admin.slider_button_background_color') ?></label>
						<input id="bsc_bg_color" value="#FFFFFF" class="form-control jscolor" data-jscolor type="text">
					</div>
				</div>
				<div class="modal-footer">
					<span id="bs-cards-form-submit" class="btn btn-md btn-primary"><?= __('admin.save_settings') ?></span>
				</div>
			</div>
		</div>
	</div>

	<!-- modal custom page -->
	<div class="modal fade custom-page-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"><?= __('admin.manage_custom_pages') ?></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body" style="max-height:70vh; overflow-y:auto;">
					<input type="hidden" id="cp_index" value="">
					<input type="hidden" id="cp_image" value="">
					<input type="hidden" id="cp_meta_id" value="">
					<div class="form-group">
						<label  class="control-label"><?= __('admin.page_title') ?></label>
						<input  id="cp_title" value="" class="form-control"  type="text">
					</div>
					<div class="form-group">
						<label  class="control-label"><?= __('admin.page_content') ?></label>
						<textarea id="cp_content" class="form-control summernote"></textarea>
					</div>
					<div class="row border p-2 m-1">
						<div class="col-md-7">
							<div class="form-group">
								<label  class="control-label"><?= __('admin.page_image') ?></label>
								<br/>
								<input type="file" name="store_cpimage">
							</div>
						</div>
						<div class="col-md-4">
							<img id="store_cpimage_container" src="" style="width: 100%; height:100px;" class='img-responsive'>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<span id="custom-page-submit" class="btn btn-md btn-primary"><?= __('admin.save_settings') ?></span>
				</div>
			</div>
		</div>
	</div>

	<!-- modal social links -->
	<div class="modal fade social-links-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"><?= __('admin.manage_social_links') ?></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body" style="max-height:70vh; overflow-y:auto;">
					<input type="hidden" id="sl_index" value="">
					<input type="hidden" id="sl_image" value="">
					<div class="form-group">
						<label  class="control-label"><?= __('admin.link_title') ?></label>
						<input  id="sl_title" value="" class="form-control"  type="text">
					</div>
					<div class="form-group">
						<label  class="control-label"><?= __('admin.link_url') ?></label>
						<input  id="sl_url" value="" class="form-control"  type="text">
					</div>
					
					<div class="row border p-2 m-1">
						<div class="col-md-7">
							<div class="form-group">
								<label  class="control-label"><?= __('admin.link_icon') ?></label>
								<br/>
								<input type="file" name="store_slicon">
							</div>
						</div>
						<div class="col-md-4">
							<img id="store_slicon_container" src="" style="width: 100%; height:100px;" class='img-responsive'>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<span id="social-links-submit" class="btn btn-md btn-primary"><?= __('admin.save_settings') ?></span>
				</div>
			</div>
		</div>
	</div>
</form>


<!-- modal footer menu section -->
<div class="modal fade footer-menu-form-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><?= __('admin.manage_footer_menu') ?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" style="max-height:70vh; overflow-y:auto;">
				<form class="form-horizontal" method="post" action="" id="footer-menu-form">
					<input type="hidden" name="fm_index" value="">
					<div class="form-group">
						<label  class="control-label"><?= __('admin.menu_title') ?></label>
						<input  name="fm_title" value="" class="form-control"  type="text">
					</div>
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label  class="control-label"><?= __('admin.menu_type') ?></label>
								<select class="form-control" name="fm_type">
									<option value="custom"><?= __('admin.custom_menu') ?></option>
									<option value="page"><?= __('admin.pages') ?></option>
									<option value="category"><?= __('admin.categories') ?></option>
								</select>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label  class="control-label"><?= __('admin.available_links') ?></label>
								<select class="form-control" name="fml_type" disabled>
									<option value="" disabled><?= __('admin.select_link') ?></option>
									<?php 
										echo '<option value="'.base_url('store/category/').'" data-fm_type="category" style="dispaly:none">All Categories</option>';
										foreach($categories as $cat) {
											echo '<option value="'.base_url('store/category/').$cat['slug'].'" data-fm_type="category" style="dispaly:none">'.$cat['name'].'</option>';
										}
									?>
									<?php 
										foreach($pages as $page) {
											echo '<option value="'.base_url('store/').$page['slug'].'" data-fm_type="page" style="dispaly:none">'.$page['name'].'</option>';
										}
									?>
								</select>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label  class="control-label"><?= __('admin.link_title') ?></label>
								<input  name="fml_title" value="" class="form-control"  type="text">
							</div>
						</div>
						<div class="col-md-10">
							<div class="form-group">
								<label  class="control-label"><?= __('admin.link_url') ?></label>
								<input disabled name="fml_url" value="" class="form-control"  type="text">
							</div>
						</div>
						<div class="col-md-1 pt-4">
							<span class="btn btn-primary btn-add-link" style="margin-top:6px;">+ <?= __('admin.add') ?></span>
						</div>
					</div>
					<table id="menu_items_list" class="table w-100">
						<thead>
							<tr>
								<th><?= __('admin.title') ?></th>
								<th><?= __('admin.url') ?></th>
								<th></th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</form>
			</div>
			<div class="modal-footer">
				<span id="footer-menu-form-submit" class="btn btn-md btn-primary"><?= __('admin.save_settings') ?></span>
			</div>
		</div>
	</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script type="text/javascript">
	$('.setting-nnnav li a').on('shown.bs.tab', function(event){
		var x = $(event.target).attr('href');
		$(".btn-submit").hide();

		if(x != '#site-fronttemplate'){
			$(".btn-submit").show();
		}
		localStorage.setItem("last_pill", x);
	});

	$(document).on('ready',function() {
		var last_pill = localStorage.getItem("last_pill");
		if(last_pill){ $('[href="'+ last_pill +'"]').click() }
	});

	$('#endtime,.datetime-picker').datetimepicker({
		format:'d-m-Y H:i',
		inline:true,
	});
	$('.setCustomTime').on('change', function(){
		$parents = $(this).parents(".form-group");
		$parents.find(".custom_time_container").hide();
		if($(this).prop("checked")){
			$parents.find(".custom_time_container").show();
		}
	});
	$(document).on('ready',function() {
		$('.summernote').summernote({
			tabsize: 2,
			height: 400
		});
	});
	$(".btn-submit").on('click',function(evt){
	    evt.preventDefault();	
		submit_store_setting();    
    	
	});

	$(document).on('change', "select[name='store[status]']", function(){
		if($(this).val() != 1) {
			$("select[name='store[menu_on_front]']").val(0).trigger('change');
			$("select[name='store[menu_on_front]']").attr('disabled', true);
		} else {
			$("select[name='store[menu_on_front]']").val($("select[name='store[menu_on_front]']").data('existing-value')).trigger('change');
			$("select[name='store[menu_on_front]']").removeAttr('disabled', true);
		}
	});


	function submit_store_setting(data=false){
		let do_not_submit = false;
		
		let ps_product_commission_type = $('select[name="productsetting[product_commission_type]"]').val();
		let ps_product_commission = $('input[name="productsetting[product_commission]"]').val();
		let ps_product_ppc = $('input[name="productsetting[product_ppc]"]').val();
		let ps_product_noofpercommission = $('input[name="productsetting[product_noofpercommission]"]').val();

		if(ps_product_commission != "" && ps_product_ppc != "" && ps_product_noofpercommission != "") {
			if(ps_product_commission_type == "") {
				do_not_submit = true;
				Swal.fire({
					icon: 'warning',
					title: 'Warning',
					text: '<?= __('admin.product_comission_type_should_not_be_empty') ?>'
				});
			}
		}

		let fs_product_commission_type = $('select[name="formsetting[product_commission_type]"]').val();
		let fs_product_commission = $('input[name="formsetting[product_commission]"]').val();
		let fs_product_ppc = $('input[name="formsetting[product_ppc]"]').val();
		let fs_product_noofpercommission = $('input[name="formsetting[product_noofpercommission]"]').val();


		if(fs_product_commission != "" && fs_product_ppc != "" && fs_product_noofpercommission != "") {
			if(fs_product_commission_type == "") {
				do_not_submit = true;
				Swal.fire({
					icon: 'warning',
					title: 'Warning',
					text: '<?= __('admin.form_comission_type_shoul_not_be_empty') ?>'
				});
			}
		}
		
		if(!do_not_submit) {
			var formData = new FormData($("#setting-form")[0]);  
		    $(".btn-submit").btn("loading");

			if(data != null) {
				formData.append(data.name, data.value);
			}

			if(!formData.has("store[menu_on_front]")) {
				formData.append("store[menu_on_front]", $("select[name='store[menu_on_front]']").val());
			}

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
		            $this.find(".is-invalid").removeClass("is-invalid");
		            $this.find("span.text-danger").remove();
		            
		            
		            if(result['success']){
						re_render_listings(result);
						Swal.fire({
							icon: 'success',
							title: '<?= __('admin.success') ?>',
							text: result['success']
						});

						$("select[name='store[menu_on_front]']").data('existing-value', $("select[name='store[menu_on_front]']").val());
						$('.formsetting_error').text("");
						$('.productsetting_error').text("");
		            }
		            if(result['errors']){
		                $.each(result['errors'], function(i,j){
		                    $ele = $this.find('[name="'+ i +'"]');
		                    if(!$ele.length){ 
		                    	$ele = $this.find('.'+ i);
		                    }
		                    if($ele){
		                        $ele.addClass("is-invalid");
		                        $ele.parents(".form-group").addClass("has-error");
		                        $ele.after("<span class='d-block text-danger'>"+ j +"</span>");
		                    }
		                });

						errors = result['errors'];
						$('.formsetting_error').text(errors['formsetting_recursion_custom_time']);
						$('.productsetting_error').text(errors['productsetting_recursion_custom_time']);
		            }
		        },
		    });
	    }
	}

	function re_render_listings(result) {
		if(result['homepage_slider']) {
			$('#homepage_sliders_list').empty();
			if(result['homepage_slider'].length > 0) {
				for (let index = 0; index < result['homepage_slider'].length; index++) {
					let element = result['homepage_slider'][index];
					let image_src = (element.slider_background_image != null && element.slider_background_image != "") ? '<?= base_url('assets/images/site/') ?>'+element.slider_background_image : '<?= base_url('assets/store/default/img/banner.png'); ?>';
					let new_row = `<tr>
						<td scope="row">`+element.index+`</td>
						<td scope="row">`+element.title+`</td>
						<td scope="row">`+element.sub_title+`</td>
						<td style="width: 200px;"><img style="width: 100px; height: 50px;" src="`+image_src+`" class='img-responsive'></td>
						<td style="width: 87px; padding: 5px 0px !important;">
							<input type="hidden" name="store[homepage_slider][edited][]" value="0">
							<input type="hidden" name="store[homepage_slider][index][]" value="`+element.index+`">
							<input type="hidden" name="store[homepage_slider][title][]" value="`+element.title+`">
							<input type="hidden" name="store[homepage_slider][sub_title][]" value="`+element.sub_title+`">
							<textarea name="store[homepage_slider][content][]" style="display:none;">`+element.content+`</textarea>
							<input type="hidden" name="store[homepage_slider][slider_background_image][]" value="`+element.slider_background_image+`">
							<input type="hidden" name="store[homepage_slider][button_text][]" value="`+element.button_text+`">
							<input type="hidden" name="store[homepage_slider][button_link][]" value="`+element.button_link+`">
							<input type="hidden" name="store[homepage_slider][slider_text_color][]" value="`+element.slider_text_color+`">
							<input type="hidden" name="store[homepage_slider][button_text_color][]" value="`+element.button_text_color+`">
							<input type="hidden" name="store[homepage_slider][button_bg_color][]" value="`+element.button_bg_color+`">
							<button type="button" class="btn btn-primary btn-slider-form-modal-edit"><i class="fa fa-pencil"></i></button>
							<button type="button" class="btn btn-danger remove-slider-btn"><i class="fa fa-trash"></i></button>
						</td>
					</tr>`;
					$('#homepage_sliders_list').append(new_row);
				}
			} else {
				$('#homepage_sliders_list').append(`<h6 class='text-center text-muted'>`+'<?= __('admin.sliders_not_available') ?>'+`</h6>`);
			}
			$('.slider-form-modal').modal('hide');
			$("#slider-form-submit").btn("reset");
		}

		if(result['homepage_features']) {
			$('#homepage_features_list').empty();
			if(result['homepage_features'].length > 0) {
				for (let index = 0; index < result['homepage_features'].length; index++) {
					let element = result['homepage_features'][index];
					let image_src = (element.feature_image != null && element.feature_image != "") ? '<?= base_url('assets/images/site/') ?>'+element.feature_image : '<?= base_url('assets/store/default/img/banner.png'); ?>';
					let new_row = `<tr>
						<td scope="row">`+element.index+`</td>
						<td scope="row">`+element.title+`</td>
						<td scope="row">`+element.sub_title+`</td>
						<td style="width: 200px;"><img style="width: 100px; height: 50px;" src="`+image_src+`" class='img-responsive'></td>
						<td style="width: 87px; padding: 5px 0px !important;">
							<input type="hidden" name="store[homepage_features][edited][]" value="0">
							<input type="hidden" name="store[homepage_features][index][]" value="`+element.index+`">
							<input type="hidden" name="store[homepage_features][title][]" value="`+element.title+`">
							<input type="hidden" name="store[homepage_features][sub_title][]" value="`+element.sub_title+`">
							<input type="hidden" name="store[homepage_features][feature_image][]" value="`+element.feature_image+`">
							<button type="button" class="btn btn-primary btn-features-form-modal-edit"><i class="fa fa-pencil"></i></button>
							<button type="button" class="btn btn-danger remove-features-btn"><i class="fa fa-trash"></i></button>
						</td>
					</tr>`;
					$('#homepage_features_list').append(new_row);
				}
			} else {
				$('#homepage_features_list').append(`<h6 class='text-center text-muted'>`+'<?= __('admin.features_not_available') ?>'+`</h6>`);
			}
			$('.features-form-modal').modal('hide');
			$("#features-form-submit").btn("reset");
		}

		if(result['bs_cards']) {
			$('#bs_cards_list').empty();
			if(result['bs_cards'].length > 0) {
				for (let index = 0; index < result['bs_cards'].length; index++) {
					let element = result['bs_cards'][index];
					let image_src = (element.feature_image != null && element.feature_image != "") ? '<?= base_url('assets/images/site/') ?>'+element.feature_image : '<?= base_url('assets/store/default/img/banner.png'); ?>';
					let new_row = `<tr>
						<td scope="row">`+element.index+`</td>
						<td scope="row">`+element.title+`</td>
						<td scope="row">`+element.sub_title+`</td>
						<td style="width: 200px;"><img style="width: 100px; height: 50px;" src="`+image_src+`" class='img-responsive'></td>
						<td style="width: 87px; padding: 5px 0px !important;">
							<input type="hidden" name="store[bs_cards][edited][]" value="0">
							<input type="hidden" name="store[bs_cards][index][]" value="`+element.index+`">
							<input type="hidden" name="store[bs_cards][title][]" value="`+element.title+`">
							<input type="hidden" name="store[bs_cards][sub_title][]" value="`+element.sub_title+`">
							<input type="hidden" name="store[bs_cards][feature_image][]" value="`+element.feature_image+`">
							<input type="hidden" name="store[bs_cards][bg_color][]" value="`+element.bg_color+`">
							<button type="button" class="btn btn-primary btn-bs-cards-form-modal-edit"><i class="fa fa-pencil"></i></button>
							<button type="button" class="btn btn-danger remove-bs-cards-btn"><i class="fa fa-trash"></i></button>
						</td>
					</tr>`;
					$('#bs_cards_list').append(new_row);
				}
			} else {
				$('#bs_cards_list').append(`<h6 class='text-center text-muted'>`+'<?= __('admin.cards_not_available') ?>'+`</h6>`);
			}
			$('.bs-cards-form-modal').modal('hide');
			$("#bs-cards-form-submit").btn("reset");
		}

		if(result['footer_menu']) {
			$('#footer_menu_list').empty();
			if(result['footer_menu'].length > 0) {
				for (let index = 0; index < result['footer_menu'].length; index++) {
					let element = result['footer_menu'][index];

					let linksInputs = "";
					let linksTitle = "";

					let letpreIndex = element.index - 1;

					element.links.forEach(link => {
						linksTitle += (linksInputs == "") ? link.title : ", "+link.title;
						linksInputs += `<input type="hidden" name="store[footer_menu][links][`+letpreIndex+`][title][]" value="`+link.title+`"><input type="hidden" name="store[footer_menu][links][`+letpreIndex+`][url][]" value="`+link.url+`"><input type="hidden" name="store[footer_menu][links][`+letpreIndex+`][type][]" value="`+link.type+`">`;
					});

					let new_row = `<tr><td scope="row">`+element.index+`</td><td scope="row">`+element.title+`</td><td scope="row">`+linksTitle+`</td><td style="width: 87px; padding: 5px 0px !important;"><input type="hidden" name="store[footer_menu][index][`+letpreIndex+`]" value="`+element.index+`"><input type="hidden" name="store[footer_menu][title][`+letpreIndex+`]" value="`+element.title+`">`;
					new_row += linksInputs;
					new_row += `<button data-letpreindex="`+letpreIndex+`" type="button" class="btn btn-primary btn-footer-menu-form-modal-edit"><i class="fa fa-pencil"></i></button>
							<button type="button" class="btn btn-danger remove-footer-menu"><i class="fa fa-trash"></i></button>
						</td>
					</tr>`;

					$('#footer_menu_list').append(new_row);
				}
			} else {
				$('#footer_menu_list').append(`<h6 class='text-center text-muted'>`+'<?= __('admin.menu_not_available') ?>'+`</h6>`);
			}
			$('.footer-menu-form-modal').modal('hide');
			$("#footer-menu-form-submit").btn("reset");
		}

		if(result['custom_page']) {
			$('#custom_page_list').empty();
			if(result['custom_page'].length > 0) {
				for (let index = 0; index < result['custom_page'].length; index++) {
					let element = result['custom_page'][index];
					let image_src = (element.image != null && element.image != "") ? '<?= base_url('assets/images/site/') ?>'+element.image : '<?= base_url('assets/store/default/img/banner.png'); ?>';

					let new_row = `<tr>
						<td scope="row">`+element.title+`</td>
						<td scope="row">`+element.slug+`</td>
						<td style="width: 200px;"><img style="width: 100px; height: 50px;" src="`+image_src+`" class='img-responsive'></td>
						<td style="width: 87px; padding: 5px 0px !important;">
							<input type="hidden" name="store[custom_page][edited][]" value="0">
							<input type="hidden" name="store[custom_page][index][]" value="`+element.index+`">
							<input type="hidden" name="store[custom_page][title][]" value="`+element.title+`">
							<input type="hidden" name="store[custom_page][slug][]" value="`+element.slug+`">
							<input type="hidden" name="store[custom_page][image][]" value="`+element.image+`">
							<input type="hidden" name="store[custom_page][meta_id][]" value="`+element.meta_id+`">
							<textarea name="store[custom_page][content][]" style="display:none">`+element.content+`</textarea>
							<button type="button" class="btn btn-primary btn-custom-page-modal-form-edit"><i class="fa fa-pencil"></i></button>
							<button type="button" class="btn btn-danger remove-custom-page"><i class="fa fa-trash"></i></button>
						</td>
					</tr>`;

					$('#custom_page_list').append(new_row);
				}
			} else {
				$('#custom_page_list').append(`<h6 class='text-center text-muted'>`+'<?= __('admin.pages_not_available') ?>'+`</h6>`);
			}
			$('.custom-page-modal').modal('hide');
			$("#custom-page-submit").btn("reset");
		}

		if(result['social_links']) {
			$('#social_links_list').empty();
			if(result['social_links'].length > 0) {
				for (let index = 0; index < result['social_links'].length; index++) {
					let element = result['social_links'][index];
					let image_src = (element.image != null && element.image != "") ? '<?= base_url('assets/images/site/') ?>'+element.image : '<?= base_url('assets/store/default/img/banner.png'); ?>';

					let new_row = `<tr>
							<td scope="row">`+element.title+`</td>
							<td scope="row">`+element.url+`</td>
							<td style="width: 200px; text-align:right;">
								<img style="width: 50px; height: 50px; background-color:grey;" src="`+image_src+`" class='img-responsive'>
							</td>
							<td style="width: 87px; padding: 5px 0px !important;">
								<input type="hidden" name="store[social_links][index][]" value="`+element.index+`">
								<input type="hidden" name="store[social_links][edited][]" value="0">
								<input type="hidden" name="store[social_links][title][]" value="`+element.title+`">
								<input type="hidden" name="store[social_links][url][]" value="`+element.url+`">
								<input type="hidden" name="store[social_links][image][]" value="`+element.image+`">
								<button type="button" class="btn btn-primary btn-social-links-form-edit"><i class="fa fa-pencil"></i></button>
								<button type="button" class="btn btn-danger remove-social-links"><i class="fa fa-trash"></i></button>
							</td>
						</tr>
						`;

					$('#social_links_list').append(new_row);
				}
			} else {
				$('#social_links_list').append(`<h6 class='text-center text-muted'>`+'<?= __('admin.pages_not_available') ?>'+`</h6>`);
			}
			$('.social-links-modal').modal('hide');
			$("#social-links-submit").btn("reset");
		}

		if(result['custom_page_for_menu']) {
			$('select[name="fml_type"] option[data-fm_type="page"]').remove();
			for (let index = 0; index < result['custom_page_for_menu'].length; index++) {
				const element = result['custom_page_for_menu'][index];
				$('select[name="fml_type"]').append(`<option value="<?= base_url('store/') ?>`+result['custom_page_for_menu'][index]['slug']+`" data-fm_type="page" style="dispaly:none">`+result['custom_page_for_menu'][index]['name']+`</option>`);
			}
		}
	}

	$(document).on('change', '#recursion_type, #form_recursion_type', function(){
		var recursion_type = $(this).val();
		if( recursion_type == 'custom_time' ){
			$(this).parent().find('.custom_time').show();
		}else{
			$(this).parent().find('.custom_time').hide();
		}
	});
	$(document).on('change', '.recur_day, .recur_hour, .recur_minute', function(){
		var days = $(this).parents('.custom_time').find('.recur_day').val();
		var hours = $(this).parents('.custom_time').find('.recur_hour').val();
		var minutes = $(this).parents('.custom_time').find('.recur_minute').val();
		var total_minutes;	
	
		total_hours = parseInt(days*24) + parseInt(hours);
		total_minutes = parseInt(total_hours*60) + parseInt(minutes);
		$(this).parents('.custom_time').find('.recursion_custom_time').val(total_minutes);
	});
	$(document).on('click', '.btn-add-comment', function(){
		var comment_row_count = $(".comment-titles table tbody tr").length;
		
		var html ='';
		html += '<tr>';
			html += '<td>';
				html += '<input type="text" name="order_comment[title]['+(comment_row_count + 1)+']" class="form-control" placeholder="<?= __('admin.comment_title') ?>" />';
			html += '</td>';
			html += '<td class="text-right">';
				html += '<button type="button" class="btn btn-danger" onclick="$(this).closest(\'tr\').remove()"><i class="fa fa-trash"></i></button>';
			html += '</td>';
		html += '</tr>';

		$('.comment-titles table tbody').append(html);
	});
</script>

<script>
	$(document).on('click', '.btn-add-more', function(){
		let count = $('#notifications-list .col-md-12').length;
		$('#notifications-list').append(`
			<div class="col-md-12">
				<div class="form-group">
					<label class="control-label">Notification `+(count+1)+`</label>
					<input name="store[notification][]" class="form-control" type="text" value="">
				</div>
				<button type="button" class="btn btn-danger btn-md remove-notification-btn" style="position: absolute; top: 30px; right: 11px;"><i class="fa fa-trash"></i></button>
			</div>
		`);
	});

	$(document).on('click', '.remove-notification-btn', function(){
		$(this).parent().remove();

		$('#notifications-list .col-md-12').each(function( index ) {
			$(this).find('.control-label').text('Notification '+(index+1));
		});

		let count = $('#notifications-list .col-md-12').length;
		
		if (count == 0) {
			$('#notifications-list').append(`
				<div class="col-md-12">
					<div class="form-group">
						<label class="control-label">Notification `+(count+1)+`</label>
						<input name="store[notification][]" class="form-control" type="text" value="">
					</div>
					<button type="button" class="btn btn-danger btn-md remove-notification-btn" style="position: absolute; top: 30px; right: 11px;"><i class="fa fa-trash"></i></button>
				</div>
			`);
		}
	});

	$(document).on('click', '.remove-slider-btn', function(){
		$(this).parent().parent().remove();
		$('#homepage_sliders_list tr').each(function( index ) {
			$(this).find('td:first-child').text((index+1));
			$(this).find('input[name="store[homepage_slider][index][]"]').val((index+1));
		});
	});

	$(document).on('click', '.remove-features-btn', function(){
		$(this).parent().parent().remove();
		$('#homepage_features_list tr').each(function( index ) {
			$(this).find('td:first-child').text((index+1));
			$(this).find('input[name="store[homepage_features][index][]"]').val((index+1));
		});
	});

	$(document).on('click', '.remove-bs-cards-btn', function(){
		$(this).parent().parent().remove();
		$('#bs_cards_list tr').each(function( index ) {
			$(this).find('td:first-child').text((index+1));
			$(this).find('input[name="store[bs_cards][index][]"]').val((index+1));
		});
	});

	$(document).on('click', '.btn-slider-form-modal', function(){
		let index = $('#homepage_sliders_list tr:not(.empty)').length + 1;
		let modal = $('.slider-form-modal');
		modal.find('#hs_index').val(index);
		modal.find('#hs_title').val('');
		modal.find('#hs_sub_title').val('');
		modal.find('#hs_content').val('');
		modal.find('#hs_button_text').val('');
		modal.find('#hs_button_link').val('');
		modal.find('#hs_text_color').val('#FFFFFF');
		modal.find('#hs_button_text_color').val('#000000');
		modal.find('#hs_button_bg_color').val('#FFFFFF');
		document.querySelector('#hs_text_color').jscolor.fromString('#FFFFFF');
		document.querySelector('#hs_button_text_color').jscolor.fromString('#000000');
		document.querySelector('#hs_button_bg_color').jscolor.fromString('#FFFFFF');
		modal.find('#hs_slider_background_image').val('');
		modal.find('input[name="store_hsbackgroundimage"]').val('');
		modal.find('#store_hsbackgroundimage_container').attr('src', '<?= base_url('assets/store/default/img/banner.png'); ?>');
		modal.modal('show');
		modal.modal('show');
	});

	$(document).on('click', '.btn-slider-form-modal-edit', function(){
		let data = $(this).parent();
		let modal = $('.slider-form-modal');
		modal.find('#hs_index').val(data.find('input[name="store[homepage_slider][index][]"]').val());
		modal.find('#hs_title').val(data.find('input[name="store[homepage_slider][title][]"]').val());
		modal.find('#hs_sub_title').val(data.find('input[name="store[homepage_slider][sub_title][]"]').val());
		modal.find('#hs_content').val(data.find('textarea[name="store[homepage_slider][content][]"]').val());
		modal.find('#hs_button_text').val(data.find('input[name="store[homepage_slider][button_text][]"]').val());
		modal.find('#hs_button_link').val(data.find('input[name="store[homepage_slider][button_link][]"]').val());
		modal.find('#hs_text_color').val(data.find('input[name="store[homepage_slider][slider_text_color][]"]').val());
		modal.find('#hs_button_text_color').val(data.find('input[name="store[homepage_slider][button_text_color][]"]').val());
		modal.find('#hs_button_bg_color').val(data.find('input[name="store[homepage_slider][button_bg_color][]"]').val());
		document.querySelector('#hs_text_color').jscolor.fromString(data.find('input[name="store[homepage_slider][slider_text_color][]"]').val());
		document.querySelector('#hs_button_text_color').jscolor.fromString(data.find('input[name="store[homepage_slider][button_text_color][]"]').val());
		document.querySelector('#hs_button_bg_color').jscolor.fromString(data.find('input[name="store[homepage_slider][button_bg_color][]"]').val());
		modal.find('input[name="store_hsbackgroundimage"]').val('');
		modal.find('#hs_slider_background_image').val(data.find('input[name="store[homepage_slider][slider_background_image][]"]').val());
		modal.find('#store_hsbackgroundimage_container').attr('src', $(this).parent().parent().find('img').attr('src'));
		modal.modal('show');
	});

	$(document).on('click', '#slider-form-submit', function(){
		let modal = $('.slider-form-modal');
		let image_src = $('#store_hsbackgroundimage_container').attr('src');

		if(modal.find('#hs_title').val() == null || modal.find('#hs_title').val() == "") {
			alert('<?= __('admin.title_should_not_be_empty') ?>');
		} else {

			$("input[name='store[homepage_slider][edited][]']").each(function( index ) {
				$(this).val(0);
			});


			let new_row = `<tr>
				<td scope="row">`+modal.find('#hs_index').val()+`</td>
				<td scope="row">`+modal.find('#hs_title').val()+`</td>
				<td scope="row">`+modal.find('#hs_sub_title').val()+`</td>
				<td style="width: 200px;"><img style="width: 100px; height: 50px;" src="`+image_src+`" class='img-responsive'></td>
				<td style="width: 87px; padding: 5px 0px !important;">
					<input type="hidden" name="store[homepage_slider][edited][]" value="1">
					<input type="hidden" name="store[homepage_slider][index][]" value="`+modal.find('#hs_index').val()+`">
					<input type="hidden" name="store[homepage_slider][title][]" value="`+modal.find('#hs_title').val()+`">
					<input type="hidden" name="store[homepage_slider][sub_title][]" value="`+modal.find('#hs_sub_title').val()+`">
					<textarea name="store[homepage_slider][content][]" style="display:none;">`+modal.find('#hs_content').val()+`</textarea>
					<input type="hidden" name="store[homepage_slider][slider_background_image][]" value="`+modal.find('#hs_slider_background_image').val()+`">
					<input type="hidden" name="store[homepage_slider][button_text][]" value="`+modal.find('#hs_button_text').val()+`">
					<input type="hidden" name="store[homepage_slider][button_link][]" value="`+modal.find('#hs_button_link').val()+`">
					<input type="hidden" name="store[homepage_slider][slider_text_color][]" value="`+modal.find('#hs_text_color').val()+`">
					<input type="hidden" name="store[homepage_slider][button_text_color][]" value="`+modal.find('#hs_button_text_color').val()+`">
					<input type="hidden" name="store[homepage_slider][button_bg_color][]" value="`+modal.find('#hs_button_bg_color').val()+`">
					<button type="button" class="btn btn-primary btn-slider-form-modal-edit"><i class="fa fa-pencil"></i></button>
					<button type="button" class="btn btn-danger remove-slider-btn"><i class="fa fa-trash"></i></button>
				</td>
			</tr>`;
			
			$('#homepage_sliders_list tr:nth-child('+(modal.find('#hs_index').val())+')').remove();

			if(modal.find('#hs_index').val() > $('#homepage_sliders_list tr:not(.empty)').length) {
				$('#homepage_sliders_list').append(new_row);
			} else {
				$('#homepage_sliders_list tr:nth-child('+(modal.find('#hs_index').val())+')').before(new_row);
			}
			submit_store_setting({name:'return', value:'slider'});
			$("#slider-form-submit").btn("loading");
		}
	});

	$(document).on('click', '.btn-features-form-modal', function(){
		let index = $('#homepage_features_list tr:not(.empty)').length + 1;
		let modal = $('.features-form-modal');
		modal.find('#hf_index').val(index);
		modal.find('#hf_title').val('');
		modal.find('#hf_sub_title').val('');
		modal.find('#hf_feature_image').val('');
		modal.find('input[name="store_hfimage"]').val('');
		modal.find('#store_hfimage_container').attr('src', '<?= base_url('assets/store/default/img/banner.png'); ?>');
		modal.modal('show');
	});

	$(document).on('click', '.btn-features-form-modal-edit', function(){
		let data = $(this).parent();
		let modal = $('.features-form-modal');
		modal.find('#hf_index').val(data.find('input[name="store[homepage_features][index][]"]').val());
		modal.find('#hf_title').val(data.find('input[name="store[homepage_features][title][]"]').val());
		modal.find('#hf_sub_title').val(data.find('input[name="store[homepage_features][sub_title][]"]').val());
		modal.find('#hf_feature_image').val(data.find('input[name="store[homepage_features][feature_image][]"]').val());
		modal.find('input[name="store_hfimage"]').val('');
		modal.find('#store_hfimage_container').attr('src', $(this).parent().parent().find('img').attr('src'));
		modal.modal('show');
	});

	$(document).on('click', '#features-form-submit', function(){
		let modal = $('.features-form-modal');
		let image_src = $('#store_hfimage_container').attr('src');

		if(modal.find('#hf_title').val() == null || modal.find('#hs_title').val() == "") {
			alert('title should not be empty');
		} else {

			$("input[name='store[homepage_features][edited][]']").each(function( index ) {
				$(this).val(0);
			});

			let new_row = `
				<tr>
					<td scope="row">`+modal.find('#hf_index').val()+`</td>
					<td scope="row">`+modal.find('#hf_title').val()+`</td>
					<td scope="row">`+modal.find('#hf_sub_title').val()+`</td>
					<td style="width: 200px;"><img style="width: 100px; height: 50px;" src="`+image_src+`" class='img-responsive'></td>
					<td style="width: 87px; padding: 5px 0px !important;">
						<input type="hidden" name="store[homepage_features][edited][]" value="1">
						<input type="hidden" name="store[homepage_features][index][]" value="`+modal.find('#hf_index').val()+`">
						<input type="hidden" name="store[homepage_features][title][]" value="`+modal.find('#hf_title').val()+`">
						<input type="hidden" name="store[homepage_features][sub_title][]" value="`+modal.find('#hf_sub_title').val()+`">
						<input type="hidden" name="store[homepage_features][feature_image][]" value="`+modal.find('#hf_feature_image').val()+`">
						<button type="button" class="btn btn-primary btn-features-form-modal-edit"><i class="fa fa-pencil"></i></button>
						<button type="button" class="btn btn-danger remove-features-btn"><i class="fa fa-trash"></i></button>
					</td>
				</tr>
			`;
			
			$('#homepage_features_list tr:nth-child('+(modal.find('#hf_index').val())+')').remove();

			if(modal.find('#hf_index').val() > $('#homepage_features_list tr:not(.empty)').length) {
				$('#homepage_features_list').append(new_row);
			} else {
				$('#homepage_features_list tr:nth-child('+(modal.find('#hf_index').val())+')').before(new_row);
			}

			submit_store_setting({name:'return', value:'features'});
			$("#features-form-submit").btn("loading");
		}
	});

	$(document).on('click', '.btn-bs-cards-form-modal', function(){
		let index = $('#bs_cards_list tr:not(.empty)').length + 1;
		let modal = $('.bs-cards-form-modal');
		modal.find('#bsc_index').val(index);
		modal.find('#bsc_title').val('');
		modal.find('#bsc_sub_title').val('');
		modal.find('#bsc_feature_image').val('');
		modal.find('#bsc_bg_color').val('#FFFFFF');
		document.querySelector('#bsc_bg_color').jscolor.fromString('#FFFFFF');
		modal.find('#store_bscimage').val('');
		modal.find('#store_bscimage_container').attr('src', '<?= base_url('assets/store/default/img/banner.png'); ?>');
		modal.modal('show');
		$('.bs-cards-form-modal').modal('show');
	});

	$(document).on('click', '.btn-bs-cards-form-modal-edit', function(){
		let data = $(this).parent();
		let modal = $('.bs-cards-form-modal');
		modal.find('#bsc_index').val(data.find('input[name="store[bs_cards][index][]"]').val());
		modal.find('#bsc_title').val(data.find('input[name="store[bs_cards][title][]"]').val());
		modal.find('#bsc_sub_title').val(data.find('input[name="store[bs_cards][sub_title][]"]').val());
		modal.find('#bsc_feature_image').val(data.find('input[name="store[bs_cards][feature_image][]"]').val());
		modal.find('#bsc_bg_color').val(data.find('input[name="store[bs_cards][bg_color][]"]').val());
		document.querySelector('#bsc_bg_color').jscolor.fromString(data.find('input[name="store[bs_cards][bg_color][]"]').val());
		modal.find('#store_bscimage').val('');
		modal.find('#store_bscimage_container').attr('src', $(this).parent().parent().find('img').attr('src'));
		modal.modal('show');
	});

	$(document).on('click', '#bs-cards-form-submit', function(){
		let modal = $('.bs-cards-form-modal');
		let image_src = $('#store_bscimage_container').attr('src');

		if(modal.find('#bsc_title').val() == null || modal.find('#hs_title').val() == "") {
			alert('title should not be empty');
		} else {

			$("input[name='store[bs_cards][edited][]']").each(function( index ) {
				$(this).val(0);
			});

			let new_row = `
				<tr>
					<td scope="row">`+modal.find('#bsc_index').val()+`</td>
					<td scope="row">`+modal.find('#bsc_title').val()+`</td>
					<td scope="row">`+modal.find('#bsc_sub_title').val()+`</td>
					<td style="width: 200px;"><img style="width: 100px; height: 50px;" src="`+image_src+`" class='img-responsive'></td>
					<td style="width: 87px; padding: 5px 0px !important;">
						<input type="hidden" name="store[bs_cards][edited][]" value="1">
						<input type="hidden" name="store[bs_cards][index][]" value="`+modal.find('#bsc_index').val()+`">
						<input type="hidden" name="store[bs_cards][title][]" value="`+modal.find('#bsc_title').val()+`">
						<input type="hidden" name="store[bs_cards][sub_title][]" value="`+modal.find('#bsc_sub_title').val()+`">
						<input type="hidden" name="store[bs_cards][feature_image][]" value="`+modal.find('#bsc_feature_image').val()+`">
						<input type="hidden" name="store[bs_cards][bg_color][]" value="`+modal.find('#bsc_bg_color').val()+`">
						<button type="button" class="btn btn-primary btn-bs-cards-form-modal-edit"><i class="fa fa-pencil"></i></button>
						<button type="button" class="btn btn-danger remove-bs-cards-btn"><i class="fa fa-trash"></i></button>
					</td>
				</tr>
			`;
			
			$('#bs_cards_list tr:nth-child('+(modal.find('#bsc_index').val())+')').remove();

			if(modal.find('#bsc_index').val() > $('#bs_cards_list tr:not(.empty)').length) {
				$('#bs_cards_list').append(new_row);
			} else {
				$('#bs_cards_list tr:nth-child('+(modal.find('#bsc_index').val())+')').before(new_row);
			}

			submit_store_setting({name:'return', value:'bs_cards'});
			$("#bs-cards-form-submit").btn("loading");
		}
	});


	$(document).on('change', '.slider-form-modal input[name="store_hsbackgroundimage"]', function() {
		read_url(this,'store_hsbackgroundimage_container');
	});

	$(document).on('change', '.features-form-modal input[name="store_hfimage"]', function() {
		read_url(this,'store_hfimage_container');
	});

	$(document).on('change', '.bs-cards-form-modal input[name="store_bscimage"]', function() {
		read_url(this,'store_bscimage_container');
	});

	$(document).on('change', '#pages_menu_section input[name="store_aboutimage"]', function() {
		read_url(this,'store_aboutimage_container');
	});

	$(document).on('change', '#pages_menu_section input[name="store_contactimage"]', function() {
		read_url(this,'store_contactimage_container');
	});

	$(document).on('change', '#pages_menu_section input[name="store_policyimage"]', function() {
		read_url(this,'store_policyimage_container');
	});

	$(document).on('change', 'select[name="fm_type"]', function(){
		let selectBox = $(this);
		if(selectBox.val() == 'custom') {
			$('select[name="fml_type"] option[data-fm_type="category"]').hide();
			$('select[name="fml_type"] option[data-fm_type="page"]').hide();
			$('select[name="fml_type"]').val('');
			$('select[name="fml_type"]').attr('disabled', true);
		} else if(selectBox.val() == 'category') {
			$('select[name="fml_type"] option[data-fm_type="category"]').show();
			$('select[name="fml_type"] option[data-fm_type="page"]').hide();
			$('select[name="fml_type"]').val('');
			$('select[name="fml_type"]').attr('disabled', false);
		} else {
			$('select[name="fml_type"] option[data-fm_type="category"]').hide();
			$('select[name="fml_type"] option[data-fm_type="page"]').show();
			$('select[name="fml_type"]').val('');
			$('select[name="fml_type"]').attr('disabled', false);
		}

		$('.footer-menu-form-modal input[name="fml_title"]').val('');
		$('.footer-menu-form-modal input[name="fml_url"]').val('');
	});

	$(document).on('change', 'select[name="fml_type"]', function(){
		let selectBox = $(this);
		if(selectBox.val() != "") {
			$('.footer-menu-form-modal input[name="fml_title"]').val(selectBox.find('option:selected').text());
			$('.footer-menu-form-modal input[name="fml_url"]').val(selectBox.find('option:selected').val());
		}
	});

	$(document).on('click', '.btn-add-link', function(){
		let link_type = $('.footer-menu-form-modal select[name="fm_type"]').val();
		let link_title = $('.footer-menu-form-modal input[name="fml_title"]').val();
		let link_url = $('.footer-menu-form-modal input[name="fml_url"]').val();
		if(link_title != "" && link_title != null && link_url != null && link_url != null) {
			$('#menu_items_list tbody').append(`<tr>
					<td scope="row">`+link_title+`</td>
					<td scope="row">`+link_url+`</td>
					<td style="width: 50px;">
						<input type="hidden" name="fm_link[title][]" value="`+link_title+`">
						<input type="hidden" name="fm_link[url][]" value="`+link_url+`">
						<input type="hidden" name="fm_link[type][]" value="`+link_type+`">
						<button type="button" class="btn btn-sm btn-danger remove-menu-item"><i class="fa fa-trash"></i></button>
					</td>
				</tr>
			`);
		} else {
			Swal.fire({
				icon: 'warning',
				text: '<?= __('admin.link_title_and_url_are_mandatory') ?>'
			});
		}
	});

	$(document).on('click', '.remove-menu-item', function(){
		$(this).parent().parent().remove();
	});

	$(document).on('click', '.remove-footer-menu', function(){
		$(this).parent().parent().remove();
	});

	$(document).on('click', '.remove-custom-page', function(){
		$(this).parent().parent().remove();
		$("#setting-form").append('<input type="hidden" name="return" value="footer_menu"/>');
	});

	$(document).on('click', '.btn-custom-page-modal-form', function(){
		let modal = $('.custom-page-modal');
		modal.find('#cp_index').val(($('#custom_page_list tr:not(.empty)').length+1));
		modal.find('#cp_title').val('');
		modal.find('#cp_image').val('');
		modal.find('#cp_meta_id').val('');
		modal.find('input[name="store_cpimage"]').val('');
		modal.find('#store_cpimage_container').attr('src', '<?= base_url('assets/store/default/img/banner.png'); ?>');
		modal.find('#cp_content').val('');
		modal.find('.summernote').summernote('code', '');
		modal.modal('show');
	});

	$(document).on('click', '.btn-custom-page-modal-form-edit', function(){
		let data = $(this).parent();
		let modal = $('.custom-page-modal');
		modal.find('#cp_index').val(data.find('input[name="store[custom_page][index][]"]').val());
		modal.find('#cp_title').val(data.find('input[name="store[custom_page][title][]"]').val());
		modal.find('#cp_image').val(data.find('input[name="store[custom_page][image][]"]').val());
		modal.find('#cp_meta_id').val(data.find('input[name="store[custom_page][meta_id][]"]').val());
		modal.find('input[name="store_cpimage"]').val('');
		modal.find('#store_cpimage_container').attr('src', $(this).parent().parent().find('img').attr('src'));
		modal.find('#cp_content').val(data.find('input[name="store[custom_page][content][]"]').val());
		modal.find('.summernote').summernote('code', data.find('textarea[name="store[custom_page][content][]"]').val());
		modal.modal('show');
	});

	$(document).on('change', '.custom-page-modal input[name="store_cpimage"]', function() {
		read_url(this,'store_cpimage_container');
	});

	$(document).on('click', '#custom-page-submit', function(){
		let modal = $('.custom-page-modal');
		let image_src = $('#store_cpimage_container').attr('src');

		if(modal.find('#cp_title').val() == null || modal.find('#cp_title').val() == "") {
			Swal.fire({
				icon: 'warning',
				text: '<?= __('admin.page_title_should_not_be_empty') ?>'
			});
		} else {
			let page_slug = convertToSlug(modal.find('#cp_title').val());
			let pagelist = $('#custom_page_list');
			let duplicateSlug = false;

			pagelist.find('tr').each(function(index){
				$(this).find("input[name='store[custom_page][edited][]']").val(0);
				
				if($(this).find("input[name='store[custom_page][slug][]']").val() == page_slug && $(this).find("input[name='store[custom_page][index][]']").val() != modal.find('#cp_index').val()) {
					Swal.fire({
						icon: 'warning',
						text: '<?= __('admin.duplicate_title_name_available_please_change_it') ?>'
					});
					duplicateSlug = true;
				};
			});
			
			if(duplicateSlug == false) {
				let new_row = `<tr>
					<td scope="row">`+modal.find('#cp_title').val()+`</td>
					<td scope="row">`+page_slug+`</td>
					<td style="width: 200px;"><img style="width: 100px; height: 50px;" src="`+image_src+`" class='img-responsive'></td>
					<td style="width: 87px; padding: 5px 0px !important;">
						<input type="hidden" name="store[custom_page][edited][]" value="1">
						<input type="hidden" name="store[custom_page][index][]" value="`+modal.find('#cp_index').val()+`">
						<input type="hidden" name="store[custom_page][title][]" value="`+modal.find('#cp_title').val()+`">
						<input type="hidden" name="store[custom_page][slug][]" value="`+page_slug+`">
						<input type="hidden" name="store[custom_page][image][]" value="`+modal.find('#cp_image').val()+`">
						<input type="hidden" name="store[custom_page][meta_id][]" value="`+modal.find('#cp_meta_id').val()+`">
						<textarea name="store[custom_page][content][]" style="display:none">`+modal.find('.summernote').summernote('code')+`</textarea>
						<button type="button" class="btn btn-primary btn-custom-page-modal-form-edit"><i class="fa fa-pencil"></i></button>
						<button type="button" class="btn btn-danger remove-custom-page"><i class="fa fa-trash"></i></button>
					</td>
				</tr>`;
				
				$('#custom_page_list tr:nth-child('+(modal.find('#cp_index').val())+')').remove();

				if(modal.find('#cp_index').val() > $('#custom_page_list tr:not(.empty)').length) {
					$('#custom_page_list').append(new_row);
				} else {
					$('#custom_page_list tr:nth-child('+(modal.find('#cp_index').val())+')').before(new_row);
				}
				submit_store_setting({name:'return', value:'custom_page'});
				$("#custom-page-submit").btn("loading");
			}
		}
	});

	$(document).on('click', '.btn-footer-menu-form-modal', function(){
		let modal = $('.footer-menu-form-modal');
		modal.find('input[name="fm_index"]').val(($('#footer_menu_list tr:not(.empty)').length+1));
		modal.find('input[name="fm_title"]').val('');
		modal.find('input[name="fm_type"]').val('').trigger('change');
		$('#menu_items_list tbody').empty();
		modal.modal('show');
	});

	$(document).on('click', '.btn-footer-menu-form-modal-edit', function(){
		let data = $(this).parent();
		let letpreIndex = $(this).data('letpreindex');
	
		let modal = $('.footer-menu-form-modal');
		modal.find('input[name="fm_index"]').val(data.find('input[name="store[footer_menu][index]['+letpreIndex+']"]').val());
		modal.find('input[name="fm_title"]').val(data.find('input[name="store[footer_menu][title]['+letpreIndex+']"]').val());
	
		titles = [];
		data.find('input[name="store[footer_menu][links]['+letpreIndex+'][title][]"]').each(function(index) {
			titles.push($(this).val());
		});
	
		urls = [];
		data.find('input[name="store[footer_menu][links]['+letpreIndex+'][url][]"]').each(function(index) {
			urls.push($(this).val());
		});

		types = [];
		data.find('input[name="store[footer_menu][links]['+letpreIndex+'][type][]"]').each(function(index) {
			types.push($(this).val());
		});

		$('#menu_items_list tbody').empty();

		for (let index = 0; index < titles.length; index++) {
			$('#menu_items_list tbody').append(`<tr>
					<td scope="row">`+titles[index]+`</td>
					<td scope="row">`+urls[index]+`</td>
					<td style="width: 50px;">
						<input type="hidden" name="fm_link[title][]" value="`+titles[index]+`">
						<input type="hidden" name="fm_link[url][]" value="`+urls[index]+`">
						<input type="hidden" name="fm_link[type][]" value="`+types[index]+`">
						<button type="button" class="btn btn-sm btn-danger remove-menu-item"><i class="fa fa-trash"></i></button>
					</td>
				</tr>
			`);
		}
		modal.modal('show');
	});

	$(document).on('click', '#footer-menu-form-submit', function(){
		let modal = $('.footer-menu-form-modal');
		let menu_title = modal.find('input[name="fm_title"]').val();
		if(menu_title != "" && menu_title != null) {
			let titles = [];
			modal.find('input[name="fm_link[title][]"]').each(function(index) {
				titles.push($(this).val());
			});
			
			letpreIndex = modal.find('input[name="fm_index"]').val() - 1;

			let new_row = `<tr><td scope="row">`+modal.find('input[name="fm_index"]').val()+`</td><td scope="row">`+modal.find('input[name="fm_title"]').val()+`</td><td scope="row">`+titles.join()+`</td><td style="width: 87px; padding: 5px 0px !important;"><input type="hidden" name="store[footer_menu][index][`+letpreIndex+`]" value="`+modal.find('input[name="fm_index"]').val()+`"><input type="hidden" name="store[footer_menu][title][`+letpreIndex+`]" value="`+modal.find('input[name="fm_title"]').val()+`">`;

			modal.find('input[name="fm_link[title][]"]').each(function( index ) {
				new_row += `<input type="hidden" name="store[footer_menu][links][`+letpreIndex+`][title][]" value="`+$(this).val()+`">`;
			});

			modal.find('input[name="fm_link[url][]"]').each(function( index ) {
				new_row += `<input type="hidden" name="store[footer_menu][links][`+letpreIndex+`][url][]" value="`+$(this).val()+`">`;
			});

			modal.find('input[name="fm_link[type][]"]').each(function( index ) {
				new_row += `<input type="hidden" name="store[footer_menu][links][`+letpreIndex+`][type][]" value="`+$(this).val()+`">`;
			});

			new_row += `<button data-letpreindex="`+letpreIndex+`" type="button" class="btn btn-primary btn-footer-menu-form-modal-edit"><i class="fa fa-pencil"></i></button>
					<button type="button" class="btn btn-danger remove-footer-menu"><i class="fa fa-trash"></i></button>
				</td>
			</tr>`;

			$('#footer_menu_list tr:nth-child('+(modal.find('input[name="fm_index"]').val())+')').remove();

			if(modal.find('input[name="fm_index"]').val() > $('#footer_menu_list tr:not(.empty)').length) {
				$('#footer_menu_list').append(new_row);
			} else {
				$('#footer_menu_list tr:nth-child('+(modal.find('input[name="fm_index"]').val())+')').before(new_row);
			}

			submit_store_setting({name:'return', value:'footer_menu'});
			$("#footer-menu-form-submit").btn("loading");
		} else {
			Swal.fire({
				icon: 'warning',
				text: '<?= __('admin.menu_title_should_not_be_empty') ?>'
			});
		}
	});

	$(document).on('click', '.btn-social-links-form', function(){
		let modal = $('.social-links-modal');
		modal.find('#sl_index').val(($('#social_links_list tr:not(.empty)').length+1));
		modal.find('#sl_title').val('');
		modal.find('#sl_url').val('');
		modal.find('#sl_image').val('');
		modal.find('input[name="store_slicon"]').val('');
		modal.find('#store_slicon_container').attr('src', '<?= base_url('assets/store/default/img/banner.png'); ?>');
		modal.modal('show');
	});

	$(document).on('click', '.btn-social-links-form-edit', function(){
		let data = $(this).parent();
		let modal = $('.social-links-modal');
		modal.find('#sl_index').val(data.find('input[name="store[social_links][index][]"]').val());
		modal.find('#sl_title').val(data.find('input[name="store[social_links][title][]"]').val());
		modal.find('#sl_url').val(data.find('input[name="store[social_links][url][]"]').val());
		modal.find('#sl_image').val(data.find('input[name="store[social_links][image][]"]').val());
		modal.find('input[name="store_slicon"]').val('');
		modal.find('#store_slicon_container').attr('src', $(this).parent().parent().find('img').attr('src'));
		modal.modal('show');
	});

	$(document).on('click', '#social-links-submit', function(){
		let modal = $('.social-links-modal');
		let image_src = $('#store_slicon_container').attr('src');

		if(modal.find('#sl_title').val() == null || modal.find('#sl_title').val() == "") {
			Swal.fire({
				icon: 'warning',
				text: '<?= __('admin.link_title_should_not_be_empty') ?>'
			});
		} else {
			let list = $('#social_links_list');

			list.find('tr').each(function(index){
				$(this).find("input[name='store[social_links][edited][]']").val(0);
			});
			
			let new_row = `<tr>
				<td scope="row">`+modal.find('#sl_title').val()+`</td>
				<td scope="row">`+modal.find('#sl_url').val()+`</td>
				<td style="width: 200px; text-align:right;">
					<img style="width: 50px; height: 50px; background-color:grey;" src="`+image_src+`" class='img-responsive'>
				</td>
				<td style="width: 87px; padding: 5px 0px !important;">
					<input type="hidden" name="store[social_links][index][]" value="`+modal.find('#sl_index').val()+`">
					<input type="hidden" name="store[social_links][edited][]" value="1">
					<input type="hidden" name="store[social_links][title][]" value="`+modal.find('#sl_title').val()+`">
					<input type="hidden" name="store[social_links][url][]" value="`+modal.find('#sl_url').val()+`">
					<input type="hidden" name="store[social_links][image][]" value="`+modal.find('#sl_image').val()+`">
					<button type="button" class="btn btn-primary btn-social-links-form-edit"><i class="fa fa-pencil"></i></button>
					<button type="button" class="btn btn-danger remove-social-links"><i class="fa fa-trash"></i></button>
				</td>
			</tr>
			`;
			
			$('#social_links_list tr:nth-child('+(modal.find('#sl_index').val())+')').remove();

			if(modal.find('#sl_index').val() > $('#social_links_list tr:not(.empty)').length) {
				$('#social_links_list').append(new_row);
			} else {
				$('#social_links_list tr:nth-child('+(modal.find('#sl_index').val())+')').before(new_row);
			}
			submit_store_setting({name:'return', value:'social_links'});
			$("#social-links-submit").btn("loading");
		}
	});

	$(document).on('change', '.social-links-modal input[name="store_slicon"]', function() {
		read_url(this,'store_slicon_container');
	});

	$(document).on('click', '.remove-social-links', function(){
		$(this).parent().parent().remove();
		$("#setting-form").append('<input type="hidden" name="return" value="footer_menu"/>');
	});

	function read_url(input,display_id) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function(e) {
			$('#'+display_id).attr('src', e.target.result);
			}
			
			reader.readAsDataURL(input.files[0]);
		}
	}

	function convertToSlug(Text) {
    	return Text.toLowerCase().replace(/ /g,'-').replace(/[^\w-]+/g,'');
	}
</script>