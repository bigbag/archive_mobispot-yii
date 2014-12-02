'use strict';
angular.module('mobispot').controller('SlideController',
  function($scope, $timeout) {

  $scope.IMAGE_WIDTH = 300;
  //$scope.FADE_SPEED = 600;
  $scope.FADE_SPEED = 0;

  $scope.getRandomInt = function(min, max){
    return Math.floor(Math.random() * (max - min + 1)) + min;
  };

  $scope.spots = {};
  $scope.spots.name = 'spots';
  $scope.spots.listposition = {left:"0px"};
  $scope.spots.slides = [
    {id:1, img:'brace_blue.png'},
  ];
  
  $scope.spots.wristbands = [1];
  $scope.spots.wristbands_current = $scope.spots.wristbands[0];
  
  $scope.spots.cards = [];
  $scope.spots.cards_current  = -1;
  
  $scope.spots.keys = [];
  $scope.spots.keys_current  = -1;
  
  $scope.spots.current = $scope.spots.wristbands_current;
  $scope.spots.current_type = 'wristband';
  $scope.spots.color_rotation = false;
  $scope.spots.timer_rotation = false;
  //$scope.getRandomInt(0, $scope.wristband.slides.length - 1);
  
  $scope.scrollTo = function(slider, ind) {
    slider.listposition = {left:($scope.IMAGE_WIDTH * ind * -1) + "px"};
  };
  
  $scope.sliderInit = function()
  {
      $scope.spots.slides = [
        {id:0, img:'brace_black.png'},
        {id:1, img:'brace_blue.png'},
        {id:2, img:'brace_green.png'},
        {id:3, img:'brace_patt01.png'},
        {id:4, img:'brace_patt02.png'},
        {id:5, img:'brace_patt03.png'},
        {id:6, img:'brace_patt04.png'},
        {id:7, img:'brace_patt05.png'},
        {id:8, img:'brace_patt06.png'},
        {id:9, img:'brace_patt07.png'},
        {id:10, img:'brace_red.png'},
        {id:11, img:'brace_white.png'},
        {id:12, img:'card_black.png'},
        {id:13, img:'card_blue.png'},
        {id:14, img:'card_green.png'},
        {id:15, img:'card_red.png'},
        {id:16, img:'card_white.png'},
        {id:17, img:'card_yellow.png'},
        {id:18, img:'key_black.png'},
        {id:19, img:'key_blue.png'},
        {id:20, img:'key_green.png'},
        {id:21, img:'key_red.png'},
        {id:22, img:'key_white.png'},
        {id:23, img:'key_yellow.png'},
        {id:24, img:'brace_yellow.png'},
      ];
      
      $scope.spots.wristbands = [0, 1, 4, 2, 3, 5, 6, 7, 8, 9, 10, 11, 24];
      $scope.spots.wristbands_current = $scope.spots.wristbands[$scope.getRandomInt(0, $scope.spots.wristbands.length - 1)];
      
      $scope.spots.cards = [12, 13, 14, 15, 16, 17];
      $scope.spots.cards_current  = 15;
      
      $scope.spots.keys = [18, 19, 20, 21, 22, 23];
      $scope.spots.keys_current  = 20;  
      
      $scope.spots.inited = true;
  
  }
  

  $scope.fadeTo = function(slider, ind) {
    if (slider.current == ind) return false;
    
    angular.element("#slider-" + slider.name + " .f-slide").stop();
    var id = "#" + slider.name + "_" + ind;
    if (!angular.element(id).length)
      return false;
    
    slider.current = ind;
    angular.element("#slider-" + slider.name + " .f-slide[id!=" +id +"]").fadeOut(0);
    angular.element(id).fadeIn($scope.FADE_SPEED);
    
    return true;
  };
  
  $scope.fadeToWistbrands = function() {
    if ($scope.fadeTo($scope.spots, $scope.spots.wristbands_current))
      $scope.spots.current_type = 'wristband';
  };
  
  $scope.fadeToCards = function() {
    if ($scope.fadeTo($scope.spots, $scope.spots.cards_current))
      $scope.spots.current_type = 'card';
  };
  
  $scope.fadeToKeys = function() {
    if ($scope.fadeTo($scope.spots, $scope.spots.keys_current))
      $scope.spots.current_type = 'key';
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