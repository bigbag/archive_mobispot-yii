<ul class="spot-hat-button">
    <li>
        <a data-tooltip title=" <?php echo Yii::t('spots', 'Settings'); ?>" id="j-settings"class="tip-top icon-spot-button right text-center settings-button icon" href="javascript:;">&#xe00f;</a>
    </li>
</ul>
<div class="spot-content slide-content" ng-init="spot.status='<?php echo $spot->status; ?>'">
    <?php if (!empty($spotContent->content)): ?>
        <?php $content = $spotContent->content ?>

        <?php if (isset($content['data']) and isset($content['keys'])): ?>

            <?php $keys = (isset($content['keys']) ? array_keys($content['keys']) : array()) ?>
            <?php $keys = '[' . implode(',', $keys) . ']'; ?>

            <span ng-init="spot.vcard=<?php echo $content['vcard']; ?>; spot.private=<?php echo $content['private']; ?>; keys=<?php echo $keys; ?>;"></span>

            <div ui-sortable="sortableOptions" ng-model="keys" id="add-content">
                <?php foreach ($content['keys'] as $key => $type): ?>
                    <?php $value = $content['data'][$key]; ?>
                        <?php echo $this->renderPartial('/widget/spot/personal/new_' . $type,
                            array(
                                'key' => $key,
                                'content' => $value,

                                )
                            );
                        ?>
                <?php endforeach; ?>
            </div>
            <div id="progress-content" class="spot-item">
                <div class="item-area type-progress">
                    <div class="progress-bar">
                        <div class="meter" ng-style="{'width': progress+'%'}">{{progress}}%</div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    <?php else: ?>
        <span ng-init="spot.vcard=0; spot.private=0"></span>
    <?php endif; ?>


    <div class="spot-content_row">
        <div id="error-upload" class="spot-item">
            <div class="item-area text-center type-error">
                <h1><?php echo Yii::t('spot', 'Error') ?></h1>
                <h4><?php echo Yii::t('spot', 'There was an error when attempting to upload this file') ?></h4>
                <h4><?php echo Yii::t('spot', 'Please try again') ?></a></h4>
            </div>
        </div>
        <div id="dropbox" class="spot-item" ng-init="spot.discodes=<?php echo $spot->discodes_id ?>">
            <textarea ng-model="spot.content" ui-keypress="{enter: 'addContent(spot)'}">

            </textarea>
            <label class="text-center label-cover">
                <h4><?php echo Yii::t('spot', 'Drag your files here or begin to type info or links') ?></h4>
                <span>
                    <?php echo Yii::t('spot', 'You can store up to 25 MB inside one spot') ?>
                    <br />
                    <?php echo Yii::t('spot', 'Use Ctrl+enter for a new paragraph') ?>
                </span>
            </label>
        </div>
    </div>
</div>