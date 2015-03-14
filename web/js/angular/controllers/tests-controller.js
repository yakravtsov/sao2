angular.module('sao').controller('TestController',
	['$scope', '$http', 'decorate', 'modalHeader',
	 function ($scope, $http, decorate, modalHeader) {
		 $scope.test = {};

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

			 $scope.test = test;
		 };

		 /*$scope.$watch('test', function (newVal, oldVal, scope) {
		  $http({
		  method: 'POST',
		  url: '/test/update?id=' + scope.test.test_id,
		  data: JSON.stringify({Test: scope.test}),
		  headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		  });

		  }, true)*/


	 }]);