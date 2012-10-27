<script type="text/javascript">

//Редактирование спота
$(document).ready(function () {
    var options = {
        success:showSpotEditResponse,
        clearForm:false,
        url:'/ajax/spotEdit/'
    };
    $('body').delegate('.spot_edit_content', 'submit', function () {
        $(this).ajaxSubmit(options);
        return false;
    });
});

function showSpotEditResponse(responseText) {
    if (responseText) {
        var obj = jQuery.parseJSON(responseText);

        if (obj.discodes_id) {
            var id = obj.discodes_id;
            if (id) {
                $('span#message_' + id).text('<?php echo Yii::t('account', 'Изменения успешно сохранены.')?>');
                $('span#message_' + id).show();
                setTimeout(function () {
                    $('span#message_' + id).hide();
                }, 3000);
            }

        }
    }
}
