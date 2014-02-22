'use strict';


//var required_modules = _.union


// Declare app level module which depends on filters, and services
angular.module('freak', [
        'ngRoute',
        'freak.filters',
        'freak.services',
        'freak.directives',
        'freak.controllers',
        'angularFileUpload'
    ]).
    config(['$routeProvider', function ($routeProvider) {

        $routeProvider.when('/home', {templateUrl: freakUrl.serverPage('home'), controller: 'HomeCtrl'});

        // We will have three standard views (form, one, all)

        $routeProvider.when(freakUrl.elementView(':element', 'form'), {

            templateUrl: function (params)
            {
                return freakUrl.serverElementView(params.element, 'form');
            },

            controller: 'ElementFormCtrl'
        });

        $routeProvider.when(freakUrl.elementView(':element', 'form/:id'), {

            templateUrl: function (params)
            {
                return freakUrl.serverElementView(params.element, 'form');
            },

            controller: 'ElementFormEditCtrl'
        });

        $routeProvider.when(freakUrl.elementView(':element', 'one/:id'), {

            templateUrl: function (params)
            {
                return freakUrl.serverElementView(params.element, 'one');
            },

            controller: 'ElementOneCtrl'
        });

        $routeProvider.when(freakUrl.elementView(':element', 'all'), {

            templateUrl: function (params)
            {
                return freakUrl.serverElementView(params.element, 'all');
            },

            controller: 'ElementAllCtrl'
        });

        $routeProvider.when(freakUrl.elementView(':element', ':view'), {

            templateUrl: function (params)
            {
                return freakUrl.serverElementView(params.element, params.view);
            },

            controller: 'ElementViewCtrl'
        });

        $routeProvider.otherwise({redirectTo: '/home'});
    }]);
