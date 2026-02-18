<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header">
						<div>
							<h4 class="mt-0 header-title"><?= __('admin.integration_programs') ?></h4>
							<div class="pull-right">
								<a class="btn btn-primary btn-sm" href="<?= base_url('integration/programs_form') ?>"><?= __('admin.add_new') ?></a>
							</div>
						</div>
					</div>
					<form method="GET" class="mt-2 ml-2">
					<div class="row">

						<div class="col-sm-3">
							<div class="form-group">
								<input type="text" name="name" id="progname" onkeyup="getDataList();" value="" class="form-control" placeholder='<?= __('admin.filter_by_program_name_or_user_name') ?>' autocomplete="off">
							</div>
						</div>

						<div class="col-sm-3">
							<div class="form-group">
								<select class="form-control" name="is_admin">
									<option value=""><?= __('admin.select_by_admin_or_vendor') ?></option>
									<option value="0"><?= __('admin.admin') ?></option>
									<option value="1"><?= __('admin.vendor') ?></option>
								</select>
							</div>
						</div>

						<div class="col-sm-3">
							<div class="form-group">
								<select class="form-control" name="status">
									<option value=""><?= __('admin.select_status'); ?></option>
									<option value="0"><?= __('admin.in_review'); ?></option>
									<option value="1"><?= __('admin.approved'); ?></option>
									<option value="2"><?= __('admin.denied'); ?></option>
									<option value="3"><?= __('admin.ask_to_edit'); ?></option>
								</select>
							</div>
						</div>
						<div class="col-sm-1">
								<button class="btn btn-primary"><?= __('admin.filter'); ?></button>
						</div>
						<div class="col-sm-1">
								<a href="<?=base_url();?>integration/programs" class="btn btn-primary"><?= __('admin.clear_search'); ?></a>
						</div>
					</div>
				</form>

					<div class="body">
						<div class="table-rep-plugin">
                        <div class="table-responsive b-0" data-pattern="priority-columns">
                             <div class="text-center">
                                <?php if ($programs ==null) {?>
                                <img class="img-responsive" src="<?php echo base_url(); ?>assets/vertical/assets/images/no-data-2.png" style="margin-top:100px;">
                                 <h3 class="m-t-40 text-center"><?= __('admin.not_activity_yet') ?></h3>
                                <?php }
                                else {?>

        
                            <table id="tech-companies-1" class="table  text-left table-striped program_tbl">
								<thead>
									<tr>
										<th><?= __('admin.id') ?></th>
										<th><?= __('admin.name') ?></th>
										<th><?= __('admin.vendor') ?></th>
										<th><?= __('admin.sale_commission') ?></th>
										<th><?= __('admin.click_commission') ?></th>
										<th><?= __('admin.sale_status') ?></th>
										<th><?= __('admin.click_status') ?></th>
										<th><?= __('admin.status') ?></th>
										<th></th>
									</tr>
								</thead>
								<tbody id="data_list">
									<?php foreach ($programs as $key => $program) { ?>
										<tr>
											<td><?= $program['id'] ?></td>
											<td><?= $program['name'] ?></td>
											<td><?= $program['username'] ? $program['username'] : 'Admin' ?></td>
											<td>
												<?php 
													if($program['vendor_id']){
														echo __('admin.admin')." : ";
														if($program['admin_sale_status']){
															if($program['admin_commission_type'] == 'percentage'){ echo $program['admin_commission_sale'].'%'; }
															else if($program['admin_commission_type'] == 'fixed'){ echo c_format($program['admin_commission_sale']); }
															else { echo  __('admin.not_set'); }
														} else{
															echo  __('admin.not_set');
														}

														echo "<br>".__('admin.affiliate')." : ";
														if($program['sale_status']){
															if($program['commission_type'] == 'percentage'){ echo $program['commission_sale'].'%'; }
															else if($program['commission_type'] == 'fixed'){ echo c_format($program['commission_sale']); }
															else { echo  __('admin.not_set'); }
														} else{
															echo  __('admin.not_set');
														}
													} else{
														if($program['sale_status']){
															if($program['commission_type'] == 'percentage'){ echo $program['commission_sale'].'%'; }
															else if($program['commission_type'] == 'fixed'){ echo c_format($program['commission_sale']); }
															else { echo  __('admin.not_set'); }
														} else{
															echo  __('admin.not_set');
														}
													}
												?>
											</td>
											<td>
												<?php
													if($program['vendor_id']){
														echo __('admin.admin')." : ";
														if($program['admin_click_status']){
															if($program["admin_commission_click_commission"] && $program['admin_commission_number_of_click']){
																echo c_format($program["admin_commission_click_commission"]). " ".__('admin.per')." ". $program['admin_commission_number_of_click'] ." ".__('admin.clicks');
															} else { echo  __('admin.not_set'); }
														} else{
															echo  __('admin.not_set');
														}

														echo "<br>".__('admin.affiliate')." : ";
														if($program['click_status']){
															echo c_format($program["commission_click_commission"]). " ".__('admin.per')." ". $program['commission_number_of_click'] ." ".__('admin.clicks');
														} else{
															echo  __('admin.not_set');
														}
													} else{
														if($program['click_status']){
															echo c_format($program["commission_click_commission"]). " ".__('admin.per')." ". $program['commission_number_of_click'] ." ".__('admin.clicks');
														} else{
															echo  __('admin.not_set');
														}
													}
												?>
											</td>
											<td>
												<?php
													if($program['vendor_id']){
														echo __('admin.admin')." : ". ($program['admin_sale_status'] ? __('admin.enable') : __('admin.disable'));
														echo "<br> ".__('admin.affiliate')." : ". ($program['sale_status'] ? __('admin.enable') : __('admin.disable'));
													} else {
														echo (int)$program['sale_status'] ? __('admin.enable') : __('admin.disable');
													}
												?>
											<td>
												<?php
													if($program['vendor_id']){
														echo __('admin.admin')." : ". ($program['admin_click_status'] ? __('admin.enable') : __('admin.disable'));
														echo "<br> ".__('admin.affiliate')." : ". ($program['click_status'] ? __('admin.enable') : __('admin.disable'));
													} else {
														echo (int)$program['click_status'] ? __('admin.enable') : __('admin.disable');
													}
												?>	
											</td>
											<td><?= program_status($program['status']) ?></td>
											<td>
												<a class="btn btn-primary btn-sm" href="<?= base_url('integration/programs_form/'. $program['id']) ?>"><?= __('admin.edit') ?></a>
												<button <?= $program['associate_programns'] ? __('admin.disable') : '' ?> class="btn btn-danger btn-sm delete-program" data-id="<?= $program['id'] ?>"><?= __('admin.delete') ?></button>
											</td>
										</tr>
									<?php } ?>
									<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
    </div>
</div>

<div class="modal fade" id="message-model">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body text-center"></div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal"><?= __('admin.close') ?></button>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">

	function getDataList(){
		var progname=$('#progname').val();
		$.ajax({
			url:'<?= base_url('integration/search_programs/') ?>',
			type:'POST',
			dataType:'json',
			data:{progname: progname},
			beforeSend:function(){
				
			},
			complete:function(){
				
			},
			success:function(json){
		
				$('#data_list').html(json);
			},
		})

	}

	$(".delete-program").on('click',function(){
		$this = $(this);
		if(!confirm('<?= __('admin.are_you_sure') ?>')) return false;
		$.ajax({
			url:'<?= base_url('integration/delete_programs_form/') ?>',
			type:'POST',
			dataType:'json',
			data:{id: $this.attr("data-id")},
			beforeSend:function(){$this.btn("loading");},
			complete:function(){$this.btn("reset");},
			success:function(json){
				if(json['success']){
					$this.parents("tr").remove();
					location.reload();
				}

				if(json['message']){
					$("#message-model .modal-body").html(json['message']);
					$("#message-model").modal("show");
				}
			},
		})
	})

</script>