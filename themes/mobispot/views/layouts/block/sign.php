<div id="signInForm" class="slide-box" >
    <div  class="row">
        <div class="seven columns centered">
                <h3><?php echo Yii::t('sign', 'Sign in');?></h3>
        </div>
        <a href="javascript:;" class="slide-box-close"></a>
    </div>
    <div class="row">
        <div class="five columns centered">
            <form>
                <input type="text" placeholder="<?php echo Yii::t('sign', 'Email address');?>">
                <input type="password" placeholder="<?php echo Yii::t('sign', 'Password');?>">
                <div class="form-control">
                    <a class="spot-button" href="#" ng-click="login()"><?php echo Yii::t('sign', 'Sign in');?></a>
                    <span class="right soc-link">
                        <a href="/service/social?service=facebook" class="i-soc-fac">&nbsp;</a>
                        <a href="/service/social?service=twitter" class="i-soc-twi">&nbsp;</a>
                        <a href="/service/social?service=google_oauth" class="i-soc-goo">&nbsp;</a>
                    </span>
                </div>
            </form>
        </div>
    </div>
</div>