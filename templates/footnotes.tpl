{if $footnoteMap|isset && $footnoteMap->hasFootnotes()}
	<div class="container containerPadding marginTop footnoteList">
		<div class="containerHeadline">
			<h3>{lang}wcf.teralios.footnotes{/lang}</h3>
		</div>
		{event name='beforeContent'}
		<ul>
			{foreach from=$footnoteMap item='footnote'}
				<li id="{$footnote->getTagID()}">
					<div class="footnoteIndex">
						{if BBCODES_FOOTNOTE_STYLE == 1}
							<sup><small>{$footnote->getIndex()}</small></sup>
						{elseif BBCODES_FOOTNOTE_STYLE == 2}
							[{$footnote->getIndex()}]
						{else}
							{'*'|str_repeat:$footnote->getIndex()}
						{/if}
					</div>
					<div class="footnoteText">{@$footnote->getText()}</div>
					<div class="clearfix"></div>
				</li>
			{/foreach}
		</ul>
		{event name='afterContent'}
	</div>
{/if}
