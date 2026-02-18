<?php 
include ('includes/header.php');

//table name
$table_name = "dns";

//current file var
$base_file = basename($_SERVER["SCRIPT_NAME"]);

//create if not
$db->exec("CREATE TABLE IF NOT EXISTS {$table_name}(id INTEGER PRIMARY KEY	AUTOINCREMENT  NOT NULL, title VARCHAR(100), url TEXT)");

//table call
$res = $db->query("SELECT * FROM {$table_name}");

//update call
@$resU = $db->query("SELECT * FROM {$table_name} WHERE id='{$_GET['update']}'");
@$rowU=$resU->fetchArray();
if(isset($_POST['submitU'])){
	$db->exec("UPDATE {$table_name} SET title='{$_POST['title']}',url='{$_POST['url']}' WHERE  id='{$_POST['id']}'");
	$db->close();
	header("Location: {$base_file}");
}

//submit new
if (isset($_POST['submit'])){
	$db->exec("INSERT INTO {$table_name}(title, url) VALUES('{$_POST['title']}', '{$_POST['url']}')");
	header("Location: {$base_file}");
	}

//premiumizeme key

$db->exec("CREATE TABLE IF NOT EXISTS key(id INTEGER PRIMARY KEY NOT NULL, api VARCHAR(50))");
$rowsc = $db->query("SELECT COUNT(*) as count FROM key");
$rowk = $rowsc->fetchArray();
$numRowsk = $rowk['count'];
if ($numRowsk == 0){
	$db->exec("INSERT INTO key(id, api) VALUES('1' ,'API Key')");
	}

$resk = $db->query("SELECT * FROM key WHERE id='1'");
$rowK = $resk->fetchArray();

if(isset($_POST['updatek'])){
$db->exec("UPDATE key SET  api='".$_POST['api']."' WHERE id='1'");
$db->close();
header("Location: {$base_file}");
}

//delete row
if(isset($_GET['delete'])){
	$db->exec("DELETE FROM {$table_name} WHERE id={$_GET['delete']}");
	header("Location: {$base_file}");
}

?>
<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content" style="background-color: black;">
			<div class="modal-header">
				<h2 style="color: white;">Confirm</h2>
			</div>
			<div class="modal-body" style="color: white;">
				Do you really want to delete?
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
				<a style="color: white;" class="btn btn-danger btn-ok">Delete</a>
			</div>
		</div>
	</div>
</div>
<?php
if (isset($_GET['create'])){

//create form
?>
<div class="container text-center text-dark mt-5">
  <div class="row">
    <div class="col-lg-4 d-block mx-auto mt-5">
      <div class="row">
        <div class="col-xl-12 col-md-12 col-md-12">
          <div class="card">
            <div class="card-body wow-bg" id="formBg">
              <h3 class="colorboard">Add DNS</h3>
              <form  method="post">
                <div class="input-group mb-3"> <input type="text" class="form-control textbox-dg" name="title" placeholder="Tile"> </div>
                <div class="input-group mb-4"> <input type="text" class="form-control textbox-dg" name="url" placeholder="DNS"> </div>
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
<?php 
}else if (isset($_GET['update'])){ 

//update form
?>
<div class="container text-center text-dark mt-5">
  <div class="row">
    <div class="col-lg-4 d-block mx-auto mt-5">
      <div class="row">
        <div class="col-xl-12 col-md-12 col-md-12">
          <div class="card">
            <div class="card-body wow-bg" id="formBg">
              <h3 class="colorboard">Edit DNS</h3>
              <form  method="post">
                <input type="hidden" name="id" value="<?=$_GET['update'] ?>">
                <div class="input-group mb-3"> <input type="text" class="form-control textbox-dg" name="title" value="<?=$rowU['title'] ?>" > </div>
                <div class="input-group mb-4"> <input type="text" class="form-control textbox-dg" name="url" value="<?=$rowU['url'] ?>" > </div>
                <div class="row">
                  <div class="col-12"> <button type="submit" name="submitU" class="btn btn-primary btn-block logn-btn">Submit</button> </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php
 }else{
//main table/form
	 ?>

	<div class="col-md-12 mx-auto">
		<form  method="post">
			<div class="form-line col-md-4 px-4">
			<div class="form-group">
				<h4 class="colorboard"></i> https://www.premiumize.me/</h4>
				<label class="colorboard">ENTER API KEY</label>
			</div>
		
			<div class="input-group">
			<input type="text" class="form-control" name="api" value="<?php echo $rowK['api'] ?>">
				<span class="input-group-btn">
				<button name="updatek" class="btn btn-warning" type="submit">Submit</button>
				</span>
			</div>
		</div>
		</form>
		<br>
		<hr style="background-color:white">
		<center>
			<h2 class="colorboard"></i> Current DNSs</h2>
			<a id="button" href="./<?php echo $base_file ?>?create" class="btn btn-primary">New DNS</a>
		</center>
		<br>
		<div class="table-responsive">
			<table class="table table-striped table-sm">
			<thead style="color:white!important">
				<tr>
				<th>Index</th>
				<th>Title</th>
				<th>DNS</th>
				<th>Edit&nbsp&nbsp&nbspDelete</th>
				</tr>
			</thead>
			<?php while ($row = $res->fetchArray()) {?>
			<tbody>
				<tr>
				<td><?=$row['id'] ?></td>
				<td><?=$row['title'] ?></a></td>
				<td><?=$row['url'] ?></td>
				<td>
				<a class="btn btn-info btn-ok" href="<?php echo $base_file ?>?update=<?=$row['id'] ?>"><i class="fa fa-pencil-square-o"></i></a>
				&nbsp&nbsp&nbsp
				<a class="btn btn-danger btn-ok" href="#" data-href="<?php echo $base_file ?>?delete=<?=$row['id'] ?>" data-toggle="modal" data-target="#confirm-delete"><i class="fa fa-trash-o"></i></a>
				</td>
				</tr>
			</tbody>
			<?php }?>
			</table>
		</div>
	</div>
<?php }?>

<?php include ('includes/footer.php');?>

</body>
</html>