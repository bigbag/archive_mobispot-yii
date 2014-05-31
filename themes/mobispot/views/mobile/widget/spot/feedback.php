<div class="spot-item">
    <p class="item-area item-type__text">
        <?php echo (!empty($content->poyasneniya_9)) ? $content->poyasneniya_9 : ''; ?>
    </p>
    <?php if ($error): ?>
        <div class="spot-item">
            <p class="item-area item-type__text error">
                Необходимо заполнить все поля
            </p>
        </div>
    <?php endif; ?>
</div>
<?php echo CHtml::beginForm(); ?>
<div class="spot-item">
    <?php
    echo CHtml::activeTextField($feedback, 'name', array(
        'placeholder' => 'Имя',
        'style' => 'display:' . (($content->imya_9 == 1) ? 'block' : 'none'),
    ));
    ?>
    <?php
    echo CHtml::activeTextField($feedback, 'email', array(
        'placeholder' => Yii::t('mobile', 'Email'),
        'style' => 'display:' . (($content->email_9 == 1) ? 'block' : 'none'),
    ));
    ?>
    <?php
    echo CHtml::activeTextField($feedback, 'phone', array(
        'placeholder' => 'Телефон',
        'style' => 'display:' . (($content->telefon_9 == 1) ? 'block' : 'none'),
    ));
    ?>
    <?php
    echo CHtml::activeTextField($feedback, 'comment', array(
        'placeholder' => 'Комментарий',
        'style' => 'display:' . (($content->kommentariy_9 == 1) ? 'block' : 'none'),
    ));
    ?>
</div>
<ul class="item-footer">
    <li><input type="submit" class="spot-button active" value="Отправить"/></li>
    <li><a class="spot-button" href="http://mobispot.com"><span>Отмена</span></a></li>
</ul>
<?php echo CHtml::endForm(); ?>
