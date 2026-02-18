<?php
  $db =& get_instance();

  $products = $db->Product_model;
  $store_setting =$db->Product_model->getSettings('store');
  $userdetails=$db->Product_model->userdetails();
  $license = $products->getLicese();
  $notifications = $products->getnotificationnew('admin',null,5);
  $notifications_count = $products->getnotificationnew_count('admin',null);
  $referlevel_status = $this->Product_model->getSettings('referlevel', 'status');
  $market_vendor_marketvendorstatus = $this->Product_model->getSettings('market_vendor', 'marketvendorstatus');
  $vendor_storestatus = $this->Product_model->getSettings('vendor', 'storestatus');
  $market_vendor_marketvendorstatus =  isset($market_vendor_marketvendorstatus['marketvendorstatus']) ? $market_vendor_marketvendorstatus['marketvendorstatus'] : 0;
  $vendor_storestatus =  isset($vendor_storestatus['storestatus']) ? $vendor_storestatus['storestatus'] : 0;
  $membership_status = $this->Product_model->getSettings('membership', 'status');
  $store_status = $this->Product_model->getSettings('store', 'status');
  $award_level_status = $this->Product_model->getSettings('award_level','status');
  $sidebar_data = array (
      'mlm_is_enable' => isset($referlevel_status['status']) ? $referlevel_status['status'] : 0,
      'saas_is_enable' => ($market_vendor_marketvendorstatus == 1 || $vendor_storestatus == 1) ? 1 : 0,
      'membership_is_enable' => isset($membership_status['status']) ? $membership_status['status'] : 0,
      'store_is_enable' => isset($store_status['status']) ? $store_status['status'] : 0,
      'award_level_is_enable' => isset($award_level_status['status']) ? $award_level_status['status'] : 0,
  );
