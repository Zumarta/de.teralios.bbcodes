{if $directory|isset && $directory->hasEntries() || $directoryJSCall|isset == false}
	<div id="directoryParse" class="directoryHidden">
		{if $directoryType|isset && $directoryType == 'sidebar'}
			{include file='directorySidebar' application='wcf'}
		{else}
			{include file='directoryFull' application='wcf'}
		{/if}
	</div> 
	<script data-relocate="true">
		//<![CDATA[
		$(function(){
			var id = '{if $directoryID|isset}{$directoryID}{else}#directoryPlaceholder{/if}';
			var addClass = '{if $directoryAddClass|isset}{$directoryAddClass}{/if}';
			new Tera.BBCode.Directory(id, addClass);
		});
		//]]>
	</script>
	{assign var='directoryJSCall' value=true}
{/if}