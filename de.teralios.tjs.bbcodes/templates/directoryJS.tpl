{if $teraDirectory|isset && $teraDirectory->hasJumpMarks() || $teraJSCall|isset == false}
	<div id="jsDirectory">
	{if $teraDirectoryType|isset && $teraDirectoryType == 'sidebar'}
		{include name='directorySidebar' application='wcf'}
	{else}
		{include name='directoryFull' application='wcf'}
	{/if}
	</div>
	<script data-relocate="true" src="{@$__wcf->getPath()}js/Tera.Directory{if !ENABLE_DEBUG_MODE}.min{/if}.js?v={@$__wcfVersion}"></script>
	<script data-relocate="true">
		//<![CDATA[
		$(function(){
			var id = '{if $teraDirectoryID|isset}{$teraDirectoryID}{else}#teraDirectory{/if}';
			Tera.Directory.init(id);
		});
		//]]>
	</script>
	{assign var='teraJSCall' value=true}
{/if}