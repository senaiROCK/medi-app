angular.module('mediApp.controllers', ['angular-loading-bar'])

        .controller('LoginCtrl', ['$scope', 'toastr', '$state', 'LoginService', 'RegisterService', 
            function ($scope, toastr, $state, LoginService, RegisterService) {

                $scope.login = function () {
                    LoginService.checkUser($scope.formData).then(function (response) {
                        if (response.status) {
                            $scope.responseMsg.user = null;
                            $('#form-user').hide();
                            $('#form-password').fadeIn();

                            if ($scope.formData.password) {
                                LoginService.authenticateUser($scope.formData).then(function (response) {
                                    if (response.status) {
                                        $state.go('app.profile');
                                        setFields();
                                    } else {
                                        toastr.warning(response.response_msg);
                                    }
                                }, function () {
                                    toastr.error('Something is wrong !');
                                });
                            }
                        } else {
                            toastr.warning('Unrecognized user !');
                        }
                    }, function () {
                        toastr.error('Something is wrong !');
                    });
                };

                $scope.register = function () {
                    RegisterService.registerUser($scope.formData).then(function (response) {
                        if (response.status) {
                            toastr.success(response.response_msg);
                            setFields();
                        } else {
                            toastr.warning(response.response_msg);
                        }
                    }, function () {
                        toastr.error('Something is wrong !');
                    });
                };

                $scope.showRegister = function () {
                    $('#form-password').hide();
                    $('#form-user').hide();
                    $('#form-register').fadeIn();
                };

                $scope.returnView = function () {
                    $('#form-password').hide();
                    $('#form-register').hide();
                    $('#form-user').fadeIn();
                };

                setFields = function () {
                    $scope.formData = {};
                    $scope.responseMsg = {
                        user: null,
                        password: null
                    };
                };

                setFields();
            }])

        .controller('AppCtrl', ['$scope', '$state', 'AppService', 'UserService', 'toastr', 
            function ($scope, $state, AppService, UserService, toastr) {
                
                $scope.isAdmin = false;
            
                $scope.endSession = function () {
                    AppService.endSession();
                    $state.go('login');
                };
            
                loadUserType = function () {
                    UserService.getUserType().then(function (response) {
                        $scope.isAdmin = response;
                    }, function (error) {
                        toastr.error('Something is wrong !');
                    });
                };
            
                loadUserType();
            }])

        .controller('PlantCtrl', ['$scope', '$state', '$stateParams', 'toastr', 'PlantService', 'UserService', 'baseImagePath',
            function ($scope, $state, $stateParams, toastr, PlantService, UserService, baseImagePath) {
                
                $scope.base = baseImagePath;
                $scope.isAdmin = false;
                $scope.plants = [];
                $scope.formData = {};

                $scope.addPlant = function () {
                    PlantService.newPlant($scope.formData).then(function (response) {
                        if (response.data.status) {
                            toastr.success(response.data.response_msg);
                            setFields();
                            loadPlants();
                            $state.go('app.plants');
                        } else {
                            toastr.warning(response.data.response_msg);
                        }
                    }, function () {
                        toastr.error('Something is wrong !');
                    });
                };

                loadPlants = function () {
                    PlantService.getPlants().then(function (response) {
                        $scope.plants = response;
                    }, function () {
                        toastr.error('Something is wrong !');
                    });
                };

                loadUserType = function () {
                    UserService.getUserType().then(function (response) {
                        $scope.isAdmin = response;
                    }, function (error) {
                        toastr.error('Something is wrong !');
                    });
                };
                
                setFields = function () {
                    $scope.formData = {
                        imageHolder: 'img/image_placeholder.png'
                    };  
                };

                loadPlants();
                loadUserType();
                setFields();
            }])

        .controller('PlantProfileCtrl', ['$scope', '$stateParams', '$state', 'toastr', 'PlantService', 'baseImagePath', 
            function ($scope, $stateParams, $state, toastr, PlantService, baseImagePath) {

            $scope.base = baseImagePath;
            $scope.formData = {};
            $scope.plant = {};
            $scope.viewTitle = $stateParams.plantName;

            plantId = parseInt($stateParams.plantId);

            $scope.updatePlant = function () {
                $scope.plant.plant_pic = ($scope.formData.plantPic) ? $scope.formData.plantPic : $scope.plant.plant_name;
                PlantService.updatePlant($scope.plant).then(function (response) {
                    if (response.data.status) {
                        toastr.success(response.data.response_msg);
                        setFields();
                        loadPlantProfile();
                    } else {
                        toastr.warning(response.data.response_msg);
                    }
                }, function () {
                    toastr.error('Something is wrong !');
                });
            };

            $scope.deletePlant = function () {
                PlantService.deletePlant(plantId).then(function (response) {
                    if (response.status) {
                        toastr.success(response.response_msg);
                        $state.go('app.plants');
                    } else {
                        toastr.warning(response.response_msg);
                    }
                }, function () {
                    toastr.error('Something is wrong !');
                });
            };

            loadPlantProfile = function () {
                PlantService.getPlantProfile(plantId).then(function (response) {
                    $scope.plant = response;
                }, function () {
                    toastr.error('Something is wrong !');
                });
            };

            setFields = function () {
                $scope.formData = {
                    imageHolder: 'img/image_placeholder.png'
                };  
            };

            loadPlantProfile();
            setFields();

        }])

        .controller('UserCtrl', ['$scope', 'toastr', 'UserService', 'baseImagePath', function ($scope, toastr, UserService, baseImagePath) {
                
                $scope.base = baseImagePath;
                $scope.users = {};
                $scope.profile = {};
                $scope.formData = {};

                $scope.updateProfile = function () {
                    $scope.profile.user_profile_photo = $scope.formData.profilePhoto;
                    UserService.updateProfile($scope.profile).then(function (response) {
                        if (response.status) {
                            toastr.success(response.data.response_msg);
                            setFields();
                            loadProfile();
                        } else {
                            toastr.warning(response.data.response_msg);
                        }
                    }, function () {
                        toastr.error('Something is wrong !');
                    });
                };

                $scope.addUser = function () {
                    UserService.addUser($scope.formData).then(function (response) {
                        if (response.status) {
                            toastr.success(response.data.response_msg);
                            setFields();
                        } else {
                            toastr.warning(response.data.response_msg);
                        }
                    }, function () {
                        toastr.error('Something is wrong !');
                    })
                };
            
                loadUsers = function () {
                    UserService.getUsers().then(function (response) {
                        $scope.users = response;
                    }, function (error) {
                        toastr.error('Something is wrong !');
                    });  
                };

                loadProfile = function () {
                    UserService.getMyProfile().then(function (response) {
                        $scope.profile = response;
                    }, function () {
                        toastr.error('Something is wrong !');
                    })
                };

                setFields = function () {
                    $scope.formData = {
                        imageHolder: 'img/image_placeholder.png'
                    };  
                };
            
                loadUsers();
                loadProfile();
                setFields();

            }])


        .controller('UserProfileCtrl', ['$scope', '$stateParams', '$state', 'toastr', 'UserService', 'baseImagePath',
            function ($scope, $stateParams, $state, toastr, UserService, baseImagePath) {

                var userId = parseInt($stateParams.userId);
                $scope.base = baseImagePath;
                $scope.viewTitle = $stateParams.userName;
                $scope.profile = {};
                $scope.formData = {};

                $scope.deleteUser = function () {
                    UserService.deleteUser(userId).then(function (response) {
                        if (response.status) {
                            toastr.success(response.response_msg);
                            $state.go('app.users');
                        } else {
                            toastr.warning(response.response_msg);
                        }
                    }, function () {
                        toastr.error('Something is wrong !');
                    });
                };

                $scope.updateUserProfile = function () {
                    $scope.profile.user_profile_photo = $scope.formData.profilePhoto;
                    UserService.updateProfile($scope.profile).then(function (response) {
                        if (response.status) {
                            toastr.success(response.data.response_msg);
                            setFields();
                            loadUserProfile();
                        } else {
                            toastr.warning(response.data.response_msg);
                        }
                    }, function () {
                        toastr.error('Something is wrong !');
                    });
                };

                loadUserProfile = function () {
                    UserService.getUserProfile(userId).then(function (response) {
                        $scope.profile = response;
                    }, function () {
                        toastr.error('Something is wrong !');
                    });
                };

                setFields = function () {
                    $scope.formData = {
                        imageHolder: 'img/image_placeholder.png'
                    };  
                };

                loadUserProfile();
                setFields();

            }]);
