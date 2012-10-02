<div class="coupon_simple">
    <span class="upload-img active"><?php echo Yii::t('account', 'Загрузка картинки');?></span>
    <a href="<?php echo $data->discodes_id;?>" class="constr"
       id="desinger"><?php echo Yii::t('account', 'Конструктор');?></a>
    <br/>
    <br/>

    <p><?php echo Yii::t('account', 'Подгрузите сюда картинку с Вашим купоном (любой графический формат, объем - до 512 Кб),<br>
                и Ваш потенциальный покупатель получит его прямо в телефон. Не забудьте указать на купоне<br> сроки его
                действия и правила использования.');?></p>
    <br/>

    <div class="noUploadImg">
        <?php if (!empty($content->kupon_4)): ?>
        <img src="/uploads/spot/<?php echo $content->kupon_4?>" width="321px" alt="coupon"/>
        <span class="cancel"></span>
        <?php else: ?>
        <img src="/themes/mobispot/images/coupon_no_image.png" alt="coupon"/>
        <?php endif;?>
        <noscript>
            <p>Please enable JavaScript to use file uploader.</p>
        </noscript>
    </div>

    <div class="round-btn-new">
        <input type="submit" id="add_file_simple" value="<?php echo Yii::t('profile', 'Загрузить');?>"/>
    </div>
</div>