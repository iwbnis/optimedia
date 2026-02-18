<h2>Oops! Something went wrong.</h2>

<div class="alert alert-danger">
    <p>ERROR: {$usefulErrorHelper}</p>
</div>

<p>Please go back and try again.</p>

<p>If the problem persists, please contact support.</p>

<div class="row">
    <div class="col-sm-4">
        <form method="post" action="clientarea.php?action=products"> 
            <input type="hidden" name="customAction" value="devices" />
            <button type="submit" class="btn btn-default btn-block">
                <i class="fa fa-arrow-circle-left"></i>
                Back to Services
            </button>
        </form>
    </div>
</div>
