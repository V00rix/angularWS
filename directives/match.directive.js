(function () {
    "use strict";

    var matchDirective = function () { 
        return {
            // require: 'ngModel',
            // link: function (scope, elem, attrs, ctrl) {
            //     var firstPassword = '#' + attrs.match;
            //     elem.add(firstPassword).on('keyup', function () {
            //         scope.$apply(function () {
            //             var v = elem.val() === $(firstPassword).val();
            //             ctrl.$setValidity('match', v);
            //         });
            //     });
            // }
        }
    }


    matchDirective.$inject = [];

    angular.module("app").directive("match", matchDirective);
})();