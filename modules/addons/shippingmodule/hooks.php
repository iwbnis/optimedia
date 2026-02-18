<?php

use WHMCS\Database\Capsule;
require_once('view.php');
$view = new ViewSM();


  $CheckoutType = $view->getCheckoutType();

  if($CheckoutType == 2)
  {
    $hookname = 'ShoppingCartCheckoutOutput';
  }
  else
  {
    $hookname = 'ShoppingCartViewCartOutput';
  }




add_hook($hookname , 1, function($vars) {
// add_hook('ShoppingCartViewCartOutput', 1, function($vars) {
    // Perform hook code here...

$view = new ViewSM();

    $ShippingType = $view->getShippingType();

    if(isset($vars["cart"]["products"]))
    {
        $cartC = $vars['cart']['products'];
        
    }
    
    if(isset($vars["cart"]["user"]["country"]))
    {
        $userC = $vars['cart']['user']['country'];
        
    }

    
    if($cartC)
    {
        $show_shipping = $view->IsShippingProduct($cartC);
    }

    $script   = $_SERVER['SCRIPT_NAME'];
    $params   = $_SERVER['QUERY_STRING'];

    if(isset($_GET['manual_reset']))
    {
      $view->resetCart();

      $list = explode('&amp;' , $params);

      if (($key = array_search('manual_reset=1', $list)) !== false) {
          unset($list[$key]);
      }
      $list = implode('&amp;' , $list);

      header("Location: $script?$list");
      exit;

    }

    if(!empty($_SESSION['shipping_country']))
    {

      $ship_html = $view->ShowShippingCharges($_SESSION['shipping_country_name'] , $_SESSION['zipcode'] , $_SESSION['address'] , $cartC);

    }
    else {

      if(isset($_POST)  && !empty($_POST['address']))
      {

          if($ShippingType == 3 && !empty($_POST['zipship']) && !empty($_POST['country']) ){

          $ship_html = $view->ShowShippingCharges($_POST['country'] , $_POST['zipship'] , $_POST['address'] , $cartC);

          }

          if(($ShippingType == 2 || $ShippingType == 4) &&  !empty($_POST['zipship']) ){

          $ship_html = $view->ShowShippingCharges( $userC , $_POST['zipship'] , $_POST['address'] , $cartC);

          }

          if($ShippingType == 1 ){


          $ship_html = $view->ShowShippingCharges( $userC , "00000" , $_POST['address'] , $cartC);

          }


      }
      else
      {
          if($show_shipping == 1)
          {
            $string = file_get_contents("resources/country/dist.countries.json");
            $countriez = json_decode($string, true);

            foreach (Capsule::table('mod_shippingmodule_country')->where("status", "=", 1)->get() as $country) {
            $countries .= '<option  value="'.$country->country.'">'.$countriez[$country->country]['name'].'</option>';
            }

            $ship_html = $view->getShippingAddForm($countries , $userC, $ShippingType);
          }
      }

    }
return <<<HTML
    <br />
    <div id="error_SMXP"></div>
    <br>
    {$ship_html}
HTML;
});




add_hook('CartTotalAdjustment', 1, function($vars) {

$view = new ViewSM();

  $cart_adjustments = array();
  $desc .= "Shipping Charges to ".$_SESSION['address'];

  if(!empty($_SESSION['shipping_country']))
  {
    $string = file_get_contents("resources/country/dist.countries.json");
    $countriez = json_decode($string, true);

    $country = Capsule::table('mod_shippingmodule_country')
              ->where("id", "=", $_SESSION['shipping_country'])
              ->value('country');

    $desc .= ', '.$countriez[$country]['name'];
  }

  if(!empty($_SESSION['zipcode']))
  {
    $desc .= ' - '.$_SESSION['zipcode'];
  }
  if(!empty($_SESSION['shipping_country']))
  {
      $cart_adjustments = [
          "description" => $desc,
          "amount" => $_SESSION['all_shipping'],
          "taxed" => false,
      ];
  }

          return $cart_adjustments;
});


