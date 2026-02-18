  <?php
  use WHMCS\Database\Capsule;


class ViewSM{


  public function Dashboard()
  {
    ?>
    <h2>Dashboard</h2>
    <h3>About Shipping Module</h3>
    <p>
      Shipping module allows you to add a shipping system to your WHMCS. It enables you to set different shipping charges to each country for differenct products. It also allows you to set shipping charges based on  Zip Codes. You can also set a Flat Shipping rate for all countries. It comes with 4 Shipping Charges types:
    </p>
    <ul>
      <li>
        Flat Shipping for All
      </li>
      <li>
        Flat Shipping for All + Zip Code Charges
      </li>
      <li>
        Country Flat Shipping + Zip Code Charges
      </li>
      <li>
        Zip Code Charges
      </li>
    </ul>
    <p>
      You can Enable Countries that you ship in, Set Zip Code Range(s), Set Countries' Flat Rates. You can also add Order tracking info along with Shipping Company Name, Tracking Number, Tracking URL and Shipping Status. Shipping Module works with all the currencies activated in your WHMCS and uses the conversion rates to convert the shipping charges from your default currency to user's currency. This module is supported with Multipage and Single page both Checkouts. You can also set Product photos and add a line of code to your products.tpl template to display product photos. It also support enlargement of photos in store.
    </p>
  <center>
  <a class="btn btn-info btn-md" href="addonmodules.php?module=shippingmodule&view=manageLicense">Manage Licenses</a>
  <a class="btn btn-success btn-md" href="addonmodules.php?module=shippingmodule&view=manageCountryShipping">Enable/Disable a Country</a>
    <a class="btn btn-info btn-md" href="addonmodules.php?module=shippingmodule&view=manageOrderTracking">Manage Order Tracking</a>
    <a class="btn btn-warning btn-md" href="addonmodules.php?module=shippingmodule&view=manageProducts">Manage Products</a>
    <a class="btn btn-danger btn-md" href="configaddonmods.php">Settings</a>

    <br />
    <br />
    <br />

  </center>
  <h5 align="center">Plugin by <a href="https://fayzanzahid.com" target="_blank">Fayzan Zahid (Fiz)</a></h5>

  <?php
  }

public function manageCountries($pid){

  $product_name = Capsule::table('tblproducts')->where("id", "=", $pid)->value('name');

  ?>
  <h2>Manage Shipping for <?php echo $product_name; ?> <span style="float:right;"> <a href="addonmodules.php?module=shippingmodule&view=massManageAddQuantityRate&pid=<?php echo $pid; ?>" class="btn btn-success btn-sm">Set Mass Additional Quantity Rate</a> <a href="addonmodules.php?module=shippingmodule&view=massFlatRate&pid=<?php echo $pid; ?>" class="btn btn-success btn-sm">Set Mass Flat Rate</a> <a href="addonmodules.php?module=shippingmodule&view=manageProduct&pid=<?php echo $pid; ?>" class="btn btn-info btn-sm">Back to Manage Product</a></span>
</h2>
<br />
    <table border class="display" id="managecountries_table">
      <thead>
        <tr>
          <th>
          Country
          </th>
          <th>
            Flat Rate
          </th>
          <th>
            Zip Code Ranges & Charges
          </th>
          <th>
            Additional Quantity Rate
          </th>

          <th>
            Action
          </th>
        </tr>
      </thead>
      <tbody>

        <?php
        $string = file_get_contents("../resources/country/dist.countries.json");
        $countries = json_decode($string, true);

            foreach (Capsule::table('mod_shippingmodule_country')->where("status", "=", 1)->get() as $country) {


              ?>
              <tr>
                <td>
                  <?php echo $countries[$country->country]['name'] . PHP_EOL;

                   ?>
                </td>
                <td>
                    <?php

                      $flatrate = Capsule::table('mod_shippingmodule_rates')->where("country", "=", $country->id)->where("product_id", "=", $_GET['pid'])->value('flat_rate');

                      $curr = Capsule::table('tblcurrencies')->where("default", "=", 1)->get();

                      if(!empty($flatrate))
                      {
                        $rate = $flatrate;
                      }
                      else {
                        $rate = 0;
                      }

                      echo $curr[0]->prefix.$rate.' '.$curr[0]->suffix;


                    ?>
                    <a class="btn btn-sm btn-warning" href="addonmodules.php?module=shippingmodule&view=manageFlatRates&country=<?php echo $country->id; ?>&pid=<?php echo $_GET['pid']; ?>">Manage</a>
                </td>
                <td>
                  <a class="btn btn-sm btn-warning" href="addonmodules.php?module=shippingmodule&view=manageZipRanges&country=<?php echo $country->id; ?>&pid=<?php echo $_GET['pid']; ?>">Manage</a>
                </td>
                <td>
                  <?php

                      $getRate = Capsule::table('mod_shippingmodule_additional_rates')
                                ->where("product_id", "=", $pid )
                                ->where("country", "=", $country->id)
                                ->first();
                      $getRate = (array) $getRate;
                      $Rtype = $getRate['rate_type'];
                      $Rvalue = $getRate['value'];

                      if($Rtype == 1){
                        echo $curr[0]->prefix.$Rvalue.' '.$curr[0]->suffix;
                      }
                      if($Rtype == 2){
                          echo $Rvalue.'%';
                      }

                      if(empty($Rvalue))
                      {
                        echo 'N/A';
                      }

                  ?>
                   <a class="btn btn-sm btn-warning" href="addonmodules.php?module=shippingmodule&view=manageAddQuantity&country=<?php echo $country->id; ?>&pid=<?php echo $_GET['pid']; ?>">Manage</a>
                </td>
                <td>
                  <!-- <a class="btn btn-sm btn-info" href="addonmodules.php?module=shippingmodule&view=editCountry&id=<?php //echo $country->id; ?>">Edit</a> -->
                    <a class="btn btn-sm btn-danger" onclick="return confirmDelete();" href="addonmodules.php?module=shippingmodule&view=deleteCountry&id=<?php echo $country->id; ?>&pid=<?php echo $_GET['pid']; ?>">Delete</a>
                </td>
              </tr>
              <?php
            }
         ?>
      </tbody>
    </table>

    <script>
    function confirmDelete() {
      return confirm("Are you sure to delete?");
    }
    </script>

    <style>
    td , th{
      text-align: center;
    }
    </style>



    <script type="text/javascript">
    $(document).ready(function() {
        $('#managecountries_table').DataTable({
          responsive: true
        });
    } );
    </script>

  <?php

}

public function manageAddQuantity(){

  $product_name = Capsule::table('tblproducts')->where("id", "=", $_GET['pid'])->value('name');

  $country_name = Capsule::table('mod_shippingmodule_country')->where("id", "=", $_GET['country'])->value('country');

  $string = file_get_contents("../resources/country/dist.countries.json");
  $countries = json_decode($string, true);

  $product_id = $_GET['pid'];
  $country = $_GET['country'];


  $getRate = Capsule::table('mod_shippingmodule_additional_rates')
              ->where("product_id", "=", $product_id)
              ->where("country", "=", $country)
              ->first();
  $getRate = (array) $getRate;
  if(isset($getRate['id']))
  {
    $rate_type = $getRate['rate_type'];
    $value = $getRate['value'];
  }


?>
<h2>Manage Additional Quantity Rate for <?php echo $countries[$country_name]['name']; ?> (<?php echo $product_name; ?>)
  <span style="float:right;">
    <a href="addonmodules.php?module=shippingmodule&view=manageCountries&pid=<?php echo $_GET['pid']; ?> " class="btn btn-warning btn-sm">All Countries</a>
    <a href="addonmodules.php?module=shippingmodule&view=manageProduct&pid=<?php echo $_GET['pid'];; ?>" class="btn btn-info btn-sm">Back to Manage Product</a>
</h2>

<form action="addonmodules.php?module=shippingmodule&view=updateAddQuantityRate&country=<?php echo $_GET['country']; ?>&pid=<?php echo $_GET['pid']; ?>" method="post">
<table class="table">
<tr>
  <td style="min-width:100px;">Rate Type</td>
  <td>
    <select class="form-control" name="rate_type">
    <?php
    foreach (Capsule::table('mod_shippingmodule_rates_types')->get() as $rate) {
        ?>
          <option <?php if($rate_type == $rate->id){ echo 'selected'; } ?> value="<?php echo $rate->id; ?>"><?php echo $rate->rate_type; ?></option>
        <?php
    }
     ?>
     </select>
     <em style="font-size:12px;">
       <b>Percentage Type:</b> Percentage is of total original shipping cost
     </em>
  </td>
</tr>

  <tr>
  <td>Rate Value</td>
  <td>
    <?php $curr = Capsule::table('tblcurrencies')->where("default", "=", 1)->get(); ?>

    <input style="display:inline-block; width:90%;" type="number" name="rate_value" class="form-control" value="<?php echo $value; ?>" />
    <br>
    <em style="font-size:12px;">
      Rate will be saved in your default currency (<?php echo $curr[0]->suffix; ?>) and will be automatically converted to other currencies at the time of checkout if you are using multiple currencies and your client chooses another currency for checkout.
    </em>
  </td>
  </tr>

  <tr>
  <td></td>
  <td>
    <input type="submit" class="btn btn-success" value="Update" />
  </td>
  </tr>


</table>


</form>



<?php
}

public function updateAddQuantityRate($country){

  $getRate = Capsule::table('mod_shippingmodule_additional_rates')
              ->where("product_id", "=", $_GET['pid'])
              ->where("country", "=", $country)
              ->first();

  $getRate = (array) $getRate;
  $product_id = $_GET['pid'];

  if(!isset($getRate['id'])){

    try {
      Capsule::table('mod_shippingmodule_additional_rates')->insert(
                  [
                      'country' => $country,
                      'product_id' => $product_id,
                      'rate_type' => $_POST['rate_type'],
                      'value' => $_POST['rate_value'],

                  ]
              );

  } catch (\Exception $e) {
    echo "unable to update {$e->getMessage()}";
  }



  }
  else
  {

      try {
          $updatedUserCount = Capsule::table('mod_shippingmodule_additional_rates')
              ->where('country', $country)
              ->where('product_id', $product_id)
              ->update(
                  [
                    'rate_type' => $_POST['rate_type'],
                    'value' => $_POST['rate_value'],
                  ]
              );

      } catch (\Exception $e) {
    echo "unable to update {$e->getMessage()}";

        }


  }

  header("Location: addonmodules.php?module=shippingmodule&view=manageCountries&pid=".$_GET['pid']);



}


public function manageCountryShipping(){

  ?>
  <h2>Manage Shipping Countries <span style="float:right;">

<a href="addonmodules.php?module=shippingmodule&view=massManageShippingCountries" class="btn btn-warning btn-sm">Mass Enable/Disable Shipping</a>

    <a href="addonmodules.php?module=shippingmodule&view=manageProducts" class="btn btn-info btn-sm">Manage Products</a></span>
</h2>
<br />
    <table border class="display" id="managecountries_table">
      <thead>
        <tr>
          <th>
          Country
          </th>
          <th>
            Shipping Status
          </th>
          <th>
            Action
          </th>
        </tr>
      </thead>
      <tbody>

        <?php
        $string = file_get_contents("../resources/country/dist.countries.json");
        $countries = json_decode($string, true);

            foreach (Capsule::table('mod_shippingmodule_country')->get() as $country) {


              ?>
              <tr>
                <td>
                  <?php echo $countries[$country->country]['name'] . PHP_EOL;

                   ?>
                </td>
                <td>

                  <?php if($country->status == 0 ){ echo 'Disabled'; } else { echo 'Enabled'; } ?>

                </td>
                <td>
                  <?php if($country->status == 0 ){
                    ?>

                    <a class="btn btn-sm btn-success" href="addonmodules.php?module=shippingmodule&view=enableCountry&id=<?php echo $country->id; ?>">Enable</a>

                  <?php } else {

                    ?>
                    <a class="btn btn-sm btn-danger" href="addonmodules.php?module=shippingmodule&view=disableCountry&id=<?php echo $country->id; ?>">Disable</a>
                  <?php } ?>

                </td>
              </tr>
              <?php
            }
         ?>
      </tbody>
    </table>

    <style>
    td , th{
      text-align: center;
    }
    </style>

    <script type="text/javascript">
    $(document).ready(function() {
        $('#managecountries_table').DataTable({
          responsive: true
        });
    } );
    </script>

  <?php





}

public function addCountry($pid){

?>
<h2>Add Country <span style="float:right;"> <a href="addonmodules.php?module=shippingmodule&view=manageCountries&pid=<?php echo $pid; ?>" class="btn btn-success btn-sm">All Countries</a> <a href="addonmodules.php?module=shippingmodule&view=manageProduct&pid=<?php echo $pid; ?>" class="btn btn-info btn-sm">Back to Manage Product</a></span></h2>
<form action="addonmodules.php?module=shippingmodule&view=saveCountry" method="post">
    <table class="table">
    <tr>
      <td>
        <select multiple style="height:350px;" class="form-control" id="selC" required name="country[]">
          <?php

          $string = file_get_contents("../resources/country/dist.countries.json");
          $countries = json_decode($string, true);

          foreach($countries as $key => $val)
          {


              $country = Capsule::table('mod_shippingmodule_country')
              ->where("product_id", "=", $pid)
              ->where("country", "=", $key)
              ->get();


              if(count($country) > 0)
              {
                continue;
              }
            ?>
              <option value="<?php echo $key; ?>"><?php echo $val['name']; ?></option>">

            <?php
          }
           ?>
        </select>

      </td>
    </tr>
    <tr>
      <td align="center">
        <input type="hidden" name="pid" value="<?php echo $_GET['pid']; ?>" />
        <button class="btn btn-success " type="submit">Add Countries</button>
      </td>
    </tr>
  </table>

</form>

<script>
$(function() {
    var data = ;
    $.each(data, function(i, option) {
        $('#selC').append($('<option/>').attr("value", option.id).text(option.name));
    });
})


</script>

<?php


}


public function saveCountry(){

    $countries = $_POST['country'];
    $pid = $_POST['pid'];

    foreach($countries as $country)
    {

      $country_check = Capsule::table('mod_shippingmodule_country')
      ->where("product_id", "=", $pid)
      ->where("country", "=", $country)
      ->get();

      if(count($country_check) < 1)
      {


            try {

              Capsule::table('mod_shippingmodule_country')->insert(
                          [
                              'product_id' => $pid,
                              'country' => $country,

                          ]
                      );

              header("Location: addonmodules.php?module=shippingmodule&view=manageCountries&pid=".$pid);
            } catch (\Exception $e) {
              echo "Uh oh! It didn't work, but I was able to rollback. {$e->getMessage()}";
          }

      }

    }

}



public function editCountry($id){

$country = Capsule::table('mod_shippingmodule_country')->where("id", "=", $id)->value('country');

?>

<h2>Edit Country <span style="float:right;"> <a href="addonmodules.php?module=shippingmodule&view=manageCountries" class="btn btn-success btn-sm">All Countries</a> <a href="addonmodules.php?module=shippingmodule" class="btn btn-info btn-sm">Dashboard</a></span></h2>
<form action="addonmodules.php?module=shippingmodule&view=updateCountry" method="post">
    <table class="table">
    <tr>
      <td>
        <input class="form-control" required placeholder="Enter Country Name" value="<?php echo $country; ?>" type="text" name="country"  />
        <input type="hidden" name="id" required value="<?php echo $_GET['id'] ?>"  />
      </td>
    </tr>
    <tr>
      <td align="center">
        <button class="btn btn-success " type="submit">Update Country</button>
      </td>
    </tr>
  </table>

</form>

<?php


}


public function updateCountry($id){

  try {
      $updatedUserCount = Capsule::table('mod_shippingmodule_country')
          ->where('id', $id)
          ->update(
              [
                  'country' => $_POST['country'],
              ]
          );

      echo "Updated {$updatedUserCount} Country";
  } catch (\Exception $e) {
    echo "I couldn't update country. {$e->getMessage()}";
    }

    header("Location: addonmodules.php?module=shippingmodule&view=manageCountries");



}

public function deleteCountry($id){

  try {
      Capsule::table('mod_shippingmodule_country')
          ->where('id', '=', $id)
          ->delete();

          Capsule::table('mod_shippingmodule_rates')
              ->where('country', '=', $id)
              ->delete();

              Capsule::table('mod_shippingmodule_zip_ranges')
                  ->where('country', '=', $id)
                  ->delete();


  } catch(\Illuminate\Database\QueryException $ex){
      echo $ex->getMessage();
  } catch (Exception $e) {
      echo $e->getMessage();
  }

  header("Location: addonmodules.php?module=shippingmodule&view=manageCountries&pid=".$_GET['pid']);


}




public function manageZipRanges($country){


    $product_name = Capsule::table('tblproducts')->where("id", "=", $_GET['pid'])->value('name');

    $country_name = Capsule::table('mod_shippingmodule_country')->where("id", "=", $country)->value('country');

    $string = file_get_contents("../resources/country/dist.countries.json");
    $countries = json_decode($string, true);

      ?>
      <h2>Manage Zip Code Ranges for <?php echo $countries[$country_name]['name']; ?> (<?php echo $product_name; ?>) <span style="float:right;"> <a href="addonmodules.php?module=shippingmodule&view=addZipRange&country=<?php echo $_REQUEST['country']; ?>&pid=<?php echo $_GET['pid']; ?>" class="btn btn-success btn-sm">Add New</a> <a href="addonmodules.php?module=shippingmodule&view=manageCountries&pid=<?php echo $_GET['pid']; ?> " class="btn btn-warning btn-sm">All Countries</a>
        <a href="addonmodules.php?module=shippingmodule&view=manageProduct&pid=<?php echo $_GET['pid'];; ?>" class="btn btn-info btn-sm">Back to Manage Product</a>
      </span>
    </h2>
    <br />
        <table border class="display" id="managezip_table">
          <thead>
            <tr>
              <th>
              Country
              </th>
              <th>
                Start Range
              </th>
              <th>
                End Range
              </th>
              <th>
                Rate
              </th>
              <th>
                Actions
              </th>
            </tr>
          </thead>
          <tbody>

            <?php
                foreach (Capsule::table('mod_shippingmodule_zip_ranges')->where("country", "=", $country)->where("product_id", "=", $_GET['pid'])->get() as $ziprange) {

                  ;

                  ?>
                  <tr>
                    <td>
                      <?php echo $countries[$country_name]['name'].PHP_EOL; ?>
                    </td>
                    <td>
                      <?php echo $ziprange->zipc_range_start.PHP_EOL; ?>
                    </td>
                    <td>
                      <?php echo $ziprange->zipc_range_end.PHP_EOL; ?>
                    </td>
                    <td>
                      <?php

                      $curr = Capsule::table('tblcurrencies')->where("default", "=", 1)->get();

                       echo $curr[0]->prefix.$ziprange->rate.' '.$curr[0]->suffix.PHP_EOL; ?>
                    </td>
                    <td>
                      <a class="btn btn-sm btn-info" href="addonmodules.php?module=shippingmodule&view=editZipRange&id=<?php echo $ziprange->id; ?>&pid=<?php echo $_GET['pid']; ?>">Edit</a>  <a class="btn btn-sm btn-danger" onclick="return confirmDelete();" href="addonmodules.php?module=shippingmodule&view=deleteZipRange&id=<?php echo $ziprange->id; ?>&country=<?php echo $ziprange->country; ?>">Delete</a>
                    </td>
                  </tr>
                  <?php
                }
             ?>
          </tbody>
        </table>

        <script>
        function confirmDelete() {
          return confirm("Are you sure to delete?");
        }
        </script>



        <script type="text/javascript">
        $(document).ready(function() {
            $('#managezip_table').DataTable({
              responsive: true
            });
        } );
        </script>

      <?php
}



public function addZipRange($country){

  $product_name = Capsule::table('tblproducts')->where("id", "=", $_GET['pid'])->value('name');


  $country_name = Capsule::table('mod_shippingmodule_country')->where("id", "=", $country)->value('country');

  $string = file_get_contents("../resources/country/dist.countries.json");
  $countries = json_decode($string, true);
   ?>

<h2>Add Zip Code Range for <?php echo $countries[$country_name]['name']; ?> (<?php echo $product_name; ?>) <span style="float:right;"> <a href="addonmodules.php?module=shippingmodule&view=manageZipRanges&country=<?php echo $country; ?>&pid=<?php echo $_GET['pid']; ?>" class="btn btn-warning btn-sm">All Zip Code Ranges for <?php echo $country_name; ?></a> <a href="addonmodules.php?module=shippingmodule&view=manageProduct&pid=<?php echo $_GET['pid']; ?>" class="btn btn-info btn-sm">Back to Manage Product</a></span></h2>
<form action="addonmodules.php?module=shippingmodule&view=saveZipRange&pid=<?php echo $_GET['pid']; ?>" method="post">
    <table class="table">
    <tr>
      <td>
        Country
      </td>
      <td>

        <?php echo $countries[$country_name]['name']; ?>
      </td>
    </tr>
    <tr>
      <td>
        Zip Code Start Range
      </td>
      <td>
        <input class="form-control" id="rStart" required placeholder="Enter Zip or Postal Code Start Range" required type="text" name="zipStart"  />
      </td>
    </tr>
    <tr>
      <td>
        Zip Code End Range
      </td>
      <td>
        <input class="form-control" id="rEnd" required placeholder="Enter Zip or Postal Code End Range" required type="text" name="zipEnd"  />
      </td>
    </tr>
    <tr>
      <td>
        Range Rate
      </td>
      <td width="75%">

          <?php
          $curr = Capsule::table('tblcurrencies')->where("default", "=", 1)->get();


                ?>
                  <?php echo $curr[0]->prefix; ?> <input style="display:inline-block; width:90%;" class="form-control" type="number" name="rangeRate"  placeholder="Enter Shipping Rate for this Range" step="0.01" required /> <?php echo $curr[0]->suffix; ?>
                  <br /> <em style="font-size:12px; ">Rate will be saved in your default currency and will be automatically converted to other currencies at the time of checkout if you are using multiple currencies and your client chooses another currency for checkout. </em>
                <?php


           ?>


      </td>
    </tr>
    <tr>
      <td>
        <input type="hidden" value="<?php echo $_REQUEST['country']; ?>" name="country" />
      </td>
      <td>

        <button class="btn btn-success " onclick="return check_range();" type="submit">Save Zip Code Range</button>
      </td>
    </tr>
  </table>

</form>

<script type="text/javascript">

function check_range(){

  var rs = $('#rStart').val();
  var re = $('#rEnd').val();

  if(rs > re)
  {
    alert('Error! Start range must be smaller than End range');
    return false;
  }

}


</script>

<?php


}


public function saveZipRange(){

  $product_id = $_GET['pid'];

    try {
      Capsule::table('mod_shippingmodule_zip_ranges')->insert(
                  [
                      'country' => $_POST['country'],
                      'zipc_range_start' => $_POST['zipStart'],
                      'zipc_range_end' => $_POST['zipEnd'],
                      'rate' => $_POST['rangeRate'],
                      'product_id' => $product_id,
                  ]
              );

      header("Location: addonmodules.php?module=shippingmodule&view=manageZipRanges&pid=".$_GET['pid']."&country=".$_POST['country']);


  } catch (\Exception $e) {
      echo "Uh oh! It didn't work, but I was able to rollback. {$e->getMessage()}";
  }

}



public function deleteZipRange($id){

  try {
      Capsule::table('mod_shippingmodule_zip_ranges')
          ->where('id', '=', $id)
          ->delete();
  } catch(\Illuminate\Database\QueryException $ex){
      echo $ex->getMessage();
  } catch (Exception $e) {
      echo $e->getMessage();
  }

  header("Location: addonmodules.php?module=shippingmodule&view=manageZipRanges&country=".$_GET['country']);


}



public function editZipRange($id){

  $product_name = Capsule::table('tblproducts')->where("id", "=", $_GET['pid'])->value('name');


  $zip_range = Capsule::table('mod_shippingmodule_zip_ranges')->where("id", "=", $id)->get();

  $country_name = Capsule::table('mod_shippingmodule_country')->where("id", "=", $zip_range[0]->country)->value('country');

  $string = file_get_contents("../resources/country/dist.countries.json");
  $countries = json_decode($string, true);

  ?>

<h2>Edit Zip Code Range for <?php echo $countries[$country_name]['name']; ?> (<?php echo $product_name; ?>) <span style="float:right;"> <a href="addonmodules.php?module=shippingmodule&view=manageZipRanges&country=<?php echo $zip_range[0]->country; ?>&pid=<?php echo $_GET['pid']; ?>" class="btn btn-warning btn-sm">All Zip Code Ranges for <?php echo $country_name; ?></a>
  <a href="addonmodules.php?module=shippingmodule&view=manageProduct&pid=<?php echo $_GET['pid'];; ?>" class="btn btn-info btn-sm">Back to Manage Product</a> </span> </h2>
<br />
<form action="addonmodules.php?module=shippingmodule&view=updateZipRange" method="post">
    <table class="table">
    <tr>
      <td>
        Country
      </td>
      <td>

        <?php echo $countries[$country_name]['name']; ?>
      </td>
    </tr>
    <tr>
      <td>
        Zip Code Range Start
      </td>
      <td>
        <input class="form-control" id="rStart" required placeholder="Enter Zip or Postal Code Start Range" value="<?php echo $zip_range[0]->zipc_range_start; ?>" required type="text" name="zipStart"  />
      </td>
    </tr>
    <tr>
      <td>
        Zip Code Range End
      </td>
      <td>
        <input class="form-control" id="rEnd" required placeholder="Enter Zip or Postal Code End Range" value="<?php echo $zip_range[0]->zipc_range_end; ?>" required type="text" name="zipEnd"  />
      </td>
    </tr>
    <tr>
      <td>
        Range Rate
      </td>
      <td width="75%">

          <?php
          $curr = Capsule::table('tblcurrencies')->where("default", "=", 1)->get();


                ?>
                  <?php echo $curr[0]->prefix; ?> <input style="display:inline-block; width:90%;" class="form-control" type="number" value="<?php echo $zip_range[0]->rate; ?>" name="rangeRate"  placeholder="Enter Shipping Rate for this Range" step="0.01" required /> <?php echo $curr[0]->suffix; ?>
                  <br /> <em style="font-size:12px; ">Rate will be saved in your default currency and will be automatically converted to other currencies at the time of checkout if you are using multiple currencies and your client chooses another currency for checkout. </em>
                <?php


           ?>


      </td>
    </tr>
    <tr>
      <td>
        <input type="hidden" value="<?php echo $zip_range[0]->country; ?>" name="country" />
        <input type="hidden" value="<?php echo $_REQUEST['id']; ?>" name="id" />
      </td>
      <td>

        <button onclick="return check_range();" class="btn btn-success " type="submit">Save Zip Code Range</button>
      </td>
    </tr>
  </table>

</form>

<script type="text/javascript">

function check_range(){

  var rs = $('#rStart').val();
  var re = $('#rEnd').val();

  if(rs > re)
  {
    alert('Error! Start range must be smaller than End range');
    return false;
  }

}


</script>

<?php


}



public function updateZipRange($id){

  try {
      $updatedUserCount = Capsule::table('mod_shippingmodule_zip_ranges')
          ->where('id', $id)
          ->update(
              [
                  'country' => $_POST['country'],
                  'zipc_range_start' => $_POST['zipStart'],
                  'zipc_range_end' => $_POST['zipEnd'],
                  'rate' => $_POST['rangeRate'],

              ]
          );

      echo "Updated {$updatedUserCount} Zip Code Range";
  } catch (\Exception $e) {
    echo "I couldn't update country. {$e->getMessage()}";
    }

    header("Location: addonmodules.php?module=shippingmodule&view=manageZipRanges&country=".$_POST['country']);



}





public function manageFlatRates($country){


  $product_name = Capsule::table('tblproducts')->where("id", "=", $_GET['pid'])->value('name');

  $string = file_get_contents("../resources/country/dist.countries.json");
  $countries = json_decode($string, true);


    $country_name = Capsule::table('mod_shippingmodule_country')->where("id", "=", $country)->value('country');

    $flat_rate = Capsule::table('mod_shippingmodule_rates')->where("country", "=", $country)->where("product_id", "=", $_GET['pid'])->get();

      ?>
      <h2>Manage Flat Rates for <?php echo $countries[$country_name]['name']; ?> (<?php echo $product_name; ?>) <span style="float:right;"> <a class="btn btn-sm btn-success" href="addonmodules.php?module=shippingmodule&view=editFlatRate&country=<?php echo $country; ?>&pid=<?php echo $_GET['pid']; ?>">Edit Flat Rate</a> <a href="addonmodules.php?module=shippingmodule&view=manageCountries&pid=<?php echo $_GET['pid']; ?>" class="btn btn-warning btn-sm">All Countries</a>
          <a href="addonmodules.php?module=shippingmodule&view=manageProduct&pid=<?php echo $_GET['pid'];; ?>" class="btn btn-info btn-sm">Back to Manage Product</a>
      </span>
    </h2>
    <br />
        <table border class="display" id="flat_rate_table">
                  <tr>
                    <td>
                    Country
                  </td>
                    <td>
                      <?php echo $countries[$country_name]['name'].PHP_EOL; ?>
                    </td>
                    </tr>

                  <tr>
                    <td>
                      Flat Shipping Rate
                    </td>
                    <td>
                      <?php

                      $curr = Capsule::table('tblcurrencies')->where("default", "=", 1)->get();

                      if(!empty($flat_rate[0]->flat_rate))
                      {
                        $rate = $flat_rate[0]->flat_rate;
                      }
                      else {
                        $rate = 0;
                      }

                       echo $curr[0]->prefix.$rate.' '.$curr[0]->suffix.PHP_EOL; ?>
                    </td>
                  </tr>
        </table>

        <script>
        function confirmDelete() {
          return confirm("Are you sure to delete?");
        }
        </script>

        <script type="text/javascript">
        $(document).ready(function() {
            $('#flat_rate_table').DataTable({
              responsive: true
            });
        } );
        </script>


      <?php


}


public function editFlatRate($country){

  $product_name = Capsule::table('tblproducts')->where("id", "=", $_GET['pid'])->value('name');


  $flat_rate = Capsule::table('mod_shippingmodule_rates')->where("product_id", "=", $_GET['pid'])->where("country", "=", $country)->get();

  $country_name = Capsule::table('mod_shippingmodule_country')->where("id", "=", $country)->value('country');

  $string = file_get_contents("../resources/country/dist.countries.json");
  $countries = json_decode($string, true);

  ?>

<h2>Edit Flat Shipping Rate for <?php echo $countries[$country_name]['name']; ?> (<?php echo $product_name; ?>) <span style="float:right;"> <a href="addonmodules.php?module=shippingmodule&view=manageCountries&pid=<?php echo $_GET['pid']; ?>" class="btn btn-warning btn-sm">All Countries</a>
    <a href="addonmodules.php?module=shippingmodule&view=manageProduct&pid=<?php echo $_GET['pid'];; ?>" class="btn btn-info btn-sm">Back to Manage Product</a>
 </span> </h2>
<br />
<form action="addonmodules.php?module=shippingmodule&view=updateFlatRate&pid=<?php echo $_GET['pid']; ?>" method="post">
    <table class="table">
    <tr>
      <td>
        Country
      </td>
      <td>

        <?php


         echo $countries[$country_name]['name']; ?>
      </td>
    </tr>
    <tr>
      <td>
        Flat Shipping Rate
      </td>
      <td width="75%">

          <?php
          $curr = Capsule::table('tblcurrencies')->where("default", "=", 1)->get();


                ?>
                  <?php echo $curr[0]->prefix; ?> <input style="display:inline-block; width:90%;" class="form-control" type="number" value="<?php echo $flat_rate[0]->flat_rate; ?>" name="flat_rate"  placeholder="Enter Flat Shipping Rate " step="0.01" required /> <?php echo $curr[0]->suffix; ?>
                  <br /> <em style="font-size:12px; ">Rate will be saved in your default currency and will be automatically converted to other currencies at the time of checkout if you are using multiple currencies and your client chooses another currency for checkout. </em>
                <?php


           ?>


      </td>
    </tr>
    <tr>
      <td>
        <input type="hidden" value="<?php echo $country; ?>" name="country" />
      </td>
      <td>

        <button onclick="return check_range();" class="btn btn-success " type="submit">Save Flat Shipping Rate</button>
      </td>
    </tr>
  </table>

</form>

<script type="text/javascript">

function check_range(){

  var rs = $('#rStart').val();
  var re = $('#rEnd').val();

  if(rs > re)
  {
    alert('Error! Start range must be smaller than End range');
    return false;
  }

}


</script>

<?php


}



public function updateFlatRate($country){

  // echo $country;
  // exit;

  $flat_rate = Capsule::table('mod_shippingmodule_rates')->where("product_id", "=", $_GET['pid'])->where("country", "=", $country)->get();

  $result = count($flat_rate);

  $product_id = $_GET['pid'];

  if($result < 1){

    try {
      Capsule::table('mod_shippingmodule_rates')->insert(
                  [
                      'country' => $country,
                      'flat_rate' => $_POST['flat_rate'],
                      'product_id' => $product_id,
                  ]
              );


  } catch (\Exception $e) {
      echo "Uh oh! It didn't work, but I was able to rollback. {$e->getMessage()}";
  }



  }
  else
  {

      try {
          $updatedUserCount = Capsule::table('mod_shippingmodule_rates')
              ->where('country', $country)
              ->where('product_id', $_GET['pid'])
              ->update(
                  [
                      'flat_rate' => $_POST['flat_rate'],

                  ]
              );

          echo "Updated {$updatedUserCount} Flat Shipping Rate";
      } catch (\Exception $e) {
        echo "I couldn't update country. {$e->getMessage()}";
        }


  }
    header("Location: addonmodules.php?module=shippingmodule&view=manageFlatRates&country=".$country."&pid=".$_GET['pid']);



}

public function CalculateAdditionProductPrice($pid , $country, $original){


  $getRate = Capsule::table('mod_shippingmodule_additional_rates')
            ->where("product_id", "=", $pid )
            ->where("country", "=", $country)
            ->first();
  $getRate = (array) $getRate;
  $Rtype = $getRate['rate_type'];
  $Rvalue = $getRate['value'];

if(!empty($Rvalue))
{
  if($Rtype == 1)
  {
    $price = $Rvalue;
  }

  if($Rtype == 2)
  {
    $price = ($original/100) * $Rvalue;
  }
}
else {
  $price = $original;
}
  return $price;
}

public function ShippingCalculator($country, $zipcode, $product_id){

  $ShippingTypeFull = Capsule::table('tbladdonmodules')
            ->where("module", "=", "shippingmodule")
            ->where("setting", "=", "ShippingType")
            ->value('value');

  $ShippingTypeSplit = explode('.', $ShippingTypeFull);

  $ShippingType = $ShippingTypeSplit[0];




  if($ShippingType == 1)
  {

    $FlatShippingForAll = Capsule::table('tbladdonmodules')
            ->where("module", "=", "shippingmodule")
            ->where("setting", "=", "FlatShippingAll")
            ->value('value');


    $ShipRate = $FlatShippingForAll;
  }

  if($ShippingType == 2)
  {

      $FlatShippingForAll = Capsule::table('tbladdonmodules')
            ->where("module", "=", "shippingmodule")
            ->where("setting", "=", "FlatShippingAll")
            ->value('value');

      $ZipRates = Capsule::table('mod_shippingmodule_zip_ranges')
                ->whereRaw("country = $country AND product_id = $product_id AND '$zipcode' BETWEEN `zipc_range_start` AND `zipc_range_end`")
                ->value('rate');


    $ShipRate = $FlatShippingForAll + $ZipRates;
  }

  if($ShippingType == 3)
  {
      $CountryFlatRate = Capsule::table('mod_shippingmodule_rates')->where("country", "=", $country)->where("product_id", "=", $product_id)->value('flat_rate');

      $ZipRates = Capsule::table('mod_shippingmodule_zip_ranges')
                ->whereRaw("country = $country AND product_id = $product_id AND '$zipcode' BETWEEN `zipc_range_start` AND `zipc_range_end`")
                ->value('rate');


    $ShipRate =  $CountryFlatRate + $ZipRates;
  }

  if($ShippingType == 4)
  {

     $ZipRates = Capsule::table('mod_shippingmodule_zip_ranges')
                ->whereRaw("country = $country AND product_id = $product_id AND '$zipcode' BETWEEN `zipc_range_start` AND `zipc_range_end`")
                ->value('rate');

    $ShipRate = $ZipRates;
  }

return $ShipRate;

}



public function ConvertCurrency($price , $s_curr){

  $default_currency = Capsule::table('tblcurrencies')->where("default", "=", 1)->get();

  $d_curr = $default_currency['id'];


  if(!empty($_SESSION['uid']) && $_SESSION['uid'] > 0)
  {
      $user_currency = Capsule::table('tblclients')->where("id", "=", $_SESSION['uid'])->value('currency');

      if($user_currency != $d_curr)
      {
        $selected_currency = Capsule::table('tblcurrencies')->where("id", "=", $user_currency)->value('rate');
        $converted_price = $price * $selected_currency;
      }
      else {
          $converted_price = $price;
      }
  }
  else
  {
      if($d_curr != $s_curr)
      {

        $selected_currency = Capsule::table('tblcurrencies')->where("id", "=", $s_curr)->value('rate');
          $converted_price = $price * $selected_currency;

      }
      else {
        $converted_price = $price;
      }
}


  return $converted_price;



}


public function manageOrderTracking(){

?>

  <h2>Manage Order Tracking <span style="float:right;"> <a href="addonmodules.php?module=shippingmodule" class="btn btn-warning btn-sm">Dashboard</a></span>
</h2>
<br />
    <table border class="display" id="orders_track" width="100%">
      <thead>
        <tr>
          <th>
          Order ID
          </th>
          <th>
          Client Name
          </th>
          <th>
            Shipping Address
          </th>
          <th>
            Shipping Company
          </th>
          <th>
            Shipping Status
          </th>
          <th>
            Action
          </th>
        </tr>
      </thead>
      <tbody>

        <?php
            foreach (Capsule::table('mod_shippingmodule')->get() as $orders) {
              ?>
              <tr>
                <td>
                  <a href="orders.php?action=view&id=<?php echo $orders->orderid; ?>" target="_blank"><?php echo $orders->orderid . PHP_EOL; ?></a>
                </td>
                <td>
                  <?php
                $user_id = Capsule::table('tblorders')->where("id", "=", $orders->orderid)->value('userid');

                $client_fn = Capsule::table('tblclients')->where("id", "=", $user_id)->value('firstname');

                $client_ln = Capsule::table('tblclients')->where("id", "=", $user_id)->value('lastname');

                echo '<a href="clientssummary.php?userid='.$user_id.'">'.$client_fn.' '.$client_ln.'</a>';

                    ?>
                </td>
                <td>
                    <?php

                      $country = Capsule::table('mod_shippingmodule_country')->where("id", "=", $orders->country)->value('country');

                      echo $orders->shipping_addr.', '.$country.' - '.$orders->zip_code;

                    ?>
                </td>
                <td>
                    <?php echo $orders->shipping_company; ?>
                </td>
                <td>
                  <?php echo $orders->shipping_status; ?>

                </td>
                <td>
                  <a class="btn btn-sm btn-info" href="addonmodules.php?module=shippingmodule&view=editOrderTracking&id=<?php echo $orders->id; ?>">Update Tracking Info</a>
                </td>
              </tr>
              <?php
            }
         ?>
      </tbody>
    </table>

    <script type="text/javascript">
    $(document).ready(function() {
        $('#orders_track').DataTable({
responsive: true

        });
    } );
    </script>

  <?php




}


public function editOrderTracking($id){

  $order = Capsule::table('mod_shippingmodule')->where("id", "=", $id)->get();

  ?>

  <h2>Update Tracking for Order # <?php echo $order[0]->orderid; ?> <span style="float:right;"> <a href="addonmodules.php?module=shippingmodule&view=manageOrderTracking" class="btn btn-success btn-sm">All Orders</a> <a href="addonmodules.php?module=shippingmodule" class="btn btn-info btn-sm">Dashboard</a></span></h2>
  <form action="addonmodules.php?module=shippingmodule&view=updateOrderTracking" method="post">
      <table class="table" border="1px solid" >
      <tr>
        <th>
          Order ID
        </th>
        <td>
          <?php echo $order[0]->orderid; ?>
        </td>
      </tr>
      <tr>
        <th>
          Shipping Address
        </th>
        <td>
          <?php echo $order[0]->shipping_addr; ?>
        </td>
      </tr>

      <tr>
        <th>
          Zip Code
        </th>
        <td>
          <?php echo $order[0]->zip_code; ?>
        </td>
      </tr>

      <tr>
        <th>
          Country
        </th>
        <th>
          <?php
          $country = Capsule::table('mod_shippingmodule_country')->where("id", "=", $order[0]->country)->value('country');

          echo $country; ?>
        </th>
      </tr>


      <tr>
        <th>
          Shipping Company
        </th>
        <td>
          <input type="text" required name="shipping_company" class="form-control" value="<?php echo $order[0]->shipping_company; ?>"  />
        </td>
      </tr>

      <tr>
        <th>
          Shipping URL
        </th>
        <td>
          <input type="url" required name="shipping_url" class="form-control" value="<?php echo $order[0]->shipping_url; ?>"  />
          <br />
          Please enter Full URL. Format: https://domain.com
        </td>
      </tr>

      <tr>
        <th>
          Shipping Status
        </th>
        <td>
          <input type="text" required name="shipping_status" class="form-control" value="<?php echo $order[0]->shipping_status; ?>"  />
        </td>
      </tr>

      <tr>
        <th>
          Tracking Number
        </th>
        <td>
          <input type="text" required name="tracking_number" class="form-control" value="<?php echo $order[0]->tracking_number; ?>"  />
        </td>
      </tr>


      <tr>
        <td>

        </td>
        <td>
          <input type="hidden" name="id" required value="<?php echo $id ?>"  />

          <button class="btn btn-success " type="submit">Update Order Tracking Info</button>
        </td>
      </tr>
    </table>

  </form>


  <?php



}


public function updateOrderTracking($id){


  try {
      $updatedUserCount = Capsule::table('mod_shippingmodule')
          ->where('id', $id)
          ->update(
              [
                  'shipping_company' => $_POST['shipping_company'],
                  'shipping_url' => $_POST['shipping_url'],
                  'shipping_status' => $_POST['shipping_status'],
                  'tracking_number' => $_POST['tracking_number'],

              ]
          );

      echo "Updated {$updatedUserCount} Order tracking info";
  } catch (\Exception $e) {
    echo "I couldn't update order tracking info: {$e->getMessage()}";
    }

    header("Location: addonmodules.php?module=shippingmodule&view=manageOrderTracking");




}


public function manageProducts(){

  $pros = Capsule::table('mod_shippingmodule_products')->get();

  $result_pro = count($pros);


  ?>
    <h2>Manage Products

<span style="float:right;"> <a href="addonmodules.php?module=shippingmodule&view=manageCountryShipping" class="btn btn-info btn-sm">Enable/Disable Shipping Countries</a></span>
    </h2>

<br>
    <table id ="products_tb"  border="">
    <thead>
      <th>Name</th>
      <th>Shipping Status</th>
      <th>Actions</th>
    </thead>
    <tbody>

  <?php
  $command = 'GetProducts';
  $postData = array(
      // 'pid' => '1',
  );
  // $adminUsername = 'ADMIN_USERNAME'; // Optional for WHMCS 7.2 and later

  $results = localAPI($command, $postData);
  foreach($results['products']['product'] as $product)
  {

    $total_pros = count($results['products']['product']);

    $proid = $product['pid'];
      $pros = Capsule::table('mod_shippingmodule_products')->where('product' , '=' , $proid)->get();

      $check_product_existance = count($pros);

      if($check_product_existance < 1)
      {
      // global $proid;
        try {

          Capsule::table('mod_shippingmodule_products')->insert(
                      [
                          'product' => $proid,
                          'shipping_enable' => 0,
                      ]
                  );



      } catch (\Exception $e) {
          echo "Uh oh! It didn't work, but I was able to rollback. {$e->getMessage()}";
      }
    }

      $shipping_status = Capsule::table('mod_shippingmodule_products')->where("product", "=", $product['pid'])->value('shipping_enable');

      $get_image = Capsule::table('mod_shippingmodule_products')->where("product", "=", $product['pid'])->value('photo');

      $image = explode(',' , $get_image);


      $files_array = $this->getFileTypes($image);




    ?>
    <tr>
      <td>
        <a style="text-decoration:none;" href="configproducts.php?action=edit&id=<?php echo $product['pid']; ?>" target="_blank">
        <?php

        if(!empty($files_array['photos'][0])) {

          $photonew = explode('|' , $files_array['photos'][0]);

           ?>
        <img src="<?php echo $this->CropImage($photonew[0]); ?>" width="50" />
        <?php }
        else { ?>
          <img src="<?php echo $this->CropImage("../img/default-image.png"); ?>" width="50" />
        <?php } ?>
        </a>
        &nbsp;
        <a href="configproducts.php?action=edit&id=<?php echo $product['pid']; ?>" target="_blank">
        <?php echo $product['name']; ?></a></td>
      <td><?php if($shipping_status == 0 || $shipping_status == NULL) { echo 'Disabled'; }
      elseif($shipping_status == 1){ echo 'Enabled'; } ?>
      </td>
      <td>

        <?php if($shipping_status == 0 || $shipping_status == NULL) {
          ?>
          <a class="btn btn-sm btn-success" href="addonmodules.php?module=shippingmodule&view=updateProducts&pid=<?php echo $product['pid']; ?>&status=1">Enable</a>
        <?php }elseif($shipping_status == 1){ ?>
          <a class="btn btn-sm btn-danger" href="addonmodules.php?module=shippingmodule&view=updateProducts&pid=<?php echo $product['pid']; ?>&status=0">Disable</a>
          <a class="btn btn-sm btn-warning" href="addonmodules.php?module=shippingmodule&view=manageProduct&pid=<?php echo $product['pid']; ?>">Manage</a>
        <?php } ?>

      </td>

    </tr>

    <?php
      unset($image);
  }

?>
</tbody>
</table>



<script type="text/javascript">
$(document).ready(function() {
    $('#products_tb').DataTable({
      responsive: true

    });
} );
</script>
<?php

}




public  function dataTables_includes(){
  ?>

  <!-- <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script> -->
  <script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/rowreorder/1.2.7/js/dataTables.rowReorder.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.6/js/dataTables.responsive.min.js"></script>

  <style>
  @import url('https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css');
  @import url('https://cdn.datatables.net/responsive/2.2.6/css/responsive.dataTables.min.css');
  @import url('https://cdn.datatables.net/rowreorder/1.2.7/css/rowReorder.dataTables.min.css');

  </style>
  <?php

}


public function updateProducts($pid){


  try {
      $updatedUserCount = Capsule::table('mod_shippingmodule_products')
          ->where('product', $pid)
          ->update(
              [
                  'shipping_enable' => $_GET['status'],
              ]
          );

      echo "Updated {$updatedUserCount} Product Shipping";
  } catch (\Exception $e) {
    echo "I couldn't update Product Shipping: {$e->getMessage()}";
    }

    header("Location: addonmodules.php?module=shippingmodule&view=manageProducts");




}


public function manageProduct($pid){

  $name = Capsule::table('tblproducts')->where("id", "=", $pid)->value('name');
  $image = Capsule::table('mod_shippingmodule_products')->where("product", "=", $pid)->value('photo');

    $images = explode(',' , $image);

    $files = $this->getFileTypes($images);

  ?>
<h3 align="center"><?php echo $_SESSION['error']; $_SESSION['error'] = ""; ?></h3>
  <h2>Manage <?php echo $name; ?>
    <span style="float:right;">
        <a href="addonmodules.php?module=shippingmodule&view=manageProducts" class="btn btn-info btn-sm">All Products</a>
     </span>
  </h2>
</br></br>
<center>

  <a href="addonmodules.php?module=shippingmodule&view=manageCountries&pid=<?php echo $pid; ?>" class="btn btn-success btn-md">Manage Shipping Rates</a>
  <a href="addonmodules.php?module=shippingmodule&view=manageProductPhoto&pid=<?php echo $pid; ?>"class="btn btn-danger btn-md">Upload Product Images/Videos</a>
  <a href="addonmodules.php?module=shippingmodule&view=AddVideos&pid=<?php echo $pid; ?>"class="btn btn-info btn-md">Add Video from URL</a>

  <a href="configproducts.php?action=edit&id=<?php echo $pid; ?>" target="_blank" class="btn btn-warning btn-md">View/Edit Product</a>
  <br><br>


<div id="accordion">
<h3>Uploaded Photos</h3>
    <div class="gallery">
    <p>

<?php

    $default_path = '../modules/addons/shippingmodule/product_images/';



    if(sizeof($files['photos']) > 0)
    {
        $i=1;
        foreach($files['photos'] as $file)
        {

          $file_data = explode("|" , $file);

            ?>

     <a href="<?php echo $default_path.$file_data[0]; ?>" class="big thumbox" rel="rel2">
            <img style="border-radius:5px;" src="<?php echo $this->CropImage($file_data[0]); ?>" width="150" alt="" title="<?php echo $file_data[2]; ?>">
         <a style="color: #FFF; margin-left: -45px;
    margin-top: 15px; position: absolute;" href="addonmodules.php?module=shippingmodule&view=deleteImage&pid=<?php echo $_GET['pid']; ?>&image=<?php echo $file; ?>" class="btn btn-danger btn-sm" onClick="return confirmDelete();">x</a>

    </a>





            <?php

            $i++;

        }
    }else
    {
        ?>
         <a href="../img/default-image.png" class="big" rel="rel2">
    <img style="border-radius:5px;" src="<?php echo $this->CropImage("../img/default-image.png"); ?>" width="150" />




        </a>

<?php

    }
?>
    </p>

</div>

<?php

  if(sizeof($files['videos']) > 0)
  {



    ?>

<h3>Uploaded Videos</h3>
<div>
    <p align="center">
<?php


        foreach($files['videos'] as $video)
        {

          $file_data = explode("|" , $video);

            ?>
    <div style="min-height: auto; padding: 5px;">
      <video width="400" controls src="<?php echo $default_path.$file_data[0]; ?>" ></video>
        <br>
        <h3><?php echo $file_data[2]; ?></h3>
        <br>
          <a style="color: #FFF;" href="addonmodules.php?module=shippingmodule&view=deleteImage&pid=<?php echo $_GET['pid']; ?>&image=<?php echo $video; ?>" class="btn btn-danger btn-sm" onClick="return confirmDelete();">Delete</a>

    </div>

            <?php


        }
?>
  </p>
</div>
<?php   } ?>



<?php

  if(sizeof($files['others']) > 0)
  {

    ?>

<h3>Added Videos By URL</h3>
<div>
    <p align="center">
<?php

        foreach($files['others'] as $video)
        {
          $video_data = explode('|' , $video);
            ?>
    <div style="min-height: auto; padding: 5px;">
      <?php
        if($video_data[1] == "youtube" || $video_data[1] == "vimeo")
        {
          switch ($video_data[1]) {
            case 'youtube':
              $url = 'https://www.youtube.com/embed/';
            break;
            case 'vimeo':
              $url = 'https://player.vimeo.com/video/';
            break;
          }
          ?>
          <iframe width="560" height="315"
          src="<?php echo $url.$video_data[0]; ?>"frameborder="0"
          allowfullscreen></iframe>
          <?php
        }

        if($video_data[1] == "html5video")
        {
          ?>
          <video width="400" controls src="<?php echo $video_data[0]; ?>" ></video>
          <?php
        }
       ?>
        <br>
        <?php echo $video_data[2];  ?>
        <br>
            <a style="color: #FFF;" href="addonmodules.php?module=shippingmodule&view=deleteImage&pid=<?php echo $_GET['pid']; ?>&image=<?php echo $video; ?>" class="btn btn-danger btn-sm" onClick="return confirmDelete();">Delete</a>
<br><br>
    </div>

            <?php


        }
?>
  </p>
</div>
<?php   } ?>


</div>





</center>


<style>
  @import url('../modules/addons/shippingmodule/css/simple-lightbox.min.css');
  @import url('//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css');


    .thumbox{

        display:inline-block;
        width: 175px;
        height: 175px;
        padding: 10px;

    }
    .ui-accordion .ui-accordion-content{
        max-height: 300px;
        min-height: 190px;
    }
</style>
<!-- As A Vanilla JavaScript Plugin -->
<script src="../modules/addons/shippingmodule/js/simple-lightbox.min.js"></script>
<!-- For legacy browsers -->
<script src="../modules/addons/shippingmodule/js/simple-lightbox.legacy.min.js"></script>
<!-- As A jQuery Plugin -->
<script src="../modules/addons/shippingmodule/js/simple-lightbox.jquery.min.js"></script>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


<script>

// As A jQuery Plugin -->
var gallery = $('.gallery a').simpleLightbox({
    /* options */

});

  $( function() {
    $( "#accordion" ).accordion(
        {

        });
  } );


    function confirmDelete() {
      return confirm("Are you sure to delete?");
    }

</script>

  <?php
}


public function array_delete($del_val, $array) {
    if(is_array($del_val)) {
         foreach ($del_val as $del_key => $del_value) {
            foreach ($array as $key => $value){
                if ($value == $del_value) {
                    unset($array[$key]);
                }
            }
        }
    } else {
        foreach ($array as $key => $value){
            if ($value == $del_val) {
                unset($array[$key]);
            }
        }
    }
    return array_values($array);
}


public function deleteImage($vars){

    $pid = $vars['pid'];
    $image_name = $vars['image'];
    $default_path = '../modules/addons/shippingmodule/product_images/';
    $images = Capsule::table('mod_shippingmodule_products')->where("product", "=", $pid)->value('photo');

    $image_array = explode(',' , $images);


    $new_image_array = $this->array_delete($image_name, $image_array);

    $images_uploaded = implode(',' , $new_image_array);

      try {
        $updatedUserCount = Capsule::table('mod_shippingmodule_products')
            ->where('product', $_GET['pid'])
            ->update(
                [
                    'photo' => $images_uploaded,

                ]
            );

        echo "Updated {$updatedUserCount} Product Photo";

        unlink($default_path.$image_name);

    } catch (\Exception $e) {
      echo "I couldn't update product. {$e->getMessage()}";
      }

     header("Location: addonmodules.php?module=shippingmodule&view=manageProduct&pid=".$_GET['pid']);
}


public function CropImage($image){

  require_once('ImageManipulator.php');

  $default_path = '../modules/addons/shippingmodule/product_images/';
  $im = new ImageManipulator($default_path.$image);
  $centreX = round($im->getWidth() / 15);
  $centreY = round($im->getHeight() / 15);

  $x1 = $centreX - 500;
  $y1 = $centreY - 500;

  $x2 = $centreX + 500;
  $y2 = $centreY + 500;

  $im->crop($x1, $y1, $x2, $y2); // takes care of out of boundary conditions automatically
  $tmp_image = "../modules/addons/shippingmodule/tmp/".$image;
  $im->save($tmp_image);

  return $tmp_image;

}



public function getShippingType(){

  $ShippingTypeFull = Capsule::table('tbladdonmodules')
            ->where("module", "=", "shippingmodule")
            ->where("setting", "=", "ShippingType")
            ->value('value');

  $ShippingTypeSplit = explode('.', $ShippingTypeFull);

  $ShippingType = $ShippingTypeSplit[0];

  return $ShippingType;

}


public function getCheckoutType(){

  $CheckoutTypeFull = Capsule::table('tbladdonmodules')
            ->where("module", "=", "shippingmodule")
            ->where("setting", "=", "CheckoutType")
            ->value('value');

  $CheckoutTypeSplit = explode('.', $CheckoutTypeFull);

  $CheckoutType = $CheckoutTypeSplit[0];

  return $CheckoutType;

}


public function printShippingRate($product_id, $shipcPrint, $shipZ, $price, $i, $new_total){

  $string = file_get_contents("../../../resources/country/dist.countries.json");
  $countriez = json_decode($string, true);

  $product_name = Capsule::table('tblproducts')->where("id", "=", $product_id)->value('name');

  $BPrice = formatCurrency($this->ConvertCurrency($price , $_SESSION['currency']), $_SESSION['currency']);




$html = '<div class="ShipDD" id="ShippingDetails_0">
    <div id="shipCDT" class="view-cart-items-header"> Shipping Cost for <b>'.$product_name.'</b> to
      '.$shipcPrint.' - '.$shipZ.'</div>
    <div class="sm_form_fields">

      <h2>'.$BPrice.'</h2>
      <a class="btn btn-warning btn-sm" href="javascript:void(0);" onclick="CalculateShipping( '.$i.' , '.$product_id.' , 1);">Re-Calculate</a>
    </div>
</div>

<script type="text/javascript">

$( document ).ready(function() {
        $("<div id=\"subtotal_'.$i.'\" class=\"bordered-totals\"><div class=\"clearfix\"><span class=\"pull-left\">Shipping for'.$product_name.'</span><span id=\"shipping_'.$i.'\" style=\"float:right;\" class=\"pull-right\">'.$BPrice.'</span></div></div>" ).insertAfter( ".subtotal" );
        $( "#totalDueToday").html( "'.formatCurrency($new_total, $_SESSION['currency']).'" );
      });
</script>';

return $html;

}



public function printShippingRateForm($product_id , $countries , $i , $userC, $ShippingType){

$product_name = Capsule::table('tblproducts')->where("id", "=", $product_id)->value('name');


  // return $html;

}


