'use strict';

/* Directives */


angular.module('freak.directives', [])

    .directive('frDataTable', function() {
        return {
            restrict: 'A',
            replace: true,
            link: function(scope, element, attrs, controller) {

                attrs.$observe('frDataTable', function(isReady) {

                    if(isReady == 'true' && $.fn.dataTable) {

                        setTimeout(function()
                        {
                            $(element).dataTable({ aaSorting : [[0, 'desc']] }).columnFilter();
                        }, 100);
                    }
                });
            }
        }
    })

    .directive('frDatetimePicker', function() {
        return {
            restrict: 'A',
            replace: true,
            link: function(scope, element, attrs, controller) {

                element.datetimepicker({
                    ampm: true,
                    dateFormat: "yy-mm-dd",
                    timeFormat:'hh:mm:ss'
                });
            }
        }
    })


    .directive('frDataTools', function() {
        return {
            restrict: 'E',
            template:
                    '<span class="btn-group">'
                        + '<a ng-click="show($index)" class="btn btn-small" ng-show="isUsing(\'show\')"><i class="icon-search"></i></a>'
                        + '<a ng-click="edit($index)" class="btn btn-small" ng-show="isUsing(\'edit\')"><i class="icon-pencil"></i></a>'
                        + '<a ng-click="destroy($index)" class="btn btn-small" ng-show="isUsing(\'destroy\')"><i class="icon-trash" ></i></a>'
                    + '</span>',

            link: function(scope, element, attrs) {

                // Default values
                var uses = ['show', 'edit', 'destroy'];

                attrs.$observe('uses', function(value) {
                    if(value) uses = scope.$eval(value);
                });

                scope.isUsing = function(tool) {

                    for(var i = 0; i < uses.length; i++) if(tool == uses[i]) return true;

                    return false;
                }
            }
        }
    });
