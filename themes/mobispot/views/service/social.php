<?php
#$this->pageTitle=$title;
?>
<div id="socialForm" class="row header-page recovery m-content-form"  ng-controller="UserController" >
    <div class="twelve columns">
        <div  class="row">
            <div class="seven columns centered">
                <h3><?php echo Yii::t('user', 'Start using your spot right now'); ?></h3>
            </div>
        </div>
        <div class="row">
            <div class="five columns centered">
                <form name="socialForm">
                    <?php if ($service == 'twitter'): ?>
                        <input
                            name='email'
                            type="email"
                            ng-model="user.email"
                            placeholder="<?php echo Yii::t('user', 'E-mail') ?>"
                            autocomplete="off"
                            maxlength="300"
                            required >
                        <?php else: ?>
                        <span ng-init="user.email='<?php echo $email ?>'"><span>
                            <?php endif ?>
                            
                            <div class="toggle-active">
                                <a class="checkbox agree"   ng-click="setTerms(user)"><i></i><?php echo Yii::t('user', 'I agree to Terms and Conditions'); ?></a>
                            </div>
                            <div class="form-control">
                                <a class="spot-button activ button-disable"  ng-click="social(user, socialForm.$valid)">
                                    <?php echo Yii::t('user', 'Registration'); ?>
                                </a>
                            </div>
                            </form>
                            </div>
                            </div>
                            </div>
                            </div>
