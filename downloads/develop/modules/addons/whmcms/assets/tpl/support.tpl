<div id="whmcms-support-page" class="well">
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1">
            <div class="row">
                <div class="col-lg-4 text-center">
                    <h4>Updates</h4>
                    <i class="fa fa-sync fa-refresh fa-4x"></i>
                    <p>
                        Keep you installation updated for new features and latest security improvements
                    </p>
                    {if $isuptodate eq "update available"}
                    <a href="http://whmcms.com/link.php?id=12" class="btn btn-sm btn-warning" target="_blank">Update Available</a>
                    {elseif $isuptodate eq "up to date"}
                    <a href="http://whmcms.com/link.php?id=12" class="btn btn-sm btn-success" target="_blank">Up-to-date</a>
                    {else}
                    <a href="http://whmcms.com/link.php?id=12" class="btn btn-sm btn-warning" target="_blank">Check for updates</a>
                    {/if}
                </div>
                <div class="col-lg-4 text-center">
                    <h4>Documentation</h4>
                    <i class="fa fa-book fa-4x"></i>
                    <p>Guides, How Tos and Tutorials to help you get the most of this module</p>
                    <a href="http://whmcms.com/link.php?id=2" class="btn btn-sm btn-default" target="_blank">Read Here</a>
                </div>
                <div class="col-lg-4 text-center">
                    <h4>Found a bug?</h4>
                    <i class="fa fa-bug fa-4x"></i>
                    <p>Tell us how to reproduce the issue and we will get it fixed in no time</p>
                    <a href="http://whmcms.com/link.php?id=3" class="btn btn-sm btn-default" target="_blank">Report here</a>
                </div>
            </div>
            <div class="clearline"></div>
            <br>
            <hr>
            <div class="row">
                <div class="col-lg-4 text-center">
                    <h4>Feature Request</h4>
                    <i class="fa fa-plus-circle fa-4x"></i>
                    <p>We listen to your suggestions, ideas and care about your experince</p>
                    <a href="http://whmcms.com/link.php?id=1" class="btn btn-sm btn-default" target="_blank">Contact Us</a>
                </div>
                <div class="col-lg-4 text-center">
                    <h4>Rate our module</h4>
                    <i class="fa fa-star fa-star-o fa-4x"></i>
                    <p>Do you like how useful this module is? share your experience with everyone</p>
                    <a href="http://whmcms.com/link.php?id=10" class="btn btn-sm btn-default" target="_blank">Rate now</a>
                </div>
                <div class="col-lg-4 text-center">
                    <h4>WHMCS Marketplace</h4>
                    <i class="fa fa-shopping-bag fa-4x"></i>
                    <p>Visit our Marketplace portfolio for high quality WHMCS modules and integrations</p>
                    <a href="http://whmcms.com/link.php?id=11" class="btn btn-sm btn-default" target="_blank">Go to our portfolio</a>
                </div>
            </div>
        </div>
    </div>
</div>