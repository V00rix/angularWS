(function() {
    "use strict";

    var UsersController = function ($scope, $http) {
        var $ctrl = this;

        $ctrl.users = [];
        $ctrl.selectedUser = null;
        $ctrl.selectedUserId = null;
        $ctrl.editing = false;
        $ctrl.editPassword = false;
        $ctrl.getRequestUrl = "../php/requests/admin/users/getUserList.request.php";
        $ctrl.updateRequestUrl = "../php/requests/admin/users/updateUserList.request.php";

        $ctrl.$onInit = function() {
            $http.get($ctrl.getRequestUrl).then(
                (res) => {
                    console.log(res);
                    $ctrl.users = res.data || [];
                    $ctrl.users.forEach(u => u.password = "");
                },
                (res) => {
                    console.error(res);
                });
        }

        $ctrl.saveUsers = function() {
            $http.post($ctrl.updateRequestUrl, $ctrl.users).then(
                (res) => {
                    console.log(res);
                    console.log('Success');
                },
                (res) => {
                    console.error(res);
                });
        }

        $ctrl.UserSelected = function(id) {
            $ctrl.editing = true;
            $ctrl.selectedUserId = id;
            $ctrl.selectedUser = angular.copy($ctrl.users[id]);
        }

        $ctrl.newUser = function() {
            $ctrl.selectedUser = new User();
            $ctrl.editing = true;
        }

        $ctrl.editConfirmed = function(valid) {
            if (valid) {
                if ($ctrl.selectedUserId || $ctrl.selectedUserId === 0)
                    $ctrl.users[$ctrl.selectedUserId] = angular.copy($ctrl.selectedUser);
                else
                    $ctrl.users.push(angular.copy($ctrl.selectedUser)); 
                $ctrl.closeEdit();
                $ctrl.saveUsers();
            }
        }

        $ctrl.editCanceled = function() {
            $ctrl.closeEdit();
        }

        $ctrl.deleteUser = function() {
            if ($ctrl.selectedUserId || $ctrl.selectedUserId === 0) {
                $ctrl.users.splice($ctrl.selectedUserId, 1);
                $ctrl.saveUsers();
            }
            $ctrl.closeEdit();
        }

        $ctrl.closeEdit = function() {     
            $ctrl.editPassword = false; 
            $ctrl.selectedUser = null;
            $ctrl.selectedUserId = null;
            $ctrl.editing = false;
        }
    }

    angular.module("app").component('wsUsers', {
       templateUrl: './app/components/users/users.template.html',
       controller: UsersController,
   });
})();