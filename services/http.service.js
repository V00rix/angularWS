var HttpService = function($http) {
	this.baseUrl = "https://webshop-5773b.firebaseio.com/"

	this.get = function() {
        window.console.log("Attempting to get products...");
        return $http.get(this.baseUrl + "products.json");
	}

	this.post = function(products) {		
        window.console.log("Trying to post..", products);
        return $http.put(this.baseUrl + "products.json", products);
	}
}

HttpService.$inject = ['$http'];

app.service("HttpService", HttpService);