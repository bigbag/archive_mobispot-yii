<?php $id = Yii::app()->request->getQuery('id') ?>
<ul class="nav-bar right">
    <?php if (Yii::app()->user->isGuest): ?>
        <li>
            <a id="actSpot" class="spot-button toggle-box" href="#actSpotForm">
                <?php echo Yii::t('menu', 'Activate spot') ?>
            </a>
        </li>
        <li>
            <a id="signIn" class="spot-button toggle-box" href="#signInForm">
                <?php echo Yii::t('menu', 'Sign in') ?>
            </a>
        </li>
    <?php else: ?>
        <li>
            <a class="spot-button" href="/service/logout/">
                <?php echo Yii::t('menu', 'Logout') ?>
            </a>
        </li>
    <?php endif; ?>
</ul>