  public function getShippingAddForm( $countries , $userC, $ShippingType){


    $ShippingType = $this->getShippingType();
    $CheckoutType = $this->getCheckoutType();


    $script   = $_SERVER['SCRIPT_NAME'];
    $params   = $_SERVER['QUERY_STRING'];

    $html .= '<div class="ShipDD" >
        <div class="view-cart-items-header"> Shipping Details:</div>
        <form action="'.$script.'?'.$params.'" method="post">';

  $ClientDetails = Capsule::table('tblclients')->where("id", "=", $_SESSION['uid'])->first();



  if($ShippingType == 3)
    {

        $html .=  '<div class="sm_form_fields">
        <span class="title_smRF">
        Country:
        </span>
        <span class="field_smRF">
        <select required id="country" name="country" class="form-control country">
        <option value="">Select Country</option>
        '.$countries.'
        </select>
        </span>
        </div>';

    }


    if($ShippingType == 2 || $ShippingType == 3 || $ShippingType == 4 )
    {
        $html .=  '  <div class="sm_form_fields">
        <span class="title_smRF">
          Zip or Postal Code
          </span>
          <span class="field_smRF">
          <input required class="form-control zipship" id="zipship" name="zipship" type="text" placeholder="Enter Your Zip or Postal Code" value="'.$ClientDetails->postcode.'" />

          </span>
          </div>';
    }





    if($CheckoutType == 2)
    {
        $shipbutton = '<button id="update_ship" class="btn btn btn-info btn-checkout">Update Shipping Details</button>';
    }
    else
    {
        $shipbutton = '<button id="update_ship" class="btn btn-success btn-sm">Update Shipping Details</button>';
    }


$html .= '<div class="sm_form_fields">
<span id="ShippingAddress">
<span class="title_smRF">
  Shipping Address
  </span>
  <span class="field_smRF">
<input required class="form-control address" id="address" name="address" type="text" value="'.$ClientDetails->address1.' '.$ClientDetails->address2.'" placeholder="Enter your Full Address" />
</span>
  </span>
  </div>

  <center >
  '.$shipbutton.'
  <br><br>
  </center>
  </form>
  </div>
<br>



  <style>
  .title_smRF{

    padding:10px;
    display: inline-block;
    width: 30%;
    vertical-align: text-bottom;

  }

  .field_smRF{
    padding:5px;
    display: inline-block;
    width: 60%;

  }

  .sm_form_fields{
      padding: 10px;
  }
  .form-control{

    vertical-align:text-bottom !important;
  }

  td{
  padding:5px;
  }

  .ShipDD{
    border: 1px solid #058;
  /* padding: 10px; */
  border-radius:5px;
  background-color: #FFF;
  text-align: center;


  }

  .shipCDT{


  word-break: break-word;

  }

  #error_SMXP{

    padding:10px;
    background:#9e0000;
    color:#FFF;
    font-size:14px;
    display:none;
    border:1px solid #FFF;
    border-radius:5px;
  }

