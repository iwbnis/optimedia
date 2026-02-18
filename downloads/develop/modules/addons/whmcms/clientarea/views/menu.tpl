{* Menu Level #1 *}
<ul {if $menu.css_id!=''}id="{$menu.css_id}"{/if} class="nav navbar-nav{if $menu.css_class!=''} {$menu.css_class}{/if}">
{foreach from=$menu.level1 key=menulevel1 item=level1}
    {if $level1.private==true && $level1.condition==true}
    <li {if $level1.css_id!=''}id="{$level1.css_id}"{/if} class="{if $level1.level2!='0'}dropdown{/if}{if $level1.css_classes!=''} {$level1.css_classes}{/if}">
        <a {if $level1.level2!='0'}class="dropdown-toggle" data-toggle="dropdown" href="#"{else}href="{$level1.targeturl}" target="{$level1.target}"{/if}>
            {if $level1.css_iconclass!=''}<i class="{$level1.css_iconclass}"></i>&nbsp;{/if}
            {$level1.title}
            {if $level1.badge>0}&nbsp;<span class="badge">{$level1.badge}</span>{/if}
            {if $level1.level2!='0'}&nbsp;<b class="caret"></b>{/if}
        </a>
        {if $level1.level2!='0'}
            {* Menu Level #2 *}
            <ul class="dropdown-menu{if $level1.css_submenuclass!=''} {$level1.css_submenuclass}{/if}">
            {foreach from=$level1.level2 key=menulevel2 item=level2}
                {if $level2.private==true && $level2.condition==true}
                    <li {if $level2.css_id!=''}id="{$level2.css_id}"{/if} {if $level2.css_classes!=''}class="{$level2.css_classes}"{/if}>
                        <a href="{$level2.targeturl}" target="{$level2.target}">
                            {if $level2.css_iconclass!=''}<i class="{$level2.css_iconclass}"></i>&nbsp;{/if}
                            {$level2.title}
                            {if $level2.badge>0}&nbsp;<span class="badge">{$level2.badge}</span>{/if}
                        </a>
                        {if $level2.level3!='0'}
                            {* Menu Level #3 *}
                            <ul {if $level2.css_submenuclass!=''}class="{$level2.css_submenuclass}"{/if}>
                            {foreach from=$level2.level3 item=level3 key=menulevel3}
                                {if $level3.private==true && $level3.condition==true}
                                    <li {if $level3.css_id!=''}id="{$level3.css_id}"{/if} {if $level3.css_classes!=''}class="{$level3.css_classes}"{/if}>
                                        <a href="{$level3.targeturl}" target="{$level3.target}">
                                            {if $level3.css_iconclass!=''}<i class="{$level3.css_iconclass}"></i>&nbsp;{/if}
                                            {$level3.title}
                                            {if $level3.badge>0}&nbsp;<span class="badge">{$level3.badge}</span>{/if}
                                        </a>
                                        {if $level3.level4!='0'}
                                            {* Menu Level #4 *}
                                            <ul {if $level3.css_submenuclass!=''}class="{$level3.css_submenuclass}"{/if}>
                                            {foreach from=$level3.level4 item=level4 key=menulevel4}
                                                {if $level4.private==true && $level4.condition==true}
                                                    <li {if $level4.css_id!=''}id="{$level4.css_id}"{/if} {if $level4.css_classes!=''}class="{$level4.css_classes}"{/if}>
                                                        <a href="{$level4.targeturl}" target="{$level4.target}">
                                                            {if $level4.css_iconclass!=''}<i class="{$level4.css_iconclass}"></i>&nbsp;{/if}
                                                            {$level4.title}
                                                            {if $level4.badge>0}&nbsp;<span class="badge">{$level4.badge}</span>{/if}
                                                        </a>
                                                    </li>
                                                {/if}
                                            {/foreach}
                                            </ul>
                                        {/if}
                                    </li>
                                {/if}
                            {/foreach}
                            </ul>
                        {/if}
                    </li>
                {/if}
            {/foreach}
            </ul>
        {/if}
    </li>
    {/if}
{/foreach}
</ul>

