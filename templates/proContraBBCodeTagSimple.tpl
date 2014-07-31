{$pcTitle}:<br />
---------<br />
{if $pcPoints|empty || ($pcPoints['pro']|empty && $pcPoints['contra']|empty && $pcPoints['neutral']|empty)}
	{lang}wcf.bbcode.proContra.{if $pcContent|empty == false}oldSyntax{else}empty{/if}{/lang}<br />
	{if $pcContent|empty == false}{@$pcContent}{/if}
{else}
	{if ($pcPoints['pro']|isset && $pcPoints['pro']|count) || ($pcPoints['contra']|isset && $pcPoints['contra']|count)}
		{if $pcPoints['pro']|isset && $pcPoints['pro']|count}
			{foreach from=$pcPoints['pro'] item=$pcPoint}
				+ {@$pcPoint}<br />
			{/foreach}
		{/if}
		{if $pcPoints['contra']|isset && $pcPoints['contra']|count}
			{foreach from=$pcPoints['contra'] item=$pcPoint}
				- {@$pcPoint}<br />
			{/foreach}
		{/if}
	{/if}
	{if $pcPoints['neutral']|isset && $pcPoints['neutral']|count}
		{foreach from=$pcPoints['neutral'] item=$pcPoints}
				* {@$pcPoint}<br />
		{/foreach}
	{/if}
{/if}