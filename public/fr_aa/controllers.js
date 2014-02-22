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

        $scope.viewOptions = {show: false, ready:false};

        var whenReadyCallback;

        // Register when ready callbak
        $scope.whenReady = function(callback)
        {
            whenReadyCallback = callback;
        }

        // When scope is ready call when ready callback if it's a function and show view and make it ready
        $scope.ready = function()
        {
            if(typeof whenReadyCallback === 'function') whenReadyCallback();

            $scope.viewOptions.show = true;
            $scope.viewOptions.ready = true;
        }

        $scope.$on('$routeChangeStart', function(next, current) {

            // Add to history
            History.add(Menu.getActiveChild());

            // Update history items
            $scope.historyItems = History.uniqueItems();

            // Don't show view
            $scope.viewOptions.show  = false;
            $scope.viewOptions.ready = false;

            // De-register when ready callback
            whenReadyCallback = null;
        });

    }])
    .controller('FooterCtrl', [function () {

    }])




    .controller('HomeCtrl', ['$scope', function ($scope) {

        $scope.ready();
    }])



    // Element custom views controller
    .controller('ElementViewCtrl', ['$scope', '$routeParams', 'Packages', function($scope, $routeParams, Packages) {

        $scope.element = $routeParams.element;

        // Reset packages to be used down in the child controllers
        Packages.reset();
    }])



    .controller('ElementFormCtrl', ['$scope', '$routeParams', 'Element', '$location', 'Packages', function($scope, $routeParams, Element, $location, Packages) {

        // Get element name
        $scope.element = $routeParams.element;

        // Create new model
        $scope.model = Element.newModel($scope.element);

        $scope.ready();

        $scope.isSubmitting = false;

        // Process form method
        $scope.processForm = function()
        {
            $scope.isSubmitting = true;

            Element.store($scope.model, function() {

                $scope.isSubmitting = false;

                // If model id isset which means it has been saved successfully
                if($scope.model.id)
                {
                    // Show a success message
                    $scope.alert.success('Success', 'Data saved successfully.');

                    // Change location to the edit form for this model...
                    $location.path($scope.url.elementView($scope.element, 'form/' + $scope.model.id));
                }
                else
                {
                    // Show an error message
                    $scope.alert.error('Ooops!', 'Something went wrong. Try again');
                }
            }, function() {

                $scope.isSubmitting = false;

                // Show an error message
                $scope.alert.error('Ooops!', 'Something went wrong. Try again');
            });
        }

        // Reset packages to be used down in the child controllers
        Packages.reset();
    }])






    .controller('ElementFormEditCtrl', ['$scope', 'Element', '$routeParams', 'Packages', function($scope, Element,$routeParams, Packages) {

        // Get element name
        $scope.element = $routeParams.element;

        $scope.model = Element.show($scope.element, $routeParams.id, function() {

            $scope.ready();

        }, function() {

            $scope.alert.error('Ooops!', 'Something went wrong while trying to request the resource from the server. Try again');
        });

        $scope.isSubmitting = false;

        $scope.processForm = function()
        {
            $scope.isSubmitting = true;

            Element.store($scope.model, function() {

                $scope.isSubmitting = false;

                // If model id is set which means it has been saved successfully
                if($scope.model.id)
                {
                    // Show a success message
                    $scope.alert.success('Success', 'Data saved successfully.');
                }
                else
                {
                    // Show an error message
                    $scope.alert.error('Ooops!', 'Something went wrong. Try again');
                }
            }, function() {

                $scope.isSubmitting = false;

                // Show an error message
                $scope.alert.error('Ooops!', 'Something went wrong. Try again');
            });
        }

        // Reset packages
        Packages.reset();

        // Set model it for the packages
        Packages.setModelId($routeParams.id);
    }])



    .controller('ElementOneCtrl', ['$scope', '$routeParams', 'Element', 'Packages', '$location',  function($scope, $routeParams, Element, Packages, $location) {

        // Get element
        $scope.element = $routeParams.element;

        // Get model
        $scope.model = Element.show($scope.element, $routeParams.id, function() {

            $scope.ready();

        }, function() {

            $scope.alert.error('Ooops!', 'Something went wrong. Try again');
        });


        // Change location to edit this model
        $scope.edit = function()
        {
            $location.path($scope.url.elementView($routeParams.element, 'form/' + $scope.model ));
        }

        // Destroy this model then go to all models
        $scope.destroy = function(index)
        {
            var result = confirm("Are you sure you want to delete?");

            if (result==true) {
                // Destroy on server
                Element.destroy($scope.models[index], function() {

                    $scope.alert.success('Deleted successfully!');

                    $location.path($scope.url.elementView($routeParams.element, 'all/' ));
                });
            }
        }

        // Reset packages
        Packages.reset();

        // Set model it for the packages
        Packages.setModelId($routeParams.id);
    }])



    .controller('ElementAllCtrl', ['$scope', '$routeParams', 'Element', '$location', '$timeout', function($scope, $routeParams, Element, $location, $timeout) {

        // Get element name
        $scope.element = $routeParams.element;

        // Get all models
        $scope.models = Element.index($routeParams.element, function() {

            // Call ready method if defined
            $scope.ready();

        }, function() {

            $scope.alert.error('Ooops!', 'Something went wrong. Try again');
        });


        $scope.refresh = function() {

            // Refresh current view
            $location.path($scope.url.elementView($routeParams.element, 'all/' ));
        }

        // Destroy the refresh timeout on destroying the view
        $scope.$on('$destroy', function() {
            $timeout.cancel(cancelRefresh);
        });

        // Change location to show the clicked model
        $scope.show = function(i)
        {
            $location.path($scope.url.elementView($routeParams.element, 'one/' + $scope.models[i].id ));
        }

        // Change location to edit the clicked model
        $scope.edit = function(i)
        {
            $location.path($scope.url.elementView($routeParams.element, 'form/' + $scope.models[i].id ));
        }

        // Destroy the clicked model
        $scope.destroy = function(index)
        {
            var result = confirm("Are you sure you want to delete?");

            if (result==true) {
                // Destroy on server
                Element.destroy($scope.models[index], function() {

                    $scope.models.splice(index, 1);

                    $scope.alert.success('Deleted successfully!');

                    $location.path($scope.url.elementView($routeParams.element, 'all/' ));
                });
            }
        }
    }])