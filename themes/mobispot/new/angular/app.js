'use strict';
angular.module('test', []);

angular.module('test').config(function($interpolateProvider) {
    $interpolateProvider.startSymbol('{[{');
    $interpolateProvider.endSymbol('}]}');
});

angular.module('test')
    .controller('GeneralController', function($scope) {
        $scope.user = {name: '', last: 'visitor'};

        $scope.test = function() {
            console.log(1);
        };
    }
);