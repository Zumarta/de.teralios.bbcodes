{if $teraDirectoryID|isset}{assign var='directoryID' value=$teraDirectoryID}
{if $teraDirectoryType|isset}{assign var='directoryType' value=$teraDirectoryType}
{if $directory|isset && $directory->hasJumpMarks() || $directoryJSCall|isset == false}
	<div id="directoryJS">
		{if $directoryType|isset && $directoryType == 'sidebar'}
			{include file='directorySidebar' application='wcf'}
		{else}
			{include file='directoryFull' application='wcf'}
		{/if}
	</div> 
	<script data-relocate="true" src="{@$__wcf->getPath()}js/Tera.Directory{if !ENABLE_DEBUG_MODE}.min{/if}.js?v={@$__wcfVersion}"></script>
	<script data-relocate="true">
		//<![CDATA[
		$(function(){
			var id = '{if $directoryID|isset}{$directoryID}{else}#directoryJSPlaceholder{/if}';
			var addClass = '{if $directoryAddClass|isset}{$directoryAddClass}{/if}';
			Tera.Directory.init(id, addClass);
		});
		//]]>
	</script>
	{assign var='directoryJSCall' value=true}
{/if}