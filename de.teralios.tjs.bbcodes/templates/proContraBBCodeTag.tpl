<!-- Pro and Contra BBCode is part of de.teralios.tjs.bbcodes (Teralios.de) -->
<div class="tabularBox proContraBBCode">
	<div class="tabularBoxTitle"><header><h2>{$title}</h2></header></div>
	{if $points|empty || ($points['pro']|empty && $points['contra']|empty && $points['neutral']|empty)}
		<div class="content">
			<div>{lang}wcf.bbcode.proContra.{if $content|empty == false}oldSyntax{else}empty{/if}{/lang}</div>
			{if $content|empty == false}<div>{@$content}</div>{/if}
		</div>
	{else}
		{if $proContraStyle|isset && $proContraStyle == 'old'}
			<div class="content styleOld">
				{if $points['pro']|isset && $points['pro']|count}
					<div class="pro">
						<ul>
							{foreach from=$points['pro'] item=$point}
								<li><span class="icon icon16 icon-plus-sign"></span> {@$point}</li>
							{/foreach}
						</ul>
					</div>
				{/if}
				{if $points['contra']|isset && $points['contra']|count}
					<div class="contra">
						<ul>
							{foreach from=$points['contra'] item=$point}
								<li><span class="icon icon16 icon-minus-sign"></span> {@$point}</li>
							{/foreach}
						</ul>
					</div>
				{/if}
				{if $points['neutral']|isset && $points['neutral']|count}
					<div class="neutral">
						<ul>
							{foreach from=$points['neutral'] item=$point}
								<li><span class="icon icon16 icon-minus-sign"></span> {@$point}</li>
							{/foreach}
						</ul>
					</div>
				{/if}
			</div>
		{else}
			<div class="content styleNew">
					<div class="proAndContra">
						{if $points['pro']|isset && $points['pro']|count}
							<ul class="pro">
								{foreach from=$points['pro'] item=$point}
									<li><span class="icon icon16 icon-plus-sign"></span> {@$point}</li>
								{/foreach}
							</ul>
						{/if}
						{if $points['contra']|isset && $points['contra']|count}
							<ul class="contra">
								{foreach from=$points['contra'] item=$point}
									<li><span class="icon icon16 icon-minus-sign"></span> {@$point}</li>
								{/foreach}
							</ul>
						{/if}
						<span class="clearfix"></span>
					</div>
					<div class="neutral">
					{if $points['neutral']|isset && $points['neutral']|count}
							<ul>
								{foreach from=$points['neutral'] item=$point}
									<li><span class="icon icon16 icon-question-sign"></span> {@$point}</li>
								{/foreach}
							</ul>
						{/if}
					</div>
			</div>
		{/if}
	{/if}
</div>
