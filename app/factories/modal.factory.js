(function () {
  "use strict";

  /**
  * Factory for modal window
  */
  var modalFactory =  function ($compile, $rootScope, $controller, $q) {
    var service = {
      config: {
        useOverlay: true,
        container: document.body,
        data: null
      },
      open: open,
      close: close
    };

    return service;

    // define auxiliary variables
    var defered = null,
    template, html, scope,
    containerClass = 'ws-modal-container',
    overlayDivClass = 'ws-modal-overlay',
    useOverlay = config.useOverlay ===  false ? false : true,
    container = angular.element(config.selector || document.body),
    overlayDiv = '<div class="'+ overlayDivClass + '"></div>';

    if (config.templateUrl) {
      $http.get(config.templateUrl).then(function(response) {
        template = response.data;
          // the html var has to be set on the 2 options of the conditional since one has an async call
          html = '<div class="' + containerClass + '"><div class="ws-modal"><a href="" class="ws-modal-close" ws-click="close()">&times;</a>' + template + '</div></div>';
        });
    } else {
      template= config.template
      html = '<div class="' + containerClass + '"><div class="ws-modal"><a href="" class="ws-modal-close" ws-click="close()">&times;</a>' + template + '</div></div>';
    }

      /**
      * Activates the modal
      * @param {any} localVars Data passed from the caller controller
      * @return {promise} Promise with resolve on successfull window close and reject on any other close
      */
      function open(config) {
        deferred = $q.defer();
        var domElement, overlay;
        scope = $rootScope.$new();
        // assign the deactivation function to the created scope
        scope.close = close;

        // if there's a modal already on the DOM, remove it before adding another
        domElement = angular.element(document.querySelectorAll('.'+containerClass));
        domElement.remove();

        // if there's an overlay div already on the DOM, remove it before adding another
        overlay = angular.element(document.querySelectorAll('.' + overlayDivClass));
        overlay.remove();

        // if there's data passed along, copy it to the created scope
        if (localVars) {
          for (var prop in localVars) {
            scope[prop] = localVars[prop];
          }
        }

        // create DOM elements
        domElement = angular.element(html);

        // the $compile() function compiles an HTML String/DOM into a template and produces a template function, which then is used
        // to link the template and a scope together
        $compile(domElement)(scope);

        if (useOverlay) {
          overlay = angular.element(overlayDiv);
          angular.element(document.body).append(overlay);
        }
        container.prepend(domElement);
      }

      function close() {
        var domElement = angular.element(document.querySelectorAll('.' + containerClass)),
        overlay = angular.element(document.querySelectorAll('.' + overlayDivClass));
        if (domElement) {
          domElement.remove();
        }
        if (overlay) {
          overlay.remove();
        }
        scope.$destroy();
      }
    };

    modalFactory.$inject = ["$compile", "$rootScope", "$controller", "$q"];

    angular.module("app").factory("modalFactory", modalFactory);
  })();