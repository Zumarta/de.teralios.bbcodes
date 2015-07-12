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

Tera.xAttach = Class.extend({
	_attachButtonClass: '',
	_attachID: 0,
	
	init: function() {
		WCF.DOMNodeInsertedHandler.addCallback('de.teralios.xattach', $.proxy(this.addButtons, this));
	},

	addButtons: function() {
		$.each($('.jsDeleteButton'), $.proxy(this.addButton, this));
		
	},
	
	addButton: function(index, value) {
		console.log(value);
	}
});