<div class="row">
  <div class="col-sm-12">
    <nav class="navbar navbar-default" role="navigation">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="navbar">
          <ul class="nav navbar-nav">
            <li role="presentation" {if $smarty.get.action eq "index"}class="active"{/if}><a href="{$modulelink}&action=index">Home</a></li>
            <li role="presentation" {if $smarty.get.action eq "tagManager"}class="active"{/if}><a href="{$modulelink}&action=tagManager">Google Tag Manager</a></li>
            <li role="presentation" {if $smarty.get.action eq "googleAnalytics"}class="active"{/if}><a href="{$modulelink}&action=googleAnalytics">Google Analytics</a></li>

          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="#"></a></li>
            <li>
              <a href="https://manage.mimirtech.co/link.php?id=14" target="_blank"><i class="fa fa-book"></i> Manual</a>

            </li>
            <li>
              <a href="https://manage.mimirtech.co/link.php?id=16" target="_blank"><i class="fa fa-question-circle"></i> Get Help</a>

            </li>
            <li>
              <a href="#">Version: {$version}</a>
            </li>
          </ul>
        </div><!-- /.navbar-collapse -->
      </div><!-- /.container-fluid -->
    </nav>
    <hr>
  </div>
</div>
