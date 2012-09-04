
    <?php $this->widget('CCaptcha', array(
    'clickableImage' => true,
    'showRefreshButton' => true,
    'buttonType' => 'button',
    'buttonOptions' =>
    array('type' => 'image',
        'src' => "/themes/mobispot/images/ico-refresh.png",
        'width' => 21,
    ),
));?>
    <script type="text/javascript">
        /*<![CDATA[*/
        jQuery(function ($) {
            jQuery('#yw0').after("<input type=\"image\" src=\"\/themes\/mobispot\/images\/ico-refresh.png\" width=\"21\" id=\"yw0_button\" name=\"yt0\" value=\"\u041f\u043e\u043b\u0443\u0447\u0438\u0442\u044c \u043d\u043e\u0432\u044b\u0439 \u043a\u043e\u0434\" \/>");
            $(document).on('click', '#yw0_button, #yw0', function () {
                $.ajax({
                    url:"\/site\/captcha?refresh=1",
                    dataType:'json',
                    cache:false,
                    success:function (data) {
                        $('#yw0').attr('src', data['url']);
                        $('body').data('captcha.hash', [data['hash1'], data['hash2']]);
                    }
                });
                return false;
            });

        });
        /*]]>*/
    </script>