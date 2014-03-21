var Tera = { };

Tera.Directory = Class.extend({
	_id = '',
	
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
});