<div class="spot-content" ng-init="spot.status=<?php echo $spot->status; ?>">
    <section class="spot-wrapper active">
        <div class="spot-hat">
            <?php include('block/menu.php'); ?>
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
                        <div id="noteHolder">
                        <h4>
                            <?php echo Yii::t('spot', 'Type the text and links or drag your files here') ?>
                        </h4>
                        <span>
                            <?php echo Yii::t('spot', 'Maximum file size cannot be greater than 25mb') ?>
                        </span>
                        </div>
                        <div id="socLinkHolder" class="hide">
                            <h4></h4>
                        </div>                      
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
                        <a ng-click="addContent()"
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
                    <?php include('block/linking_socnet.php'); ?>
                    <a onclick="window.open('/<?php echo $spot->url; ?>', 'Страницы компании', 'width=550, height=350, status=no, resizable=yes, top=200, left=200'); return false;"
                        href="/<?php echo $spot->url; ?>"
                        target="_blank"
                        class="right mobile-link">
                            <i class="icon">&#xe010;</i>
                            <?php echo Yii::t('spot', "Spot's URL")?>
                            </a>
                    </div>
                </div>
                <?php if (!empty($spotContent->content)): ?>
                    <?php $content = $spotContent->content ?>
                    <?php if (isset($content['data']) and isset($content['keys'])): ?>
                        <?php $keys = (isset($content['keys']) ? array_keys($content['keys']) : array()) ?>
                        <?php $keys = '[' . implode(',', $keys) . ']'; ?>

                        <span ng-init="spot.keys=<?php echo $keys; ?>"></span>
                        <div ui-sortable="sortableOptions" ng-model="spot.keys" id="add-content">
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
