<h4>Main</h4>
<div class="set-item">

    <div class="row control">
        <div class="columns large-5">
            <form class="custom">
                <input
                    placeholder="<?php echo Yii::t('spot', 'Spot name')?>"
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
            <p>Длина не должна превышать 10 символов.<br>
                    Может содержать только: кириллицу, латиницу и цифровое значение. </p>
        </div>
    </div>
    <div class="control control-list">
        <div class="row toggle-visible">
            <div class="columns large-4">
                <a class="red"
                    ng-click="visibleSpot()">
                    <div class="c-visible">
                        <i class="icon">&#xe60b;</i>
                        <span><?php echo Yii::t('spot', 'Make spot invisible')?></span>
                    </div>
                    <div class="c-invisible">
                        <i class="icon">&#xe60c;</i>
                        <span><?php echo Yii::t('spot', 'Make spot visible')?></span>
                    </div>
                </a>
            </div>
            <div class="columns left large-7">
                <p>Открывает/Закрывает доступ к споту для просмотра в мобильном отображении</p>
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
                <p>Полностью очистить все содержимое.<br> Восстановить будет невозмоно.</p>
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
                <p>Полность удалить устройства.<br> Восстановить будет невозмоно. </p>
            </div>
        </div>
        </div>
</div>