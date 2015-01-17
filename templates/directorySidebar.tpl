{if $directory|isset && $directory->hasEntries()}
	<!-- sidebar directory is part of de.teralios.tjs.bbcodes (http://www.teralios.de) -->
	<fieldset class="dashboardBox">
		<legend>{lang}wcf.directory.title{/lang}</legend>
		<div>
			<ol class="sidebarNestedCategoryList">
				{foreach from=$directory item=$entry}
					{if $entry->existEntry() || $entry->hasEntries()}
						<li>
							{if $entry->existJumpMark()}
								<a href="{$entry->getEntry()->getAnchor()}">{$entry->getEntry()->getTitle()}</a>
							{/if}
							{if $entry->hasEntries()}
								<ol>
									{foreach from=$entry item=$subEntry
										<li><a href="{$subEntry->getEntry()->getAnchor()}">{$subEntry->getEntries()->getTitle()}</a></li>
									{/foreach}
								</ol>
							{/if}
						</li>
					{/if}
				{/foreach}
			</ol>
			{event name='afterContent'}
		</div>
	</fieldset>
{/if}