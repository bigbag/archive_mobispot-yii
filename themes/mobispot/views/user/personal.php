<div class="row">
    <div class="twelve columns spot-desc">
        <h3 class="color">Welcome back. Ready to make a change?</h3>

        <p>Your spots are listed below. Click on the spot name you want to edit.
            When it opens, you can change whatever you want.</p>

        <p>How much you share is up to you.</p>
    </li>
    </div>
</div>

<?php $message = (isset($message[1]))?$message:0;?>
<div 
    class="row"
    ng-init="defOpen(<?php echo $open_spot_id;?>);setModal('<?php echo $message ;?>', 'none')">
    <div class="twelve columns">
        <?php
        $this->widget('MListView', array(
            'dataProvider' => $dataProvider,
            'itemView' => 'block/spots',
            'itemsTagName' => 'ul',
            'itemsCssClass' => 'spot-list',
            'enableSorting' => false,
            'template' => '{items} {pager}',
            'cssFile' => false,
            'id' => 'spotslistview',
        ));
        ?>
    </div>
</div>
<div class="row">
  <div class="twelve columns text-center toggle-active">
    <a href="#actSpotForm" id="actSpot" class="add-spot toggle-box button round slideToThis">
      <i class="icon">&#xe015;</i>
      <span class="m-tooltip m-tooltip-open">
        <?php echo Yii::t('spot', 'Add another spot') ?>
      </span>
      <span class="m-tooltip m-tooltip-close">
        <?php echo Yii::t('wallet', 'Close form')?>
      </span>
    </a>
  </div>
</div>
<div id="actSpotForm" class="slide-box add-spot-box">
    <div class="row popup-content">
        <div class="six columns centered">
            <form id="add-spot" name="addSpotForm">
                <input type="text"
                       ng-model="spot.code"
                       name="code"
                       placeholder="<?php echo Yii::t('spot', 'Spot activation code') ?>"
                       autocomplete="off"
                       maxlength="10"
                       required>
                <input type="text"
                       name="name"
                       ng-model="spot.name"
                       placeholder="<?php echo Yii::t('spot', 'Spot name') ?>"
                       autocomplete="off">
                <div class="form-row toggle-active">
                    <a class="checkbox agree"  ng-click="setTerms(spot)">
                        <i></i>
                        <?php echo Yii::t('spot', 'I agree to Mobispot Pages Terms') ?>
                    </a>
                </div>
                <div class="form-control">
                    <a class="spot-button button-disable"  ng-click="addSpot(spot)"><?php echo Yii::t('spot', 'Load a new spot') ?></a>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="spot-edit" class="spot-item hide spot-main-input">
    <textarea
        rows="2" cols="2"
        ng-keypress="($event.keyCode == 13)?saveContent(spot, $event):''"
        ng-model="spot.content_new"
        ui-event="{ blur : 'hideSpotEdit()' }">
    </textarea>
</div>

