angular.module('sao').factory('modal', function () {
	var	 _header = '';
	var _object = {};
	return {
		show: function(object) {
			_object = object;
		},
		get: function(){
			return _header;
		},
		set: function(header) {
			_header = header;
		}
	}
});