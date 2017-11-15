function HeroDetailController() {
  var ctrl = this;

  ctrl.delete = function() {
    ctrl.onDelete({hero: ctrl.hero});
  };

  ctrl.update = function(prop, value) {
    ctrl.onUpdate({hero: ctrl.hero, prop: prop, value: value});
  };
}

app.component('products', {
  templateUrl: './components/products/products.template.html',
  controller: ProductsController,
  bindings: {
    hero: '<',
    onDelete: '&',
    onUpdate: '&'
  }
});