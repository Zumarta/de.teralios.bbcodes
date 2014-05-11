{$title}:<br />
---------<br />
{if $points|empty || ($points['pro']|empty && $points['contra']|empty && $points['neutral']|empty)}
	{lang}wcf.bbcode.proContra.{if $content|empty == false}oldSyntax{else}empty{/if}{/lang}<br />
	{if $content|empty == false}{@$content}{/if}
{else}
	{if ($points['pro']|isset && $points['pro']|count) || ($points['contra']|isset && $points['contra']|count)}
		{if $points['pro']|isset && $points['pro']|count}
			{foreach from=$points['pro'] item=$point}
				+ {@$point}<br />
			{/foreach}
		{/if}
		{if $points['contra']|isset && $points['contra']|count}
			{foreach from=$points['contra'] item=$point}
				- {@$point}<br />
			{/foreach}
		{/if}
	{/if}
	{if $points['neutral']|isset && $points['neutral']|count}
		{foreach from=$points['neutral'] item=$point}
				* {@$point}<br />
		{/foreach}
	{/if}
{/if}