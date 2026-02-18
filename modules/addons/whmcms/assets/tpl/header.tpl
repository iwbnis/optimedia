<nav id="whmcms-navbar" class="navbar navbar-default">
	<div class="container-fluid">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#whmcms-navbar-collapse" aria-expanded="false">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="{$modurl}">
                <img src="../modules/addons/whmcms/assets/img/whmcms-small.png" alt="WHMCMS">
            </a>
		</div>
		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="whmcms-navbar-collapse">
			<ul class="nav navbar-nav">
				{include file="./includes/navbar.tpl"}
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li><a href="https://www.whmcms.com/" target="_blank">by SENTQ</a></li>
			</ul>
		</div><!-- /.navbar-collapse -->
	</div><!-- /.container-fluid -->
</nav>

<div id="whmcms">
    <div class="container-fluid">

        {include file="./includes/breadcrumbs.tpl"}

        {if $system_message}
        <div class="row">
            <div class="col-12">
                <div class="alert alert-dismissible alert-{$system_messagetype}">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    {$system_message}
                </div>
            </div>
        </div>
        {/if}
