<li id="<?php echo $data->discodes_id;?>" class="oneSpotBlock">
    <div class="oneSpot">
        <table class="formSpot">
            <tr>
                <td id="id_<?php echo $data->discodes_id;?>" class="td60">
                    <center>
                        <input type="checkbox" name="discodes_id" value="<?php echo $data->discodes_id;?>"
                               class="niceCheck">
                    </center>
                    <span id="status_<?php echo $data->discodes_id;?>">
                        <input type="hidden" name="status" value="<?php echo $data->status;?>">
                    </span>
                </td>
                <td id="name_<?php echo $data->discodes_id;?>" class="td100p">
                    <div class="rename" style="display: none;">
                        <form action="" method="post" class="spot_rename_form">
                            <div style="background-position: 0px 0px;" class="txt-form">
                                <div style="background-position: 100% -35px;" class="txt-form-cl">
                                    <input class="txt" name="name" maxlength="300" value="<?php echo $data->name;?>"
                                           placeholder=" " type="text">
                                    <input type="hidden" name="discodes_id" value="<?php echo $data->discodes_id;?>">
                                </div>
                            </div>
                            <div class="round-btn">
                                <div class="round-btn-cl">
                                    <input class="" value="<?php echo Yii::t('account', 'Сохр.');?>" type="submit">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="name">
                        <?php echo mb_substr($data->name, 0, 45, 'utf-8');?>
                    </div>
                </td>
                <td class="td115">
                    <span class="spot_id_view"><?php echo $data->discodes_id;?></span>
                    <span class="spot_code_view" style="display: none"><?php echo $data->code;?></span>
                </td>
                <td id="type_<?php echo $data->discodes_id;?>" class="td180">
                    <div class="retype" style="display: none;">
                        <form action="" method="post" class="spot_retype_form">
                            <input type="hidden" name="discodes_id" value="<?php echo $data->discodes_id;?>">

                            <?php
                            echo CHtml::activeDropDownList(
                                $data,
                                'spot_type_id',
                                SpotType::getSpotTypeArray(),
                                array('options' => array($data->spot_type_id => array('selected' => true)))
                            );
                            ?>

                            <div class="round-btn">
                                <div class="round-btn-cl">
                                    <input class="" value="<?php echo Yii::t('account', 'Сохр.');?>" type="submit">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="type">
                        <?php echo (!empty($data->spot_type->name))?$data->spot_type->name:'';?>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    <div class="contSpot">
        <span class="message" id="message_<?php echo $data->discodes_id;?>"></span>

        <div class="btn-30">
            <div><input type="submit" class="" value="<?php echo Yii::t('account', 'Сохранить');?>"
                        form="spot_edit_content_<?php echo $data->discodes_id;?>"/></div>
        </div>
        <a href="#" class="btn-30">
            <span class="preview-ico ico"></span>
            <span class="btn-30-txt"><?php echo Yii::t('account', 'Предпросмотр');?></span>
        </a>


        <div id="spot_content_<?php echo $data->discodes_id;?>" class="oneSpotInfo"></div>
        <div class="clear"></div>
        <div>
</li>
