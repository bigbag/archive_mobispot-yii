'use strict';
function getRandomInt(min, max){
    return Math.floor(Math.random() * (max - min + 1)) + min;
}

var hideMenu = function (){
        $('.showMenu').removeClass('showMenu');
};

$(document).ready( function(){
    $(document).on('click', '.tabs nav a', function(){
        if(!$(this).hasClass('active')){

            $('*','.tabs').removeClass('active');

            $(this).addClass('active');
            var tabIndex = $(this).index();

            var tabContent = $('.tabs-content > article');

            $(tabContent[tabIndex]).addClass('active');

        }
    });
    $(document).on('click', '#show-menu', function(){
        $('.wrapper').addClass('showMenu');
    });
    $(document).on('click','.showMenu',hideMenu);
    $(document).on('click','.main-back',hideMenu);
    $(document).on('click','#menu', function(event){
        event.stopPropagation();
    });
    $(document).on('click', '.make-main', function(){
        $('tr','.card-list').removeClass('main-card');
        $(this).parents('tr').addClass('main-card');
    });

    $(document).on('click', '.block-wallet', function(){
        $('.card').toggleClass('blocked');
    });

});