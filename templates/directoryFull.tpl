{if $directory|isset}
	{if $directory->hasJumpMarks()}
		<!-- directory is part of de.teralios.tjs.bbcodes (http://www.teralios.de) -->
		<div class="directoryFull tabularBox">
			<div class="tabularBoxTitle"><header><h2>{lang}wcf.directory.title{/lang}</h2></header></div>
			<div>
				{event name='beforeContent'}
				<ol>
					{foreach from=$directory item=$jumpMark}
						{if $jumpMark->existJumpMark() || $jumpMark->hasJumpMarks()}
							<li>
								{if $jumpMark->existJumpMark()}
									<a href="{$jumpMark->getJumpMark()->getAnchor()}">{$jumpMark->getJumpMark()->getTitle()}</a>
								{/if}
								{if $jumpMark->hasJumpMarks()}
									<ol>
										{foreach from=$jumpMark item=$subJumpMark}
											<li><span class="icon icon16 icon-caret-right"></span> <a href="{$subJumpMark->getJumpMark()->getAnchor()}">{$subJumpMark->getJumpMark()->getTitle()}</a></li>
										{/foreach}
									</ol>
								{/if}
							</li>
						{/if}
					{/foreach}
				</ol>
				{event name='afterContent'}
			</div>
		</div>
	{/if}
{/if}