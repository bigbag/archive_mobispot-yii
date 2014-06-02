    <script src="/themes/mobispot/js/jquery-ui.min.js"></script>

    <script src="/themes/mobispot/js/angular-cookies.min.js"></script>
    <script src="/themes/mobispot/angular/modules/sortable/src/sortable.js"></script>
    <script src="/themes/mobispot/angular/app/app.js"></script>
    <script src="/themes/mobispot/angular/app/service.js"></script>
    <script src="/themes/mobispot/angular/app/controllers/user.js"></script>

    <?php echo $this->blockFooterScript; ?>
    <script src="/themes/mobispot/js/script-add.js"></script>
    <script src="/themes/mobispot/js/script.js"></script>
    <script src="/themes/mobispot/js/foundation.min.js"></script>
    <script>
        $(document).foundation();
        $(function () {
            var w = window.innerWidth;
            var h = window.innerHeight;
            $('#slides').slidesjs({
                width: w,
                height: h,
                min_width: 950,
                min_height: 560,
                play: {
                    active: true,
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
    </script>
