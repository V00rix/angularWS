(function () {
    "use strict";

    var matchDirective = function () { 
        return {
            require: 'ngModel',
            link: function (scope, elem, attrs, ctrl) {
                var firstPassword = angular.element( document.querySelector( '#' + attrs.match ) );;
                elem.on("keyup", function () {
                    scope.$apply(function () {
                        var v = elem.val() === firstPassword.val();
                        ctrl.$setValidity('pwmatch', v);
                    });
                });
            }
        }
    }


    matchDirective.$inject = [];

    angular.module("app").directive("match", matchDirective);
})();