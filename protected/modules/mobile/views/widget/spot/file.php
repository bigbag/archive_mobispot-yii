<?php if (strpos($content->fayl_6, 'pdf')  == 0): ?>
<img src="/uploads/spot/<?php echo $content->fayl_6;?>" alt=""/>
<?php else: ?>
<iframe src="http://docs.google.com/gview?url=<?php echo Yii::app()->request->getBaseUrl(true);?>/uploads/spot/<?php echo $content->fayl_6;?>" style="width:400px; height:700px;" frameborder="0"></iframe>

<?php endif; ?>