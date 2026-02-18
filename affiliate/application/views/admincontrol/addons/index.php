<?php if(false){ ?>
  <div class="page-content-wrapper ">
    <div class="container_">
      <?php echo $doc_config['content']; ?>
    </div>
  </div>
<?php } ?>  


<style>
.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
  margin-top:50px;
}

.switch input { 
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}

.card-title{
  text-align:center;
}

.card-header{
  font-size:20px;
}
</style>

<div class="addon-module-switcher">
  <div class="card card-title text-white <?= ((int)$mlm_is_enable > 0) ? "bg-info" : "bg-secondary"; ?> mb-3">
    <div class="card-header"><?= __('admin.mlm_module') ?></div>
    <div class="card-body">
      <label class="switch"><input class="activity" type="checkbox" data-setting_type="referlevel" data-setting_key="status" data-sidebar="mlm" <?= ((int)$mlm_is_enable > 0) ? "checked" : ""; ?>><span class="slider round"></span></label>
    </div>
  </div>

  <div class="card card-title text-white <?= ((int)$saas_is_enable > 0) ? "bg-info" : "bg-secondary"; ?> mb-3">
    <div class="card-header"><?= __('admin.saas_module') ?></div>
    <div class="card-body">
      <label class="switch"><input class="activity" type="checkbox" data-setting_type="market_vendor" data-setting_key="marketvendorstatus" data-sidebar="saas" <?= ((int)$saas_is_enable > 0) ? "checked" : ""; ?>><span class="slider round"></span></label>
    </div>
  </div>

  <div class="card card-title text-white <?= ((int)$store_is_enable > 0) ? "bg-info" : "bg-secondary"; ?> mb-3">
    <div class="card-header"><?= __('admin.store_module') ?></div>
    <div class="card-body">
      <label class="switch"><input class="activity" type="checkbox" data-setting_type="store" data-setting_key="status" data-sidebar="store" <?= ((int)$store_is_enable > 0) ? "checked" : ""; ?>><span class="slider round"></span></label>
    </div>
  </div>

  <div class="card card-title text-white <?= ((int)$membership_is_enable > 0) ? "bg-info" : "bg-secondary"; ?> mb-3">
    <div class="card-header"><?= __('admin.membership_module') ?></div>
    <div class="card-body">
      <label class="switch"><input class="activity" type="checkbox" data-setting_type="membership" data-setting_key="status" data-sidebar="membership" <?= ((int)$membership_is_enable > 0) ? "checked" : ""; ?>><span class="slider round"></span></label>
    </div>
  </div>

  <div class="card card-title text-white <?= ((int)$vendor_deposit_is_enable > 0) ? "bg-info" : "bg-secondary"; ?> mb-3">
    <div class="card-header"><?= __('admin.vendor_deposit_module') ?></div>
    <div class="card-body">
      <label class="switch"><input class="activity" type="checkbox" data-setting_type="vendor" data-setting_key="depositstatus" data-sidebar="vendor" <?= ((int)$vendor_deposit_is_enable > 0) ? "checked" : ""; ?>><span class="slider round"></span></label>
    </div>
  </div>

  <div class="card card-title text-white <?= ((int)$award_level_is_enable > 0) ? "bg-info" : "bg-secondary"; ?> mb-3">
    <div class="card-header"><?= __('admin.award_level') ?></div>
    <div class="card-body">
      <label class="switch"><input class="activity" type="checkbox" data-setting_type="award_level" data-setting_key="status" data-sidebar="award_level" <?= ((int)$award_level_is_enable > 0) ? "checked" : ""; ?>><span class="slider round"></span></label>
    </div>
  </div>
</div>
  

<div class="row">
  <div class="col-md-2">
    <div class="card card-title text-white bg-info mb-3">
      <div class="card-header"><?= __( 'admin.menu_setting') ?></div>
      <div class="card-body">
        <a href="<?= base_url('admincontrol/paymentsetting') ?>" target="_blank" role="button" class="btn btn-primary btn-sm"><?php echo __( 'admin.go_to_module') ?></a>
      </div>
    </div>
  </div>

  <div class="col-md-2">
    <div class="card card-title text-white bg-info mb-3">
      <div class="card-header"><?= __( 'admin.language') ?></div>
      <div class="card-body">
        <a href="<?= base_url('admincontrol/language') ?>" target="_blank" role="button" class="btn btn-primary btn-sm"><?= __( 'admin.go_to_module') ?></a>
      </div>
    </div>
  </div>

  <div class="col-md-2">
    <div class="card card-title text-white bg-info mb-3">
      <div class="card-header"><?= __( 'admin.currency') ?></div>
      <div class="card-body">
        <a href="<?= base_url('admincontrol/currency_list') ?>" target="_blank" role="button" class="btn btn-primary btn-sm"><?php echo __( 'admin.go_to_module') ?></a>
      </div>
    </div>
  </div>


  <div class="col-md-2">
    <div class="card card-title text-white bg-info mb-3">
      <div class="card-header"><?= __('admin.mail_templates') ?></div>
      <div class="card-body">
        <a href="<?= base_url('admincontrol/mails') ?>" target="_blank" role="button" class="btn btn-primary btn-sm"><?php echo __( 'admin.go_to_module') ?></a>
      </div>
    </div>
  </div>


  <div class="col-md-2">
    <div class="card card-title text-white bg-info mb-3">
      <div class="card-header"><?= __( 'admin.registration_form') ?></div>
      <div class="card-body">
        <a href="<?= base_url('admincontrol/registration_builder') ?>" target="_blank" role="button" class="btn btn-primary btn-sm"><?php echo __( 'admin.go_to_module') ?></a>
      </div>
    </div>
  </div>

  <div class="col-md-2">
    <div class="card card-title text-white bg-info mb-3">
      <div class="card-header"><?= __( 'admin.backups') ?></div>
      <div class="card-body">
        <a href="<?= base_url('admincontrol/backup') ?>" target="_blank" role="button" class="btn btn-primary btn-sm"><?= __( 'admin.go_to_module') ?></a>
      </div>
    </div>
  </div>


