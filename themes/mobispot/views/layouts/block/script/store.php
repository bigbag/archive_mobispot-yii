    <script src="/themes/mobispot/js/jquery-ui.min.js"></script>

    <script>angular.module('mobispot', []);</script>
    <script src="/themes/mobispot/angular/app/service.js"></script>
    <script src="/themes/mobispot/angular/app/controllers/user.js"></script>
    <script src="/themes/mobispot/angular/app/controllers/store.js"></script>

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