add_hook('AfterShoppingCartCheckout', 1, function($vars) {

    $view = new ViewSM();

  $shipping_country = $_SESSION['shipping_country'];
  $zipcode = $_SESSION['zipcode'];
  $address = $_SESSION['address'];
  $order_id = $vars['OrderID'];
  $service_ids = serialize($vars['ServiceIDs']);
  //unserialize()

  if(!empty($_SESSION['address']))
  {

      if(empty($shipping_country))
      {

        $command = 'GetClientsDetails';
        $postData = array(
        'clientid' => $_SESSION['uid'],
        'stats' => false,
        );
        $results = localAPI($command, $postData);
        $shipping_country = $results['client']['country'];
      }

      if(empty($zipcode))
      {
        $command = 'GetClientsDetails';
        $postData = array(
        'clientid' => $_SESSION['uid'],
        'stats' => false,
        );
        $results = localAPI($command, $postData);
        $shipping_country = $results['client']['postcode'];
      }

        try {
          //key value pair.
          $insert_array = [
            'orderid' => $order_id,
            'service_id' => $service_ids,
            'shipping_addr' => $address,
            'zip_code' => $zipcode,
            'country' => $shipping_country,
            'shipping_company' => 'N/A',
            'shipping_url' => 'N/A',
            'shipping_status' => 'Order in Process',
            'tracking_number' => 'N/A',
          ];
          Capsule::table('mod_shippingmodule')
              ->insert($insert_array);

                $view->resetCart();

      } catch(\Illuminate\Database\QueryException $ex){
          echo $ex->getMessage();

      } catch (Exception $e) {
          echo $e->getMessage();
      }
  }

});



add_hook('ClientAreaProductDetailsOutput', 1, function($service) {

    if (!is_null($service)) {
        $orderID = $service['service']->orderId;
        $order = Capsule::table('mod_shippingmodule')->where("orderid", "=", $orderID)->get();
        $result = count($order);

        if($result > 0)
        {
          $country = Capsule::table('mod_shippingmodule_country')->where("id", "=", $order[0]->country)->value('country');
          // print_r($order);
          return '<div class="tab-content product-details-tab-container" style="border:1px solid #CCC; background:#FFF; border-radius:3px;"><h4><b>Tracking Info</b> <a style="float:right;" class="btn btn-info btn-sm" target="_blank" href="'.$order[0]->shipping_url.'">Track Order</a></h4><table class="table"><tr><td>Shipping Address:</td><td>'.$order[0]->shipping_addr.', '.$country.' - '.$order[0]->zip_code.'</td></tr><tr><td>Shipping Company:</td><td>'.$order[0]->shipping_company.'</td></tr><tr><td>Shipping Status:</td><td>'.$order[0]->shipping_status.'</td></tr><tr><td>Tracking Number:</td><td>'.$order[0]->tracking_number.'</td></tr><tr><td></td><td></td></tr></table></div><br /><br /> ';
        }
    }
    return '';
});



add_hook('CancelOrder', 1, function($vars) {

    $order_id = $vars['orderid'];
    $order = Capsule::table('mod_shippingmodule')->where("orderid", "=", $order_id)->get();
    $result = count($order);

    if($result > 0){

      try {
          $updatedUserCount = Capsule::table('mod_shippingmodule')
              ->where('orderid', $order_id)
              ->update(
                  [
                      'shipping_status' => "Order Canceled",
                  ]
              );

          // return "Updated {$updatedUserCount} Order tracking info";
      } catch (\Exception $e) {
        return "I couldn't update order tracking info: {$e->getMessage()}";
        }
    }
});



add_hook('DeleteOrder', 1, function($vars) {

  $order_id = $vars['orderid'];
  $order = Capsule::table('mod_shippingmodule')->where("orderid", "=", $order_id)->get();
  $result = count($order);

  if($result > 0){

    try {
    Capsule::table('mod_shippingmodule')
            ->where('orderid', '=', $order_id)
            ->delete();
    } catch (Exception $e) {
        echo $e->getMessage();
    }
  }
});


