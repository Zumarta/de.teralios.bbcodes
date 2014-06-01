{if $directoryItemIndex|isset == false}
	{assign var='directoryItemIndex' value=1}
{/if}
<div class="directoryItemPlaceholder{$directoryItemIndex} directoryHidden"></div>
{assign var='directoryItemParseClassIndex' value=$directoryItemIndex}
{assign var='directoryItemIndex' value=$directoryItemIndex+1}