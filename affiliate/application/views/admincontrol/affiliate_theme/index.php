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
						<?php if($this->session->flashdata('success')){?>
							<div class="alert alert-success alert-dismissable"> <?php echo $this->session->flashdata('success'); ?> </div>
						<?php } ?>
							<div class="row theme-container">
								<?php foreach ($front_themes as $theme) {  ?>
								<div class="col-sm-4">
									<div class="theme-box <?= $login['front_template'] == $theme['id'] ? 'selected' : '' ?> ">
										<img class="theme-image" src="<?= resize('assets/images/themes/'.$theme['image'],392,192) ?>">
										<div class="theme-bottom">
											<div class="theme-name"><span class="theme-status"><?= __('admin.active') ?> :</span> <?= $theme['name'] ?></div>
											<div class="theme-buttons">
												<?php
													if(in_array($theme['name'],['Index 5','Index 6','Index 7','Index 8','Index 9'])) {
														?>
														<button type="button" data-id='<?= $theme['id'] ?>' class="theme-btn" data-toggle="modal" data-target="#title-and-content-form-modal"><i class="fa fa-edit" ></i></button>
														<!-- Modal -->
														<div class="modal fade" id="title-and-content-form-modal" tabindex="-1" role="dialog" aria-hidden="true">
															<div class="modal-dialog" role="document">
																<div class="modal-content">
																	<div class="modal-header">
																		<h5 class="modal-title text-dark m-0"><?= __('admin.update_title_and_content') ?></h5>
																		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																		<span aria-hidden="true">&times;</span>
																		</button>
																	</div>
																	<div class="modal-body">
																		<div class="form-group text-left text-dark">
																			<label><?= __('admin.heading') ?></label>
																			<input id="loginclient_heading" type="text" class="form-control" value="<?= (isset($loginclient['heading'])) ? $loginclient['heading'] : ""; ?>"/>
																		</div>
																		<div class="form-group text-left text-dark">
																			<label><?= __('admin.home_content') ?></label>
																			<textarea id="loginclient_content" class="form-control" rows="3"><?= (isset($loginclient['content'])) ? $loginclient['content'] : ""; ?></textarea>
																		</div>
																		<div class="form-group text-left text-dark">
																			<label><?= __('admin.about_content') ?></label>
																			<textarea id="loginclient_about_content" class="form-control" rows="3"><?= (isset($loginclient['about_content'])) ? $loginclient['about_content'] : ""; ?></textarea>
																		</div>
																	</div>
																	<div class="modal-footer">
																		<button type="button" class="btn btn-secondary" data-dismiss="modal"><?= __('admin.close') ?></button>
																		<button id="loginclient_details_submit" type="button" class="btn btn-primary"><?= __('admin.save_changes') ?></button>
																	</div>
																</div>
															</div>
														</div>
														<?php
													}
												?>
												<?php 
												if(!empty($theme['id']) && $theme['id'] == "multiple_pages"){
												?>
												  <a class="theme-btn" href="<?= base_url('themes/multiple_theme') ?>"><i class="fa fa-edit" ></i></a>
                        <?php 
                      	} 
												if(!empty($theme['id']) && $theme['id'] == "default"){
												?>
												  <a class="theme-btn" href="<?= base_url('admincontrol/front_template') ?>"><i class="fa fa-edit" ></i></a>
                        <?php } ?>
												<button type="button" data-id='<?= $theme['id'] ?>' class="theme-btn btn-theme-active"><?= __('admin.active') ?></button>
												<a href="<?= base_url('?tmp_theme='. $theme['id']) ?>" target="_blank" class="theme-btn btn-theme-preview"><?= __('admin.preview') ?></a>
											</div>
										</div>
									</div>
								</div>
							<?php } ?>
						</div>
          </div>
				</div>
			</form>
		</div>
</div>
<script type="text/javascript">
	$('#loginclient_details_submit').on('click', function(){
		$this = $(this);
		let data = {
			loginclient : true,
			heading : $('#loginclient_heading').val(),
			content : $('#loginclient_content').val(),
			about_content : $('#loginclient_about_content').val()
		};

		$this.btn("loading");	

		if(data.heading != "" && data.content != "" && data.about_content != "") {
			$.ajax({
				type:'POST',
				dataType:'json',
				data:data,
				complete:function(){
					$this.btn("reset");
				},
				success:function(response){
					if(response.success) {
						$('#title-and-content-form-modal').modal('hide');
					} else {
						Swal.fire({
							icon: 'error',
							text: response.message,
						});
					} 
				},
			});
		} else {
			$this.btn("reset");
			Swal.fire({
				icon: 'error',
				text: '<?= __('admin.tite_and_content_not_empty') ?>',
			});
		}
	});

	$(".theme-container").delegate(".btn-theme-active","click",function(evt){
		$this = $(this);

		$.ajax({
	        type:'POST',
	        dataType:'json',
	        data:{
	        	id: $this.attr("data-id"),
	        	action:'active_theme',
	        },
	        beforeSend:function(){ $this.btn("loading"); },
					complete:function(){$this.btn("reset"); },
	        success:function(result){
	            $(".alert-dismissable").remove();


	            $this.find(".has-error").removeClass("has-error");
	            $this.find("span.text-danger").remove();
	            
	            if(result['success']){
		            $(".theme-box.selected").removeClass('selected');
		            $this.parents('.theme-box').addClass('selected')

	                $(".tab-content").prepend('<div class="alert mt-4 alert-info alert-dismissable">'+ result['success'] +'</div>');
	                setTimeout(function(){ $(".alert-dismissable").remove() }, 3000);
	                var body = $("html, body");
					body.stop().animate({scrollTop:0}, 500, 'swing', function() { });

					var div = $(".theme-box.selected").parents(".col-sm-4").clone()
					$(".theme-box.selected").parents(".col-sm-4").remove();
					div.prependTo(".theme-container");

					$(".btn-theme-active").removeClass("btn-loading");
	            }
	        },
	    })
	});

</script>
