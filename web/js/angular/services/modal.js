angular.module('sao').factory('modal', function () {
	var	 _header = '';
	var _object = {}, _objectTemplate={}, _isEdit=false, _tempObject = {};
	return {
		show: function(object, header, objectTemplate) {
			_object = object;
			for (var key in object){
				_objectTemplate[key]=object[key];
			}
//			_objectTemplate = object;
			if(!angular.isUndefined(header)){
				this.setHeader(header);
			}
			if(!angular.isUndefined(objectTemplate)){
//				_objectTemplate=objectTemplate;
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
		}
	}
});