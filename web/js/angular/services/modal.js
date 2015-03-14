angular.module('sao').factory('modal', function () {
	var	 _header = '';
	var _object = {}, _objectTemplate={};
	return {
		show: function(object, header) {
			_object = object;
			_objectTemplate = object;
			if(!angular.isUndefined(header)){
				this.setHeader(header);
			}
		},
		getCurrentObject: function(){
			return _object;
		},
		setHeader: function(header) {
			_header = header;
		},
		getHeader: function() {
			return _header;
		},
		isCurrentObject: function(obj) {
			return obj==_objectTemplate
		}
	}
});