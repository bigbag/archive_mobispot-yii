<div id="gallery_modal" class="reveal-modal">
<div class="cont-pop">
<a class="close-reveal-modal"><?php echo Yii::t('user', 'Закрыть')?></a>

<form action="post.php" method="POST">
<div id="galleryPhoto">
<?php if (!empty($photo)): ?>
<?php $count_photo = count($photo); ?>

<?php $i = 1; ?>
<?php foreach ($photo as $key => $value): ?>
<div class="gallery_image" id="<?php echo $i;?>" style="<?php echo ($i != 1) ? 'display: none;' : ''?>">
<span id="numPhoto"><?php echo $i;?>/<?php echo $count_photo;?></span>
<span id="left" class="navGallery"
style="<?php echo ($i == 1) ? 'display: none;' : ''?>"></span>
<span id="right" class="navGallery"
style="<?php echo ($i == $count_photo) ? 'display: none;' : ''?>"></span>
<img src="/uploads/spot/<?php echo $value;?>" alt=""/>
</div>
<?php $i++; ?>

<?php endforeach; ?>
<?php endif;?>
</div>
<div id="galleryOption">
<span class="btn-30" id="add_to_spot">
<span class="star-ico ico"></span>
<span class="btn-30-txt"><?php echo Yii::t('account', 'Сделать основной'); ?></span>
</span>
<span class="btn-30"  id="remove_photo">
<span class="del-ico ico"></span>
<span class="btn-30-txt"><?php echo Yii::t('account', 'Удалить'); ?></span>
</span>
</div>
<div class="clear"></div>
</form>
</div>
</div>

<script type="text/javascript">
$(document).ready(function () {
    $('#remove_photo').click(function () {
        var file_path = $("div.gallery_image:visible img").attr('src');
        if (file_path){
          var file_array = file_path.split('/');
          if (file_array[3]){
            var file = file_array[3];
            
            if(file){
              $.ajax({
                  url:'/ajax/spotRemovePhoto',
                  type:'POST',
                  data:{user_id:<?php echo $user_id?>, file:file},
                  success:function (result) {
                    var curent_file = $('#personal_photo').val();
                    if (curent_file == result){
                      $('#personal_photo').val('');
                      $('.photo-cont').html('<img width="130" src="/themes/mobispot/images/personal_no_photo.jpg" />');
                    }
                    $('.close-reveal-modal').click();
                  }
              });
            }
          }
        }
    });
    return false;
});

$(document).ready(function () {
    $('#add_to_spot').click(function () {
        var file_path = $("div.gallery_image:visible img").attr('src');
        if (file_path){
          var file_array = file_path.split('/');
          if (file_array[3]){
            var file = file_array[3];
            $('#personal_photo').val(file);
            $('.photo-cont').html('<img width="130" src="/uploads/spot/' + file + '" />');
            $('.close-reveal-modal').click();
          }
        }
    });
    return false;
});


$(document).ready(function () {
    $('span#right').click(function () {
        var id = $(this).parent().attr('id');
        if (id) {
          var new_id = id * 1 + 1;
          $(this).parent().hide();
          $('#' + new_id).show();
        }
    });
    return false;
});

$(document).ready(function () {
    $('span#left').click(function () {
        var id = $(this).parent().attr('id');
        if (id) {
          var new_id = id * 1 - 1;
          $(this).parent().hide();
          $('#' + new_id).show();
        }
    });
    return false;
});
</script>