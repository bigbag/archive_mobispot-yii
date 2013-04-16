var $body = $('body');
var $popup = $('.popup');
var $element = new Object();

var toggleOpen = function (element) {
  $(element).toggleClass('open');
};

var addActive = function () {
  $(this).addClass('active').siblings().removeClass('active');
};
var toggleActive = function () {
  $(this).toggleClass('active');
};

var showPopup = function(){
  $element.showPopupButton = $(this);
  var popupId =  'popup-' + $(this).attr('id');
  $popup.removeClass('hide').attr('id', popupId).animate({opacity: 1}, 50, function(){
    $body.addClass('overflow-h');
  });

};
var hidePopup = function(){
  if ($element.showPopupButton){
    $element.showPopupButton.removeClass('active');
    $popup.animate({opacity: 0}, 50, function(){
      $(this).addClass('hide');
      $body.removeClass('overflow-h');
    });
  }
};

$(window).load(function() {
  $(document).on('click','.add-active > *', addActive);
  $(document).on('click','.toggle-active > *', toggleActive);
  $(document).on('click','.store-items__close', function(){
    $(this).parents('tr').remove();
  });


  $('.spot-list').on('click','label', function(){
    $(this).prev().focus();
  });


  $('.settings-button').on('click', showPopup);
  $('.button', '.popup').on('click', hidePopup);

  $('.spot-list').on('click','.settings-button', showPopup);
  $('.spot-list').on('click','.button', hidePopup);
  $('.spot-list').on('click','.popup', hidePopup);

  $(document).keydown(function(e){
    if(e.which == 27){
      $popup.hasClass('hide')||hidePopup();
    }
  });

  var textArea = $('textarea');

  for(i=0; i<textArea.length; i++){
    if ( $(textArea[i]).val() ){
      $(textArea[i]).addClass('put')
    } else{
      $(textArea[i]).removeClass('put');
    }

  }
  $('.spot-list').on('input propertychange','textarea', function() {
    if($(this).val()){
      $(this).addClass('put');
    }else{
      $(this).removeClass('put');
    }

  });

  $(document).on('click', '.b-input-number span', function(e){
    var $numberInput = $(this).parent().find('input')
    var currentNumber = $numberInput.val();
      if($(this).hasClass('number-up')){
        !currentNumber?currentNumber = 1 : currentNumber++;
      } else{
        currentNumber < 1 ?currentNumber = 0 : currentNumber--;
      }
    $numberInput.val(currentNumber);
  });

});

