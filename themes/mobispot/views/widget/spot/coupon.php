<div class="oneSpot">
    <div class="contSpot">
        <div class="btn-30">
            <div><input type="submit" class="" value="<?php echo Yii::t('account', 'Сохранить');?>"
                        form="spot_edit_content_<?php echo $data->discodes_id;?>"/></div>
        </div>
        <a href="#" class="btn-30">
            <span class="preview-ico ico"></span>
            <span class="btn-30-txt"><?php echo Yii::t('account', 'Предпросмотр');?></span>
        </a>

        <div class="oneSpotInfo">
            <form action="" method="post" class="spot_edit_content"
                  id="spot_edit_content_<?php echo $content->spot_id?>">
                <?php echo CHtml::activeHiddenField($content, 'spot_id'); ?>
                <?php echo CHtml::activeHiddenField($content, 'spot_type_id'); ?>
                <span class="upload-img active"><?php echo Yii::t('account', 'Загрузка картинки');?></span>
                <a href="<?php echo $data->discodes_id;?>" class="constr"
                   id="desinger"><?php echo Yii::t('account', 'Конструктор');?></a>
                <br/>
                <br/>

                <p><?php echo Yii::t('account', 'Подгрузите сюда картинку с Вашим купоном (любой графический формат, объем - до 512 Кб),<br>
                и Ваш потенциальный покупатель получит его прямо в телефон. Не забудьте указать на купоне<br> сроки его
                действия и правила использования.');?></p>
                <br/>

                <div class="noUploadImg">
                    <?php if (!empty($content->kupon_4)): ?>
                    <img src="/uploads/spot/<?php echo $content->kupon_4?>" height="192px" alt="coupon"/>
                    <?php endif;?>
                    <noscript>
                        <p>Please enable JavaScript to use file uploader.</p>
                    </noscript>
                </div>
                <div class="round-btn-new">
                    <input type="submit" id="add_photo" value="<?php echo Yii::t('profile', 'Загрузить');?>"/>
                </div>

            </form>
        </div>

        <div class="clear"></div>
    </div>
</div>

<?php Yii::app()->getClientScript()->registerScriptFile('/themes/mobispot/js/jquery.uploadifive.min.js'); ?>
<script type="text/javascript">
    $(document).ready(function () {
        $('a#desinger').click(function () {
            var id = <?php echo $data->discodes_id;?>;
            $.ajax({
                url:'/ajax/getContent',
                type:'POST',
                data:{discodes_id:id, 'content':'coupon_designer'},
                success:function (result) {
                    $('.oneSpotInfo').html(result);
                    $('.upload-img').attr('href', id);
                }
            });
            return false;
        });
    });

    $(function () {
        $("#add_photo").uploadifive({
            'width':'120',
            'height':'28',
            'fileTypeExts':'*.pdf; *.gif; *.jpg; *.png',
            uploadScript:'/user/uploadFile/',
            'formData':{'spot_id':<?php echo($data->discodes_id)?>},
            'fileSizeLimit':'10MB',
            'removeTimeout':10,
            'multi':false,
            'buttonClass':'uploadify_personal',
            'buttonText':'<?php echo Yii::t('profile', 'Загрузить');?>',

            'onError':function (errorType) {
                $('#messages_modal div.messages').html('The file could not be uploaded: ' + errorType);
                $('#messages_modal').reveal({animation:'none'});
            },
            'onUploadComplete':function (file, data, response) {
                var obj = jQuery.parseJSON(data);
                var file_name = obj.file;
                var error = obj.error;
                if (file_name) {
                    $('.noUploadImg').html('<img src="/uploads/spot/' + file_name + '" height="192px"  alt="coupon"/>');
                }
                if (error) alert(error);
            }
        });
    });
</script>