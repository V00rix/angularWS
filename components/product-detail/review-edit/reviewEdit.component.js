(function () {
  "use strict";

  var ReviewEditController = function ($scope) { 
    var ctrl = this;

    // Parameters
    ctrl.rating = 3;
    ctrl.hovered = null;

    // Functions
    ctrl.getCurrentUser = getCurrentUser;

    function getCurrentUser() {
      return {username: "Some fake username"};
    }
  }

  app.component('wsReviewEdit', {
    templateUrl: './components/product-detail/review-edit/reviewEdit.template.html',
    controller: ReviewEditController,
  })
})();