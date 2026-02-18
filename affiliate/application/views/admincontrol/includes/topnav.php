<?php
  $db = & get_instance();
  $SiteSetting =$db->Product_model->getSiteSetting();
  $products = $db->Product_model;
  $notifications = $products->getnotificationnew('admin', null, 5);
  $notifications_count = $products->getnotificationnew_count('admin', null);
  $userdetails=$db->Product_model->userdetails();
  $license = $products->getLicese();
  $LanguageHtml = $products->getLanguageHtml();
  $CurrencyHtml = $products->getCurrencyHtml();
  $noti_order = $products->hold_noti();
  $commonSetting = array(
      'site' => array('notify_email'),
      'store' => array('affiliate_cookie'),
      'email' => array('from_email'),
      'productsetting' => array('product_commission', 'product_ppc', 'product_noofpercommission'),
      'affiliateprogramsetting' => array('affiliate_commission', 'affiliate_ppc'),
      'paymentsetting' => array('api_username', 'api_password', 'api_signature'),
  );
  $allSettings = array();
  foreach ($commonSetting as $key => $value) {
      $allSettings[$key] = $products->getSettings($key);
  }
  $required = '';
  $validate = true;
  foreach ($commonSetting as $key => $fields) {
      $data = $allSettings[$key];
      foreach ($fields as $field) {
          if (!isset($data[$field]) || $data[$field] == '') {
              $required .= "{$key} - {$field} \n";
              $validate = false;
          }
      }
  }

  $page_id = $products->page_id();

  $serverReq = checkReq();
  
  require APPPATH."config/breadcrumb.php";
  $pageKey = $db->Product_model->page_id();

  $site_setting_timeout = $this->Product_model->getSettings('site', 'session_timeout');
  $timeout = (isset($site_setting_timeout['session_timeout']) && is_numeric($site_setting_timeout['session_timeout'])) ? $site_setting_timeout['session_timeout'] : 1800;
