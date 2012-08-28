<li class="oneSpotBlock">
    <div class="oneSpot">
        <table class="formSpot">
            <tr>
                <td class="td60">
                    <center>
                        <input type="checkbox" name="discodes_id" value="<?php echo $data->discodes_id;?>" class="niceCheck">
                    </center>
                </td>
                <td class="td100p"><?php echo $data->name;?></td>
                <td class="td115"><span><?php echo $data->discodes_id;?></span></td>
                <td class="td180"><?php echo $data->spot_type->name;?></td>
            </tr>
        </table>
    </div>
    <div class="contSpot">
        <div class="btn-30">
            <div><input type="submit" class="" value="<?php echo Yii::t('account', 'Сохранить');?>"/></div>
        </div>
        <a href="" class="btn-30"><span class="preview-ico ico"></span><span class="btn-30-txt"><?php echo Yii::t('account', 'Предпросмотр');?></span></a>
        <?php $file_path = '_spot_type_' . $data->spot_type->slug . '.php';?>
        <?php include($file_path)?>
        <div class="clear"></div>
        <div>
</li>