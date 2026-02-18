<?php
    $db =& get_instance();
    $userdetails = get_object_vars($db->user_info());
    $products = $db->Product_model;
    $notifications_count = $products->getnotificationnew_count('admin',null);
?>

<link rel="stylesheet" type="text/css" href="<?= base_url('assets/plugins/flag/css/main.min.css') ?>">
<link rel="stylesheet" type="text/css" href="<?= base_url("assets/plugins/table/datatables.min.css") ?>">
<script type="text/javascript" src="<?= base_url("assets/plugins/table/datatables.min.js") ?>"></script>
<script type="text/javascript" src="<?= base_url("assets/plugins/table/dataTables.responsive.min.js") ?>"></script>

<style>
    .counter{
        font-size: 1.7vw;
        font-weight: bold;
    }
    .counter-card {
        width: 100%;
        height: 100%;
    }
    .counter-card .card-body{
        display: flex;
        align-items: center;
    }
    @media(max-width: 1200px){
        .counter{
            font-size: 1.3rem;
        }
        .profile__value{
            font-size: 1rem !important;
        }
    }
</style>
<div class="d-flex align-items-center justify-content-between flex-wrap admin-balance-main">
    <div class="admin-width admin-area">
        <div class="admin-balance ml-0">
            <div class="admin-top-img">
                <img src="<?= base_url('assets/template/images/admin-1.png') ?>" alt="<?= __('admin.admin_balance') ?>">
            </div>
            <span><?= __('admin.admin_balance') ?>
                <em class="rad-color">
                    <span class="ajax-admin_balance"><?= $fun_c_format($admin_totals['admin_balance']) ?></span>
                </em>
            </span>
        </div>
    </div>

    <div class="admin-width admin-area">
        <div class="admin-balance">
            <div class="admin-top-img">
                <img src="<?= base_url('assets/template/images/admin-2.png') ?>" alt="<?= __('admin.all_actions') ?>">
            </div>
            <span><?= __('admin.all_actions') ?>
                <em>
                    <span class="ajax-click_action_total"><?= (int)$admin_totals['click_action_total'] ?></span>
                     / 
                     <span class="ajax-click_action_commission"><?= $fun_c_format($admin_totals['click_action_commission']) ?></span>
                 </em>
            </span>
        </div>
    </div>

    <div class="admin-width admin-area">
        <div class="admin-balance">
            <div class="admin-top-img">
                <img src="<?= base_url('assets/template/images/admin-click.png') ?>" alt="<?= __('admin.admin_all_clicks') ?>">
            </div>
            <span><?= __('admin.admin_all_clicks') ?>
                <em> 
                    <span class="ajax-all_click_total">  <?= (int)(  $admin_totals['click_localstore_total'] +
                                $admin_totals['click_integration_total'] +
                                $admin_totals['click_form_total']   ) ?>
                    </span>
                    / 
                    <span class="ajax-all_click_commission">
                            <?= $fun_c_format(
                                $admin_totals['click_localstore_commission'] +
                                $admin_totals['click_integration_commission'] +
                                $admin_totals['click_form_commission']
                            ) ?>
                    </span>
                </em>
            </span>
        </div>
    </div>

    <div class="sales-width admin-area  total-bg">
        <div class="total-area admin-balance">
            <div>
                <h4><?= __('admin.admin_total_sales') ?></h4>
                <ul class="d-flex">
                    <li class="text-right"><?= __('admin.admin_sales') ?>
                        <strong class="ajax-sale_total_admin_store">
                            <?= $fun_c_format($admin_totals['sale_localstore_total'] + $admin_totals['order_external_total']) ?>
                        </strong>
                    </li>
                    <li class="border-0"><?= __('admin.admin_vendor_sales') ?>
                        <strong class="ajax-sale_localstore_vendor_total">
                            <?= $fun_c_format($admin_totals['sale_localstore_vendor_total']) ?>
                        </strong>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="online-width admin-area online-bg">
        <div class="total-area admin-balance">
            <div>
                <h4><?= __('admin.admin_total_online') ?></h4>
                <ul class="d-flex">
                    <li class="text-center"><?= __('admin.admin_admin') ?>
                        <strong class="ajax-online-admin"><?= (int)$online_count['admin']['online'] ?></strong>
                    </li>
                    <li class="text-center"><?= __('admin.admin_affiliate') ?>
                        <strong class="ajax-online-affiliate"><?= (int)$online_count['user']['online'] ?></strong>
                    </li>
                    <li class="text-center border-0"><?= __('admin.admin_vendor') ?>
                        <strong class="ajax-online-vendor"><?= (int)$online_count['vendor']['online'] ?></strong>
                    </li>
                    <li class="text-center border-0"><?= __('admin.admin_client') ?>
                        <strong class="ajax-online-client"><?= (int)$online_count['client']['online'] ?></strong>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="d-flex justify-content-between dashboard-area">
    <div class="dashboard-left">
        <?php 
            $top_user = isset($populer_users[0]) ? $populer_users[0] : false;
            if(isset($top_user)){
                $users_pic =  (!empty($products->getAvatar($top_user['avatar']))) ? ($products->getAvatar($top_user['avatar'])) : base_url('assets/vertical/assets/images/no-image.jpg'); ?>
                <div class="dashboard-div commition-row">
                    <div class="admin-balance">
                        <div class="user-info"> 
                            <img src="<?= $users_pic ?>" alt="<?= $top_user['firstname'].' '.$top_user['lastname'] ?>">
                            <div class="country-flag"> 
                                <?php if($top_user['sortname']){ ?>
                                    <img src="<?= base_url('assets/vertical/assets/images/flags/' . strtolower($top_user['sortname']) . '.png') ?>" alt="<?= strtolower($top_user['sortname']) ?>"> 
                                <?php } ?>
                            </div>
                            <strong><?= $top_user['firstname'].' '.$top_user['lastname'] ?></strong> 
                        </div>
                        <div class="separate-border"> 
                            <span><?= __( 'admin.admin_balance' ) ?> <em><?= $fun_c_format($top_user['amount']) ?></em></span> 
                        </div>
                        <div class="separate-border pr-0"> 
                            <span><?= __( 'admin.admin_commission' ) ?> <em><?= $fun_c_format($top_user['all_commition']) ?></em></span> 
                        </div>
                    </div>
                </div>
            <?php } ?>

        <div class="dashboard-div">
            <div class="link-details">
                <?php $share_url = base_url('register/vendor'); ?>
                <div class="user-header d-flex align-items-center border-0 p-0">
                    <div>
                        <h2><?= __('admin.register_new_vendor_account_link') ?></h2>
                    </div>
                </div>
                <div class="link-area d-flex">
                    <input id="unique_re_link" type="text" readonly="readonly" value="<?= $share_url ?>">
                    <a href="javascript:void(0);" copyToClipboard="<?= $share_url ?>">
                        <img src="<?= base_url('assets/template/images/copy-icon.png') ?>" alt="<?= __('admin.copy') ?>">
                    </a>
                    <a href="javascript:void(0)" data-social-share data-share-url="<?= $share_url; ?>" data-share-title=""              data-share-desc="">
                        <img src="<?= base_url('assets/template/images/user-share-icon.png') ?>" alt="<?= __('admin.share') ?>"> 
                    </a>
                </div>
            </div>
            <div class="link-details">
                <?php $share_url = base_url('register/' . base64_encode($userdetails['id'])); ?>
                <div class="user-header d-flex align-items-center border-0 p-0">
                    <div>
                        <h2><?= __('admin.register_new_affiliate_account_link') ?></h2>
                    </div>
                </div>
                <div class="link-area d-flex">
                    <input id="unique_re_link" type="text" readonly="readonly" value="<?= $share_url ?>">
                    <a href="javascript:void(0);" copyToClipboard="<?= $share_url ?>">
                        <img src="<?= base_url('assets/template/images/copy-icon.png') ?>" alt="<?= __('admin.copy') ?>">
                    </a>
                    <a href="javascript:void(0)" data-social-share data-share-url="<?= $share_url; ?>" data-share-title=""              data-share-desc="">
                        <img src="<?= base_url('assets/template/images/user-share-icon.png') ?>" alt="<?= __('admin.share') ?>"> 
                    </a>
                </div>
            </div>
        </div>

        <div class="dashboard-div">
            <div class="dashboard-user-details">
                <div class="user-header d-flex align-items-center">
                    <div class="header-img"> 
                        <img src="<?= base_url('assets/template/images/click-icon.png') ?>" alt="<?= __('admin.admin_all_clicks') ?>"> 
                    </div>
                    <div>
                        <h2><?= __( 'admin.admin_all_clicks' ) ?></h2>
                        <span><?= __('admin.total') ?> 
                            <span class="ajax-click_all_total">
                                <?= (int)(
                                    $admin_totals['click_localstore_total'] +
                                    $admin_totals['click_integration_total'] +
                                    $admin_totals['click_form_total'] 
                                ) ?>
                            </span>
                            / 
                            <span class="click_all_commission">
                                <?= $fun_c_format(
                                    $admin_totals['click_localstore_commission'] +
                                    $admin_totals['click_integration_commission'] +
                                    $admin_totals['click_form_commission']
                                ) ?>
                            </span>
                        </span> 
                    </div>
                </div>
                <ul>
                    <li class="d-flex"> 
                        <span><?= __( 'admin.admin_ecommerce' ) ?></span> 
                        <strong>
                            <strong class="ajax-click_localstore_total"><?= (int)$admin_totals['click_localstore_total'] ?></strong> 
                            / 
                            <strong class="ajax-click_localstore_commission"><?= $fun_c_format($admin_totals['click_localstore_commission']) ?></strong>
                        </strong> 
                    </li>
                    <li class="d-flex"> 
                        <span><?= __( 'admin.admin_external' ) ?></span> 
                        <strong>
                            <strong class="ajax-click_integration_total"><?= (int)$admin_totals['click_integration_total'] ?></strong>
                            / 
                            <strong class="ajax-click_integration_commission"><?= $fun_c_format($admin_totals['click_integration_commission']) ?></strong>  
                        </strong> 
                    </li>
                    <li class="d-flex"> 
                        <span><?= __( 'admin.admin_forms' ) ?></span> 
                        <strong>
                            <strong class="ajax-click_form_total"><?= (int)$admin_totals['click_form_total'] ?></strong>
                            / 
                            <strong class="ajax-click_form_commission"><?= $fun_c_format($admin_totals['click_form_commission']) ?></strong>
                        </strong> 
                    </li>
                </ul>
            </div>
        </div>

        <div class="dashboard-div">
            <div class="dashboard-user-details">
                <div class="user-header d-flex align-items-center">
                    <div class="header-img"> 
                        <img src="<?= base_url('assets/template/images/percentage-icon.png') ?>" alt="<?= __( 'admin.admin_order_commission' ) ?>"> 
                    </div>
                    <div>
                        <h2><?= __( 'admin.admin_order_commission' ) ?></h2>
                        <span><?= __('admin.total') ?> 
                            <span class="ajax-all_sale_count">
                                <?= (int)(
                                    $admin_totals['sale_localstore_count'] +
                                    $admin_totals['order_external_count'] +
                                    $admin_totals['sale_localstore_vendor_count']

                                ) ?>
                            </span>
                            / 
                            <span class="ajax-all_sale_commission">
                                <?= $fun_c_format(
                                    $admin_totals['sale_localstore_commission'] +
                                    $admin_totals['order_external_commission'] +
                                    $admin_totals['sale_localstore_vendor_commission']

                                ) ?>
                            </span>
                        </span>
                    </div>
                </div>
                <ul>
                    <li class="d-flex"> 
                        <span><?= __( 'admin.admin_ecommerce' ) ?></span> 
                        <strong>
                            <strong class="ajax-sale_localstore_count"><?= (int)$admin_totals['sale_localstore_count'] ?></strong>
                            / 
                            <strong class="ajax-sale_localstore_commission"><?= $fun_c_format($admin_totals['sale_localstore_commission']) ?></strong>
                        </strong> 
                    </li>
                    <li class="d-flex"> 
                        <span><?= __( 'admin.admin_vendor' ) ?></span> 
                        <strong>
                            <strong class="ajax-sale_localstore_vendor_count"><?= (int)$admin_totals['sale_localstore_vendor_count'] ?></strong>
                            / 
                            <strong class="ajax-sale_localstore_vendor_commission"><?= $fun_c_format($admin_totals['sale_localstore_vendor_commission']) ?></strong>
                        </strong> 
                    </li>
                    <li class="d-flex"> 
                        <span><?= __( 'admin.admin_external' ) ?></span> 
                        <strong>
                            <strong class="ajax-order_external_count"><?= (int)$admin_totals['order_external_count'] ?></strong>
                            / 
                            <strong class="ajax-order_external_commission"><?= $fun_c_format($admin_totals['order_external_commission']) ?></strong>
                        </strong> 
                    </li>
                </ul>
            </div>
        </div>

        <div class="dashboard-div">
            <div class="dashboard-user-details">
                <div class="user-header d-flex align-items-center">
                    <div class="header-img"> 
                        <img src="<?= base_url('assets/template/images/wallet-icon.png') ?>" alt="<?= __( 'admin.admin_wallet_statistics' ) ?>"> 
                    </div>
                    <div>
                        <h2><?= __( 'admin.admin_wallet_statistics' ) ?></h2>
                    </div>
                </div>
                <ul>
                    <li class="d-flex"> 
                        <span><?= __( 'admin.admin_hold' ) ?></span> 
                        <strong>
                            <strong class="ajax-wallet_unpaid_amounton_hold_count"><?= (int)$admin_totals['wallet_unpaid_amounton_hold_count'] ?></strong>
                            / 
                            <strong class="ajax-wallet_on_hold_amount"><?= $fun_c_format($admin_totals['wallet_on_hold_amount']) ?></strong>
                        </strong> 
                    </li>
                    <li class="d-flex"> 
                        <span><?= __( 'admin.admin_unpaid' ) ?></span> 
                        <strong>
                            <strong class='ajax-wallet_unpaid_count'><?= (int)$admin_totals['wallet_unpaid_count'] ?></strong>
                            / 
                            <strong class='ajax-wallet_unpaid_amount'><?= $fun_c_format($admin_totals['wallet_unpaid_amount']) ?></strong>
                        </strong> 
                    </li>
                    <li class="d-flex"> 
                        <span><?= __( 'admin.admin_request' ) ?></span> 
                        <strong>
                            <strong class="ajax-wallet_request_sent_count"><?= (int)$admin_totals['wallet_request_sent_count'] ?></strong>
                            / 
                            <strong class="ajax-wallet_request_sent_amount"><?= $fun_c_format($admin_totals['wallet_request_sent_amount']) ?></strong>
                        </strong> 
                    </li>
                    <li class="d-flex"> 
                        <span><?= __( 'admin.admin_paid' ) ?></span> 
                        <strong>
                            <strong class="ajax-wallet_accept_count"><?= (int)$admin_totals['wallet_accept_count'] ?></strong>
                            / 
                            <strong class="ajax-wallet_accept_amount"><?= $fun_c_format($admin_totals['wallet_accept_amount']) ?></strong>
                        </strong> 
                    </li>
                    <li class="d-flex"> 
                        <span><?= __( 'admin.admin_cancel' ) ?></span> 
                        <strong>
                            <strong class="ajax-wallet_cancel_count"><?= (int)$admin_totals['wallet_cancel_count'] ?></strong>
                            / 
                            <strong class="ajax-wallet_cancel_amount"><?= $fun_c_format($admin_totals['wallet_cancel_amount']) ?></strong>
                        </strong> 
                    </li>
                    <li class="d-flex"> 
                        <span><?= __( 'admin.trash' ) ?></span> 
                        <strong>
                            <strong class="ajax-wallet_trash_count"><?= (int)$admin_totals['wallet_trash_count'] ?></strong>
                            / 
                            <strong class="ajax-wallet_trash_amount"><?= $fun_c_format($admin_totals['wallet_trash_amount']) ?></strong>
                        </strong> 
                    </li>
                </ul>
            </div>
        </div>

        <div class="dashboard-div">
            <div class="dashboard-user-details">
                <div class="user-header d-flex align-items-center">
                    <div class="header-img"> 
                        <img src="<?= base_url('assets/template/images/vendor-icon.png') ?>" alt="<?= __( 'admin.admin_vendor_order_statistics' ) ?>"> 
                    </div>
                    <div>
                        <h2><?= __( 'admin.admin_vendor_order_statistics' ) ?></h2>
                    </div>
                </div>
                <ul>
                    <li class="d-flex"> 
                        <span><?= __( 'admin.admin_paid' ) ?></span> 
                        <strong>
                            <strong class="ajax-vendor_wallet_accept_count"><?= (int)$admin_totals['vendor_wallet_accept_count'] ?></strong>
                            / 
                            <strong class="ajax-vendor_wallet_accept_amount"><?= $fun_c_format($admin_totals['vendor_wallet_accept_amount']) ?></strong>
                        </strong> 
                    </li>
                    <li class="d-flex"> 
                        <span><?= __( 'admin.admin_request' ) ?></span> 
                        <strong>
                            <strong class="ajax-vendor_wallet_request_sent_count"><?= (int)$admin_totals['vendor_wallet_request_sent_count'] ?></strong>
                            / 
                            <strong class="ajax-vendor_wallet_request_sent_amount"><?= $fun_c_format($admin_totals['vendor_wallet_request_sent_amount']) ?></strong>
                        </strong> 
                    </li>
                    <li class="d-flex"> 
                        <span><?= __( 'admin.admin_unpaid' ) ?></span> 
                        <strong>
                            <strong class="ajax-vendor_wallet_unpaid_count"><?= (int)$admin_totals['vendor_wallet_unpaid_count'] ?></strong>
                            / 
                            <strong class="ajax-vendor_wallet_unpaid_amount"><?= $fun_c_format($admin_totals['vendor_wallet_unpaid_amount']) ?></strong>
                        </strong> 
                    </li>
                    <li class="d-flex"> 
                        <strong><?= __( 'admin.admin_total_orders' ) ?></strong> 
                        <strong>
                            <strong class="ajax-order_vendor_total"><?= (int)$admin_totals['order_vendor_total'] ?></strong>
                            / 
                            <strong class="ajax-order_vendor_total"><?= (int)$admin_totals['order_vendor_total'] ?></strong>
                        </strong> 
                    </li>
                </ul>
            </div>
        </div>

        <div class="dashboard-div p-0">
            <div class="dashboard-user-details">
                <div class="d-flex align-items-center user-header p-3">
                    <div class="affiliate-img"> 
                        <img src="<?= base_url('assets/template/images/affiliate-icon.png') ?>" alt="<?= __('admin.popular_affiliates') ?>"> 
                    </div>
                    <div>
                        <h2><?= __('admin.popular_affiliates') ?></h2>
                    </div>
                </div>
                <div class="affiliate-table">
                    <table>
                        <thead>
                            <tr>
                                <th><?= __( 'admin.admin_name' ) ?></th>
                                <th><?= __( 'admin.admin_country' ) ?></th>
                                <th><?= __( 'admin.admin_balance' ) ?></th>
                                <th><?= __( 'admin.admin_commission' ) ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($populer_users as $key => $users) { ?>
                                <tr>
                                    <?php
                                        $flag = '';
                                        if ($users['sortname'] != '') {
                                            $flag = base_url('assets/vertical/assets/images/flags/' . strtolower($users['sortname']) . '.png');
                                        }
                                    ?>
                                    <td><img class="top-affiliate-image" src="<?= $products->getAvatar($users['avatar']); ?>" alt="<?= $users['firstname'].' '.$users['lastname']; ?>" /><?= $users['firstname'].' '.$users['lastname']; ?></td>
                                    <td><img class="top-affiliate-country-flag" src="<?= $flag; ?>" alt="<?= strtoupper($users['sortname']) ?>"></td>
                                    <td><?= $fun_c_format($users['amount']); ?></td>
                                    <td><?= $fun_c_format($users['all_commition']); ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="dashboard-right">
        <div class="dashboard-div p-4">
            <div class="graph-header d-flex flex-wrap align-items-center justify-content-between">
                <h2><?= __('admin.admin_overview') ?></h2>
                <ul class="d-flex flex-wrap">
                    <li class="d-flex admin-balance">
                        <div class="arrow-div"> <span></span> </div>
                        <div class="earning-text"> 
                            <span>
                                <?= __('admin.weekly_earnings') ?>
                                <em class="ajax-weekly_balance"><?= $admin_totals_week ?></em> 
                            </span> 
                        </div>
                    </li>
                    <li class="d-flex arrow-red admin-balance">
                        <div class="arrow-div"> <span></span> </div>
                        <div class="earning-text"> 
                            <span>
                                <?= __('admin.monthly_earnings') ?>
                                <em class="rad-color ajax-monthly_balance"><?= $admin_totals_month ?></em> 
                            </span> 
                        </div>
                    </li>
                    <li class="d-flex admin-balance">
                        <div class="arrow-div"> <span></span> </div>
                        <div class="earning-text"> 
                            <span>
                                <?= __('admin.yearly_earnings') ?>
                                <em class="ajax-yearly_balance"><?= $admin_totals_year ?></em> 
                            </span> 
                        </div>
                    </li>
                </ul>
            </div>
            <div class="graph-filter">
                <select onchange="loadDashboardChart()" class="renderChart chart-input form-control" name="group">
                    <option value="day" ><?= __('admin.day') ?></option>
                    <option value="week"><?= __('admin.week') ?></option>
                    <option value="month" selected=""><?= __('admin.month') ?></option>
                    <option value="year"><?= __('admin.year') ?></option>
                </select>

                <select onchange="loadDashboardChart()" class="yearSelection chart-input form-control" name='year'>
                    <?php for($i=2016; $i<= date("Y"); $i++){ ?>
                        <option value="<?= $i ?>" <?php echo $i==date("Y") ? "selected='selected'" : '' ?>><?= $i ?></option>
                    <?php  } ?>
                </select>
            </div>
            <div class="graph-chart">
                <script src="<?= base_url('assets/plugins/chart/chart.min.js') ?>"></script>
                <canvas id="dashboard-chart" class="ct-chart ct-golden-section"></canvas>
                <div id="dashboard-chart-empty" class="ct-chart d-none ct-golden-section">
                    <img src="<?= base_url('assets/vertical/assets/images/no-data-2.png'); ?>">
                    <h3><?= __('admin.not_activity_yet') ?></h3>
                </div>
                <script type="text/javascript">
                    var ctx = document.getElementById('dashboard-chart').getContext('2d');
                    var chartData = <?= json_encode($chart) ?>;

                    var months = [
                          '<?= __('admin.january') ?>',
                          '<?= __('admin.february') ?>',
                          '<?= __('admin.march') ?>',
                          '<?= __('admin.april') ?>',
                          '<?= __('admin.may') ?>',
                          '<?= __('admin.june') ?>',
                          '<?= __('admin.july') ?>',
                          '<?= __('admin.august') ?>',
                          '<?= __('admin.september') ?>',
                          '<?= __('admin.october') ?>',
                          '<?= __('admin.november') ?>',
                          '<?= __('admin.december') ?>',
                        ];

                    var chart = new Chart(ctx, {
                        type: 'line',
                        data: {},
                        options: {
                            tooltips: {
                                mode: 'index',
                                intersect: false
                            },
                            plugins: {
                                legend: {
                                    position: 'top',
                                    labels: {
                                        usePointStyle: true,
                                    },
                                }
                            },
                            responsive: true,
                        }
                    });

                    function renderDashboardChart(chartData){
                        chart.data = {
                            labels: months,
                            datasets: [
                                {
                                    label: '<?= __('admin.action_count') ?>',
                                    fill: false,
                                    borderWidth: 3,
                                    borderColor: 'rgb(54, 162, 235)',
                                    backgroundColor: 'rgb(54, 162, 235)',
                                    data: Object.values(chartData['action_count']),
                                    pointStyle: 'line'
                                },
                                {

                                    label: '<?= __('admin.order_count') ?>',
                                    fill: false,
                                    borderWidth: 3,
                                    borderColor: 'rgb(255, 205, 86)',
                                    backgroundColor: 'rgb(255, 205, 86)',
                                    data: Object.values(chartData['order_count']),
                                    pointStyle: 'line'
                                },
                                {
                                    label: '<?= __('admin.order_commission') ?>',
                                    fill: false,
                                    borderWidth: 3,
                                    borderColor: 'rgb(29, 201, 183)',
                                    backgroundColor: 'rgb(29, 201, 183)',
                                    data: Object.values(chartData['order_commission']),
                                    pointStyle: 'line'
                                },
                                {
                                    label: '<?= __('admin.action_commission') ?>',
                                    fill: false,
                                    borderWidth: 3,
                                    borderColor: 'rgb(75, 192, 192)',
                                    backgroundColor: 'rgb(75, 192, 192)',
                                    data: Object.values(chartData['action_commission']),
                                    pointStyle: 'line'
                                },
                                
                                {
                                    label: '<?= __('admin.order_total') ?>',
                                    fill: false,
                                    borderWidth: 3,
                                    borderColor: 'rgb(253, 57, 122)',
                                    backgroundColor: 'rgb(253, 57, 122)',
                                    data: Object.values(chartData['order_total']),
                                    pointStyle: 'line'
                                },
                            ]
                        }

                        chart.update();
                    }

                    function loadDashboardChart(){
                        $.ajax({
                            url:'<?= base_url("admincontrol/dashboard?getChartData=1") ?>',
                            type:'POST',
                            dataType:'json',
                            data:$(".chart-input"),
                            beforeSend:function(){},
                            complete:function(){},
                            success:function(json){
                                if(json['chart']){
                                    $("#dashboard-chart-empty").addClass('d-none');
                                    $("#dashboard-chart").removeClass('d-none');
                                    
                                    renderDashboardChart(json['chart']);
                                } else {
                                    $("#dashboard-chart-empty").removeClass('d-none');
                                    $("#dashboard-chart").addClass('d-none');
                                }
                            },
                        })
                    }

                    loadDashboardChart()
                </script>
            </div>
        </div>

        <div class="dashboard-div world-map p-4">
            <script type="text/javascript" src="<?= base_url('assets/plugins/jmap/jquery-jvectormap-2.0.3.min.js') ?>"></script>
            <script type="text/javascript" src="<?= base_url('assets/plugins/jmap/jquery-jvectormap-world-mill.js') ?>"></script>
            <link rel="stylesheet" type="text/css" href="<?= base_url('assets/plugins/jmap/css.css') ?>">
            <div class="orders-header">
                <h2><?= __("admin.affiliates_map") ?></h2>
                <div class="world-map-users"></div>
            </div>
            <script type="text/javascript">
                function load_userworldmap(_data) {
                    $('.world-map-users').html('<div class="map"><div id="world-map-users" class="map-content"></div></div>');
                    var data = {};
                    $.each(_data,function(i,j){
                        data[j['code']] = j['total']; 
                    })

                    $('.world-map-users #world-map-users').vectorMap({
                        map: 'world_mill',
                        zoomButtons : 1,
                        zoomOnScroll: false,
                        panOnDrag: 1,
                        backgroundColor: 'transparent',
                        markerStyle: {
                            initial: {
                                fill: '#ff00ff',
                                stroke: '#ffff00',
                                "stroke-width": 1,
                                r: 5
                            },
                        },
                        onRegionTipShow: function(e, el, code, f){
                            el.html(el.html() + (data[code] ? ': <small>' + data[code]+'</small>' : ''));
                        },
                        series: {
                            regions: [{
                                values: data,
                                scale: ['#ff846e'],
                                normalizeFunction: 'polynomial'
                            }]
                        },
                        regionStyle: {
                            initial: {
                                fill: '#2e4765'
                            },
                            hover: {
                              "fill-opacity": 0.8
                            }
                        },
                        markers:false,
                    });
                };

                load_userworldmap(<?= json_encode($userworldmap) ?>);
            </script>
        </div>

        <div class="dashboard-div site-order-top">
            <div class="dashboard-user-details site-order">
                <div class="user-header">
                    <h2><?= __('admin.website_integration_store') ?></h2>
                    <div class="site-order-wrapp d-flex align-items-center justify-content-between flex-wrap">
                        <div>
                            <div class="pagination-div bg-area">
                                <ul>
                                    <?php
                                        $integration_data_per_page = 10;
                                        $page_count = ceil(count($integration_data['array']) / $integration_data_per_page);

                                        for($i = 1; $i < $page_count+1; $i++){
                                            if($i < 5){
                                                $class = ($i == 1) ? 'class="active"' : ''; ?>
                                                <li <?= $class ?>>
                                                    <a href="javascript:void(0);" data-page="<?= $i ?>"><?= $i ?></a>
                                                </li>
                                            <?php 
                                            }
                                        }
                                    ?>
                                    <?php if($page_count != 1 && (($page_count - 1) > 2)){ ?>
                                        <li class="next">
                                            <a href="javascript:void(0);" data-page="2"><i class="lni lni-chevron-right"></i></a>    
                                        </li>
                                    <?php } ?>    
                                </ul>
                            </div>
                        </div>
                        <div class="bg-area">
                            <select name="filter_integration[year]">
                                <?php foreach($years as $key => $value){ ?>
                                    <option value="<?= $value ?>" <?php if(date('Y') == $value) { ?>selected="selected"<?php } ?>><?= $value ?></option>
                                <?php } ?>
                            </select>
                            <select name="filter_integration[month]">
                                <?php foreach ($months as $key => $value) { ?>
                                    <option value="<?= $value ?>"><?= $value ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="affiliate-table">
                    <table id="external-site-order">
                        <thead>
                            <tr>
                                <th><?= __( 'admin.website' ) ?></th>
                                <th><?= __( 'admin.total_balance' ) ?></th>
                                <th><?= __( 'admin.total_sales' ) ?></th>
                                <th><?= __( 'admin.clicks' ) ?></th>
                                <th><?= __( 'admin.actions' ) ?></th>
                                <th><?= __( 'admin.total_commission' ) ?></th>
                                <th><?= __( 'admin.total_orders' ) ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 0;
                                while($i < $integration_data_per_page){ ?>
                                <tr>
                                    <td class="no-wrap" data-container="body" data-toggle="popover" data-trigger="hover"data-placement="top" data-content="<?= $integration_data['array'][$i]['website'] ?>" copyToClipboard="<?= $integration_data['array'][$i]['website'] ?>">
                                        <?= stringLimiter($integration_data['array'][$i]['website'],20) ?>
                                     </td>
                                    <td class="no-wrap"><?= $integration_data['array'][$i]['balance'] ?></td>
                                    <td class="no-wrap"><?= $integration_data['array'][$i]['total_count_sale'] ?></td>
                                    <td class="no-wrap"><?= $integration_data['array'][$i]['click_count_amount'] ?></td>
                                    <td class="no-wrap"><?= $integration_data['array'][$i]['action_count_amount'] ?></td>
                                    <td class="no-wrap"><?= $integration_data['array'][$i]['total_commission'] ?></td>
                                    <td class="no-wrap"><?= $integration_data['array'][$i]['total_orders'] ?></td>
                                </tr>
                            <?php $i++;
                            } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="dashboard-div pt-0 pr-0 pb-0 mb-0">
            <div class="log-details">
                <div class="user-header">
                    <div class="d-flex align-items-center justify-content-between">
                        <h2><?= __('admin.live_logs') ?></h2>
                        <div class="setting-area"> 
                            <a href="javascript:void(0);" class="btn-count-notification" data-key='live_log' data-type='admin'>
                                <span class="count-notifications"><?= count($live_window) ?></span>
                                <img src="<?= base_url('assets/template/images/notifications-icon.png') ?>" alt="<?= __('admin.notification') ?><">
                            </a> 
                            <a href="javascript:void(0);" class="log-setting btn-setting" data-key='live_log' data-type='admin'> 
                                <i class="lni lni-cog"></i>
                            </a> 
                        </div>
                    </div>
                </div>
                <div class="live-wrap">
                    <div class="live-wrap-empty-data" style="display: <?= !empty($live_window) ? 'none' : 'block'; ?>">
                        <img src="<?= base_url("assets/vertical/assets/images/no-data-2.png"); ?>">
                        <h3><?= __('admin.not_activity_yet') ?></h3>
                    </div>
                    <ul class="ajax-live_window" style="display: <?= empty($live_window) ? 'none' : 'table'; ?>;width: 100%">
                        <?php foreach($live_window as $key => $value){ ?>
                            <?= $value['title'] ?>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $social_share_modal ?>
<?php
    $last_id_integration_logs = 0;
    $last_id_integration_orders = 0;
    $last_id_newuser = 0;
    $last_id_notifications = 0;
    foreach ($integration_logs as $key => $log){
        if($last_id_integration_logs <= $log['id']){ $last_id_integration_logs = $log['id']; }
    }
    foreach ($integration_orders as $key => $order) {
        if($last_id_integration_orders <= $order['id']){ $last_id_integration_orders = $order['id']; }
    }
    foreach ($newuser as $users) {
        if($last_id_newuser <= $users['id']){ $last_id_newuser = $users['id']; }
    }
    foreach ($notifications as $key => $notification) {
        if($last_id_notifications <= $notification['notification_id']){ $last_id_notifications = $notification['notification_id']; }
    }
?>
<script type="text/javascript">
    var ajax_interval = 2000;
    <?php  if((float)$live_dashboard['admin_data_load_interval'] >= 2){ ?>
        ajax_interval  = <?= (float)$live_dashboard['admin_data_load_interval'] * 1000 ?>;
    <?php } ?>

    var dashboard_xhr;
    var last_id_integration_logs = <?= (int)$last_id_integration_logs ?>;
    var last_id_integration_orders = <?= (int)$last_id_integration_orders ?>;
    var last_id_newuser = <?= (int)$last_id_newuser ?>;
    var last_id_notifications = <?= (int)$last_id_notifications ?>;
    var total_commision_filter_year = '<?= date('Y') ?>';
    var total_commision_filter_month = '<?= date('m') ?>';
    var settings_clear = false;
    var homepage_integration_data = JSON.parse('<?= json_encode($integration_data['array']); ?>');
    var integration_data_per_page = <?= $integration_data_per_page ?>;

    function playSound(){
        $("body").append('<iframe id="noti-sound-iframe" src="<?= base_url('/assets/notify/notification.mp3') ?>"></iframe>')
        $("#noti-sound-iframe").on('load',function(){
            setTimeout(function(){
                $("#noti-sound-iframe").remove();
            },1000)
        });
    }

    function setTimeout2(callnexttime,show_popup) {
        $("<div />").css("height","0px").animate({height:'100px'},{
            duration: ajax_interval,
            step: function(now){
                $("#dashboard-progress").css('width',now+"%");
            },
            complete: function(){
                getDashboard(callnexttime,show_popup);
            }
        });
    }

    var checkdata = {
        '.ajax-admin_balance'                     : 'admin_balance',
        '.ajax-sale_total_admin_store'            : 'sale_total_admin_store',
        '.ajax-sale_localstore_vendor_total'      : 'sale_localstore_vendor_total',
        '.ajax-click_action_total'                : 'click_action_total',
        '.ajax-click_action_commission'           : 'click_action_commission',
        '.ajax-all_click_total'                   : 'all_click_total',
        '.ajax-all_click_commission'              : 'all_click_commission',
        '.ajax-click_localstore_total'            : 'click_localstore_total',
        '.ajax-click_localstore_commission'       : 'click_localstore_commission',
        '.ajax-click_integration_total'           : 'click_integration_total',
        '.ajax-click_integration_commission'      : 'click_integration_commission',
        '.ajax-click_form_total'                  : 'click_form_total',
        '.ajax-click_form_commission'             : 'click_form_commission',
        '.ajax-click_all_total'                   : 'click_all_total',
        '.ajax-click_all_commission'              : 'click_all_commission',
        '.ajax-sale_localstore_count'             : 'sale_localstore_count',
        '.ajax-sale_localstore_commission'        : 'sale_localstore_commission',
        '.ajax-sale_localstore_vendor_count'      : 'sale_localstore_vendor_count',
        '.ajax-sale_localstore_vendor_commission' : 'sale_localstore_vendor_commission',
        '.ajax-order_external_count'              : 'order_external_count',
        '.ajax-order_external_commission'         : 'order_external_commission',
        '.ajax-all_sale_count'                    : 'all_sale_count',
        '.ajax-all_sale_commission'               : 'all_sale_commission',
        '.ajax-wallet_unpaid_amounton_hold_count' : 'wallet_unpaid_amounton_hold_count',
        '.ajax-wallet_on_hold_amount'             : 'wallet_on_hold_amount',
        '.ajax-wallet_unpaid_count'               : 'wallet_unpaid_count',
        '.ajax-wallet_unpaid_amount'              : 'wallet_unpaid_amount',
        '.ajax-wallet_request_sent_count'         : 'wallet_request_sent_count',
        '.ajax-wallet_request_sent_amount'        : 'wallet_request_sent_amount',
        '.ajax-wallet_accept_count'               : 'wallet_accept_count',
        '.ajax-wallet_accept_amount'              : 'wallet_accept_amount',
        '.ajax-wallet_cancel_count'               : 'wallet_cancel_count',
        '.ajax-wallet_cancel_amount'              : 'wallet_cancel_amount',
        '.ajax-wallet_trash_count'                : 'wallet_trash_count',
        '.ajax-wallet_trash_amount'               : 'wallet_trash_amount',
        '.ajax-vendor_wallet_accept_count'        : 'vendor_wallet_accept_count',
        '.ajax-vendor_wallet_accept_amount'       : 'vendor_wallet_accept_amount',
        '.ajax-vendor_wallet_request_sent_count'  : 'vendor_wallet_request_sent_count',
        '.ajax-vendor_wallet_request_sent_amount' : 'vendor_wallet_request_sent_amount',
        '.ajax-vendor_wallet_unpaid_count'        : 'vendor_wallet_unpaid_count',
        '.ajax-vendor_wallet_unpaid_amount'       : 'vendor_wallet_unpaid_amount',
        '.ajax-order_vendor_total'                : 'order_vendor_total',
    }

    function setColors() {
        $.each(checkdata,function(ele,Key){
            if($(ele).length){
                var val =  parseInt($(ele).html().toString().replace(/[^0-9-.]/g, '') || 0);

                $(ele).removeClass("text-primary")
                $(ele).removeClass("text-danger")
                if(val >= 0){
                    $(ele).addClass("text-primary");
                } else{
                    $(ele).addClass("text-danger");
                }
            }
        })
    }

    //setColors();

    function getDashboard(callnexttime,show_popup,actions){
        if(dashboard_xhr && dashboard_xhr.readyState != 4) dashboard_xhr.abort();

        if(actions == 'clearlog'){
            settings_clear = true;
            last_id_integration_logs = 0;
            last_id_integration_orders = 0;
            last_id_newuser = 0;
            last_id_notifications = 0;
        }

        dashboard_xhr = $.ajax({
            url:'<?= base_url('admincontrol/ajax_dashboard') ?>',
            type:'POST',
            dataType:'json',
            data:{
                renderChart  : $(".renderChart").val(),
                selectedyear :$('.yearSelection').val(),
                last_id_integration_logs :last_id_integration_logs,
                last_id_integration_orders :last_id_integration_orders,
                last_id_newuser :last_id_newuser,
                last_id_notifications :last_id_notifications,
                last_id_top_notifications :$("#last_id_notifications").val(),
                total_commision_filter_year : $('select[name="filter_commission[year]"]').val(),
                total_commision_filter_month : $('select[name="filter_commission[month]"]').val(),
                integration_data_year : $('select[name="filter_integration[year]"]').val(),
                integration_data_month : $('select[name="filter_integration[month]"]').val(),
                integration_data_selected : $("#integration-chart-type").val(),
            },
            beforeSend:function(){},
            complete:function(){
                if(callnexttime){
                    setTimeout2(true,true);
                }
            },
            success:function(json){
                setTimeout(function(){
                    $('.ajax-live_window .fa-bell').removeClass('blink-icon');
                    $(".mini-stat-icon i").removeClass("blink-icon");
                }, 5000);

                var play_sound = false;
                
                $(".server-last-update em").text(json['time']);
                sessionTimeout(json['timeout']);

                $.each(checkdata,function(ele,Key){
                    if($.trim($(ele).html()) != json['admin_totals'][Key]){
                        play_sound = true;
                        $(ele).html(json['admin_totals'][Key]);
                    }
                })

                //setColors();

                if(json['online_count']){
                    if (typeof json['online_count']['admin'] == 'object' && json['online_count']['admin']['online'] ) {
                        $(".ajax-online-admin").html( json['online_count']['admin']['online']);
                    }
                    if (typeof json['online_count']['user'] == 'object' && json['online_count']['user']['online'] ) {
                        $(".ajax-online-affiliate").html(json['online_count']['user']['online']);
                    }
                    if (typeof json['online_count']['vendor'] == 'object' && json['online_count']['vendor']['online'] ) {
                        $(".ajax-online-vendor").html(json['online_count']['vendor']['online']);
                    }
                    if (typeof json['online_count']['client'] == 'object' && json['online_count']['client']['online'] ) {
                        $(".ajax-online-client").html(json['online_count']['client']['online']);
                    }
                }

                $(".ajax-weekly_balance").html(json['admin_totals_week']);
                $(".ajax-monthly_balance").html(json['admin_totals_month']);
                $(".ajax-yearly_balance").html(json['admin_totals_year']);

                if(json['chart']){
                    $("#dashboard-chart-empty").addClass('d-none');
                    $("#dashboard-chart").removeClass('d-none');
                    
                    renderDashboardChart(json['chart']);
                } else {
                    $("#dashboard-chart-empty").removeClass('d-none');
                    $("#dashboard-chart").addClass('d-none');
                }
                
                load_userworldmap(json['userworldmap']);

                homepage_integration_data = json['integration_data']['array'];

                let homepage_integration_pagination_template = createIntegrationPaginationTemplate(1);
                $(".dashboard-div .pagination-div ul").html(homepage_integration_pagination_template);
                
                let homepage_integration_data_template = createIntegrationDataTemplate(1);
                $(".dashboard-div #external-site-order tbody").html(homepage_integration_data_template);

                $('.popover.bs-popover-top').remove();
                $('[data-toggle="popover"]').popover();

                if($.trim($(".ajax-notifications_count").html()) != json['notifications_count']){
                    play_sound = true;
                }
                $(".ajax-notifications_count").html(json['notifications_count']);

                if(json['newuser']){
                    $.each(json['newuser'], function(i,j){
                        last_id_newuser = last_id_newuser <= parseInt(j['id']) ? parseInt(j['id']) : last_id_newuser;
                        if(show_popup && json['live_dashboard']['admin_affiliate_register_status']){
                            show_tost("success",'<?= __('admin.new_affiliate_register') ?>','<?= __('admin.new_affiliate') ?>'+" "+ j['firstname'] +" "+ j['lastname'] +'<?= __('admin.register_just_now') ?>');
                        }
                    })
                }

                var count = 0;
                if(json['live_window']){
                    var notifications='';
                    $.each(json['live_window'], function(i,j){
                        play_sound = true;
                        count++;
                        notifications += j['title'];
                    })
                    if(notifications){
                        $('.btn-count-notification .count-notifications').text(count);
                        $(".ajax-live_window").html(notifications);

                        $(".live-wrap-empty-data").css('display','none');
                        $(".ajax-live_window").css('display','table');
                    }
                }

                if(json['integration_logs']){
                    $.each(json['integration_logs'], function(i,j){
                        last_id_integration_logs = last_id_integration_logs <= parseInt(j['id']) ? parseInt(j['id']) : last_id_integration_logs;
                        if(j['click_type'] == 'Action'){
                            if(show_popup && json['live_dashboard']['admin_action_status']){
                                show_tost("success",'<?= __('admin.new_action') ?>','<?= __('admin.new_action_click_done_just_now') ?>');
                            }
                        }
                    })
                }

                if(json['integration_orders']){
                    $.each(json['integration_orders'], function(i,j){
                        last_id_integration_orders = last_id_integration_orders <= parseInt(j['id']) ? parseInt(j['id']) : last_id_integration_orders;
                        if(show_popup && json['live_dashboard']['admin_integration_order_status']){
                            show_tost("success",'<?= __('admin.new_integration_order') ?>','<?= __('admin.new_integration_order_place_just_now') ?>');
                        }
                    })
                }

                var top_notifications = '';
                if(json['notifications']){
                    $.each(json['notifications'], function(i,j){
                        top_notifications += '<a class="dropdown-item" href="javascript:void(0)" onclick="shownofication('+ j['notification_id'] +',\'<?= base_url('admincontrol') ?>'+ j['notification_url'] + '\')">\
                            '+ j['notification_title'] +'<em>'+ j['notification_description'] +'</em></a>';
                    })
                }
                
                if(json['last_id_notifications']){
                    $.each(json['last_id_notifications'], function(i,j){
                        if(j['notification_type'] == 'order'){
                            if(show_popup && json['live_dashboard']['admin_local_store_order_status']){
                                show_tost("success",'<?= __('admin.new_local_store_order') ?>', j['notification_title'] + '<?= __('admin.just_now') ?>');
                            }
                        }
                        last_id_notifications = last_id_notifications <= parseInt(j['notification_id']) ? parseInt(j['notification_id']) : last_id_notifications;
                    })
                }

                $("#last_id_top_notifications").val(last_id_notifications);
                $(".ajax-top_notifications_count").html(json['notifications'].length);
                $('#allnotification').html(top_notifications);

                if(play_sound && json['sound_status'] == "1" && show_popup){
                    playSound();
                }
            },
        })
    }

    $(function() {
        $(".progress").on('each',function() {
            var value = $(this).attr('data-value');
            var left = $(this).find('.progress-left .progress-bar');
            var right = $(this).find('.progress-right .progress-bar');
            if (value > 0) {
                if (value <= 50) {
                    right.css('transform', 'rotate(' + percentageToDegrees(value) + 'deg)')
                } else {
                    right.css('transform', 'rotate(180deg)')
                    left.css('transform', 'rotate(180deg)')
                }
            }
        })
        function percentageToDegrees(percentage) {
            return percentage / 100 * 360
        }
    });

    setTimeout2(true,true);

    $(document).on('click','.dashboard-div .pagination-div ul li a',function(e){
        e.preventDefault();

        let page = $(this).data('page');
        $('.dashboard-div .pagination-div ul li.prev a').attr('data-page',page-1);
        $('.dashboard-div .pagination-div ul li.next a').attr('data-page',page+1);

        let homepage_integration_pagination_template = createIntegrationPaginationTemplate(page);
        $(".dashboard-div .pagination-div ul").html(homepage_integration_pagination_template);

        let homepage_integration_data_template = createIntegrationDataTemplate(page);
        $(".dashboard-div #external-site-order tbody").html(homepage_integration_data_template);

        $('.popover.bs-popover-top').remove();
        $('[data-toggle="popover"]').popover();
    })  

    function createIntegrationPaginationTemplate(page){
        let template = '';
        let count = homepage_integration_data.length;
        let page_count = Math.ceil(count/integration_data_per_page);

        let diff = page_count - page;
        let i = 1;

        if(diff < 3)
            i = page + diff - 3;
        else 
            i = page;
        
        if(page > 2 && ((page + 2) < page_count))
            i--;

        if(i < 1)
            i = 1;

        if(page != 1)
            template += '<li class="prev"><a href="javascript:void(0)" data-page="' + (page - 1) +'"><i class="lni lni-chevron-left"></i></a></li>';

        let counter = 1;
        for(i; i < page_count+1; i++){
            if(counter < 5){
                let activeClass = (i == page) ? 'class="active"' : '';
                template += '<li ' + activeClass + '><a href="javascript:void(0)" data-page="' + i +'">' + i + '</a></li>';
            }
            counter++;
        }

        if(page != page_count && diff > 2)
            template += '<li class="next"><a href="javascript:void(0)" data-page="' + (page + 1) +'"><i class="lni lni-chevron-right"></i></a></li>';

        return template;
    }

    function createIntegrationDataTemplate(page){
        let template = '';
        let offset = (page - 1) * integration_data_per_page;
        for(let i = offset; i < (integration_data_per_page + offset); i++){
            if(homepage_integration_data[i]){
                template += '<tr>';
                    template += '<td class="no-wrap" data-container="body" data-toggle="popover" data-trigger="hover"data-placement="top" data-content="'+homepage_integration_data[i].website+'" copyToClipboard="'+homepage_integration_data[i].website+'">'+stringLimiter(homepage_integration_data[i].website,20)+'</td>';
                    template += '<td class="no-wrap">'+homepage_integration_data[i].balance+'</td>';
                    template += '<td class="no-wrap">'+homepage_integration_data[i].total_count_sale+'</td>';
                    template += '<td class="no-wrap">'+homepage_integration_data[i].click_count_amount+'</td>';
                    template += '<td class="no-wrap">'+homepage_integration_data[i].action_count_amount+'</td>';
                    template += '<td class="no-wrap">'+homepage_integration_data[i].total_commission+'</td>';
                    template += '<td class="no-wrap">'+homepage_integration_data[i].total_orders+'</td>';
                template += '</tr>';
            }
        }

        return template;
    }

    function stringLimiter(text,length){
        if(text.length <= length){
            return text;
        } else {
            text = text.substr(text,length) + '...';
            return text;
        }
    }

</script>