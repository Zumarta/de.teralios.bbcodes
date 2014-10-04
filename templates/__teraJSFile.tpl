{if $directoryJSFileLoaded|isset == false}
	{assign var='teraBBCodeVersion' value='5cb714'}
	<script data-relocate="true" src="{@$__wcf->getPath()}js/Tera{if !ENABLE_DEBUG_MODE}.min{/if}.js?v={@$teraBBCodeVersion}"></script>
	{assign var='directoryJSFileLoaded' value=true}
{/if}