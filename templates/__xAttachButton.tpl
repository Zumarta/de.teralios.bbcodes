{if $xAttachJS|isset == false}
	{if $wysiwygContainerID|isset && "xattach"|allowedBBCode}
		<script data-relocated="true">
		//<![CDATA[
			$(function() {
				WCF.Language.addObject({ 'wcf.bbcode.xattach.insert': '{lang}wcf.bbcode.xattach.insert{/lang}' });
				new Tera.xAttach('{@$wysiwygContainerID}');
			});
			//]]>
		</script>
	{/if}
	{assign var='xAttachJS' value=true}
{/if}