{if $teraDirectory|isset}
	{if $teraDirectory->hasJumpMarks()}
		<div class="directoryFull tabularBox">
			<div class="tabularBoxTitle"><header><h2>{lang}wcf.directory.title{/lang}</h2></header></div>
			<div>
				<ul>
					{foreach from=$teraDirectory item=$jumpMark}
						{if $jumpMark->existJumpMark() || $jumpMark->hasJumpMarks()}
							<li>
								{if $jumpMark->existJumpMark()}
									<a href="{$jumpMark->getJumpMark()->getLink()}">{$jumpMark->getJumpMark()->getTitle()}</a>
								{/if}
								{if $jumpMark->hasJumpMarks()}
									<ul>
										{foreach from=$jumpMark item=$subJumpMark}
											<li><a href="{$subJumpMark->getJumpMark()->getLink()}">{$subJumpMark->getJumpMark()->getTitle()}</a></li>
										{/foreach}
									</ul>
								{/if}
							</li>
						{/if}
					{/foreach}
				</ul>
			</div>
		</div>
	{/if}
{/if}