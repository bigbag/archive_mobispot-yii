'use strict';

var app = angular.module('mobispot', []);

var CODE_REGEXP = /^\-?\w{10}$/;
	app.directive('activationCode', function() {
	return {
		require: 'ngModel',
		link: function(scope, elm, attrs, ctrl) {
			ctrl.$parsers.unshift(function(viewValue) {
				if (CODE_REGEXP.test(viewValue)) {
					// it is valid
					ctrl.$setValidity('activationCode', true);
					return viewValue;
				} else {
					// it is invalid, return undefined (no model update)
					ctrl.$setValidity('activationCode', false);
					return undefined;
				}
			});
		}
	};
});