<div class="{if $xaNoBorder}xattachBBCode{else}xattachBorderBBCode{/if} {if $xaFloat != 'none'}xattach{$xaFloat|ucfirst} teraliosFloat{else}xattachNoFloat{/if}">
	<div>
		{if $xaIsImage == false}
			<a href="{@$xaLink}" title="{@$xaTitle}" class="jsTooltip"><span class="fa icon96 {$xaIcon}"></span></a>
		{else}
			{@$xaLink}
		{/if}
	</div>
	{if $xaText|empty == false}<div>{@$xaText}</div>{/if}
</div><span></span>
