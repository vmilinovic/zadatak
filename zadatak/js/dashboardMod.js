angular.module('dashboardModule', ['ngRoute', 'util'])
    .controller('dashboardCtrl', ['$scope', '$rootScope', '$http', '$location', 'myUtil', dashboardCtrlFn]);

function dashboardCtrlFn($scope, $rootScope, $http, $location, myUtil) {

    myUtil.checkSession();
    $rootScope.isLogin = true;
    $scope.customers = [];
    $scope.limits = [10,50,100];
    $scope.firstname = '';
    $scope.lastname = '';
    $scope.limit = 10;

    $scope.manageCustomer = function(customer) {
        localStorage.setItem('currentCustomer', JSON.stringify(customer));
        $location.path("/customer");

    };
    $scope.manageIll = function(id) {
        sessionStorage.setItem('customerId', id);
        $location.path("/illness");
    };

    $scope.search = function(){
        $http({
            url: "php/getCustomer.php",
            method: "GET",
            params: {
                firstname: $scope.firstname,
                lastname: $scope.lastname,
                limit: $scope.limit
            }
        }).then(function(response) {
            var result = response.data.result;
            if (result.code == 0){
                $scope.customers = result.customers;
            } else {
                alert('Error!');
            }

        });
    };
    $scope.search($scope.firstname,$scope.lastname,$scope.limit);
}