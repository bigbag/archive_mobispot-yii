<div class="spot-content">
    <section class="spot-wrapper active">
        <div class="spot-hat">
            <div class="spot-tabs">
                <a class="active"
                    ng-click="general.views='spot'"
                    ng-class="{active: general.views=='spot'}">
                    <i class="icon">&#xe600;</i>
                    <?php echo Yii::t('spot', 'Social links')?>
                </a>
                <?php if ($wallet and $spot->type == Spot::TYPE_FULL):?>
                <a ng-click="general.views='wallet'"
                    ng-class="{active: general.views=='wallet'}">
                    <i class="icon">&#xe006;</i>
                    <?php echo Yii::t('spot', 'Wallet')?>
                </a>
                <a ng-click="general.views='coupon'"
                    ng-class="{active: general.views=='coupon'}">
                    <i class="icon">&#xe601;</i>
                    <?php echo Yii::t('spot', 'Coupon')?>
                </a>
                <?php endif;?>
                <a href="javascript:;"
                    title="settings"
                    ng-click="spotBlock($event,'settings-block')"
                    class="icon-spot-button right icon settings">&#xe00f;
                </a>
            </div>
        </div>
        <div class="tabs-block">
            <section class="spot-block spot-content_row tabs-item active">
                <div id="dropbox"
                    class="spot-item spot-main-input info-pick">
                    <textarea id=""
                        ng-model="spot.content"
                        ng-init="getSocPatterns()"
                        ng-change="changeContent()"
                        ng-trim="true">
                    </textarea>
                    <div class="text-center label-cover" ng-class="{invisible: spot.content}">
                        <h4>
                            <?php echo Yii::t('spot', 'Drag your files here or begin to type info or links') ?>
                        </h4>
                        <span>
                            <?php echo Yii::t('spot', 'A maximum file size limit of 25mb for free accounts') ?>
                        </span>
                        <div class="hat-cover"></div>
                    </div>
                    <div class="cover-fast-link">
                        <label
                            for="add-file"
                            title="<?php echo Yii::t('spot', 'Add file')?>"
                            class="quick-input icon">
                            &#xe604;
                        </label>
                        <input id="add-file" type="file">
                        <a ng-click="addContent(spot)"
                            class="right form-button"
                            ng-class="{visible: spot.content}">
                            <?php echo Yii::t('spot', 'Post')?>
                        </a>
                    </div>
                </div>
                <div id="error-upload" class="hide spot-item">
                    <div class="item-area text-center type-error">
                        <h4 class="color"><?php echo Yii::t('spot', 'Oops!') ?></h4>
                        <h4><?php echo Yii::t('spot', 'There was an error when attempting to upload this file<br/>Please try again') ?></h4>
                    </div>
                </div>
                <div id="progress-content" class="hide spot-item">
                    <div class="item-area type-progress">
                        <div class="progress-bar">
                            <div class="meter" ng-style="{'width': progress+'%'}">{{progress}}%</div>
                        </div>
                    </div>
                </div>
                <div class="spot-item-stack info-pick">
                    <div class="stack-hat">
                    <?php include('block/linking.php'); ?>
                        <a href="#" class="right mobile-link">
                            <i class="icon">&#xe010;</i>
                            <?php echo Yii::t('spot', 'public link')?>
                            </a>
                    </div>
                </div>
                <?php if (!empty($spotContent->content)): ?>
                    <?php $content = $spotContent->content ?>
                    <?php if (isset($content['data']) and isset($content['keys'])): ?>
                        <?php $keys = (isset($content['keys']) ? array_keys($content['keys']) : array()) ?>
                        <?php $keys = '[' . implode(',', $keys) . ']'; ?>

                        <div ui-sortable="sortableOptions" ng-model="keys" id="add-content">
                        <?php foreach ($content_keys as $key => $type): ?>
                            <?php $value = $content['data'][$key]; ?>
                                <?php echo $this->renderPartial('/spot/personal/new_' . $type,
                                    array(
                                        'key' => $key,
                                        'content' => $value,
                                        )
                                    );
                                ?>
                        <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </section>
        </div>
    </section>
</div>
