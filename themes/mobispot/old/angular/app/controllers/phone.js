'use strict';
angular.module('mobispot').controller('PhonesCtrl', 
  function($scope) {
	$scope.initPhones = function(initValue)
	{
		$scope.parents = initValue;
		var herher = $scope.parents.models;
	}
});
