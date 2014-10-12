{if MODULE_ATTACHMENT && BBCODES_XATTACH_EDITOR && $attachmentHandler !== null && $attachmentHandler->canUpload()}
	{include file='__teraJSFile' application='wcf'}
	<script data-relocate="true">
		//<![CDATA[
		$(function() {
			new Tera.xAttachment('{@$wysiwygContainerID}');
		});
		//]]>
	</script>
{/if}