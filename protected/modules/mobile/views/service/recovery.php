<div id="main-container">
  <div class="grayAllBlock rad6 shadow">
    <?php if (Yii::app()->user->hasFlash('success')): ?>
      <div class="info">
        <?php echo Yii::app()->user->getFlash('success'); ?>
      </div>
    <?php else: ?>
      <?php echo CHtml::beginForm(); ?>
      <p>
        <?php echo Yii::t('mobile', 'Если Вы забыли свой пароль и хотите его восстановить,<br /> введите адрес электронной почты, который Вы использовали при регистрации.') ?>
      </p>
      <span class="error"><?php echo CHtml::errorSummary($form); ?></span>
      <table class="proc100">
        <tr>
          <td>
            <?php echo CHtml::activeTextField($form, 'email', array('class' => 'txt-100p rad6', 'placeholder' => Yii::t('mobile', 'Email'))) ?>
          </td>
        </tr>
      </table>
      <input type="submit" class="btn-round fright rad12 shadow" value="<?php echo Yii::t('mobile', 'Восстановить') ?>"/>
      <?php echo CHtml::endForm(); ?>
    <?php endif; ?>
  </div>
</div>