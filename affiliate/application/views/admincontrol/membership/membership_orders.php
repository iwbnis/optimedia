<?php print_message($this); ?>
<div class="row">
	<div class="col-sm-12">
        <div class="row">
            <div class="col-sm-3">
                <div class="dashboard-box box-purple">
                    <div class="text"><label class="m-0"><?= __('admin.order_total') ?></label></div>
                    <div class="count"><h1><?= $dashboard_totals->week_ago_total_orders ?></h1></div>
                    <div class="count"><h6><?= c_format($dashboard_totals->week_ago_total_order_amount) ?></h6></div>
                    <div class="title"><?= __('admin.last_7_days') ?></div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="dashboard-box box-purple">
                    <div class="text"><label class="m-0"><?= __('admin.order_total') ?></label></div>
                    <div class="count"><h1><?= $dashboard_totals->month_ago_total_orders ?></h1></div>
                    <div class="count"><h6><?= c_format($dashboard_totals->month_ago_total_order_amount) ?></h6></div>
                    <div class="title"><?= __('admin.last_30_days') ?></div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="dashboard-box box-purple">
                    <div class="text"><label class="m-0"><?= __('admin.order_total') ?></label></div>
                    <div class="count"><h1><?= $dashboard_totals->year_ago_total_orders ?></h1></div>
                    <div class="count"><h6><?= c_format($dashboard_totals->year_ago_total_order_amount) ?></h6></div>
                    <div class="title"><?= __('admin.this_year') ?></div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="dashboard-box box-purple">
                    <div class="text"><label class="m-0"><?= __('admin.order_total') ?></label></div>
                    <div class="count"><h1><?= $dashboard_totals->all_time_total_orders ?></h1></div>
                    <div class="count"><h6><?= c_format($dashboard_totals->all_time_total_order_amount) ?></h6></div>
                    <div class="title"><?= __('admin.all_time') ?></div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="dashboard-box box-purple">
                    <div class="text"><label class="m-0"><?= __('admin.bonus_commission') ?></label></div>
                    <div class="count"><h6><?= c_format($dashboard_totals->week_ago_total_bonus_commission) ?></h6></div>
                    <div class="title"><?= __('admin.last_7_days') ?></div>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="dashboard-box box-purple">
                    <div class="text"><label class="m-0"><?= __('admin.bonus_commission') ?></label></div>
                    <div class="count"><h6><?= c_format($dashboard_totals->month_ago_total_bonus_commission) ?></h6></div>
                    <div class="title"><?= __('admin.last_30_days') ?></div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="dashboard-box box-purple">
                    <div class="text"><label class="m-0"><?= __('admin.bonus_commission') ?></label></div>
                    <div class="count"><h6><?= c_format($dashboard_totals->year_ago_total_bonus_commission) ?></h6></div>
                    <div class="title"><?= __('admin.this_year') ?></div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="dashboard-box box-purple">
                    <div class="text"><label class="m-0"><?= __('admin.bonus_commission') ?></label></div>
                    <div class="count"><h6><?= c_format($dashboard_totals->all_time_total_bonus_commission) ?></h6></div>
                    <div class="title"><?= __('admin.all_time') ?></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12">
		<div class="card">
			<div class="card-header">
				<h5 class="card-title m-0"><?= __('admin.purchase_history') ?></h5>
                <form>
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <select class="form-control filter_status" name="status_id">
                                    <option value=""><?= __('admin.filter_by_status') ?></option>
                                    <?php foreach (App\MembershipPlan::$lang_status_list as $key => $value) { ?>
                                        <option <?= (isset($_GET['status_id']) && $_GET['status_id'] != '' && $_GET['status_id'] == $key) ? 'selected' : '' ?> value="<?= $key ?>"><?= __('admin.'.$value) ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <select class="form-control" name="user_id">
                                    <option value=""><?= __('admin.filter_by_user') ?></option>
                                    <?php foreach ($users as $key => $value) { ?>
                                    <option <?= isset($user_id) && $user_id == $value['id'] ? 'selected' : '' ?> value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <input autocomplete="off" type="text" name="date" value="<?= isset($_GET['date']) ? $_GET['date'] : '' ?>" class="form-control daterange-picker" placeholder='<?= __('admin.filter_by_date') ?>'>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <button class="btn btn-primary"><?= __('admin.search') ?></button>
                                <button type="button" class="btn btn-delete-multiple d-none btn-danger"><?= __('admin.delete_selected') ?></button>
                            </div>
                        </div>
                    </div>
                </form>
			</div>
			<div class="card-body p-0">
                <form id="delete-form" method="post" action="<?= base_url('membership/odrer_plan_delete_multiple/') ?>">
                	<div class="table-responsive m-0">
                    	<table class="table table-striped">
                    		<thead>
                    			<tr>
                    				<th width="1">
                                        <input type="checkbox" class="select-all">
                                    </th>
                                    <th><?= __('admin.username') ?></th>
                                    <th><?= __('admin.plan_name') ?></th>
                                    <th><?= __('admin.price') ?></th>
                                    <th><?= __('admin.type') ?></th>
                                    <th><?= __('admin.is_active') ?></th>
                                    <th><?= __('admin.plan_status') ?></th>
                                    <th><?= __('admin.payment_method') ?></th>
                                    <th><?= __('admin.remaining_time') ?></th>
                                    <th><?= __('admin.start_date') ?></th>
                                    <th><?= __('admin.end_date') ?></th>
                    				<th width="180px"><?= __('admin.created_at') ?></th>
                    				<th><?= __('admin.action') ?></th>
                    			</tr>
                    		</thead>
                    		<tbody>
                    			<?php if(count($plans) == 0){ ?>
                            		<tr>
                            			<td colspan="100%" class="text-center"><?= __('admin.no_records_found') ?></td>
                            		</tr>
                            	<?php } ?>
                    			<?php foreach ($plans as $key => $plan) { ?>
                    				<tr>
                    					<td>
                                            <?php if($plan->is_active == 0){ ?>
                                                <input type="checkbox" name="delete[]" value="<?= $plan->id ?>" class="single-check">
                                            <?php } ?>
                                            <span class="badge badge-secondary">
                                                ID <?= $plan->id ?>
                                            </span>
                                        </td>
                    					<td><?= ($plan->user ? $plan->user->username : '') ?></td>
                                        <td><?= ($plan->plan ? $plan->plan->name : '') ?></td>
                    					<td><?= c_format($plan->total) ?></td>
                    					<td><?= ($plan->plan ? $plan->plan->type : '') ?></td>
                    					<td><?= $plan->active_text ?></td>
                    					<td><?= $plan->status_text ?></td>
                                        <td>
                                            <?= $plan->payment_method ?>
                                            <?php if($plan->payment_details){ 
                                                $payment_details = json_decode($plan->payment_details, true);
                                                if(isset($payment_details['transaction_id'])){ ?>
                                                    <br>
                                                    <b>Transaction ID :</b> <?= $payment_details['transaction_id']; 
                                                } ?>

                                                <?php if(isset($payment_details['payment_status'])){ ?>
                                                    <br>
                                                    <b>Payment Status :</b>
                                                    <span class="badge 
                                                    <?php if(in_array(strtolower($payment_details['payment_status']), array('completed','succeeded','succcess','paid','active'))) { ?>badge-success<?php }else{ ?>badge-danger<?php } ?>">
                                                        <?= ucfirst($payment_details['payment_status']) ?>
                                                    </span>
                                                <?php } ?>
                                            <?php } ?>
                                        </td>
                    					<td><?= $plan->remainDay() ?></td>
                    					<td><?= dateFormat($plan->started_at,'d/m/Y') ?></td>
                    					<td><?= $plan->expire_text ?></td>
                    					<td><?= dateFormat($plan->created_at) ?></td>
                    					<td>
                    						<a href="<?= base_url('membership/membership_purchase_edit/'. $plan->id) ?>" class="btn btn-sm btn-primary"><?= __('admin.edit') ?></a>
                                            <?php if($plan->is_active == 0){ ?>
                                                <a href="javascript:void(0)" onclick="delete_confirm('<?= base_url('membership/odrer_plan_delete/'. $plan->id) ?>')" class="btn btn-sm btn-danger"><?= __('admin.delete') ?></a>
                                            <?php } ?>
                    					</td>
                    				</tr>
                    			<?php } ?>
                    		</tbody>
                    	</table>
                	</div>
                </form>
            </div>
            <?php if($links){ ?>
                <div class="card-footer text-right">
                	<div class="pull-left">
                		<?= $links[1] ?>
                	</div>
                	<div class="pull-right">
                    	<ul class="pagination m-0"><?= $links[0] ?></ul>
                    </div>
                </div>
           <?php } ?>
		</div>
	</div>
</div>

<script src="<?= base_url('assets/plugins/datatable') ?>/moment.js"></script>
<script type="text/javascript" src="<?= base_url('assets/plugins/datatable') ?>/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/plugins/datatable') ?>/daterangepicker.css" />
<script type="text/javascript">
    $(".single-check").change(buttonToggle);
    $(".select-all").change(function(){
        $(".single-check").prop("checked", $(this).prop("checked"))
        buttonToggle();
    })

    $(".btn-delete-multiple").click(function(){
        Swal.fire({
            title: '<?= __('admin.are_you_sure') ?>',
            text: "<?= __('admin.you_want_be_able_to_revert_this') ?>",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: '<?= __('admin.yes_delete_it') ?>',
            cancelButtonText: '<?= __('admin.no_cancel') ?>',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                $("#delete-form")[0].submit();
            }
        })
    })

    function buttonToggle() {
        if($(".single-check:checked").length){
            $(".btn-delete-multiple").removeClass("d-none")
        } else {
            $(".btn-delete-multiple").addClass("d-none")
        }
    }

    function delete_confirm(url) {
        Swal.fire({
            title: '<?= __('admin.are_you_sure') ?>',
            text: "<?= __('admin.you_want_be_able_to_revert_this') ?>",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: '<?= __('admin.yes_delete_it') ?>',
            cancelButtonText: '<?= __('admin.no_cancel') ?>',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                window.location.href = url;
            }
        })
        return false;
    }

    $('[name="user_id"]').select2();
    $('.daterange-picker').daterangepicker({
        opens: 'left',
        autoUpdateInput: false,
        ranges: {
            '<?= __('admin.today') ?>': [moment(), moment()],
            '<?= __('admin.yesterday') ?>': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            '<?= __('admin.last_7_days') ?>': [moment().subtract(6, 'days'), moment()],
            '<?= __('admin.last_30_days') ?>': [moment().subtract(29, 'days'), moment()],
            '<?= __('admin.this_month') ?>': [moment().startOf('month'), moment().endOf('month')],
            '<?= __('admin.last_month') ?>': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        locale: {
            cancelLabel: '<?= __('admin.clear') ?>',
            format: 'DD-M-YYYY'
        }
    });
    $('.daterange-picker').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('DD-M-YYYY') + ' - ' + picker.endDate.format('DD-M-YYYY'));
    });
    $('.daterange-picker').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
    });
</script>