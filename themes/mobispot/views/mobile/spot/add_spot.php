<div class="wrapper" ng-controller="UserCtrl" ng-init="user.token='<?php echo Yii::app()->request->csrfToken; ?>'">
    <div id="menu" class="main-menu">
        <ul>
            <li><a href="/spot/addSpot"><i>+</i><?php echo Yii::t('user', 'Add New Spot'); ?></a></li>
            <li><a href="<?php echo $this->desktopHost() ?>/user/profile/"><i class="icon">&#xe60f;</i><?php echo Yii::t('user', 'Profile'); ?></a></li>
            <li><a href="/service/logout/"><i class="icon">&#xe610;</i><?php echo Yii::t('user', 'Log Out'); ?></a></li>
        </ul>
    </div>
    <header>
        <h1><a href="#"><img width="140" src="img/logo_x2.png"></a></h1>
        <a class="full-size" href="http://mobispot.com"><i class="icon">&#xf108;</i>Full size version</a>
    </header>
    <div class="control">
            <h4>Add New Spot</h4>
            <a href="javascript:;" id="show-menu" class="right"><i class="icon">&#xe611;</i></a>
        </div>
    <section class="content">
        <form>
                <p>
                    You can change your password following the instructions in a special email from us. Please click the button below to proceed.
                </p>
                    <input placeholder="Spot activation code" type="text">
                    <div class="checkbox">
                        <input id="formReg_agree" type="checkbox" name="formReg_agree" value="check1">
                        <label for="formReg_agree">I agree to Terms and Conditions</label>
                    </div>

                    <a class="form-button" href="#">Activate</a>
                </form>

    </section>
    <div class="fc"></div>
</div>
