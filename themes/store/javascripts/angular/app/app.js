'use strict';

var app = angular.module('mobispot', [])
	.directive('makeSlider',function() {
        return function(scope, elm, attrs) {
            elm.orbit({
				timer: false,
				advanceSpeed: 6000,
				bullets: true,
				bulletThumbs: true,
				directionalNav: false
			});
        };
    });
	
app.factory('itemsService', function($rootScope) {
    var sharedService = {};
    
    sharedService.itemsInCart = '';

    sharedService.prepForBroadcast = function(count) {
        this.itemsInCart = count;
        this.broadcastItem();
    };

    sharedService.broadcastItem = function() {
        $rootScope.$broadcast('handleBroadcast');
    };

    return sharedService;
});	

ProductCtrl.$inject = ['$scope', 'itemsService']; 

CartCtrl.$inject = ['$scope', 'itemsService']; 

StoreHeadCtrl.$inject = ['$scope', 'itemsService']; 