<div class="popup slow bg-gray hide">
    <div class="row popup-content content-settings">
        <div class="twelve columns">
            <ul class="add-active settings-list">
                <li id="renameSpot" class="toggle-box spot-action"  ng-click="actionSpot(spot, $event)">
                    <?php echo Yii::t('spot', 'Rename spot') ?>
                </li>
                <div class="sub-content rename-spot" id="renameSpotForm">
                    <div class="sub-content-container">
                        <form name="renameSpotForm">
                        <input
                            type="text"
                            class="b-short-input"
                            ng-model="spot.newName"
                            name="newName"
                            ui-keypress="{enter: 'setNewName(spot)'}"
                            placeholder="<?php echo Yii::t('spot', 'New Name') ?>"
                            autocomplete="off"
                            maxlength="50"
                            required>
                        <a  ng-click="setNewName(spot)" class="spot-button">
                        <?php echo Yii::t('spot', 'Save') ?>
                        </a>
                    </form>
                    </div>
                </div>

                <li id="setPass" class="toggle-box spot-action"  ng-click="actionSpot(spot, $event)">
                    <?php echo Yii::t('spot', 'Set password') ?>
                </li>
                <div class="sub-content rename-spot" id="setPassForm">
                    <div class="sub-content-container">
                        <form name="setPassForm">
                        <p><?php echo Yii::t('spot', "Create a 4-digit password to protect your spot's content. Tell this password only to trusted people.") ?></p>
                        <input
                            type="text"
                            class="b-short-input"
                            ng-model="spot.pass"
                            name="newPass"
                            ui-keypress="{enter: 'setNewPass(spot)'}"
                            ng-change="savePassButtonText('<?php echo Yii::t('spot', 'Save') ?>');"
                            placeholder="<?php echo Yii::t('spot', 'New Password') ?>"
                            autocomplete="off"
                            maxlength="4"
                            required>
                        <a id="savePassButton"  ng-click="setNewPass(spot)" class="spot-button">
                        <?php echo Yii::t('spot', 'Save') ?>
                        </a>
                        <a id="resetPassButton"  ng-click="resetPass(spot)" class="spot-button">
                        <?php echo Yii::t('spot', 'Reset Password') ?>
                        </a>
                    </form>
                    </div>
                </div>
                
                <li id="invisibleSpot" class="toggle-box spot-action" ng-click="actionSpot(spot, $event)" ng-show="spot.invisible">
                    <?php echo Yii::t('spot', 'Make spot invisible') ?>
                </li>
                <div class="sub-content confirm" id="invisibleSpotForm">
                    <div class="sub-content-container">
                        <h4><?php echo Yii::t('spot', 'Continue?') ?></h4>
                        <p>
                            <?php echo Yii::t('spot', 'Hide the content of your spot from other people. When they tap it with phone they will see page 404') ?>
                        </p>
                    </div>
                    <a class="button round"  ng-click="confirmYes(spot)">
                        <?php echo Yii::t('spot', 'Yes') ?>
                    </a>
                    <a class="button round active"  ng-click="confirmNo(spot)">
                        <?php echo Yii::t('spot', 'No') ?>
                    </a>
                </div>

                <li id="visibleSpot" class="toggle-box spot-action" ng-click="actionSpot(spot, $event)" ng-hide="spot.invisible">
                    <?php echo Yii::t('spot', 'Make spot visible') ?>
                </li>
                <div class="sub-content confirm" id="visibleSpotForm">
                    <div class="sub-content-container">
                        <h4><?php echo Yii::t('spot', 'Continue?') ?></h4>
                        <p>
                            <?php echo Yii::t('spot', "Bring back your spot's content to your friends") ?>
                        </p>
                    </div>
                    <a class="button round"  ng-click="confirmYes(spot)">
                        <?php echo Yii::t('spot', 'Yes') ?>
                    </a>
                    <a class="button round active"  ng-click="confirmNo(spot)">
                        <?php echo Yii::t('spot', 'No') ?>
                    </a>
                </div>

                <li id="cleanSpot" class="toggle-box spot-action" ng-click="actionSpot(spot, $event)">
                    <?php echo Yii::t('spot', 'Clean spot') ?>
                </li>
                <div class="sub-content confirm" id="cleanSpotForm">
                    <div class="sub-content-container">
                        <h4><?php echo Yii::t('spot', 'Are you sure?') ?></h4>
                        <p>
                            <?php echo Yii::t('spot', 'Erase all the content of your spot with one click. You will not be able to cancel this action.') ?>
                        </p>
                    </div>
                    <a class="button round"  ng-click="confirmYes(spot)">
                        <?php echo Yii::t('spot', 'Yes') ?>
                    </a>
                    <a class="button round active"  ng-click="confirmNo(spot)">
                        <?php echo Yii::t('spot', 'No') ?>
                    </a>
                </div>

                <li id="deleteSpot" class="toggle-box spot-action" ng-click="actionSpot(spot, $event)">
                    <?php echo Yii::t('spot', 'Delete your spot') ?>
                </li>
                <div class="sub-content confirm" id="deleteSpotForm">
                    <div class="sub-content-container">
                        <h4><?php echo Yii::t('spot', 'Are you sure?') ?></h4>
                        <p>
                            <?php echo Yii::t('spot', 'Make your spot disappear forever from your personal account. You will not be able to cancel this action or to re-store your spot.') ?>
                        </p>
                    </div>
                    <a class="button round"  ng-click="confirmYes(spot)">
                        <?php echo Yii::t('spot', 'Yes') ?>
                    </a>
                    <a class="button round active"  ng-click="confirmNo(spot)">
                        <?php echo Yii::t('spot', 'No') ?>
                    </a>
                </div>
            </ul>
        </div>
    </div>
</div>