(function () {
  "use strict";

  /**
  * Factory for confirmation window
  */
  var confirmationFactory =  function ($compile, $rootScope, $http, $controller, $q, confirmationController) {
    var service = {
      data: {
        container: null,
      },
      scope: null,
      overlay: null,
      deferred: null,
      template: null,
      domElement: null,
      confirm: confirm,
      close: close,
      confirmCallback: () => {},
      cancelCallback: () => {}
    };


    return service;

      /**
      * Activates the confirmation
      * @param {any} localVars Data passed from the caller controller
      * @return {promise} Promise with resolve on successfull window close and reject on any other close
      */
      function confirm(data, confirmCallback, cancelCallback) {    
        if (confirmCallback)
          service.confirmCallback = confirmCallback;
        if (cancelCallback)
          service.cancelCallback = cancelCallback;

        $http.get("./factories/confirmation/template.html").then(function(response) {
          service.template = response.data;

          service.scope = $rootScope.$new();

          // assign the deactivation function to the created scope
          service.scope.close = close;
          service.scope.ok = ok;
          service.scope.controller = confirmationController; 

          // if there's a confirmation already on the DOM, remove it before adding another
          service.domElement = angular.element(document.querySelectorAll('.ws-confirmation-container'));
          service.domElement.remove();

          // if there's an overlay div already on the DOM, remove it before adding another
          service.overlay = angular.element(document.querySelectorAll('.ws-confirmation-overlay'));
          service.overlay.remove();

          // if there's data passed along, copy it to the created scope
          if (data) {
            for (var prop in data) {
              service.scope[prop] = data[prop];
            }
          }

          // default values
          service.scope.optionOk = data.optionOk || "Ok";
          service.scope.optionCancel = data.optionCancel || "Cancel";

          // create DOM elements
          service.domElement = angular.element(service.template);

          // the $compile() function compiles an HTML String/DOM into a template and produces a template function, which then is used
          // to link the template and a scope together
          $compile(service.domElement)(service.scope);

          // set the element to appent confirmation to
          service.data.container = angular.element(service.data.selector || document.body),

          service.data.container.prepend(service.domElement);

        });
      }

      function close() {
        var domElement = angular.element(document.querySelectorAll('.ws-confirmation-container')),
        overlay = angular.element(document.querySelectorAll('.ws-confirmation-overlay'));
        if (domElement) {
          domElement.remove();
        }
        if (overlay) {
          overlay.remove();
        }
        service.scope.$destroy();
        service.cancelCallback();
      }

      function ok(data) {
        var domElement = angular.element(document.querySelectorAll('.ws-confirmation-container')),
        overlay = angular.element(document.querySelectorAll('.ws-confirmation-overlay'));
        if (domElement) {
          domElement.remove();
        }
        if (overlay) {
          overlay.remove();
        }
        service.scope.$destroy();
        service.confirmCallback();
      }
    }

    confirmationFactory.$inject = ["$compile", "$rootScope", "$http", "$controller", "$q"];

    angular.module("app").factory("confirmationFactory", confirmationFactory);
  })();