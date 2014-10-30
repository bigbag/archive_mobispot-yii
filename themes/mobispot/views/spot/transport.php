<div class="spot-content" ng-init="spot.status=<?php echo $spot->status; ?>">
    <section class="spot-wrapper active">
        <div class="spot-hat">
            <?php include('block/menu.php'); ?>
        </div>
        <div class="tabs-block">
            <section class="transport-block spot-content_row tabs-item">
            <div class="item-area w-bg clearfix"> 
                <h4>"Московская транспортная карта "Тройка" 
                    <a class="spot-button_block" href="javascript:;">
                                        <span class="block"><i class="icon">&#xe606;</i>block card</span>
                                    </a>
                    </h4>
                    <div class="card-img">
                        <img src="/uploads/transport/troika.jpg">
                        <a href="javascript:;" ng-click="showCustomCard()"><?php echo Yii::t('spot', 'Создать свой макет карты')?></a>
                    </div>
                    <div class="card-info">
                            <ul>
                                <li><?php echo Yii::t('spot', 'Дата активации:')?> <span></span></li>
                            
                                <li><?php echo Yii::t('spot', 'Номер карты:')?>  <span></span> </li>
                            </ul>
                            <div class="balance">
                                <?php echo Yii::t('spot', 'Баланс:');?> <b></b>
                            </div>
                            <a href="javascript:;" class="form-button"><?php echo Yii::t('spot', 'Пополнить:');?></a>
                    </div>
                    <footer>
                        <?php echo Yii::t('spot', 'По вопросам функционирования карты:')?> 
                        +7 495 933-5918 <?php echo Yii::t('spot', 'или'); ?>  <a href="mailto:helpme@mobispot.com">helpme@mobispot.com</a>
                        <br>
                        <?php echo Yii::t('spot', 'По транспортным вопросам:'); ?> +7 495 539-5454
                    </footer>
                </div>
            </section>
        </div>
    </section>
</div>
