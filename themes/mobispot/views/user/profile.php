<div class="page">
<div class="title"><?php echo Yii::t('profile', 'Личные данные');?></div>
<?php echo CHtml::beginForm('', 'post'); ?>
<div class="profile">
<div class="row">
<div class="four columns sidebar">
<div class="sidebar-content">
<div class="photo">
<?php if (!empty($profile->photo)): ?>
<img src="/uploads/images/<?php echo $profile->photo?>" width="200px" alt="personal"/>
<?php else: ?>
<img src="/themes/mobispot/images/personal_no_photo.jpg" alt="personal"/>
<?php endif;?>
<noscript>
<p>Please enable JavaScript to use file uploader.</p>
</noscript>
</div>
<br />
<div class="send">
<button class="m-button add_photo">
<i class="icon-upload"></i>&nbsp;<?php echo Yii::t('profile', 'Загрузить');?>
</button>
</div>
<br />
<div>
<?php echo CHtml::activeCheckBox($profile, 'use_photo', array('class'=>'niceCheck')); ?>
<span class="dop-txt">
<?php echo Yii::t('profile', 'Использовать фото<br/>в моих личных спотах');?>
</span>
</div>
<br />
<div class="soc">
<button class="secondary small m-button">
<i class="icon-facebook"></i>&nbsp;&nbsp;<?php echo Yii::t('profile', 'Connect with Facebook');?>
</button>
<br />
<br />
<button class="secondary small m-button">
<i class="icon-twitter"></i>&nbsp;&nbsp;<?php echo Yii::t('profile', 'Connect with Twitter');?>
</button>
</div>
</div>
</div>
<div class="seven columns">
<div class="body">
<div class="row name">
<div class="four columns">
<label class="left inline"><?php echo Yii::t('profile', 'Имя');?></label>
</div>
<div class="eight columns">
<?php echo CHtml::activeTextField($profile, 'name', array('class'=>'nine' )); ?>
</div>
</div>
<div class="row">
<div class="four columns">
<label class="left inline"><?php echo Yii::t('profile', 'Дата рождения');?></label>
</div>
<div class="row">
<div class="six columns">
<div class="three columns birthday">
<select name="UserProfile[birthday_day]">
<option></option>
<?php for ($i=1; $i <= 31; $i++): ?>
<?php if (!empty($profile->birthday_day) and $i==$profile->birthday_day): ?>
<option value="<?php echo $i?>" selected><?php echo $i?></option>
<?php else: ?>
<option value="<?php echo $i?>"><?php echo $i?></option>
<?php endif; ?>
<?php endfor;?>
</select>
</div>

<div class="five columns" />
<select name="UserProfile[birthday_month]">
<option></option>
<?php foreach (MDate::month() as $key=>$value): ?>
<?php if (!empty($profile->birthday_month) and $key==$profile->birthday_month): ?>
<option value="<?php echo $key?>" selected><?php echo $value?></option>
<?php else: ?>
<option value="<?php echo $key?>"><?php echo $value?></option>
<?php endif; ?>
<?php endforeach;?>
</select>
</div>
<div class="four columns">
<select name="UserProfile[birthday_year]">
<option></option>
<?php for ($i=date("Y") - 100; $i <= date("Y"); $i++): ?>
<?php if (!empty($profile->birthday_year) and $i==$profile->birthday_year): ?>
<option value="<?php echo $i?>" selected><?php echo $i?></option>
<?php else: ?>
<option value="<?php echo $i?>"><?php echo $i?></option>
<?php endif; ?>
<?php endfor;?>
</select>
</div>
</div>
</div>
</div>
<div class="row">
<div class="four columns">
<label class="left inline"><?php echo Yii::t('profile', 'Город');?></label>
</div>
<div class="eight columns">
<?php echo CHtml::activeTextField($profile, 'place', array('class'=>'nine' )); ?>
</div>
</div>
<div class="row">
<div class="four columns">
<label class="left inline"><?php echo Yii::t('profile', 'Пол');?></label>
</div>
<div class="eight columns sex">
<input type="hidden" value="0" name="UserProfile[sex]" />

<input value="1" type="checkbox" name="UserProfile[sex]" <?php echo ($profile->sex==1)?"checked":""?>/>&nbsp;
<?php echo Yii::t('profile', 'Male');?>&nbsp;&nbsp;
<input value="2" type="checkbox" name="UserProfile[sex]" <?php echo ($profile->sex==2)?"checked":""?>/>&nbsp;
<?php echo Yii::t('profile', 'Female');?>
</div>
</div>
</div>
</div>
</div>

<div class="save">
<input type="submit" class="m-button" value="<?php echo Yii::t('profile', 'Сохранить');?>"/>
</div>

</div>
<?php echo CHtml::endForm(); ?>
</div>

<script type="text/javascript">
$(function () {
    $(".add_photo").uploadifive({
        'width':'120px',
        'height':'28px',
        uploadScript:'/site/upload/',
        'formData':{'action':'personal', 'user_id':<?php echo Yii::app()->user->id;?>},
        'removeTimeout':10,
        'multi':false,
        'buttonClass':'m-button',
        'buttonText':'<i class="icon-upload"></i>&nbsp;<?php echo Yii::t('profile', 'Загрузить');?>',
        
        'onError':function (errorType) {
          $('#messages_modal div.messages').html('The file could not be uploaded: ' + errorType);
          $('#messages_modal').reveal({animation:'none'});
        },
        'onUploadComplete':function (file, data, response) {
          var obj=jQuery.parseJSON(data);
          var file_name=obj.file;
          var error=obj.error;
          if (file_name) {
            $('.photo').html('<img src="/uploads/images/' + file_name + '" width="200px"/>');
            $('#photo').hide();
          }
          if (error) alert(error);
        }
    });
});
</script>
