'use strict';
angular.module('mobispot', ['ngCookies', 'ui.sortable','ui.mask']);

angular.module('mobispot').filter('tel', function () {
    return function (tel) {
        if (!tel) { return ''; }

        var value = tel.toString().trim().replace(/^\+/, '');

        var country = value.slice(0, 1);
        var code = value.slice(1, 4);
        var number = value.slice(4);

        number = number.slice(0, 3) + ' ' + number.slice(3, 5) + ' ' + number.slice(5);

        return ('+' + country + " (" + code + ") " + number).trim();
    };
});
