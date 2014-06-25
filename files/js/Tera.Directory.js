/**
 * Contains javascript class for directory.
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
	_id: '',
	_addClass: '',
	_toClass: '',
	_fromClass: '',
	
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
	
	initItem: function(toClass, fromClass, addClass) {
		if (toClass.substring(0,1) != '.') {
			this._toClass = '.' + toClass;
		}
		
		if (fromClass.substring(0,1) != '.') {
			this._fromClass = '.' + fromClass;
		}
		
		this._addClass = addClass;
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
	},
	
	parsePerItem: function() {
		var htmlSource = $(this._fromClass).contents();
		var placeHolder = $(this._toClass);
		
		if (htmlSource.length > 1) {
			placeHolder.append(htmlSource);
			if (this._addClass) {
				placeHolder.addClass(this._addClass);
			}
			
			placeHolder.show();
		}
	}
};