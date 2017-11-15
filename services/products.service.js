var ProductsService = function(HttpService) {
	this.products;
	this.cartProducts = [];

	this.onInit = function() {
		// this.fakeProducts();
		this.loadProducts();
	};

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

	this.loadProducts = function() {
		return HttpService.get().then(
			(res) => {
				this.products = res.data;
				console.log(this.products);
			},
			(res) => {
				console.log(res);
			});
	}

	this.saveProducts = function() {
		return HttpService.post(this.products).then(
			(res) => {
				console.log(res);
			},
			(res) => {
				console.log(res);
			});
	}

	this.onInit();
}

ProductsService.$inject = ['HttpService'];

app.service("ProductsService", ProductsService);