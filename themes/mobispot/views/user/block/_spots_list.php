<div class="spot" id="<?php echo $data->discodes_id;?>">
    <div class="spot-title">
    <div class="one columns spot-checkbox">
        <input type="checkbox" name="discodes_id" ng-model="discodes" ng-true-value="<?php echo $data->discodes_id;?>" ng-change="status = <?php echo $data->status;?>"/>
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
        <span class="spot_id_view" ng-click="selected_<?php echo $data->discodes_id;?> = true" ng-model="selected_<?php echo $data->discodes_id;?>" ng-hide="selected_<?php echo $data->discodes_id;?>"><?php echo $data->discodes_id;?></span>
        <span class="spot_code_view" ng-click="selected_<?php echo $data->discodes_id;?> = false" ng-model="selected_<?php echo $data->discodes_id;?>" ng-show="selected_<?php echo $data->discodes_id;?>"><?php echo $data->code;?></span>
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
    <div class="row">
        <div class="five columns">
            <a href="<?php echo $data->discodes_id;?>" class="m-button save-spot">
                <?php echo Yii::t('account', 'Сохранить');?>
            </a>&nbsp;&nbsp;
            <a href="<?php echo $data->discodes_id;?>" class="m-button preview-spot">
                <i class="icon-search"></i>&nbsp;<?php echo Yii::t('account', 'Предпросмотр');?>
            </a>
        </div>
        <div class="seven columns">

        </div>
    </div>
    <div class="spot-content-body"></div>
</div>
</div>
