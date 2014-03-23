{if $teraDirectory|isset}
	{if $teraDirectory->hasJumpMarks()}
		<div class="directoryFull tabularBox">
			<div class="tabularBoxTitle"><header><h2>{lang}wcf.directory.title{/lang}</h2></header></div>
			<div>
				<ol>
					{foreach from=$teraDirectory item=$jumpMark}
						{if $jumpMark->existJumpMark() || $jumpMark->hasJumpMarks()}
							<li>
								{if $jumpMark->existJumpMark()}
									<a href="{$jumpMark->getJumpMark()->getLink()}">{$jumpMark->getJumpMark()->getTitle()}</a>
								{/if}
								{if $jumpMark->hasJumpMarks()}
									<ol>
										{foreach from=$jumpMark item=$subJumpMark}
											<li><span class="icon icon16 icon-caret-right"></span> <a href="{$subJumpMark->getJumpMark()->getLink()}">{$subJumpMark->getJumpMark()->getTitle()}</a></li>
										{/foreach}
									</ol>
								{/if}
							</li>
						{/if}
					{/foreach}
				</ol>
			</div>
		</div>
	{/if}
{/if}