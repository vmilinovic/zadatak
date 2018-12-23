angular.module('myApp', [
    'ngRoute',
    'util',
    'loginModule',
    'dashboardModule',
    'addModule',
    'customerModule',
    'illnessModule'
]);

angular.module('myApp')
    .config(['$routeProvider',function($routeProvider){
        $routeProvider.
        when("/dashboard",
            {
                templateUrl: "html/dashboard.html",
                controller: "dashboardCtrl"
            }
        ).
        when("/customer",
            {
                templateUrl: "html/customer.html",
                controller: "customerCtrl"
            }
        ).
        when("/newCustomer",
            {
                templateUrl: "html/customer.html",
                controller: "customerCtrl"
            }
        ).
        when("/illness",
            {
                templateUrl: "html/illness.html",
                controller: "illnessCtrl"
            }
        ).
        when("/newIllness",
            {
                templateUrl: "html/illness.html",
                controller: "illnessCtrl"
            }
        ).
        when("/add",
            {
                templateUrl: "html/add.html",
                controller: "addCtrl"
            }
        ).
        when("/login",
            {
                templateUrl: "html/login.html",
                controller: "loginCtrl"
            }
        ).
        otherwise(
            {
                redirectTo: "/dashboard"
            }
        );
    }])
    .controller('appCtrl', ['$scope', '$rootScope', '$location', 'myUtil', appCtrlFn]);

    function appCtrlFn($scope, $rootScope, $location, myUtil) {
        $rootScope.isLogin = false;

        if (!myUtil.checkSession()){
            myUtil.logout();
            $rootScope.isLogin = false;
        }
        else {
            $rootScope.isLogin = true;
        }

        $scope.goHome = function () {
            $location.path('/dashboard');
        };
        $scope.createUser = function () {
            $location.path('/add');
        };
        $scope.createCustomer = function () {
            $location.path('/newCustomer');
        };
        $scope.createIllness = function () {
            $location.path('/newIllness');
        };
        $scope.logout = function () {
            $rootScope.isLogin = false;
            myUtil.logout();
        }
    }