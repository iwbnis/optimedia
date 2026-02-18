<div id="whmcms">
    <div class="row">
        <div class="col-12">{$content}</div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="accordion" id="faq_group_{$groupid}">
                {foreach $items as $item}
                <div class="card mb-0">
                    <div class="card-header" id="item_heading_{$item.itemid}">
                        <h4 class="mb-0">
                            <a role="button" data-toggle="collapse" href="#item_answer_{$item.itemid}" aria-expanded="true" aria-controls="item_answer_{$item.itemid}">
                            	{$item.question}
                            </a>
                        </h4>
                    </div>
                    <div id="item_answer_{$item.itemid}" class="collapse" role="tabpanel" aria-labelledby="item_heading_{$item.itemid}" data-parent="#faq_group_{$groupid}">
                        <div class="card-body">
                        	{$item.answer|stripslashes}
                        </div>
                    </div>
                </div>
                {/foreach}
            </div>
        </div>
    </div>
</div>
