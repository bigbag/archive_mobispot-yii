var aSpeed = 500;


var closeShowBlock = function(){
	$('.show.active').removeClass('active');
	$('.show-block.active').removeClass('active').fadeOut(aSpeed);
};

var closeLang = function(){
	$('.lang-list').fadeOut();
	$('.lang').removeClass('open');
};


$(function()	{
	$(document).keydown(function(e){
		if(e.which === 27){
			closeShowBlock();
			closeLang();
		}
	});

	$(document).on('click', closeShowBlock);
	$(document).on('click','.header-page', function(event){
		event.stopPropagation();
		closeLang();
	});

	$('.show').click(function(){
		var blockID = $(this).attr('href');

		if(!$(this).hasClass('active')){
			$('.show.active').removeClass('active');
			$(this).addClass('active');
			if($('.show-block').hasClass('active')){
				$('.show-block.active').removeClass('active').fadeOut(aSpeed, function(){
					$(blockID).fadeIn(aSpeed).addClass('active');
				});
			}	else	{
				$(blockID).fadeIn(aSpeed).addClass('active');
			}
		}	else	{
			closeShowBlock();
		}
		closeLang();
		return false;
	});

	$(document).on('textchange','.wrapper.help input', function(){
		$(this).next('.f-hint').fadeOut(aSpeed);
	});

	$(document).on('click', '.lang .current', function(){
		if($(this).parent('.lang').hasClass('open')){
			closeLang();
		} else {
			closeShowBlock();
			$(this).parent('.lang').addClass('open');
			$('.lang-list').fadeIn();
		}
	});

		$(document).on('click', function(){
			closeLang();
		});
		$(document).on('click','.lang', function(event){
			event.stopPropagation();
		});

	$(document).on('click','.lang-list li', function(){
		var $that = $(this);
		$('.lang-list').fadeOut(function(){
			$that.addClass('current-lang').siblings().removeClass();
			var curLangImg = $that.find('img').clone();
			$('.current','.lang').html(curLangImg);
			$('.lang').removeClass('open');
		});
	});
});