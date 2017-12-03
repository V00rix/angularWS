function Product(id, name, description, imageUrl, quantity, cost, reviews) {
	this.id = id;
	this.name = name || "Nameless product";
	this.description = description || "No description is available for this product.";
	this.imageUrl = imageUrl || "http://www.p-etalon.ru/global/images/prod/nophoto.png";
	this.quantity = quantity || 1;
	this.cost = cost || 100;
	this.reviews = reviews || [];
}