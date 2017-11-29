(function () {
    "use strict";

    var testerDirective = function () { 
        return {
            require: "ngModel",
            link: function (scope, elm, attrs, ctrl) {
                ctrl.$validators.tester = function (modelValue) {
                    this.regexs = [
                    { reg: /^(([a-z -'`A-Z]*)|([а-я -'`А-Я]*)|([a-z -'`A-ZěščřžýáíéúůĚŠČŘŽÝÁÍÉÚŮ]*))$/, key: "name" },
                    { reg: /^((\+[0-9][0-9][0-9][ -]?)?[0-9][0-9][0-9][ -]?[0-9][0-9][0-9][ -]?[0-9][0-9][0-9])$/, key: "phone" },
                    { reg: /^([a-zA-Z0-9.])*@([a-zA-Z])*\.([a-zA-Z])+$/, key: "email" },
                    { reg: /^ *$/, key: "empty" },
                    { reg: /^.*$/, key: "any" }
                    ];

                    if (ctrl.$isEmpty(modelValue)) {
                        return true;
                    }

                    switch (attrs.tester) {
                        case "amount":
                        return (modelValue >= 20000 && modelValue <= 500000 );
                        case "duration":
                        return (modelValue >= 6 && modelValue <= 96);
                        case "interest":
                        return (modelValue >= 0 && modelValue < 1);
                        case "phone":
                        window.console.log(this.regexs.find(r => r.key === "phone"));
                        return this.regexs.find(r => r.key === "phone").reg.test(modelValue);
                        case "email":
                        return this.regexs.find(r => r.key === "email").reg.test(modelValue);
                        case "name":
                        return this.regexs.find(r => r.key === "name").reg.test(modelValue);
                        default:
                        return false;
                    }
                }
            }
        }
    };
    
    testerDirective.$inject = [];

    angular.module("app").directive("tester", testerDirective);
})();