var sao = angular.module('sao', []);

sao.config(function ($httpProvider, csrf) {
	// set all post requests content type
	$httpProvider.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=UTF-8';
	$httpProvider.defaults.headers.common["X-Requested-With"] = 'XMLHttpRequest';
	// send all requests payload as query string
	$httpProvider.defaults.transformRequest = function (data) {
		if (data === undefined) {
			return data;
		}
		var excludeParams = ['crudUrl', 'pk'];
		//Replacement of jQuery.param
		var serialize = function (obj, prefix) {
			var str = [];
			for (var p in obj) {
				if (obj.hasOwnProperty(p)) {
					if(excludeParams.indexOf(p)>-1){
						continue;
					}
					var k = prefix ? prefix + "[" + p + "]" : p, v = obj[p];
					if(angular.isFunction(v)){
						continue;
					}
					str.push(typeof v == "object" ?
						serialize(v, k) :
						encodeURIComponent(k) + "=" + encodeURIComponent(v));
				}
			}
			return str.join("&");
		};

		return serialize(angular.extend(csrf, data));
	};

});
