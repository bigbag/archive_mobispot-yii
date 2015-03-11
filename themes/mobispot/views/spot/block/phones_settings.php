<h4>Смс информирование</h4>
<table class="wrapper-table">
<tr>
    <td class="left_list">
        <form name="new_phone_form" class="custom">
            <label for="new_phone_input"><?php echo Yii::t('spot', 'Введите номер телефона (10 цифр)');?></label>
            <input id="new_phone_input" ui-mask="+7(999)999 99 99" type="text" required ng-model="new_phone" name="new_phone"></input>
            <a class="form-button" ng-click="addPhone(new_phone, new_phone_form.$valid)"><?php echo Yii::t('spot', 'Добавить номер');?></a>
        </form>
        <table id="phones-list">
        <?php foreach($phones as $phone):?>
            <?php include(Yii::getPathOfAlias('webroot') . '/themes/mobispot/views/spot/block/phone.php'); ?>
        <?php endforeach;?>
        </table>
    </td>
    <td id="phone_services">
        <?php include(Yii::getPathOfAlias('webroot') . '/themes/mobispot/views/spot/block/school_extended.php'); ?>
    </td>
</tr>
</table>