  </style>
  <script type="text/javascript">

    $( document ).ready(function() {

      $(".country").val("'.$userC.'");

      $("#checkout").click(function(event){
        if($(".zipship")[0] || $(".country")[0] || $(".address")[0])
        {
          event.preventDefault();
          $("#error_SMXP").html("Please update shipping details before checkout");
          $("#error_SMXP").show();
          $("html, body").animate({ scrollTop: $("#error_SMXP").offset().top  }, "slow");
        }
      });



      $("#frmCheckout").submit(function(event){

        if($(".zipship")[0] || $(".country")[0] || $(".address")[0])
        {
          event.preventDefault();
          $("#error_SMXP").html("Please update shipping details before checkout");
          $("#error_SMXP").show();
          $("html, body").animate({ scrollTop: $("#error_SMXP").offset().top }, "slow");
        }
        $("#checkout .loader").addClass("hidden");
        $("#checkout span").removeClass("invisible hidden");
        $("#checkout2 .loader").addClass("hidden");
        $("#checkout2 span").removeClass("invisible hidden");

      });


      $("#btnCompleteOrder").click(function(event){

        if($(".zipship")[0] || $(".country")[0] || $(".address")[0])
        {
          $("#error_SMXP").html("Please update shipping details before checkout");
          $("#error_SMXP").show();
          $("html, body").animate({ scrollTop: $("#error_SMXP").offset().top }, "slow");
          event.preventDefault()
        }
      });




  });



