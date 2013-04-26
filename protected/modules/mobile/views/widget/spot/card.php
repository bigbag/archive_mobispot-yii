<?php if (!empty($content['nazvanie-biznesa_8'][0])):?>
<div class="spot-item">
    <?php if (!empty($content['sayt_8'][0])):?>
        <a href="<?php echo YText::formatUrl($content['sayt_8'])?>" class="item-area type-logo">
            <?php echo $content['nazvanie-biznesa_8']; ?>
        </a>
    <?php else:?>
        <p class="item-area type-logo">
            <?php echo $content['nazvanie-biznesa_8']; ?>
        </p>
    <?php endif;?>

    
</div>
<?php endif;?>

<?php if (!empty($content['kontaktnoe-litso_8'][0])):?>
    <div class="spot-item">
        <div class="item-area text-center type-phone">
            <i></i><?php echo $content['kontaktnoe-litso_8']; ?>
        </div>
    </div>
<?php endif;?>

<div class="spot-item__pack">
    <h2>Интересные предложение:</h2>
    <?php if (!empty($content->nazvanie_8)): ?>
        <?php $i = 0; ?>
        <?php foreach ($content->nazvanie_8 as $name): ?>
            <?php $link = $content->ssyilka_8; ?>
            <?php $file = $content->kartinka_8; ?>

            <?php if (!empty($file[$i])):?>
            <div class="spot-item">
                <div class="item-area text-center">
                    <img src="/uploads/spot/<?php echo $file[$i] ?>"/>
                </div>
            </div>
            <?php endif;?>

            <?php if (!empty($name)):?>
                <div class="spot-item">
                <?php if (!empty($link[$i])):?>
                    <a href="<?php echo YText::formatUrl($link[$i])?>" class="item-area type-link"> 
                        <?php echo $name; ?>
                    </a>
                <?php else:?>
                    <p class="item-area item-type__text">
                        <?php echo $name; ?>
                    </p>
                <?php endif;?>
                </div>
            <?php endif;?>

            <?php $i = $i + 1; ?>
            <?php endforeach; ?>
    <?php endif;?>

       
</div>
<div class="spot-item__pack">
    <h2>Ближайшие точки продаж:</h2>
        <?php if (count($content['tochka-nazvanie_8']) > 0): ?>
            <?php $i = 0; ?>
            <?php foreach ($content['tochka-nazvanie_8'] as $name): ?>
                <?php if (isset($name[1])): ?>
                <div class="spot-item">
                    <div class="item-area type-find">
                    <?php $karta = $content['tochka-karta_8']; ?>
                    <p><?php echo CHtml::encode($name);?></p>
                    <?php if (!empty($karta[$i])):?>
                    <a href="<?php echo YText::formatUrl($karta[$i])?>"
                          class="spot-item_button">На карте
                    </a>
                        <?php endif;?>
                    </div>
                </div>
                <?php endif; ?>
                <?php $i = $i + 1; ?>
            <?php endforeach; ?>
        <?php endif;?>
</div>