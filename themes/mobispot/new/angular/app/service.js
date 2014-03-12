angular.module('mobispot').service('contentService', function() {
    var resultModal = angular.element('.m-result');
    var resultContent = resultModal.find('p');

    //Вызываем модальное окно
    this.setModal = function(content, type){
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

    var scroll_speed = 600;
    //Автоскролинг до нужного блока
    this.scrollPage = function(id, speed){
        speed = typeof speed !== 'undefined' ? speed : scroll_speed;
        var scroll_height = $(id).offset().top;
          $('html, body').animate({
            scrollTop: scroll_height
          }, speed);
      };
});
