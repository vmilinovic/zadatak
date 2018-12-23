angular.module('loginModule', ['ngRoute'])
    .controller('loginCtrl', ['$scope', 'myUtil', loginCtrlFn]);

function loginCtrlFn($scope, myUtil) {
    $scope.username = '';
    $scope.password = '';
    $scope.login = function(    ){
        var userCredentials = {username: $scope.username, password: $scope.password};
        myUtil.login(userCredentials);
    }
}