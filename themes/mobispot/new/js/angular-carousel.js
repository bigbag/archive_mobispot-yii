/**
 * Angular Carousel - Mobile friendly touch carousel for AngularJS
 * @version v0.1.7 - 2014-02-12
 * @link http://revolunet.github.com/angular-carousel
 * @author Julien Bouquillon <julien@revolunet.com>
 * @license MIT License, http://www.opensource.org/licenses/MIT
 */
/*global angular */

/*
Angular touch carousel with CSS GPU accel and slide buffering
http://github.com/revolunet/angular-carousel

*/

/*
Fork Pavel Liashkov 2014
*/


angular.module('angular-carousel', [
    'ngTouch'
]);

angular.module('angular-carousel')

.directive('rnCarouselControls', [function() {
  return {
    restrict: 'A',
    replace: true,
    scope: {
      items: '=',
      index: '=',
    },
    link: function(scope) {
        scope.prev = function() {
            scope.index--;
            if(scope.index < 0) {
                scope.index = scope.items.length -1;
            }
        };
        scope.next = function() {
            scope.index++;
            if(scope.index > scope.items.length -1) {
                scope.index = 0;
            }
      };
    },
    template:   
                '<div class="rn-carousel-controls">' +
                '<a class="rn-carousel-control rn-carousel-control-prev"  ng-click="prev()" >&#xe602;</a>' +
                '<a class="rn-carousel-control rn-carousel-control-next"  ng-click="next()" >&#xe603;</a>' +
               '</div>'
  };
}]);

