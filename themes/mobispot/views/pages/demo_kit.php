<?php $this->pageTitle = Yii::t('store', 'Mobispot demo-kit'); ?>
<?php $this->mainBackground = 'main-bg-w.png'?>
<?php $this->blockFooterScript = '<script src="/themes/mobispot/angular/app/controllers/demokit.js"></script>'?>

<div class="content-wrapper" ng-controller="DemokitController" >
    <div class="content-block"
        id="demo-kit-block"
        ng-init="order.token='<?php echo Yii::app()->request->csrfToken ?>'">
    <div class="row">
        <div class="large-12 columns form-block">
            <div>
                <div class="row">
                    <div class="column large-12">
                        <ul class="get-up-nav">
                            <li class="active"  ng-click="dkitForm($event, '1')"><?php echo Yii::t('store', 'Step 1: Demo-kit description')?></li>
                            <li ng-click="dkitForm($event, '2')"><?php echo Yii::t('store', 'Step 2: Delivery details')?></li>
                            <li ng-click="dkitForm($event, '3')"><?php echo Yii::t('store', 'Step 3: Payment and shipping')?></li>
                        </ul>
                    </div>
                </div>
                <?php include('block/demo_kit_desc.php'); ?>
                <?php include('block/demo_kit_customer.php'); ?>
                <?php include('block/demo_kit_shipping.php'); ?>
            </div>
        </div>
    </div>
</div>
<div class="fc"></div>
