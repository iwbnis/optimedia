<?php if(!file_exists(FCPATH."/install/version.php") || !defined('SCRIPT_VERSION') || !defined('CODECANYON_LICENCE') || SCRIPT_VERSION == "" || CODECANYON_LICENCE == "") { ?>

  <script type="text/javascript">
    $("#model-adminpassword").remove();
    $.ajax({
      url:'<?= base_url("installversion/confirm_password") ?>',
      type:'POST',
      dataType:'json',
      data:{for:"license"},
      success:function(json){
        if(json['html']){
          $("body").append(json['html']);
          $("#model-adminpassword").modal("show");
          $('#model-adminpassword').on('hidden.bs.modal', function (){
            $("#model-adminpassword").modal("show");
          });
        }
      }
    });

  </script>
<?php } ?>

<script type="text/javascript">
  function resetNotify(){
    $.ajax({
      url:'<?= base_url('admincontrol/resetnotify') ?>',
      type:'POST',
      dataType:'json',
      beforeSend:function(){},
      success:function(response){
        if(response.status == 1)
          $(".ajax-notifications_count").text(0);
      },
    })
  }
</script>

<?php

  $db =& get_instance(); 
  $products = $db->Product_model; 
  $userdetails=$db->Product_model->userdetails(); 
  $SiteSetting =$db->Product_model->getSiteSetting(); 
  $license = $products->getLicese();
  if(isset($license['is_lifetime']) && $license['is_lifetime'] == false){ ?>
    
    <div class="license-expire">
      <span><?= __('admin.your_license_expire_in') ?> <span class="timer"><?= $license['remianing_time'] ?></span> </span>
    </div>

    <script type="text/javascript">
      var distance = <?= (float)$license['remianing_time'] ?>;
      var x = setInterval(function() {
      var days = Math.floor(distance / (60 * 60 * 24));
      var hours = Math.floor((distance % (60 * 60 * 24)) / (60 * 60));
      var minutes = Math.floor((distance % (60 * 60)) / (60));
      var seconds = Math.floor((distance % (60)));

      var timer = '';
      if(days > 0) timer += days + "d ";
      if(hours > 0) timer += hours + "h ";

      $(".license-expire .timer").html(timer +  minutes + "m " + seconds + "s ");
      distance--;
      if(distance < 0){
        clearInterval(x);
        $(".license-expire .timer").html('<?= __('admin.expired') ?>');
        window.location.reload();
      }
    }, 1000);
  </script>

<?php } ?>

  </div>

<?php 
  
  $global_script_status = (array)json_decode($SiteSetting['global_script_status'],1);
  if(in_array('admin', $global_script_status))
    echo $SiteSetting['global_script'];


  require APPPATH . 'views/common/setting_widzard.php';
?>

  </div>
  <div class="dashboard-footer">
    <div class="d-flex align-items-center justify-content-between flex-wrap">
      <div class="footer-rights">
        <?php $logo = $SiteSetting['admin-side-logo'] ? base_url('assets/images/site/'. $SiteSetting['admin-side-logo'] ) : base_url('assets/template/images/footer-logo.png'); ?>
        <img src="<?= $logo ?>" alt="<?= __('admin.logo') ?>">
        <p><?= $SiteSetting['footer'] ?></p>
      </div>
      <a href="<?= base_url('admincontrol/script_details') ?>">
        <div class="text-right script-right"> 
          <img src="<?= base_url('assets/template/images/script-icon.png') ?>" alt=""> 
          <span><?= __('admin.script_version') ?></span>
          <span><?php echo SCRIPT_VERSION ?></span>
        </div>
     </a>
    </div>
  </div>
</div>

