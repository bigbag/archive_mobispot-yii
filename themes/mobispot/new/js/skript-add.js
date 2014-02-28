$(function() {
    var w = window.innerWidth;
    var h = window.innerHeight;
    $('#slides').slidesjs({
        width: w,
        height: h,
        min_width: 950,
        min_height: 560,
        play: {
            active: true,
            swap: true,
            interval: 10000,
            auto: true,
            restartDelay: 2500
        },
        effect: {
            slide: {
                speed: 1300
            },
        },
    });
});

startSlide = function(){
   $('.slidesjs-start').click();
}

stopSlide = function(){
   $('.slidesjs-stop').click();
}

prevSlide = function(){
   $('.slidesjs-previous').click();
}

nextSlide = function(){
   $('.slidesjs-next').click();
}

$(document).on('keyup', function(e) {
    if (e.keyCode === 37) prevSlide();
    if (e.keyCode === 39) nextSlide();
});

var _gaq = _gaq || [];
_gaq.push(['_setAccount', 'UA-33307941-1']);
_gaq.push(['_setDomainName', 'mobispot.com']);
_gaq.push(['_trackPageview']);

(function() {
    var ga = document.createElement('script');
    ga.type = 'text/javascript';
    ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(ga, s);
})();