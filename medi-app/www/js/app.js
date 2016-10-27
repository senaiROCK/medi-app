/* global cordova, StatusBar */

angular.module('mediApp', ['ionic', 'angular-loading-bar', 'ngFileUpload', 'toastr', 'mediApp.controllers', 'mediApp.services'])

        .run(function ($ionicPlatform) {
            $ionicPlatform.ready(function () {
                // Hide the accessory bar by default (remove this to show the accessory bar above the keyboard
                // for form inputs)
                if (window.cordova && window.cordova.plugins.Keyboard) {
                    cordova.plugins.Keyboard.hideKeyboardAccessoryBar(true);
                    cordova.plugins.Keyboard.disableScroll(true);

                }
                if (window.StatusBar) {
                    // org.apache.cordova.statusbar required
                    StatusBar.styleDefault();
                }
            });
        })

        .constant('base', 'http://localhost/medi-app-server/')
        .constant('baseImagePath', 'http://localhost/medi-app-server/assets/uploaded_images/')

        .config(function ($stateProvider, $urlRouterProvider, toastrConfig) {

            angular.extend(toastrConfig, {
                autoDismiss: false,
                containerId: 'toast-container',
                maxOpened: 0,    
                newestOnTop: true,
                positionClass: 'toast-bottom-center',
                preventDuplicates: false,
                preventOpenDuplicates: false,
                target: 'body'
            });

            $stateProvider


                    .state('login', {
                        url: '/login',
                        templateUrl: 'templates/login.html',
                        controller: 'LoginCtrl'
                    })

                    .state('app', {
                        url: '/app',
                        abstract: true,
                        templateUrl: 'templates/menu.html',
                        controller: 'AppCtrl'
                    })

                    .state('app.plants', {
                        url: '/plants',
                        views: {
                            'menuContent': {
                                templateUrl: 'templates/access/plant/plant.list.html',
                                controller: 'PlantCtrl'
                            }
                        }
                    })
            
                    .state('app.plants/view', {
                        url: '/plants/:plantId/:plantName',
                        views: {
                            'menuContent': {
                                templateUrl: 'templates/access/plant/plant.view.html',
                                controller: 'PlantProfileCtrl'
                            }
                        }
                    })
                    
                    .state('app.plants/add', {
                        url: '/plants/add/plant',
                        views: {
                            'menuContent': {
                                templateUrl: 'templates/access/plant/plant.add.html',
                                controller: 'PlantCtrl'
                            }
                        }
                    })
            
                    .state('app.users', {
                        url: '/users',
                        views: {
                            'menuContent': {
                                templateUrl: 'templates/access/user/user.list.html',
                                controller: 'UserCtrl'
                            }
                        }
                    })

                    .state('app.users/add', {
                        url: '/users/add',
                        views: {
                            'menuContent': {
                                templateUrl: 'templates/access/user/user.add.html',
                                controller: 'UserCtrl'
                            }
                        }
                    })

                    .state('app.users/view', {
                        url: '/users/:userId/:userName',
                        views: {
                            'menuContent': {
                                templateUrl: 'templates/access/user/user.view.html',
                                controller: 'UserProfileCtrl'
                            }
                        }
                    })

                    .state('app.profile', {
                        url: '/profile',
                        views: {
                            'menuContent': {
                                templateUrl: 'templates/access/user/user.profile.html',
                                controller: 'UserCtrl'
                            }
                        }
                    });

            // if none of the above states are matched, use this as the fallback
            $urlRouterProvider.otherwise('/login');
        });
