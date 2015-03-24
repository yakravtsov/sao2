angular.module('sao').controller('TestController',
	['$scope', '$http', 'modal', 'decorate',
	 function ($scope, $http, modal, decorate) {
//		 $scope.test = testContainer.get();
		 $scope.modal = modal;

		 $scope.initModel = function (test) {
			 test = decorate.test(test);
			 angular.forEach(test.questions, function (question) {
				 question = decorate.question(question);
				 angular.forEach(question.answers, function (answer) {
					 answer = decorate.common(answer);
					 angular.forEach(answer.effects, function (effect) {
						 effect = decorate.common(effect);
						 answer.effects[effect.getPk()] = effect;
					 });
					 question.answers[answer.getPk()] = answer;
				 });
				 test.questions[question.getPk()] = question;
			 });
			 angular.forEach(test.scales, function (scale) {
				 scale = decorate.scale(scale);
				 test.scales[scale.getPk()] = scale;
			 });

			 test.templates.question = decorate.question(test.templates.question);
			 test.templates.scale = decorate.scale(test.templates.scale);

			 $scope.test = test;
		 };

	 }]);