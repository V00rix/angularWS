(function () {
  "use strict";

  var RegistrationController = function ($scope, LoginService, $location) { 
    var $ctrl = this;

    // regiter user data
    $ctrl.username = "";
    $ctrl.email = "";
    $ctrl.password = "";

    // error statuses
    $ctrl.usernameNotFree = null;
    $ctrl.emailNotFree = null;
    // unhandled error
    $ctrl.unhandledError = null;

    $ctrl.$onInit = function() {
      LoginService.onRegistrationStart();
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
              $ctrl.emailNotFree = status;
          }
        };
        LoginService.checkCredentials(requestConfig); 
      }
    }

    $ctrl.register =  function(valid) {
      if (valid && !$ctrl.usernameNotFree && !$ctrl.emailNotFree) {      
        let requestConfig = {
          username: $ctrl.username, 
          email: $ctrl.email,
          password: $ctrl.password,
          successCallback: function() {
            console.log("Registration succeeded...");
            LoginService.checkCredentials({
              username: $ctrl.username,
              password: $ctrl.password,
              successCallback: () => {
                LoginService.userChanged(new User($ctrl.username));
              }
            })
            $location.path('/products');
          },
          failureCallback: function(error) {
            console.log("Registration failed...");  
            $ctrl.unhandledError = error.data;          
          }
        };  
        LoginService.register(requestConfig); 
      }
    }
  }

  RegistrationController.$inject = ["$scope", "LoginService", "$location"];

  angular.module("app").component('wsRegistration', {
    templateUrl: './components/registration/registration.template.html',
    controller: RegistrationController,
  })
})();