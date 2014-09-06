<{if $hsTag == 'heading'}h2 class="headingBBCode"{else}h3 class="subheadingBBCode"{/if}{if $hsJumpMark|empty == false} id="{$hsJumpMark}"{/if}>
	{@$hsHeading}
	{if $hsJumpMark|empty == false}
		{event name='jumpMark'}
		<span class="jsOnly"><a href="{$hsJumpMark->getLink()}" class="jsTooltip jsButtonShare" title="{lang}wcf.directory.share{/lang}" data-link-title="{@$hsDataLink}"><span class="icon icon16 icon-link"></span></a></span>
	{/if}
</{if $hsTag == 'heading'}h2{else}h3{/if}>