angular.module('sao').factory('decorate', ['$http', 'modal', '$rootScope', '$q', function ($http, modal, $rootScope, $q) {
	var _templates = {
			question: {
				name: '',
				type: 0
			},
			scale: {
				name: '',
				'default': null
			},
			answer: {
				question_id: null,
				answer: ''
			}
	};

	var _commonDecorator = {
		save: function () {
			var url = this.hasOwnProperty(this.pk) ? this.crudUrl.update + '/' + this[this.pk] : this.crudUrl.create;
			$http.post(url, this).success(function(data, status) {
				var deferred = $q.defer();
				deferred.resolve(data);
				return deferred.promise;
			});
		},
		'delete': function () {
			$http({
				method: 'POST',
				url: this.crudUrl.delete,
				data: JSON.stringify({Question: $scope.scale}),
				headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
			});
		}
	};

	var _questionDecorator = {
		addAnswer: function () {
			this.questions.push(_templates.answer);
		}
	};

	var _nestedDecorator = {
		left: function () {
			//move left
		},
		right: function () {
			//move right
		}
	};

	var _scaleDecorator = {
		pk: 'scale_id',
		crudUrl: {
			create: '/scale/create',
			update: '/scale/create',
			'delete': '/scale/delete'
		}
	};

	var _testDecorator = {
		templates: _templates,
		addQuestion: function (data) {
			modal.set('Новый вопрос');
			this.questions.push(this.templates.question);
		},
		addScale: function (data) {
			console.log(this);
			console.log(data);
			this.scales.push(angular.extend(data, _commonDecorator, _scaleDecorator));
		}
	};
	return  {
		common: function (parent) {
			return angular.extend(parent, _commonDecorator)
		},
		nested: function (parent) {
			return angular.extend(parent, _nestedDecorator)
		},
		test: function (parent) {
			angular.forEach(_testDecorator.templates, function (question, key) {
				_testDecorator.templates[key]['test_id']=parent.test_id;
			});
			return angular.extend(parent, _testDecorator)
		},
		question: function (parent) {
			return angular.extend(parent, _commonDecorator, _questionDecorator, _nestedDecorator)
		},
		scale: function (parent) {
			return angular.extend(parent, _commonDecorator, _scaleDecorator)
		}
	}
}]);