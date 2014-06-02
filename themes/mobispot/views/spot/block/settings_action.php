<h4><?php echo Yii::t('spot', 'Settings')?></h4>
<div class="set-item">

    <div class="row control">
        <div class="columns large-5">
            <form class="custom">
                <input
                    ng-init="spot.name='<?php echo $spot->name; ?>'"
                    ng-model="spot.name"
                    maxlength="300"
                    ng-class="{error: error.name}"
                    ng-trim="true"
                    required
                    >
                <a class="form-button"
                    ng-click="renameSpot(spot)">
                    <?php echo Yii::t('spot', 'Rename')?>
                </a>
            </form>
        </div>
        <div class="columns large-7">
            <p><?php echo Yii::t('spot', 'Name cannot be longer than 15 symbols. <br /> May consist of Cyrillic, Latin and digits.')?></p>
        </div>
    </div>
    <div class="control control-list">
        <div class="row toggle-visible">
            <div class="columns large-4">
                <a class="red"
                    ng-click="ivisibleSpot(spot)">
                    <div ng-show="spot.status==2">
                        <i class="icon">&#xe60b;</i>
                        <span><?php echo Yii::t('spot', 'Make spot invisible')?></span>
                    </div>
                    <div ng-show="spot.status==6">
                        <i class="icon">&#xe60c;</i>
                        <span><?php echo Yii::t('spot', 'Make spot visible')?></span>
                    </div>
                </a>
            </div>
            <div class="columns left large-7">
                <p><?php echo Yii::t('spot', 'Make spot invisible/Make spot visible')?></p>
            </div>
        </div>
        <div class="row">
            <div class="columns large-3">
                <a class="red"
                    ng-click="cleanSpot(spot)">
                    <i class="icon">&#xe609;</i>
                    <span><?php echo Yii::t('spot', 'Clean spot')?></span>
                </a>
            </div>
            <div class="columns left large-7">
                <p><?php echo Yii::t('spot', 'Clean all the content from your spot.<br /> Will be impossible to restore.')?></p>
            </div>
        </div>
        <div class="row">
            <div class="columns large-3">
                <a class="red"
                    ng-click="removeSpot(spot)">
                    <i class="icon">&#xe60a;</i>
                    <span><?php echo Yii::t('spot', 'Delete spot')?></span>
                </a>
            </div>
            <div class="columns left large-7">
                <p><?php echo Yii::t('spot', 'Delete the spot from your account.<br /> Attention: Will be impossible to restore.')?></p>
            </div>
        </div>
        </div>
</div>
