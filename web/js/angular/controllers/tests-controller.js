angular.module('sao').controller('TestController',
	['$scope', '$http', 'decorate', 'modal',
	 function ($scope, $http, decorate, modal) {
		 $scope.test = {};
		 $scope.modal = modal;

		 $scope.initModel = function (test) {
			 test = decorate.test(test);
			 angular.forEach(test.questions, function (question, key) {
				 question = decorate.question(question);
				 angular.forEach(question.answers, function (answer, key) {
					 answer = decorate.common(answer);
					 angular.forEach(answer.effects, function (effect, key) {
						 answer.effects[key] = decorate.common(effect);
					 });
					 question.answers[key] = answer;
				 });
				 test.questions[key] = question;
			 });
			 angular.forEach(test.scales, function (scale, key) {
				 test.scales[key] = decorate.common(scale);
			 });
			 test.templates.question = decorate.question(test.templates.question);
			 test.templates.scale = decorate.scale(test.templates.scale);
			 $scope.test = test;
		 };

	 }]);