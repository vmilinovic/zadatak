angular.module('addModule', ['ngRoute'])
    .controller('addCtrl', ['$scope', '$http', '$location', 'myUtil', addCtrlFn]);

function addCtrlFn($scope, $http, $location, myUtil) {
    myUtil.checkSession();

    $scope.roles = [
        {
            id: 1,
            name: 'admin'
        },
        {
            id: 2,
            name: 'dr'
        },
        {
            id: 2,
            name: 'nurse'
        }];
    $scope.selectedRole = $scope.roles[0];

    $scope.createUser = function(username,password,firstname,lastname,role) {
        $http({
            method: 'POST',
            url: 'php/createUser.php',
            data: {
                'username' : username,
                'password' : password,
                'firstname' : firstname,
                'lastname' : lastname,
                'role' : role
            }
        }).then(function (res) {
            alert(res.data.result.msg);
            if (res.data.result.code == 0){
                $location.path("/dashboard");
            }
        })


    }
}