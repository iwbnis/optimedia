
<div class="row">
	<div class="col-12">
		<div class="card m-b-30">
			<div class="card-header">
				<h4 class="card-title pull-left"><?= __("admin.language") ?></h4>
				<div class="pull-right">
					<a href="<?= base_url('admincontrol/update_user_langauges/all')  ?>" class="btn btn-warning bg-warning text-dark" ><?= __("admin.update_languages") ?></a>
					<a href="<?= base_url('admincontrol/translation_edit/'.$lang['id'])  ?>" class="btn btn-primary add-new" id="<?= $lang['id'] ?>"><?= __("admin.add_new") ?></a>
				</div>
			</div>
			<div class="card-body">
				<div class="table-rep-plugin">
					<div class="table-responsive b-0" data-pattern="priority-columns">

						<?php if($this->session->flashdata('success')){?>								
						<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><?php echo $this->session->flashdata('success'); ?> </div>
						<?php } ?>	
						<?php if($this->session->flashdata('error')){?>								
						<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><?php echo $this->session->flashdata('error'); ?></div>
						<?php } ?>
						<table class="table">
							<thead>
								<tr>
									<th width="50px"><?= __("admin.flag") ?></th>
									<th><?= __("admin.name") ?></th>
									<th width="100px"><?= __("admin.translation_missing_all") ?></th>
									<th width="50px"><?= __("admin.is_default") ?></th>
									<th width="50px"><?= __("admin.status") ?></th>
									<th width="180px"></th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($language as $lang){ ?>
									<tr>
										<td>
											<img src="<?= base_url($lang['flag']) ?>" style="height: 20px">
										</td>
										<td>
											<?= $lang['name'] ?>
											<?php if($lang['is_default']){ echo "<small class='default-badge'> ( ".__('admin.default')." ) </small>"; } ?>
										</td>
										<td class="text-center">
											<?= $lang['count']['missing'] ?> /
											<?= $language_count['all'] ?>
										</td>
										<td>
											<i class="btn_default_lang btn_lang_toggle <?= ($lang['is_default'] == 1) ? "fa fa-toggle-on" : "fa fa-toggle-off"?>" style="<?= ($lang['is_default'] == 1) ? "color: green;" : "color: red;"?>cursor: pointer;font-size: 35px;width:50px" data-lang_id="<?= $lang['id'] ?>" data-column="is_default"></i>
										</td>
										<td>
											<i class="btn_lang_toggle <?= ($lang['status'] == 1) ? "fa fa-toggle-on" : "fa fa-toggle-off"?>" style="<?= ($lang['status'] == 1) ? "color: green;" : "color: red;"?>cursor: pointer;font-size: 35px;width:50px" data-lang_id="<?= $lang['id'] ?>" data-column="status"></i>
										</td>
										<td>
											<button class="btn btn-primary open-details"><?= __('admin.import_export') ?></button>
											<a href="<?= base_url('admincontrol/translation_edit/'.$lang['id'])  ?>" class="btn btn-primary edit-button" id="<?= $lang['id'] ?>"><?= __("admin.edit") ?></a>
											<?php if($lang['id'] != 1){ ?>
												<a class="btn btn-primary edit-button" href="<?= base_url('admincontrol/translation/'.$lang['id'])  ?>"> <?= __("admin.translation") ?> </a>
											<?php } ?>
											<?php if($lang['is_default'] == '0' && $lang['id'] != 1){ ?>
												<button class="btn btn-danger detele-button" id="<?= $lang['id'] ?>"><?= __("admin.delete") ?></button>
											<?php } ?>
										</td>
									</tr>
									
									<tr style="display: none" class="details-tr">
										<td colspan="100%" class="p-0">
											<div class="well" style="border-radius: 0;margin: 0;">
												<div class="lang-uploader">
													<div class="text-right download-link">
														<?= __('admin.click_here_to') ?> <a href="<?= base_url("admincontrol/language_export/".$lang['id']) ?>" target="_blank"><?= __('admin.export_langauge') ?></a> <?= __('admin.file') ?>.
													</div>
													<div class="file-input">
														<?php if($lang['id'] != 1){ ?>
															<form class="form-language">
																<div class="lang-message text-center"></div>
																<input class="d-none" data-lang_file="<?= $lang['id'] ?>" type="file" name="file">
																<input type="hidden" name="id" value="<?= $lang['id'] ?>">
															</form>

															<a href="javascript:void(0)" data-lang_id="<?= $lang['id'] ?>" id="language_xls_upload_btn" class="btn btn-block btn-default"><?= __('admin.import_excel_file') ?></a>

															<a href="javascript:void(0)" id="language_zip_upload_btn" class="btn btn-block btn-default"><?= __('admin.import_language_package') ?></a>
														<?php } else { ?>
															<p><?= __('admin.you_can_not_import_main_language') ?></p>
														<?php } ?>
													</div>
												</div>
											</div>
										</td>
									</tr>
									

								<?php } ?>
								<div class="d-none">
									<form id="language_zip_upload_form" action="<?= base_url("admincontrol/language_zip_upload") ?>" method="post" enctype="multipart/form-data">
										<input type="file" name="file" id="language_zip_upload_input">
									</form>
								</div>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div> 
	</div> 
