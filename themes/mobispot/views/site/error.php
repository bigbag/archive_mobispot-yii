<?php $this->pageTitle = Yii::t('error', 'Error'); ?>

<div class="content-wrapper">
    <div class="error-block">
        <div class="row">
            <div class="content-block p-error-txt">
                <?php if ($code == 404): ?>
                    <h2>
                        <?php echo Yii::t('error', 'The page you wanted doesn’t exist.') ?>
                    </h2>
                <?php else: ?>
                    <h2>
                        <?php echo Yii::t('error', 'Looks like something went wrong!') ?>
                    </h2>
                <?php endif; ?>
                <p>
                    <?php echo Yii::t('error', 'If you believe that something is going wrong please connect with us and we will fix it.') ?>
                </p>
                <footer>
                    <a class="color" href="/help"><?php echo Yii::t('error', 'Get help!') ?></a>
                    <a class="color" href="mailto:helpme@mobispot.com">helpme@mobispot.com</a>
                    <a class="color" href="https://twitter.com/heymobispot">@heymobispot</a>
                </footer>
                <div class="error-icon">
                    <span class="type-error"><?php echo $code;?></span>
                </div>
            </div>
        </div>
    </div>
</div>
