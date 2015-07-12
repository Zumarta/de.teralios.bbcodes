{if $directoryJSFileLoaded|isset == false}
	{assign var='teraBBCodeVersion' value='2.1.0'}
	<script data-relocate="true" src="{@$__wcf->getPath()}js/Tera.js?v={@$teraBBCodeVersion}"></script>
	{assign var='directoryJSFileLoaded' value=true}
{/if}