<?php print_message($this); ?>
<div class="card">
	<div class="card-body">
		<form class="form-horizontal" method="post" action=""  enctype="multipart/form-data" id="setting-form">
			<div class="row">
				<div class="col-sm-12">
					<ul class="nav nav-pills nav-stacked setting-nnnav" role="tablist">
						<li class="nav-item">
							<a class="nav-link active show" data-toggle="tab" href="#tab-setting" role="tab"><?= __('admin.setting') ?></a>
						</li>
						<li class="nav-item">
							<a class="nav-link" data-toggle="tab" href="#tab-cron_jobs" role="tab"><?= __('admin.cron_jobs') ?></a>
						</li>
					</ul>
					<div class="tab-content">
						<?php if($this->session->flashdata('success')){?>
							<div class="alert alert-success alert-dismissable"> <?php echo $this->session->flashdata('success'); ?> </div>
						<?php } ?>
						<div class="tab-pane p-3 active" id="tab-setting" role="tabpanel">
							<div class="form-group">
								<label class="control-label"><?= __('admin.status') ?></label>
								<select class="form-control" name="membership[status]">
									<option value="0" <?= ($membership['status'] == 0) ? 'selected' : '' ?>><?= __('admin.disable') ?></option>
									<option value="1" <?= ($membership['status'] == 1) ? 'selected' : '' ?>><?= __('admin.enable_for_all_users') ?></option>
									<option value="2" <?= ($membership['status'] == 2) ? 'selected' : '' ?>><?= __('admin.enable_for_all_vendors') ?></option>
									<option value="3" <?= ($membership['status'] == 3) ? 'selected' : '' ?>><?= __('admin.enable_for_all_affiliates') ?></option>
								</select>
							</div>

							<div class="form-group">
								<label class="control-label"><?= __('admin.show_epire_notification_interval_in_days') ?></label>
								<input type="number" value="<?= $membership['notificationbefore'] ?>" class="form-control" name="membership[notificationbefore]">
							</div>
							<div class="form-group">
								<label class="control-label"><?= __('admin.default_plan_for_new_members') ?></label>
								<select class="form-control" name="membership[default_plan_id]">
									<option value=""><?= __('admin.none') ?></option>
									<?php foreach ($plans as $key => $plan) { ?>
										<option value="<?= $plan->id ?>" <?= $membership['default_plan_id'] == $plan->id ? 'selected' : '' ?>><?= $plan->name ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="tab-pane p-3" id="tab-cron_jobs" role="tabpanel">
							<div class="row">
								<div class="col-sm-6">
									<h5><?= __('admin.what_is_cron_job') ?></h5>
									<p><?= __('admin.what_is_cron_job_answer') ?></p>

									<h6><?= __('admin.to_add_cron_job_steps') ?>:</h6>

									<ol>
										<li><?= __('admin.to_add_cron_job_step1') ?></li>
										<li><?= __('admin.to_add_cron_job_step2') ?></b>:</li>
										<li><?= __('admin.to_add_cron_job_step3') ?></li>
										<li><?= __('admin.to_add_cron_job_step4') ?>  <b><?= __('admin.once_per_minute') ?>(* * * * *)</b>.</li>
										<li><?= __('admin.to_add_cron_job_step5') ?> <div> <code>curl <?= base_url('/cronJob/expire_package_notification') ?></code></div> </li>
										<li><?= __('admin.to_add_cron_job_step6') ?></li>
									</ol>
								</div>
								<div class="col-sm-6">
									<img src="<?= base_url('assets/images/cronjob2.jpg') ?>" width="100%" class='img-responsive'>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-12 text-right">
						<button type="button" class="btn btn-sm btn-primary btn-submit"><?= __('admin.save') ?></button>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>

<script type="text/javascript">
	$(".btn-submit").on('click',function(evt){
	    evt.preventDefault();
	    
    	var formData = new FormData($("#setting-form")[0]);  

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
	            $this.find(".is-invalid").removeClass("is-invalid");
	            $this.find("span.text-danger").remove();
	            
	            if(result['location']){
	                window.location = result['location'];
	            }

	            if(result['success']){
	                $("#setting-form").prepend('<div class="alert mt-4 alert-info alert-dismissable">'+ result['success'] +'</div>');
	                var body = $("html, body");
					body.stop().animate({scrollTop:0}, 500, 'swing', function() { });

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
	

	    return false;
	});
</script>