'use strict';
mobispot.directive("required", ['$timeout', function($timeout) {
    return function(scope, element, attrs) {
        element.on('change.autofill DOMAttrModified.autofill keydown.autofill propertychange.autofill', function(e) {
            $timeout(function() {
                if (element.val()!=='') {
                    element.trigger('input');
                }
            }, 0);
        });
    }
}]);