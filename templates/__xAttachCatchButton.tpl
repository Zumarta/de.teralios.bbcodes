{if MODULE_ATTACHMENT && BBCODES_XATTACH_EDITOR && $attachmentHandler !== null && $attachmentHandler->canUpload()}
	{if $xAttachButton|isset && $xAttachButton == true}
		{include file='__bbcodeTeraVersion' application='wcf'}
		<script data-relocate="true" src="{@$__wcf->getPath()}js/Tera.xAttachment{if !ENABLE_DEBUG_MODE}.min{/if}.js?v={@$teraBBCodeVersion}"></script>
		<script data-relocate="true">
			//<![CDATA[
			$(function() {
				new Tera.xAttachment('{@$wysiwygContainerID}', {if $isWCF21|isset && $isWCF21 == true}true{else}false{/if});
			});
			//]]>
		</script>
	{/if}
{/if}