"use strict";

var ProductsService = function(HttpService, $q) {
	this.products;
	this.cartProducts = {
		products: [],
		fullLength: 0
	};

	// this.onInit = function() {
	// 	// this.fakeProducts();
	// 	this.loadProducts().then(
	// 		() => {
	// 			console.log("Products loaded.");
	// 		},
	// 		() => {
	// 			console.log("Could not load products.");
	// 		},
	// 		(upd) => {
	// 			console.log("Recieved notification: ", upd);			
	// 		});
	// };

	this.fakeProducts = function() {
		this.words = ["hello", "winter", "again", "sad", "my", "enrage", "never", "can", "you", "imagine"];

		this.products = [];
		for (var i = 0; i < 50; ++i) {
			this.products.push(new Product(i, this.words[2], 
				this.words[i % this.words.length - 1] + this.words[i % this.words.length - 1] + 
				this.words[i % this.words.length - 1] + this.words[i % this.words.length - 1] + 
				this.words[i % this.words.length - 1] + this.words[i % this.words.length - 1] + 
				this.words[i % this.words.length - 1]));
		}
	}

	// Fetches products array from server and returns it or
	// simply returns it if they have already been loaded
	this.loadProducts = function() {
        window.console.log("Attempting to get products...");

		// construct new promise
		var deferred = $q.defer();

		// send notification
		deferred.notify('About to get products.');

		// if products already been fetched
		if (this.products)
			deferred.resolve(this.products);
		else {
			// fetch data
			HttpService.get().then(
				(res) => {
					// assign to local products variable
					this.products = res.data;
					console.log("Products loaded.");
					// resolve
					deferred.resolve(this.products);
				},
				(res) => {
					console.error("Could not load products.");
					// reject to error message
					deferred.reject("Couldn't get products.", res);
				});
		}

		// return promise to subscribe to
		return deferred.promise;
	}

	this.saveProducts = function() {
		return HttpService.post(this.products).then(
			(res) => {
				console.log(res);
			},
			(res) => {
				console.error("Error!", res.statusText + "\n" , res.data);
			});
	}

	// this.onInit();
}

// ProductsService.$inject = ['HttpService', '$q'];
