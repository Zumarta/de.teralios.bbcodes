{if $teraDirectory|isset && $teraDirectory->hasJumpMarks()}
	<fieldset class="dashboardBox">
		<legend>{lang}wcf.directory.title{/lang}</legend>
		<div>
			<ol class="sidebarNestedCategoryList">
				{foreach from=$teraDirectory item=$jumpMark}
					{if $jumpMark->existJumpMark() || $jumpMark->hasJumpMarks()}
						<li>
							{if $jumpMark->existsJumpMark()}
								<a href="{$jumpMark->getJumpMark()->getLink()}">{$jumpMark->getJumpMark()->getTitle()}</a>
							{/if}
							{if $jumpMark->hasJumpMarks()}
								<ol>
									{foreach from=$jumpMark item=$subJumpMark}
									<li>
										<a href="{$subJumpMark->getJumpMark()->getLink()}">{$subJumpMark->getJumpMark()->getTitle()}</a>
									</li>
									{/foreach}
								</ol>
							{/if}
						</li>
					{/if}
				{/foreach}
			</ol>
		</div>
	</fieldset>
{/if}