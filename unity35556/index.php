<?php
@session_start();

$db = new SQLite3('./api/.db.db');
$db->exec("CREATE TABLE IF NOT EXISTS users(id INTEGER PRIMARY KEY,username TEXT ,password TEXT)");

$log_check = $db->query("SELECT * FROM users WHERE id='1'");
$roe = $log_check->fetchArray();
$loggedinuser = @$roe['username'];

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
	header("location:"."dns.php");
}

$rows = $db->query("SELECT COUNT(*) as count FROM users");
$row = $rows->fetchArray();
$numRows = $row['count'];
if ($numRows == 0){
	$db->exec("INSERT INTO users(id ,username, password) VALUES('1' ,'admin', 'admin')");
	$db->close();
	}

if (isset($_POST["login"])){
	if(!$db){
		echo $db->lastErrorMsg();
	} else {
	}
	$sql ='SELECT * from users where username="'.$_POST["username"].'";';
	$ret = $db->query($sql);
	while($row = $ret->fetchArray() ){
		$id=$row['id'];
		$username=$row['username'];
		$password=$row['password'];
	}
	if ($id!=""){
		if ($password==$_POST["password"]){
			session_regenerate_id();
			$_SESSION['loggedin'] = TRUE;
			$_SESSION['name'] = $_POST['username'];
			if ($_POST['username'] == 'admin'){
				header('Location: user.php');
			}else{
				header('Location: dns.php');
			}
		}else{
		header('Location: ./api/index.php');
		}
		}else{
		header('Location: ./api/index.php');
		}
	$db->close();
	}


////Get User IP
function real_ip() {
	$ip = 'undefined';
	if (isset($_SERVER)) {
		$ip = $_SERVER['REMOTE_ADDR'];
		if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		elseif (isset($_SERVER['HTTP_CLIENT_IP'])) $ip = $_SERVER['HTTP_CLIENT_IP'];
	} else {
		$ip = getenv('REMOTE_ADDR');
		if (getenv('HTTP_X_FORWARDED_FOR')) $ip = getenv('HTTP_X_FORWARDED_FOR');
		elseif (getenv('HTTP_CLIENT_IP')) $ip = getenv('HTTP_CLIENT_IP');
	}
	$ip = htmlspecialchars($ip, ENT_QUOTES, 'UTF-8');
	return $ip;
}

$curr = basename($_SERVER['PHP_SELF']);
$page = substr($curr, 0, 3);


?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FTG</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="./includes/css.css">
	
</head>

<div>
  <div class="starsec"></div>
  <div class="starthird"></div>
  <div class="starfourth"></div>
  <div class="starfifth"></div>
</div>

 <style> 
  table{table-layout: fixed;}
  td{word-wrap:break-word}
  .main{padding-top: 25px;}
</style>
<div class="container text-center text-dark mt-5">
  <div class="row">
    <div class="col-lg-4 d-block mx-auto mt-5">
      <div class="row">
        <div class="col-xl-12 col-md-12 col-md-12">
          <div class="card">
            <div class="card-body wow-bg" id="formBg">
              <h3 class="colorboard">CinemaHD Login</h3>
              <form  method="post">
                <p class="text-muted">Sign In to your account</p>
                <div class="input-group mb-3"> <input type="text" class="form-control textbox-dg" name="username" placeholder="Username"> </div>
                <div class="input-group mb-4"> <input type="password" class="form-control textbox-dg" name="password" placeholder="Password"> </div>
                <div class="row">
                  <div class="col-12"> <button type="submit" name="login" class="btn btn-primary btn-block logn-btn">Login</button> </div>
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
</body>

</html>

