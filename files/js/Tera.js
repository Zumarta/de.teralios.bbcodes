"use strict";
/**
 * Contains javascript for bbcode package.
 * 
 * @author		Karsten (Teralios) Achterrath
 * @copyright	2014 teralios.de
 * @license		Attribution-ShareAlike 4.0 International (CC BY-SA 4.0) <http://creativecommons.org/licenses/by-sa/4.0/legalcode>
 * @package		de.teralios.tjs.bbcodes
 */
var Tera = { };

/**
 * Adds directory to place holder.
 */
Tera.Directory = Class.extend({
	_id: '',
	_addClass: '',
	
	init: function(id, addClass) {
		if (id.substring(0, 1) != '#') {
			this._id = '#' + id;
		}
		else {
			this._id = id;
		}
		this._addClass = addClass;
		this.parse();
	},
	
	parse: function() {
		var htmlSource = $('#directoryParse').contents();
		var placeHolder = $(this._id);
	
		if (htmlSource.length > 1) {
			placeHolder.append(htmlSource);
			if (this._addClass) {
				placeHolder.addClass(this._addClass);
			}
			placeHolder.show();
		}
	}
});

// icon bbcode insert
Tera.IconBBCode = Class.extend({
	// contains icons for dialog.
	_icons: null,
	
	// redactor
	_redactor: null,
	
	// size of icons.
	_size: [16,32,48,96],
	
	// current size.
	_currentSize: 32,
	
	// dialog
	_dialog: null,
	
	// is dialog open
	_isOpen: false,
	
	// initialize icon bbcode dialog.
	init: function(_redactor, _iconsJSON) {
		this._icons = $.parseJSON(_iconsJSON);
		this._redactor = _redactor;
		this.initDialog();
	},
	
	// create icon dialog.
	initDialog: function() {
		// build dialog.
		this._dialog = $('<div />').hide();
		this._dialog.html(this._getTemplate());
		this._dialog.appendTo(document.body);
		
		// add icons and change events.
		this._addIcons(this._icons);
		$('#iconBBCodeSize').change($.proxy(this.changeSize, this));
		$('#iconBBCodeSearch').keyup($.proxy(this.search, this));
		
		// dialog
		this._dialog.wcfDialog({
			onClose: $.proxy(function() { this._isOpen = false; }, this),
			title: WCF.Language.get('wcf.bbcode.icon')
		});
		$(window).trigger('resize');
		this._dialog.wcfDialog('render');
	},

	// open icon dialog.
	open: function() {
		if (this._isOpen == true) {
			return false;
		}
		
		this.isOpen = true;
		
		if (this._dialog === null) {
			this.initDialog();
		}
		else {
			this._dialog.wcfDialog('open');
			$(window).trigger('resize');
		}
	},
	
	// change size of icons.
	changeSize: function(event) {
		var $size = $('#iconBBCodeSize').val();
		$('.iconButton').removeClass('icon' + this._currentSize);
		$('.iconButton').addClass('icon' + $size);
		this._currentSize = $size;
	},
	
	// insert icon to redactor.
	insert: function(event) {
		var $icon = $(event.currentTarget).data('name');
		var $position = $('#iconBBCodePosition').val();
		var $attrList = this._currentSize;
		if ($position == 'right' || $position == 'left') {
			$attrList += ",'" + $position + "'";
		}
		
		var bbCode = "[icon='" + $icon + "'," + $attrList + '][/icon]';
		this._redactor.wutil.insertDynamic(bbCode);
		this._reset();
	},
	
	// search icons in icon array and replace old icons.
	search: function(event) {
		var icons = [];
		var $searchString = $('#iconBBCodeSearch').val();
		
		// search string is empty
		if ($searchString === null || $searchString == '') {
			icons = this._icons;
		}
		else {
			for (var index in this._icons) {
				var iconName = this._icons[index];
				
				// icon name have the same lenght or is longer as search string
				if (iconName.length >= $searchString.length) {
					if (iconName.indexOf($searchString) > -1) {
						icons.push(iconName);
					}
				}
			}
		}
		
		this._addIcons(icons);
	},
	
	// add icons to dialog.
	_addIcons: function(icons) {
		var self = this;
		$('#iconBBCodeList').empty();
		$.each(icons, function(index, value) {
			var iconName = 'fa-' + value;
			var $li = $('<li data-name="' + iconName + '"><span class="icon icon32 ' + iconName + ' iconButton jsTooltip" data-name="' + iconName + '" title="' + iconName +'"></span></li>');
			$li.click($.proxy(self.insert, self));
			$li.appendTo("#iconBBCodeList");
		});
	},
	
	// reset information and close dialog
	_reset: function() {
		this._curentSize = 32;
		$('#iconBBCodePosition').val('none');
		$('#iconBBCodeSize').val(this._currentSize);
		$('#iconBBCodeSearch').val('');
		this._addIcons(this._icons);
		this._dialog.wcfDialog('close');
	},
	
	// icon dialog template
	_getTemplate: function() {
		var $template = '<div id="iconBBCodeBrowser">'
		+ '<div class="dialogform">'
		+ '<fieldset>'
		+ '<legend>' + WCF.Language.get('wcf.bbcode.icon.settings') + '</legend>'
		+ '<small>' + WCF.Language.get('wcf.bbcode.icon.settings.description') + '</small>'
		+ '<dl>'
		+ '<dt><laben for="iconBBCodeSearch">' + WCF.Language.get('wcf.bbcode.icon.search') + '</label></dt>'
		+ '<dd><input type="text" id="iconBBCodeSearch" value="" /></dd>'
		+ '<dt><label for="iconBBCodeSize">' + WCF.Language.get('wcf.bbcode.icon.size') + '</label></dt>'
		+ '<dd>'
		+ '<select id="iconBBCodeSize"><option value="16">16</option><option value="32" selected="selected">32</option><option value="48">48</option><option value="96">96</option></select>'
		+ '</dd>'
		+ '<dt><label for="iconBBCodePosition">' + WCF.Language.get('wcf.bbcode.icon.position') + '</label></dt>'
		+ '<dd>'
		+ '<select id="iconBBCodePosition">'
		+ '<option value="none" selected="selected">' + WCF.Language.get('wcf.bbcode.icon.position.none') + '</option>'
		+ '<option value="left">' + WCF.Language.get('wcf.bbcode.icon.position.left') + '</option>'
		+ '<option value="right">' + WCF.Language.get('wcf.bbcode.icon.position.right') + '</option>'
		+ '</select>'
		+ '</dd>'
		+ '</dl>'
		+ '</fieldset>'
		+ '<fieldset>'
		+ '<legend>' + WCF.Language.get('wcf.bbcode.icon') + '</legend>'
		+ '<ul id="iconBBCodeList" class="clearfix"></ul>'
		+ '</fieldset>'
		+ '</div>'
		+ '</div>';
		
		return $template;
	}
});

