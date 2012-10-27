<p>
    <?php echo Yii::t('account', ' Разместите здесь ссылку на веб-страницу,<br/>которую Вы хотите показать
    кому-нибудь при помощи своего спота');?>
</p>
<div class="row">
    <div class="two mobile-one columns">
        <label class="left inline"><?php echo Yii::t('account', 'Название ссылки');?></label>
    </div>
    <div class="ten mobile-three columns">
        <input type="text"
            ng-model="eSpot.nazvanie_5"
            name="nazvanie_5"
            value="<?php echo ($content['nazvanie_5'])?$content['nazvanie_5']:''?>"
            ng-minlength="3"
            class="five"/>
    </div>
</div>
<div class="row">
    <div class="two mobile-one columns">
        <label class="left inline"><?php echo Yii::t('account', 'Веб адрес');?></label>
    </div>
    <div class="ten mobile-three columns">
            <input type="url"
            ng-model="eSpot.adres_5"
            name="adres_5"
            value="<?php echo ($content['adres_5'])?$content['adres_5']:''?>"
            class="five"/>
    </div>
</div>