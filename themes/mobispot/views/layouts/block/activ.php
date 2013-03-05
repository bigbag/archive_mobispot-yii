<div id="actSpotForm" class="slide-box">
    <div  class="row">
        <div class="seven columns centered">
            <h3><?php echo Yii::t('activate', 'Start using your spot right now');?></h3>
        </div>
        <a href="javascript:;" class="slide-box-close"></a>
        <div class="five columns centered">
            <div class="choose-type">
                <h6><?php echo Yii::t('activate', 'Please tell us who you are');?></h6>
                <div class="columns centered">
                    <a id="personSpot" class="radio-link six columns toggle-box toggle-box__sub" href="javascript:;"><i></i><?php echo Yii::t('activate', 'Person');?></a>
                    <a id="companySpot" class="radio-link six columns toggle-box toggle-box__sub" href="javascript:;"><i></i><?php echo Yii::t('activate', 'Company');?></a>
                </div>
            </div>
        </div>
    </div>
    <div id="personSpotForm" class="bg-gray sub-slide-box">
        <div class="row">
            <div class="five columns centered">
                <form>
                    <input class="error" type="email" placeholder="Email address">
                    <input type="password" placeholder="<?php echo Yii::t('activate', 'Password');?>">
                    <input type="password" placeholder="<?php echo Yii::t('activate', 'Confirm your password');?>">
                    <input type="text" placeholder="<?php echo Yii::t('activate', 'Spot activation code');?>">
                    <div class="toggle-active">
                        <a class="checkbox agree" href="javascript:;"><i></i><?php echo Yii::t('activate', 'I agree to Mobispot Pages Terms');?></a>
                    </div>
                    <div class="form-control">
                        <a class="spot-button" href="#"><?php echo Yii::t('activate', 'Activate spot');?></a>
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
    <div id="companySpotForm" class="bg-gray sub-slide-box">
        <div class="row">
            <div class="five columns centered">
                <form>
                    <input class="error" type="email" placeholder="Email address">
                    <input type="password" placeholder="Password">
                    <input type="password" placeholder="Confirm your password">
                    <input type="text" placeholder="Spot activation code">
                    <div class="toggle-active">
                        <a class="checkbox agree" href="javascript:;"><i></i><?php echo Yii::t('activate', 'I agree to Mobispot Pages Terms');?></a>
                    </div>
                    <div class="form-control">
                        <a class="spot-button" href="#"><?php echo Yii::t('activate', 'Activate spot');?></a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>