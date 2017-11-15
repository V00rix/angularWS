"use strict";

var rootUrl = "/angularWS"
var viewsUrl = rootUrl + "/views"
var app = angular.module("app", ["ngRoute"]);


var configFunction = function ($routeProvider) {
    $routeProvider
    .when("/products",
        {
            template: '<products></products>',
            controller: "ProductsController"
        })
    .when("/cart",
        {
            templateUrl: viewsUrl + "/cart/cart",
            controller: "CartController"
        })
    .when("/admin",
        {
            templateUrl: viewsUrl + "/admin/admin",
            controller: "AdminController"
        })
}
configFunction.$inject = ["$routeProvider"];

app.config(configFunction);