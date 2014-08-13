<div class="tabularBox boxBBCode boxSize{$boxSize}{if $boxPosition != ''} box{$boxPosition|ucfirst}{/if}">
	{if $boxTitle != ''}<div class="tabularBoxTitle"><header><h2>{$boxTitle}</h2></header></div>{/if}
	<div class="content">
		{@$boxContent}
	</div>
</div>