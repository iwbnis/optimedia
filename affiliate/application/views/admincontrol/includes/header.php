<!doctype html>
<?php
  $db =& get_instance();

  $userdetails=$db->Product_model->userdetails(); 
  $SiteSetting =$db->Product_model->getSiteSetting();
  $db->Product_model->ping($userdetails['id']);
?>
<html lang="en">
  <head>
    <meta charset="utf-8">
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <title><?= $SiteSetting['name'] ?> - <?= __('admin.menu_admin_panel') ?></title>
   
    <meta content="<?= $SiteSetting['meta_description'] ?>" name="description" />
    
    <meta content="<?= $SiteSetting['meta_author'] ?>" name="author" />
    
    <meta content="<?= $SiteSetting['meta_keywords'] ?>" name="keywords" />
    
    <link href="<?= base_url('assets/vertical/assets/plugins/magnific-popup/magnific-popup.css?v='.av()); ?>" rel="stylesheet" type="text/css">

    <link href="<?= base_url('assets/js/jquery-confirm.min.css?v='.av()); ?>" rel="stylesheet">

    <link href="<?= base_url('assets/vertical/assets/plugins/morris/morris.css?v='.av()); ?>" rel="stylesheet">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" crossorigin="anonymous">

    <link href="<?= base_url('assets/css/jquery-ui.css?v='.av()); ?>" rel="stylesheet" type="text/css">

    <link href="<?= base_url('assets/vertical/assets/plugins/chartist/css/chartist.min.css?v='.av()); ?>" rel="stylesheet" type="text/css">

    <link href="<?= base_url('assets/vertical/assets/css/bootstrap.min.css?v='.av()); ?>" rel="stylesheet" type="text/css">

    <link href="<?= base_url('assets/vertical/assets/css/icons.css?v='.av()); ?>" rel="stylesheet" type="text/css">

    <link href="<?= base_url('assets/vertical/assets/css/style.css?v='.av()); ?> ?>" rel="stylesheet" type="text/css">

    <link href="<?= base_url('assets/template/css/admin.style.css?v='.av()); ?>" rel="stylesheet">

    <link href="<?= base_url('assets/template/css/admin.responsive.css?v='.av()); ?>" rel="stylesheet">

    <link href="<?= base_url('assets/vertical/assets/plugins/RWD-Table-Patterns/dist/css/rwd-table.min.css?v='.av()); ?>" rel="stylesheet" type="text/css" media="screen">

    <?php if($SiteSetting['favicon']){ ?>
        <link rel="icon" href="<?= base_url('assets/images/site/'.$SiteSetting['favicon']) ?>" type="image/*" sizes="16x16">
    <?php } ?>

    <link href="<?= base_url('assets/css/jquery.uploadPreviewer.css?v='.av()); ?>" rel="stylesheet" type="text/css" media="screen">

    <?php if($SiteSetting['google_analytics'] != '') echo $SiteSetting['google_analytics']; ?>

    <script src="<?= base_url('assets/js/jquery.min.js'); ?>"></script>
    <script type="text/javascript">
      window.affiliatePro ={
        base_url:"<?= base_url() ?>"
      }
    </script>

    <link href="<?= base_url('assets/plugins/datetimepicker/jquery.datetimepicker.min.css') ?>?v=<?= av() ?>" rel="stylesheet" />

    <script src="<?= base_url('assets/plugins/datetimepicker/jquery.datetimepicker.full.min.js') ?>"></script>

    <link href="<?= base_url('assets/plugins/datatable') ?>/select2.css?v=<?= av() ?>" rel="stylesheet" />

    <script src="<?= base_url('assets/plugins/datatable') ?>/select2.min.js"></script>

    <script src="<?= base_url('assets/js') ?>/jscolor.js"></script>

    <script type="text/javascript" src='<?= base_url('assets/sweetalert/sweetalert.min.js') ?>'></script>

    <script type="text/javascript" src='<?= base_url('assets/plugins/color-picker/spectrum.js') ?>'></script>

    <link rel='stylesheet' href='<?= base_url('assets/plugins/color-picker/spectrum.css?v='.av()) ?>' />

    <link rel='stylesheet' href='<?= base_url('assets/css/admin-common.css') ?>?v=<?= av() ?>' />

    <script type="text/javascript">
        (function ($) {
            $.fn.btn = function (action) {
                var self = $(this);
                var tagName = self.prop("tagName");

                if(tagName == 'A'){
                    if(action == 'loading'){
                        $(self).addClass("disabled");
                        $(self).attr('data-text',$(self).text());
                        $(self).text('<?= ('admin.loading') ?>'+"..");
                    }

                    if(action == 'reset') $(self).text($(self).attr('data-text')); $(self).removeClass("disabled");

                } else {
                    if(action == 'loading') $(self).addClass("btn-loading");

                    if(action == 'reset')  $(self).removeClass("btn-loading");
                }
            }
        })(jQuery);

        $(document).delegate('a.disabled',"click",function (e){
            e.preventDefault();
        });

        var formDataFilter = function(formData){
            if(!(window.FormData && formData instanceof window.FormData)) return formData

            if(!formData.keys) return formData

            var newFormData = new window.FormData()

            Array.from(formData.entries()).forEach(function(entry){
                var value = entry[1]
                if(value instanceof window.File && value.name === '' && value.size === 0)
                    newFormData.append(entry[0], new window.Blob([]), '')
                else
                    newFormData.append(entry[0], value)

            })

            return newFormData
        }

        function apply_color(ele){
            $(ele).spectrum({
                preferredFormat: "rgb",
                showInput: true,
                className: "full-spectrum",
                showInitial: true,
                showPalette: true,
                showSelectionPalette: true,
                maxSelectionSize: 10,
                localStorageKey: "bolly_fashion",
                allowEmpty:true,
                palette: [
                          ["transparent"],

                          ["rgb(255, 255, 255)","rgb(230, 184, 175)", "rgb(244, 204, 204)", "rgb(252, 229, 205)", "rgb(255, 242, 204)", "rgb(217, 234, 211)", 

                          "rgb(208, 224, 227)", "rgb(201, 218, 248)", "rgb(207, 226, 243)", "rgb(217, 210, 233)", "rgb(234, 209, 220)", 

                          "rgb(221, 126, 107)", "rgb(234, 153, 153)", "rgb(249, 203, 156)", "rgb(255, 229, 153)", "rgb(182, 215, 168)", 

                          "rgb(162, 196, 201)", "rgb(164, 194, 244)", "rgb(159, 197, 232)", "rgb(180, 167, 214)", "rgb(213, 166, 189)", 

                          "rgb(204, 65, 37)", "rgb(224, 102, 102)", "rgb(246, 178, 107)", "rgb(255, 217, 102)", "rgb(147, 196, 125)", 

                          "rgb(118, 165, 175)", "rgb(109, 158, 235)", "rgb(111, 168, 220)", "rgb(142, 124, 195)", "rgb(194, 123, 160)",

                          "rgb(166, 28, 0)", "rgb(204, 0, 0)", "rgb(230, 145, 56)", "rgb(241, 194, 50)", "rgb(106, 168, 79)",

                          "rgb(69, 129, 142)", "rgb(60, 120, 216)", "rgb(61, 133, 198)", "rgb(103, 78, 167)", "rgb(166, 77, 121)",

                          "rgb(91, 15, 0)", "rgb(102, 0, 0)", "rgb(120, 63, 4)", "rgb(127, 96, 0)", "rgb(39, 78, 19)", 

                          "rgb(12, 52, 61)", "rgb(28, 69, 135)", "rgb(7, 55, 99)", "rgb(32, 18, 77)", "rgb(76, 17, 48)"]
                ]
            });
        }
    </script>

    <?php if(is_rtl()){ ?>
      <!-- place here your RTL css code -->
    <?php } ?>
  </head>
<body>
  <?php 
    $fbmessager_status = (array)json_decode($SiteSetting['fbmessager_status'],1);
    if(in_array('admin', $fbmessager_status))
      echo $SiteSetting['fbmessager_script'];
  ?>
<div class="main">
  <div class="overly"></div>