?>
<div class="dashboard-wrap" style="border-radius: 51px 0 0 51px;">
  <div class="dashboard-main-right">
    <div class="dashboard-navbar">
       <div class="header-top d-flex justify-content-end align-items-center">
          <div class="logo">
            <?php $logo = $SiteSetting['admin-side-logo'] ? base_url('assets/images/site/'. $SiteSetting['admin-side-logo'] ) : base_url('assets/template/images/logo.png'); ?>
            <a href="<?= base_url('admincontrol/dashboard'); ?>">
              <img src="<?= $logo  ?>" alt="<?= __('admin.logo') ?>"/>
            </a>
          </div>

          <div class="header-right">
            <ul class="d-flex align-items-center justify-content-between">
              <li id="admin-currency-top-menu" class="nav-item dropdown border-0"><?= $CurrencyHtml ?></li>

              <li class="nav-item dropdown arrow-position"><?= $LanguageHtml ?></li>

              <li class="nav-item dropdown notification-area arrow-position">
                <?php if ($notifications_count == null) { ?> 
                  <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" onclick="resetNotify();">
                    <span class="bell"></span>
                    <img src="<?= base_url('assets/template/images/notification-icon.png') ?>" alt="<?= __('admin.notifications') ?>"/>
                    <span class="notifications-count ajax-notifications_count"><?= $notifications_count; ?></span>
                  </a> 
                <?php } else { ?>
                  <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" onclick="resetNotify();">
                    <span class="bell"></span>
                    <img src="<?= base_url('assets/template/images/notification-icon.png') ?>" alt="<?= __('admin.notifications') ?>"/>
                    <span class="notifications-count ajax-notifications_count"><?= $notifications_count; ?></span>
                  </a>
                 <?php } ?>
                  
                <div class="dropdown-menu dropdown-menu-right shadow user-setting">
                  <i class="arrow"></i>
                  <div class="heading-notification d-flex justify-content-between align-items-center">
                    <h4><?= __('admin.notification') ?></h4>
                    <strong class="ajax-top_notifications_count"><?= $notifications_count; ?></strong>
                  </div>
                  <div id="allnotification">
                    <?php $last_id_notifications = 0;
                      foreach($notifications as $key => $notification){
                        if($last_id_notifications <= $notification['notification_id']){
                          $last_id_notifications = $notification['notification_id'];
                        } ?>
                        <a class="dropdown-item" href="javascript:void(0)" onclick="shownofication(<?= $notification['notification_id'] . ',\'' . base_url('admincontrol') . $notification['notification_url'] . '\''; ?>)" >
                          <?= $notification['notification_title']; ?>
                          <em><?= $notification['notification_description']; ?></em> 
                        </a>
                    <?php } ?>
                    <input type="hidden" id="last_id_notifications" value="<?= $last_id_notifications ?>">
                  </div>
                  <div class="text-center"> 
                    <a class="dropdown-item view-area" href="<?= base_url('admincontrol/notification') ?>"> + <?= __('admin.common_view_all') ?> </a> 
                  </div>
                </div>
              </li>

              <li class="nav-item dropdown user-right border-0">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <?php $login_user_profile_avatar =  (!empty($userdetails['avatar'])) ? base_url('assets/images/users/'.$userdetails['avatar']) : base_url('assets/vertical/assets/images/no-image.jpg'); ?>
                  <img class="profile-image" src="<?= $login_user_profile_avatar; ?>" alt="<?= $this->session->userdata('administrator')['firstname'].' '.$this->session->userdata('administrator')['lastname'] ?>"/>
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow  user-setting">
                  <i class="arrow"></i> 
                  <a class="dropdown-item" href="<?= base_url('admincontrol/editProfile'); ?>"><?= __('admin.top_profile') ?></a>
                  <a class="dropdown-item" href="<?= base_url('admincontrol/changePassword'); ?>"><?= __('admin.top_change_password') ?></a>
                  <a class="dropdown-item" href="<?= base_url('admincontrol/mywallet'); ?>"><?= __('admin.top_my_wallet') ?></a>
                  <a class="dropdown-item" href="<?= base_url('admincontrol/paymentsetting'); ?>"><?= __('admin.top_settings') ?></a>
                  <a class="dropdown-item" href="<?= base_url('admincontrol/logout'); ?>"><?= __('admin.top_logout') ?></a>
              </li>
            </ul>
            <ol class="breadcrumb hide-breadcrumb">
             <?php $count = count($pageSetting[$pageKey]['breadcrumb']);
              foreach($pageSetting[$pageKey]['breadcrumb'] as $key => $value){ ?>
                <li class="breadcrumb-item <?= $count == $key ? 'active' : '' ?>">
                  <a href="<?= $value['link'] ?>"><?= $value['title'] ?></a>
                </li>
            <?php } ?>
          </ol>
          </div>
          <a href="#" class="menu-button"><span></span><span></span><span></span> </a>
        </div>
         <div class="header-left">
          <div class="header-heading d-flex justify-content-between align-items-center">
            <h1><?= $pageSetting[$pageKey]['title'] ?></h1>
            <div>
              <span> <?= __('admin.menu_welcome') ?></span>
              <strong><?= $this->session->userdata('administrator')['firstname'].' '.$this->session->userdata('administrator')['lastname'] ?></strong>
              <a href="javaScript:location.reload(true);" class="reload-btn" title="<?= ('admin.refresh_page') ?>">
                <img src="<?= base_url('assets/template/images/refresh-icon.png') ?>" alt="<?= ('admin.refresh_page') ?>">
              </a> 
            </div>
          </div>
          <div class="header-updated d-flex justify-content-between align-items-center flex-wrap">
            <div class="updated-div"> 
              <span class="server-last-update m-0"><?= __('admin.last_updated') ?>: <em><?= date("h:i:s A") ?></em></span> 
              <span class="dashboard-refresh"><?= __('admin.session_timeout') ?>: <em>00:01:00</em></span>
            </div>
            <div class="setting-div">
              <span>
                <?php if(count($serverReq) == 0){ ?>
                  <a href="javascript:void(0);">
                    <i class="lni lni-checkmark"></i>
                  </a>
                <?php } else { ?>
                  <a href="javascript:void(0);">
                    <i class="lni lni-close"></i>
                  </a>
                <?php } ?>
              </span>
              <span class="setting-bg">
                <a href="javascript:void(0);" class="btn-setting" data-key='live_dashboard' data-type='admin'><i class="lni lni-cog"></i></a>
              </span>
              <span class="eye-bg">
                <a href="<?= base_url() ?>" target="_blank"><i class="lni lni-eye"></i></a>
              </span>
            </div>
          </div>
          <?php if($pageKey == 'admincontrol_dashboard'){ ?>
            <div id="dashboard-progress"></div>
           <?php } ?>
        </div>
    </div>

    <div class="server-errors">
       <?php 
          if($serverReq){
            echo "<div class='requirement-error'>";
            
            foreach($serverReq as $key => $e)
              echo "<p>{$e}</p>";

            echo "</div>";
          }

          $setting_market_vendor_status= $this->Product_model->getSettings('market_vendor', 'marketvendorstatus');
          $setting_vendor_min_deposit = $this->Product_model->getSettings('site', 'vendor_min_deposit');
          $setting_vendor_deposit_status = $this->Product_model->getSettings('vendor', 'depositstatus');

          if($setting_market_vendor_status['marketvendorstatus'] == 1 && $setting_vendor_min_deposit['vendor_min_deposit'] == 0 && $setting_vendor_deposit_status['depositstatus'] == 1){
            echo "<div class='requirement-error'>";
            echo "<p>".__('admin.vendor_min_deposit_alert')." <a href='".base_url('/admincontrol/saas_setting')."'>".__('admin.set_here')."</a></p>";
            echo "</div>";
          }
       ?>
    </div>
    <script>
      function sessionTimeout(){
        var dt = new Date();
        let distance = (GlobaleCountDownDate - dt.getTime()) / 1000;

        let h = Math.floor(distance / 3600);
        let m = Math.floor(distance % 3600 / 60);
        let s = Math.floor(distance % 3600 % 60);

        let string = "";

        string += (h > 0) ? ('0'+h).slice(-2)+":" : "00:"; 

        string += (m > 0) ? ('0'+m).slice(-2)+":" : "00:"; 

        string += (s > 0) ? ('0'+s).slice(-2)+"" : "00"; 

        $(".dashboard-refresh em").text(string);

        if (distance <= 0){
          window.location.replace('<?= base_url('admincontrol/logout'); ?>');
          clearInterval(GlobaleCountDownDateInterval);
        }
      }

      var dt = new Date();
      var GlobaleCountDownDate = dt.setTime(dt.getTime() + (<?= $timeout ?> * 1000));

      sessionTimeout();
      var GlobaleCountDownDateInterval = setInterval(sessionTimeout,100);

      $(document).ajaxComplete(function(event, request, settings) {
         let parts = settings.url.split("/");
         let last_part = parts[parts.length-1];
         if(last_part != "ajax_dashboard"){
          var dt = new Date();
          var GlobaleCountDownDate = dt.setTime(dt.getTime() + (<?= $timeout ?> * 1000));
         }
      });
    </script>
    <div class="content-wrapper">