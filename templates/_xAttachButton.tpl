{if $xAttachJS|isset == false}
	{include file='__teraJSFile' application='wcf'}
	<script data-relocated="true">
	//<![CDATA[
		$(function() {
			WCF.Language.addObject({ 'wcf.bbcode.xattach.insert': '{lang}wcf.bbcode.xattach.insert{/lang}' });
			new Tera.xAttach('{@$wysiwygContainerID}');
		});
		//]]>
	</script>
	{assign var='xAttachJS' value=true}
{/if}