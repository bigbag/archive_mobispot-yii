'use strict';

angular.module('mobispot').service('contentService', function() {

    //Отображение модального окна
    this.desktopModal = function(action, speed){
      if (angular.isUndefined(speed)) speed = 500;

      angular.element('.lang-list').fadeOut();
      angular.element('.lang').removeClass('open');

      if (action == 'none') {
        $('.show-block.active').removeClass('active').fadeOut(speed);
        return false;
      }
      var modal = angular.element('#' + action);

      if($('.show-block').hasClass('active')){
        $('.show-block.active').removeClass('active').fadeOut(speed, function(){
          modal.fadeIn(speed).addClass('active');
        });
      } else  {
        modal.fadeIn(speed).addClass('active');
      }
    };

    this.mobileModal = function(content, type){
      var resultModal = angular.element('.m-result');
      var resultContent = resultModal.find('p');

      resultModal.removeClass('m-negative');
      if (type == 'error') {
          resultModal.addClass('m-negative');
      }
      resultModal.hide();
      resultModal.show();
      resultContent.text(content);
      setTimeout(function(){
        resultModal.hide();
      }, 5000);
    };

    //Автоскролинг до нужного блока
    this.scrollPage = function(id, speed){
      if (angular.isUndefined(speed)) speed = 600;
      var scroll_height = $(id).offset().top;
        $('html, body').animate({
          scrollTop: scroll_height
        }, speed);
    };
});