<div class="modal" id="payment-detail_modal">

  <div class="modal-dialog modal-lg">

    <div class="modal-content">

      <div class="modal-header">

        <h4 class="modal-title mt-0"><?= __('admin.footer_user_payment_details') ?></h4>

        <button type="button" class="close" data-dismiss="modal">&times;</button>

      </div>

      <div class="modal-body">

        <h4 class="modal-title mt-0"><?= __('admin.footer_bank_details') ?></h4>

          <div class="table-rep-plugin">

            <div class="table-responsive b-0" data-pattern="priority-columns">

              <table id="tech-companies-1" class="table  table-striped">

                <thead>

                  <tr>

                    <th class="txt-cntr"><?= __('admin.footer_bank_name') ?></th>

                    <th class="txt-cntr"><?= __('admin.footer_account_number') ?></th>

                    <th class="txt-cntr"><?= __('admin.footer_account_name') ?></th>

                    <th class="txt-cntr"><?= __('admin.footer_ifsc_code') ?></th>

                  </tr>

                </thead>

                <tbody class="bank-details"> </tbody>

              </table>

            </div>

          </div>

          <h4 class="modal-title mt-0"><?= __('admin.footer_paypal_emails') ?></h4>

          <div class="table-rep-plugin">

            <div class="table-responsive b-0" data-pattern="priority-columns">

              <table id="tech-companies-1" class="table  table-striped">

                <thead>

                  <tr>
                      <th class="txt-cntr"></th>

                      <th class="txt-cntr"><?= __('admin.footer_email') ?></th>

                  </tr>

                </thead>

              <tbody class="paypal-details"> </tbody>

            </table>

          </div>

        </div>


        <h4 class="modal-title mt-0"><?= __('admin.footer_user_details') ?></h4>

        <div class="table-rep-plugin">
          
          <div class="table-responsive b-0" data-pattern="priority-columns">

            <table id="tech-companies-1" class="table  table-striped">

              <tbody class="user-details"></tbody>

            </table>

          </div>

      </div>

      <div class="modal-footer">

        <button type="button" class="btn btn-danger" data-dismiss="modal"><?= __('admin.footer_close') ?></button>

      </div>

    </div>

  </div>

</div>

</div>

