angular.module('sao').factory('decorate', ['$http', 'modal', '$rootScope', '$q', function ($http, modal, $rootScope, $q) {
	var _templates = {
		question: {
			question_id: null,
			root: null,
			lft: 1,
			rgt: 1,
			depth: 1,
			settings: null,
			name: '',
			type: 0,
			created: null,
			updated: null,
			author_id: null,
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
			answer_id: null,
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
			return $http.post(this.isNewRecord() ? this.crudUrl.create : this.crudUrl.update + this.getPk(), this);
		},
		remove: function () {
			return $http.post(this.crudUrl.remove + this.getPk(), this);
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
		addAnswer: function () {
			this.answers.push(angular.extend(angular.copy(_templates.answer), _commonDecorator, _answerDecorator));
		},
		removeAnswer: function (answer) {
			var answers = [];
			angular.forEach(this.answers, function (one) {
				if (!angular.equals(one, answer)) {
					answers.push(one);
				}
			});
			this.answers = answers;
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
		},
		effect: function (scale) {
			return {
				scale_id: scale.getPk(),
				name: scale.name,
				operation: 1,
				value: 0
			}
		}
	};

	var _answerDecorator = {
		pk: 'answer_id'
	};

	var _testDecorator = {
		templates: _templates,
		saveQuestion: function (modal) {
			var _test = this;
			var question = modal.getCurrentObject();
			question.save().then(function (result) {
				var _newQuestion = angular.extend(result.data, _commonDecorator, _questionDecorator);
				_test.questions[_newQuestion.getPk()] = _newQuestion;
				modal.clear();
			});
		},
		deleteQuestion: function (question) {
			var _test = this;
			question.remove().then(function (result) {
				delete _test.questions[question.getPk()];
			});
			return false;
		},
		isValid: function () {

		},
		saveScale: function (scale) {
			var _test = this;
			scale.save().then(function (result) {
				var _newScale = angular.extend(result.data, _commonDecorator, _scaleDecorator);
				_test.scales[_newScale.getPk()] = _newScale;
				_test.templates.answer.scaleEffects[_newScale.getPk()] = _newScale.effect(scale);
				modal.clear();
			});
		},
		deleteScale: function (scale) {
			var _test = this;
			scale.remove().then(function (result) {
				delete _test.scales[scale.getPk()];
				var scaleEffects = {};
				angular.forEach(_test.templates.answer.scaleEffects, function (effect) {
					if (effect.scale_id != scale.getPk()) {
						scaleEffects[effect.scale_id] = effect;
					}
				});
				_test.templates.answer.scaleEffects = scaleEffects;
			});
			return false;
		}
	};
	return  {
		scaleEffect: function (parent) {
			return _scaleDecorator.effect(parent);
		},
		common: function (parent) {
			return angular.extend(parent, _commonDecorator);
		},
		answer: function (parent) {
			return angular.extend(parent, _commonDecorator, _answerDecorator);
		},
		nested: function (parent) {
			return angular.extend(parent, _nestedDecorator);
		},
		test: function (parent) {
			angular.forEach(_testDecorator.templates, function (question, key) {
				_testDecorator.templates[key]['test_id'] = parent.test_id;
			});
			return angular.extend(parent, _testDecorator);
		},
		question: function (parent) {
			return angular.extend(parent, _commonDecorator, _questionDecorator, _nestedDecorator);
		},
		scale: function (parent) {
			return angular.extend(parent, _commonDecorator, _scaleDecorator);
		}
	}
}]);