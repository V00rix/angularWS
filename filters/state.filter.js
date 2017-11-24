(function () {
	"use strict";

	var stateFilter = function() {
		return function(input) {
			input = input || "0";
			var out;
			window.console.log(input);
			switch (input) {
				case "0":
				out = "Not yet contacted";
				break;
				case "1":
				out = "Could not make contact";
				break;
				case "2":
				out = "Contacted, confirmed";
				break;
				case "3":
				out = "Contacted, accepted";
				break;
				default:
				out = "Invalid contact state";
				break;
			}
			return out;
		};
	};

	angular.module("app").filter("state", stateFilter);
})();