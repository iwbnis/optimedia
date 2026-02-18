<div id="whmcms">
    <div class="row">
        <div class="col-xs-12">{$content}</div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="panel-group" id="faq_group_{$groupid}" role="tablist" aria-multiselectable="true">
                {foreach $items as $item}
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="item_heading_{$item.itemid}">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#faq_group_{$groupid}" href="#item_answer_{$item.itemid}" aria-expanded="true" aria-controls="item_answer_{$item.itemid}">
                            	{$item.question}
                            </a>
                        </h4>
                    </div>
                    <div id="item_answer_{$item.itemid}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="item_heading_{$item.itemid}">
                        <div class="panel-body">
                        	{$item.answer|stripslashes}
                        </div>
                    </div>
                </div>
                {/foreach}
            </div>
        </div>
    </div>
</div>
