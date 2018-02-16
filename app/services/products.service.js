(function () {
    "use strict";

    const ProductsService = function (HttpService, $q, messageFactory) {
        this.products = null;
        this.cartProducts = {
            products: null,
            fullLength: null
        };

        // Fetches products array from server and returns it or
        // simply returns it if they have already been loaded
        this.loadProducts = function () {
            window.console.log("Attempting to get products...");

            // construct new promise
            const deferred = $q.defer();

            // if products already been fetched
            if (this.products)
                deferred.resolve(this.products);
            else
                HttpService.getProducts().then(
                    (res) => {
                        // assign to local products variable
                        this.products = res.data;
                        console.log("Products loaded.");
                        this.resolveTemp();
                        // resolve
                        deferred.resolve(this.products);
                    },
                    (res) => {
                        messageFactory.display("Could not get product list", "warn");
                        console.error(res);
                        // reject to error message
                        deferred.reject("Couldn't get products.", res);
                    });

            // return promise to subscribe to
            return deferred.promise;
        };

        /**
         *
         * @returns {Promise}
         */
        this.buy = function () {
            const deferred = $q.defer();
            // create http request data
            const request = [];
            this.cartProducts.products.forEach(
                p => request.push({id: p.id, quantity: p.quantity}));

            HttpService.buy(request).then(
                (res) => {
                    console.log(res);
                    messageFactory.display("Buy request successful", "success");
                    deferred.resolve();
                },
                (res) => {
                    messageFactory.display(["Buy request failed", res.data], "error");
                    console.error("Error!", res.statusText + "\n", res.data);
                    deferred.reject();
                });
            return deferred.promise;
        };

        this.clearCart = function () {
            for (let product of this.cartProducts.products) {
                const pr = this.products.find(p => p.id === product.id);
                pr.quantity += product.quantity;
            }
            this.cartProducts.fullLength = 0;
            this.cartProducts = [];
        };

        // save temporary cart data
        this.saveTemporary = function () {
            HttpService.postTemp(this.cartProducts).then(
                (res) => {
                    console.log(res);
                },
                (reason) => {
                    messageFactory.display("Could not save temporary cart", "warn");
                    console.error(reason);
                });
        };

        // retrieve temporary cart data
        this.getTemporary = function () {
            // construct new promise
            const deferred = $q.defer();

            // if products already been fetched
            if (this.cartProducts.products)
                deferred.resolve(this.cartProducts);
            else
                HttpService.getTemp().then(
                    (res) => {
                        if (res.data && res.data.cartProducts) {
                            this.cartProducts = res.data.cartProducts;
                            this.cartProducts.products = res.data.cartProducts.products ? res.data.cartProducts.products : [];
                            this.cartProducts.fullLength = this.cartProducts.products.map(p => p.quantity).reduce((acc, val) => acc + val, 0);
                        }
                        else {
                            this.cartProducts = res.data.cartProducts ? res.data.cartProducts : {
                                products: [],
                                fullLength: 0
                            };
                        }
                        this.resolveTemp();
                        deferred.resolve(this.cartProducts);
                    },
                    (reason) => {
                        messageFactory.display("Could not get temporary cart", "warn");
                        console.error(reason);
                        deferred.reject(reason);
                    });

            // return promise to subscribe to
            return deferred.promise;
        };

        this.resolveTemp = function () {
            if (this.cartProducts.products && this.products)
                this.cartProducts.products.forEach(product => {
                    const prod = this.products.find(p => p.id === product.id);
                    prod.quantity -= product.quantity;
                });
        };

        this.addReview = function (product, review) {
            return HttpService.addReview(product.id, review);
        }
    };

    ProductsService.$inject = ["HttpService", "$q", "messageFactory"];

    angular.module("app").service("ProductsService", ProductsService);
})();
