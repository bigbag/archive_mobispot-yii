angular.module("ui.pagination", [])
    .directive('uiPagination', function () {
        return {
            restrict: 'EA',
            replace: true,
            template:
                    '<ul class="pagination">' +
                        '<li class="arrow" ng-hide="firstPage()" ng-click="goToFirstPage()">' +
                            '<a>&laquo;</a>' +
                        '</li>' +
                        '<li ng-hide="!hasPrev()" ng-click="prev()">' +
                            '<a>&lt;</a>' +
                        '</li>' +
                        '<li ng-repeat="page in pages"' +
                            'ng-class="{current: isCurrent(page)}"' +
                            'ng-click="setCurrent(page)"' +
                        '>' +
                            '<a>{{page}}</a>' +
                        '</li>' +
                        '<li ng-hide="!hasNext()" ng-click="next()">' +
                            '<a>&gt;</a>' +
                        '</li>' +
                        '<li class="arrow" ng-hide="lastPage()" ng-click="goToLastPage()">' +
                            '<a>&raquo;</a>' +
                        '</li>' +
                    '</ul>',
            scope: {
                cur: '=',
                total: '=',
                display: '@'
            },
            link: function (scope, element, attrs) {
                var calcPages = function () {
                    var display = +scope.display;
                    var delta = Math.floor(display / 2);
                    scope.start = scope.cur - delta;
                    if (scope.start < 1) {
                        scope.start = 1;
                    }
                    scope.end = scope.start + display - 1;
                    if (scope.end > scope.total) {
                        scope.end = scope.total;
                        scope.start = scope.end - (display - 1);
                        if (scope.start < 1) {
                            scope.start = 1;
                        }
                    }

                    scope.pages = [];
                    for (var i = scope.start; i <= scope.end; ++i) {
                        scope.pages.push(i);
                    }
                };
                scope.$watch('cur', calcPages);
                scope.$watch('total', calcPages);
                scope.$watch('display', calcPages);

                scope.isCurrent = function (index) {
                    return scope.cur == index;
                };

                scope.setCurrent = function (index) {
                    scope.cur = index;
                };

                scope.hasPrev = function () {
                    return scope.cur > 1;
                };
                scope.prev = function () {
                    if (scope.hasPrev()) scope.cur--;
                };

                scope.hasNext = function () {
                    return scope.cur < scope.total;
                };
                scope.next = function () {
                    if (scope.hasNext()) scope.cur++;
                };

                scope.firstPage = function () {
                    return scope.start == 1;
                };
                scope.goToFirstPage = function () {
                    if (!scope.firstPage()) scope.cur = 1;
                };
                scope.lastPage = function () {
                    return scope.end == scope.total;
                };
                scope.goToLastPage = function () {
                    if (!scope.lastPage()) scope.cur = scope.total;
                };
            }
        };
    });