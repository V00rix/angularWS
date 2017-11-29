(function () {
  "use strict";

  var ReviewEditController = function ($scope, LoginService) { 
    var ctrl = this;

    // Parameters
    ctrl.hovered = null;

    // Currnet review model
    ctrl.review = {
      rating: 3,
      title: null,
      description: null
    };

    // Functions
    ctrl.getCurrentUser = function() {
      return LoginService.currentUser;
    };

    ctrl.submitReview = function(formValid) {
      if (formValid) {
        var review = new Review(ctrl.getCurrentUser(), ctrl.review.rating, ctrl.review.title, ctrl.review.description, new Date());
        ctrl.reviewAdded({review: review});
      }
    };
  }

  ReviewEditController.$inject = ["$scope", "LoginService"];

  angular.module("app").component('wsReviewEdit', {
    templateUrl: './components/product-detail/review-edit/reviewEdit.template.html',
    controller: ReviewEditController,
    bindings: {
      reviewAdded: '&'
    }
  })
})();