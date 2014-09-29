<div class="wrapper" ng-controller="SpotController" ng-init="spot.token='<?php echo Yii::app()->request->csrfToken; ?>'; host_type='mobile';">
    <div id="menu" class="main-menu">
        <ul>
            <li><a href="/spot/addSpot"><i>+</i><?php echo Yii::t('user', 'Add New Spot'); ?></a></li>
            <li><a href="/user/profile/"><i class="icon">&#xe60f;</i><?php echo Yii::t('user', 'Profile'); ?></a></li>
            <li><a href="/service/logout/"><i class="icon">&#xe610;</i><?php echo Yii::t('user', 'Log Out'); ?></a></li>
            <li><a class="main-back" href="javascript:;"><i class="icon">&#xe603;</i></a></li>
        </ul>
    </div>
    <header>
        <h1><a href="/"><img width="140" src="/themes/mobispot/img/logo_x2.png"></a></h1>
        <a class="full-size" href="/service/setFullView"><i class="icon">&#xf108;</i><?php echo Yii::t('spot', 'Full size version'); ?></a>
    </header>
    <div class="control">
            <h4><?php echo Yii::t('user', 'Add New Spot') ?></h4>
            <a href="javascript:;" id="show-menu" class="right"><i class="icon">&#xe611;</i></a>
        </div>
    <section class="content">
        <form id="add-spot" name="addSpotForm">
                <p>
                    <?php echo Yii::t('spot', 'Please type your new spot’s activation code and click the button below.'); ?>
                </p>
                    <input type="text"
                       ng-model="spot.code"
                       name="code"
                       placeholder="<?php echo Yii::t('spot', 'Spot activation code ') ?>"
                       autocomplete="off"
                       maxlength="10"
                       ng-class="{error: error.code}"
                       required>
                    <div class="checkbox">
                        <input
                            id="spot_agree"
                            ng-model="spot.terms"
                            type="checkbox"
                            name="formSpot_agree"
                            value="0"
                            required
                        >
                        <label for="spot_agree"><?php echo Yii::t('spot', 'I agree to Mobispot Pages Terms'); ?></label>
                    </div>
                    <a class="form-button" ng-click="addSpot(spot)"><?php echo Yii::t('spot', 'Activate spot'); ?></a>
                </form>

    </section>
    <div class="fc"></div>
</div>
