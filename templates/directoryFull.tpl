{if $directory|isset}
	{if $directory->hasEntries()}
		<!-- directory is part of de.teralios.tjs.bbcodes (http://www.teralios.de) -->
		<div class="directoryFull tabularBox">
			<div class="tabularBoxTitle"><header><h2>{lang}wcf.directory.title{/lang}</h2></header></div>
			<div>
				{event name='beforeContent'}
				<ol>
					{foreach from=$directory item=$entry}
						{if $entry->existEntry() || $entry->hasEntries()}
							<li>
								{if $entry->existEntry()}
									<a href="{$entry->getEntry()->getAnchor()}">{$entry->getEntry()->getTitle()}</a>
								{/if}
								{if $entry->hasEntries()}
									<ol>
										{foreach from=$entry item=$subEntry}
											<li><span class="icon16 fa fa-chevron-right"></span> <a href="{$subEntry->getEntry()->getAnchor()}">{$subEntry->getEntry()->getTitle()}</a></li>
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