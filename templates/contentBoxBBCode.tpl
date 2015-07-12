<div class="cboxBBCode{if $boxPosition != 'none'} cbox{$boxPosition|ucfirst} cboxSize{$boxSize}{/if}">
	<div class="{if $boxTitle != ''}tabularBox {else} container {/if}">
		{if $boxTitle != ''}<div class="tabularBoxTitle"><header><h2>{$boxTitle}</h2></header></div>{/if}
		<div class="boxContent">
			{@$boxContent}
		</div>
	</div>
</div><!-- removeBR -->