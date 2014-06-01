{if $directoryItemParseClassIndex|isset && $directory|isset && $directory->hasJumpMarks()}
	<div class="directoryItemParse{$directoryItemParseClassIndex} directoryHidden">
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
			var addClass = '{if $directoryAddClass|isset}{$directoryAddClass}{/if}';
			var toClass = 'directoryItemPlaceholder{$directoryItemParseClassIndexx}'
			var fromClass = 'directoryItemParse{$directoryItemParseClassIndex}'
			Tera.Directory.initItem(toClass, fromClass, addClass);
		});
		//]]>
	</script>
{/if}