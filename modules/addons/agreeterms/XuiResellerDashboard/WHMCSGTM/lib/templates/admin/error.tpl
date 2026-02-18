<div class="row">
  <div class="col-sm-12">
    {if $errortype eq 'license'}
    <div class="alert alert-danger">
           <strong>LICENSE ERROR!</strong> Your license is <strong>{$licenseinfo.status}</strong>. Please contact support
    </div>
    {/if}
  </div>
</div>
