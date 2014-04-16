/**
 * Contains javascript class for directory.
 * 
 * @author		Karsten (Teralios) Achterrath
 * @copyright	2014 teralios.de
 * @license		GNU Lesser General Public License v3.0 <http://www.gnu.org/licenses/lgpl-3.0.txt>
 * @package		de.teralios.tjs.bbcodes
 */
var Tera = { };

Tera.Directory = {
	_id: '',
	
	init: function(id) {
		if (id.substring(0, 1) != '#') {
			this._id = '#' + id;
		}
		else {
			this._id = id;
		}
		this.parse();
	},
	
	parse: function() {
		$(this._id).append($('#jsDirectory').contents());
		$(this._id).show();
	}
};