</div>

<script type="text/javascript">

	$(document).on('click', '#language_xls_upload_btn', function(){
		$('input[data-lang_file="'+$(this).data('lang_id')+'"]').click();
	});

	$(document).on('change', 'input[type="file"][data-lang_file]', function(){
		$(this).closest('form').submit();
	});

	$(document).on('click', '#language_zip_upload_btn', function(){
		$('#language_zip_upload_input').click();
	});

	$(document).on('change', '#language_zip_upload_input', function(){
		$('#language_zip_upload_form').submit();
	});

	$(document).on('click', ".btn_lang_toggle", function(){
		let skip_change = false;
		let id = $(this).data('lang_id');
		let column = $(this).data('column');
		let status = $(this).hasClass('fa-toggle-off') ? 1 : 0;

		if (column == 'is_default' && !status) {
			Swal.fire('Warning', '<?= __('admin.please_select_another_language_as_default') ?>', 'warning');
			skip_change = true;
		} else if (column == 'is_default') {
			if($('.btn_lang_toggle[data-lang_id="'+id+'"][data-column="status"]').hasClass('fa-toggle-off')) {
				Swal.fire('Warning', '<?= __('admin.inactive_language_can_not_be_set_as_default') ?>', 'warning');
				skip_change = true;
			} else {
				$('.btn_default_lang').addClass('fa-toggle-off').removeClass('fa-toggle-on');
				$('.btn_default_lang').css("color", "red");
				
			}
		} else {
			if($('.btn_lang_toggle[data-lang_id="'+id+'"][data-column="is_default"]').hasClass('fa-toggle-on')) {
				Swal.fire('Warning', '<?= __('admin.default_language_can_not_be_set_as_inactive') ?>', 'warning');
				skip_change = true;
			}
		}

		if(!skip_change) {
			if(status) {
				$(this).addClass('fa-toggle-on').removeClass('fa-toggle-off');
				$(this).css("color", "green");
				if (column == 'is_default') { 
					$('.default-badge').remove();
					$(this).closest('tr').find('td:nth-child(2)').append("<small class='default-badge'> ( "+'<?= __('admin.default') ?>'+" ) </small>");
				}
			} else {
				$(this).addClass('fa-toggle-off').removeClass('fa-toggle-on');
				$(this).css("color", "red");
			}

			$.ajax({
				url: "<?= base_url('admincontrol/lang_status_toggle')?>",
				type: "POST",
				dataType: "json",
				data: {
					id:id,
					status:status,
					column:column
				},
				success: function (response) {	
					if(response.status) {
						$('.notification-list.language').html(response.languages);
					}
				}
			});
		}
	});	

	$(".open-details").on('click',function(){
		$tr = $(this).parents("tr").next(".details-tr");

		if($tr.css("display") == 'none'){
			$tr.show();
		} else {
			$tr.hide();
		}
	})

	$(".detele-button").on('click',function(){
		if(!confirm('<?= __('admin.are_you_sure') ?>')) return false;
		
		$this = $(this);
		$.ajax({
			url:'<?= base_url("admincontrol/delete_update_language") ?>',
			type:'POST',
			dataType:'json',
			data:{id:$this.attr("id")},
			beforeSend:function(){
				$this.prop("disabled",true);
			},
			complete:function(){
				$this.prop("disabled",false);
			},
			success:function(json){
				window.location.reload();
			},
		})
	})

	$(".form-language").submit(function(evt){
        evt.preventDefault();
        var formData = new FormData($(this)[0]);
        formData = formDataFilter(formData);
        $this = $(this);
        
        $this.find('.btn-submit').btn("loading");
        $.ajax({
            url:'<?= base_url('admincontrol/language_import') ?>',
            type:'POST',
            dataType:'json',
            cache:false,
            contentType: false,
            processData: false,
            data:formData,
            error:function(){
            	$this.find('.btn-submit').btn("reset");
            },
            success:function(json){
                $this.find('.btn-submit').btn("reset");
                $this.find(".lang-message").html('');

                if(json['success']){
                	$this.find(".lang-message").html('<div class="d-inline-block text-success">'+ json['success'] +'</div>');
                	$this[0].reset();
                }
                if(json['warning']){
                	$this.find(".lang-message").html('<div class="d-inline-block text-danger">'+ json['warning'] +'</div>');
                }
            },
        })
        return false;
    });
</script>