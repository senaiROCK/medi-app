angular.module('mediApp.filters', ['angular-loading-bar'])


        .filter('capitalize', function () {
            return function (mystr) {
                var newstr = mystr.substr(1);
                var fchar = mystr[0];//transform to capitalize
                return fchar.toUppercase() + newstr;

            };
        });