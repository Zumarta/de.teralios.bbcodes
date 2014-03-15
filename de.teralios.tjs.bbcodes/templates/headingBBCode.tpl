<{if $tag == 'heading'}h2 class="headingBBCode"{else}h3 class="subheadingBBCode"{/if}{if $jumpMark|empty == false} id="{$jumpMark}"{/if}>
	{@$heading}
	{if $jumpMark|empty == false}
		<span class="jsOnly"><a href="{$__wcf->getAnchor($jumpMark)}" class="jsTolltip jsButtonShare" title="{lang}wcf.message.share{/lang}" data-link-title="{@$heading}"><span class="icon icon16 icon-link"></span></a></span>
	{/if}
</{if $tag == 'heading'}h2{else}h3{/if}>