    </script>';



  if($CheckoutType == 2)
  {
        $html .= '<style>.view-cart-items-header { padding:10px; background: blue; color:#FFF;}</style>' ;
  }


    return $html;

}

public function InsertCountries_WHMCS(){

  $string = file_get_contents("../resources/country/dist.countries.json");
  $countries = json_decode($string, true);

  foreach($countries as $key => $val)
  {


    $country = Capsule::table('mod_shippingmodule_country')
    ->where("country", "=", $key)
    ->get();

    if(count($country) > 0)
    {
      continue;
    }

      try {

        Capsule::table('mod_shippingmodule_country')->insert(
                    [
                        'country' => $key,

                    ]
                );

      } catch (\Exception $e) {
        echo "Uh oh! It didn't work, but I was able to rollback. {$e->getMessage()}";
    }

  }



}


public function InsertRate_Types(){

  $data = array(
    'Flat',
    'Percentage',
  );

  foreach($data as $type)
  {


    $rate_type = Capsule::table('mod_shippingmodule_rates_types')
    ->where("rate_type", "=", $type)
    ->get();

    if(count($rate_type) > 0)
    {
      continue;
    }

      try {

        Capsule::table('mod_shippingmodule_rates_types')->insert(
                    [
                        'rate_type' => $type,

                    ]
                );

      } catch (\Exception $e) {
        echo "Uh oh! It didn't work, but I was able to rollback. {$e->getMessage()}";
    }

  }



}


