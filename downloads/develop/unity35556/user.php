<?php 
include ('includes/header.php');

$res = $db->query("SELECT * FROM users WHERE id='1'");
$row=$res->fetchArray();

if(isset($_POST['submit'])){
	$db->exec("UPDATE users SET	username='{$_POST['username']}', password='{$_POST['password']}' WHERE id='1' ");
	session_regenerate_id();
	$_SESSION['loggedin'] = TRUE;
	$_SESSION['name'] = $_POST['username'];
	header("Location: dns.php");
}

?>
<div class="container text-center text-dark mt-5">
  <div class="row">
    <div class="col-lg-4 d-block mx-auto mt-5">
      <div class="row">
        <div class="col-xl-12 col-md-12 col-md-12">
          <div class="card">
            <div class="card-body wow-bg" id="formBg">
              <h3 class="colorboard">Edit User</h3>
              <form  method="post">
                <div class="input-group mb-3"> <input type="text" class="form-control textbox-dg" name="username" value="<?php echo $row['username'] ?>" > </div>
                <div class="input-group mb-4"> <input type="text" class="form-control textbox-dg" name="password" value="<?php echo $row['password'] ?>" > </div>
                <div class="row">
                  <div class="col-12"> <button type="submit" name="submit" class="btn btn-primary btn-block logn-btn">Submit</button> </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include ('includes/footer.php');?>