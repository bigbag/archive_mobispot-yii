<div class="row" ng-controller="HelpCtrl">
    <div class="twelve columns singlebox-margin">
        <div ng-init="user.token='<?php echo Yii::app()->request->csrfToken ?>'">
            <div class="row">
                <div class="six columns">
                    <h4><?php echo Yii::t('help', 'Have a question? Need a hand? Anything bugging you? Please stick your details in this form and we’ll get back to you. Pronto. If not sooner.'); ?></h4>
                    <form id="help-in" name="helpForm">
                        <input
                            name='fName'
                            type="text"
                            ng-model="user.fName"
                            placeholder="<?php echo Yii::t('help', 'First Name'); ?>"
                            maxlength="300"
                            ng-minlength="3"
                            required >
                        <input
                            name='lname'
                            type="text"
                            ng-model="user.lname"
                            placeholder="<?php echo Yii::t('help', 'Last name'); ?>"
                            maxlength="300">
                        <input
                            name='email'
                            type="email"
                            ng-model="user.email"
                            placeholder="<?php echo Yii::t('help', 'Email'); ?>"
                            maxlength="300"
                            ng-minlength="3"
                            required >
                        <input
                            name='phone'
                            type="text"
                            ng-model="user.phone"
                            placeholder="<?php echo Yii::t('help', 'Mobile'); ?>">
                        <textarea
                            name="question"
                            ng-model="user.question"
                            style="height: 100px;"
                            placeholder="<?php echo Yii::t('help', 'Question'); ?> (<?php echo Yii::t('help', 'If you have a suggested answer, please let us know'); ?>)"
                            ngMinlength="3"
                            required >
                        </textarea>
                        <div class="form-control">
                            <a class="spot-button button-disable" href="javascript:;" ng-click="send(user)"><?php echo Yii::t('help', 'Send'); ?></a>
                        </div>
                    </form>
                </div>
                <div class="six columns">
                    <h4 class="two-line"><?php echo Yii::t('help', 'Or if you want, we can connect on'); ?></h4>
                    <ul class="contact-info">
                        <li><?php echo Yii::t('help', 'Email'); ?> – <a href="mailto:helpme@mobispot.com">helpme@mobispot.com</a></li>
                        <li><?php echo Yii::t('help', 'Skype'); ?> – mobispot</li>
                        <li class="soc-link"><?php echo Yii::t('help', 'Keep up at Twitter'); ?>
                            <a href="http://www.facebook.com/heyMobispot" class="i-soc-fac">&#xe000;</a>
                        </li>
                        <li class="soc-link"><?php echo Yii::t('help', 'Hook up at Facebook'); ?>
                            <a href="https://twitter.com/heymobispot" class="i-soc-twi">&#xe001;</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>