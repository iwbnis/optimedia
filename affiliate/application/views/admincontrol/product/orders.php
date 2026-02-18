<?php include(APPPATH.'/views/admincontrol/includes/store.php'); ?>
<br>
		<div class="row">
			<div class="col-lg-12 col-md-12">
				<?php if($this->session->flashdata('success')){?>
					<div class="alert alert-success alert-dismissable">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<?php echo $this->session->flashdata('success'); ?> </div>
				<?php } ?>
				
				<?php if($this->session->flashdata('error')){?>
					<div class="alert alert-danger alert-dismissable">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<?php echo $this->session->flashdata('error'); ?> </div>
				<?php } ?>
			</div>
		</div>
		<div class="row">
			<div class="col-12">
				<div class="card m-b-30">
					<div class="card-body">
						<div class="table-rep-plugin">
						    
						    <?php if ($getallorders == null) {?>
                                <div class="text-center">
                                <img class="img-responsive" src="<?php echo base_url(); ?>assets/vertical/assets/images/no-data-2.png" style="margin-top:100px;">
                                 <h3 class="m-t-40 text-center text-muted"><?= __('admin.no_orders') ?></h3></div>
                                <?php }
                                else {?>
                                
                                
							<div class="table-responsive b-0" data-pattern="priority-columns">
								<table class="table table-striped">
									<thead>
										<tr>
											<th><?= __('admin.order_id') ?></th>
											<th><?= __('admin.price') ?></th>
											<th><?= __('admin.payment_method') ?></th>
											<th><?= __('admin.ip') ?></th>
											<th><?= __('admin.transaction') ?></th>
											<th><?= __('admin.commission') ?></th>
											<th><?= __('admin.status') ?></th>
											<th><?= __('admin.action') ?></th>
											<th></th>
										</tr>
									</thead>
									<tbody>
										<?php foreach($getallorders as $product){ ?>
											<tr>
												<td><?php echo $product['id'];?></td>
												<td class="txt-cntr"><?php echo c_format($product['total_sum']); ?></td>
												<td class="txt-cntr"><?php echo str_replace("_", " ", $product['payment_method']) ?></td>
												<td class="txt-cntr"><?php echo $product['order_country_flag'];?></td>
												<td class="txt-cntr"><?php echo $product['txn_id'];?></td>

												<td class="txt-cntr">
													<?php 
														if($product['wallet_commission_status'] == 0){ ?>
															<span class="badge <?= ((int)$product['wallet_status'] > 0) ? 'badge-success' : 'badge-warning' ?>">
																<?= $wallet_status[(int)$product['wallet_status']] ?>
															</span>
													<?php } else {
															echo commission_status($product['wallet_commission_status']);
													 	} ?>

													 	<br>
													 	<?= c_format($product['commission_amount']); ?>
												</td>
												<td class="txt-cntr order-status"><?php echo $status[$product['status']]; ?></td>
												<td>
													<select class="status-change-rdo"
															name="status_<?= $product['id'] ?>"
														 	data-id='<?= $product['id'] ?>'>
														<option value=""><?= __('admin.please_choose') ?></option>
														<?php 
															unset($status['0']);
															foreach ($status as $key => $value) { ?>
																<option value="<?= $key ?>"><?= $value ?></option>
														<?php } ?>
													</select>
												</td>
												<td>
													<a href="<?= base_url('admincontrol/vieworder/'. $product['id']) ?>" class="btn btn-primary btn-sm"><?= __('admin.details') ?></a>
												</td>
											</tr>
										<?php } ?>
									</tbody>
								</table>
							</div>
						<?php } ?>
						</div>
					</div>
				</div> 
			</div> 
		</div>

		<div class="modal" id="model-confirmodal">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h6 class="modal-title m-0"><?= __('admin.change_order_status') ?></h6>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>
					<div class="modal-body">
						<div class="complete-text">
							<p class="text-center"><?= __('admin.change_order_status_information_1') ?></p> 
							<p class="text-center"><?= __('admin.change_order_status_information_2') ?></p>
							<br>
						</div>
						<p class="text-center"><b><?= __('admin.are_you_sure') ?></b></p>
						<div class="text-center modal-buttons">
							<button type="button" class="btn btn-danger" data-dismiss="modal"><?= __('admin.close') ?></button>
						</div>
					</div>
				</div>
			</div>
		</div>

<script type="text/javascript">
	$(".status-change-rdo").change(function(e){
		$this = $(this);
		var id = $this.attr("data-id");
		var val = $this.val();

		$("#model-confirmodal .btn-status-change").remove();
		
		$btn = $('<button type="button" class="btn btn-status-change btn-primary">'+'<?= __('admin.yes_sure') ?>'+'</button>');
		$btn.on('click',function(){
			$btn.prop('disabled',true);
			changeStatus($this,id,val,1);
		});
		$btn.prependTo(".modal-buttons");

		if(val == 1)
			$("#model-confirmodal .complete-text").css('display','block');
		else
			$("#model-confirmodal .complete-text").css('display','none');

		$("#model-confirmodal").modal("show");
	});

	function changeStatus(t,id,val){
		$.ajax({
			url: '<?= base_url("admincontrol/order_change_status") ?>',
			type:'POST',
			dataType:'json',
			data:{id:id,val:val},
			success:function(json){
				$("#model-confirmodal").modal("hide");
				if(json['status'])
					location.reload();
				else
					Swal.fire('<?= __('admin.warning') ?>', '<?= __('admin.order_status_not_change') ?>', 'warning');
			},
		})
	}
</script>