angular.module('util', ['ngRoute']);
angular.module('util').factory('myUtil', ['$http', '$location', myUtilFn]);
function myUtilFn ($http,$location) {
    return {
        login: function (userCredentials) {
            $http({
                method: 'POST',
                url: 'php/login.php',
                data: {
                    'username' : userCredentials.username,
                    'password' : userCredentials.password
                }
            }).then(function (res) {
                var result = res.data.result;
                if(result != undefined && result.code ==0){
                    localStorage.setItem('userId', result.id);
                    localStorage.setItem('sessionKey', result.sessionKey);
                    $location.path('/dashboard');
                } else {
                    localStorage.clear();
                }
            });
        },
        logout: function () {
            localStorage.clear();
            $location.path('/login');
        },
        checkSession: function () {
            var userId = localStorage.getItem('userId');
            var sessionKey = localStorage.getItem('sessionKey');

            if (userId !=undefined && sessionKey != undefined) {
                var req = {'sessionKey': sessionKey, 'userId': userId};
                $http({
                    method: 'POST',
                    url: 'php/checkSession.php',
                    data: req
                }).then(function (res) {
                    var result = res.data.result;
                    if(result != undefined && result.code ==0){
                    } else {
                        localStorage.clear();
                        $location.path('/login');
                    }
                })
            }
            else {
                localStorage.clear();
                $location.path('/login');
            }
        }
    }
}