public function enableCountry($id){

  try {
      $updatedUserCount = Capsule::table('mod_shippingmodule_country')
          ->where('id', $id)
          ->update(
              [
                  'status' => 1,
              ]
          );

      echo "Updated {$updatedUserCount} Country";
      header("Location: addonmodules.php?module=shippingmodule&view=manageCountryShipping");

  } catch (\Exception $e) {
    echo "I couldn't update country. {$e->getMessage()}";
    }



}


public function disableCountry($id){

  try {
      $updatedUserCount = Capsule::table('mod_shippingmodule_country')
          ->where('id', $id)
          ->update(
              [
                  'status' => 0,
              ]
          );

      echo "Updated {$updatedUserCount} Country";
            header("Location: addonmodules.php?module=shippingmodule&view=manageCountryShipping");
  } catch (\Exception $e) {
    echo "I couldn't update country. {$e->getMessage()}";
    }



}




public function IsShippingProduct($products){


  foreach($products as $product)
  {
    $product_id = $product['pid'];
    $shipping_status = Capsule::table('mod_shippingmodule_products')->where("product", "=", $product_id)->value('shipping_enable');

    if($shipping_status == 1 )
    {
      $isshipping = 1;
    }
  }

return $isshipping;
}


public function IsShippingProductSolo($product){


    $shipping_status = Capsule::table('mod_shippingmodule_products')->where("product", "=", $product)->value('shipping_enable');

    if($shipping_status == 1 )
    {
      $isshipping = 1;
    }

return $isshipping;
}

