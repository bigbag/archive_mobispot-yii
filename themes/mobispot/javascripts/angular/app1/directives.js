'use strict';

var myApp = angular.module('mobispot', []);

myApp.directive('equal', function()
{
  	return {
    	require: 'ngModel',
    	link: function(scope, elm, attrs, ctrl)
    	{
      		scope.$watch(attrs.equal, function (newValue)
      		{
        		if (newValue === ctrl.$modelValue)
        		{
        		  	ctrl.$setValidity('equal', true);
        		}
        		else
        		{
        		  	ctrl.$setValidity('equal', false);
        		}
      		});

      		ctrl.$parsers.unshift(function(viewValue)
      		{
        		if (viewValue === scope.$eval(attrs.equal))
        		{
        	 	 	ctrl.$setValidity('equal', true);
        	 	 	return viewValue;
        		}
        		else
        		{
        	 	 	ctrl.$setValidity('equal', false);
        	 	 	return undefined;
        		}
      		});
    	}
  	};
});
