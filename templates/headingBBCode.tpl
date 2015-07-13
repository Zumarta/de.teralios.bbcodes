<{if $hsTag == 'h1'}h2 class="headingBBCode"{else}h3 class="subheadingBBCode"{/if}{if $hsEntry|empty == false} id="{$hsEntry}"{/if}>
	{@$hsHeading}
	{if $hsEntry|empty == false}
		{event name='shareLink'}
		<span class="jsOnly"><a href="{$hsEntry->getShareLink()}" class="jsTooltip jsButtonShare" title="{lang}wcf.directory.share{/lang}" data-link-title="{@$hsLinkTitle}"><span class="icon16 fa fa-link"></span></a></span>
	{/if}
</{if $hsTag == 'h1'}h2{else}h3{/if}><span></span>