// add xattach insert button to attachment list.
Tera.xAttach = Class.extend({
	_attachButtonClass: '',
	_attachID: 0,
	_wysiwygContainerID: '',
	_addedButton: [],
	
	// add insert event to NodeInserted Handler.
	init: function(wysiwygContainerID) {
		this._wysiwygContainerID = wysiwygContainerID;
		
		this._addButtons();
		WCF.DOMNodeInsertedHandler.addCallback('de.teralios.xattach', $.proxy(this._addButtons, this));
	},
	
	// insert attachment
	insert: function(event) {
		// get attachment id and build text
		var attachmentID = $(event.currentTarget).data('objectID');
		var insertText = '[xattach=' + attachmentID + '][/xattach]';
		
		// if reactor, insert xattachment tag.
		if ($.browser.redactor) {
			$('#' + this._wysiwygContainerID).redactor('wutil.insertDynamic', insertText);
		}
	},

	// adds buttons
	_addButtons: function() {
		// add button to image attachments
		if ($('.sortableAttachment')) {
			$('.sortableAttachment').each($.proxy(this._addButton, this));
		}
	},
	
	// add a button
	_addButton: function(key, attachmentElement) {
		var attachmentID = $(attachmentElement).data('objectID');
		var $ul = $(attachmentElement).find('.buttonGroup');
		
		if ($.inArray(attachmentID, this._addedButton) == -1) {
			//create button and insert button for xattach	
			var $button = $('<li><span class="button small jsButtonXAttachmentInsert" data-object-id="' + attachmentID + '">' + WCF.Language.get('wcf.bbcode.xattach.insert') + '</span></li>');
			$button.children('span.button').click($.proxy(this.insert, this));
			$button.appendTo($ul);
			this._addedButton.push(attachmentID);
		}
	}
});