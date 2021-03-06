{if $footnoteMap|isset && $footnoteMap->hasFootnotes()}
	<div class="container containerPadding marginTop footnoteList">
		<div class="containerHeadline">
			<h3>{lang}wcf.bbcode.footnote{/lang}</h3>
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
						{elseif BBCODES_FOOTNOTE_STYLE == 3}
							{'*'|str_repeat:$footnote->getIndex()}
						{else}
							<sup><small>{$footnote->getIndex()|romanize}</small></sup>
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