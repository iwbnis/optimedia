<?php
@session_start();
$db = new SQLite3('./api/.db.db');
$log_check = $db->query("SELECT * FROM users WHERE id='1'");
$roe = $log_check->fetchArray();
$loggedinuser = $roe['username'];

if ($_SESSION['name'] != $loggedinuser) {
	header("location:"."index.php");
	exit();
}
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

<header class="top-header">
</header>
<div id="mainCoantiner">
  <div class="main-header">
  <br>
      <a class="btn btn-primary" href="./dns.php">DNS</a>
      <a class="btn btn-info" href="./user.php">Change Password</a>
      <a class="btn btn-danger" href="./logout.php">Logout</a>
</div>

<div>
  <div class="starsec"></div>
  <div class="starthird"></div>
  <div class="starfourth"></div>
  <div class="starfifth"></div>
</div>

 <style> 
table{
    table-layout: fixed;
	color: #fff;
}

td{
	color: #fff;
    word-wrap:break-word
}
h2{color: #fff;}
.main{
	color: #fff;
	padding-top: 25px;
}
</style>
<br>