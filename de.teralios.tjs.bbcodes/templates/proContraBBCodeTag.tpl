<!-- Pro and Contra BBCode is part of de.teralios.tjs.bbcodes (Teralios.de) -->
<div class="tabularBox proContraBox">
	<div class="tabularBoxTitle"><header><h2>{$title}</h2></header></div>
	<div class="proContraBoxContent">
	{if $points['pro']|count}
		<div class="proBox">
			<ul>
				{foreach from=$points['pro'] item=$point}
					<li><span class="icon icon16 icon-plus-sign icon-pro"></span> {@$point}</li>
				{/foreach}
			</ul>
		</div>
	{/if}
	{if $points['contra']|count}
		<div class="contraBox">
			<ul>
				{foreach from=$points['contra'] item=$point}
					<li><span class="icon icon16 icon-minus-sign icon-contra"></span> {@$point}</li>
				{/foreach}
			</ul>
		</div>
	{/if}
	{if $points['neutral']|count}
		<div class="neutralBox">
			<ul>
				{foreach from=$points['neutral'] item=$point}
					<li><span class="icon icon16 icon-minus-sign"></span> {@$point}</li>
				{/foreach}
			</ul>
		</div>
	{/if}
	</div>
</div>