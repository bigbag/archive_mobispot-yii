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
    {id:0, img:'brace_black.jpg'},
    {id:1, img:'brace_blue.jpg'},
    {id:2, img:'brace_green.jpg'},
    {id:3, img:'brace_patt01.jpg'},
    {id:4, img:'brace_patt02.jpg'},
    {id:5, img:'brace_patt03.jpg'},
    {id:6, img:'brace_patt04.jpg'},
    {id:7, img:'brace_patt05.jpg'},
    {id:8, img:'brace_patt06.jpg'},
    {id:9, img:'brace_patt07.jpg'},
    {id:10, img:'brace_red.jpg'},
    {id:11, img:'brace_white.jpg'},
    {id:12, img:'card_black.jpg'},
    {id:13, img:'card_blue.jpg'},
    {id:14, img:'card_green.jpg'},
    {id:15, img:'card_red.jpg'},
    {id:16, img:'card_white.jpg'},
    {id:17, img:'card_yellow.jpg'},
    {id:18, img:'key_black.jpg'},
    {id:19, img:'key_blue.jpg'},
    {id:20, img:'key_green.jpg'},
    {id:21, img:'key_red.jpg'},
    {id:22, img:'key_white.jpg'},
    {id:23, img:'key_yellow.jpg'},
    {id:24, img:'brace_yellow.jpg'},
  ];
  
  $scope.spots.wristbands = [0, 1, 4, 2, 3, 5, 6, 7, 8, 9, 10, 11, 24];
  $scope.spots.wristbands_current = $scope.spots.wristbands[$scope.getRandomInt(0, $scope.spots.wristbands.length - 1)];
  
  $scope.spots.cards = [12, 13, 14, 15, 16, 17];
  $scope.spots.cards_current  = 12;
  
  $scope.spots.keys = [18, 19, 20, 21, 22, 23];
  $scope.spots.keys_current  = 18;
  
  $scope.spots.current = $scope.spots.wristbands_current;
  $scope.spots.current_type = 'wristband';
  $scope.spots.color_rotation = false;
  $scope.spots.timer_rotation = false;
  //$scope.getRandomInt(0, $scope.wristband.slides.length - 1);
  
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
        
    if ($scope.spots.timer_rotation)
        return false;
    
    $scope.spots.timer_rotation = true;
    $timeout(function(){
     $scope.colorRotation();
    }, 300);
  };
  
  $scope.stopColors = function() {
    $scope.spots.color_rotation = false;
  };
  
  $scope.colorRotation = function() {
    if (!$scope.spots.color_rotation) {
      $scope.spots.timer_rotation = false;
      return false;
    }
     
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
        
   $scope.spots.timer_rotation = true;
   $timeout(function(){
     $scope.colorRotation();
   }, 1300);
 
  };
  
  $scope.randomSlide = function(slider) {
    $scope.fadeTo(slider, $scope.getRandomInt(0, slider.slides.length - 1));
  };
});