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

        $routeProvider.when('/home', {templateUrl: freakUrl.page('home', true), controller: 'HomeCtrl'});


        // We will have three standard views (form, one, all)

        $routeProvider.when(freakUrl.elementView(':element', 'form'), {

            templateUrl: function (params)
            {
                return freakUrl.elementView(params.element, 'form', true);
            },

            controller: 'ElementFormCtrl'
        });

        $routeProvider.when(freakUrl.elementView(':element', 'form/:id'), {

            templateUrl: function (params)
            {
                return freakUrl.elementView(params.element, 'form', true);
            },

            controller: 'ElementFormEditCtrl'
        });

        $routeProvider.when(freakUrl.elementView(':element', 'one/:id'), {

            templateUrl: function (params)
            {
                return freakUrl.elementView(params.element, 'one', true);
            },

            controller: 'ElementOneCtrl'
        });

        $routeProvider.when(freakUrl.elementView(':element', 'all'), {

            templateUrl: function (params)
            {
                return freakUrl.elementView(params.element, 'all', true);
            },

            controller: 'ElementAllCtrl'
        });

        $routeProvider.otherwise({redirectTo: '/'});
    }]);
