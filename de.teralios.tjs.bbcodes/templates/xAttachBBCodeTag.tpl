{if $xAttachCSS|isset == false && $xAttachSize|isset && $xAttachSize > 0}
	<style type="text/css">
		.xAttachBBCode {
			max-width: {$xAttachSize}px;
		}
	</style>
	{assign var='xAttachCSS' value=true}
{/if}
<div class="xAttachBBCode{if $float|empty}{else} xAttach{$float|ucfirst}{/if}">
	<div>{@$attachmentLink}</div>
	<div>{@$description}</div>
</div>