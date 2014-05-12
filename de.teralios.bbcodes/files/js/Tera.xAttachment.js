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

Tera.Directory = {
		_editorID = '',
		
		init: function(editorID) {
			this._editorID = editorID;
			
			WCF.DOMNodeInsertedHandler.addCallback('Tera.Directory', $.proxy(this._catchButton, this));
		}
		
		_catchButton: function() {
			$('.jsButtonInsertAttachment').off('click');
			$('.jsButtonInsertAttachment').click($.proxy(this._xAttachInsert, this));
		}
		
		/**
		 * Attachment insert.
		 * @author	Alexander Ebert
		 * @copyright	2001-2014 WoltLab GmbH
		 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
		 */
		_xAttachInsert: function(event) {
			var $attachmentID = $(event.currentTarget).data('objectID');
			var $bbcode = '[xattach=' + $attachmentID + '][/xattach]';
			
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
		}
}