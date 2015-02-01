var sao = angular.module('sao', [])/*.config(function($routeProvider, $locationProvider) {
    $locationProvider.html5Mode(true);
})*/;
    sao.controller('TestController',
    ['$scope', '$http',
        function ($scope, $http) {
            $scope.test = {};
            $scope.modalHeader = '';
            $scope.init = function($a) {
                $scope.a = $a;
            };

            $scope.initModel = function(model) {
                $scope.test = model;
            };

            $scope.newQuestion = function() {
                $scope.modalHeader = 'Новый вопрос';
            };
            $scope.$watch('test', function(newVal, oldVal, scope){
                console.log(JSON.stringify(scope.test));
                $http({
                    method : 'POST',
                    url : '/test/update?id=' + scope.test.test_id,
                    data: JSON.stringify({Test: scope.test}),
                    headers : {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
                });

            }, true)
        }]);