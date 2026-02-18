
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>Admin Login</title>
    <meta content="Admin Dashboard" name="description">
    <meta content="Mannatthemes" name="author">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <?php if($setting['favicon']){ ?>
        <link rel="icon" href="<?php echo base_url('assets/images/site/'.$setting['favicon']) ?>" type="image/*" sizes="16x16">
    <?php } ?>

    <!--  CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/admin/'); ?>css/bootstrap.css">
    <link rel="stylesheet" href="<?= base_url('assets/admin/'); ?>fonts/stylesheet.css">
    <link rel="stylesheet" href="<?= base_url('assets/admin/'); ?>css/style.css">

    <title>Admin Login</title>
  </head>
  <body>
  
  <div class="login-main">
    <div class="login-wrapper">
        <div class="login-form">
        <?php $logo = $setting['admin-side-logo'] ? base_url('assets/images/site/'. $setting['admin-side-logo'] ) : base_url('assets/admin/img/logo.png'); ?>
        <img src="<?= $logo ?>" class="img-fluid img-logo" alt="Logo">
        <form method="post">
            <?php if(!empty($this->session->flashdata('error'))){?>
                <div class="alert alert-danger">
                    <?php echo $this->session->flashdata('error'); ?>
                </div>
            <?php } ?>
            <?php if(!empty($this->session->flashdata('success'))){?>
                <div class="alert alert-success">
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
            <?php } ?>
            <div class="form-group">
                <input type="password" name="password" class="" placeholder="New Password" required>
                <span></span>
                <img src="<?= base_url('assets/admin/'); ?>img/password.png" alt="icon">
            </div>
            <div class="form-group">
                <input type="password" name="conf_password" class="" placeholder="Confirm New Password" required>
                <span></span>
                <img src="<?= base_url('assets/admin/'); ?>img/password.png" alt="icon">
            </div>
            
            <div class="form-group">
                <input type="submit" class="btn btn-loginsbt" value="Change Password">
            </div>
            <a href="<?= $redirect_url; ?>" class="forgotpass"><?= __('user.cancel') ?></a>
        </form>
        </div>
    </div>
    </div> 
  
  
<script src="<?= base_url('assets/admin/'); ?>js/jquery.min.js"></script>
<script src="<?= base_url('assets/admin/'); ?>js/bootstrap.min.js" ></script>
</body>
</html>