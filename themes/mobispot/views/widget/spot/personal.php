<div class="yourPhoto">
    <div class="photo-cont">
    </div>
    <div class="round-btn">
        <div class="round-btn-cl">
            <input type="submit" class="" value="<?php echo Yii::t('account', 'Загрузить');?>"/>
        </div>
    </div>
    <a href=""><?php echo Yii::t('account', 'Показать все');?></a>
</div>
<div class="yourName">
    <div class="txt-form">
        <div class="txt-form-cl">
            <?php echo CHtml::activeTextField($content,'3_imya', array('placeholder'=>'Your Name', 'class' => 'text')); ?>
        </div>
    </div>
</div>

<div class="oneBlockSpotInfo">
    <div class="top-border ">
        <?php echo Yii::t('account', 'Контактные данные');?>
        <div class="txt-form">
            <div class="txt-form-cl">
                <span class="tel-ico"></span>
                <input type="text" class="txt" name=3_telefon" value="" placeholder="Your Phone"/>
            </div>
        </div>
        <div class="txt-form">
            <div class="txt-form-cl">
                <span class="mail-ico"></span>
                <input type="text" class="txt" name="3_email" value="" placeholder="example@example.com"/>
            </div>
        </div>
        <div class="txt-form">
            <div class="txt-form-cl">
                <span class="skype-ico"></span>
                <input type="text" class="txt" name="3_skype" value="" placeholder="bulletgfx"/>
            </div>
        </div>
        <a href="#" class="r-btn-30"><span><?php echo Yii::t('account', 'Добавить');?></span></a>
    </div>
</div>
<div class="oneBlockSpotInfo">
    <div class="top-border ">
        <?php echo Yii::t('account', 'Социальные сети');?>
        <div class="txt-form">
            <div class="txt-form-cl">
                <span class="fb-ico"></span>
                <input type="text" class="txt" name="3_facebook" value="" placeholder="www.facebook.com/example"/>
            </div>
        </div>
        <div class="txt-form">
            <div class="txt-form-cl">
                <span class="tw-ico"></span>
                <input type="text" class="txt" name="3_twitter" value="" placeholder="www.twitter.com/example"/>
            </div>
        </div>
        <div class="txt-form">
            <div class="txt-form-cl">
                <span class="vk-ico"></span>
                <input type="text" class="txt" name="3_vk" value="" placeholder="www.link"/>
            </div>
        </div>
        <div class="txt-form">
            <div class="txt-form-cl">
                <span class="in-ico"></span>
                <input type="text" class="txt" name="3_linkedin" value="" placeholder="www.link"/>
            </div>
        </div>
        <a href="#" class="r-btn-30"><span><?php echo Yii::t('account', 'Добавить');?></span></a>
    </div>
</div>
<div class="clear"></div>
<div class="oneBlockSpotInfo" style="width:431px;margin:0">
    <div class="top-border ">
        <table class="oneBlockSpotInfoTbl" cellspacing="0">
            <tr>
                <td class="field"><?php echo Yii::t('account', 'Учебное заведение');?></td>
                <td>
                    <div class="txt-form">
                        <div class="txt-form-cl">
                            <input type="text" class="txt" name="inputtext" value="" placeholder=" "/>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="field"><?php echo Yii::t('account', 'Город');?></td>
                <td>
                    <div class="txt-form">
                        <div class="txt-form-cl">
                            <input type="text" class="txt" name="inputtext" value="" placeholder=" "/>
                        </div>
                    </div>
                </td>
            </tr>
        </table>

        <a href="#" class="r-btn-30"><span><?php echo Yii::t('account', 'Добавить');?></span></a>
    </div>
</div>
<div class="oneBlockSpotInfo">
    <div class="top-border ">
        <?php echo Yii::t('account', 'Язык отображения спота');?>
        <select>
            <option><?php echo Yii::t('account', 'Русский');?></option>
            <option><?php echo Yii::t('account', 'Английский');?></option>
        </select>
        <table class="oneBlockSpotInfoTbl">
            <tr>
                <td><?php echo Yii::t('account', 'Разрешить комментарии к споту');?></td>
                <td><input type="checkbox" class="niceCheck"></td>
            </tr>
            <tr>
                <td><?php echo Yii::t('account', 'Разрешить скачивать визитку');?></td>
                <td><input type="checkbox" class="niceCheck"></td>
            </tr>
        </table>
    </div>
</div>

