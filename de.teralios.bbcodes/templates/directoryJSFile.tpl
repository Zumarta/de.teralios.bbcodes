{if $directoryJSFileLoaded|isset == false}
	<script data-relocate="true" src="{@$__wcf->getPath()}js/Tera.Directory{if !ENABLE_DEBUG_MODE}.min{/if}.js?v={@$__wcfVersion}"></script>
	{assign var='directoryJSFileLoaded' value=true}
{/if}