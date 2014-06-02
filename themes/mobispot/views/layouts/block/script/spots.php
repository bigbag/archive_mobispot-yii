<script src="/themes/mobispot/js/jquery-ui.min.js"></script>
<script src="/themes/mobispot/js/slide-box.min.js"></script>
<script src="/themes/mobispot/js/jquery.autosize-min.js"></script>
<script src="/themes/mobispot/js/jquery.animate-enhanced.min.js"></script>
<!--[if lt IE 9]>
    <script src="/themes/mobispot/js/jquery.placeholder.js"></script>

    <script>
        $(function () {
            $('input, textarea').placeholder();
        });
    </script>

<![endif]-->

<script src="/themes/mobispot/js/angular-cookies.min.js"></script>
<script src="/themes/mobispot/angular/modules/sortable/src/sortable.js"></script>
<script src="/themes/mobispot/angular/app/app.js"></script>
<script src="/themes/mobispot/angular/app/service.js"></script>
<script src="/themes/mobispot/angular/app/controllers/user.js"></script>
<script src="/themes/mobispot/angular/app/controllers/spot.js"></script>
<?php echo $this->blockFooterScript; ?>
<script src="/themes/mobispot/js/script-add.js"></script>
<script src="/themes/mobispot/js/script.js"></script>
<script src="/themes/mobispot/js/foundation.min.js"></script>
<script>
    $(document).foundation();
    $(window).load(function () {
        $('textarea').autosize();
    });
</script>
