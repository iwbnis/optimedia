{* Menu Level #1 *}
{*<ul {if $menu.css_id}id="{$menu.css_id}"{/if} class="nav navbar-nav{if $menu.css_class} {$menu.css_class}{/if}">*}
	{foreach from=$items item=level1}
    <li {if $level1.css_id}id="{$level1.css_id}"{/if} class="{if $level1.childrens}dropdown{/if}{if $level1.css_classes} {$level1.css_classes}{/if}">
        <a {if $level1.childrens}class="dropdown-toggle" data-toggle="dropdown" href="#"{else}href="{$level1.url}" target="{$level1.target}"{/if}>
            {if $level1.css_iconclass!=''}<i class="{$level1.css_iconclass}"></i>&nbsp;{/if}
            {$level1.title}
            {if $level1.badge}&nbsp;<span class="badge">{$level1.badge}</span>{/if}
            {if $level1.childrens}&nbsp;<b class="caret"></b>{/if}
        </a>
        {if $level1.childrens}
            {* Menu Level #2 *}
            <ul class="dropdown-menu{if $level1.css_submenuclass} {$level1.css_submenuclass}{/if}">
            	{foreach from=$level1.childrens item=level2}
                {if in_array($level2.title, ["-----", "------", "Divider"])}
                <li class="nav-divider{if $level2.css_classes} {$level2.css_classes}{/if}" {if $level2.css_id}id="{$level2.css_id}"{/if}></li>
                {continue}
                {/if}
                <li {if $level2.css_id}id="{$level2.css_id}"{/if} {if $level2.css_classes}class="{$level2.css_classes}"{/if}>
                    <a href="{$level2.url}" target="{$level2.target}">
                        {if $level2.css_iconclass}<i class="{$level2.css_iconclass}"></i>&nbsp;{/if}
                        {$level2.title}
                        {if $level2.badge}&nbsp;<span class="badge">{$level2.badge}</span>{/if}
                    </a>
                    {if $level2.childrens}
                        {* Menu Level #3 *}
                        <ul {if $level2.css_submenuclass}class="{$level2.css_submenuclass}"{/if}>
                            {foreach from=$level2.childrens item=level3}
                            {if in_array($level3.title, ["-----", "------", "Divider"])}
                            <li class="nav-divider{if $level3.css_classes} {$level3.css_classes}{/if}" {if $level3.css_id}id="{$level3.css_id}"{/if}></li>
                			{continue}
                			{/if}
                            <li {if $level3.css_id}id="{$level3.css_id}"{/if} {if $level3.css_classes}class="{$level3.css_classes}"{/if}>
                                <a href="{$level3.url}" target="{$level3.target}">
                            	    {if $level3.css_iconclass}<i class="{$level3.css_iconclass}"></i>&nbsp;{/if}
                                    {$level3.title}
                                    {if $level3.badge}&nbsp;<span class="badge">{$level3.badge}</span>{/if}
                                </a>
                                {if $level3.childrens}
                                    {* Menu Level #4 *}
                                    <ul {if $level3.css_submenuclass}class="{$level3.css_submenuclass}"{/if}>
                            	        {foreach from=$level3.childrens item=level4}
                                        {if in_array($level4.title, ["-----", "------", "Divider"])}
                                        <li class="nav-divider{if $level4.css_classes} {$level4.css_classes}{/if}" {if $level4.css_id}id="{$level4.css_id}"{/if}></li>
                						{continue}
                						{/if}
                                        <li {if $level4.css_id}id="{$level4.css_id}"{/if} {if $level4.css_classes}class="{$level4.css_classes}"{/if}>
                                            <a href="{$level4.url}" target="{$level4.target}">
                                    	        {if $level4.css_iconclass}<i class="{$level4.css_iconclass}"></i>&nbsp;{/if}
                                                {$level4.title}
                                                {if $level4.badge}&nbsp;<span class="badge">{$level4.badge}</span>{/if}
                                            </a>
                                        </li>
                                        {/foreach}
                                    </ul>
                                {/if}
                            </li>
						    {/foreach}
                        </ul>
                    {/if}
                </li>
            	{/foreach}
            </ul>
		{/if}
    </li>
	{/foreach}
{*</ul>*}