(function () {
  "use strict";

  var ReviewController = function ($scope) { 
    var ctrl = this;

    // Parameters
    ctrl.rating = 3;
    ctrl.hovered = null;

    // Functions
    ctrl.reviewColor = reviewColor;
    ctrl.getNumber = getNumber;

    function $onInit() {
    }

    function reviewColor() {
      switch(ctrl.review.rating) {
        case 1:
        return '#ff06063d';
        case 2:
        return '#ff6b065c';
        case 3:
        return '#b6fff175';
        case 4:
        return '#eeffe2';
        case 5:
        return '#dcffc9';
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