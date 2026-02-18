<div class="modal-dialog">

	<div class="modal-content">

		<div class="modal-header">

			<h5 class="modal-title m-0"><?= __('admin.edit_user_membership') ?></h5>

			<button type="button" class="close" data-dismiss="modal">&times;</button>

		</div>



		<?php if($MembershipSetting['status']){ ?>

			<nav>

				<div class="nav nav-tabs nav-justified" id="nav-tab" role="tablist">

					<a class="nav-item nav-link active" id="mmu-currentplan" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true"><?= __('admin.current_plan') ?></a>

					<a class="nav-item nav-link" id="mmi-newplan" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false"><?= __('admin.change_plan') ?></a>

				</div>

			</nav>

			<div class="tab-content" id="nav-tabContent">

				<div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="mmu-currentplan">

					<?php if (isset($is_lifetime_plan) && $is_lifetime_plan) { ?>

						<div class="card-body">

							<h4 class="text-center text-success"><?= __('admin.lifetime_free_membership') ?></h4>

							<p class="text-center text-muted"><?= __('admin.user_have_lifetime_free_membership_info') ?></p>

						</div>

					<?php } else if (isset($plan) && $plan) { ?>

						<?php 

						$checkDay = max((int)$MembershipSetting['notificationbefore'],1);

						?>



						<div class="card-body">

							<h4 class="text-success"><span class="text-muted"><?= __('admin.plan') ?>: </span><?= $plan->plan ? $plan->plan->name : '' ?></h4>

						</div>

						<ul class="list-group list-group-flush">

							<li class="list-group-item">

								<span><?= __('admin.plan_date') ?></span>

								<span class="text-right pull-right text-primary">

									<?= dateFormat($plan->started_at,'d F Y') . " to ". $plan->expire_text ?>

								</span>  

							</li>

							<li class="list-group-item p-0 px-3">

								<span class="d-inline-block my-3">&nbsp;<?= __('admin.remain_days') ?></span>

								<span class=" pull-right text-primary text-right">

									<?php

									$remain = $plan->remainDay();

									if($remain === 'lifetime'){

										echo '<span class="font-32">&infin;</span>';

									} else {

										echo "<span class='my-3 d-block'>". $remain ."</span>";

									}

									?>

								</span>  

							</li>

							<li class="list-group-item">

								<span><?= __('admin.plan_status') ?></span>

								<span class="text-right pull-right text-primary">

									<?= $plan->status_text ?>

								</span>  

							</li>

							<li class="list-group-item">

								<span><?= __('admin.active') ?></span>

								<span class="text-right pull-right text-primary">

									<?= $plan->active_text ?>

								</span>  

							</li>

						</ul>

						<div class="card-body">



						</div>

					<?php } else { ?>

						<div class="modal-body">

							<p class="text-center"><?= __('admin.user_have_no_any_membership_plan') ?></p>

						</div>

					<?php } ?>

				</div>

				<div class="tab-pane fade " id="nav-profile" role="tabpanel" aria-labelledby="mmi-newplan">

					<form class="change-plan-form">

						<ul class="list-group">

							<?php foreach ($plan_lists as $key => $p) { ?>

						  		<li class="list-group-item">

						  			<label class="m-0">

						  				<input <?= $plan->plan_id == $p->id ? 'checked' : '' ?> value="<?= $p->id ?>" type="radio" name="new_planid" class="m-0 mr-2"> <span><?= $p->name ?></span>

						  			</label>

						  		</li>

						  	<?php } ?>

						</ul>



						<div class="modal-body ">

							<input type="hidden" name="user_id" value="<?= $user->id ?>">

							<div class="form-group">

		    					<label class="form-control-label"><?= __('admin.status') ?></label>

		    					<select class="form-control" name="status_id">

		    						<option value=""><?= __('admin.select_status') ?></option>

		    						<?php foreach (App\MembershipPlan::$status_list as $key => $value) { ?>

		    							<option value="<?= $key ?>"><?= $value ?></option>

		    						<?php } ?>

		    					</select>

		    				</div>

							<div class="form-group">

		    					<label class="form-control-label"><?= __('admin.comment') ?></label>

		    					<textarea class="form-control" name="comment"></textarea>

		    				</div>

						</div>

					</form>



					<div class="modal-footer">

						<button class="btn btn-primary btn-change-plan"><?= __('admin.change_plan') ?></button>

					</div>

				</div>



			</div>



		<?php } else { ?>

			<div class="modal-body">

				<p class="text-center"><?= __('admin.membership_is_not_active') ?></p>

			</div>

		<?php } ?>	

	</div>

</div>

<script type="text/javascript">

	$(".btn-change-plan").click(function(){

		$this = $(this);

		$.ajax({

			url:'<?= base_url("membership/user_plan_modal") ?>',

			type:'POST',

			dataType:'json',

			data:$(".change-plan-form").serialize(),

			beforeSend:function(){$this.btn("loading");},

			complete:function(){$this.btn("reset");},

			success:function(json){

				$container = $('.change-plan-form');

				$container.find(".is-invalid").removeClass("is-invalid");

				$container.find("span.invalid-feedback").remove();

		

				if (json['reload']) {

					window.location.reload();

				}

				

				if(json['errors']){

				    $.each(json['errors'], function(i,j){

				        $ele = $container.find('[name="'+ i +'"]');

				        if($ele){

				            $ele.addClass("is-invalid");

				            if($ele.parent(".input-group").length){

				                $ele.parent(".input-group").after("<span class='invalid-feedback'>"+ j +"</span>");

				            } else{

				                $ele.after("<span class='invalid-feedback'>"+ j +"</span>");

				            }

				        }

				    })

				}

			},

		})
	})

</script>

