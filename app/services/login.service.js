(function() {
	"use strict";

    const LoginService = function ($rootScope, HttpService, $q, messageFactory) {
        this.currentUser = null;

        /**
         * Login function: sends login request to backend using request configuration parameter
         * @param {object} requestsConfig Configuration data with properties:
         *    {string} username Username
         *    {string} username Email
         *    {string} password Password
         *    {function} successCallback Function to called get when user is logged in
         *    {function} badUsernameCallback Function to get called when username wasn't found
         *    {function} emailNotFreeCallback Function to get called when email was found, so it's taken
         *    {function} badPasswordCallback Function to get called when username was found, but password is wrong
         *    {function} unhandledCallback Function to get called when unexpected response was recieved
         * @return {void}
         */
        this.checkCredentials = function (requestsConfig) {
            // Set default config
            requestsConfig = {
                // Request data
                username: requestsConfig.username ? requestsConfig.username : null,
                email: requestsConfig.email ? requestsConfig.email : null,
                password: requestsConfig.password ? requestsConfig.password : null,
                // Callbacks
                successCallback: requestsConfig.successCallback ? requestsConfig.successCallback : function () {
                },
                usernameCallback: requestsConfig.usernameCallback ? requestsConfig.usernameCallback : function (status) {
                },
                emailCallback: requestsConfig.emailCallback ? requestsConfig.emailCallback : function (status) {
                },
                passwordCallback: requestsConfig.passwordCallback ? requestsConfig.passwordCallback : function (status) {
                },
                unhandledCallback: requestsConfig.unhandledCallback ? requestsConfig.unhandledCallback : function (data) {
                }
            };

            // Call httpService to check credentials
            HttpService.getCredentialsStatus(requestsConfig.username, requestsConfig.email, requestsConfig.password).then(
                (result) => {
                    requestsConfig.usernameCallback(result.data.usernameFound);
                    requestsConfig.emailCallback(result.data.emailFound);
                    requestsConfig.passwordCallback(result.data.passwordFound);
                    if (result.data.usernameFound === true && result.data.passwordFound === true) {
                        requestsConfig.successCallback();
                    }
                },
                (reason) => {
                    console.error("Encountered a " + reason.status + " error. " + reason.data, reason);
                    requestsConfig.unhandledCallback(reason);
                });
        };

        /**
         * Login function: sends registration request to backend using request configuration parameter
         * @param {object} requestsConfig Configuration data with properties:
         *    {string} username Username
         *    {string} username Email
         *    {string} password Passowrd
         *    {function} successCallback Function to called get when user is logged in
         *    {function} unhandledCallback Function to get called when unexpected response was recieved
         * @return {void}
         */
        this.register = function (requestsConfig) {
            // Set default config
            requestsConfig = {
                // Request data
                username: requestsConfig.username ? requestsConfig.username : null,
                email: requestsConfig.email ? requestsConfig.email : null,
                password: requestsConfig.password ? requestsConfig.password : null,
                // Callbacks
                successCallback: requestsConfig.successCallback ? requestsConfig.successCallback : function () {
                },
                failureCallback: requestsConfig.failureCallback ? requestsConfig.failureCallback : function () {
                },
                unhandledCallback: requestsConfig.unhandledCallback ? requestsConfig.unhandledCallback : function (data) {
                }
            };

            // Call httpService to register new user
            HttpService.register(requestsConfig.username, requestsConfig.email, requestsConfig.password).then(
                (result) => {
                    messageFactory.display("Registration successful", "success");
                    requestsConfig.successCallback();
                },
                (reason) => {
                    messageFactory.display(["Registration failed", "Reason: " + reason.data], "error");
                    console.error(reason);
                    requestsConfig.failureCallback(reason);
                });
        };

        this.login = function (requestsConfig) {
            // Set default config
            requestsConfig = {
                // Request data
                username: requestsConfig.username ? requestsConfig.username : null,
                password: requestsConfig.password ? requestsConfig.password : null,
                // Callbacks
                successCallback: requestsConfig.successCallback ? requestsConfig.successCallback : function () {
                },
                failureCallback: requestsConfig.failureCallback ? requestsConfig.failureCallback : function () {
                },
                unhandledCallback: requestsConfig.unhandledCallback ? requestsConfig.unhandledCallback : function (data) {
                }
            };

            // Call httpService to login
            HttpService.login(requestsConfig.username, requestsConfig.email, requestsConfig.password).then(
                (result) => {
                    messageFactory.display("Login successful", "success");
                    requestsConfig.successCallback();
                },
                (reason) => {
                    console.log(reason);
                    messageFactory.display(["Login failed", "Reason: " + reason.data], "error");
                    requestsConfig.failureCallback(reason);
                });
        };

        /**
         * subscribe to event which closes the login panel
         */
        this.subscribe = function (scope, callback) {
            const handler = $rootScope.$on('login-changed', callback);
            scope.$on('$destroy', handler);
        };

        /**
         * emit event to close login panel
         */
        this.onRegistrationStart = function () {
            $rootScope.$emit('login-changed');
        };

        /**
         * assign selected user and close login panel
         */
        this.userChanged = function (user) {
            this.currentUser = user;
            $rootScope.$emit('login-changed');
        };

        /**
         * send logout request
         */
        this.logout = function () {
            return HttpService.logout().then(
                (res) => {
                    messageFactory.display("Logged out", "success");
                    this.currentUser = null;
                },
                (reason) => {
                    messageFactory.display(["Could not logout", "Reason: " + reason.data], "warn", 7000);
                    console.error(reason);
                });
        };

        /**
         * check if the user is already logged in
         */
        this.loggedIn = function () {
            HttpService.loggedIn().then(
                (res) => res.data ? this.userChanged(new User(res.data)) : null);
        };

        /**
         * check if the user is already logged in
         */
        this.deleteAccount = function () {
            return HttpService.deleteAccount(this.currentUser.username).then(
                (res) => {
                    console.log(res);
                    messageFactory.display("Deletion successful", "success");
                    this.userChanged(null);
                },
                (reason) => {
                    console.error(reason);
                    messageFactory.display(["Deletion failed", "Reason: " + reason.data], "error");
                });
        }
    };


    LoginService.$inject = ["$rootScope", "HttpService", "$q", "messageFactory"];

	angular.module("app").service("LoginService", LoginService);
})();