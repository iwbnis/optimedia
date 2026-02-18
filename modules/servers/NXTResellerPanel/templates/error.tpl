<h2>Oops! Something went wrong.</h2>

<div class="alert alert-danger">
    <p>ERROR: {$usefulErrorHelper}</p>
</div>

<p>Please go back and try again.</p>

<p>If the problem persists, please contact support.</p>

 <div class="row" style="margin-top: 15px;">
        <div class="col-sm-8"></div> 
        <div class="col-sm-4">
            <form method="post" action="clientarea.php?action=productdetails&id={$serviceid}">
                <input type="hidden" name="id" value="{$serviceid}" />
                <input type="hidden" name="customAction" value="overview" />
                <button type="submit" class="btn btn-default btn-block overview_btn_new">
                    <i class="fa fa-arrow-circle-left"></i>
                    Back to Overview
                </button>
            </form>
        </div>
    </div> 
