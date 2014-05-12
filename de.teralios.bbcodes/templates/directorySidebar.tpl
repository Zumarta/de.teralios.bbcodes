{if $directory|isset && $directory->hasJumpMarks()}
	<!-- sidebar directory is part of de.teralios.tjs.bbcodes (http://www.teralios.de) -->
	<fieldset class="dashboardBox">
		<legend>{lang}wcf.directory.title{/lang}</legend>
		<div>
			<ol class="sidebarNestedCategoryList">
				{foreach from=$directory item=$jumpMark}
					{if $jumpMark->existJumpMark() || $jumpMark->hasJumpMarks()}
						<li>
							{if $jumpMark->existJumpMark()}
								<a href="{$jumpMark->getJumpMark()->getLink()}">{$jumpMark->getJumpMark()->getTitle()}</a>
							{/if}
							{if $jumpMark->hasJumpMarks()}
								<ol>
									{foreach from=$jumpMark item=$subJumpMark}
										<li><a href="{$subJumpMark->getJumpMark()->getLink()}">{$subJumpMark->getJumpMark()->getTitle()}</a></li>
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