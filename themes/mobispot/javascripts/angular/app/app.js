'use strict';
var mobispot = angular.module('mobispot', ['ui.directives']);

mobispot.directive("linked",function(){
    return function (scope, element, attrs) {
        var id = attrs["linked"];
        element.on("click",function(){
            document.getElementById(id).click();
        });
    };
});