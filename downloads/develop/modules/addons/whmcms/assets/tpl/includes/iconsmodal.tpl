<div id="menuIconModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Choose Icon</h4>
            </div>
            <div class="modal-body">
                <ul class="nav nav-pills" role="tablist">
                    {foreach $icons as $name => $data name=icons}
                    <li role="presentation"{if $smarty.foreach.icons.first} class="active"{/if}><a href="#{$name}" aria-controls="{$name}" role="tab" data-toggle="tab">{$data.Name}</a></li>
                    {/foreach}
                </ul>
                <div class="clearline"></div>
                <!-- Tab panes -->
                <div class="tab-content">
                    {foreach $icons as $name => $data name=icons}
                    <div role="tabpanel" class="tab-pane{if $smarty.foreach.icons.first}  active{/if}" id="{$name}">
                        <p>{$data.Description}</p>
                        <div class="clearline"></div>
                        <div class="resources-icons-list row">
                            {foreach $data.Icons as $icon}
                            <a href="#" class="col-lg-1 resources-icons-list-item" onclick="return setSelectedIcon('{$icon}', '{$data.Prefix}');">
                                {$data.HTMLTemplate|replace:'{#prefix}':$data.Prefix|replace:'{#icon}':$icon}
                            </a>
                            {/foreach}
                        </div>
                    </div>
                    {/foreach}
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>