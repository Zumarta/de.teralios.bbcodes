{if MODULE_ATTACHMENT && BBCODES_XATTACH_EDITOR && $attachmentHandler !== null && $attachmentHandler->canUpload()}
	{if $xAttachButton|isset && $xAttachButton == true}
		{include file='__teraJSFile' application='wcf'}
		<script data-relocate="true">
			//<![CDATA[
			$(function() {
				new Tera.xAttachment('{@$wysiwygContainerID}');
			});
			//]]>
		</script>
	{/if}
{/if}