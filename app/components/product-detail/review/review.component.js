(function () {
  "use strict";

  var ReviewController = function ($scope) { 
    var $ctrl = this;

    // Parameters
    $ctrl.rating = 3;
    $ctrl.hovered = null;

    // Functions
    $ctrl.reviewColor = reviewColor;
    $ctrl.getNumber = getNumber;

    function $onInit() {
    }

    function reviewColor() {
      switch($ctrl.review.rating) {
        case 1:
        return 'rgba(192, 24, 24, 0.95)';
        case 2:
        return 'rgba(234, 182, 87, 0.95)';
        case 3:
        return 'rgba(234, 228, 38, 0.95)';
        case 4:
        return 'rgba(90, 168, 164, 0.95)';
        case 5:
        return 'rgba(164, 217, 135, 0.95)';
      }
    }

    function getNumber(num) {
      return new Array(num);
    }
  }

  ReviewController.$inject = ["$scope"];

  angular.module("app").component('wsReview', {
    templateUrl: './components/product-detail/review/review.template.html',
    controller: ReviewController,
    bindings: {
      review: '<'
    }
  })
})()