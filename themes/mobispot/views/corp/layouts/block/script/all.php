
<!-- Foundation 3 for IE 8 and earlier -->
<!--[if lt IE 9]>
  <script src="/themes/mobispot/js/foundation3/app.js"></script>
  <script type="text/javascript">
    $(function() {
        $('input, textarea').placeholder();
    });
  </script>
<![endif]-->

<!-- Foundation 4 for IE 9 and later -->
<!--[if gt IE 8]><!-->
  <script src="/themes/mobispot/js/foundation4/foundation.min.js"></script>
  <script>
    $(document).foundation();
  </script>
<!--<![endif]-->

<script src="/themes/mobispot/js/slide-box.min.js"></script>
<script src="/themes/mobispot/js/script.js"></script>

<script src="/themes/mobispot/angular/app/app.js"></script>
<script src="/themes/mobispot/angular/app/services.js"></script>
<script src="/themes/mobispot/angular/app/controllers/help.js"></script>
<script src="/themes/mobispot/angular/app/controllers/user.js"></script>
<script src="/themes/mobispot/angular/app/controllers/payment.js"></script>


<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-33307941-1']);
  _gaq.push(['_setDomainName', 'mobispot.com']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>
