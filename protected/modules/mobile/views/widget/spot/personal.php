<?php $all_field_ico = SpotPersonalField::getPersonalFieldAllIco(); ?>

<div id="main-container">
    <?php if (!empty($content->fotografiya_3)): ?>
    <div>
        <img src="/uploads/spot/<?php echo $content->fotografiya_3;?>" id="userPhoto" width="220" height="270"/>
    </div>
    <?php endif;?>
    <?php if ($content->imya_3): ?>
    <div class="whitePlash rad12">
        <?php echo $content->imya_3;?>
    </div>
    <?php endif; ?>
    <br/>
    <?php if (isset($content['razreshit-skachivat-vizitku_3'][0])): ?>
    <a href="/spot/getCard/" class="btn-round rad12 shadow"><?php echo Yii::t('mobile', 'Сохранить визитку')?></a>
    <br/>
    <?php endif;?>

    <div id="userContact" class="clr">
        <?php if ($content->kontaktyi_3): ?>
        <?php foreach ($content->kontaktyi_3 as $key => $value): ?>
            <?php if (!empty($value)): ?>
                <?php if (strpos($value, '@')): ?>
                    <a href="mailto:<?php echo $value;?>" class="btn-dig rad6 shadow">
            <span class="txt-24">
                <span class="ico ico-phone">
                    <?php if (!empty($all_field_ico[$key])): ?>
                        <img src="/uploads/ico/<?php echo $all_field_ico[$key]?>" alt="" width="30" height="30">
                        <?php endif; ?>
                </span>
                <?php echo $value; ?>
            </span>
        </a>
                    <?php else: ?>
                <span class="btn-dig rad6 shadow">
            <span class="txt-24">
                <span class="ico ico-phone">
                    <?php if (!empty($all_field_ico[$key])): ?>
                    <img src="/uploads/ico/<?php echo $all_field_ico[$key]?>" alt="" width="30" height="30">
                    <?php endif;?>
                </span>
                <?php echo $value; ?>
            </span>
        </span>
                <?php endif; ?>

            <?php endif
            ; ?>
            <?php endforeach; ?>
        <?php endif; ?>

        <?php if ($content->sotsseti_3): ?>
        <?php foreach ($content->sotsseti_3 as $key => $value): ?>
            <?php if (!empty($value)): ?>
                <a href="<?php echo YText::formatUrl($value)?>" class="btn-dig rad6 shadow">
            <span class="txt-24">
                <span class="ico ico-phone">
                    <?php if (!empty($all_field_ico[$key])): ?>
                    <img src="/uploads/ico/<?php echo $all_field_ico[$key]?>" alt="" width="30" height="30">
                    <?php endif; ?>
                </span>
                <?php echo $value; ?>
            </span>
                </a>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>

        <?php if ($content->opisanie_3): ?>
        <?php foreach ($content->opisanie_3 as $key => $value): ?>
            <?php if (!empty($value)): ?>
                <span class="btn-dig rad6 shadow">
                <span class="ico ico-phone">
                    <?php if (!empty($all_field_ico[$key])): ?>
                    <img src="/uploads/ico/<?php echo $all_field_ico[$key]?>" alt="" width="30" height="30">
                    <?php endif;?>
                </span>
            <span class="small-txt">
                <?php echo $value; ?>
            </span>
        </span>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>


    </div>
    <?php if (isset($content['razreshit-kommentarii_3'][0])): ?>
    <div class="grayAllBlock rad6 shadow">
        <div class="grayHead radTop6"><?php echo Yii::t('mobile', 'Оставить комментарий')?></div>
        <form>
            <textarea class="txt-100p txtArea rad6"></textarea>
            <input type="submit" class="btn-round fright rad12 shadow"
                   value="<?php echo Yii::t('mobile', 'Отправить')?>"/>
        </form>
    </div>
    <br/>
    <?php endif;?>

</div>
