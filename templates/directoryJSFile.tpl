{if $directoryJSFileLoaded|isset == false}
	{include file='__bbcodeTeraVersion' application='wcf'}
	<script data-relocate="true" src="{@$__wcf->getPath()}js/Tera.Directory{if !ENABLE_DEBUG_MODE}.min{/if}.js?v={@$teraBBCodeVersion}"></script>
	{assign var='directoryJSFileLoaded' value=true}
{/if}