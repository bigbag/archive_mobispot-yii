'use strict';

var app = angular.module('mobispot', []);

var CODE_REGEXP = /^\-?\w{10}$/;
	app.directive('activationCode', function() {
	return {
		require: 'ngModel',
		link: function(scope, elm, attrs, ctrl) {
			ctrl.$parsers.unshift(function(viewValue) {
				if (CODE_REGEXP.test(viewValue)) {
					ctrl.$setValidity('activationCode', true);
					return viewValue;
				} else {
					ctrl.$setValidity('activationCode', false);
					return undefined;
				}
			});
		}
	};
});