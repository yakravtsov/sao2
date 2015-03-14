angular.module('sao').factory('decorate', ['$http', 'modalHeader', function ($http, modalHeader) {
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
			$http({
				method: 'POST',
				url: this.crudUrl.save,
				data: JSON.stringify({Question: $scope.scale}),
				headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
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
		modalType: 'question',
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
		modalType: 'scale'
	};

	var _testDecorator = {
		templates: _templates,
		addQuestion: function () {
			modalHeader.set('Новый вопрос');
			this.questions.push(this.templates.question);
		},
		addScale: function () {
			modalHeader.set('Новая шкала');
			this.scales.push(this.templates.scale);
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
			return angular.extend(parent, _testDecorator)
		},
		question: function (parent) {
			return angular.extend(parent, _commonDecorator, _questionDecorator, _nestedDecorator)
		}
	}
}]);