public function ShowShippingCharges($country , $zipship , $address, $products){


  $string = file_get_contents("resources/country/dist.countries.json");
  $countries = json_decode($string, true);

  $ShippingType = $this->getShippingType();
  $CartRawTotal = $_SESSION['SM_CART_RAWTOTAL'];
  $country_id = Capsule::table('mod_shippingmodule_country')
  ->where("country", "=", $country)
  ->value('id');

if($ShippingType == 1)
{
  $html .= '<div class="ShipDD"> <div class="view-cart-items-header"> Shipping Cost to '.$countries[$country]['name'].'</div>';

}
else {
  $html .= '<div class="ShipDD"> <div class="view-cart-items-header"> Shipping Cost to '.$countries[$country]['name'].' - '.$zipship.'</div>';

}

$numPros = 0;

foreach($products as $product)
{

  $product_id = $product['pid'];
  $checkShipStatus = $this->IsShippingProductSolo($product_id);
  if($checkShipStatus != 1)
  {
    continue;
  }

  $product_name = Capsule::table('tblproducts')->where("id", "=", $product_id)->value('name');
  $numPros++;

  if($numPros > 1)
  {
    $originalPrice = $this->ShippingCalculator($country_id , $zipship , $product_id);
    $shippingPrice = $this->CalculateAdditionProductPrice($product_id , $country_id, $originalPrice);

  }
  else {

    $shippingPrice = $this->ShippingCalculator($country_id , $zipship , $product_id);


  }

  $final_price = $this->ConvertCurrency($shippingPrice , $_SESSION['currency']);

  $price = formatCurrency($final_price, $_SESSION['currency']);







  $html .= '
  <div class="sm_form_fields">
  <span class="title_smRF">
    '.$product_name.'
    </span>
    <span class="field_smRF">
'.$price.'

    </span>
    </div>';

  $all_shipping = $all_shipping + $final_price;



}



$_SESSION['all_shipping'] = $all_shipping;
$_SESSION['shipping_country'] = $country_id;
$_SESSION['shipping_country_name'] = $country;
$_SESSION['zipcode'] = $zipship;
$_SESSION['address'] = $address;

$script   = $_SERVER['SCRIPT_NAME'];
$params   = $_SERVER['QUERY_STRING'];


$html .= '<br>
<center>
    '.$_SESSION['address'].'
<br><br>
<a href="'.$script.'?'.$params.'&manual_reset=1" class="btn btn-warning">Edit Shipping Details</a>
<center>
<br>
</div>
<br>';




$new_total = $CartRawTotal + $all_shipping;

$CheckoutType = $this->getCheckoutType();

  if($CheckoutType == 1)
  {


$html .= '<script type="text/javascript">

$( document ).ready(function() {
        $("<div id=\"subtotal_sm\" class=\"bordered-totals\"><div class=\"clearfix\"><span class=\"pull-left\">Shipping Charges</span><span id=\"shipping_sm\" style=\"float:right;\" class=\"pull-right\">'.formatCurrency($all_shipping, $_SESSION["currency"]).'</span></div></div>" ).insertAfter( ".subtotal" );
        $( ".order-summary-list:not(\"#recurring\")" ).append( "<li class=\"summary-list-item\"><span class=\"pull-left\">Shipping Charges</span><span id=\"subtotal_sm\" class=\"pull-right\">'.formatCurrency($all_shipping, $_SESSION["currency"]).'</span></li>");

      });
</script>';
  }
    else
    {

  $html .= '<script type="text/javascript">

$( document ).ready(function() {
        $( ".order-summary-list:not(\"#recurring\")" ).append( "<li class=\"list-item\"><span class=\"item-name\">Shipping Charges</span><span class=\"item-value\">'.formatCurrency($all_shipping, $_SESSION["currency"]).'</span></li>" );
        $( ".order-summary-list:not(\"#recurring\")" ).append( "<li class=\"summary-list-item\"><span class=\"pull-left\">Shipping Charges</span><span id=\"subtotal_sm\" class=\"pull-right\">'.formatCurrency($all_shipping, $_SESSION["currency"]).'</span></li>");

      });
</script>';

        $html .= '<style>.view-cart-items-header { padding:10px; background: blue; color:#FFF;}</style>' ;


    }


$html .= '<style>
.title_smRF{

  padding:10px;
  display: inline-block;
  width: 30%;
  vertical-align: text-bottom;

}

.field_smRF{
  padding:5px;
  display: inline-block;
  width: 60%;
  overflow:auto;

}

.sm_form_fields{
    padding: 10px;
    border-bottom:1px solid #CCC;
    font-size:14px;
}
.form-control{

  vertical-align:text-bottom !important;
}

td{
padding:5px;
}

.ShipDD{
  border: 1px solid #058;
/* padding: 10px; */
border-radius:5px;
background-color: #FFF;
text-align: center;


}

.shipCDT{


word-break: break-word;

}

#error_SMXP{

  padding:10px;
  background:#9e0000;
  color:#FFF;
  font-size:14px;
  display:none;
  border:1px solid #FFF;
  border-radius:5px;
}
</style>
';

return $html;


}

public function resetCart(){


  unset($_SESSION['all_shipping']);
  unset($_SESSION['shipping_country']);
  unset($_SESSION['shipping_country_name']);
  unset($_SESSION['zipcode']);
  unset($_SESSION['address']);
  unset($_SESSION['SM_CART_RAWTOTAL']);


}


public function massFlatRate($pid){



  ?>
  <h2>Set Mass Flat Shipping Rate <span style="float:right;"> <a href="addonmodules.php?module=shippingmodule&view=manageCountries&pid=<?php echo $pid; ?>" class="btn btn-success btn-sm">All Countries</a> <a href="addonmodules.php?module=shippingmodule&view=manageProduct&pid=<?php echo $pid; ?>" class="btn btn-info btn-sm">Back to Manage Product</a></span></h2>
  <form action="addonmodules.php?module=shippingmodule&view=massSaveFlatRate&pid=<?php echo $_GET['pid']; ?>" method="post">
      <table class="table">
      <tr>
        <td>
          Select Multiple Countries
        </td>
        <td>
          <select multiple style="height:250px;" class="form-control" id="selC" required name="country[]">
            <?php

            $string = file_get_contents("../resources/country/dist.countries.json");
            $countries = json_decode($string, true);

            foreach(Capsule::table('mod_shippingmodule_country')->where("status", "=", 1)->get() as $country)
            {


            ?>
                <option value="<?php echo $country->id; ?>"><?php echo $countries[$country->country]['name']; ?></option>

              <?php
            }
             ?>
          </select>

        </td>
      </tr>
      <tr>
        <td>
          Flat Rate
        </td>
        <td>
          <?php $curr = Capsule::table('tblcurrencies')->where("default", "=", 1)->get(); ?>

          <?php echo $curr[0]->prefix; ?> <input style="display:inline-block; width:90%;" type="number" name="flat_rate" class="form-control" /> <?php echo $curr[0]->suffix; ?>
          <br>
          <em style="font-size:12px;">
            Rate will be saved in your default currency and will be automatically converted to other currencies at the time of checkout if you are using multiple currencies and your client chooses another currency for checkout.
          </em>
        </td>
      </tr>
      <tr>
        <td></td>
        <td align="center">
          <button class="btn btn-success " type="submit">Set Flat Rate</button>
        </td>
      </tr>
    </table>

  </form>
  <?php

}

public function massSaveFlatRate($pid){


$countries = $_POST['country'];


// print_r($countreis);

$limit = sizeof($countries);

foreach($countries as $country)
{

  $this->massUpdateFlatRate($country);

}

header("Location: addonmodules.php?module=shippingmodule&view=manageCountries&pid=".$_GET['pid']);





}


public function massUpdateFlatRate($country){

  $flat_rate = Capsule::table('mod_shippingmodule_rates')->where("product_id", "=", $_GET['pid'])->where("country", "=", $country)->get();

  $result = count($flat_rate);

  $product_id = $_GET['pid'];

  if($result < 1){

    try {
      Capsule::table('mod_shippingmodule_rates')->insert(
                  [
                      'country' => $country,
                      'flat_rate' => $_POST['flat_rate'],
                      'product_id' => $product_id,
                  ]
              );


  } catch (\Exception $e) {
      echo "Uh oh! It didn't work, but I was able to rollback. {$e->getMessage()}";
  }



  }
  else
  {

      try {
          $updatedUserCount = Capsule::table('mod_shippingmodule_rates')
              ->where('country', $country)
              ->where('product_id', $_GET['pid'])
              ->update(
                  [
                      'flat_rate' => $_POST['flat_rate'],

                  ]
              );

          echo "Updated {$updatedUserCount} Flat Shipping Rate";
      } catch (\Exception $e) {
        echo "I couldn't update country. {$e->getMessage()}";
        }


  }

}



public function massManageShippingCountries(){



    ?>
    <h2>Mass Enable/Disable Shipping <span style="float:right;"> <a href="addonmodules.php?module=shippingmodule&view=manageCountryShipping&pid=<?php echo $pid; ?>" class="btn btn-success btn-sm">All Countries</a> <a href="addonmodules.php?module=shippingmodule&view=manageProducts&pid=<?php echo $pid; ?>" class="btn btn-info btn-sm">Manage Products</a></span></h2>
    <form action="addonmodules.php?module=shippingmodule&view=massSaveCountryShipping" method="post">
        <table class="table">
        <tr>
          <td>
            Select Multiple Countries
          </td>
          <td>
            <select multiple style="height:250px;" class="form-control" id="selC" required name="country[]">
              <?php

              $string = file_get_contents("../resources/country/dist.countries.json");
              $countries = json_decode($string, true);

              foreach(Capsule::table('mod_shippingmodule_country')->get() as $country)
              {


              ?>
                  <option value="<?php echo $country->id; ?>"><?php echo $countries[$country->country]['name']; ?></option>

                <?php
              }
               ?>
            </select>

          </td>
        </tr>
        <tr>
          <td>
            Select Mass Action
          </td>
          <td>
            <select name="status" class="form-control">
              <option value="1">Enable</option>
              <option value="0">Disable</option>
            </select>
          </td>
        </tr>
        <tr>
          <td></td>
          <td align="center">
            <button class="btn btn-success " type="submit">Apply</button>
          </td>
        </tr>
      </table>

    </form>
    <?php
}


public function massSaveCountryShipping(){


$countries = $_POST['country'];
$status = $_POST['status'];


foreach($countries as $country)
{

  if($status == 1)
  {
      $this->enableCountry($country);

  }elseif($status == 0)
  {
    $this->disableCountry($country);

  }
}

}



public function manageProductPhoto($pid){

  ?>
  <h2>Update Product Photo <span style="float:right;"> <a href="addonmodules.php?module=shippingmodule&view=manageCountryShipping&pid=<?php echo $pid; ?>" class="btn btn-success btn-sm">All Countries</a>
    <a href="addonmodules.php?module=shippingmodule&view=AddVideos&pid=<?php echo $pid; ?>" class="btn btn-warning btn-sm">Add Video from URL</a>
    <a href="addonmodules.php?module=shippingmodule&view=manageProduct&pid=<?php echo $pid; ?>" class="btn btn-info btn-sm">Back to Manage Product</a>
  </span></h2>
  <form action="addonmodules.php?module=shippingmodule&view=UpdateProductPhoto&pid=<?php echo $_GET['pid']; ?>" method="post" enctype="multipart/form-data">
      <table class="table">
      <tr>
        <td>
          Product
        </td>
        <td>
          <?php $product_name = Capsule::table('tblproducts')->where("id", "=", $_GET['pid'])->value('name');
            echo $product_name;?>
        </td>
      </tr>
      <tr>
        <td>
          Select Image <br>Max Size: 50 MB<br>Allowed File types: JPG, JPEG, PNG, GIF, mp4, ogg, webm, quicktime<br>Recommended Size: 500x500
            <br>

        </td>
        <td id="imageInputDiv">
          <p style="border:1px solid #eee; padding:15px;">
            <input class="form-control" type='file' required name="product_photo[]" ><br>
            <input class="form-control" type='text' required name="product_cap[]" placeholder="Caption for this Photo/Video"><br>
          </p>
        </td>
      </tr>
      <tr>
        <td></td>
        <td align="center">
            <a class="btn btn-warning" href="javascript:void(0);" onClick="AddImage();">Add More</a>
          <button class="btn btn-success" name="submit" type="submit">Upload All</button>
            <button class="btn btn-danger" name="reset" type="reset">Reset</button>
        </td>
      </tr>
    </table>

  </form>

<script type="text/javascript">
    function AddImage(){
        var inputDiv = $("#imageInputDiv");

        inputDiv.append('<p style="border:1px solid #eee; padding:15px;"> <input class="form-control" type="file" required name="product_photo[]" ><br> <input class="form-control" type="text" required name="product_cap[]" placeholder="Caption for this Photo/Video"><br> </p>');


    }
</script>

  <?php
}


