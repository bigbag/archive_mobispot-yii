<div id="main-container">
    <div id="userContact" class="clr">
        <span class="btn-dig rad6 shadow">
            <span class="txtFCenter"><?php echo $content['nazvanie-biznesa_8']; ?>
            </span>
        </span>
        <a href="<?php echo YText::formatUrl($content['sayt_8'])?>" class="btn-dig rad6 shadow">
            <span class="txtFCenter"><?php echo $content['sayt_8']; ?></span>
        </a>
        <span class="btn-dig rad6 shadow"><?php echo $content['kontaktnoe-litso_8']; ?>
        </span>
    </div>
    <div class="grayAllBlock rad6 shadow">
        <div class="grayHead radTop6"><?php echo Yii::t('mobile', 'Интересные предложение');?></div>
        <?php if (!empty($content->nazvanie_8)): ?>
        <?php $i = 0; ?>
        <?php foreach ($content->nazvanie_8 as $name): ?>
            <?php $link = $content->ssyilka_8; ?>
            <?php $file = $content->kartinka_8; ?>

            <img src="/uploads/spot/<?php echo $file[$i] ?>" class="fleft" alt="" width="400px"/>
            <div class="infoViz proc100 clr txtFLeft">
                <p><a href="<?php echo YText::formatUrl($link[$i])?>"> <?php echo $link[$i]; ?>2</a></p>

                <p><?php echo $name; ?></p>
            </div>

            <?php $i = $i + 1; ?>
            <?php endforeach; ?>
        <?php endif;?>

    </div>
    <div class="grayAllBlock rad6 shadow">
        <div class="grayHead radTop6"><?php echo Yii::t('mobile', 'Ближайшие точки прода');?></div>
        <div class="infoViz proc100 clr txtFLeft">

            <?php if (count($content['tochka-nazvanie_8']) > 0): ?>
            <?php $i = 0; ?>
            <?php foreach ($content['tochka-nazvanie_8'] as $name): ?>
                <?php if (isset($name[1])): ?>
                    <?php $karta = $content['tochka-karta_8']; ?>
                    <p><?php echo $name;?></p>
                    <p><a href="<?php echo YText::formatUrl($karta[$i])?>"
                          class="btn-cent ico rad4 shadow txtFLeft"><span></span><?php echo Yii::t('account', 'На карте');?>
                    </a></p><br/>
                    <?php endif; ?>
                <?php $i = $i + 1; ?>
                <?php endforeach; ?>
            <?php endif;?>
        </div>
    </div>
</div>