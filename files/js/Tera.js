/**
 * Contains javascript for bbcode packatge.
 * 
 * @author		Karsten (Teralios) Achterrath
 * @copyright	2014 teralios.de
 * @license		GNU Lesser General Public License v3.0 <http://www.gnu.org/licenses/lgpl-3.0.txt>
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
		
		init: function(editorID) {
			this._editorID = editorID;
			
			WCF.DOMNodeInsertedHandler.addCallback('Tera.xAttachment', $.proxy(this._catchButton, this));
			this._catchButton();
		},
		
		_catchButton: function() {
			$('.jsButtonInsertAttachment').off('click');
			$('.jsButtonInsertAttachment').click($.proxy(this._xAttachInsert, this));
		},

		_xAttachInsert: function(event, attachmentID) {
			var $attachmentID = (event === null) ? attachmentID : $(event.currentTarget).data('objectID');
			var bbcode = '[xattach=' + $attachmentID + '][/xattach]';

			if ($.browser.redactor) {
				$('#' + this._editorID).redactor('insertDynamic', $bbcode);
			}
		}
});