<li class="oneSpotBlock">
    <div class="oneSpot">
        <table class="formSpot">
            <tr>
                <td id="id_<?php echo $data->discodes_id;?>" class="td60">
                    <center>
                        <input type="checkbox" name="discodes_id" value="<?php echo $data->discodes_id;?>"
                               class="niceCheck">
                    </center>
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
                        <?php echo substr($data->name, 0, 45);?>
                    </div>
                </td>
                <td class="td115"><span><?php echo $data->discodes_id;?></span></td>
                <td id="type_<?php echo $data->discodes_id;?>" class="td180">
                    <div class="retype" style="display: none;">
                        <form action="" method="post" class="spot_retype_form">
                            <input type="hidden" name="discodes_id" value="<?php echo $data->discodes_id;?>">
                            <select name="type">
                                <?foreach (SpotType::getSpotTypeArray($data->type) as $key => $value): ?>
                                <?php if ($data->spot_type_id == $key): ?>
                                    <option value="<?php echo $key; ?>" selected><?php echo $value; ?></option>
                                    <?php else: ?>
                                    <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>

                            <div class="round-btn">
                                <div class="round-btn-cl">
                                    <input class="" value="<?php echo Yii::t('account', 'Сохр.');?>" type="submit">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="type">
                        <?php echo $data->spot_type->name;?>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    <div class="contSpot">
        <div class="btn-30">
            <div><input type="submit" class="" value="<?php echo Yii::t('account', 'Сохранить');?>"/></div>
        </div>
        <a href="" class="btn-30"><span class="preview-ico ico"></span><span
            class="btn-30-txt"><?php echo Yii::t('account', 'Предпросмотр');?></span></a>
        <?php $file_path = '_spot_type_' . $data->spot_type->pattern . '.php';?>
        <?php include($file_path)?>
        <div class="clear"></div>
        <div>
</li>
