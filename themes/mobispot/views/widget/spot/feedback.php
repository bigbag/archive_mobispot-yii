<p>
    <?php echo Yii::t('account', 'Используйте этот спот, чтобы получить жалобу, вопрос или похвалу от
    Вашего клиента. <br />Отметьте ниже, какие поля ему нужно заполнить, а также
    поясните, зачем Вы собираете эту информацию.<br />');?>
</p>
<div class="row">
    <div class="twelve columns">
        <?php echo CHtml::activeTextField($content, 'poyasneniya_9',
            array(
                'placeholder' => Yii::t('account', 'Введите здесь поясняющий текст к Вашему споту'),
        )); ?>
    </div>
</div>
<div class="row">
    <div class="four columns">
        <?php echo Yii::t('account', 'Имя');?><br/><br/><br/>
    </div>
    <div class="eight columns">
        <?php echo CHtml::activeCheckBox($content, 'imya_9'); ?>
    </div>
</div>
<div class="row">
    <div class="four columns">
        <?php echo Yii::t('account', 'Телефон');?><br/><br/><br/>
    </div>
    <div class="eight columns">
        <?php echo CHtml::activeCheckBox($content, 'telefon_9'); ?>
    </div>
</div>
<div class="row">
    <div class="four columns">
        <?php echo Yii::t('account', 'Электронная почта');?><br/><br/><br/>
    </div>
    <div class="eight columns">
        <?php echo CHtml::activeCheckBox($content, 'email_9'); ?>
    </div>
</div>
<div class="row">
    <div class="four columns">
        <?php echo Yii::t('account', 'Комментарий');?><br/><br/>
    </div>
    <div class="eight columns">
        <?php echo CHtml::activeCheckBox($content, 'kommentariy_9'); ?>
    </div>
</div>

<button class="m-button">
    <?php echo Yii::t('account', 'Смотреть отзывы к этому споту');?>
</button>

<script type="text/javascript">
            $(document).ready(function () {
                $('#feedback_content').click(function () {
                    if (id) {
                        $.ajax({
                            url:'/ajax/spotFeedbackContent',
                            type:'POST',
                            data:{discodes_id:id},
                            success:function (result) {
                                $('#spot_content_' + id).html(result);
                            }
                        });
                    }
                    return false;
                });
            });
</script>