<div class="boxBBCode{if $boxPosition != 'none'} teralios{$boxPosition|ucfirst} boxSize{$boxSize}{/if}">
	<div class="{if $boxTitle != ''}tabularBox {else} container {/if}">
		{if $boxTitle != ''}<div class="tabularBoxTitle"><header><h2>{$boxTitle}</h2></header></div>{/if}
		<div class="boxContent">
			{@$boxContent}
		</div>
	</div>
</div>