add_hook('AfterCalculateCartTotals', 1, function($vars) {
  $_SESSION['SM_CART_RAWTOTAL'] = $vars['rawtotal'];
});


function hook_template_variables_shippingmodule($vars)
{

    $view = new ViewSM();
    $extraTemplateVariables = array();

    $pros = Capsule::table('tblproducts')->get();
    $path = '../modules/addons/shippingmodule/product_images/';
    $modpath = '../modules/addons/shippingmodule/';
    $tmppath = '../modules/addons/shippingmodule/tmp/';

    foreach($pros as $pro)
    {
        $image = Capsule::table('mod_shippingmodule_products')->where("product", "=", $pro->id)->value('photo');

            $extraTemplateVariables['defaultimgtest'] = $image;

        if(empty($image))
        {
            $defaultimg = "enable";
            $extraTemplateVariables['defaultimg'.$pro->id] = $defaultimg;

        }
        else
        {
             $default = NULL;
        }

        $images = explode(',' , $image);
        $all_media = $view->getFileTypes($images);
        $extraTemplateVariables['image'.$pro->id] = $all_media;
        $extraTemplateVariables['path'] = $path;
        $extraTemplateVariables['temppath'] = $tmppath;
        $extraTemplateVariables['modpath'] = $modpath;

    }

    // return array of template variables to define
    return $extraTemplateVariables;
}

add_hook('ClientAreaPage', 1, 'hook_template_variables_shippingmodule');

add_hook('ClientAreaFooterOutput', 1, function($vars) {
    $language = $vars['language'];
    $sslPage = $vars['servedOverSsl'];
    $html = '<div class="fixeddiv">
    <div class="lightbox">
            <a class="close" onclick="closebox();">X</a>
                <img width="500" src="">
        </div>
    </div>
    <style>
        .fixeddiv{
          position:fixed;
          width:100%;
          height:100%;
          top:0;
          left:0px;
          display:none;
          background:#000;
          z-index:2;
        }

        .close{
      font-size:24px;
      color:#FFF;
      font-weight:bold;
      float:right;
      margin-right:15px;
      margin-top:15px;
      padding:10px;
      text-decoration:none;
      cursor: pointer;
    }
    .close:hover{
      color:#FFF;
      text-decoration:none;
    }
            .lightbox{
                width: 100%;
                height: 100%;
                margin: 0px;
                border: 1px solid black;
                position: absolute;
                top:0;
                left:0;
                background:#000;
                opacity:1 !important;
            }
            .lightbox img{
              opacity:1 !important;
                max-height: 100%;
                max-width: 100%;
                position: absolute;
                top: 0;
                bottom: 0;
                left: 0;
                right: 0;
                margin: auto;
            }
    </style>

    <script>
        function LightBox_SM(image)
        {
          $(".lightbox img").attr("src" , image);
          $( ".fixeddiv" ).fadeIn( "slow", function() {
            // Animation complete
          });
        }

        function closebox(){
          $( ".fixeddiv" ).fadeOut( "slow", function() {
            // Animation complete
          });

        }
    </script>';

    return $html;
});


add_hook('DailyCronJob', 1, function($vars) {

	ini_set('memory_limit','512M');
	ini_set('max_execution_time', 0 );


  $view->runCron();




});


use WHMCS\View\Menu\Item;

