<?php $id=Yii::app()->request->getQuery('id')?>
<ul class="nav-bar right">
<?php if (Yii::app()->controller->id!='site'): ?>
<li>
<a class="spot-button <?php echo ($id=='personal')?'active':'';?>" href="/personal"><?php echo Yii::t('general', 'Personal')?></a>
</li>

<li>
<a class="spot-button <?php echo ($id=='business')?'active':'';?>" href="/business"><?php echo Yii::t('general', 'Business')?></a>
</li>
<li>
<a class="spot-button <?php echo ($id=='corporate')?'active':'';?>" href="/corporate"><?php echo Yii::t('general', 'Corporate')?></a>
</li>
<?php endif; ?>
<li>
<a class="spot-button" href="http://store.mobispot.com"><?php echo Yii::t('general', 'Store')?></a>
</li>
<?php if (Yii::app()->user->isGuest): ?>
<li>
<a id="actSpot" class="spot-button toggle-box" href="#actSpotForm"><?php echo Yii::t('general', 'Activate spot')?></a>
</li>
<li>
<a id="signIn" class="spot-button toggle-box" href="#signInForm"><?php echo Yii::t('general', 'Sign in')?></a>
</li>
<?php else:?>
<li>
<a class="spot-button" href="/service/logout/"><?php echo Yii::t('general', 'Logout')?></a>
</li>
<?php endif; ?>
<?php foreach(Lang::getLang() as $row):?>
<?php if($row['name'] != Yii::app()->language):?>
<li>
<a class="spot-button" href="/service/lang/<?php echo $row['name']?>"><?php echo $row['desc']?></a>
</li>
<?php endif;?>
<?php endforeach;?>
</ul>