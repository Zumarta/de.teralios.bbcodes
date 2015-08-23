{if $xAttachJS|isset == false}
	{if $wysiwygContainerID|isset && "xattach"|allowedBBCode}
		<script data-relocated="true">
		//<![CDATA[
			$(function() {
				WCF.Language.addObject({
					'wcf.bbcode.xattach': '{lang}wcf.bbcode.xattach{/lang}',
					'wcf.bbcode.xattach.description': '{lang}wcf.bbcode.xattach.description{/lang}',
					'wcf.bbcode.xattach.insert': '{lang}wcf.bbcode.xattach.insert{/lang}',
					'wcf.bbcode.xattach.position': '{lang}wcf.bbcode.xattach.position{/lang}',
					'wcf.bbcode.xattach.position.left': '{lang}wcf.bbcode.xattach.position.left{/lang}',
					'wcf.bbcode.xattach.position.none': '{lang}wcf.bbcode.xattach.position.none{/lang}',
					'wcf.bbcode.xattach.position.right': '{lang}wcf.bbcode.xattach.position.right{/lang}',
					'wcf.bbcode.xAttach.settings': '{lang}wcf.bbcode.xAttach.settings{/lang}'
				});
				new Tera.xAttachBBCode('{@$wysiwygContainerID}');
			});
			//]]>
		</script>
	{/if}
	{assign var='xAttachJS' value=true}
{/if}