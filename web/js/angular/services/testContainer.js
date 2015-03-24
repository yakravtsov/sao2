angular.module('sao').factory('testContainer', function () {
	var	 _test = {};
	return {
		get: function(){
			return _test;
		},
		set: function(test) {
			_test = test;
		}
	}
});