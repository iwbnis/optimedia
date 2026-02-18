{include file="includes/navbar.tpl"}
{function name=licensestatus level=0}
  {if $data eq 'Invalid'}
    <span class="label label-danger">{$data}</span>
  {elseif $data eq 'Active'}
    <span class="label label-success">{$data}</span>
  {elseif $data eq 'Expired' }
    <span class="label label-default">{$data}</span>
  {elseif $data eq 'Suspended'}
  <span class="label label-warning">{$data}</span>
  {else}
  <span class="label label-info">{$data}</span>
  {/if}

{/function}
<div class="row">
  <div class="col-sm-4">
    <!--col-->
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title text-center">Module Configuration</h3>
      </div>
      <div class="panel-body">
        <div class="row">
          <div class="col-sm-6">
            <img src="data:image/png;base64,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" alt="Google Tag Manager">
          </div>
          <div class="col-sm-6 text-center">
            {if $gtm_container ne ''}
              <p class="h3">{$gtm_container}</p>
            {else}
              <a href="{$modulelink}&action=tagManager" class="btn btn-primary">Configure</a>
            {/if}
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-sm-6">
            <img src="data:image/png;base64,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" alt="Google Analytics">
          </div>
          <div class="col-sm-6 text-center">
            {if $ga_trackingid ne ''}
              <p class="h3">{$ga_trackingid}<p>
            {else}
            <a href="{$modulelink}&action=googleAnalytics" class="btn btn-primary">Configure</a>
            {/if}
          </div>
        </div>
        <hr>

      </div>
    </div>
    <!--col-->
  </div>
  <div class="col-sm-4 col-sm-offset-4">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title text-center">Module & License Information</h3>
      </div>

      <div class="panel-body">
        <div class="table-responsive">
          <table class="table">
            <tbody>
              <tr>
                <th scope="col" class="text-right">Version:</th>
                <td>{$version}</td>
              </tr>
              <tr>
                <th scope="col" class="text-right">License Key:</th>
                <td>{$licensekey}</td>
              </tr>
              <tr>
                <th scope="col" class="text-right">License Status:</th>
                <td>
                  {licensestatus data=$licenseinfo.status}
                  <button form="refreshLicense" type="submit" class="btn btn-primary btn-xs" alt="refresh license" title="refresh license"><i class="fa fa-sync-alt"></i> Refresh</button>

                </td>
              </tr>
              {* <tr>
                <th scope="col" class="text-right">Registered For:</th>
                <td>{$licenseinfo.registeredname} - {$licenseinfo.email}</td>
              </tr> *}
            </tbody>
          </table>
        </div>
      </div>

    </div>
  </div>
</div>
<form action="addonmodules.php?module=WHMCSGTM&action=refreshLicense" method="post" id="refreshLicense">

</form>
