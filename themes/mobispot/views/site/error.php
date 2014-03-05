<?php $this->pageTitle = Yii::t('error', 'Error'); ?>
<?php $this->main_background = 'main_bg_2.jpg'?>

<div class="content-wrapper">
    <div class="content-block" ng-controller="PhonesController">
        <div class="row">
            <div class="large-12 columns form-block">
                <div>
                    <div class="row">
                        <div class="column large-12">
                            <?php if ($code == 404): ?>
                                <h2 class="color">
                                    <?php echo Yii::t('error', 'The page you wanted doesn’t exist.') ?>
                                </h2>
                            <?php else: ?>
                                <h2 class="color">
                                    <?php echo Yii::t('error', 'Looks like something went wrong!') ?>
                                </h2>
                            <?php endif; ?>
                            <p>
                                <?php echo Yii::t('error', 'If you believe that something is going wrong please connect with us and we will fix it.') ?>
                            </p>
                            <h5 class="two-line color">
                                <a class="color" href="/help">
                                    <?php echo Yii::t('error', 'Get help!') ?>
                                </a>
                            </h5>
                            <h5 class="two-line color">
                                <a class="color" href="mailto:helpme@mobispot.com">
                                    helpme@mobispot.com
                                </a>
                            </h5>
                            <h5 class="two-line color">
                                <a class="color" href="https://twitter.com/heymobispot">
                                    @heymobispot
                                </a>
                            </h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>