public function UpdateProductPhoto($pid){

  $existing_photos[] = Capsule::table('mod_shippingmodule_products')->where("product", "=", $_GET['pid'])->value('photo');

  $target_dir = "../modules/addons/shippingmodule/product_images/";

  $uploadOk = 1;
  $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

  $caption_all = $_POST["product_cap"];
  $images_all = $_FILES["product_photo"];
  $image_types = [ 'image/png', 'image/jpg' , 'image/gif' , 'image/bmp' , 'image/jpeg' , 'video/mp4' , 'video/ogg' , 'video/quicktime' , 'video/webm'];

    $i=0;
    foreach($_FILES["product_photo"]['name'] as $image)
    {

        $timestamp = date('HisdmY');
        $target_file = $timestamp. basename($_FILES["product_photo"]["name"][$i]);
        $target_path = $target_dir .$target_file;

        if(!in_array($_FILES["product_photo"]['type'][$i],$image_types) || $_FILES["product_photo"]['size'][$i] > 50000000 || file_exists($target_path))
        {
           $_SESSION['error'] .= $_FILES["product_photo"]['name'][$i]." is not a valid image/video file <br>";
            $i++;
            continue;

        }
        else{

            if (move_uploaded_file($_FILES["product_photo"]["tmp_name"][$i], $target_path)) {
               // echo "The file ". htmlspecialchars( basename($image["name"])). " has been uploaded.";

                array_push($existing_photos, $target_file."|local|".$caption_all[$i]);

            } else {
                $_SESSION['error'] .= "<br>Sorry, there was an error uploading your file.";
            }

        }

        $i++;
    }


$images_uploaded = implode(',' , $existing_photos);

  try {
        $updatedUserCount = Capsule::table('mod_shippingmodule_products')
            ->where('product', $_GET['pid'])
            ->update(
                [
                    'photo' => $images_uploaded,

                ]
            );

        echo "Updated {$updatedUserCount} Product Photo";
    } catch (\Exception $e) {
      $_SESSION['error'] .= "<br>I couldn't update product. {$e->getMessage()}";
      }

  header("Location: addonmodules.php?module=shippingmodule&view=manageProduct&pid=".$_GET['pid']);

}



public function getFileTypes($files_array){



    $image_types = [ 'png', 'jpg' , 'bmp' , 'jpeg' , 'gif' , 'PNG', 'JPG' , 'BMP' , 'JPEG' , 'GIF'];
    $video_types = [ 'mp4' , 'ogv' , 'ogg' , 'quicktime' , 'webm' , 'flv' , 'MP4' , 'OGV' , 'OGG' , 'QUICKTIME' , 'WEBM' , 'FLV' ,];

    $files = array(
        'photos' => array(),
        'videos' => array(),
        'others' => array(),
    );

    $newIMG_array = array_filter($files_array);

    foreach($newIMG_array as $file)
    {

        $filedata = explode('|',$file);

        $ext = pathinfo($filedata[0], PATHINFO_EXTENSION);

        if(in_array($ext,$image_types))
        {
            array_push($files['photos'] , $file);
        }

        if(in_array($ext,$video_types))
        {
            array_push($files['videos'] , $file);
        }

        if(!in_array($ext,$video_types) && !in_array($ext,$image_types))
        {
            array_push($files['others'] , $file);
        }

    }

        return $files;
}

public function manageLicense(){

?>

<h2>License Manager
<span style="float:right;">
  <a href="addonmodules.php?module=shippingmodule&view=addLicense" class="btn btn-success btn-sm">Add New</a>
<a href="addonmodules.php?module=shippingmodule&view=runCron&type=manual" class="btn btn-warning btn-sm">Check all for Expiry</a>
</span>
</h2>

<br>

<table id="licenses">
  <thead>
    <th>
      Licensee Domain
    </th>
    <th>
      License Key
    </th>
    <th>
      Activated on
    </th>
    <th>
      Expires on
    </th>
    <th>
      Status
    </th>
    <th>
      Action
    </th>

  </thead>

  <tbody>
    <?php
    foreach (Capsule::table('mod_shippingmodule_license')->get() as $licenseinfo) {

     ?>
   <tr>
    <td>
      <?php echo $licenseinfo->license_domain; ?>
    </td>
    <td>
      <?php echo $licenseinfo->license_key; ?>
    </td>
    <td>
      <?php echo $licenseinfo->activated_on; ?>
    </td>
    <td>
      <?php echo $licenseinfo->expiry; ?>
    </td>
    <td>
      <?php echo $licenseinfo->status; ?>
    </td>
    <td>
      <a class="btn btn-warning btn-sm" href="addonmodules.php?module=shippingmodule&view=editLicense&id=<?php echo $licenseinfo->id; ?>">Edit</a>
      <a class="btn btn-danger btn-sm" href="addonmodules.php?module=shippingmodule&view=destroyLicense&id=<?php echo $licenseinfo->id; ?>" onclick="return confirmDelete();">x</a>
    </td>
  </tr>

    <?php
    }
     ?>
  </tbody>
</table>


<script type="text/javascript">
    $(document).ready(function() {
        $('#licenses').DataTable({
          responsive: true

        });
    } );


    function confirmDelete() {
      return confirm("Are you sure to delete?");
    }
    </script>


<?php

}

public function addLicense(){

?>

<h2>Add License</h2>
<form action="addonmodules.php?module=shippingmodule&view=saveLicense" method="post">
<table class="table">
<tr>
<td>Licensee Domain</td>
<td>
<input type="text" name="license_domain" class="form-control" placeholder="Enter Licensed Domain" />
</td>
</tr>

<tr>
<td>Expire After (Days)</td>
<td>
<input type="number" name="expiry_days" class="form-control" placeholder="Enter Number of Days after which License will expire" />
</td>
</tr>

<tr>
<td>Status</td>
<td>
<select class="form-control" name="status">
  <option value="active">Active</option>
  <option value="inactive">Inactive</option>
</select>
</td>
</tr>

<tr>
<td></td>
<td>
<button type="submit" class="btn btn-success btn-md">Generate License Key</button>
<a class="btn btn-info btn-md" href="addonmodules.php?module=shippingmodule&view=manageLicense">Go Back</a>
</td>
</tr>


</table>
</form>


  <?php
}


public function saveLicense(){

  $chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
  $res = "";
  for ($b = 0; $b < 25; $b++) {
      $res .= $chars[mt_rand(0, strlen($chars)-1)];
  }

      $days = $_POST['expiry_days'] +1;

      $license_key = date('HisdmY').$res;
      $domain = $_POST['license_domain'];
      $expiry = date('Y-m-d', strtotime("+".$days." day"));;
      $status = $_POST['status'];
      $activated = date('Y-m-d');





              try {

                Capsule::table('mod_shippingmodule_license')->insert(
                            [
                                'license_key' => $license_key,
                                'license_domain' => $domain,
                                'activated_on' => $activated,
                                'expiry' => $expiry,
                                'status' => $status,

                            ]
                        );

                header("Location: addonmodules.php?module=shippingmodule&view=manageLicense");
              } catch (\Exception $e) {
                echo "Uh oh! It didn't work, but I was able to rollback. {$e->getMessage()}";
            }

}


public function editLicense($vars){

  $id = $vars['id'];

  $license = Capsule::table('mod_shippingmodule_license')->where("id", "=", $id)->get();
  ?>

  <h2>Edit License</h2>
  <form action="addonmodules.php?module=shippingmodule&view=updateLicense&id=<?php echo $id; ?>" method="post">
  <table class="table">
  <tr>
  <td>Licensee Domain</td>
  <td>
  <input type="text" name="license_domain" class="form-control" value="<?php echo $license[0]->license_domain; ?>" placeholder="Enter Licensed Domain" />
  </td>
  </tr>

  <tr>
  <td>Expire</td>
  <td>
  <input type="date" name="expiry" class="form-control" value="<?php echo $license[0]->expiry; ?>" />
  </td>
  </tr>

  <tr>
  <td>Status</td>
  <td>
  <select class="form-control" name="status">
    <option <?php if($license[0]->status == "active") { echo 'selected'; } ?> value="active">Active</option>
    <option <?php if($license[0]->status == "inactive") { echo 'selected'; } ?> value="inactive">Inactive</option>
  </select>
  </td>
  </tr>

  <tr>
  <td></td>
  <td>
  <a href="addonmodules.php?module=shippingmodule&view=reGenerateLicense&id=<?php echo $id; ?>" class="btn btn-danger btn-md">Re-Generate License Key</a>
  <button class="btn btn-success btn-md" type="submit">Update License Info</button>
<a class="btn btn-info btn-md" href="addonmodules.php?module=shippingmodule&view=manageLicense">Go Back</a>
  </td>
  </tr>


  </table>
  </form>


    <?php
}


public function updateLicense($vars){

  $id = $vars['id'];
  $domain = $_POST['license_domain'];
  $expiry = $_POST['expiry'];
  $status = $_POST['status'];

    try {
        $updatedUserCount = Capsule::table('mod_shippingmodule_license')
            ->where('id', $id)
            ->update(
                [
                    'license_domain' => $domain,
                    'expiry' => $expiry,
                    'status' => $status,
                ]
            );

        echo "Updated {$updatedUserCount} License";
    } catch (\Exception $e) {
      echo "I couldn't update License. {$e->getMessage()}";
      }

      header("Location: addonmodules.php?module=shippingmodule&view=manageLicense");

}

public function destroyLicense($vars){

  $id = $vars['id'];

  try {
      Capsule::table('mod_shippingmodule_license')
          ->where('id', '=', $id)
          ->delete();


  } catch(\Illuminate\Database\QueryException $ex){
      echo $ex->getMessage();
  } catch (Exception $e) {
      echo $e->getMessage();
  }

  header("Location: addonmodules.php?module=shippingmodule&view=manageLicense");




}


public function reGenerateLicense($vars){


  $chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
  $res = "";
  for ($b = 0; $b < 25; $b++) {
      $res .= $chars[mt_rand(0, strlen($chars)-1)];
  }

  $license_key = date('HisdmY').$res;
  $id = $vars['id'];

  try {
      $updatedUserCount = Capsule::table('mod_shippingmodule_license')
          ->where('id', $id)
          ->update(
              [
                  'license_key' => $license_key,
              ]
          );

      echo "Re-Generated {$updatedUserCount} License Key";
  } catch (\Exception $e) {
    echo "I couldn't Re-Generate License Key. {$e->getMessage()}";
    }

    header("Location: addonmodules.php?module=shippingmodule&view=manageLicense");

}


public function runCron($vars){

  $type = $vars['type'];


  foreach(Capsule::table('mod_shippingmodule_license')->get() as $licenseinfo){


    $id = $licenseinfo->id;
    $expiry = $licenseinfo->expiry;
    $date = date('Y-m-d');


    if($date > $expiry)
    {

      try {
          $updatedUserCount = Capsule::table('mod_shippingmodule_license')
              ->where('id', $id)
              ->update(
                  [
                      'status' => 'expired',
                  ]
              );

          echo "Updated {$updatedUserCount} License";
      } catch (\Exception $e) {
        echo "I couldn't update License. {$e->getMessage()}";
        }


    }



  }

  if($type == "manual"){

    header("Location: addonmodules.php?module=shippingmodule&view=manageLicense");
  }


}




