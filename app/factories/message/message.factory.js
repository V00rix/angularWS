(function () {
  "use strict";

  /**
  * Factory for message window
  */
  var messageFactory =  function ($compile, $rootScope, $http, $q) {
    var service = {
      scope: null,
      deferred: null,
      template: null,
      domElement: null,
      timeout: null,
      // functions
      display: display,
      close: close
    };

    return service;

    /**
    * Activates the message
    * @param {any} localVars Data passed from the caller
    * @return {promise} Promise with resolve on successfull window close and reject on any other close
    */
    function display(messages, severity = "success", fadeOutTime = 3000) {    
      $http.get("./factories/message/template.html").then(function(response) {
        service.template = response.data;
        service.scope = $rootScope.$new();

        // assign the deactivation function to the created scope
        service.scope.close = close;

        // if there's a message already on the DOM, remove it before adding another
        service.domElement = angular.element(document.querySelectorAll('.ws-message-container'));
        service.domElement.remove();

        // assign message passed to scope
        if (typeof messages === "string") 
          service.scope.messages = [messages];
        else if (Array.isArray(messages))
          service.scope.messages = messages;
        service.scope.severity = severity;

        // create DOM elements
        service.domElement = angular.element(service.template);

        // the $compile() function compiles an HTML String/DOM into a template and produces a template function, which then is used
        // to link the template and a scope together
        $compile(service.domElement)(service.scope);

        // set the element to appent message to
        angular.element(document.body).prepend(service.domElement);

        if (fadeOutTime && fadeOutTime !== 0)
          service.timeout = setTimeout(() => {
            close();
          }, fadeOutTime);
      });
    }

    function close() {
      if (service.timeout)
        clearTimeout(service.timeout);
      var domElement = angular.element(document.querySelectorAll('.ws-message-container'));
      if (domElement) {
        domElement.remove();
      }
      service.scope.$destroy();
    }
  }

  messageFactory.$inject = ["$compile", "$rootScope", "$http", "$q"];

  angular.module("app").factory("messageFactory", messageFactory);
})();