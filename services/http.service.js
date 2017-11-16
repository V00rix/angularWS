var HttpService = function($http) {
	this.baseUrl = "https://webshop-5773b.firebaseio.com/"

	this.get = function() {
        return $http.get(this.baseUrl + "products.json");
	}

	this.post = function(products) {		
        return $http.put(this.baseUrl + "products.json", products);
	}
}

HttpService.$inject = ['$http'];