public function Documentation(){

    ?>
    <h2>Documentation</h2>


    <ul>
        <li>1. Shipping Countries</li>
        <li>2. Manage Products</li>
        <li>3. Manage Order Tracking</li>
        <li>4. Settings</li>
    </ul>



<div id="accord">
<h3>1. Shipping Countries</h3>
  <div>
    <p>
                You can enable countries where you ship products. You can find all the countries available in this section.
                <h3>1.1 How to enable a Country?</h3>
                <ul>
                    <li>Go to "Shipping Coutnries" (from Addon Sidebar) or "Enable/Disable Country" (from Addon Dashboard) <br> <img src="../modules/addons/shippingmodule/img/docs/1.jpg" /> <br> </li>
                    <li>Lookup for the country you want to Enable for Shipping. You can use the search form as well. Once you find it Click "Enable" under Action column <br> <img src="../modules/addons/shippingmodule/img/docs/2.jpg" /> <br>  </li>
                    <li>Now the enabled country will appear in Shipping Form during checkout</li>
                </ul>
            </p>
  </div>
  <h3>2. Manage Products</h3>
  <div>
    <p>
                You can also enable the products you would like to ship and leave the virtual products disabled. Shipping form will apeear to only those who will have shipping enabled products in their cart. You can also add Photos and Videos of the product which will appear in the store for users to see what they are buying. You can also set separate shipping rates for each product for each country. You can set Flat Country Shipping rate or You can also define Zip or Postal Code ranges.

                <h3>2.1 How to make a Product Shipping Enabled</h3>
                <ul>
                    <li>Go to "Manage Products" (from addon sidebar or dashbaord)<br> <img src="../modules/addons/shippingmodule/img/docs/3.jpg" /> <br> </li>
                    <li>Seach for your desired product using the search form and Click "Enable" in Action Column<br> <img src="../modules/addons/shippingmodule/img/docs/4.jpg" /> <br> </li>
                </ul>

                <h3>2.2 How to Set Shipping rates of a Product?</h3>
                <p>
                    <ul>
                        <li>After Enabling Shipping of a product a "Manage" butom will appear, Click it to Manage the product<br> <img src="../modules/addons/shippingmodule/img/docs/5.jpg" /> <br> </li>
                        <li>On Product Page Click "Manage Shipping Rates"<br> <img src="../modules/addons/shippingmodule/img/docs/6.jpg" /> <br> </li>
                        <li>All the Enabled countries will apear on "Manage Shipping" Page, You can manage Country's Flat rate as well as its Zip or Postal Code ranges</li>
                        <li>Click on "Manage" in Flat Rate Column of desired Country to set its Flat Shipping Rate<br> <img src="../modules/addons/shippingmodule/img/docs/7.jpg" /> <br> </li>
                        <li>On Flat Shipping Rate page you can view the current Flat rate, Click "Edit Flat Rate" to edit its flat shipping rate<br> <img src="../modules/addons/shippingmodule/img/docs/8.jpg" /> <br> </li>
                        <li>Enter the "Flat Shipping" rate in the form on Edit Flat Shipping Rate page. It will be saved in your default currency and will convert automatically to user's currency.<br> <img src="../modules/addons/shippingmodule/img/docs/9.jpg" /> <br> </li>
                        <li>To set Zip or Postal Code ranges, Go to "Manage Shipping Rates" on "Manage Product" Page<br> <img src="../modules/addons/shippingmodule/img/docs/6.jpg" /> <br> </li>
                        <li>Click on "Manage" under "Zip Code Ranges &amp; Charges" column.<br> <img src="../modules/addons/shippingmodule/img/docs/10.jpg" /> <br> </li>
                        <li>Manage Zip or Postal Code Ranges page will now appear, You can click add new to add new range<br> <img src="../modules/addons/shippingmodule/img/docs/11.jpg" /> <br> </li>
                        <li>You can set a Starting Range and Ending Range along with its Shipping Rate. All the ranges in between will be charged with the rate you set here. e.g Tuscon, Arizona, USA have the zip codes from 85701-85775<br> <img src="../modules/addons/shippingmodule/img/docs/12.jpg" /> <br> </li>
                    </ul>
                </p>

                <h3>2.3 How to add Photos and Videos to any Product?</h3>
                <p>
                    <ul>
                        <li>You can click on "Upload Product Images/Videos" button on Manage Product page <br> <img src="../modules/addons/shippingmodule/img/docs/13.jpg" /> <br> </li>
                        <li>You can browse and select file, also you can add more files using "Add More" button and select files. You can select any JPG, PNG, GIF, BMP image, also you can add any mp4, ogg, webm or quicktime video<br> <img src="../modules/addons/shippingmodule/img/docs/14.jpg" /> <br> </li>
                        <li>After selecting adding and selecting files you can click "Upload All" button to upload Images and Videos<br> <img src="../modules/addons/shippingmodule/img/docs/15.jpg" /> <br> </li>
                    </ul>

                </p>
            </p>
  </div>
  <h3>3. Manage Order Tracking</h3>
  <div>
    <p>
                You can manage orders for products that needs shipping from inside the addon and update their Tracking Info including Shipping Company, Tracking URL, Status and Tracking Number

                <h3>3.1 How to update tracking info of an order?</h3>
                <ul>
                    <li>Go to Manage Order Tracking (from addon sidebar or dashboard)<br> <img src="../modules/addons/shippingmodule/img/docs/16.jpg" /> <br> </li>
                    <li>All the order will be listed on Manage order Tracking page. You can also search for an order to find any particular order. Click on "Update Tracking Info" button under Action Column to update tracking info of an order<br> <img src="../modules/addons/shippingmodule/img/docs/17.jpg" /> <br> </li>
                    <li>You can fill the form accordingly and click "Update Order Tracking Info"<br> <img src="../modules/addons/shippingmodule/img/docs/18.jpg" /> <br> </li>
                    <li>Tracking Status will apeear in User's Client Area. Users can click on Track Order which will take them to Shipping Company Website for Tracking<br> <img src="../modules/addons/shippingmodule/img/docs/19.jpg" /> <br> </li>
                </ul>
            </p>
  </div>
  <h3>4. Settings</h3>
  <div>
    <p>
                <br> <center><img src="../modules/addons/shippingmodule/img/docs/20.jpg" /> </center><br>
                You can setup addons settings in WHMCS on Addon Modules page.
                <ul>
                    <li>You can select your desired Shipping Type which depends on how you want to calculate the shipping charges</li>
                    <li>You can set "Flat Shipping Rate for All" which overrites flat shipping for all products in all countries, You can enable this from shipping type</li>
                    <li>You can Choose a checkout type. Some themes of WHMCS now support one page checkout this option will help you integrate the Shipping module to all themes without any hassle</li>
                </ul>

            </p>
  </div>
</div>



<style>
    h2{
        font-size: 20px;
    font-weight: bold;
    text-decoration: underline;
    }

    li{
        font-weight: bold;
        color: red;
    }

    h3{
/*        text-decoration: underline;*/
    }

    img{
        max-width: 800px;
        border-radius: 5px;
    }

    p{
        padding:15px;
    }
    .ui-accordion .ui-accordion-content{
        max-height: 500px;
        min-height: 500px;
    }

</style>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<style>
@import url('https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css');
</style>
<script type="text/javascript">

  $( function() {
    $( "#accord" ).accordion();
  } );

</script>


    <?php
}


// NEW REVISION

public function massSaveAddQuantityRate(){


  $countries = $_POST['country'];


  $limit = sizeof($countries);

  foreach($countries as $country)
  {

    $this->updateAddQuantityRate($country);

  }

  header("Location: addonmodules.php?module=shippingmodule&view=manageCountries&pid=".$_GET['pid']);





}

public function massManageAddQuantityRate(){


    $product_name = Capsule::table('tblproducts')->where("id", "=", $_GET['pid'])->value('name');

    $country_name = Capsule::table('mod_shippingmodule_country')->where("id", "=", $_GET['country'])->value('country');

    $string = file_get_contents("../resources/country/dist.countries.json");
    $countries = json_decode($string, true);

    $product_id = $_GET['pid'];
    $country = $_GET['country'];


    $getRate = Capsule::table('mod_shippingmodule_additional_rates')
                ->where("product_id", "=", $product_id)
                ->where("country", "=", $country)
                ->first();
    $getRate = (array) $getRate;
    if(isset($getRate['id']))
    {
      $rate_type = $getRate['rate_type'];
      $value = $getRate['value'];
    }


  ?>
  <h2>Manage Additional Quantity Rate for <?php echo $countries[$country_name]['name']; ?> (<?php echo $product_name; ?>)
    <span style="float:right;">
      <a href="addonmodules.php?module=shippingmodule&view=manageCountries&pid=<?php echo $_GET['pid']; ?> " class="btn btn-warning btn-sm">All Countries</a>
      <a href="addonmodules.php?module=shippingmodule&view=manageProduct&pid=<?php echo $_GET['pid'];; ?>" class="btn btn-info btn-sm">Back to Manage Product</a>
  </h2>

  <form action="addonmodules.php?module=shippingmodule&view=massSaveAddQuantityRate&pid=<?php echo $_GET['pid']; ?>" method="post">
  <table class="table">
    <tr>
      <td>
        Select Multiple Countries
      </td>
      <td>
        <select multiple style="height:250px;" class="form-control" id="selC" required name="country[]">
          <?php

          $string = file_get_contents("../resources/country/dist.countries.json");
          $countries = json_decode($string, true);

          foreach(Capsule::table('mod_shippingmodule_country')->where("status", "=", 1)->get() as $country)
          {


          ?>
              <option value="<?php echo $country->id; ?>"><?php echo $countries[$country->country]['name']; ?></option>

            <?php
          }
           ?>
        </select>

      </td>
    </tr>
  <tr>
    <td style="min-width:100px;">Rate Type</td>
    <td>
      <select class="form-control" name="rate_type">
      <?php
      foreach (Capsule::table('mod_shippingmodule_rates_types')->get() as $rate) {
          ?>
            <option <?php if($rate_type == $rate->id){ echo 'selected'; } ?> value="<?php echo $rate->id; ?>"><?php echo $rate->rate_type; ?></option>
          <?php
      }
       ?>
       </select>
       <em style="font-size:12px;">
         <b>Percentage Type:</b> Percentage is of total original shipping cost
       </em>
    </td>
  </tr>

    <tr>
    <td>Rate Value</td>
    <td>
      <?php $curr = Capsule::table('tblcurrencies')->where("default", "=", 1)->get(); ?>

      <input style="display:inline-block; width:90%;" type="number" name="rate_value" class="form-control" value="<?php echo $value; ?>" />
      <br>
      <em style="font-size:12px;">
        Rate will be saved in your default currency (<?php echo $curr[0]->suffix; ?>) and will be automatically converted to other currencies at the time of checkout if you are using multiple currencies and your client chooses another currency for checkout.
      </em>
    </td>
    </tr>

    <tr>
    <td></td>
    <td>
      <input type="submit" class="btn btn-success" value="Update" />
    </td>
    </tr>


  </table>


  </form>



  <?php



}


public function AddVideos(){
  ?>
  <h2>Update Product Photo <span style="float:right;"> <a href="addonmodules.php?module=shippingmodule&view=manageCountryShipping&pid=<?php echo $_GET['pid']; ?>" class="btn btn-success btn-sm">All Countries</a>
    <a href="addonmodules.php?module=shippingmodule&view=manageProduct&pid=<?php echo $_GET['pid']; ?>" class="btn btn-info btn-sm">Back to Manage Product</a>
  </span></h2>
  <form action="addonmodules.php?module=shippingmodule&view=UpdateVideoURL&pid=<?php echo $_GET['pid']; ?>" method="post" enctype="multipart/form-data">
      <table class="table">
      <tr>
        <td>
          Product
        </td>
        <td>
          <?php $product_name = Capsule::table('tblproducts')->where("id", "=", $_GET['pid'])->value('name');
            echo $product_name;?>
        </td>
      </tr>
      <tr>
        <td>
          Video Type<br>Select Video Type

        </td>
        <td id="imageInputDiv">
            <select name="video_type" class="form-control" onchange="ShowVideoInput(this.value);">
              <option value="youtube">Youtube</option>
              <option value="vimeo">Vimeo</option>
              <option value="html5video">Direct Video URL</option>
            </select>
        </td>
      </tr>

      <tr>
        <td id="videolabel">
          Video ID<br>e.g. https://www.youtube.com/watch?v=<b>61YIZkGDDME</b>
          <br> Text in Bold is ID
        </td>
        <td id="imageInputDiv">
            <input class="form-control" type='text' required name="video_url" ><br>
        </td>
      </tr>
      <tr>
        <td id="videolabel">
          Video Caption
        </td>
        <td id="imageInputDiv">
            <input class="form-control" type='text' required name="video_cap" placeholder="Caption for this Video" ><br>
        </td>
      </tr>

      <tr>
        <td></td>
        <td align="center">
          <button class="btn btn-success" name="submit" type="submit">Add Video</button>
        </td>
      </tr>
    </table>

  </form>

<script type="text/javascript">

    function ShowVideoInput(type){
      if(type == 'youtube')
      {
        $('#videolabel').html("Video ID<br>e.g. https://www.youtube.com/watch?v=<b>61YIZkGDDME</b><br> Text in Bold is ID");
      }
      if(type == 'vimeo')
      {
        $('#videolabel').html("Video ID<br>e.g. https://vimeo.com/<b>117135392</b><br> Text in Bold is ID");
      }
      if(type == 'html5video')
      {
        $('#videolabel').html("Video URL<br>e.g. https://example.com/anyfolder/video.mp4");

      }

    }


</script>

  <?php



}


public function UpdateVideoURL(){

  $existing_photos[] = Capsule::table('mod_shippingmodule_products')->where("product", "=", $_GET['pid'])->value('photo');

  $video_type = $_POST["video_type"];
  $video_url = $_POST["video_url"];
  $video_cap = $_POST["video_cap"];



  $target_file = $video_url."|".$video_type."|".$video_cap;

  array_push($existing_photos, $target_file);

  $images_uploaded = implode(',' , $existing_photos);


  try {
        $updatedUserCount = Capsule::table('mod_shippingmodule_products')
            ->where('product', $_GET['pid'])
            ->update(
                [
                    'photo' => $images_uploaded,

                ]
            );

        echo "Added {$updatedUserCount} Video with URL";
    } catch (\Exception $e) {
      echo "I couldn't update product. {$e->getMessage()}";
      }

  header("Location: addonmodules.php?module=shippingmodule&view=manageProduct&pid=".$_GET['pid']);



}




}
