<?php
$this->pageTitle = 'Error';
?>
<div class="large-5 columns">
    <div class="p-error-txt">
        <?php if ($code == 404): ?>
            <h2 class="color">
                <?php echo Yii::t('error', 'The page you wanted doesn’t exist.') ?>
            </h2>
        <?php else: ?>
            <h2 class="color">
                <?php echo Yii::t('error', 'Looks like something went wrong!') ?>
            </h2>
        <?php endif; ?>
        <p><?php echo Yii::t('error', 'If you believe that something is going wrong please connect with us and we will fix it.') ?>

        </p>
        <footer>
            <a class="color" href="/help"><?php echo Yii::t('error', 'Get help!') ?></a>
            <a class="color" href="mailto:help@mobispot.com">help@mobispot.com</a>
            <a class="color" href="https://twitter.com/heymobispot">@heymobispot</a>
        </footer>
    </div>
</div>
<div class="large-7 columns">
    <div class="error-message">
        <div class="error-text-block">
            <h1><?php echo Yii::t('error', 'Oops!') ?></h1>
            <span class="error-code"><?php echo $code; ?></span>
        </div>

    </div>
</div>