<!-- pro and contra bbcode is part of de.teralios.tjs.bbcodes (http://www.teralios.de) -->
<div class="tabularBox proContraBBCode">
	<div class="tabularBoxTitle"><header><h2>{$title}</h2></header></div>
	{if $points|empty || ($points['pro']|empty && $points['contra']|empty && $points['neutral']|empty)}
		<div class="content">
			<div>{lang}wcf.bbcode.proContra.{if $content|empty == false}oldSyntax{else}empty{/if}{/lang}</div>
			{if $content|empty == false}<div>{@$content}</div>{/if}
		</div>
	{else}
		<div class="content {if $proContraStyle|isset && $proContraStyle == 'old'}styleOld{else}styleNew{/if}">
			{if ($points['pro']|isset && $points['pro']|count) || ($points['contra']|isset && $points['contra']|count)}
				{if $points['pro']|isset && $points['pro']|count}
					{if $proContraStyle|isset && $proContraStyle == 'old'}<div>{/if}
					<ul class="pro">
						{foreach from=$points['pro'] item=$point}
							<li><span class="icon icon16 icon-plus-sign"></span> {@$point}</li>
						{/foreach}
					</ul>
					{if $proContraStyle|isset && $proContraStyle == 'old'}</div>{/if}
				{/if}
				{if $points['contra']|isset && $points['contra']|count}
					{if $proContraStyle|isset && $proContraStyle == 'old'}<div>{/if}
					<ul class="contra">
						{foreach from=$points['contra'] item=$point}
							<li><span class="icon icon16 icon-minus-sign"></span> {@$point}</li>
						{/foreach}
					</ul>
					{if $proContraStyle|isset && $proContraStyle == 'old'}</div>{/if}
				{/if}
			{/if}
			{if $points['neutral']|isset && $points['neutral']|count}
				<div>
					<ul class="neutral">
						{foreach from=$points['neutral'] item=$point}
							<li><span class="icon icon16 icon-question-sign"></span> {@$point}</li>
						{/foreach}
					</ul>
				</div>
			{/if}
		</div>
	{/if}
</div>
