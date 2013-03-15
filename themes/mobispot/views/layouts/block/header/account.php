<header class="header-page">
<div class="row row__head-slider">
    <div class="twelve">
        <div class="header-top">
				<div class="four columns">
					<h1 class="logo"><a href="/"><img src="/themes/mobispot/images/logo-white.png" /></a></h1>
				</div>
				<div class="eight columns">
					<ul class="nav-bar right">
						<li class="dropdown toggle-active">
							<?php $userInfo=$this->userInfo()?>
							<a class="spot-button" href="#"><?php echo $userInfo->name;?></a>
							<ul class="options">
								<li><a href="#"><?php echo Yii::t('account', 'Settings');?></a></li>
								<li><a href="#"><?php echo Yii::t('account', 'Logout');?></a></li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
		<div class="bubbles-slider">
			  <div>
				  <img src="/themes/mobispot/images/personal-cover2.png" />
				  <div class="dropdown dropdown__light change-cover">
					  <a class="spot-button" href="javascript:;"><?php echo Yii::t('sign', 'Change cover');?></a>
					  <ul class="options">
						  <li><a href="#"><?php echo Yii::t('account', 'Remove');?></a></li>
						  <li><a href="#"><?php echo Yii::t('account', 'Upload new');?></a></li>
					  </ul>
				  </div>
			  </div>
		</div>
  	</div>
</div>
</header>