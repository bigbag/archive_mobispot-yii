<div class="spot-item">
    <p class="item-area item-type__text">
        <?php echo Yii::t('user', 'Для продолжения работы с сайтом вам необходимо ввести код изображенный на картинке.'); ?>
        <?php echo CHtml::errorSummary($form); ?>
    </p>
</div>
<div class="spot-item__pack">
    <p class="text-center">
        <?php
        $this->widget('CCaptcha', array(
            'clickableImage' => true,
            'showRefreshButton' => false,
        ));
        ?>
    </p>
</div>

<?php echo CHtml::beginForm(); ?>
<div class="spot-item">
    <input type="text" value="" name="ErrorForm[verifyCode]"/>
    <div style="display: none;">
        <input type="text" class="txt-100p rad6" value="" name="email"/>
    </div>
</div>

<ul class="item-footer">
    <li><input type="submit" class="spot-button active" value="Отправить"/></li>
</ul>
<?php echo CHtml::endForm(); ?>
