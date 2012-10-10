<div class="spot" id="<?php echo $data->discodes_id;?>">
    <div class="spot-title">
    <div class="one columns spot-checkbox">
        <input type="checkbox" name="discodes_id" value="<?php echo $data->discodes_id;?>"/>
        <span id="status_<?php echo $data->discodes_id;?>">
            <input type="hidden" name="status" value="<?php echo $data->status;?>">
        </span>
    </div>
    <div class="six columns spot-name">
        <div class="rename" style="display: none;">
            <form action="" method="post" class="spot_rename_form">
                <input type="hidden" name="discodes_id" value="<?php echo $data->discodes_id;?>">
                <div class="nine columns">
                    <input class="txt" name="name" maxlength="300" value="<?php echo $data->name;?>"
                                           placeholder=" " type="text">
                </div>
                <div class="three columns send">
                    <input class="m-button" value="<?php echo Yii::t('account', 'Сохр.');?>" type="submit">
                </div>
            </form>
        </div>
        <div class="name">
            <?php echo mb_substr($data->name, 0, 45, 'utf-8');?>
        </div>
    </div>
    <div class="two columns spot-id">
        <span class="spot_id_view"><?php echo $data->discodes_id;?></span>
        <span class="spot_code_view" style="display: none"><?php echo $data->code;?></span>
    </div>
    <div class="three columns spot-type">
        <div class="retype" style="display: none;">
            <form action="" method="post" class="spot_retype_form">
                <input type="hidden" name="discodes_id" value="<?php echo $data->discodes_id;?>">
            <div class="type-list">
                <?php
                    echo CHtml::activeDropDownList(
                        $data,
                        'spot_type_id',
                        SpotType::getSpotTypeArray(),
                        array('options' => array($data->spot_type_id => array('selected' => true)))
                    );
                ?>
            </div>
            <div class="send">
                    <input class="m-button" value="<?php echo Yii::t('account', 'Сохр.');?>" type="submit">
            </div>
            </form>
        </div>

        <div class="type">
            <?php echo (!empty($data->spot_type->name)) ? $data->spot_type->name : '';?>
        </div>
    </div>
</div>
<div class="twelve columns spot-content">
    <div class="five columns">
        <form action="/user/preview" method="get">
            <input type="hidden" name="discodes_id" value="<?php echo $data->discodes_id;?>">
            <input type="submit" class="m-button" value="<?php echo Yii::t('account', 'Сохранить');?>"
                        form="spot_edit_content_<?php echo $data->discodes_id;?>"/>&nbsp;&nbsp;
            <input type="submit" class="m-button" value="<?php echo Yii::t('account', 'Предпросмотр');?>"/>
    </form>
    </div>
    <div class="seven columns">

    </div>
    <div class="spot-content-body"></div>
</div>
</div>
