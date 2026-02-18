<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Upgrade Details</title>
	<link href="<?php echo base_url(); ?>assets/vertical/assets/css/bootstrap.min.css?v=<?= av() ?>" rel="stylesheet" type="text/css">
	<style type="text/css">
		
			p.console{font-family: 'Roboto Mono', monospace;}
		header.terminal{background:#E0E8F0;height:30px;border-radius:8px 8px 0 0;padding-left:10px;}
		.terminal-container header .button{width:12px;height:12px;margin:10px 4px 0 0;display:inline-block;border-radius:8px;}.green{background-color: #3BB662 !important;}.red{background-color: #E75448 !important;}
		.yellow{background-color: #E5C30F !important;}
		.terminal-container{text-align:left;width:100%;border-radius:10px;margin:auto;margin-bottom:14px;position:relative;}
		.terminal-fixed-top{margin-top: 30px;}
		.terminal-home{
			background-color: #30353A;
			padding: 1.5em 1em 1em 2em;
			border-bottom-left-radius: 6px;
			border-bottom-right-radius: 6px;
			color: #FAFAFA;
			max-height: 70vh;
			overflow-y: scroll;
		}

		.console.success {
			color: lightgreen;
		}

		.console.error {
			color: red;
		}

		.console.warning {
			color: yellow;
		}
	</style>
<script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
</head>
<body class="p-3">
	<section class="terminal-container terminal-fixed-top">
	  <header class="terminal">
	    <span class="button red"></span>
	    <span class="button yellow"></span>
	    <span class="button green"></span>
	  </header>

	  <div class="terminal-home">					
	  	<?php 
	  	$is_successfully_updated = true;
	  	for ($i=0; $i < sizeof($result); $i++) { 
	  		foreach ($result[$i] as $key => $value) {
	  			if($key == 'error') { 
	  				
	  				if($is_successfully_updated == true && str_contains($value, 'already a latest version'))  {
	  					$already_latest_version = true;
	  				}

	  				$is_successfully_updated = false;
	  			}
	  			echo '<p class="console '.$key.'">'.$value.'</p>';
	  		}
	  	}
	  	?>
	  </div>

	  <div class="row mt-2">
  		<div class="col-12">
  			<div class="text-center alert <?php echo ($is_successfully_updated == true) ? "alert-success" : ((isset($already_latest_version)) ? "alert-info" : "alert-danger"); ?>">
		  		<?php
		  		if($is_successfully_updated == true) {
		  			echo "The system was updated successfully!";
		  		} else {
		  			if(isset($already_latest_version)) {
		  				echo "The system is already updated to the latest version!";
		  			} else {
		  				echo "Something went wrong while upgrading the system!";
		  			}
		  		}
		  		?>
	  		</div>
  		</div>
  		<div class="col-12 text-center">
  			<button class="btn btn-primary btn-lg" onclick="location.replace('dashboard');"><?= __('user.back_to_admin') ?></button>
  		</div>
	  </div>


	  <footer class="pb-3" style="position: fixed; bottom:0px; width: 100%; font-weight: bold;">
		Current Version: <?php echo SCRIPT_VERSION;?>	  	
	  </footer>
	</section>
</body>

<script type="text/javascript">
	
	var $container = $('.terminal-home'),
$scrollTo = $('.console:last-child');

$container.animate({
    scrollTop: $scrollTo.offset().top - $container.offset().top + $container.scrollTop()
});
</script>
</html>