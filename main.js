"use strict";

var x = 5;
var app = angular.module("app", ["ngRoute"]);

app.service("ProductsService", ProductsService);
app.service("LoginService", LoginService);
app.service("HttpService", HttpService);

var configFunction = function ($routeProvider, $interval) {
    $routeProvider
    .when("/products",
    {
        template: '<ws-products products="$resolve.products" on-product="main.showDetail(productName)"></ws-products>',
        resolve: { 
            products: function(ProductsService) { 
                return ProductsService.loadProducts(); 
            }
        },
        useAsDefault: true
    })
    .when("/cart",
    {
        template: '<ws-cart></ws-cart>'
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
    .when("/product-detail/:productName?", {
        template: '<ws-product-detail></ws-product-detail>',
        resolve: { 
            products: function(ProductsService) { 
                return ProductsService.loadProducts(); 
            }
        }
    })
}
configFunction.$inject = ["$routeProvider"];

app.config(configFunction);