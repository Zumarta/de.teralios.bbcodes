{if $directoryJSFileLoaded|isset == false}
	{assign var='teraBBCodeVersion' value='5cb714'}
	<script data-relocate="true" src="{@$__wcf->getPath()}js/Tera.js?v={@$teraBBCodeVersion}"></script>
	{assign var='directoryJSFileLoaded' value=true}
{/if}