<div class="tabularBox proContraBBCode{if $pcPosition == 'Left' || $pcPosition == 'Right'} proContraBBCode{$pcPosition}{/if}">
	<div class="tabularBoxTitle"><header><h2>{$pcTitle}</h2></header></div>
		<div class="content">
			{event name='beforeContent'}
			{if ($pcPoints['+']|isset && $pcPoints['+']|count) || ($pcPoints['-']|isset && $pcPoints['-']|count)}
				<div>
					{if $pcPoints['pro']|isset && $pcPoints['pro']|count}
						<ul class="pro">
							{foreach from=$pcPoints['+'] item=$pcPoint}
								<li><div><span class="icon16 fa fa-plus-circle"></span> {@$pcPoint}</div></li>
							{/foreach}
						</ul>
					{/if}
					{if $pcPoints['-']|isset && $pcPoints['-']|count}
						<ul class="contra">
							{foreach from=$pcPoints['-'] item=$pcPoint}
								<li><div><span class="icon16 fa fa-minus-circle"></span> {@$pcPoint}</div></li>
							{/foreach}
						</ul>
					{/if}
					<div class="clearfix"></div>
				</div>
			{/if}
			{if $pcPoints['*']|isset && $pcPoints['*']|count}
				<div>
					<ul class="neutral">
						{foreach from=$pcPoints['*'] item=$pcPoint}
							<li><div><span class="icon16 fa fa-circle"></span> {@$pcPoint}</div></li>
						{/foreach}
					</ul>
				</div>
			{/if}
			{event name='afterContent'}
		</div>
	{/if}
</div>