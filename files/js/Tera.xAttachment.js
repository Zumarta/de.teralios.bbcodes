/**
 * Contains javascript class for xAttachment. (experimental)
 * 
 * @author		Karsten (Teralios) Achterrath
 * @copyright	2014 teralios.de
 * @license		GNU Lesser General Public License v3.0 <http://www.gnu.org/licenses/lgpl-3.0.txt>
 * @package		de.teralios.tjs.bbcodes
 */
if (!Tera) {
	var Tera = { };
}

/**
 * Catch attachmant insert button.
 */
Tera.xAttachment = Class.extend({
		_editorID: '',
		_wcf21: false,
		
		init: function(editorID, wcf21) {
			this._editorID = editorID;
			this._wcf21 = wcf21;
			
			WCF.DOMNodeInsertedHandler.addCallback('Tera.xAttachment', $.proxy(this._catchButton, this));
			this._catchButton();
		},
		
		_catchButton: function() {
			$('.jsButtonInsertAttachment').off('click');
			$('.jsButtonInsertAttachment').click($.proxy(this._xAttachInsert, this));
		},

		_xAttachInsert: function(event, attachmentID) {
			var $attachmentID = (event === null) ? attachmentID : $(event.currentTarget).data('objectID');
			var $bbcode = '[xattach=' + $attachmentID + '][/xattach]';
			
			if (this._wcf21 == false) {
				this._insertVersion20($bbcode);
			}
			else {
				this._insertVersion21($bbcode);
			}
		},
		
		_insertVersion20: function(bbcode) {
			var $bbcode = bbcode;
	
			var $ckEditor = ($.browser.mobile) ? null : $('#' + this._editorID).ckeditorGet();
			if ($ckEditor !== null && $ckEditor.mode === 'wysiwyg') {
				// in design mode
				$ckEditor.insertText($bbcode);
			}
			else {
				// in source mode
				var $textarea = ($.browser.mobile) ? $('#' + this._editorID) : $('#' + this._editorID).next('.cke_editor_text').find('textarea');
				var $value = $textarea.val();
				if ($value.length == 0) {
					$textarea.val($bbcode);
				}
				else {
					var $position = $textarea.getCaret();
					$textarea.val( $value.substr(0, $position) + $bbcode + $value.substr($position) );
				}
			}
		},
		
		_insertVersion21: function(bbcode) {
			var $bbcode = bbcode;

			if ($.browser.redactor) {
				$('#' + this._editorID).redactor('insertDynamic', $bbcode);
			}
		}
});