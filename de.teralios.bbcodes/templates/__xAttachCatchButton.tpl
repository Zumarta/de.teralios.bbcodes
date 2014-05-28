{if MODULE_ATTACHMENT && $attachmentHandler !== null && $attachmentHandler->canUpload()}
	{if $xAttachButton|isset && $xAttachButton == true}
		<script data-relocate="true" src="{@$__wcf->getPath()}js/Tera.xAttachment{if !ENABLE_DEBUG_MODE}.min{/if}.js"></script>
		<script data-relocate="true">
			//<![CDATA[
			$(function() {
				Tera.xAttachment.init('{@$wysiwygContainerID}', {if $isWCF21|isset && $isWCF21 == true}true{else}false{/if});
			});
			//]]>
		</script>
	{/if}
{/if}