<?php $id=Yii::app()->request->getQuery('id')?>
<ul class="nav-bar right">
  <?php if ((Yii::app()->controller->id!='site') or (Yii::app()->controller->action->id=='error')): ?>
  <li>
    <a class="spot-button <?php echo ($id=='personal')?'active':'';?>" href="/personal">
      <?php echo Yii::t('menu', 'Personal')?>
    </a>
  </li>
  <li>
    <a class="spot-button <?php echo ($id=='business')?'active':'';?>" href="/business">
      <?php echo Yii::t('menu', 'Business')?>
    </a>
  </li>
  <li>
    <a class="spot-button <?php echo ($id=='corporate')?'active':'';?>" href="/corporate">
      <?php echo Yii::t('menu', 'Corporate')?>
    </a>
  </li>
  <?php endif; ?>
<?php if (!Yii::app()->user->isGuest): ?>

  <li>
    <a class="spot-button" href="/store">
      <?php echo Yii::t('menu', 'Store')?>
    </a>
  </li>
 <?php endif; ?>
  <?php if (Yii::app()->user->isGuest): ?>
  <li>
    <a id="actSpot" class="spot-button toggle-box" href="#actSpotForm">
      <?php echo Yii::t('menu', 'Activate spot')?>
    </a>
  </li>
  <li>
    <a id="signIn" class="spot-button toggle-box" href="#signInForm">
      <?php echo Yii::t('menu', 'Sign in')?>
    </a>
  </li>
  <?php else:?>
  <li>
    <a class="spot-button" href="/service/logout/">
      <?php echo Yii::t('menu', 'Logout')?>
    </a>
  </li>
  <?php endif; ?>
</ul>
