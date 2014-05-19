<?php $all_lang = Lang::getLangArray() ?>
<div id="footer">
  <span id="sel-lang"><?php echo $all_lang[Yii::app()->language]; ?> •
    <?php foreach (Lang::getLang() as $row): ?>
      <?php if ($row['name'] != Yii::app()->language): ?>
        <a id="" href="/service/lang/<?php echo $row['name'] ?>"><?php echo $row['desc'] ?></a>
      <?php endif; ?>
    <?php endforeach; ?>
  </span>
  <br/>
  <span id="rule-info"><a href=""><?php echo Yii::t('footer', 'Правила пользования') ?></a></span><br/>
  <span id="copyright"><?php echo Yii::app()->params['copyright']; ?></span>
</div>