?>
<div class="left-menu">
  <div class="collapse d-block">
    <ul class="navbar-nav scroll-wrap">
      <li class="nav-item dropdown">
        <a class="nav-link d-flex" href="<?= base_url('admincontrol/dashboard') ?>">
          <div>
            <img src="<?= base_url('assets/template/images/home-icon.png') ?>" alt="<?= __('admin.menu_dashboard') ?>"/><?= __('admin.menu_dashboard') ?>
          </div>
        </a> 
      </li>


      <li class="nav-item dropdown"> 
        <a class="nav-link dropdown-toggle" href="javascript:void(0);" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <div> 
          <img src="<?= base_url('assets/template/images/rgb-icon.png') ?>" alt="<?= __('admin.useful_links') ?>"/><?= __('admin.useful_links') ?>
        </div>
        <div>
          <i class="lni lni-chevron-right"></i>
        </div>
        </a>
        <div class="dropdown-menu"> 
            <a class="dropdown-item" href="<?= base_url('admincontrol/addons') ?>"><?= __('admin.menu_addons') ?></a>
            <a class="dropdown-item" <?= $sidebar_data['award_level_is_enable'] == 0 ? 'style="display:none;"' : ''; ?> href="<?= base_url('admincontrol/award_level') ?>"><?= __('admin.award_level') ?></a>
            <a class="dropdown-item" href="<?= base_url('admincontrol/affiliate_theme') ?>"><?= __('admin.affiliate_theme') ?></a>
            <a class="dropdown-item" href="<?= base_url('admincontrol/language') ?>"><?= __('admin.menu_language') ?></a>
            <a class="dropdown-item" href="<?= base_url('admincontrol/currency_list') ?>"><?= __('admin.menu_currency') ?></a>
            <a class="dropdown-item" href="<?= base_url('admincontrol/system_status') ?>"><?= __('admin.server') ?></a>
            <a class="dropdown-item" href="<?= base_url('admincontrol/paymentsetting') ?>"><?= __('admin.menu_setting') ?></a>
        </div>
      </li>

      <li class="nav-item dropdown"> 
        <a class="nav-link dropdown-toggle" href="javascript:void(0);" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <div> 
          <img src="<?= base_url('assets/template/images/rgb-icon.png') ?>" alt="<?= __('admin.payments_system') ?>"/><?= __('admin.payments_system') ?>
        </div>
        <div>
          <i class="lni lni-chevron-right"></i>
        </div>
        </a>
        <div class="dropdown-menu"> 
            <a class="dropdown-item" href="<?= base_url('admincontrol/payment_gateway') ?>"><?= __('admin.payment_gateways') ?></a>
            <a class="dropdown-item" href="<?= base_url('admincontrol/all_transaction') ?>"><?= __('admin.menu_all_transactions') ?></a> 
        </div>
      </li>

      <li class="nav-item dropdown"> 
        <a class="nav-link dropdown-toggle" href="javascript:void(0);" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <div> 
          <img src="<?= base_url('assets/template/images/rgb-icon.png') ?>" alt="<?= __('admin.program_integrations') ?>"/><?= __('admin.program_integrations') ?>
        </div>
        <div>
          <i class="lni lni-chevron-right"></i>
        </div>
        </a>
        <div class="dropdown-menu"> 
          <a class="dropdown-item" href="<?= base_url('integration/integration_tools') ?>"><?= __('admin.menu_affiliate_marketing') ?></a>
          <a class="dropdown-item" href="<?= base_url('integration/programs') ?>"><?= __('admin.sub_menu_integration_programs') ?></a>
          <a class="dropdown-item" href="<?= base_url('integration/integration_category') ?>"><?= __('admin.integration_category') ?></a>
        </div>
      </li>

      <li class="nav-item dropdown"> 
        <a class="nav-link dropdown-toggle" href="javascript:void(0);" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <div> 
          <img src="<?= base_url('assets/template/images/info-icon.png') ?>" alt="<?= __('admin.system_activity') ?>"/><?= __('admin.system_activity') ?>
        </div>
        <div>
          <i class="lni lni-chevron-right"></i>
        </div>
        </a>
        <div class="dropdown-menu"> 
          <a class="dropdown-item" href="<?= base_url('admincontrol/store_orders') ?>"><?= __('admin.my_all_orders') ?></a>
          <a class="dropdown-item" href="<?= base_url('admincontrol/store_logs') ?>"><?= __('admin.my_all_logs') ?></a>
          <!-- <a class="dropdown-item" href="<?= base_url('admincontrol/store_markettools') ?>"><?= __('admin.all_markettools') ?></a> -->
          <a class="dropdown-item" href="<?= base_url('incomereport') ?>"><?= __('admin.menu_users_statistics') ?></a>
          <a class="dropdown-item" href="<?= base_url('reportController/admin_transaction') ?>"><?= __('admin.menu_report_transactions') ?></a>
          <a class="dropdown-item" href="<?= base_url('reportController/admin_statistics') ?>"><?= __('admin.menu_report_graphs') ?></a>

        </div>
      </li>

      <li class="nav-item dropdown"> 
        <a class="nav-link dropdown-toggle" href="javascript:void(0);" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <div> 
          <img src="<?= base_url('assets/template/images/wallet-icon.png') ?>" alt="<?= __('admin.menu_admin_wallet') ?>"/><?= __('admin.menu_admin_wallet') ?>
        </div>
        <div>
          <i class="lni lni-chevron-right"></i>
        </div>
        </a>
        <div class="dropdown-menu"> 
          <a class="dropdown-item" href="<?= base_url('admincontrol/mywallet') ?>"><?= __('admin.menu_all_transactions') ?></a>
          <a class="dropdown-item" href="<?= base_url('admincontrol/wallet_requests_list') ?>"><?= __('admin.menu_withdraw_request_v2') ?></a>
          <a class="dropdown-item" href="<?= base_url('admincontrol/withdrawal_payment_gateways') ?>"><?= __('admin.withdrawal_payment_gateways') ?></a>
          <a class="dropdown-item" href="<?= base_url('admincontrol/wallet_setting') ?>"><?= __('admin.wallet_setting') ?></a>
        </div>
      </li>

      <li id="sidebar_mlm" class="nav-item dropdown" <?= $sidebar_data['mlm_is_enable'] == 0 ? 'style="display:none;"' : ''; ?>> 
        <a class="nav-link dropdown-toggle" href="javascript:void(0);" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <div> 
          <img src="<?= base_url('assets/template/images/settings-icon-2.png') ?>" alt="<?= __('admin.menu_mlm') ?>"/><?= __('admin.menu_mlm') ?>
        </div>
        <div>
          <i class="lni lni-chevron-right"></i>
        </div>
        </a>
        <div class="dropdown-menu"> 
          <a class="dropdown-item" href="<?= base_url('admincontrol/mlm_settings') ?>"><?= __('admin.menu_mlm_settings') ?></a>
          <a class="dropdown-item" href="<?= base_url('admincontrol/mlm_levels') ?>"><?= __('admin.menu_mlm_levels') ?></a>
        </div>
      </li>

      <li id="sidebar_saas" class="nav-item dropdown" <?= $sidebar_data['saas_is_enable'] == 0 ? 'style="display:none;"' : ''; ?>> 
        <a class="nav-link dropdown-toggle" href="javascript:void(0);" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <div> 
          <img src="<?= base_url('assets/template/images/settings-icon-2.png') ?>" alt="<?= __('admin.menu_saas') ?>"/><?= __('admin.menu_saas') ?>
        </div>
        <div>
          <i class="lni lni-chevron-right"></i>
        </div>
        </a>
        <div class="dropdown-menu"> 
          <a class="dropdown-item" href="<?= base_url('admincontrol/saas_setting') ?>"><?= __('admin.menu_saas_settings') ?></a>
          <a class="dropdown-item" href="<?= base_url('admincontrol/vendor_deposits') ?>"><?= __('admin.vendor_deposit') ?></a>
        </div>
      </li>



      <li class="nav-item dropdown"> 
        <a class="nav-link dropdown-toggle" href="javascript:void(0);" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <div> 
          <img src="<?= base_url('assets/template/images/member-icon.png') ?>" alt="<?= __('admin.menu_members') ?>"/><?= __('admin.menu_members') ?>
        </div>
        <div>
          <i class="lni lni-chevron-right"></i>
        </div>
        </a>
        <div class="dropdown-menu"> 
          <a class="dropdown-item" href="<?= base_url('admincontrol/userslist') ?>"><?= __('admin.menu_list_affiliates') ?></a>
          <a class="dropdown-item" href="<?= base_url('admincontrol/usergroup') ?>"><?= __('admin.menu_user_group') ?></a>
          <a class="dropdown-item" href="<?= base_url('admincontrol/userslisttree') ?>"><?= __('admin.menu_referring_tree') ?></a>
          <a class="dropdown-item" href="<?= base_url('admincontrol/userslistmail') ?>"><?= __('admin.menu_list_affiliates_email') ?></a>
          <?php if($userdetails['id'] == 1){ ?>
            <a class="dropdown-item" href="<?= base_url('admincontrol/admin_user') ?>"><?= __('admin.menu_manage_admin') ?></a>
          <?php } ?>  
        </div>
      </li>

      <li id="sidebar_membership" class="nav-item dropdown" <?= $sidebar_data['membership_is_enable'] == 0 ? 'style="display:none;"' : ''; ?>> 
        <a class="nav-link dropdown-toggle" href="javascript:void(0);" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <div> 
          <img src="<?= base_url('assets/template/images/membership-icon.png') ?>" alt="<?= __('admin.membership') ?>"/><?= __('admin.membership') ?>
        </div>
        <div>
          <i class="lni lni-chevron-right"></i>
        </div>
        </a>
        <div class="dropdown-menu"> 
          <a class="dropdown-item" href="<?= base_url('membership/plans') ?>"><?= __('admin.membership_plans') ?></a>
          <a class="dropdown-item" href="<?= base_url('membership/membership_orders') ?>"><?= __('admin.membership_orders') ?></a>
          <a class="dropdown-item" href="<?= base_url('membership/settings') ?>"><?= __('admin.membership_settings') ?></a>
        </div>
      </li>

      <li id="sidebar_store" class="nav-item dropdown" <?= $sidebar_data['store_is_enable'] == 0 ? 'style="display:none;"' : ''; ?>>
        <a class="nav-link d-flex" href="<?= base_url('admincontrol/store_dashboard') ?>">
          <div>
            <img src="<?= base_url('assets/template/images/shopping-bag.png') ?>" alt="<?= __('admin.menu_my_store') ?>"/><?= __('admin.menu_my_store') ?>
          </div>
        <div>
          <i class="lni lni-chevron-right"></i>
        </div>
        </a> 
      </li>
    </ul>
  </div>
</div>