<a href="{@$__wcf->getAnchor($footnoteTagID)}" title="{$footnoteTooltip}" class="jsTooltip">
	{if BBCODES_FOOTNOTE_STYLE == 1}
		<sup><small>{$footnoteIndex}</small></sup>
	{elseif BBCODES_FOOTNOTE_STYLE == 2}
		[{$footnoteIndex}]
	{else}
		{'*'|str_repeat:$footnoteIndex}
	{/if}
</a>