<?php if(true || count($status) > 0){ ?>
  <script type="text/javascript">

    $(document).delegate(".only-number-allow","keypress",function (e) {
      if (e.which != 46 && e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57))
          return false;
    });

    $(document).on('ready',function(){
      if(getCookie('hide_welcome') != 'true')
        $("#welcome-modal").modal("show");
    })

    function setCookie(cname, cvalue, exdays){
      var d = new Date();
      d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));

      var expires = "expires="+d.toUTCString();
      document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    }

    function readURLAndSetValue(input,name,placeholder){

      if(input.files && input.files[0]){
        var reader = new FileReader();

        reader.onload = function(e){
          $("input[name='"+name+"']").val('image.jpg');
          $(placeholder).attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
      }
    }

    function readURL(input,placeholder){

      if(input.files && input.files[0]){
        var reader = new FileReader();

        reader.onload = function(e){
          $(placeholder).attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
      }
    }

    function getCookie(cname){

      var name = cname + "=";
      var ca = document.cookie.split(';');

      for(var i = 0; i < ca.length; i++){
        var c = ca[i];

        while (c.charAt(0) == ' '){
          c = c.substring(1);
        }

        if(c.indexOf(name) == 0)
          return c.substring(name.length, c.length);
      }

      return "";
    }

    $('.hide-welcome').on('click',function(){

      setCookie("hide_welcome","true", 365)

      $("#welcome-modal").modal("hide");

    })

  </script>  

<?php } ?>

<div class="modal" id="model-shorturl"></div>

<script type="text/javascript">

  $(".btn-delete").on('click',function(){
    return confirm('<?= __('admin.are_you_sure') ?>');
  })

  $(document).delegate("[payment_detail]",'click',function(e){

    e.preventDefault();

    e.stopPropagation();

    $this = $(this);

    var user_id = $this.attr("payment_detail");

    $.ajax({

      url:'<?= base_url("admincontrol/getpaymentdetail") ?>/' + user_id,

      type:'POST',

      dataType:'json',

      beforeSend:function(){ $this.btn("loading"); },

      complete:function(){ $this.btn("reset"); },

      success:function(json){

        $('#payment-detail_modal').modal("show");

        var html = '';

        $.each(json['paymentlist'], function(i,j){

          html += '<tr>';

          html += '<th>'+ j['payment_bank_name'] +'</th>';

          html += '<th>'+ j['payment_account_number'] +'</th>';

          html += '<th>'+ j['payment_account_name'] +'</th>';

          html += '<th>'+ j['payment_ifsc_code'] +'</th>';

          html += '</tr>';

        })  

        $('#payment-detail_modal .bank-details').html(html);

        var html = '';

        $.each(json['paypalaccounts'], function(i,j){

          html += '<tr>';

          html += '<th>'+ (i+1) +'</th>';

          html += '<th>'+ j['paypal_email'] +'</th>';

          html += '</tr>';

        })  

        $('#payment-detail_modal .paypal-details').html(html);

        var html = '';

        html += '<tr>';

        html += '<th><?= __('admin.footer_firstname') ?></th>';

        html += '<td>'+ json.user.firstname +'</td>';

        html += '</tr>';

        html += '<tr>';

        html += '<th><?= __('admin.footer_lastname') ?></th>';

        html += '<td>'+ json.user.lastname +'</td>';

        html += '</tr>';

        html += '<tr>';

        html += '<th><?= __('admin.footer_username') ?></th>';

        html += '<td>'+ json.user.username +'</td>';

        html += '</tr>';

        html += '<tr>';

        html += '<th><?= __('admin.footer_email') ?></th>';

        html += '<td>'+ json.user.email +'</td>';

        html += '</tr>';

        html += '<tr>';

        html += '<th><?= __('admin.footer_phone') ?></th>';

        html += '<td>'+ json.user.phone +'</td>';

        html += '</tr>';

        html += '<tr>';

        html += '<th><?= __('admin.footer_address') ?></th>';

        html += '<td>'+ json.user.address +'</td>';

        html += '</tr>';

        html += '<tr>';

        html += '<th><?= __('admin.footer_state') ?></th>';

        html += '<td>'+ json.user.state +'</td>';

        html += '</tr>';

        html += '<tr>';

        html += '<th><?= __('admin.footer_country') ?></th>';

        html += '<td>'+ json.user.country +'</td>';

        html += '</tr>';

        $('#payment-detail_modal .user-details').html(html);
      },  
    })
  })

</script>

<script src="<?= base_url('assets/js/jquery-ui.js'); ?>"></script>

<script src="<?= base_url('assets/js/jquery-confirm.min.js'); ?>"></script>

<script src="<?= base_url('assets/js/popper.min.js'); ?>"></script>

<script src="<?= base_url('assets/js/bootstrap.min.js'); ?>"></script>

<script src="<?= base_url('assets/js/modernizr.min.js'); ?>"></script>

<script src="<?= base_url('assets/js/detect.js'); ?>"></script>

<script src="<?= base_url('assets/js/fastclick.js'); ?>"></script>

<script src="<?= base_url('assets/js/jquery.slimscroll.js'); ?>"></script>

<script src="<?= base_url('assets/js/jquery.blockUI.js'); ?>"></script>

<script src="<?= base_url('assets/js/waves.js'); ?>"></script>

<script src="<?= base_url('assets/js/jquery.nicescroll.js'); ?>"></script>

<script src="<?= base_url('assets/js/jquery.scrollTo.min.js'); ?>"></script>

<script src="<?= base_url('assets/vertical/assets/plugins/skycons/skycons.min.js'); ?>"></script>

<script src="<?= base_url('assets/vertical/assets/plugins/raphael/raphael-min.js'); ?>"></script>

<script src="<?= base_url('assets/vertical/assets/plugins/morris/morris.min.js'); ?>"></script>

<script src="<?= base_url('assets/vertical/assets/plugins/magnific-popup/jquery.magnific-popup.min.js'); ?>"></script>

<script src="<?= base_url('assets/js/lightbox.js'); ?>"></script>

<script src="<?= base_url('assets/js/jssocials-1.4.0/jssocials.min.js'); ?>"></script>

<link href="<?= base_url('assets/js/jssocials-1.4.0/jssocials.css'); ?>" type="text/css" rel="stylesheet" />

<link href="<?= base_url('assets/js/jssocials-1.4.0/jssocials-theme-flat.css'); ?>" type="text/css" rel="stylesheet" />

<script type="text/javascript">
  let leftHeight = $(".left-menu").height();
  let navbarHeight = $(".dashboard-navbar").height();
  let errorHeight = $(".server-errors").height();
  let footerHeight = $(".dashboard-footer").height();
  let elTotalheight = navbarHeight + errorHeight + footerHeight;
  let contentHeight = leftHeight - elTotalheight - 26;
  $(".content-wrapper").css('min-height',contentHeight);

  $(document).delegate(".copy-input input",'click', function(){
    $(this).select();
  })

  $(document).delegate('[copyToClipboard]',"click", function(){
    $this = $(this);

    var $temp = $("<input>");

    $("body").append($temp);

    $temp.val($(this).attr('copyToClipboard')).select();

    document.execCommand("copy");

    $temp.remove();

    $this.tooltip('hide').attr('data-original-title','<?= __('admin.copied') ?>').tooltip('show');

    setTimeout(function() { $this.tooltip('hide'); }, 500);
  });

  $('[copyToClipboard]').tooltip({
    trigger: 'click',
    placement: 'bottom'

  });

  (function ($) {
    $.fn.button = function (action){
      var self = $(this);
      if(action == 'loading'){
        if($(self).attr("disabled") == "disabled"){
            //e.preventDefault();
        }

        $(self).attr("disabled", "disabled");

        $(self).attr('data-btn-text', $(self).html());

        $(self).html('<i class="fa fa-spinner fa-spin"></i>' + $(self).text());
      }

      if(action == 'reset'){
        $(self).html($(self).attr('data-btn-text'));
        $(self).removeAttr("disabled");
      }
    }

  })(jQuery);

</script>

<script src="<?= base_url('assets/js/app.js'); ?>"></script>
 
<link href="<?= base_url('assets/js/summernote-0.8.12-dist/summernote-bs4.css'); ?>" rel="stylesheet">

<script src="<?= base_url('assets/js/summernote-0.8.12-dist/summernote-bs4.js'); ?>"></script>

<div class="modal fade" id="ip-flag_model">

  <div class="modal-dialog">

    <div class="modal-content">

      <div class="modal-header">

        <h4 class="modal-title"><?= __('admin.all_ips_details') ?></h4>

        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

      </div>

      <div class="modal-body"></div>

      <div class="modal-footer">

        <button type="button" class="btn btn-default" data-dismiss="modal"><?= __('admin.close') ?></button>

      </div>

    </div>

  </div>

</div>

<script>

  $(".select2-input").select2();

  $(document).delegate(".view-all",'click',function(){
    var data = $(this).find("span").html();
    var html = '<table class="table table-hover">';

    data = JSON.parse(data);

    html += '<tr>';

    html += ' <th>'+'<?= ('admin.ip') ?>'+'</th>';

    html += ' <th width="30px">'+'<?= ('admin.country') ?>'+'</th>';

    html += '</tr>';

    $.each(data, function(i,j){
      html += '<tr>';

      html += ' <td>'+ j['ip'] +'</td>';

      html += ' <td><img style="width: 20px;" src="<?= base_url('assets/vertical/assets/images/flags/') ?>'+ j['country_code'].toLowerCase() +'.png" ></td>';

      html += '</tr>';
    })

    html += '</table>';

    $("#ip-flag_model").modal("show");

    $("#ip-flag_model .modal-body").html(html);
  })

  $('[data-toggle="tooltip"]').tooltip();   

  if($('#morris-area-chart').length > 0){
    var areaData = [

      {y: '2011', a: 10, b: 15},

      {y: '2012', a: 30, b: 35},

      {y: '2013', a: 10, b: 25},

      {y: '2014', a: 55, b: 45},

      {y: '2015', a: 30, b: 20},

      {y: '2016', a: 40, b: 35},

      {y: '2017', a: 10, b: 25},

      {y: '2018', a: 25, b: 30}

    ];

    Morris.Area({

      element: 'morris-area-chart',

      pointSize: 3,

      lineWidth: 2,

      data: areaData,

      xkey: 'y',

      ykeys: ['a', 'b'],

      labels: ['Orders', 'Sales'],

      resize: true,

      hideHover: 'auto',

      gridLineColor: '#eef0f2',

      lineColors: ['#00c292', '#03a9f3'],

      lineWidth: 0,

      fillOpacity: 0.1,

      xLabelMargin: 10,

      yLabelMargin: 10,

      grid: false,

      axes: false,

      pointSize: 0

    });
  }

  $(document).on('ready',function(){

    if($('#morris-donut-chart').length > 0){
      var donutData = [
        <?php $str = '';
          $country_list = isset($country_list)?$country_list:[];
          foreach($country_list as $key => $one_item){ 
            $str .= '{label: "' . $one_item->name . '", value: ' . (int)$one_item->num . '},'; 
          }
          echo rtrim($str,", ");
        ?>
      ];

      Morris.Donut({

        element: 'morris-donut-chart',

        data: donutData,

        resize: true,

        colors: ['#40a4f1', '#5b6be8', '#c1c5e2', '#e785da', '#00bcd2']

      });

    }

    if($("#boxscroll").length > 0)
      $("#boxscroll").niceScroll({cursorborder:"",cursorcolor:"#cecece",boxzoom:true});

    if($("#boxscroll2").length > 0)
      $("#boxscroll2").niceScroll({cursorborder:"",cursorcolor:"#cecece",boxzoom:true}); 

  
    if($(".clickable-row").length > 0){
      $(".clickable-row").on('click',function(){
        window.location = $(this).data("href");
      });
    }

    if($("#Country").length > 0){
      $('#Country').on('change', function(){
        country_id = $(this).val();

        $.ajax({

          type: "POST",

          url: "<?= base_url();?>admincontrol/getstate",

          data:'country_id='+country_id,

          success: function(data){

            $("#StateProvince").html(data);

          }

        });

      });
    }

  });


  function shownofication(id,url){

    $.ajax({

      type: "POST",

      url: "<?= base_url('admincontrol/updatenotify');?>",

      data:'id='+id,

      dataType:'json',

      success: function(data){

        window.location.href=data['location'];

      }

    });

  }

  $(document).on('ready',function(){
    $('.summernote-img').each(function(){
        sumNote($(this));
    });

  });

  function sumNote(element){
    var height = $(element).attr("data-height") ? $(element).attr("data-height") : 500;

    $(element).summernote({

        disableDragAndDrop: true,

        height: height,


        toolbar: [

            ['style', ['style']],

            ['font', ['bold', 'underline', 'clear']],

            ['fontname', ['fontname']],

            ['color', ['color']],

            ['para', ['ul', 'ol', 'paragraph']],

            ['table', ['table']],

            ['insert', ['link', 'image', 'picture', 'video']],

            ['view', ['fullscreen', 'codeview', 'help']]

        ],

        buttons: {

            image: function() {

                var ui = $.summernote.ui;

                // create button

                var button = ui.button({

                    contents: '<i class="fa fa-image" />',

                    tooltip: false,

                    click: function () {

                        $('#modal-image').remove();

                    

                        $.ajax({

                            url: '<?= base_url("filemanager") ?>',

                            dataType: 'html',

                            beforeSend: function() {

                            },complete: function() {

                            },success: function(html) {

                                $('body').append('<div id="modal-image" class="modal fade">' + html + '</div>');

                                $('#modal-image').modal('show');

                                $('#modal-image').delegate('.image-box .thumbnail','click', function(e) {

                                    e.preventDefault();

                                    $(element).summernote('insertImage', $(this).attr('href'));

                                    $('#modal-image').modal('hide');

                                });

                            }

                        });                     

                    }

                });

            

                return button.render();

            }

        }

    });

  }

</script>
</body>
</html>