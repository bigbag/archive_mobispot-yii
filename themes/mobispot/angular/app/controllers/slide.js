'use strict';
angular.module('mobispot').controller('SlideController',
  function($scope, $timeout) {

  $scope.IMAGE_WIDTH = 300;
  $scope.FADE_SPEED = 600;

  $scope.getRandomInt = function(min, max){
    return Math.floor(Math.random() * (max - min + 1)) + min;
  };

  $scope.spots = {};
  $scope.spots.name = 'spots';
  $scope.spots.listposition = {left:"0px"};
  $scope.spots.slides = [
    {id:0, img:'brace_black.png', tmb_style:'background: #000'},
    {id:1, img:'brace_blue.png', tmb_style:'background: #0062FF'},
    {id:2, img:'brace_green.png', tmb_style:'background: #5AC0B9'},
    {id:3, img:'brace_patt01.png', tmb_style:'background: #AB2640'},
    {id:4, img:'brace_patt02.png', tmb_style:'background: #d5d850'},
    {id:5, img:'brace_patt03.png', tmb_style:'background: #fff'},
    {id:6, img:'brace_patt04.png', tmb_style:'background: #fff'},
    {id:7, img:'brace_patt05.png', tmb_style:'background: #fff'},
    {id:8, img:'brace_patt06.png', tmb_style:'background: #fff'},
    {id:9, img:'brace_patt07.png', tmb_style:'background: #fff'},
    {id:10, img:'brace_red.png', tmb_style:'background: #fff'},
    {id:11, img:'brace_white.png', tmb_style:'background: #fff'},
    {id:12, img:'card_black.png', tmb_style:'background: #fff'},
    {id:13, img:'card_blue.png', tmb_style:'background: #fff'},
    {id:14, img:'card_green.png', tmb_style:'background: #fff'},
    {id:15, img:'card_red.png', tmb_style:'background: #fff'},
    {id:16, img:'card_white.png', tmb_style:'background: #fff'},
    {id:17, img:'card_yellow.png', tmb_style:'background: #fff'},
    {id:18, img:'key_black.png', tmb_style:'background: #fff'},
    {id:19, img:'key_blue.png', tmb_style:'background: #fff'},
    {id:20, img:'key_green.png', tmb_style:'background: #fff'},
    {id:21, img:'key_red.png', tmb_style:'background: #fff'},
    {id:22, img:'key_white.png', tmb_style:'background: #fff'},
    {id:23, img:'key_yellow.png', tmb_style:'background: #fff'},
  ];
  
  $scope.spots.wristbands = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11];
  $scope.spots.wristbands_current = $scope.spots.wristbands[$scope.getRandomInt(0, $scope.spots.wristbands.length - 1)];
  
  $scope.spots.cards = [12, 13, 14, 15, 16, 17];
  $scope.spots.cards_current  = 12;
  
  $scope.spots.keys = [18, 19, 20, 21, 22, 23];
  $scope.spots.keys_current  = 18;
  
  $scope.spots.current = $scope.spots.wristbands_current;
  $scope.spots.current_type = 'wristband';
  $scope.spots.color_rotation = false;
  //$scope.getRandomInt(0, $scope.wristband.slides.length - 1);
  
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
    slider.listposition = {left:($scope.IMAGE_WIDTH * ind * -1) + "px"};
  };

  $scope.fadeTo = function(slider, ind) {
    if (slider.current == ind) return false;
    
    angular.element("#slider-" + slider.name + " .f-slide").stop();
    var id = "#" + slider.name + "_" + ind;
    console.log(id);
    slider.current = ind;
    angular.element("#slider-" + slider.name + " .f-slide[id!=" +id +"]").fadeOut(0);
    angular.element(id).fadeIn($scope.FADE_SPEED);
  };
  
  $scope.fadeToWistbrands = function() {
    $scope.spots.current_type = 'wristband';
    $scope.fadeTo($scope.spots, $scope.spots.wristbands_current);
  };
  
  $scope.fadeToCards = function() {
    $scope.spots.current_type = 'card';
    $scope.fadeTo($scope.spots, $scope.spots.cards_current);
  };
  
  $scope.fadeToKeys = function() {
    $scope.spots.current_type = 'key';
    $scope.fadeTo($scope.spots, $scope.spots.keys_current);
  };
  
  $scope.startColors = function() {
    if ($scope.spots.color_rotation)
        return false;
        
    $scope.spots.color_rotation = true;
    $scope.colorRotation();
  };
  
  $scope.stopColors = function() {
    $scope.spots.color_rotation = false;
  };
  
  $scope.colorRotation = function() {
    if (!$scope.spots.color_rotation)
      return false;
     
    if ('wristband' == $scope.spots.current_type) {
        var current_ind = -1;
        
        for (var i = 0; i < $scope.spots.wristbands.length; i++)
            if ($scope.spots.wristbands[i] == $scope.spots.wristbands_current)
              current_ind = i;

        if (current_ind < 0) {
            return false;
        }
        
        if (($scope.spots.wristbands.length - 1) == current_ind)
            $scope.spots.wristbands_current = $scope.spots.wristbands[0];
        else
          $scope.spots.wristbands_current = $scope.spots.wristbands[current_ind + 1];

        $scope.fadeToWistbrands();
    }
    else if ('card' == $scope.spots.current_type) {
        var current_ind = -1;
        
        for (var i = 0; i < $scope.spots.cards.length; i++)
            if ($scope.spots.cards[i] == $scope.spots.cards_current)
              current_ind = i;

        if (current_ind < 0) {
            return false;
        }
        
        if (($scope.spots.cards.length - 1) == current_ind)
            $scope.spots.cards_current = $scope.spots.cards[0];
        else
          $scope.spots.cards_current = $scope.spots.cards[current_ind + 1];

        $scope.fadeToCards();
    }
    else if ('key' == $scope.spots.current_type) {
        var current_ind = -1;
        
        for (var i = 0; i < $scope.spots.keys.length; i++)
            if ($scope.spots.keys[i] == $scope.spots.keys_current)
              current_ind = i;

        if (current_ind < 0) {
            return false;
        }
        
        if (($scope.spots.keys.length - 1) == current_ind)
            $scope.spots.keys_current = $scope.spots.keys[0];
        else
          $scope.spots.keys_current = $scope.spots.keys[current_ind + 1];

        $scope.fadeToKeys();
    }
    else
        return false;
        
   $timeout(function(){
     $scope.colorRotation();
   }, 2000);
 
  };
  
  
  
  $scope.randomSlide = function(slider) {
    $scope.fadeTo(slider, $scope.getRandomInt(0, slider.slides.length - 1));
  };
});