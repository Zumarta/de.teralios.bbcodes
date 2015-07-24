{if true}
	WCF.Language.addObject({
		'wcf.bbcode.icon': '{lang}wcf.bbcodes.icon{/lang}',
		'wcf.bbcode.icon.insert': '{lang}wcf.bbcodes.icon.insert{/lang}'
	});
	
	if ($.browser.redactor) {
		__REDACTOR_BUTTONS.push({ icon: 'fa-rebel', label: '{lang}wcf.bbcode.icon{/lang}', name: 'icon' });
			(function() {
		
			var $iconJSON = '{include file='__iconJSON' application='wcf'}';
			var $iconBBCode =  null;
			var $iconTemplate = '{include file='iconBBCodeBrowser' application='wcf'}';
						
			WCF.System.Event.addListener('com.woltlab.wcf.redactor', 'insertBBCode_icon_' + $editorName, function(data) {
				data.cancel = true;
				
				if ($iconBBCode === null) {
					$iconBBCode = new Tera.IconBBCode(data.redactor, $iconJSON, $iconTemplate);
				}
				
				$iconBBCode.open();
			});
		})();
	}
{/if}