add_hook('ClientAreaHomepagePanels', 1, function (Item $homePagePanels)
{

    $i=1;
     foreach(Capsule::table('mod_shippingmodule')
     ->select('orderid','shipping_status', 'shipping_company','shipping_url','tracking_number')
     ->join('tblorders', 'tblorders.id', '=', 'mod_shippingmodule.orderid')
     ->where('tblorders.userid' , '=' ,$_SESSION['uid'] )
     ->get() as $smorders)
     {
             $slides  .= '<div class="mySlides">
    <span>Your Order # '.$smorders->orderid.'<br>Tracking # '.$smorders->tracking_number.'<br>Shipping Company: '.$smorders->shipping_company.'<br>Shipping Status: '.$smorders->shipping_status.'</span>
    <br><br>
    <a style="display:none;" class="smcustom_track_href" class="btn btn-info btn-sm" href="'.$smorders->shipping_url.'">'.$smorders->orderid.'</a>
  </div>';

         $i++;
      }

    if($smorders)
    {
        $result = count($smorders);
        
    }
    
    if($result > 0)
    {


        $html = <<<EOT
  <!-- Slideshow container -->
<div class="slideshow-container">

  <!-- Full-width slides/quotes -->
$slides

  <!-- Next/prev buttons -->
  <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
  <a class="next" onclick="plusSlides(1)">&#10095;</a>
</div>


    <style>
/* Slideshow container */
.slideshow-container {
  position: relative;

}

/* Slides */
.mySlides {
  display: none;
  padding: 10px 0px;
  text-align: center;
}

/* Next & previous buttons */
.prev, .next {
  cursor: pointer;
  position: absolute;
  top: 50%;
  width: auto;
  margin-top: -30px;
  padding: 5px;
  color: #888;
  font-weight: bold;
  font-size: 20px;
  border-radius: 0 3px 3px 0;
  user-select: none;
}

/* Position the "next button" to the right */
.next {
  position: absolute;
  right: 0;
  border-radius: 3px 0 0 3px;
}

/* On hover, add a black background color with a little bit see-through */
.prev:hover, .next:hover {
  background-color: #28a745;
  color: white;
  text-decoration:none;
}

/* The dot/bullet/indicator container */
.dot-container {
  text-align: center;
  padding: 20px;
  background: #ddd;
}

/* The dots/bullets/indicators */
.dot {
  cursor: pointer;
  height: 15px;
  width: 15px;
  margin: 0 2px;
  background-color: #bbb;
  border-radius: 50%;
  display: inline-block;
  transition: background-color 0.6s ease;
}

/* Add a background color to the active dot/circle */
.active, .dot:hover {
  background-color: #717171;
}

/* Add an italic font style to all quotes */
q {font-style: italic;}

/* Add a blue color to the author */
.author {color: cornflowerblue;}    </style>
  <script>
  var slideIndex = 1;
showSlides(slideIndex);
setInterval(function(){ plusSlides(slideIndex) }, 6000);

function plusSlides(n) {
  showSlides(slideIndex += n);
}

function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  var i;
  var slides = $(".mySlides");
  if (n > slides.length) {slideIndex = 1}
    if (n < 1) {slideIndex = slides.length}
    for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";
    }

  slides[slideIndex-1].style.display = "block";



   updatetrackorderbtn();


}

function updatetrackorderbtn(){




var link = $('.mySlides[style="display: block;"] .smcustom_track_href').attr('href');

var textlink = $('.mySlides[style="display: block;"] .smcustom_track_href').text();
//alert(link);

$('.card-title .customtracksm').attr('href', link);
$('.panel-title .customtracksm').attr('href', link);

$('.card-title .customtracksm').attr('target', "_new");
$('.panel-title .customtracksm').attr('target', "_new");

$('.card-title .customtracksm').html('<i class="fas fa-arrow-right"></i> Track Order # ' + textlink);

$('.panel-title .customtracksm').html('<i class="fas fa-arrow-right"></i> Track Order # ' + textlink);


}


  </script>
EOT;

    $homePagePanels->addChild('trackorder', array(
        'label' => 'Track Orders',
        'icon' => 'fa-shipping-fast',
        'order' => 10,
        'extras' => array(
            'color' => 'green customtracksm',
            'btn-link' => '#',
            'btn-text' => 'Track Order',
            'btn-icon' => 'fa-arrow-right',
        ),
        'bodyHtml' => $html,
        'footerHtml' => 'Tip: Click Track Order and Enter Tracking Number',
    ));

    }
});
