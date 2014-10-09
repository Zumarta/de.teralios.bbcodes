<div class="{if BBCODES_XATTACH_FREESTYLE}xAttachBBCode{else}xAttachBorderBBCode{/if}{if $float|empty}{else} xAttach{$float|ucfirst}{/if}">
	<div>{@$attachmentLink}</div>
	{if $description|empty == false}<div>{@$description}</div>{/if}
</div>