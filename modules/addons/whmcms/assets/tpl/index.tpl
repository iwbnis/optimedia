<div class="row">
    <div class="col-lg-12 text-center">
        <h2 class="text-center h3">Welcome to WHMCMS</h2>
        <p>This page will help you to check and troubleshoot the integration status of your installation of WHMCMS, if you don't see both "Needing Attention" and "Warnings" sections below, it means that your WHMCMS installed and configured properly, if that is the case then start browsing all the sections above to know what WHMCMS can offer to you.</p>
    </div>
</div>

<div class="clearline"></div>

{if count($integration.errors) > 0}
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-danger integration-panel integration-panel-danger">
            <div class="panel-heading">
                <h4 class="panel-title">Needing Attention</h4>
            </div>
            <div class="panel-body">
                {foreach $integration.errors as $error}
                <div class="panel panel-default">
                    <div class="panel-body">
                        <h6>{$error.title}</h6>
                        <p>{$error.description}</p>
                    </div>
                </div>
                {/foreach}
            </div>
        </div>
    </div>
</div>

<div class="clearline"></div>
{/if}

{if count($integration.warnings) > 0}
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-warning integration-panel integration-panel-warning">
            <div class="panel-heading">
                <h4 class="panel-title">Warnings</h4>
            </div>
            <div class="panel-body">
                {foreach $integration.warnings as $warning}
                <div class="panel panel-default">
                    <div class="panel-body">
                        <h6>{$warning.title}</h6>
                        <p>{$warning.description}</p>
                    </div>
                </div>
                {/foreach}
            </div>
        </div>
    </div>
</div>

<div class="clearline"></div>
{/if}

{if count($integration.successful) > 0}
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-info integration-panel integration-panel-info">
            <div class="panel-heading">
                <h4 class="panel-title">Successful Checks</h4>
            </div>
            <div class="panel-body">
                {foreach $integration.successful as $successful}
                <div class="panel panel-default">
                    <div class="panel-body">
                        <h6>{$successful.title}</h6>
                        <p>{$successful.description}</p>
                    </div>
                </div>
                {/foreach}
            </div>
        </div>
    </div>
</div>
{/if}