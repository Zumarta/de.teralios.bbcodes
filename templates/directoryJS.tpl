{if $teraDirectoryID|isset}{assign var='directoryID' value=$teraDirectoryID}{/if}
{if $teraDirectoryType|isset}{assign var='directoryType' value=$teraDirectoryType}{/if}
{if $directory|isset && $directory->hasJumpMarks() || $directoryJSCall|isset == false}
	<div id="directoryParse" class="directoryHidden">
		{if $directoryType|isset && $directoryType == 'sidebar'}
			{include file='directorySidebar' application='wcf'}
		{else}
			{include file='directoryFull' application='wcf'}
		{/if}
	</div> 
	{include file='directoryJSFile' application='wcf'}
	<script data-relocate="true">
		//<![CDATA[
		$(function(){
			var id = '{if $directoryID|isset}{$directoryID}{else}#directoryPlaceholder{/if}';
			var addClass = '{if $directoryAddClass|isset}{$directoryAddClass}{/if}';
			Tera.Directory.init(id, addClass);
		});
		//]]>
	</script>
	{assign var='directoryJSCall' value=true}
{/if}