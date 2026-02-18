<div class="row">

			<div class="col-12">

				<div class="card m-b-30">

					<div class="card-header">

						<h4 class="card-title pull-left"><?= isset($lang) ? __("admin.edit_language") : __("admin.add_language") ?></h4>

					</div>

					<div class="card-body">

						<form id="language-form" enctype="multipart/form-data" action="<?= base_url("admincontrol/update_language") ?>" method="POST">

							<?php if($this->session->flashdata('success')){?>								

			                     <div class="alert alert-success alert-dismissable">									

			                     	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

			                     	<?php echo $this->session->flashdata('success'); ?> 

			                     </div>

		                     <?php } ?>	

		                     <?php if($this->session->flashdata('error')){?>								

			                     <div class="alert alert-danger alert-dismissable">									

			                     	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

			                     	<?php echo $this->session->flashdata('error'); ?> 

			                     </div>

		                     <?php } ?>	

							<input class="form-control" type="hidden" name="id" value="<?= isset($lang) ? $lang['id'] : '0' ?>" >

							<div class="form-group">
								<label class="control-label"><?= __("admin.language_name") ?></label>
								<?php if(isset($lang) && isset($lang['name'])) { ?>
									<input class="form-control" name="name" value="<?= $lang['name'] ?>" readonly/>
								<?php } else { ?>
									<select class="form-control" name="name" required>
										<option value="" disabled selected><?= __('admin.select') ?> <?= __("admin.language_name") ?></option>
										<?php foreach ($languages as $key => $value) { ?>
											<option value="<?= $value ?>"><?= $value ?></option>
										<?php } ?>										
									</select>
								<?php } ?>
							</div>

							<div class="flag-file-chooser">

								<ul>

									<?php

										if(isset($lang['flag'])) $selected = $lang['flag'];

									?>

									<?php foreach ($flags_code as $key => $value) { ?>

										<li>

											<label>

												<input data-flag_code="<?= $key ?>" <?= $selected == $value ? 'checked' : '' ?> type="radio" name="flag" value="<?= $value ?>">

												<img src="<?= base_url($value) ?>">

											</label>

										</li>

									<?php } ?>

								</ul>

							</div>

							<br>

							<div class="row">

								<div class="col-sm-2">

									<div class="form-group">

										<label class="control-label"><?= __("admin.status") ?> </label>

										<div>

											<label class="switch">

											  <input type="checkbox"  name="status" value="1" <?= (isset($lang) && $lang['status'] == '1') ? "checked" :  '' ?>>

											  <span class="slider"></span>

											</label>

										</div>

									</div>

								</div>

								<div class="col-sm-3">

									<div class="form-group">

										<label class="control-label"><?= __("admin.set_default") ?></label>

										<div>

											<label class="switch">

											  <input type="checkbox" value="1" name="is_default" <?= (isset($lang) && $lang['is_default'] == '1') ? "checked" :  '' ?>  >

											  <span class="slider"></span>

											</label>

										</div>

									</div>

								</div>



								<div class="col-sm-3">

									<div class="form-group">

										<label class="control-label"><?= __("admin.is_rtl") ?></label>

										<div>

											<label class="switch">

											  <input type="checkbox" value="1" name="is_rtl" <?= (isset($lang) && $lang['is_rtl'] == '1') ? "checked" :  '' ?>  >

											  <span class="slider"></span>

											</label>

										</div>

									</div>

								</div>

							</div>

							<button type="submit" class="btn btn-primary btn-submit"><?= __("admin.save_changes") ?></button>

							<a href="<?= base_url("admincontrol/language") ?>" class="btn btn-default " ><?= __("admin.cancel") ?></a>

						</form>

					</div>

				</div> 

			</div> 

		</div>

 

<script type="text/javascript">

var languages = null;
var countries_with_languages = null;

$.getJSON("<?= base_url('assets/data/countries_with_languages.json'); ?>", function( data ) {
	countries_with_languages = data;
});

$.getJSON("<?= base_url('assets/data/languages.json'); ?>", function( data ) {
	languages = data;
});

$(document).on('change', 'select[name="name"]', function(){
	let langName = $(this).val();
	let langCode = Object.keys(languages).find(key => languages[key] === langName);

	let country = countries_with_languages.filter(function (e) {
		let languages = e.languages.split(",");
		return languages.indexOf(langCode) != -1;
	});

	if(country.length > 0) {
		$('input[name="flag"]').parent().parent().hide();
		for (let index = 0; index < country.length; index++) {
			const iso_code = country[index].iso_code.toLowerCase();
			$('input[name="flag"][data-flag_code="'+iso_code+'"]').parent().parent().show();
			if(index == 0) { $('input[name="flag"][data-flag_code="'+iso_code+'"]').trigger('click'); }
		}
	} else {
		$('input[name="flag"]').parent().parent().show();
	}
});

</script>