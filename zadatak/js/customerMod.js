angular.module('customerModule', ['ngRoute', 'util'])
    .controller('customerCtrl', ['$scope', '$http', '$location', '$window', 'myUtil', customerCtrlFn]);

function customerCtrlFn($scope, $http, $location, $window, myUtil) {
    myUtil.checkSession();
    $scope.logout = function(){
        myUtil.logout();
    };

    $scope.customer = {
        'firstname': '',
        'lastname': '',
        'street': '',
        'streetNumber': '',
        'zipCode': '',
        'phone': '',
        'birthDate': '',
        'userId': '',
        'img': '',
        'pdf': '',
        'word': '',
    };


    var currentCustomer = JSON.parse(localStorage.getItem('currentCustomer'));
    localStorage.removeItem('currentCustomer');
    if (currentCustomer != null) {
        $scope.status = 'edit';
        $scope.customer = currentCustomer;
        $scope.customer.birthDate = new Date($scope.customer.birthDate);
    } else {
        $scope.status = 'create';
    }
    $scope.manageIllness = function () {
        sessionStorage.setItem('customerId',$scope.customer.id);
        $location.path("/illness");
    };
    $scope.createCustomer = function(){
        $http({
            method: 'POST',
            url: 'php/createCustomer.php',
            data: {
                'customer' : $scope.customer
            }
        }).then(function (res) {
            alert(res.data.result.msg);
            if (res.data.result.code == 0){
                $location.path("/dashboard");
            }
        })
    };
    $scope.updateCustomer = function(){
        $http({
            method: 'PUT',
            url: 'php/updateCustomer.php',
            data: {
                'customer' : $scope.customer
            }
        }).then(function (res) {
            alert(res.data.result.msg);
            $location.path("/dashboard");
        })
    };
    $scope.deleteCustomer = function(){
        var deleteCustomer = confirm("Are you sure?");
        if (deleteCustomer == true) {
            $http({
                method: 'DELETE',
                url: 'php/deleteCustomer.php',
                data: {
                    'id' : $scope.customer.id
                }
            }).then(function (res) {
                alert(res.data.result.msg);
                $location.path("/dashboard");
            })
        }
    };

    $scope.data = {};
    var fileSelect = document.createElement('input');
    fileSelect.type = 'file';

    if (fileSelect.disabled) { //check if browser support input type='file' and stop execution of controller
        alert("browser done't support input type='file'")
    }

    fileSelect.onchange = function() {
        var f = fileSelect.files[0],
            r = new FileReader();

        r.onloadend = function(e) { //callback after files finish loading
            $scope.data.b64 = e.target.result;

            if($scope.fileAdded == 'img'){
                $scope.customer.img = $scope.data.b64;
            }
            if($scope.fileAdded == 'pdf'){
                $scope.customer.pdf = $scope.data.b64;
            }
            if($scope.fileAdded == 'word'){
                $scope.customer.word = $scope.data.b64;
            }
            $scope.$apply();

        }

        r.readAsDataURL(f);
    };

    $scope.fileAdded ="";
    $scope.fileLoaded ="";
    $scope.addFile = function(file) {
        $scope.fileAdded = file;
        fileSelect.click();
    };

    $scope.openFile = function(file){
        if (file == 'pdf') {
            $window.open($scope.customer.pdf);
        }
        if (file == 'word') {
            $window.open($scope.customer.word);
        }
    }


}