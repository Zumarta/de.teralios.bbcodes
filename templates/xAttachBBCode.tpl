<div class="{if $xaNoBorder}xAttachBBCode{else}xAttachBorderBBCode{/if} xAttach{$xaFloat|ucfirst}">
	<div>
		{if $xaIsImage == false}
			<a href="{@$xaLink}" title="{@$xaTitle}" class="jsTooltip"><span class="fa icon96 {$xaIcon}"></span></a>
		{else}
			{@$xaLink}
		{/if}
	</div>
	{if $xaText|empty == false}<div>{@$xaText}</div>{/if}
</div>
