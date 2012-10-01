<div id="main-container">
    <div id="userContact" class="clr">
        <?php if (!empty($content['nazvanie-biznesa_8'])):?>
        <span class="btn-dig rad6 shadow">
            <span class="txtFCenter"><?php echo $content['nazvanie-biznesa_8']; ?>
            </span>
        </span>
        <?php endif;?>
        <?php if (!empty($content['sayt_8'])):?>
        <a href="<?php echo YText::formatUrl($content['sayt_8'])?>" class="btn-dig rad6 shadow">
            <span class="txtFCenter"><?php echo $content['sayt_8']; ?></span>
        </a>
        <?php endif;?>
        <?php if (!empty($content['kontaktnoe-litso_8'])):?>
        <span class="btn-dig rad6 shadow"><?php echo $content['kontaktnoe-litso_8']; ?>
        </span>
        <?php endif;?>
    </div>
    <div class="grayAllBlock rad6 shadow">
        <div class="grayHead radTop6"><?php echo Yii::t('mobile', 'Интересные предложение');?></div>
        <?php if (!empty($content->nazvanie_8)): ?>
        <?php $i = 0; ?>
        <?php foreach ($content->nazvanie_8 as $name): ?>
            <?php $link = $content->ssyilka_8; ?>
            <?php $file = $content->kartinka_8; ?>

            <?php if (!empty($file[$i])):?>
                <img src="/uploads/spot/<?php echo $file[$i] ?>" class="fleft" alt="" width="100%"/>
            <?php endif;?>
            <?php if (!empty($name)):?>
            <div class="infoViz proc100 clr txtFLeft">
                <?php if (!empty($link[$i])):?>
                <p><a href="<?php echo YText::formatUrl($link[$i])?>"> <?php echo $name; ?></a></p>
                <?php else:?>
                <p><?php echo $name; ?></p>
                <?php endif;?>
            </div>
            <?php endif;?>

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
                    <?php if (!empty($karta[$i])):?>
                    <p><a href="<?php echo YText::formatUrl($karta[$i])?>"
                          class="btn-cent ico rad4 shadow txtFLeft"><span></span><?php echo Yii::t('account', 'На карте');?>
                    </a></p><br/>
                        <?php endif;?>
                    <?php endif; ?>
                <?php $i = $i + 1; ?>
                <?php endforeach; ?>
            <?php endif;?>
        </div>
    </div>
</div>