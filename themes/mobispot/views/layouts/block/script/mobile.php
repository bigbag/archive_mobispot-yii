    <script src="/themes/mobispot/js/jquery-ui.min.js"></script>

    <script src="/themes/mobispot/angular/modules/autofill-event.js"></script>
    <script src="/themes/mobispot/angular/app.min.js"></script>

    <script type="text/javascript">
    function getRandomInt(e,t){return Math.floor(Math.random()*(t-e+1))+e}var hideMenu=function(){$(".showMenu").removeClass("showMenu")};$(document).ready(function(){var e="url(/themes/mobispot/images/bg-main/bg_"+getRandomInt(1,4)+".jpg)";$("body").css("background-image",e);$(document).on("click",".tabs nav a",function(){if(!$(this).hasClass("active")){$("*",".tabs").removeClass("active");$(this).addClass("active");var e=$(this).index(),t=$(".tabs-content > article");$(t[e]).addClass("active")}});$(document).on("click","#show-menu",function(){$(".wrapper").addClass("showMenu")});$(document).on("click",".showMenu",hideMenu);$(document).on("click",".main-back",hideMenu);$(document).on("click","#menu",function(e){e.stopPropagation()});$(document).on("click",".make-main",function(){$("tr",".card-list").removeClass("main-card");$(this).parents("tr").addClass("main-card")});$(document).on("click",".block-wallet",function(){$(".card").toggleClass("blocked")})});</script>

    <?php echo $this->blockFooterScript; ?>
    <script src="/themes/mobispot/js/script.min.js"></script>
    <script src="/themes/mobispot/js/foundation.min.js"></script>
