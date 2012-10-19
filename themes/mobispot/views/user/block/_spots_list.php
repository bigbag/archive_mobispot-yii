<div class="spot" id="<?php echo $data->discodes_id;?>">
    <div class="spot-title">
    <div class="one columns spot-checkbox">
        <input type="checkbox" name="discodes_id" ng-model="discodes" ng-true-value="<?php echo $data->discodes_id;?>" ng-change="status = <?php echo $data->status;?>"/>
    </div>
    <div class="six columns spot-name">
        <div class="rename" style="display: none;">
            <form class="spot_rename_form"  name="renameForm"  ng-init="discodes=discodes; spot_name_<?php echo $data->discodes_id;?>='<?php echo $data->name;?>'">
                <div class="nine columns">
                    <input
                        name="name"
                        maxlength="300"
                        value="<?php echo $data->name;?>"
                        ng-model="spot_name_<?php echo $data->discodes_id;?>"
                        type="text">
                </div>
                <div class="three columns send">
                    <button class="m-button" ng-click="rename(spot_name_<?php echo $data->discodes_id;?>)">
                       <?php echo Yii::t('account', 'Сохр.')?>
                    </button>
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
            <form class="spot_retype_form" name="retypeForm"  ng-init="discodes=<?php echo $data->discodes_id;?>; spot_type_id_<?php echo $data->discodes_id;?>=<?php echo $data->spot_type_id;?>">
            <div class="type-list">
                <?php
                    echo CHtml::activeDropDownList(
                        $data,
                        'spot_type_id',
                        Spot::getAllSpot(),
                        array(
                            'options' => array(
                                $data->spot_type_id => array('selected' => true),
                            ),
                            'ng-model' => "spot_type_id_" . $data->discodes_id,
                        )
                    );
                ?>
            </div>
            <div class="send">
                <button class="m-button" ng-click="retype(spot_type_id_<?php echo $data->discodes_id;?>)">
                    <?php echo Yii::t('account', 'Сохр.')?>
                </button>
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
