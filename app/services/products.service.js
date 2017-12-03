(function() {
	"use strict";

	var ProductsService = function(HttpService, $q) {
		this.products = null;
		this.cartProducts = {
			products: null,
			fullLength: null
		};

		// Fetches products array from server and returns it or
		// simply returns it if they have already been loaded
		this.loadProducts = function() {
			window.console.log("Attempting to get products...");

			// construct new promise
			var deferred = $q.defer();

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
						console.error("Could not load products.");
						// reject to error message
						deferred.reject("Couldn't get products.", res);
					});

			// return promise to subscribe to
			return deferred.promise;
		}

		this.buy = function() {
			// create http request data
			var request = [];
			this.cartProducts.products.forEach(
				p => request.push({id: p.id, quantity: p.quantity}));

			return HttpService.buy(request).then(
				(res) => {
					console.log(res);
				},
				(res) => {
					console.error("Error!", res.statusText + "\n" , res.data);
				});
		}

		this.clearCart = function() {			
			for (var product in ProductsService.cartProducts.products) {
				var pr = ProductsService.products.find(p => p.id === product.id);
				pr.quantity += product.quantity;
			}
			ProductsService.cartProducts.fullLength = 0;
			ProductsService.cartProducts = [];
		}

    	// save temporary cart data
    	this.saveTemporary = function() {
    		HttpService.postTemp(this.cartProducts).then(
    			(res) => {
    			},
    			(reason) => {
    				console.error(reason); 
    			});
    	}

    	// retrieve temporary cart data
    	this.getTemporary = function() {
			// construct new promise
			var deferred = $q.defer();

			// if products already been fetched
			if (this.cartProducts.products)
				deferred.resolve(this.cartProducts);
			else
				HttpService.getTemp().then(
					(res) => {
						this.cartProducts = res.data.cartProducts ? res.data.cartProducts : {
							products: [],
							fullLength: 0    					
						};
						this.resolveTemp();
						deferred.resolve(this.cartProducts);
					},
					(reason) => {
						console.error(reason); 
						deferred.reject(reason);
					});

			// return promise to subscribe to
			return deferred.promise;
		}

		this.resolveTemp = function() {
			if (this.cartProducts.products && this.products)
				this.cartProducts.products.forEach(product => {
					var prod = this.products.find(p => p.id === product.id);
					prod.quantity -= product.quantity;
				});
		}

		this.addReview = function(product, review) {
			return HttpService.addReview(product.id, review);
		}
	}

	ProductsService.$inject = ['HttpService', '$q'];

	angular.module("app").service("ProductsService", ProductsService);
})();
