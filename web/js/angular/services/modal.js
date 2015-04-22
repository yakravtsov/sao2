angular.module('sao').factory('modal', function () {
	var	 _header = '';
	var _object = {}, _objectTemplate={}, _isEdit=false;
	return {
		show: function(object, header, objectTemplate) {
			_objectTemplate = {};
			_object = angular.copy(object);
			for (var key in _object){
				_objectTemplate[key]=_object[key];
			}
			if(!angular.isUndefined(header)){
				this.setHeader(header);
			}
			if(!angular.isUndefined(objectTemplate)){
				_isEdit=true;
			}
		},
		getCurrentObject: function(){
			return _isEdit ? _objectTemplate : _object;
		},
		setHeader: function(header) {
			_header = header;
		},
		getHeader: function() {
			return _header;
		},
		isCurrentObject: function(obj) {
			for (var key in _objectTemplate){
				if(! obj.hasOwnProperty(key)){
					return false;
				}
			}
			return true;
		},
		clear: function() {
			_object = {};
			_objectTemplate = {};
			_isEdit=false;
		}
	}
});