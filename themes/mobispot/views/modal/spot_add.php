<div id="spot_add_modal" class="reveal-modal medium">
<div class="cont-pop">
<a class="close-reveal-modal"><?php echo Yii::t('account', 'Закрыть')?></a>

<form name="addForm">
<p>
<?php echo Yii::t('account', 'Введите код спота')?>
</p>

<div class="row">
<div class="nine columns centered">
<input type="text" name="code"
autocomplete="off"
ng-model="code"
ng-minlength="10"
ng-maxlength="10"
ng-required="true"
/>
<?php
echo CHtml::dropDownList(
  'spot_type_id',
  '',
  Spot::getAllSpot(),
  array(
    'ng-required' => true,
    'ng-model' => 'type',
    'style' => 'width: 225px',
    'class' => 'spot_type',
  )
);
?>
</div>
</div>
<div class="row">
<div class="six columns centered">
<br />
<button class="m-button" ng-click="add()" ng-disabled="addForm.$invalid">
<?php echo Yii::t('account', 'Сохранить')?>
</button>
</div>
</div>
</form>
</div>
</div>
