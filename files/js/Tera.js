"use strict";
/**
 * Contains javascript for bbcode package.
 * 
 * @author		Karsten (Teralios) Achterrath
 * @copyright	2014 teralios.de
 * @license		Attribution-ShareAlike 4.0 International (CC BY-SA 4.0) <http://creativecommons.org/licenses/by-sa/4.0/legalcode>
 * @package		de.teralios.tjs.bbcodes
 */
if (!Tera) {
	var Tera = { };
}

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

// add xattach insert button to attachment list.
Tera.xAttach = Class.extend({
	_attachButtonClass: '',
	_attachID: 0,
	_wysiwygContainerID: '',
	
	init: function(wysiwygContainerID) {
		this._wysiwygContainerID = wysiwygContainerID;
		WCF.DOMNodeInsertedHandler.addCallback('de.teralios.xattach', $.proxy(this._addButtons, this));
	},

	_addButtons: function() {
		// add button to image attachments
		if ($('.jsButtonAttachmentInsertThumbnail')) {
			$('.jsButtonAttachmentInsertThumbnail').each($.proxy(this._addButton, this));
		}
		
		// add buttons to normal attachments.
		if ($('.jsButtonAttachmentInsertPlain')) {
			$('.jsButtonAttachmentInsertPlain').each($.proxy(this._addButton, this));
		}
	},
	
	_addButton: function(key, button) {
		// get ul element
		var $ul = $(button).parent().parent();
		
		// get attachment id
		var attachmentID = $(button).data('objectID');
		
		// create button and insert button for xattach
		var $button = $('<li><span class="button small jsButtonXAttachmentInsert" data-object-id="' + attachmentID + '">' + WCF.Language.get('wcf.bbcode.xattach.insert') + '</span></li>');
		$button.children('span.button').click($.proxy(this._insert, this));
		$button.appendTo($ul)
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