(function() {
    "use strict";

    angular.module('angular-carousel')

    .directive('rnCarousel', ['$swipe', '$window', '$document', '$parse', '$compile', function($swipe, $window, $document, $parse, $compile) {
        // internal ids to allow multiple instances
        var carouselId = 0,
            // used to compute the sliding speed
            timeConstant = '1200ms',
            startDelay = '200ms',
            // in container % how much we need to drag to trigger the slide change
            moveTreshold = 0.05,
            // in absolute pixels, at which distance the slide stick to the edge on release
            rubberTreshold = 3;


        return {
            restrict: 'A',
            scope: true,
            compile: function(tElement, tAttributes) {
                // use the compile phase to customize the DOM
                var firstChildAttributes = tElement.children()[0].attributes,
                    isRepeatBased = false,
                    isBuffered = false,
                    slidesCount = 0,
                    isIndexBound = false,
                    repeatItem,
                    repeatCollection,
                    currentSlide = 0;

                // add CSS classes
                tElement.addClass('rn-carousel-slides');
                tElement.children().addClass('rn-carousel-slide');

                // try to find an ngRepeat expression
                // at this point, the attributes are not yet normalized so we need to try various syntax
                ['ng-repeat', 'data-ng-repeat', 'x-ng-repeat'].every(function(attr) {
                    var repeatAttribute = firstChildAttributes[attr];
                    if (angular.isDefined(repeatAttribute)) {
                        // ngRepeat regexp extracted from angular 1.2.7 src
                        var exprMatch = repeatAttribute.value.match(/^\s*([\s\S]+?)\s+in\s+([\s\S]+?)(?:\s+track\s+by\s+([\s\S]+?))?\s*$/),
                            trackProperty = exprMatch[3];

                        repeatItem = exprMatch[1];
                        repeatCollection = exprMatch[2];

                        if (repeatItem) {
                            if (angular.isDefined(tAttributes['rnCarouselBuffered'])) {
                                // update the current ngRepeat expression and add a slice operator if buffered
                                isBuffered = true;
                                repeatAttribute.value = repeatItem + ' in ' + repeatCollection + '|carouselSlice:carouselBufferIndex:carouselBufferSize';
                                if (trackProperty) {
                                    repeatAttribute.value += ' track by ' + trackProperty;
                                }
                            }
                            isRepeatBased = true;
                            return false;
                        }
                    }
                    return true;
                });

                return function(scope, iElement, iAttributes, containerCtrl) {
                    carouselId++;

                    var containerWidth,
                        transformProperty,
                        pressed,
                        startX,
                        amplitude,
                        offset = 0,
                        destination,
                        slidesCount = 0,
                        timestamp;

                    var carousel = iElement.wrap("<div id='carousel-" + carouselId +"' class='rn-carousel-container'></div>"),
                        container = carousel.parent(),
                        slides = carousel.children();

                    if (angular.isDefined(iAttributes.rnCarouselControl)) {
                        updateControlArray();
                        scope.$watch('carouselIndex', function(newValue) {
                            scope.controlIndex = newValue;
                        });
                        scope.$watch('controlIndex', function(newValue) {
                            goToSlide(newValue, true);
                            currentSlide = newValue;
                        });

                    }

                    if (angular.isDefined(iAttributes.rnCarouselControl)) {
                        var controls = $compile("<div id='carousel-" + carouselId +"-controls' index='controlIndex' items='carouselControlArray' rn-carousel-controls class='rn-carousel-controls'></div>")(scope);
                        container.append(controls);
                    }

                    scope.carouselBufferIndex = 0;
                    scope.carouselBufferSize = 5;
                    scope.carouselIndex = 0;

                    // handle index databinding
                    if (iAttributes.rnCarouselIndex) {
                        var updateParentIndex = function(value) {
                            indexModel.assign(scope.$parent, value);
                        };
                        var indexModel = $parse(iAttributes.rnCarouselIndex);
                        if (angular.isFunction(indexModel.assign)) {
                            scope.$watch('carouselIndex', function(newValue) {
                                updateParentIndex(newValue);
                            });
                            scope.carouselIndex = indexModel(scope);
                            scope.$parent.$watch(indexModel, function(newValue, oldValue) {
                                if (newValue!==undefined) {
                                    if (newValue >= slidesCount) {
                                        newValue = slidesCount - 1;
                                        updateParentIndex(newValue);
                                    } else if (newValue < 0) {
                                        newValue = 0;
                                        updateParentIndex(newValue);
                                    }
                                    goToSlide(newValue, true);
                                }
                            });
                            isIndexBound = true;
                        } else if (!isNaN(iAttributes.rnCarouselIndex)) {
                          scope.carouselIndex = parseInt(iAttributes.rnCarouselIndex, 10);
                        }
                    }

                    if (isRepeatBased) {
                        scope.$watchCollection(repeatCollection, function(newValue, oldValue) {
                            slidesCount = 0;
                            if (angular.isArray(newValue)) {
                                slidesCount = newValue.length;
                            } else if (angular.isObject(newValue)) {
                                slidesCount = Object.keys(newValue).length;
                            }
                            updateControlArray();
                            if (!containerWidth) updateContainerWidth();
                            goToSlide(scope.carouselIndex);
                        });
                    } else {
                        slidesCount = iElement.children().length;
                        updateControlArray();
                        updateContainerWidth();
                    }

                    function updateControlArray() {
                        var items = [];
                        for (var i = 0; i < slidesCount; i++) items[i] = i;
                        scope.carouselControlArray = items;
                    }

                    function getCarouselWidth() {
                        if (slides.length === 0) {
                            containerWidth = carousel[0].getBoundingClientRect().width;
                        } else {
                            containerWidth = slides[0].getBoundingClientRect().width;
                        }
                        return Math.floor(containerWidth);
                    }

                    function updateContainerWidth() {
                        container.css('width', '100%');
                        container.css('width', getCarouselWidth() + 'px');
                    }

                    function scroll(x) {
                        // use CSS 3D transform to move the carousel
                        if (isNaN(x)) {
                            x = scope.carouselIndex * containerWidth;
                        }
                        var move = -Math.round(x);
                        
                        move += (scope.carouselBufferIndex * containerWidth);

                        slides[currentSlide].style['z-index'] = '5';

                        carousel[0].style[transformProperty] = 'translate3d(' + move + 'px, 0, 0)';
                        carousel[0].style['-webkit-transition'] = '-webkit-transform ' + timeConstant + ' ' + startDelay + ' ease'; 
                        carousel[0].style['transition'] = 'transform ' + timeConstant + ' ' + startDelay + ' ease';
                        slides[currentSlide].style['z-index'] = '0';
                    }   

                    function capIndex(idx) {
                        return (idx >= slidesCount) ? slidesCount: (idx <= 0) ? 0 : idx;
                    }

                    function updateBufferIndex() {
                        var bufferIndex = 0;
                        var bufferEdgeSize = (scope.carouselBufferSize - 1) / 2;
                        if (isBuffered) {
                            if (scope.carouselIndex <= bufferEdgeSize) {
                                bufferIndex = 0;
                            } else if (slidesCount < scope.carouselBufferSize) {
                                bufferIndex = 0;
                            } else if (scope.carouselIndex > slidesCount - scope.carouselBufferSize) {
                                bufferIndex = slidesCount - scope.carouselBufferSize;
                            } else {
                                bufferIndex = scope.carouselIndex - bufferEdgeSize;
                            }
                        }
                        scope.carouselBufferIndex = bufferIndex;
                    }

                    function goToSlide(i, animate) {
                        if (isNaN(i)) {
                            i = scope.carouselIndex;
                        }
                        if (animate) {
                            // simulate a swipe so we have the standard animation
                            // used when external binding index is updated or touch canceed
                            offset = (i * containerWidth);
                            swipeEnd(null, true);
                            return;
                        }
                        scope.carouselIndex = capIndex(i);
                        updateBufferIndex();
                        // if outside of angular scope, trigger angular digest cycle
                        // use local digest only for perfs if no index bound
                        if (scope.$$phase!=='$apply' && scope.$$phase!=='$digest') {
                            if (isIndexBound) {
                                scope.$apply();
                            } else {
                                scope.$digest();
                            }
                        }
                        scroll();
                    }

                    function getAbsMoveTreshold() {
                        // return min pixels required to move a slide
                        return moveTreshold * containerWidth;
                    }


                    function capPosition(x) {
                        // limit position if start or end of slides
                        var position = x;
                        if (scope.carouselIndex===0) {
                            position = Math.max(-getAbsMoveTreshold(), position);
                        } else if (scope.carouselIndex===slidesCount-1) {
                            position = Math.min(((slidesCount-1)*containerWidth + getAbsMoveTreshold()), position);
                        }
                        return position;
                    }

                    function swipeEnd(event, forceAnimation) {
                       if(event) {
                            return;
                        }

                        pressed = false;
                        destination = offset;

                        var minMove = getAbsMoveTreshold(),
                            currentOffset = (scope.carouselIndex * containerWidth),
                            absMove = currentOffset - destination,
                            slidesMove = -Math[absMove>=0?'ceil':'floor'](absMove / containerWidth),
                            shouldMove = Math.abs(absMove) > minMove;

                        if ((slidesMove + scope.carouselIndex) >= slidesCount ) {
                            slidesMove = slidesCount - 1 - scope.carouselIndex;
                        }
                        if ((slidesMove + scope.carouselIndex) < 0) {
                            slidesMove = -scope.carouselIndex;
                        }
                        var moveOffset = shouldMove?slidesMove:0;

                        destination = (moveOffset + scope.carouselIndex) * containerWidth;

                        if (destination == containerWidth*(slidesCount -2 )) {
                            goToSlide(0);
                        }
                        
                        amplitude = destination - offset;
                        timestamp = Date.now();
                        if (forceAnimation) {
                            amplitude = offset - currentOffset;
                        }
                        scroll(destination);
                        return false;
                    }

                    // инициализируем первый слайдер
                    if (!isIndexBound) {
                        goToSlide(scope.carouselIndex);
                    }

                    // находим css префикс
                    transformProperty = 'transform';
                    ['webkit', 'Moz', 'O', 'ms'].every(function (prefix) {
                        var e = prefix + 'Transform';
                        if (typeof document.body.style[e] !== 'undefined') {
                            transformProperty = e;
                            return false;
                        }
                        return true;
                    });

                    function onOrientationChange() {
                        updateContainerWidth();
                        goToSlide();
                    }

                    //Перестраиваем слайдер при изменении размера или ориентации экрана
                    var winEl = angular.element($window);
                    winEl.bind('orientationchange', onOrientationChange);
                    winEl.bind('resize', onOrientationChange);

                    scope.$on('$destroy', function() {
                        winEl.unbind('orientationchange', onOrientationChange);
                        winEl.unbind('resize', onOrientationChange);
                    });

                };
            }
        };
    }]);

})();