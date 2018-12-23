angular.module('illnessModule', ['ngRoute', 'util'])
    .controller('illnessCtrl', ['$scope', '$http', '$location', 'myUtil', illnessCtrlFn]);

function illnessCtrlFn($scope, $http, $location, myUtil) {
    myUtil.checkSession();

    $scope.customerId = sessionStorage.getItem('customerId');

    sessionStorage.removeItem('customerId');
    $scope.stateCustomerData = 'create';
    $scope.currtentIllness = {
        'id': '*',
        'comment': 'No comment'
    };
    $scope.allIllnesses = [{
        'id': '*',
        'name': 'no',
        'description': 'nothing'
    }];
    $scope.customerIllnesses = [{
        'id': '*',
        'name': 'no',
        'description': 'nothing'
    }];

    $scope.getAllIllness = function(){
        $http.get("php/getAllIllness.php")
            .then(function(response) {
                var result = response.data.result;
                if (result.code == 0){
                    $scope.allIllnesses = result.illnesses;
                } else {
                    alert('Error')
                }
            });
    };
    $scope.getAllIllness();
    $scope.getCustomerIllness = function(){
        $http({
            url: "php/getCustomerIllness.php",
            method: "GET",
            params: {customerId: $scope.customerId}
        }).then(function(response) {
                var result = response.data.result;
                if (result.code == 0){
                    $scope.customerIllnesses = result.illnesses;
                } else {
                    alert('Error')
                }
            });
    };
    $scope.getAllIllness();
    if ($scope.customerId != undefined){
        $scope.status = 'edit';
        $scope.getCustomerIllness();
    } else {
        $scope.status = 'create';
    }




    $scope.deleteIllnesFromCustomer = function(ind) {
        var deleteCustomer = confirm("Are you sure?");
        if (deleteCustomer == true) {
            $http({
                method: 'DELETE',
                url: 'php/deleteIllnesFromCustomer.php',
                data: {
                    'ind' : ind
                }
            }).then(function (res) {
                alert(res.data.result.msg);
                $scope.getCustomerIllness();
            })
        }

    };
    $scope.deleteIllnesFromIllnesses = function(id) {
        var deleteCustomer = confirm("Are you sure?");
        if (deleteCustomer == true) {
            $http({
                method: 'DELETE',
                url: 'php/deleteIllnesFromIllnesses.php',
                data: {
                    'id' : id
                }
            }).then(function (res) {
                alert(res.data.result.msg);
                if (result.code == 0) {
                    $scope.getAllIllness();
                }
            })
        }
    };

    $scope.addIllnessToCustomer = function(illnessId,customerId,comment){
        $http({
            method: 'POST',
            url: 'php/addIllnessToCustomer.php',
            data: {
                "illnessId" : illnessId,
                "customerId" : customerId,
                "comment" : comment
            }
        }).then(function (res) {
            var result = res.data.result;
            alert(result.msg);
            if (result.code == 0) {
                $scope.getCustomerIllness();
            }
        })
    };
    $scope.addIllnessToIllnesses = function(name,description){
        $http({
            method: 'POST',
            url: 'php/addIllnessToIllnesses.php',
            data: {
                "name": name,
                "description": description
            }
        }).then(function (res) {
            var result = res.data.result;
            alert(result.msg);
            if (result.code == 0) {
                $scope.getAllIllness();
            }
        })
    };

    $scope.showData = function (data) {
        alert(data);
    }
}