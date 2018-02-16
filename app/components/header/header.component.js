(function() {
	"use strict";

	var HeaderController = function ($scope, ProductsService, LoginService, confirmationFactory) {
		var $ctrl = this;

		$ctrl.displayLogin = false;
		$ctrl.userDataDisplayed = false;
		$ctrl.cartProducts = null;
		$ctrl.timeout = null;

		$ctrl.$onInit = function() {
			LoginService.subscribe($scope, () => {
				$ctrl.displayLogin = false;
			});	
			LoginService.loggedIn();
			ProductsService.getTemporary().then(
				(prods)=>{
					$ctrl.cartProducts = prods;
				});
		};

		$ctrl.getFullLength = function() {
			return ProductsService.cartProducts.fullLength;
		};

		$ctrl.deleteAccount = function() {
			confirmationFactory.confirm({message: "Are you sure you want to delete your account?", optionOk: "Yes", optionCancel: "No"}, () => {
				LoginService.deleteAccount();
			});
		};

		$ctrl.getCurrentUser = function () {
			return LoginService.currentUser;
		};
		
		$ctrl.logout = function() {
			confirmationFactory.confirm({message: "Are you sure you want to log  out?", optionOk: "Yes", optionCancel: "No"}, () => {
				LoginService.logout().then($ctrl.userDataDisplayed = false);
			});
		};

		$ctrl.displayUserData = function() {
			$ctrl.userDataDisplayed = true;
			if ($ctrl.timeout)
				clearTimeout($ctrl.timeout);
		};

		$ctrl.hideUserData = function() {
			$ctrl.timeout = setTimeout(()=>{
				$ctrl.userDataDisplayed = false;
				$scope.$apply();
			}, 600);	
		};

		/* Dropdown */
		// Navbar and dropdowns
		var toggle = document.getElementsByClassName('navbar-toggle')[0],
		collapse = document.getElementsByClassName('navbar-collapse')[0],
            dropdowns = document.getElementsByClassName('dropdown');
        // Toggle if navbar menu is open or closed
		function toggleMenu() {
			collapse.classList.toggle('collapse');
			collapse.classList.toggle('in');
		}

		// Close all dropdown menus
		function closeMenus() {
			for (var j = 0; j < dropdowns.length; j++) {
				dropdowns[j].getElementsByClassName('dropdown-toggle')[0].classList.remove('dropdown-open');
				dropdowns[j].classList.remove('open');
			}
		}

		// Add click handling to dropdowns
		for (var i = 0; i < dropdowns.length; i++) {
			dropdowns[i].addEventListener('click', function() {
				if (document.body.clientWidth < 768) {
					var open = this.classList.contains('open');
					closeMenus();
					if (!open) {
						this.getElementsByClassName('dropdown-toggle')[0].classList.toggle('dropdown-open');
						this.classList.toggle('open');
					}
				}
			});
		}

		// Close dropdowns when screen becomes big enough to switch to open by hover
		function closeMenusOnResize() {
			if (document.body.clientWidth >= 768) {
				closeMenus();
				collapse.classList.add('collapse');
				collapse.classList.remove('in');
			}
		}

		// Event listeners
		window.addEventListener('resize', closeMenusOnResize, false);
		toggle.addEventListener('click', toggleMenu, false);
	};

	HeaderController.$inject = ["$scope", "ProductsService", "LoginService", "confirmationFactory"];

	angular.module("app").component('wsHeader', {
		templateUrl: './components/header/header.template.html',
		controller: HeaderController,
	});
})();