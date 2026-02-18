<div class="row">
	<div class="col-12">
		<div class="card m-b-30">
			<div class="card-header">
				<h4 class="card-title pull-left"><?= __('admin.currencies') ?></h4>
				<div class="pull-right">
					<a href="<?= base_url('admincontrol/currency_edit/') ?>" class="btn btn-primary add-new" id="<?= $lang['id'] ?>"><?= __("admin.add_new") ?></a>
				</div>
			</div>
			<div class="card-body">
				<div class="table-rep-plugin">
					<div class="table-responsive b-0" data-pattern="priority-columns">
						<table id="tech-companies-1" class="table  table-striped">
							<thead>
								<tr>
									<th><?= __('admin.currency_type') ?></th>
									<th><?= __('admin.symbol_right') ?></th>
									<th><?= __('admin.symbol_left') ?></th>
									<th><?= __('admin.is_default') ?></th>
									<th><?= __('admin.status') ?></th>
									<th><?= __('admin.code') ?></th>
									<th><?= __('admin.value') ?></th>
									<th><?= __('admin.last') ?></th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($currencys as $currency){ ?>
									<tr>
										<td><?= $currency['title'] . ($currency['is_default'] ? ' - ('.__('admin.default').')' : '') ?></td>
										<td><?= $currency['symbol_right'] ?></td>
										<td><?= $currency['symbol_left'] ?></td>
										<td><?= $currency['is_default'] ? __('admin.default') : '' ?></td>
										<td><?= $currency['status'] ?></td>
										<td><?= $currency['code'] ?></td>
										<td><?= $currency['value'] ?></td>
										<td><?= $currency['date_modified'] ?></td>
										<td>
											<a href="<?= base_url('admincontrol/currency_edit/'. $currency['currency_id']) ?>" class="btn btn-sm btn-primary"> <?= __('admin.edit') ?> </a>
											<a href="<?= base_url('admincontrol/currency_delete/'. $currency['currency_id']) ?>" class="btn btn-sm btn-danger btn-delete"> <?= __('admin.delete') ?> </a>
										</td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div> 
	</div> 
</div>