<article class="tab-transport">
    <div class="tabs-item">
        <h4><?php echo Yii::t('spot', 'Транспортная карта &laquo;Тройка&raquo;')?></h4>
            <ul>
                <?php if(!empty($troika) and !empty($troika['troika_id'])):?>
                    <li><?php echo Yii::t('spot', 'Номер карты:')?> <span class="number"><?php echo '0003 126 569' //echo $troika['troika_id']; ?></span></li>
                <?php endif; ?>
                <li><a class="pay" target="_blank" href="http://troika.mos.ru/about/pay/"><?php echo Yii::t('spot', 'Пополнить баланс')?></a></li>
                <li><a class="block" ng-click="$event.stopPropagation();blockTroika(spot)"><?php echo Yii::t('spot', 'Заблокировать карту')?></a></li>
                <li><span class="note"><?php echo Yii::t('spot', 'По вопросам функционирования карты:') ?><br>+7 495 933-5918 <?php echo Yii::t('spot', 'или'); ?>  <a href="mailto:helpme@mobispot.com">helpme@mobispot.com</a></span>
                </li>
            </ul>
    </div>
</article>
<div class="block-information">
    <i class="icon">&#xe606;</i>
    <?php if (isset($troika)):?>
        <?php echo SpotTroika::getStatusDescr($troika);?>
    <?php endif; ?>
</div>