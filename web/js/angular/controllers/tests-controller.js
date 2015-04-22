angular.module('sao').controller('TestController',
	['$scope', '$http', 'modal', 'decorate',
	 function ($scope, $http, modal, decorate) {
		 $scope.modal = modal;

		 $scope.initModel = function (test) {
			 test = decorate.test(angular.copy(test));
			 angular.forEach(test.scales, function (scale) {
				 scale = decorate.scale(scale);
				 test.scales[scale.getPk()] = scale;
			 	 test.templates.answer.scaleEffects[scale.getPk()] = decorate.scaleEffect(scale);
			 });
			 angular.forEach(test.questions, function (question) {
				 question = decorate.question(question);
				 var answers = [];
				 angular.forEach(question.answers, function (answer) {
					 answer = decorate.answer(answer);
					 angular.forEach(answer.effects, function (effect) {
						 effect = decorate.common(effect);
						 answer.effects[effect.getPk()] = effect;
					 });
					 this.push(answer);
				 }, answers);
				 this.answers = answers;
				 test.questions[question.getPk()] = question;
			 });

			 test.templates.question = decorate.question(test.templates.question);
			 test.templates.scale = decorate.scale(test.templates.scale);
			 test.templates.answer = decorate.answer(test.templates.answer);

			 $scope.test = test;
		 };

	 }]);