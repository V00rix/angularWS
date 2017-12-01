(function () {
  "use strict";

  var RegistrationController = function ($scope, LoginService) { 
    var $ctrl = this;

    // regiter user data
    $ctrl.username = "";
    $ctrl.email = "";
    $ctrl.password = "";

    // error statuses
    $ctrl.usernameNotFree = null;
    $ctrl.emailNotFree = null;
    $ctrl.badUsername = null;

    $ctrl.$onInit = function() {
      LoginService.onRegistrationStart($scope);
    }


    $ctrl.checkUsername = function(valid) {
      if (valid) {  
        $ctrl.usernameNotFree = null;
        // some timeout to prevent fast dis-|reappearing
        let requestConfig = {
          username: $ctrl.username, 
          usernameCallback: function(status) {
            if (status) {
              $ctrl.usernameNotFree = true;
            }
            else 
              $ctrl.usernameNotFree = false;
          }
        };  
        LoginService.checkCredentials(requestConfig);
      }
    }

    // Validates email on input
    $ctrl.checkEmail = function(valid) {
      if (valid) {   
        $ctrl.emailNotFree = null;
        let requestConfig = {
          email: $ctrl.email, 
          emailCallback: function(status) {
            if (status)
              $ctrl.emailNotFree = false;
            else
              $ctrl.emailNotFree = true;
          }
        };
        LoginService.checkCredentials(requestConfig); 
      }
    }

    $ctrl.register =  function(valid) {
      if (valid) {      
        let requestConfig = {
          username: $ctrl.username, 
          email: $ctrl.email,
          password: $ctrl.password,
          successCallback: function() {
            console.log("Registration succeeded...");
          },
          failureCallback: function() {
            console.log("Registration failed...");            
          }
        };  
        LoginService.register(requestConfig); 
      }
    }
  }

  RegistrationController.$inject = ["$scope", "LoginService"];

  angular.module("app").component('wsRegistration', {
    templateUrl: './components/registration/registration.template.html',
    controller: RegistrationController,
  })
})();