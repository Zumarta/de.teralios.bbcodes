{if $canUseIconBBCode}
	WCF.Language.addObject({
		'teralios.bbcode.icon': '{lang}wcf.bbcodes.iconBBCode{/lang}',
		'teralios.bbcode.icon.insert': '{lang}wcf.bbcodes.iconBBCode.insert{/lang}'
	});
	
	if ($.browser.redactor) {
		__REDACTOR_BUTTONS.push({ icon: 'fa-file-image-o', label: '{lang}wcf.bbcodes.iconBBCode{/lang}', name: 'teraliosIconBBCode' });
		
		(function() {
			var $iconJSON = '';
			var $iconBBCode =  null;
			var $iconTemplate = '';
						
			WCF.System.Event.addListener('com.woltlab.wcf.redactor', 'insertBBCode_teraliosIconBBCode_' + $editorName, function(data) {
				data.cancel = true;
				
				if ($iconBBCode === null) {
					$iconBBCode = new Tera.IconBBCode(data.redactor, $iconJSON, $iconTemplate);
				}
				
				$iconBBCode.open();
			});
		});
	}
{/if}
