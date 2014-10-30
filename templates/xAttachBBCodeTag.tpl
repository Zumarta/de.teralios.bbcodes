<div class="{if BBCODES_XATTACH_FREESTYLE}xAttachBBCode{else}xAttachBorderBBCode{/if}{if $xFloat|empty}{else} xAttach{$xFloat|ucfirst}{/if}">
	<div>
		{if $xIcon != false}
			<a href="{$xAttachmentLink}" title="{$xTitle}" class="jsTooltip"><span class="fa icon96 {$xIcon}"></span></a>
		{else}
			{@$xAttachmentLink}
		{/if}
	</div>
	{if $xDescription|empty == false}<div>{@$xDescription}</div>{/if}
</div>