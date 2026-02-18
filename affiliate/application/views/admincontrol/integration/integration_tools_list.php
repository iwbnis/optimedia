<?php foreach ($tools as $key => $tool) { ?>
	<tr>
		<td>
			<div class="modal fade" id="campaign-details-<?= $tool['id']; ?>" class="modal" tabindex="-1" role="dialog">
			  <div class="modal-dialog" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			        <h5 class="modal-title"><?= ucwords(strtolower($tool['name'])) ?></h5>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
			      <div class="modal-body">
			        <h6><?= __('admin.tool_type') ?> : <?= parseIntegrationType($tool['_tool_type']); ?></h6>
                    <?php if($tool['_tool_type'] == 'program'){ ?>
                    <h6><?= __('admin.integration_plugin_name') ?> : <?= isset($integration_plugins[$tool['tool_integration_plugin']]) ? $integration_plugins[$tool['tool_integration_plugin']]['name'] : "<span class='text-muted'>".__('admin.not_available_dashed')."</span>" ?></h6>
                    <?php } ?>
			        <div>
			        	<?php if ($tool['_tool_type'] == 'action' || $tool['_tool_type'] == 'single_action') { ?>
							<div class="mb-2"><h6 class="my-0 font-weight-normal-bold"><?= __('admin.action_click') ?></h6>
							<?php 
								if($tool['vendor_id']){
									echo __('admin.affiliate_will_get') . " : ";
								}  else{
									echo __('admin.you_will_get') . ":";
								}
								echo c_format($tool["action_amount"]). " ".__('admin.per')." ". $tool['action_click'] ." ".__('admin.actions')." <br>";
								if($tool['vendor_id']){
									echo __('admin.admin_will_get') ." : ";
									echo c_format($tool["admin_action_amount"]). " ".__('admin.per')." ". $tool['admin_action_click'] ." ".__('admin.actions')." <br>";
								}
							?></div>
						<?php } ?>

						<?PHP if($tool['_tool_type'] == 'general_click') { ?>
							<div class="mb-2"><h6 class="my-0 font-weight-normal-bold"><?= __('admin.general_click') ?></h6>
							<?php 
								if($tool['vendor_id']){
									echo __('admin.affiliate_will_get') . " : ";
								}  else{
									echo __('admin.you_will_get') .  ":";
								}
								echo c_format($tool["general_amount"]). " ".__('admin.per')." ". $tool['general_click'] ." ".__('admin.clicks')." <br>";

								if($tool['vendor_id']){
									echo __('admin.admin_will_get') . " : ";
									echo c_format($tool["admin_general_amount"]). " ".__('admin.per')." ". $tool['admin_general_click'] ." ".__('admin.clicks')." <br>";
								}
							?></div>
						<?php } ?>

						<?php if($tool['_tool_type'] == 'program' && $tool['click_status']) { ?>
							<div class="mb-2"><h6 class="my-0 font-weight-normal-bold"><?= __('admin.product_click') ?></h6>
							<?php 
								if($tool['vendor_id']){
									echo __('admin.affiliate_will_get') . " : ";
								}  else{
									echo __('admin.you_will_get') .  ":";
								}
								
								echo c_format($tool["commission_click_commission"]). " ".__('admin.per')." ". $tool['commission_number_of_click'] ." ".__('admin.clicks')." <br>";

								if($tool['vendor_id']){
									echo __('admin.admin_will_get') . " : ";
									echo c_format($tool["admin_commission_click_commission"]). " ".__('admin.per')." ". $tool['admin_commission_number_of_click'] ." ".__('admin.clicks')." <br>";
								}
							?></div>
						<?php } ?>

						<?php if($tool['_tool_type'] == 'program' && $tool['sale_status']) { ?>
							<div class="mb-2"><h6 class="my-0 font-weight-normal-bold"><?= __('admin.sale_commisssion') ?></h6>
							<?php 
								$comm = '';
								if($tool['commission_type'] == 'percentage'){ $comm = $tool['commission_sale'].'%'; }
								else if($tool['commission_type'] == 'fixed'){ $comm = c_format($tool['commission_sale']); }
								
								if($tool['vendor_id']){
									echo __('admin.affiliate_will_get') . ":{$comm} <br>";
								} else{
									echo __('admin.you_will_get') . ":{$comm} <br>";
								}
								if($tool['vendor_id']){
									$comm = '';
									if($tool['admin_commission_type'] == 'percentage'){ $comm = $tool['admin_commission_sale'].'%'; }
									else if($tool['admin_commission_type'] == 'fixed'){ $comm = c_format($tool['admin_commission_sale']); }

									echo __('admin.admin_will_get') . " : {$comm} <br>";
								}
							?></div>
						<?php } ?>
			        </div>
			        <hr/>
			        <h6><?= __('admin.transactions_details') ?>:</h6>
			        <div>
			        	<?php if($tool['_tool_type'] == 'action' || $tool['_tool_type'] == 'single_action') { ?>
							<div class="mb-2"><h6 class="my-0 font-weight-normal-bold"><?= __('admin.action_click') ?></h6>
							<?php 
								echo __('admin.admin_count').": ". (int)$tool['total_action_click_count'] ."<br>";
								echo __('admin.admin_amount').": ". $tool['total_action_click_amount'];
							?> </div>
						<?php } ?>
						<?PHP if($tool['_tool_type'] == 'general_click') { ?>
							<div class="mb-2"><h6 class="my-0 font-weight-normal-bold"><?= __('admin.general_click') ?></h6>
							<?php 
								echo __('admin.admin_count').": ". (int)$tool['total_general_click_count'] ."<br>";
								echo __('admin.admin_amount').": ". $tool['total_general_click_amount'];
							?> </div>
						<?php } ?>
						<?php if($tool['_tool_type'] == 'program' && $tool['click_status']) { ?>
							<div class="mb-2"><h6 class="my-0 font-weight-normal-bold"><?= __('admin.product_click') ?></h6>
							<?php 
								echo __('admin.admin_count').": ". (int)$tool['total_click_count'] ."<br>";
								echo __('admin.admin_amount').": ". $tool['total_click_amount'];
							?> </div>
						<?php } ?>

						<?php if($tool['_tool_type'] == 'program' && $tool['sale_status']) { ?>
							<div class="mb-2"><h6 class="my-0 font-weight-normal-bold"><?= __('admin.sale_commisssion') ?></h6>
							<?php 
								echo __('admin.admin_count').": ". (int)$tool['total_sale_count'] ."<br>";
								echo __('admin.admin_amount').": ". $tool['total_sale_amount'];
							?> </div>
						<?php } ?>
			        </div>
			        <hr/>
			        <h6><?php echo __('admin.group') ?>:</h6>
			        <div>
			        	<?php

						$groupInfo = "";

						if(empty($tool['groups'])) {
							$groupInfo = '<span class="badge badge-default">'.__('admin.groups_not_assigned').'!</span>';
						} else {
							$groups = explode(',', $tool['groups']);
							foreach($groups as $g) {
								$groupInfo .= '<span class="badge badge-primary mx-1">'.$g.'</span>';
							}
						}

						?>
			        	<?= $groupInfo ?>
			        </div>
			      </div>
			      <div class="modal-footer" style="justify-content: space-between !important;">
			      	<img width="45px" height="45px" src="<?php echo base_url('assets/images/product/upload/thumb/'. $tool['featured_image']) ?>" >
			        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= __('admin.close') ?></button>
			      </div>
			    </div>
			  </div>
			</div>
			<img width="45px" height="45px" src="<?php echo base_url('assets/images/product/upload/thumb/'. $tool['featured_image']) ?>" >
		</td>
		
		<td>
			<?= $tool['username'] ? ucwords($tool['username']) : 'Admin' ?>
		</td>

		<td class="max-width-300">
			<?= ucwords(strtolower($tool['name'])) ?>
		</td>

		<td>
			<?= isset($integration_plugins[$tool['tool_integration_plugin']]) ? $integration_plugins[$tool['tool_integration_plugin']]['name'] : "<span class='text-muted'>".__('admin.not_available_dashed')."</span>" ?>
		</td>

		<td class="text-center">
			<?= $tool['created_at'] ?>
		</td>

		<td class="text-center security-status">
			<?php if($tool['security_status'] == 0): ?>
					<button data-toggle="tooltip" title="<?= __('admin.integration_code') ?>" 
						class="btn-show-code badge badge-info " data-id='<?= $tool['id'] ?>'>
						<i class="fa fa-code" aria-hidden="true"></i>
					</button>
			<?php endif ?>
			<?= ads_security_status($tool['security_status']); ?>
		</td>

		<td class="text-center">
			<?= ads_status($tool['status']); ?>
			<?php if($tool['status'] == 1):
				$isRunning = $tool['status'] == 1 ? 1 : 0;

				$isRunningTooltip = __('admin.lifetime');

				if(!empty($tool['start_date']) && $tool['start_date'] != "0000-00-00 00:00:00") {
					$startDateAvailable = date('d M Y H:i A', strtotime($tool['start_date']));
					if(time() < strtotime($tool['start_date'])) {
						$isRunning = 0;
					}
				} else {
					$startDateAvailable = date('d M Y H:i A', strtotime($tool['created_at']));
				}

				if(!empty($tool['end_date']) && $tool['end_date'] != "0000-00-00 00:00:00") {
					$endDateAvailable = date('d M Y H:i A', strtotime($tool['end_date']));
					if(time() > strtotime($tool['end_date'])) {
						$isRunning = 2;
					}
				} else {
					$endDateAvailable = __('admin.lifetime');
				} ?>

				<a data-toggle="tooltip" title="<?= $startDateAvailable ?> To <?= $endDateAvailable ?>" 
					class="cursor text-white badge badge-<?= ads_running_status($isRunning); ?>">
					<i class="fa fa-clock" aria-hidden="true" style="font-size:18px;"></i>
				</a>
			<?php endif ?>
		</td>

		<td class="text-center">
			<?php if($tool['main_commission_type'] != 'disabled'): ?>
				<button data-toggle="tooltip" title="<?php echo __('admin.integration_mlm_info') ?>" class="btn-show-integration-mlm-info btn btn-sm btn-info" data-id='<?= $tool['id'] ?>'>
					<i class="fas fa-network-wired"></i>
				</button>
			<?php endif ?>
			

			<a href="javascript:void(0);" class="btn btn-sm btn-info check-campaign-with-id" data-id="<?= $tool['id'] ?>">
				<i class="fa fa-shield" aria-hidden="true"></i>
			</a>

			<button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#campaign-details-<?= $tool['id']; ?>">
				<i class="fa fa-info-circle" aria-hidden="true"></i>
			</button>

			<button data-toggle="tooltip" title="<?php echo __('admin.integration_code') ?>" class="btn-show-code btn btn-sm btn-primary" data-id='<?= $tool['id'] ?>'>
				<i class="fa fa-code" aria-hidden="true"></i>
			</button>

			<button data-toggle="tooltip" title="<?php echo __('admin.terms') ?>"  class="btn-show-terms btn btn-sm btn-primary" data-id='<?= $tool['id'] ?>'>
				<i class="fa fa-file-alt" aria-hidden="true"></i>
			</button>

			<a data-toggle="tooltip" title="<?php echo __('admin.duplicate') ?>" class="btn btn-sm btn-primary" href="<?= base_url('integration/integration_tools_duplicate/'. $tool['id']) ?>">
				<i class="fa fa-copy cursors" aria-hidden="true"></i>
			</a>
			<a data-toggle="tooltip" title="<?php echo __('admin.edit') ?>" class="btn btn-sm btn-primary" onclick="return confirm(<?= __('admin.are_you_sure_to_edit') ?>);" href="<?= base_url('integration/integration_tools_form/'. $tool['_type'] .'/' . $tool['id']) ?>">
				<i class="fa fa-edit cursors" aria-hidden="true"></i>
			</a>
			<a data-toggle="tooltip" title="<?php echo __('admin.delete') ?>" class="btn btn-sm btn-danger tool-remove-link" href="<?= base_url('integration/integration_tools_delete/'. $tool['id']) ?>">
				<i class="fa fa-trash-o cursors" aria-hidden="true"></i>
			</a>
		</td>
	</tr>
<?php } ?>
