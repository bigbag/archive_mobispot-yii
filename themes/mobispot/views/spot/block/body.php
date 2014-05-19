<div class="spot-content">
    <section id="spot-1" class="spot-wrapper active">
        <div class="spot-hat">
            <div class="spot-tabs">
                <a href="javascript:;" class="active" ng-click="spotBlock($event,'spot-block')"><i class="icon">&#xe600;</i>Social links</a>
                <a  href="javascript:;" ng-click="spotBlock($event,'wallet-block')"><i class="icon">&#xe006;</i>Wallet</a>
                <a href="javascript:;" ng-click="spotBlock($event,'coupon-block')"><i class="icon">&#xe601;</i>Coupon<sub>2</sub></a>
                <a href="javascript:;" title="settings" ng-click="spotBlock($event,'settings-block')" class="icon-spot-button right icon settings">&#xe00f;</a>
            </div>
        </div>
        <div class="tabs-block">
            <section class="spot-block spot-content_row tabs-item active">
                <div class="spot-item spot-main-input info-pick" ng-class="info">
                    <div class="help-layer" ng-class="info">
                        <h3>1.Делай. Или не делай. Нет места попытке.</h3>
                        <p>
                            Ходи то, делай сюда. Бла, бла, бла</p>
                    </div>
                    <a href="javascript:;" ng-click="infoShow($event) " class="icon info-button first-start">&#xe605;</a>
                    <textarea ng-model="spot.put" required></textarea>
                    <div class="text-center label-cover" ng-class="{invisible: spot.put}">
                        <h4>Drag your files here or begin to type info or links</h4>
                        <span>A maximum file size limit of 25mb for free accounts</span>
                        <div class="hat-cover"></div>
                    </div>
                    <div class="cover-fast-link" ng-click="inputFocus()">
                            <label for="addFile"  title="Add file" class="quick-input icon">&#xe604;</label>
                            <input id="addFile" type="file">
                            <a href="javascript:;" class="right form-button" ng-class="{visible: spot.put}">Post</a>
                    </div>
                </div>
                <div class="spot-item-stack info-pick">
                    <div class="stack-hat">
                    <?php include('linking.php'); ?>
                        <a href="#" class="right mobile-link"><i class="icon">&#xe010;</i>public link</a>
                    </div>
                </div>
            </section>
        </div>
    </section>
</div>