"use strict";
/**
 * Contains javascript for bbcode packatge.
 * 
 * @author		Karsten (Teralios) Achterrath
 * @copyright	2014 teralios.de
 * @license		Attribution-ShareAlike 4.0 International (CC BY-SA 4.0) <http://creativecommons.org/licenses/by-sa/4.0/legalcode>
 * @package		de.teralios.tjs.bbcodes
 */
if (!Tera) {
	var Tera = { };
}

Tera.Directory =  Class.extend({
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

/**
 * Catch attachmant insert button.
 */
Tera.xAttachment = Class.extend({
		_editorID: '',
		_replaceUrl: '',
		_attachmentIDs: [ ],
		
		init: function(editorID) {
			// editor id
			this._editorID = editorID;
			
			// register events
			WCF.DOMNodeInsertedHandler.addCallback('Tera.xAttachment', $.proxy(this._catchButton, this));
			//WCF.System.Event.addListener('com.woltlab.wcf.redactor', 'afterConvertToHtml', $.proxy(this._bbcode2html, this));
			//WCF.System.Event.addListener('com.woltlab.wcf.redactor', 'afterConvertFromHtml', $.proxy(this._html2bbcode, this));
			
			// get important data
			if ($.browser.redactor) {
				this._replaceUrl = $('#' + this._editorID).redactor('wutil.getOption', 'woltlab.attachmentUrl');
				this._attachmentIDs = $('#' + this._editorID).redactor('wbbcode._getImageAttachmentIDs');
			}
			
			this._catchButton();
		},
		
		_catchButton: function() {
			// TODO new code for new wcf functions
		},

		_xAttachInsert: function(event, attachmentID) {
			var $attachmentID = (event === null) ? attachmentID : $(event.currentTarget).data('objectID');
			var bbcode = '[xattach=' + $attachmentID + '][/xattach]';

			if ($.browser.redactor) {
				$('#' + this._editorID).redactor('wutil.insertDynamic', bbcode);
			}
		},
		
		/*_bbcode2html: function(eventData) {
			
		},
		
		/*_html2bbcode: function(eventData) {
			
		}*/
});