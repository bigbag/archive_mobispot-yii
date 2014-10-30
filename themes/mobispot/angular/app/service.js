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

      if($('.show-block').hasClass('active')  && ($('.show-block.active').attr('id') != action)){
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
    
    this.messageModal = function(message, host_type){
      speed = 500;
      if (host_type === 'mobile') {
          this.mobileModal(message, 'none');
      } else {
        angular.element('.lang-list').fadeOut();
        angular.element('.lang').removeClass('open');
      
        var modal = angular.element('#message');
        var content = angular.element('#message p');
      
        if($('.show-block').hasClass('active')){
          $('.show-block.active').removeClass('active').fadeOut(speed, function(){
            content.html(message);
            modal.fadeIn(speed).addClass('active');
          });
        } else  {
          content.html(message);
          modal.fadeIn(speed).addClass('active');
        }    
      }
    }
    
    //Автоскролинг до нужного блока
    this.scrollPage = function(id, speed){
      if (angular.isUndefined(speed)) speed = 600;
      var scroll_height = $(id).offset().top;
        $('html, body').animate({
          scrollTop: scroll_height
        }, speed);
    };
    
    var current_spot = {};
    
    this.setSpot = function(spot) {
        current_spot = spot;
    }
    
    this.getSpot = function() {
        return current_spot;
    }
    
});

angular.module('mobispot').service('dialogService', function() {
    
    var yesNoDialog = function(callback, textYes, textNo, message, dialog_class) {
      speed = 500;

      angular.element('.lang-list').fadeOut();
      angular.element('.lang').removeClass('open');
    
      var modal = angular.element('#b-dialog');
      var content = angular.element('#b-dialog p');
      var btnYes = angular.element('#b-dialog .yes-button');
      var btnNo = angular.element('#b-dialog .no-button');
      
      if($('.show-block').hasClass('active'))
        $('.show-block.active').removeClass('active').fadeOut(0);
      
      content.html(message);
      btnYes.text(textYes);
      btnNo.text(textNo);
      modal.removeClass('alert');
      modal.removeClass('negative');
      if (typeof dialog_class !== 'undefined')
        modal.addClass(dialog_class);
      modal.fadeIn(speed).addClass('active');
      
      btnYes.bind("click", cbYes);   
      btnNo.bind("click", cbNo);
      $(document).bind("click", cbNo);
      
      function cbYes() {
        callback('yes');
        closeDialog();
      }
      
      function cbNo() {
        callback('no');
        closeDialog();
      }
      
      function closeDialog() {
        btnYes.unbind("click", cbYes);  
        btnNo.unbind("click", cbNo);
        $(document).unbind("click", cbNo);
        
        modal.removeClass('active').fadeOut(speed);      
      }

    };

    return {
      yesNoDialog: yesNoDialog
    };

});