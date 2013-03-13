<div class="text-center">
<?php $this->widget('CCaptcha', array(
    'clickableImage' => true,
    'showRefreshButton' => false,
));?>
</div>
<input name='code' type="text" ng-model="user.code" placeholder="<?php echo Yii::t('sign', 'Verification code');?>" required >
{{user.code}}
<script type="text/javascript">
/*<![CDATA[*/
    jQuery(function ($) {
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