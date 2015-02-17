<?php $this->mainBackground = 'main-bg-w.png'?>

<div class="content-wrapper"
    ng-controller="SpotController"
    ng-init="spot.token=user.token; spot.discodes='<?php echo $curent_discodes;?>';general.views='<?php echo $curent_views;?>';setSpot(spot);">
    <div class="content-block">
        <div class="row text-center">
            <div class="block-link-wrapper">
            <a id="to-store" href="/store">
                <?php echo Yii::t('spot', 'Перейти в магазин спотов') ?>
            </a>
            </div><br>
            
            <div class="block-form-wrapper">
            <form id="add-spot" name="addSpotForm" class="custom">
                <p class="sub-txt">
                <?php echo Yii::t('spot', 'У Вас уже есть спот? Тогда введите код активации:'); ?>
                </p>
                 <input type="text"
                   ng-model="spot.code"
                   name="code"
                   placeholder="<?php echo Yii::t('spot', 'Spot activation code ') ?>"
                   autocomplete="off"
                   maxlength="10"
                   ng-class="{error: error.code}"
                   required>
                <input type="text"
                   ng-model="spot.name"
                   name="name"
                   placeholder="<?php echo Yii::t('spot', 'Spot\'s name') ?>"
                   autocomplete="off"
                   maxlength="300"
                   >
                <div class="checkbox">
                    <input id="spot_agree"
                        ng-model="spot.terms"
                        type="checkbox"
                        name="formSpot_agree"
                        value="0"
                        required
                        >
                    <label for="spot_agree">
                    <?php echo Yii::t('spot', 'I agree to Mobispot Pages Terms'); ?>
                    </label>
                </div>

                <div class="form-control">
                    <a  class="form-button" ng-click="addSpot(spot)">
                    <?php echo Yii::t('spot', 'Activate spot'); ?>
                    </a>
                </div>
                <span ng-init="spot.need_reload=1">
            </form>
            </div>
            
        </div>
    </div>
    <div class="fc"></div>
</div>
<div class="fc"></div>
