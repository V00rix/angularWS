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
      return 'ws-rating-' + $ctrl.review.rating; 
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