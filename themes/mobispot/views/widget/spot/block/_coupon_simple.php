<div class="coupon-simple">
<div class="row">
<div class="twelve columns">
<span class="upload-img active"><?php echo Yii::t('account', 'Загрузка картинки');?></span>
<span class="constr">
<?php echo Yii::t('account', 'Конструктор');?>
</span>
</div>
</div>
<div class="row">
<div class="twelve columns">
<p><?php echo Yii::t('account', 'Подгрузите сюда картинку с Вашим купоном (любой графический формат, объем - до 512 Кб),<br>
                и Ваш потенциальный покупатель получит его прямо в телефон. Не забудьте указать на купоне<br> сроки его
действия и правила использования.');?></p>

<div class="image">
<?php if (!empty($content->kupon_4)): ?>
<img src="/uploads/spot/<?php echo $content->kupon_4?>" width="321px" alt="coupon"/><i class="icon-large icon-remove-sign"></i>
<?php else: ?>
<img src="/themes/mobispot/images/coupon_no_image.png" width="321px" alt="coupon"/>
<?php endif;?>
<noscript>
<p>Please enable JavaScript to use file uploader.</p>
</noscript>
</div>

<div class="upload">
<br />
<span id="add-file" class="m-button"><i class="icon-circle-arrow-up"></i>&nbsp;<?php echo Yii::t('profile', 'Загрузить');?></span>

</div>
</div>
</div>
</div>