<div id="main-container">
  <div class="grayAllBlock rad6 shadow">
    <form action="" method="post">
      <table class="proc100">
        <tr>
          <td>
            <?php echo Yii::t('mobile', 'Для продолжения работы с сайтом вам необходимо ввести код изображенный на картинке.'); ?>
            <?php echo CHtml::errorSummary($form); ?>
          </td>
        </tr>
        <tr>
          <td>

            <?php
            $this->widget('CCaptcha', array(
                'clickableImage'=>true,
                'showRefreshButton'=>true,
                'buttonType'=>'button',
                'buttonOptions' =>
                array('type'=>'image',
                    'src'=>"/themes/mobispot/images/ico-refresh.png",
                    'width'=>21,
                ),
            ));
            ?>
          </td>
        </tr>
        <tr>
          <td>
            <div style="width: 200px; margin: 0 auto;">
              <input type="text" class="txt-100p rad6" value="" name="ErrorForm[verifyCode]"/>
            </div>
            <div style="display: none;">
              <input type="text" class="txt-100p rad6" value="" name="email"/>
            </div>
          </td>
        </tr>
      </table>
      <input type="submit" class="btn-round txtFCenter rad12 shadow"
             value="<?php echo Yii::t('mobile', 'Отправить'); ?>"/>
    </form>
  </div>
</div>