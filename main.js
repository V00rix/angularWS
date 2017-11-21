"use strict";

var app = angular.module("app", ["ngRoute"]);

app.service("ProductsService", ProductsService);
app.service("HttpService", HttpService);

var configFunction = function ($routeProvider) {
    $routeProvider
    .when("/products",
    {
        template: '<ws-products products="$resolve.products" on-product="main.showDetail(product)"></ws-products>',
        resolve: { 
            products: function(ProductsService) { 
                return ProductsService.loadProducts(); 
            }
        },
        useAsDefault: true
    })
    .when("/cart",
    {
        template: '<ws-cart products="$resolve.products"></ws-cart>'
    })
    .when("/admin",
    {
        template: '<ws-admin products="$resolve.products"></ws-admin>',
        resolve: { 
            products: function(ProductsService) { 
                return ProductsService.loadProducts(); 
            }
        }
    })
    .when("/product-detail", {
        template: '<ws-product-detail product="main.selectedProduct">sddsafsdfsd</ws-product-detail>',
        resolve: { 
            products: function(ProductsService) { 
                return ProductsService.loadProducts(); 
            }
        }
    })
}
configFunction.$inject = ["$routeProvider"];

app.config(configFunction);