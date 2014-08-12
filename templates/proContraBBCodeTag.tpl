<div class="tabularBox proContraBBCode{if $pcPosition != 0} proContraBBCode{$pcPosition}{/if}">
	<div class="tabularBoxTitle"><header><h2>{$pcTitle}</h2></header></div>
	{if $pcPoints|empty || ($pcPoints['pro']|empty && $pcPoints['contra']|empty && $pcPoints['neutral']|empty)}
		<div class="content">
			<div>{lang}wcf.bbcode.proContra.{if $content|empty == false}oldSyntax{else}empty{/if}{/lang}</div>
			{if $content|empty == false}<div>{@$content}</div>{/if}
		</div>
	{else}
		<div class="content">
			{event name='beforeContent'}
			{if ($pcPoints['pro']|isset && $pcPoints['pro']|count) || ($pcPoints['contra']|isset && $pcPoints['contra']|count)}
				<div>
					{if $pcPoints['pro']|isset && $pcPoints['pro']|count}
						<ul class="pro">
							{foreach from=$pcPoints['pro'] item=$pcPoint}
								<li><div><span class="icon icon16 icon-plus-sign"></span> {@$pcPoint}</div></li>
							{/foreach}
						</ul>
					{/if}
					{if $pcPoints['contra']|isset && $pcPoints['contra']|count}
						<ul class="contra">
							{foreach from=$pcPoints['contra'] item=$pcPoint}
								<li><div><span class="icon icon16 icon-minus-sign"></span> {@$pcPoint}</div></li>
							{/foreach}
						</ul>
					{/if}
					<div class="clearfix"></div>
				</div>
			{/if}
			{if $pcPoints['neutral']|isset && $pcPoints['neutral']|count}
				<div>
					<ul class="neutral">
						{foreach from=$pcPoints['neutral'] item=$pcPoint}
							<li><div><span class="icon icon16 icon-play-sign"></span> {@$pcPoint}</div></li>
						{/foreach}
					</ul>
				</div>
			{/if}
			{event name='afterContent'}
		</div>
	{/if}
</div>
