

function SmsCtrl($scope) {
	$scope.tiktak;
	$scope.myValue = 1;
	$scope.number = '';

	$scope.acceptNumber = function(){
		$scope.myValue = 0;
	}
	$scope.resetNumber = function(){
		$scope.myValue = 1;
	}
	$scope.startTimer = function(){
		var second = 5;
		$scope.timer = 0;
		$scope.countDown(second);
		
	}
	$scope.countDown = function(second){

		$scope.timer = second;
		if(second<=9){second="0" + second;}
		second--;
		if(second < -1){
			return false;
		}
		$scope.$apply();

		setTimeout(function() { $scope.countDown(second) }, 1000);
	}



}
