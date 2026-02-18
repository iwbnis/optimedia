{foreach $navbar as $item}
    <li menuItemName="{$item->getName()}" class="{if $item->hasChildren()}dropdown{/if}{if $item->getClass()} {$item->getClass()}{/if}" id="{$item->getId()}">
        <a {if $item->hasChildren()}class="dropdown-toggle" data-toggle="dropdown" href="#"{else}href="{$item->getUri()}"{/if}{if $item->getAttribute('target')} target="{$item->getAttribute('target')}"{/if}>
            {if $from == 'account'}
                <i class="fas fa-user"></i>
            {else}
                {if $item->hasIcon()}<i class="{$item->getIcon()}"></i>&nbsp;{/if}
                {$item->getLabel()}
                {if $item->hasBadge()}&nbsp;<span class="badge">{$item->getBadge()}</span>{/if}
                {if $item->hasChildren()}&nbsp;<b class="caret"></b>{/if}
            {/if}
        </a>
        {if $item->hasChildren()}
            <ul class="dropdown-menu">
                {if $loggedin && $from == 'account'}
                    <li menuItemName="Profile">
                        <a href="#" class="user-name">
                            {$item->getLabel()}
                            <span>{$clientsdetails.email}</span>
                        </a>
                    </li>
                {/if}
                {foreach $item->getChildren() as $childItem}
                    <li menuItemName="{$childItem->getName()}"{if $childItem->getClass()} class="{$childItem->getClass()}"{/if} id="{$childItem->getId()}">
                        <a href="{$childItem->getUri()}"{if $childItem->getAttribute('target')} target="{$childItem->getAttribute('target')}"{/if}>
                            {if $childItem->hasIcon()}<i class="{$childItem->getIcon()}"></i>&nbsp;{/if}
                            {$childItem->getLabel()}
                            {if $childItem->hasBadge()}&nbsp;<span class="badge">{$childItem->getBadge()}</span>{/if}
                        </a>
                    </li>
                {/foreach}
            </ul>
        {/if}
    </li>
{/foreach}