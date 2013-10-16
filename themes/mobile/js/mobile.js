$(document).ready(function(){
  var maxWidth = 52;
  var minWidth = 30;
  var maxMargin = 14;
  var minMargin = 0;
  
  var aWidth = screen.width*0.1;
  if(aWidth > maxWidth)
    aWidth = maxWidth;
  else if(aWidth < minWidth)
    aWidth = minWidth;
  var aMargin = (aWidth-25)/1.9;
  if(aMargin > maxMargin)
    aMargin = maxMargin;
  else if(aMargin < minMargin)
    aMargin = minMargin;
  aWidth = Math.round(aWidth);
  aMargin = Math.round(aMargin);
  $('.user-avatar').width(aWidth+'px');
  $('.user-avatar').css('margin-right', (aMargin+'px'));
});


$(function() {
    $('a','.spot-password').click(function(){
        if ($('#passForm input[name=pass]').hasClass('error')){
            $('#passForm input[name=pass]').val('');
            $('#passForm input[name=pass]').removeClass('error');
        }
        var valueButon = $(this).html();
        var valueInput = $('#passForm input[name=pass]').val();
        if (valueInput.length < 4){
            $('#passForm input[name=pass]').val(valueInput + valueButon);
            if (3 == valueInput.length){
                $('#passForm input[name=pass]').removeAttr('disabled');
                $('#passForm').submit();
            }
        }
    });
    $('.backspace','.spot-password').click(function(){
        if ($('#passForm input[name=pass]').hasClass('error')){
            $('#passForm input[name=pass]').val('');
            $('#passForm input[name=pass]').removeClass('error');
        }
        else
        {
            var valueInput = $('#passForm input[name=pass]').val();
            $('#passForm input[name=pass]').val(valueInput.substring(0, valueInput.length - 1));
        }
    });
});