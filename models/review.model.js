function Review(user, rating, title, description, date) {
	this.user = user;
	this.rating = rating || 3;
	this.title = title || "Untitled review";
	this.description = description;
	this.date = date || new Date();
}