</div>

<div class="row">

  <div class="col-md-2">
    <div class="card card-title text-white bg-info mb-3">
      <div class="card-header"><?= __( 'admin.update_version') ?></div>
      <div class="card-body">
        <a href="<?= base_url('admincontrol/install_new_version') ?>" target="_blank" role="button" class="btn btn-primary btn-sm"><?php echo __( 'admin.go_to_module') ?></a>
      </div>
    </div>
  </div>

  <div class="col-md-2">
    <div class="card card-title text-white bg-info mb-3">
      <div class="card-header"><?= __( 'admin.system_status') ?></div>
      <div class="card-body">
        <a href="<?= base_url('admincontrol/system_status') ?>" target="_blank" role="button" class="btn btn-primary btn-sm"><?php echo __( 'admin.go_to_module') ?></a>
      </div>
    </div>
  </div>

  <div class="col-md-2">
    <div class="card card-title text-white bg-info mb-3">
      <div class="card-header"><?= __( 'admin.system_license') ?></div>
      <div class="card-body">
        <a href="<?= base_url('admincontrol/script_details') ?>" target="_blank" role="button" class="btn btn-primary btn-sm"><?php echo __( 'admin.go_to_module') ?></a>
      </div>
    </div>
  </div>

    <div class="col-md-2">
    <div class="card card-title text-white bg-info mb-3">
      <div class="card-header"><?= __( 'admin.admin_user_theme') ?></div>
      <div class="card-body">
        <a href="<?= base_url('admincontrol/theme_setting') ?>" target="_blank" role="button" class="btn btn-primary btn-sm"><?php echo __( 'admin.go_to_module') ?></a>
      </div>
    </div>
  </div>

  <div class="col-md-2">
    <div class="card card-title text-white bg-info mb-3">
      <div class="card-header"><?= __('admin.how_to_integrate') ?></div>
      <div class="card-body">
        <a href="<?= base_url('integration/how_to_start') ?>" target="_blank" role="button" class="btn btn-primary btn-sm"><?php echo __( 'admin.go_to_module') ?></a>
      </div>
    </div>
  </div>

  <div class="col-md-2">
    <div class="card card-title text-white bg-info mb-3">
      <div class="card-header"><?= __('admin.first_settings') ?></div>
      <div class="card-body">
        <a href="<?= base_url('firstsetting') ?>" target="_blank" role="button" class="btn btn-primary btn-sm"><?php echo __( 'admin.go_to_module') ?></a>
      </div>
    </div>
  </div>

</div>


<?= $integration_modules_view; ?>



<script type="text/javascript">
  $("input[data-setting_key='depositstatus']").on('change',function(){
    if($(this).is(':checked')){
      Swal.fire({
        icon: 'info',
        text: "<?= __('admin.vendor_deposit_on_message')  ?>",
      })
    } else {
      Swal.fire({
        icon: 'warning',
        text: "<?= __('admin.vendor_deposit_off_message')  ?>",
      }) 
    }
  })

  $(document).on('change', '.activity', function(){
    let setting_type = $(this).data('setting_type');
    let setting_key = $(this).data('setting_key');
    let val = $(this).prop('checked') ? 1 : 0;
    
    let menu =  $(this).data('sidebar');

    if(val) {
      $('#sidebar_'+menu).show();
      $(this).closest('.card').removeClass('bg-secondary');
      $(this).closest('.card').addClass('bg-info');
    } else {
      $('#sidebar_'+menu).hide();
      $(this).closest('.card').addClass('bg-secondary');
      $(this).closest('.card').removeClass('bg-info');
    }

    $.ajax({
      type: "POST",
      data: {
        action: 'change_status', 
        setting_type: setting_type, 
        setting_key : setting_key, 
        val : val
      },
      success: function(res){
      },
    });
  });
</script>