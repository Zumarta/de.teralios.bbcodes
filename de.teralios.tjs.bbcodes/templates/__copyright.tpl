{if $proContraDevNote|isset || $directoryDevNote|isset}
	<address class="copyright marginTop">
		{if $proContraDevNote|isset && $directoryDevNote|isset}
			{lang}wcf.teralios.bbcodes.devNote{/lang}
		{elseif $proContraDevNote|isset}
			{lang}wcf.bbcode.proContra.devNote{/lang}
		{elseif $directoryDevNote|isset == true}
			{lang}wcf.directory.devNote{/lang}
		{/if}
	</address>
{/if}