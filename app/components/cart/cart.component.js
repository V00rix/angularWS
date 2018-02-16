(function () {
    "use strict";

    const CartController = function ($scope, ProductsService, LoginService, confirmationFactory) {
        const $ctrl = this;
        $ctrl.cart = null;

        $ctrl.$onInit = function () {
            ProductsService.getTemporary().then(
                (cart) => {
                    $ctrl.cart = cart;
                });
            if (!ProductsService.products)
                ProductsService.loadProducts();
        };

        $ctrl.more = function (product) {
            const pr = ProductsService.products.find(p => p.id === product.id);
            if (pr.quantity > 0) {
                product.quantity++;
                $ctrl.cart.fullLength++;
                pr.quantity--;
            }
            ProductsService.saveTemporary();
        };

        $ctrl.getCurrentUser = function () {
            return LoginService.currentUser;
        };

        $ctrl.less = function (product) {
            const pr = ProductsService.products.find(p => p.id === product.id);
            if (product.quantity > 0) {
                product.quantity--;
                $ctrl.cart.fullLength--;
                pr.quantity++;
            }
            ProductsService.saveTemporary();
        };

        $ctrl.removeProduct = function (id) {
            confirmationFactory.confirm({message: "Are you sure you want to remove selected product from your cart?"}, () => {
                const pr = ProductsService.products.find(p => p.id === $ctrl.cart.products[id].id);
                $ctrl.cart.fullLength -= $ctrl.cart.products[id].quantity;
                pr.quantity += $ctrl.cart.products[id].quantity;
                $ctrl.cart.products.splice(id, 1);
                ProductsService.cartProducts = $ctrl.cart;
                ProductsService.saveTemporary();
            });
        };

        $ctrl.orderConfirmed = function () {
            ProductsService.buy().then(() => {
                $ctrl.cart.products = [];
                $ctrl.cart.fullLength = 0;
            });
        };

        $ctrl.clearCart = function () {
            confirmationFactory.confirm({message: "Are you sure you want to clear your cart?"}, () => {
                ProductsService.clearCart();
                $ctrl.cart.products = [];
                ProductsService.saveTemporary();
            });
        };

        $ctrl.getFullCost = function () {
            return $ctrl.cart.products.map(p => p.cost * p.quantity).reduce((acc, val) => acc + val, 0);
        }
    };


    CartController.$inject = ["$scope", "ProductsService", "LoginService", "confirmationFactory"];
    angular.module("app").component('wsCart', {
        templateUrl: './components/cart/cart.template.html',
        controller: CartController
    });
})();