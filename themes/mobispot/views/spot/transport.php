<div class="spot-content" ng-init="spot.status=<?php echo $spot->status; ?>">
    <section class="spot-wrapper active">
        <div class="spot-hat">
            <?php include('block/menu.php'); ?>
        </div>
        <div class="tabs-block">
            <section id="blockTroika" 
                class="transport-block spot-content_row tabs-item<?php echo (empty($troika) or !SpotTroika::isActive($troika))?' ' . 'disabled':''; ?>">
                <div class="item-area w-bg clearfix"> 
                    <h4>Транспортная карта &laquo;Тройка&raquo;</h4>
                    <div class="card-img">
                        <img src="/themes/mobispot/img/troika.png">
                    </div>
                    <div class="card-info">
                        <ul>
                            <?php if(!empty($troika) and !empty($troika['troika_id'])):?>
                                <li><?php echo Yii::t('spot', 'Номер карты:')?> <span class="number"><?php echo $troika['troika_id']; ?></span></li>
                            <?php endif; ?>
                            <li><a class="pay" target="_blank" href="http://troika.mos.ru/about/pay/"><?php echo Yii::t('spot', 'Пополнить баланс')?></a></li>
                            <li><a class="block" ng-click="$event.stopPropagation();blockTroika(spot)"><?php echo Yii::t('spot', 'Заблокировать карту')?></a></li>
                            <li><span class="note"><?php echo Yii::t('spot', 'По вопросам функционирования карты:') ?><br>+7 495 933-5918 <?php echo Yii::t('spot', 'или'); ?>  <a href="mailto:helpme@mobispot.com">helpme@mobispot.com</a></span>
                            </li>
                        </ul>
                    </div>
                    <div class="block-information">
                        <i class="icon">&#xe606;</i><?php echo Yii::t('spot', 'Карта заблокирована')?>
                    </div>
                </div>
                <div class="cover"></div>
            </section>
        </div>
    </section>
</div>
