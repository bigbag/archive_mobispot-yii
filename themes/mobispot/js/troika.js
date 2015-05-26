function windowSize(){
        var winHeight = $(window).height();
        var winWidth = $(window).width();
        
        if(winHeight > 680){
            $('#business-info').css('height', winHeight);
        }
        
        if (winWidth < 1400) {
            $('.first-screen .content h1').css('font-size', '4rem');
        } else {
            $('.first-screen .content h1').css('font-size', '4.3rem');   
        }
}

function scrollTo(selector, speed, new_hash){
    var $target = $(selector);
    $('html, body').stop().animate({
        'scrollTop': $target.offset().top
    }, speed, 'swing'/*, function () {
        window.location.hash = new_hash;
    }*/);
}

$(window).on('load resize', windowSize);

$(window).on('load', function(){
    if ('#business'==window.location.hash) {
        $('#business-info').show();
    }
});

$('a[href^="#"]').on('click',function (e) {
    e.preventDefault();
    var target = this.hash;

    if ($(this).hasClass('tobusiness')) {
        speed = 1500;
        if ($(this).hasClass('faster'))
            speed = 800;
        $('#business-info').show();
        setTimeout(function(){
            scrollTo(target, speed, target);
        }, 300);
        return true;
    }
    
    scrollTo(target, 600, target);
});