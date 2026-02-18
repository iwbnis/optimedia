<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">

    <?php if($dtype=="sysupdatereport") { ?>
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
            max-height: 78vh;
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
    <?php } ?>
    <title>Developers Tools</title>
  </head>
  <body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Developers Tools</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link mx-2 rounded <?= $dtype=="logs" ? "active bg-white text-dark": ""; ?>" aria-current="page" href="<?= base_url('debug/logs');?>">Logs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mx-2 rounded <?= $dtype=="dbstructure" ? "active bg-white text-dark": ""; ?>" href="<?= base_url('debug/dbstructure');?>">Database Structure</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mx-2 rounded <?= $dtype=="sysupdatereport" ? "active bg-white text-dark": ""; ?>" href="<?= base_url('debug/sysupdatereport');?>">System Update Report</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


    <section class="container-fluid">
        <?php if(isset($error)) { ?>
            <div class="alert alert-danger" role="alert"><?= $error ?></div>
        <?php } else { ?>
            <?php
                switch ($dtype) {
                    case 'logs':
                        ?>
                        <div id="content">
                            <div class="container-fluid">
                                <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><i class="fa fa-exclamation-triangle"></i></h3>
                                </div>
                                <div class="panel-body">
                                    <textarea wrap="off" rows="15" readonly class="form-control"><?php echo $log; ?></textarea>
                                </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        break;
                    case 'dbstructure':
                        ?>
                        <div id="content">
                            <div class="container-fluid py-2">
                                <?php foreach ($dbstructure as $table => $structure) { ?>
                                    <div class="accordion" id="accordion-dbstructure">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="heading-<?= $table; ?>">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-<?= $table; ?>" aria-expanded="false" aria-controls="collapse-<?= $table; ?>">
                                                <?= $table; ?>
                                            </button>
                                            </h2>
                                            <div id="collapse-<?= $table; ?>" class="accordion-collapse collapse" aria-labelledby="heading-<?= $table; ?>" data-bs-parent="#accordion-dbstructure">
                                                <div class="accordion-body">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <td>Name</td>  
                                                            <td>Type</td>  
                                                            <td>Max Length</td>  
                                                            <td>Default</td>  
                                                            <td>Primary Key</td>  
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php
                                                        foreach ($structure as $str) {
                                                            ?>
                                                            <tr>
                                                                <td><?= $str->name; ?></td>  
                                                                <td><?= $str->type; ?></td>  
                                                                <td><?= $str->max_length; ?></td>  
                                                                <td><?= $str->default; ?></td>  
                                                                <td><?= $str->primary_key; ?></td>  
                                                            </tr>
                                                            <?php
                                                        }
                                                    ?>
                                                    </tbody>
                                                </table>                                                
                                                </div>
                                            </div>
                                        </div>
                                    </div>                                    
                                <?php } ?>
                            </div>
                        </div>
                        <?php
                        break;
                    case 'sysupdatereport':
                        ?>
                        <div id="content">
                            <section class="terminal-container">
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
                    echo "System is updated successfully!";
                } else {
                    if(isset($already_latest_version)) {
                        echo "System is already updated to latest version!";
                    } else {
                        echo "Something went wrong while upgrading system!";
                    }
                }
                ?>
            </div>
        </div>
      </div>
    </section>
    <footer class="pb-3" style="position: fixed; bottom:0px; width: 100%; font-weight: bold;">
        Current Version: <?php echo SCRIPT_VERSION;?>       
      </footer>
                        </div>
                        <?php
                        break;
                    default:
                        ?><div class="alert alert-warning" role="alert">Something went wrong, please try again!</div><?php
                        break;
                }
            ?>
        <?php } ?>
    </section>
    <script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>

    <?php if($dtype=="sysupdatereport") { ?>

<script type="text/javascript">
    
    var $container = $('.terminal-home'),
$scrollTo = $('.console:last-child');

// $container.scrollTop(
//     $scrollTo.offset().top - $container.offset().top + $container.scrollTop()
// );

// Or you can animate the scrolling:
$container.animate({
    scrollTop: $scrollTo.offset().top - $container.offset().top + $container.scrollTop()
});
</script>
    <?php } ?>
  </body>
</html>