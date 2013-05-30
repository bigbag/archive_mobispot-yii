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
  $('.default-avatar').width(aWidth+'px');
  $('.default-avatar').css('margin-right', (aMargin+'px'));
});