<div class="boxBBCode{if $boxPosition != ''} box{$boxPosition|ucfirst} boxSize{$boxSize}{/if}">
	<div class="{if $boxTitle != ''}tabularBox {else} container {/if}">
		{if $boxTitle != ''}<div class="tabularBoxTitle"><header><h2>{$boxTitle} {@$teraEgg}</h2></header></div>{/if}
		<div class="content">
			{@$boxContent}
		</div>
	</div>
</div>