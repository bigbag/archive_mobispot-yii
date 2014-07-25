'use strict';
angular.module('mobispot').controller('SlideController',
  function($scope) {

  $scope.IMAGE_WIDTH = 300;
  $scope.FADE_SPEED = 600;

  $scope.getRandomInt = function(min, max){
    return Math.floor(Math.random() * (max - min + 1)) + min;
  };

  $scope.wristband = {};
  $scope.wristband.name = 'wristband';
  $scope.wristband.listposition = {left:"0px"};
  $scope.wristband.slides = [
    {id:0, img:'wristband_black.png', tmb_style:'background: #000'},
    {id:1, img:'wristband_blue.png', tmb_style:'background: #0062FF'},
    {id:2, img:'wristband_red.png', tmb_style:'background: #ff0050'},
    {id:3, img:'wristband_green.png', tmb_style:'background: #30D874'},
    {id:4, img:'wristband_yellow.png', tmb_style:'background: #30D874'},
    {id:5, img:'wristband_green_p1.png', tmb_style:'background: #30D874'},
    {id:6, img:'wristband_blue_p2.png', tmb_style:'background: #30D874'},
    {id:7, img:'wristband_red_p3.png', tmb_style:'background: #30D874'},
    {id:8, img:'wristband_black_p4.png', tmb_style:'background: #30D874'},
    {id:9, img:'wristband_blue_p5.png', tmb_style:'background: #30D874'},
    {id:10, img:'wristband_green_p6.png', tmb_style:'background: #30D874'},
    {id:11, img:'wristband_red_p7.png', tmb_style:'background: #30D874'},
    {id:12, img:'wristband_white.png', tmb_style:'background: #fff'}
  ];
  $scope.wristband.current = $scope.getRandomInt(0, $scope.wristband.slides.length - 1);

  $scope.cards = {};
  $scope.cards.name = 'cards';
  $scope.cards.listposition = {left:"0px"};
  $scope.cards.slides = [
    {id:0, img:'card_black.png', tmb_style:'background: #000'},
    {id:1, img:'card_blue.png', tmb_style:'background: #0062FF'},
    {id:2, img:'card_green.png', tmb_style:'background: #5AC0B9'},
    {id:3, img:'card_red.png', tmb_style:'background: #AB2640'},
    {id:4, img:'card_yellow.png', tmb_style:'background: #d5d850'},
    {id:5, img:'card_white.png', tmb_style:'background: #fff'}
  ];
  $scope.cards.current = $scope.getRandomInt(0, $scope.cards.slides.length - 1);

  $scope.keyfobs = {};
  $scope.keyfobs.name = 'keyfobs';
  $scope.keyfobs.listposition = {left:"0px"};
  $scope.keyfobs.slides = [
    {id:0, img:'keyfobs_black.png', tmb_style:'background: #000'},
    {id:1, img:'keyfobs_red.png', tmb_style:'background: #ff0050'},
    {id:2, img:'keyfobs_green.png', tmb_style:'background: #30D874'},
    {id:3, img:'keyfobs_yellow.png', tmb_style:'background: #d5d850'},
    {id:4, img:'keyfobs_blue.png', tmb_style:'background: #0062FF'},
    {id:5, img:'keyfobs_white.png', tmb_style:'background: #fff'}
  ];
  $scope.keyfobs.current = $scope.getRandomInt(0, $scope.keyfobs.slides.length - 1);

  $scope.scrollTo = function(slider, ind) {
    slider.listposition = {left:($scopeIMAGE_WIDTH * ind * -1) + "px"};
  };

  $scope.fadeTo = function(slider, ind) {
    angular.element("#slider-" + slider.name + " .f-slide").stop();
    var id = "#" + slider.name + "_" + ind;
    angular.element("#slider-" + slider.name + " .f-slide[id!=" +id +"]").fadeOut(0);
    angular.element(id).fadeIn($scope.FADE_SPEED);
  };

  $scope.randomSlide = function(slider) {
    $scope.fadeTo(slider, $scope.getRandomInt(0, slider.slides.length - 1));
  };
});