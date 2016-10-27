angular.module('mediApp.services', ['angular-loading-bar'])

        .service('LoginService', ['$http', 'base', function ($http, base) {
                return {
                    checkUser: function (formData) {
                        var params = '?user_name=' + formData.email;

                        return $http.get(base + 'api/authentication/checkUser' + params).then(function (response) {
                            return response.data;
                        });
                    },
                    authenticateUser: function (formData) {
                        var params = '?user_name=' + formData.email + '&password=' + formData.password;

                        return $http.get(base + 'api/authentication/authenticateUser' + params).then(function (response) {
                            return response.data;
                        });
                    }
                };
            }])

        .service('RegisterService', ['$http', 'base', function ($http, base) {

            return {
                registerUser: function (formData) {
                    return $http.post(base + 'api/registration/registerUser', formData).then(function (response) {
                        return response.data;
                    });
                }
            };

        }])

        .service('AppService', ['$http', 'base', function ($http, base) {
                return {
                    endSession: function () {
                        return $http.post(base + 'api/authentication/endSession');
                    }
                };
            }])

        .service('PlantService', ['$http', 'base', 'Upload', function ($http, base, Upload) {
                return {
                    getPlants: function () {
                        return $http.get(base + 'api/plant/getPlants').then(function (response) {
                            return response.data;
                        });
                    },
                    getPlantProfile: function (plantId) {
                        return $http.get(base + 'api/plant/getPlantProfile?plant_id=' + plantId).then(function (response) {
                            return response.data;
                        });
                    },
                    newPlant: function (plant) {
                        return Upload.upload({
                            url: base + 'api/plant/newPlant',
                            data: plant
                        });
                    },
                    updatePlant: function (plant) {
                        return Upload.upload({
                            url: base + 'api/plant/updatePlant',
                            data: plant
                        });
                    },
                    deletePlant: function (plantId) {
                        return $http.get(base + 'api/plant/deletePlant?plant_id=' + plantId).then(function (response) {
                            return response.data;
                        });
                    }
                };
            }])

        .service('UserService', ['$http', 'base', 'Upload', function ($http, base, Upload) {
                return {
                    getUsers: function () {
                        return $http.get(base + 'api/user/getUsers').then(function (response) {
                            return response.data;
                        });  
                    },
                    getUserType: function () {
                        return $http.get(base + 'api/user/getUserType').then(function (response) {
                            return response.data;
                        });
                    },
                    getMyProfile: function () {
                        return $http.get(base + 'api/user/getMyProfile').then(function (response) {
                            return response.data;
                        });
                    },
                    getUserProfile: function (userId) {
                        return $http.get(base + 'api/user/getUserProfile?user_id=' + userId).then(function (response) {
                            return response.data;
                        });
                    },
                    updateProfile: function (profile) {
                        return Upload.upload({
                            url: base + 'api/user/updateProfile',
                            data: profile
                        });
                    },
                    addUser: function (user) {
                        return Upload.upload({
                            url: base + 'api/user/addUser',
                            data: user
                        });
                    },
                    deleteUser: function (userId) {
                        return $http.get(base + 'api/user/deleteUser?user_id=' + userId).then(function (response) {
                            return response.data;
                        });
                    }
                };
            }]);