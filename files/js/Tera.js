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
	_icons: null,
	_template: '',
	_redactor: null,
	_size: [16,32,48,64],
	_currentSize: 32,
	_position: ['left', 'right'],
	_dialog: null,
	_isOpen: false,
	
	init: function(_redactor, _iconsJSON, _template) {
		this._icons = $.parseJSON(_iconsJSON);
		this._redactor = _redactor;
		this._template = _template;
	},
	
	// create icon dialog.
	initDialog: function() {
		// build dialog.
		this._dialog('<div />').hide();
		this._dialog.html(this._template);
		this._dialog.appendTo(document.body);
		
		// add icons and change events.
		this._addIcons();
		$('#iconBBCodeSize').change($.proxy(this.changeSize, this));
		
		// dialog
		this._dialog.wcfDialog({
			onClose: $.proxy(function() { this._isOpen = false; }, this),
			title: WCF.Language.get('gallery.image.browser')
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
	
	// add icons to dialog.
	_addIcons: function() {
		$.each(this.icons, function(index, value) {
			var iconName = 'fa-' + value;
			var $li = $('<li><span class="icon icon32 ' + iconName + ' iconButton" data-icon="' + iconName + '"></span> ' + iconName + '</li>');
			$li.click($.proxy(this.insert, this));
			$li.appendTo("#iconBBCodeList");
		});
	},
	
	// change size for dialog.
	changeSize: function(event) {
		var $size = $('#iconBBCodeSize').val();
		$('.iconButton').removeClass('icon' + this._currentSize);
		$('.iconButton').addClass('icon' + $size);
		this._currentSize = $size;
	},
	
	// insert icon to redactor.
	insert: function(event) {
		var $icon = $(event.currentTarget).data('icon');
		var $position = $('#iconBBCodePosition').val();
		var $attrList = this._currentSize;
		if ($.inArray($position, ['left, right'])) {
			$attrList += ",'" + $position + "'";
		}
		
		var $bbCode = "[icon='" + $icon + "'," + $attrList + '][/icon]';
		this._redactor.wutil.insertDynamic($bbCode);
	}
});

// add xattach insert button to attachment list.
Tera.xAttach = Class.extend({
	_attachButtonClass: '',
	_attachID: 0,
	_wysiwygContainerID: '',
	_addedButton: [],
	
	init: function(wysiwygContainerID) {
		this._wysiwygContainerID = wysiwygContainerID;
		
		this._addButtons();
		WCF.DOMNodeInsertedHandler.addCallback('de.teralios.xattach', $.proxy(this._addButtons, this));
	},

	_addButtons: function() {
		// add button to image attachments
		if ($('.sortableAttachment')) {
			$('.sortableAttachment').each($.proxy(this._addButton, this));
		}
	},
	
	_addButton: function(key, attachmentElement) {
		var attachmentID = $(attachmentElement).data('objectID');
		var $ul = $(attachmentElement).find('.buttonGroup');
		
		if ($.inArray(attachmentID, this._addedButton) == -1) {
			//create button and insert button for xattach	
			var $button = $('<li><span class="button small jsButtonXAttachmentInsert" data-object-id="' + attachmentID + '">' + WCF.Language.get('wcf.bbcode.xattach.insert') + '</span></li>');
			$button.children('span.button').click($.proxy(this._insert, this));
			$button.appendTo($ul);
			this._addedButton[attachmentID] = attachmentID;
		}
	},
	
	_insert: function(event) {
		// get attachment id and build text
		var attachmentID = $(event.currentTarget).data('objectID');
		var insertText = '[xattach=' + attachmentID + '][/xattach]';
		
		// if reactor, insert xattachment tag.
		if ($.browser.redactor) {
			$('#' + this._wysiwygContainerID).redactor('wutil.insertDynamic', insertText);
		}
	}
});