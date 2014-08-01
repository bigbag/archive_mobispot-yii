<?php $this->pageTitle = Yii::t('phone', 'Help'); ?>
<?php $this->mainBackground = 'main_bg_1.jpg'?>

<div class="content-wrapper">
    <div class="content-block" ng-controller="HelpController" >
        <div class="row">
            <div class="large-12 columns form-block">
                <div class="row">
                    <div class="column large-12">
                        <h2 class="color">
                            <?php echo Yii::t('help', 'Get Help') ?>
                        </h2>
                    </div>
                </div>
                <div class="row">
                    <div class="small-8 large-8 column">
                        <span class="form-h">
                            <?php echo Yii::t('help', 'Have a question? Need a hand?
                            Anything bugging you?
                            Please stick your details in this form and we’ll get back to you. Pronto. If not sooner.') ?>
                        </span>
                    </div>
                </div>
                <div class="row">
                    <div class="small-4 large-4 column">
                        <form id="help-in" name="helpForm" class="custom">
                            <input
                                name='name'
                                type="text"
                                ng-model="user.name"
                                placeholder="<?php echo Yii::t('help', 'Name'); ?>"
                                maxlength="300"
                                ng-minlength="3"
                                required >
                            <input
                                name='email'
                                type="email"
                                ng-model="user.help_email"
                                placeholder="<?php echo Yii::t('help', 'Email'); ?>"
                                maxlength="300"
                                ng-minlength="3"
                                required >
                            <input
                                name='phone'
                                type="text"
                                ng-model="user.phone"
                                placeholder="<?php echo Yii::t('help', 'Phone'); ?>">
                            <textarea
                                name="question"
                                ng-model="user.question"
                                style="height: 100px;"
                                placeholder="<?php echo Yii::t('help', 'Question'); ?> (<?php echo Yii::t('help', 'If you have a suggested answer, please let us know'); ?>)"
                                ngMinlength="3"
                                required >
                            </textarea>
                            <div class="form-control">
                                <a class="form-button" href="javascript:;" ng-click="send(user, helpForm.$valid)">
                                    <?php echo Yii::t('help', 'Send'); ?>
                                </a>
                            </div>
                        </form>
                    </div>
                    <div class="small-8 large-8 column">
                        <ul class="contact-info">
                            <li>Email – <a class="color" href="mailto:helpme@mobispot.com">helpme@mobispot.com</a></li>
                            <li>Skype – mobispot</li>
                            <li><?php echo Yii::t('help', 'Keep up at Twitter') ?> <a class="icon" href="https://twitter.com/heymobispot">&#xe001;</a></li>
                            <li><?php echo Yii::t('help', 'Hook up at Facebook') ?> <a class="icon" href="http://www.facebook.com/heyMobispot">&#xe000;</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="fc"></div>
