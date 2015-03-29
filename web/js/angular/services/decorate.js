angular.module('sao').factory('decorate', ['$http', 'modal', '$rootScope', '$q', function ($http, modal, $rootScope, $q) {
	var _templates = {
		question: {
			name: '',
			type: 0,
			created: null,
			updated: null,
			author_id: null,
			scale_id: null,
			answers: []
		},
		scale: {
			name: '',
			'default': null,
			created: null,
			updated: null,
			author_id: null,
			scale_id: null
		},
		answer: {
			question_id: null,
			answer: '',
			created: null,
			updated: null,
			author_id: null,
			scale_id: null,
			scaleEffects: {}
		}
	};

	var _commonDecorator = {
		save: function () {
			return $http.post(
				this.isNewRecord() ? this.crudUrl.create : this.crudUrl.update + this.getPk(), this
			);
		},
		remove: function () {
			return $http.post(this.crudUrl.remove+this.getPk(), this);
		},
		isNewRecord: function () {
			return this.getPk() == null
		},
		getPk: function () {
			return this[this.pk];
		}
	};

	var _questionDecorator = {
		pk: 'question_id',
		crudUrl: {
			create: '/question/create',
			update: '/question/update?id=',
			remove: '/question/delete?id='
		},
		addAnswer: function (scales) {
			var answer = angular.copy(_templates.answer);
			angular.forEach(scales, function(scale){
				answer.scaleEffects[scale.getPk()] = {
					scale_id: scale.getPk(),
					name: scale.name,
					effect: ''
				};
			});
			this.answers.push(answer);
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
			update: '/scale/update?id=',
			remove: '/scale/delete?id='
		}
	};

	var _testDecorator = {
		templates: _templates,
		saveQuestion: function (question) {
			var _test = this;
			question.save().then(function (result) {
				var _newQuestion = angular.extend(result.data, _commonDecorator, _questionDecorator);
				_test.questions[_newQuestion.getPk()] = _newQuestion;
			});
		},
		isValid: function() {

		},
		saveScale: function (scale) {
			var _test = this;
			scale.save().then(function (result) {
				var _newScale = angular.extend(result.data, _commonDecorator, _scaleDecorator);
				_test.scales[_newScale.getPk()] = _newScale;
			});
		},
		deleteScale: function(scale) {
			var _test = this;
			scale.remove().then(function (result) {
				delete _test.scales[scale.getPk()];
			});
			return false;
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
				_testDecorator.templates[key]['test_id'] = parent.test_id;
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