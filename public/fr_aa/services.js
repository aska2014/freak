'use strict';

/* Services */


// Demonstrate how to register services
// In this case it is a simple value service.
angular.module('freak.services', ['ngResource']).

    // Service to get menu configurations
    factory('Menu', ['$q', '$http', 'url', '$location', function ($q, $http, url, $location) {

        return {
            data: [],

            get: function()
            {
                var deferred = $q.defer();
                var that = this;

                $http.get(url.serverConfiguration('menu')).success(function(data) {

                    that.data = that.modifyData(data);

                    deferred.resolve(that.data);

                }).error(function(data) {

                    deferred.reject(data);
                });

                return deferred.promise;
            },

            modifyData: function(data)
            {
                var activeChosen = false;

                for (var i=0, parentItem; parentItem = data[i]; i++) {

                    for (var j=0, childItem; childItem = parentItem.children[j]; j++) {

                        childItem.uri = '#' + url.elementView(parentItem.element, childItem.uri);

                        if(! activeChosen)
                        {
                            activeChosen = childItem.active = parentItem.active = this.isActiveItem(childItem);
                        }
                    }
                }

                return data;
            },

            makeParentActive: function(item)
            {
                for (var i=0, parentItem; parentItem = this.data[i]; i++) {
                    parentItem.active = false;
                }

                item.active = true;
            },

            makeChildActive: function(item)
            {
                for (var i=0, parentItem; parentItem = this.data[i]; i++) {

                    for (var j=0, childItem; childItem = parentItem.children[j]; j++) {

                        childItem.active = false;
                    }
                }

                item.active = true;
            },

            isActiveItem: function(item)
            {
                return item.uri === '#' + $location.path()
            },

            getActiveArray: function()
            {
                for (var i=0, parentItem; parentItem = this.data[i]; i++) {

                    for (var j=0, childItem; childItem = parentItem.children[j]; j++) {

                        if(childItem.active)
                        {
                            return [parentItem, childItem];
                        }
                    }
                }

                return [];
            },

            getActiveChild: function()
            {
                var array = this.getActiveArray();

                return array.length > 1 ? array[1] : null;
            }
        }
    }])


    .factory('History', [function() {

        return {
            items: [],
            add: function(child) {

                if(child != null) this.items.push(child);
            },
            uniqueItems: function() {

                var unique = {};
                var distinct = [];
                for( var i in this.items ){
                    if( typeof(unique[this.items[i].title]) == "undefined"){
                        distinct.push(this.items[i]);
                    }
                    unique[this.items[i].title] = 0;
                }

                return distinct;
            }
        }
    }])



    .factory('Element', ['url', '$resource', function(url, $resource) {


        return {
            resource: function(_name) {

                return $resource(url.serverElement(_name, ':id'), {id: '@id'}, {
                    query: {method: 'GET', isArray: true}
                });
            },

            newModel: function(_name) {
                var resource = this.resource(_name);

                return new resource();
            },

            index: function(_name, success_callback, error_callback) {

                return this.resource(_name).query(success_callback, error_callback);
            },

            store: function(_model, success_callback, error_callback) {

                _model.$save(success_callback, error_callback);
            },

            show: function(_name, id, success_callback, error_callback) {
                return this.resource(_name).get({id: id}, success_callback, error_callback);
            },

            destroy: function(_model, success_callback, error_callback) {
                _model.$delete(success_callback, error_callback);
            },

            operation: function(_name, _uri, _parameters, success_callback, error_callback) {

                return $resource('', _parameters, {
                    operation: {url: url.serverElement(_name, _uri)}
                }).operation(success_callback, error_callback);
            }
        }
    }])



    .factory('Alert', [function() {

        return {
            success: function(title, body) {

                this.message(title, body, 'success');
            },

            error: function(title, body) {

                this.message(title, body, 'error');
            },

            info: function(title, body) {

                this.message(title, body, 'info');
            },

            notice: function(title, body) {

                this.message(title, body, 'notice');
            },

            message: function(title, body, type) {

                $.pnotify({
                    title: title,
                    text: body,
                    type: type
                });
            }
        }
    }])



    .factory('Packages', ['Helpers', function(Helpers) {

        return {

            ready: false,
            model: {id: 0, type: ''},
            options: [],
            waiting: [],

            reset: function()
            {
                this.ready = false;
                this.model = {id: 0, type: ''};
                this.options = [];
                this.waiting = [];
            },

            mergeOptions: function(_package, _default)
            {
                // Current options
                var options  = this.getOptions(_package);

                var merged = jQuery.extend(_default, options);

                // Merge with default options
                this.setOptions(_package, merged);

                // Return merged options
                return merged;
            },

            setOptions: function(_package, _options) {
                this.options[_package] = _options;
            },

            getOptions: function(_package) {
                return this.options[_package];
            },

            setModelType: function(_modelType) {
                this.model.type = _modelType;
            },

            getModelType: function() {
                return this.model.type;
            },

            setModelId: function(_modelId) {

                if(Helpers.isInteger(_modelId)) {

                    this.model.id = _modelId;

                    this.ready = true;
                    this.callWaitingForId();
                }
            },

            whenReady: function(callback) {

                if(this.ready) callback();

                else this.waiting.push(callback);
            },

            callWaitingForId: function() {
                for(var i = 0; i < this.waiting.length; i ++) {

                    if(Helpers.isFunction(this.waiting[i])) {

                        this.waiting[i]();
                    }

                    delete this.waiting[i];
                }
            },

            getDataToSend: function(_package, noObject) {

                var data = {
                    model_type: this.model.type,
                    model_id: this.model.id
                };

                // Append options if noObject is set.
                if(noObject) {

                    angular.forEach(this.options[_package], function(value, key){
                        data['options_' + key] = value;
                    });

                    data.noObject = true;

                } else data.options = this.options[_package];

                return data;
            }
        }
    }])


    .factory('Helpers', function() {

        this.isFunction = function(functionToCheck) {
            var getType = {};
            return functionToCheck && getType.toString.call(functionToCheck) === '[object Function]';
        };

        this.isInteger = function(possibleInteger) {
            return /^[\d]+$/.test(possibleInteger);
        };

        return this;
    })


    .factory('Refresher', ['$timeout', function($timeout) {

        var callbacks = [[], [], []], intervals = [0, 0, 0], id = 0;

        var that = this;

        this.registerShort = function(callback) {
            callbacks[0].push(callback);
            return id++;
        }

        this.registerShort = function(callback) {
            callbacks[0].push(callback);
            return id++;
        }

        this.setIntervals = function(_shortInterval, _mediumInterval, _longInterval) {
            intervals = [_shortInterval, _mediumInterval, _longInterval];
        }

        this.callShort = function() {
            for(var i = 0; i < callbacks.length; i ++){

                callbacks[i]();
            }
        }

        // Hold the cancel refresh
        $timeout(function myFunction() {

            that.callShort();

            $timeout(myFunction, that.interval[0]);
        },that.interval[0]);
    }])


    .value('url', freakUrl);

