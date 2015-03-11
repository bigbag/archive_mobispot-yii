<?php if(empty($school_extended_address)):?>
<form name="school_extended_form" class="custom">
    <label>Сервисы информирования</label>
    <h5><?php echo Yii::t('spot', 'Школьная продленка');?></h5>
    <input id="new_phone_input" type="text" required ng-model="home_address" name="home_address" placeholder="Домашний адрес"></input>
    <a class="form-button" ng-click="activateSchoolExtended(home_address, school_extended_form.$valid)"><?php echo Yii::t('spot', 'Активировать');?></a>
</form>
<?php else:?>
<form name="school_extended_form" class="custom">
    <label>Сервисы информирования</label>
    <h5><img src="/themes/mobispot/img/icons/checked.png"> <?php echo Yii::t('spot', 'Школьная продленка');?></h5>
    <span><?php echo Yii::t('spot', 'Адрес:');?><?php echo $school_extended_address;?></span><br>
    <a class="service-ctrl" ng-click="removeSchoolExtended()"><span class="ctrl-icon">&#xe00b;</span> <?php echo Yii::t('spot', 'Удалить');?></a>
</form>
<?php endif;?>