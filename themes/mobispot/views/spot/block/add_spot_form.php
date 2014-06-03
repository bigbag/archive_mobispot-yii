 <div id="actSpotForm" class="slide-box add-spot-box">
    <div class="row">
        <div class="custom centered column">
            <form id="add-spot" name="addSpotForm">
                <p class="sub-txt">
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
            </form>
        </div>
    </div>
</div>
