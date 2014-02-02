'use strict';

/* Controllers */

angular.module('freak.controllers', []).

    // Organization: Body(Header, Content(Sidebar, Main), Footer)

    controller('BodyCtrl', ['$scope', 'Alert', 'url', function ($scope, Alert, url) {

        // Global variables
        $scope.alert = Alert;
        $scope.url   = url;

    }])
    .controller('HeaderCtrl', [function () {

    }])
    .controller('ContentCtrl', [function () {

    }])
    .controller('SidebarCtrl', ['$scope', 'Menu', function ($scope, Menu) {

        Menu.get().then(function(menu)
        {
            $scope.menu = menu;
        });

        $scope.makeParentActive = function(item) {
            Menu.makeParentActive(item);
        }

        $scope.makeChildActive = function(item) {
            Menu.makeChildActive(item);
        }
    }])
    .controller('MainCtrl', ['$scope', 'Menu', 'History', function ($scope, Menu, History) {

        $scope.viewOptions = {show: false};

        $scope.$on('$routeChangeStart', function(next, current) {

            History.add(Menu.getActiveChild());

            $scope.historyItems = History.uniqueItems();

            $scope.viewOptions.show = false;
        });

    }])
    .controller('FooterCtrl', [function () {

    }])




    .controller('HomeCtrl', function ($resource) {
    })






    .controller('ElementFormCtrl', ['$scope', '$routeParams', 'Element', '$location', 'Packages', function($scope, $routeParams, Element, $location, Packages) {

        $scope.element = $routeParams.element;

        $scope.resource = Element($routeParams.element);

        $scope.model = new $scope.resource();

        $scope.viewOptions.show = true;

        $scope.processForm = function()
        {
            $scope.model.$save(function() {
                $scope.alert.success('Success', 'Data saved successfully. ');

                $location.path($scope.url.elementView($routeParams.element, 'form/' + $scope.model.id));
            }, function() {
                $scope.alert.error('Ooops!', 'Something went wrong. Try again');
            });
        }

        Packages.reset();
    }])






    .controller('ElementFormEditCtrl', ['$scope', 'Element', '$routeParams', 'Packages', function($scope, Element,$routeParams, Packages) {

        $scope.element = $routeParams.element;

        $scope.resource = Element($routeParams.element);

        $scope.model = $scope.resource.get({id: $routeParams.id}, function() {

            $scope.viewOptions.show = true;

        }, function() {

            $scope.alert.error('Ooops!', 'Something went wrong. Try again');
        });

        $scope.processForm = function()
        {
            $scope.model.$save(function() {
                $scope.alert.success('Success', 'Data saved successfully');
            }, function() {
                $scope.alert.error('Ooops!', 'Something went wrong. Try again');
            });
        }

        // Handling packages
        Packages.reset();

        Packages.setModelId($routeParams.id);
    }])



    .controller('ElementOneCtrl', ['$scope', '$routeParams', 'Element', 'Packages',  function($scope, $routeParams, Element, Packages) {

        $scope.element = $routeParams.element;

        $scope.resource = Element($routeParams.element);

        $scope.model = $scope.resource.get({id: $routeParams.id}, function() {

            $scope.viewOptions.show = true;

        }, function() {

            $scope.alert.error('Ooops!', 'Something went wrong. Try again');
        });

        // Handling packages
        Packages.reset();

        Packages.setModelId($routeParams.id);
    }])



    .controller('ElementAllCtrl', ['$scope', '$routeParams', 'Element', '$resource', function($scope, $routeParams, Element, $resource) {

        $scope.element = $routeParams.element;

        $scope.resource = Element($routeParams.element);

        $scope.models = $scope.resource.query(function() {

            $scope.viewOptions.show = true;

        }, function() {

            $scope.alert.error('Ooops!', 'Something went wrong. Try again');
        });
    }])