<div class="row" ng-controller="PaymentController" ng-init="payment.token='<?php echo Yii::app()->request->csrfToken;?>'; user.token='<?php echo Yii::app()->request->csrfToken;?>'">
	<div class="columns twelve">
		<ul class="spot-list so-awesome" id="numero1">
		<li>
		<div id="spot03" class="spot-hat toggle-box" style="display:none">
			<h3>
				
			</h3>
			<ul class="spot-hat-button nav-bar">
            <?php /*
				<!--<li>
					<div>
						<a data-tooltip title="Wallet" id="j-wallet" class="tip-top wallet-button b-negative b-positive toggle-box right text-center" href="javascript:;">134$</a>
					</div>
				</li>-->
				<li>
					<div>
						<a data-tooltip title="Settings" id="j-settings" class="tip-top icon-spot-button right text-center toggle-box icon" href="javascript:;">&#xe00f;</a>
					</div>
				</li>
                */ ?>
			</ul>
		</div>

		<div id="spot03Form" class="spot-content slide-content" style="display:block">
        <?php /*
		<div id="j-settingsForm" class="settings-block slide-content slide-box">
			<div class="m-set-content" ng-controller="spotCtrl">
				<div class="row">

						<h2>Settings</h2>

					<div class="two column">
						<ul class="settings-nav">
							<li id="mainSet" ng-click="spotSet($event)" class="active setLink">Spot</li>
							<li id="smsSet" ng-click="spotSet($event)" class="setLink" >SMS-инф.</li>
						</ul>
					</div>
					<div id="mainSetBlock" class="ten column settings-block">
						<div class="row">
							<div class="column five">
								<input type="text" value="New spot">
							</div>
							<div class="left">
								<a href="#" class="spot-button">Rename</a>
							</div>
						</div>
						<div class="row toggle-active">
							<a class="checkbox agree" href="javascript:;">
								<i class="large"></i>
								Make spot invisible
							</a>
						</div>
						<div class="row sub-control">
							<a href="#" class="spot-button spot-button-red">Clean spot</a>
							<a href="#" class="spot-button spot-button-red">Delete spot</a>
							<a href="#" class="spot-button">Censel</a>
						</div>
					</div>
					<div id="smsSetBlock" class="ten column settings-block hide">
						<div class="toggle-active">
							<a href="javascript:;" class="checkbox checkbox-h agree">
								<i class="large"></i>
								<h3> SMS информирование</h3>
							</a>
							<div class="settings-item_form active-sub">
								<p class="set-description">Смс информирование включается для всех кошельков сразу. Смс пока высылается только в том случае когда баланс любой карты меньше 40 руб.</p>
								<div class="condition condition01"  ng-show="myValue">
									<input ng-model="number" type="text" placeholder="Номер телефона">
									<a id="smsForm" href="#" class="spot-button popup-button" ng-click="startTimer()">Сохранить</a>

									<div class="toggle-active">
										<a href="javascript:;" class="checkbox agree">
											<i class="large"></i>
											<span> Включить и для все остальных кошельков</span>
										</a>
									</div>
								</div>
								<div class="condition condition__number condition02" ng-hide="myValue">
									<h3>Смс оповещение включено для номера:</h3>
									<p>{{number}}</p><a href="#" class="spot-button red-button" ng-click="resetNumber()">Отменить</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div id="j-walletForm" class="settings-block slide-content slide-box">
			<div class="row content-payment m-set-content content-wallet">
				<div>
					<div id="setPayment" class="row popup-row">
						<div>
							<div class="item-area item-area_w clearfix">
								<div class="row">
									<div class="eight columns">
										<h3>Состояние счета
										<span class="b-account b-negative b-positive">
										  3402 руб.
										</span>
										</h3>
									</div>
									<div class="twelve left columns">
										<form name="paymentForm" class="custom item-area__right clearfix ng-pristine ng-invalid ng-invalid-required" action="https://test.wpay.uniteller.ru/pay/">
											<input id="unitell_shop_id" type="hidden" name="Shop_IDP" value="">
											<input id="unitell_customer" type="hidden" name="Customer_IDP" value="">
											<input id="unitell_order_id" type="hidden" name="Order_IDP" value="">
											<input id="unitell_subtotal" type="hidden" name="Subtotal_P" value="">
											<input id="unitell_signature" type="hidden" name="Signature" value="">
											<input id="unitell_url_ok" type="hidden" name="URL_RETURN_OK" value="">
											<input id="unitell_url_no" type="hidden" name="URL_RETURN_NO" value="">
											<div class="row">
												<div class="twelve columns">
													<label for="payment">Введите сумму от 100 до 1000 руб.</label>
												</div>
											</div>
											<div class="row form-line">
												<div class="four columns">
													<input id="payment" type="text" ng-pattern="/[0-9]+/" ng-model="payment.summ" placeholder="100" maxlength="50" required="" class="ng-pristine ng-invalid ng-invalid-required ng-valid-pattern b-pay-input"><span class="right b-currency">руб.</span>
												</div>
												<div class="three left columns">
													<a class="spot-button button-disable text-center" href="javascript:;" ng-click="addSumm(payment, $event)">Пополнить</a><br>
												</div>
												<span id="j-rules" class="payment-rules settings-button right">Условия использования</span>

											</div>
										</form>
									</div>
									<a class="b-systems" href="#"><img src="images/mps.png"></a>
								</div>
								<div class="row">
									<div class="m-auto-payment">
										<div class="twelve columns">
											<a id="j-auto-payment" href="javascript:;" class="radio-link radio-link_on-item-area toggle-box toggle-box__sub"><i class="large"></i>
												<h3>Автоплатежи</h3>
											</a>
											<p class="sub-txt sub-txt-last">
												*Включая автоплатежи вы соглашаетесь,
												что баланс кампусной карты "Мобиспот" будет автоматически пополняться при остатке менее 100 руб.
												Для пополнения будет использована банковская карта по которой вы последний раз совершали пополнение.
											</p>
										</div>
										<div id="j-auto-paymentForm" class="twelve left olumns sub-slide-box">
											<form class="item-area__right">
												<div class="clearfix">
													<div class="twelve columns">
														<label for="auto-payment">Введите сумму автопополнения</label>
													</div>
												</div>
												<div class="clearfix form-line">
													<div class="four columns">
														<input id="auto-payment" type="text" ng-pattern="/[0-9]+/" ng-model="payment.summ" placeholder="100" maxlength="50" required="" class="ng-pristine ng-invalid ng-invalid-required ng-valid-pattern b-pay-input"><span class="right b-currency">руб.</span>
													</div>
													<div class="three left columns">
														<a class="spot-button button-disable text-center" href="javascript:;" ng-click="addSumm(payment, $event)">Принять</a><br>
													</div>
												</div>
											</form>
											<div class="m-card-block">
												<h5>Автоплатеж будет производится с карты:</h5>
												<div class="m-card-cur m-card_visa">
													<div>Карта: <span class="m-card-info">xxxx xxxx xxxx 1234</span></div>
													<div>Дата подключения: <span class="m-card-info">12.04.2013</span></div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row popup-row">
						<div class="twelve">
							<div class="item-area  item-area_w  item-area_table">
								<h3>Последние операции</h3>
								<div class="m-table-wrapper">
									<table class="m-spot-table" ng-grid="gridOptions">
										<thead>
										<tr>
											<th><div></sia><span>Дата и время</span></div></th>
											<th><div><span>Место</span></div></th>
											<th><div><span>Сумма</span></div></th>
										</tr>
										</thead>
										<tbody>
										<tr>
											<td><div>12.10.2013, 20:00</div></td>
											<td><div>Uilliam’s</div></td>
											<td><div>50$</div></td>
										</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
        */ ?>
		<div class="spot-tabs" style="height:0px">
        <?php /*
			<a href="/user/personal" class="active">Spot list<i class="icon">&#xe600;</i></a>
			<a href="#wallet-block">Wallet<i class="icon">&#xe006;</i></a>
			<a href="#wallet-block2">Coupons<i class="icon">&#xe601;</i></a>
        */ ?>
		</div>
        <?php /*
		<div class="tabs-block">
		<div id="spot-block" class="spot-content_row tabs-item active">
		<div class="spot-item spot-main-input">
			<textarea></textarea>
			<div class="text-center label-cover">
				<h4>Drag your files here or begin to type info or links</h4>
				<span>A maximum file size limit of 25mb for free accounts</span>
				<div class="cover-fast-link">
					<label for="add-file" data-tooltip title="Add file"  class="icon tip-left">&#xe00e;</label>
					<a data-tooltip href="javascripts:;" title="Add links and social accounts" id="extraMedia" class="tip-right icon toggle-box">&#xe005;</a>
					<input id="add-file" type="file">
				</div>
				<div class="hat-cover"></div>
			</div>

			<div id="extraMediaForm" class="spot-sub-slide slide-content">
				<a data-tooltip title="Facebook" class="tip-top" href="#"><img width="36" src="socialmediaicons/facebook.png"> </a>
				<a data-tooltip title="Flickr" class="tip-top" href="#"><img width="36" src="socialmediaicons/flickr.png"> </a>
				<a data-tooltip title="Behance" class="tip-top" href="#"><img width="36" src="socialmediaicons/behance.png"> </a>
				<a data-tooltip title="Vimeo" class="tip-top" href="#"><img width="36" src="socialmediaicons/vimeo.png"> </a>
				<a data-tooltip title="LinkEdin" class="tip-top" href="#"><img width="36" src="socialmediaicons/linkedin.png"> </a>
				<a data-tooltip title="LastFM" class="tip-top" href="#"><img width="36" src="socialmediaicons/lastfm.png"> </a>
				<a data-tooltip title="MySpace" class="tip-top" href="#"><img width="36" src="socialmediaicons/myspace.png"> </a>
				<a data-tooltip title="tumblr" class="tip-top" href="#"><img width="36" src="socialmediaicons/tumblr.png"> </a>
				<a data-tooltip title="YouTube" class="tip-top" href="#"><img width="36" src="socialmediaicons/youtube.png"> </a>
				<a data-tooltip title="Twitter" class="tip-top" href="#"><img width="36" src="socialmediaicons/twitter.png"> </a>
				<a data-tooltip title="Google+" class="tip-top" href="#"><img width="36" src="socialmediaicons/google.png"> </a>
				<a data-tooltip title="VKontakte" class="tip-top" href="#"><img width="36" src="socialmediaicons/vk.png"> </a>
				<a data-tooltip title="Instagram" class="tip-top" href="#"><img width="36" src="socialmediaicons/instagram.png"> </a>
				<a data-tooltip title="Pinterest" class="tip-top" href="#"><img width="36" src="socialmediaicons/pinterest.png"> </a>
				<a data-tooltip title="DeviantART" class="tip-top" href="#"><img width="36" src="socialmediaicons/deviantart.png"> </a>
				<a data-tooltip title="Foursquare" class="tip-top" href="#"><img width="36" src="socialmediaicons/foursquare.png"> </a>
				<a data-tooltip title="CrunchBase" class="tip-top" href="#"><img width="36" src="socialmediaicons/crunchbase.png"> </a>
			</div>
		</div>
		<div class="spot-item-stack">
		<div class="spot-item">
			<div class="item-area type-progress">
				<div class="progress-bar">
					<div class="meter" style="width: 50%">50%</div>
				</div>
			</div>
		</div>
		<div class="spot-item">
			<div class="item-area text-center type-error">
				<h4 class="color">Oops!</h4>
				<h4>There was an error when attempting to upload this file</h4>
				<h4>Please try <a href="#">again</a></h4>
			</div>
		</div>
		<div class="spot-item item-area">
			<p class=" item-type__text">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.</p>
			<div class="spot-cover slow">
				<div class="spot-activity">
					<a class="button round" href="javascripts:;">&#xe003;</a>
					<a class="button round" href="javascripts:;">&#xe005;</a>
					<a class="button round" href="javascripts:;">&#xe009;</a>
					<a class="button round" href="javascripts:;">&#xe00b;</a>
				</div>
				<div class="move-spot"><i></i><span>Move your text</span></div>
			</div>
		</div>

		<div class="spot-item item-area">
			<div class="type-mess text-center">
				<img src="images/spot-file.png">
			</div>
			<div class="spot-cover slow">
				<div class="spot-activity">
					<a class="button round" href="javascripts:;">&#xe003;</a>
					<a class="button round" href="javascripts:;">&#xe005;</a>
					<a class="button round" href="javascripts:;">&#xe009;</a>
					<a class="button round" href="javascripts:;">&#xe00b;</a>
				</div>
				<div class="move-spot"><i></i><span>Move your image</span></div>
			</div>
		</div>
		<div class="spot-item">
			<div class="item-area type-itembox">
				<div class="item-head">
					<a href="#" class="type-link">
						<img class="soc-icon" src="socialmediaicons/facebook.png" height="36"> <span class="link">facebook.com/mobispot.campus</span>
					</a>
				</div>
				<div class="type-mess item-body">
					<div class="item-user-avatar"><img width="50" height="50" src="https://fbcdn-profile-a.akamaihd.net/hprofile-ak-ash3/c0.26.180.180/s160x160/547806_230431453766593_16910993_a.png" ></div>
					<div class="mess-body">
						<div class="author-row"><a class="authot-name" href="#">Mobispot. Campus solutions</a><span class="sub-line">поделился(лась) ссылкой.</span></div>
						<p>Mobispot is serving E-payments conference on Sep 3. Don't forget to tap your coffee card with an NFC phone!</p>

						<a href="#" class="thumbnail">
							<img src="http://external.ak.fbcdn.net/safe_image.php?d=AQAKN2G0x7QArx_X&amp;w=154&amp;h=154&amp;url=http%3A%2F%2Fwww.comnews-conferences.ru%2Fimages%2Fstories%2Frus%2FMF2013%2F03.jpg">
							<h4>RUS_MB2013_инфо</h4>
							<span class="sub-txt">www.comnews-conferences.ru</span>
							<p>COMNEWS при поддержке Ассоциации «Электронные Деньги» проводит Практическую конференцию «E-payments Russia 2013 - электронные платежные системы, мобильные платежи и сервисы в России», которая состоится 3 сентября 2013 года в гостинице "Ренессанс Москва Олимпик".</p>
						</a>

						<footer>
							<span>последний пост 50 мин. назад </span>
						</footer>
					</div>
				</div>
				<div class="spot-cover slow">
					<div class="spot-activity">
						<a class="button round" href="javascripts:;">&#xe003;</a>
						<a class="button round" href="javascripts:;">&#xe005;</a>
						<a class="button round" href="javascripts:;">&#xe009;</a>
						<a class="button round" href="javascripts:;">&#xe00b;</a>
					</div>
					<div class="move-spot"><i></i><span>Move your link</span></div>
				</div>
			</div>
		</div>
		<div class="spot-item">
			<div class="item-area type-itembox">
				<div class="item-head">
					<a href="#" class="type-link">
						<img class="soc-icon" src="socialmediaicons/facebook.png" height="36"> <span class="link">facebook.com/mobispot.campus</span>
					</a>
				</div>
				<div class="spot-cover slow">
					<div class="spot-activity">
						<a class="button round" href="javascripts:;">&#xe003;</a>
						<a class="button round" href="javascripts:;">&#xe005;</a>
						<a class="button round" href="javascripts:;">&#xe009;</a>
						<a class="button round" href="javascripts:;">&#xe00b;</a>
					</div>
					<div class="move-spot"><i></i><span>Move your link</span></div>
				</div>
			</div>
		</div>
		<div class="spot-item">
			<div class="item-area type-itembox">
				<div class="item-head">
					<a href="#" class="type-link">
						<span class="link">http://icomoon.io/app/#font</span>
					</a>
				</div>
				<div class="spot-cover slow">
					<div class="spot-activity">
						<a class="button round" href="javascripts:;">&#xe003;</a>
						<a class="button round" href="javascripts:;">&#xe005;</a>
						<a class="button round" href="javascripts:;">&#xe009;</a>
						<a class="button round" href="javascripts:;">&#xe00b;</a>
					</div>
					<div class="move-spot"><i></i><span>Move your link</span></div>
				</div>
			</div>
		</div>
		<div class="spot-item">
			<div class="item-area type-itembox">
				<div class="item-head">
					<a href="#" class="type-link">
						<img class="file-icon" src="images/icons/i-files.2x.png" height="36"> <span class="link">Presentation Mobispot.pdf </span>
					</a>
				</div>

				<div class="item-body item-download">
					<table class="j-list">
						<tr>
							<td><span>Тип</span></td>
							<td>PDF</td>
						</tr>
						<tr>
							<td><span>Описание</span></td>
							<td>Текстовый контент</td>
						</tr>
						<tr>
							<td><span>Размер</span></td>
							<td>25mb</td>
						</tr>
					</table>
				</div>
				<div class="spot-cover slow">
					<div class="spot-activity">
						<a class="button round" href="javascripts:;">&#xe003;</a>
						<a class="button round" href="javascripts:;">&#xe005;</a>
						<a class="button round" href="javascripts:;">&#xe009;</a>
						<a class="button round" href="javascripts:;">&#xe00b;</a>
					</div>
					<div class="move-spot"><i></i><span>Move your file</span></div>
				</div>
			</div>
		</div>
		<div class="spot-item spot-item_twi">
			<div class="item-area type-itembox">
				<div class="item-head">
					<a href="#" class="type-link">
						<img class="soc-icon" src="socialmediaicons/twitter.png" height="36"> <span class="link">twitter.com/author_name</span>
					</a>
				</div>
				<div class="type-mess item-body">
					<div class="item-user-avatar"><img width="50" height="50" src="images/avatar.png"></div>
					<div class="mess-body">
						<div class="author-row"><a class="authot-name" href="#">Author Name</a>
							<a class="user-name sub-line" href="#">@username</a>
						</div>
						<p>
							Tweet text must be displayed on a line below the author’s name and <a class="color" href="#">@username</a>, and may not be altered or modified in any way except as outlined in these requirements.
							<a class="color" href="https://dev.twitter.com/terms/display-requirements">https://dev.twitter.com/terms/display-requirements</a>
						</p>
						<footer>
							<div class="left timestamp">3:00 PM - 31 May 12</div>
						</footer>
					</div>
				</div>
				<div class="spot-cover slow">
					<div class="spot-activity">
						<a class="button round" href="javascripts:;">&#xe003;</a>
						<a class="button round" href="javascripts:;">&#xe005;</a>
						<a class="button round" href="javascripts:;">&#xe009;</a>
						<a class="button round" href="javascripts:;">&#xe00b;</a>
					</div>
					<div class="move-spot"><i></i><span>Move your link</span></div>
				</div>
			</div>
		</div>
		<div class="spot-item">
			<div class="item-area type-itembox">
				<div class="item-head">
					<a href="#" class="type-link">
						<img class="soc-icon" src="socialmediaicons/instagram.png" height="36"><span class="link">instagram.com/katya_fug</span>
					</a>
				</div>
				<div class="type-mess item-body">
					<div class="item-user-avatar"><img width="50" height="50" src="images/avatar.png"></div>
					<div class="mess-body">
						<div class="author-row">
							<a class="authot-name" href="#">katya_fug</a>
							<b class="time">15 ч. назад</b>
							<div class="sub-line">
								<span class="icon">&#xe01b;</span>St. Petersburg, Krestovskiy Island...
							</div>
						</div>
						<div class="ins-block">
							<img src="images/inst.jpg">
							<div class="likes-block"><a class="authot-name" href="#">yuri_kuznetsov</a>, <a class="authot-name" href="#">alejestem</a> and <b>13</b> others like this.</div>
							<div class="comments">
								<img width="24" src="images/avatar.png"> <a class="authot-name" href="#">katya_fug</a> асфальт!
							</div>
						</div>
					</div>
				</div>
				<div class="spot-cover slow">
					<div class="spot-activity">
						<a class="button round" href="javascripts:;">&#xe003;</a>
						<a class="button round" href="javascripts:;">&#xe005;</a>
						<a class="button round" href="javascripts:;">&#xe009;</a>
						<a class="button round" href="javascripts:;">&#xe00b;</a>
					</div>
					<div class="move-spot"><i></i><span>Move your link</span></div>
				</div>
			</div>
		</div>
		<div class="spot-item ">
			<div class="item-area type-itembox">
				<div class="item-head">
					<a href="#" class="type-link">
						<img class="soc-icon" src="socialmediaicons/vimeo.png" height="36"><span class="link">vimeo.com/33382554</span>
					</a>
				</div>
				<div class="type-mess item-body">
					<div class="item-user-avatar"><img width="50" height="50" src="http://www.gravatar.com/avatar/600e975e56182df0974cc62e1da8b39e?d=http%3A%2F%2Fb.vimeocdn.com%2Fimages_v6%2Fportraits%2Fportrait_75_green.png&s=75"></div>
					<div class="mess-body">
						<div class="author-row">
							<h3><a class="color" href="http://vimeo.com/33382554">Temps Bourg 2011 - Cie Transe Express "Lâcher de violons"</a></h3>
							<span class="sub-line"> from <a href="http://vimeo.com/user2956232">Anne Flageul</a> on <a href="http://vimeo.com">Vimeo</a> </span>
						</div>
						<iframe id="vimeo_11" src="http://player.vimeo.com/video/33382554" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
						<footer>
							<span>102 345 просмотров</span>
						</footer>
						<script type="text/javascript">
							$(document).ready(function(){
								$('#vimeo_11').width($('body').width()-146);
								$('#vimeo_11').height(($('body').width()-146)/1.3333333333333);
							});
							$(window).resize(function(){
								$('#vimeo_11').width($('body').width()-146);
								$('#vimeo_11').height(($('body').width()-146)/1.3333333333333);
							});
						</script>
					</div>
				</div>
				<div class="spot-cover slow">
					<div class="spot-activity">
						<a class="button round" href="javascripts:;">&#xe003;</a>
						<a class="button round" href="javascripts:;">&#xe005;</a>
						<a class="button round" href="javascripts:;">&#xe009;</a>
						<a class="button round" href="javascripts:;">&#xe00b;</a>
					</div>
					<div class="move-spot"><i></i><span>Move your link</span></div>
				</div>
			</div>
		</div>
		<div class="spot-item item-area">
			<p class="item-type__text">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.</p>
			<div class="spot-cover slow">
				<div class="spot-activity">
					<a class="button round" href="javascripts:;">&#xe003;</a>
					<a class="button round" href="javascripts:;">&#xe005;</a>
					<a class="button round" href="javascripts:;">&#xe009;</a>
					<a class="button round" href="javascripts:;">&#xe00b;</a>
				</div>
				<div class="move-spot"><i></i><span>Move your text</span></div>
			</div>
		</div>
		<div class="spot-item ">
			<div class="item-area type-itembox">
				<div class="item-head">
					<a href="#" class="type-link">
						<img class="soc-icon" src="socialmediaicons/youtube.png" height="36"><span class="link">youtu.be/yGg9RrI7V9s</span>
					</a>
				</div>
				<div class="type-mess item-body">
					<div class="item-user-avatar"><img width="50" height="50" src="https://i1.ytimg.com/i/6cqazSR6CnVMClY0bJI0Lg/1.jpg?v=51b2d2e9"></div>
					<div class="author-row">
						<h3><a class="color" href="http://vimeo.com/33382554">[BadComedian] - КРЕПКИЙ ОРЕШЕК 1-4</a></h3>
						<span class="sub-line"> from <a href="http://vimeo.com/user2956232">TheBadComedian</a> </span>
					</div>
					<div class="mess-body">
						<object>
							<param name="movie" value="https://www.youtube.com/v/yGg9RrI7V9s?version=3&amp;f=user_uploads&amp;app=youtube_gdata">
							<param name="allowFullScreen" value="true">
							<embed class="yt_player" id="player_4" src="https://www.youtube.com/v/yGg9RrI7V9s?version=3&amp;f=user_uploads&amp;app=youtube_gdata" type="application/x-shockwave-flash" width="100%" height="480" allowfullscreen="true" style="height: 912.0000000000229px;">
						</object>
						<script type="text/javascript">
							$(document).ready(function(){
								$('#player_4').height($('#player_4').width()/1.3333333333333);
							});
							$(window).resize(function(){
								$('#player_4').height($('#player_4').width()/1.3333333333333);
							});
						</script>
						<footer>
							<span>63798 просмотров</span>
						</footer>
					</div>
				</div>
				<div class="spot-cover slow">
					<div class="spot-activity">
						<a class="button round" href="javascripts:;">&#xe003;</a>
						<a class="button round" href="javascripts:;">&#xe005;</a>
						<a class="button round" href="javascripts:;">&#xe009;</a>
						<a class="button round" href="javascripts:;">&#xe00b;</a>
					</div>
					<div class="move-spot"><i></i><span>Move your link</span></div>
				</div>
			</div>
		</div>
		<div class="spot-item">
			<div class="item-area type-itembox">
				<div class="item-head">
					<a href="#" class="type-link">
						<img class="soc-icon" src="socialmediaicons/google.png" height="36"><span class="link">plus.google.com/u/0/105054371588663458860/posts</span>
					</a>
				</div>
				<div class="type-mess item-body">
					<div class="item-user-avatar"><img width="50" height="50" src="https://lh3.googleusercontent.com/-Dzcrb7Q6dh8/AAAAAAAAAAI/AAAAAAAABo0/QrglwOzu-_U/s46-c-k-no/photo.jpg"></div>
					<div class="mess-body">
						<div class="author-row">
							<a class="authot-name" href="#">Nataly Miklina</a>
							<b class="time sub-line">Доступно всем в Интернете  -  23 июля 2012 г.</b>
						</div>
						<p>
							Еду 15 июля! Уже купила тур :))))
							АААА потусим!!
							Никогда еще не отдыхала в России, посмотрим..заценим :)
						</p>
						<img src="https://lh5.googleusercontent.com/-xy6rb_GdhWo/T9CMyYZrtDI/AAAAAAAABIk/lYrhPWGQdj4/w426-h637/photo.jpg">
					</div>
				</div>
				<div class="spot-cover slow">
					<div class="spot-activity">
						<a class="button round" href="javascripts:;">&#xe003;</a>
						<a class="button round" href="javascripts:;">&#xe005;</a>
						<a class="button round" href="javascripts:;">&#xe009;</a>
						<a class="button round" href="javascripts:;">&#xe00b;</a>
					</div>
					<div class="move-spot"><i></i><span>Move your link</span></div>
				</div>
			</div>
		</div>
		<div class="spot-item">
			<div class="item-area type-itembox">
				<div class="item-head">
					<a href="#" class="type-link">
						<img class="soc-icon" src="socialmediaicons/vk.png" height="36"><span class="link">vk.com/id5369928</span>
					</a>
				</div>
				<div class="type-mess item-body">
					<div class="item-user-avatar"><img width="50" height="50" src="http://cs402324.vk.me/v402324928/b943/6SpgJDQGZDU.jpg"></div>
					<div class="mess-body">
						<div class="author-row">
							<a class="authot-name" href="#">Delirium Delger</a>
						</div>
						<p>Мы на пляже :)</p>
						<img src="http://cs402324.vk.me/v402324928/b928/gWhsdkIAdx8.jpg">
						<footer>
							<span>последний пост 1 час назад </span>
						</footer>
					</div>

				</div>
				<div class="spot-cover slow">
					<div class="spot-activity">
						<a class="button round" href="javascripts:;">&#xe003;</a>
						<a class="button round" href="javascripts:;">&#xe005;</a>
						<a class="button round" href="javascripts:;">&#xe009;</a>
						<a class="button round" href="javascripts:;">&#xe00b;</a>
					</div>
					<div class="move-spot"><i></i><span>Move your link</span></div>
				</div>
			</div>
		</div>
		<div class="spot-item">
			<div class="item-area type-itembox">
				<div class="item-head">
					<a href="#" class="type-link">
						<img class="soc-icon" src="socialmediaicons/vk.png" height="36"><span class="link">vk.com/id5369928</span>
					</a>
				</div>
				<div class="type-mess item-body">
					<div class="item-user-avatar"><img width="50" height="50" src="http://cs402324.vk.me/v402324928/b943/6SpgJDQGZDU.jpg"></div>
					<div class="mess-body">
						<div class="author-row">
							<a class="authot-name" href="#">Delirium Delger</a>
						</div>

						<a href="#" class="thumbnail">
							<img src="http://external.ak.fbcdn.net/safe_image.php?d=AQAKN2G0x7QArx_X&amp;w=154&amp;h=154&amp;url=http%3A%2F%2Fwww.comnews-conferences.ru%2Fimages%2Fstories%2Frus%2FMF2013%2F03.jpg">
							<h4>RUS_MB2013_инфо</h4>
							<span class="sub-txt">www.comnews-conferences.ru</span>
							<p>COMNEWS при поддержке Ассоциации «Электронные Деньги» проводит Практическую конференцию «E-payments Russia 2013 - электронные платежные системы, мобильные платежи и сервисы в России», которая состоится 3 сентября 2013 года в гостинице "Ренессанс Москва Олимпик".</p>
						</a>
						<footer>
							<span>последний пост 1 час назад </span>
						</footer>
					</div>

				</div>
				<div class="spot-cover slow">
					<div class="spot-activity">
						<a class="button round" href="javascripts:;">&#xe003;</a>
						<a class="button round" href="javascripts:;">&#xe005;</a>
						<a class="button round" href="javascripts:;">&#xe009;</a>
						<a class="button round" href="javascripts:;">&#xe00b;</a>
					</div>
					<div class="move-spot"><i></i><span>Move your link</span></div>
				</div>
			</div>
		</div>


		</div>
		<div class="spot-item">
			<div class="item-area type-itembox">
				<div class="item-head">
					<a href="#" class="type-link">
						<img class="soc-icon" src="socialmediaicons/foursquare.png" height="36"><span class="link">foursquare.com/user/32775128</span>
					</a>
				</div>
				<div class="type-mess item-body">
					<div class="item-user-avatar"><img width="50" height="50" src="https://is0.4sqi.net/userpix_thumbs/VNYKLUEDXGN5VZHV.jpg"></div>
					<div class="mess-body">
						<div class="author-row">
							<a class="authot-name" href="#">Vavyorka</a>
							<b class="time">23 hours ago</b>
							<div class="sub-line">
								<span class="icon">&#xe01b;</span>at <a href="#">Wargaming Summer Party</a>
							</div>
						</div>
						<p>Танкисты везде!</p>
						<img src="https://irs2.4sqi.net/img/general/532x266/32775128_ziV4pq0fhb5mKxsrsB1OpsFGzwzzjf00ODI58_YLazE.jpg">
					</div>
				</div>
				<div class="spot-cover slow">
					<div class="spot-activity">
						<a class="button round" href="javascripts:;">&#xe003;</a>
						<a class="button round" href="javascripts:;">&#xe005;</a>
						<a class="button round" href="javascripts:;">&#xe009;</a>
						<a class="button round" href="javascripts:;">&#xe00b;</a>
					</div>
					<div class="move-spot"><i></i><span>Move your link</span></div>
				</div>
			</div>
		</div>
		<div class="spot-item">
			<div class="item-area type-itembox">
				<div class="item-head">
					<a href="#" class="type-link">
						<img class="soc-icon" src="socialmediaicons/behance.png" height="36"><span class="link">behance.net/gallery/Collezioni-magazine/7422851</span>
					</a>
				</div>
				<div class="type-mess item-body">
					<div class="item-user-avatar"><img width="50" height="50" src="http://behance.vo.llnwd.net/profiles20/380813/50x17dd855f92d07c7bce60fce78bec28cf.jpg"></div>
					<div class="mess-body">
						<div class="author-row">
							<a class="authot-name" href="#">Danil Golovkin</a>
							<b class="time">March 03, 2013</b>
							<div class="sub-line">
								<span class="icon">&#xe01b;</span>Moscow, Russian Federati...
							</div>
						</div>

						<img src="http://behance.vo.llnwd.net/profiles20/380813/projects/7422851/396aba4dcdc1000c9803e7b3e585286e.jpg">
					</div>
				</div>
				<div class="spot-cover slow">
					<div class="spot-activity">
						<a class="button round" href="javascripts:;">&#xe003;</a>
						<a class="button round" href="javascripts:;">&#xe005;</a>
						<a class="button round" href="javascripts:;">&#xe009;</a>
						<a class="button round" href="javascripts:;">&#xe00b;</a>
					</div>
					<div class="move-spot"><i></i><span>Move your link</span></div>
				</div>
			</div>
		</div>
		<div class="spot-item">
			<div class="item-area type-itembox">
				<div class="item-head">
					<a href="#" class="type-link">
						<img class="soc-icon" src="socialmediaicons/deviantart.png" height="36"><span class="link">deviantart.com/art/Leaden-398692880</span>
					</a>
				</div>
				<div class="type-mess item-body">
					<div class="item-user-avatar"><img width="50" height="50" src="http://a.deviantart.net/avatars/y/u/yuumei.gif?4"></div>
					<div class="mess-body">
						<div class="author-row">
							<h3 class="color">Leaden</h3>
							<span class="sub-line"> by <a href="http://vimeo.com/user2956232">`yuumei</a></span>
						</div>
						<img src="http://fc04.deviantart.net/fs71/f/2013/250/9/1/leaden_by_yuumei-d6ldde8.jpg">
						<footer>
							<div><a href="#">Digital Art</a> / <a href="#">Drawings & Paintings</a> / <a href="#">Fantasy</a></div>
							<p>©2013 `yuumei</p>
						</footer>
					</div>
				</div>
				<div class="spot-cover slow">
					<div class="spot-activity">
						<a class="button round" href="javascripts:;">&#xe003;</a>
						<a class="button round" href="javascripts:;">&#xe005;</a>
						<a class="button round" href="javascripts:;">&#xe009;</a>
						<a class="button round" href="javascripts:;">&#xe00b;</a>
					</div>
					<div class="move-spot"><i></i><span>Move your link</span></div>
				</div>spot-hat-button
			</div>
		</div>
		<div class="spot-item">
			<div class="item-area type-itembox">
				<div class="item-head">
					<a href="#" class="type-link">
						<img class="soc-icon" src="socialmediaicons/myspace.png" height="36"><span class="link">myspace.com/suitnop</span>
					</a>
				</div>
				<div class="type-mess item-body">
					<div class="item-user-avatar"><img width="50" height="50" src="https://a4-images.myspacecdn.com/images03/1/0d0d58df48474e889d76f69d7ecd3517/300x300.jpg"></div>
					<div class="mess-body">
						<div class="author-row">
							<a class="authot-name" href="#">Mark Pontius</a>
							<div class="sub-line">
								<span class="icon">&#xe01b;</span>Los Angeles, CA
							</div>
						</div>
						<h3 class="color-black">ARTIST & SURFER     "I dont know the key to success, but the key to failure is trying to please everybody" -Bill Cosby</h3>

						<img src="https://a2-images.myspacecdn.com/images03/17/1f898d72bea1476fade649bcf925a3eb/full.jpg">

					</div>
				</div>
				<div class="spot-cover slow">
					<div class="spot-activity">
						<a class="button round" href="javascripts:;">&#xe003;</a>
						<a class="button round" href="javascripts:;">&#xe005;</a>
						<a class="button round" href="javascripts:;">&#xe009;</a>
						<a class="button round" href="javascripts:;">&#xe00b;</a>
					</div>
					<div class="move-spot"><i></i><span>Move your link</span></div>
				</div>
			</div>
			<div class="spot-item">
				<div class="item-area type-itembox">
					<div class="item-head">
						<a href="#" class="type-link">
							<img class="soc-icon" src="socialmediaicons/linkedin.png" height="36"><span class="link">linkedin.com/profile/view?id=138852850&authType=name&authToken=o5OU&offset=0&ref=PYMK&trk=prof-sb-pdm-pymk-photo</span>
						</a>
					</div>
					<div class="type-mess item-body">
						<div class="item-user-avatar"><img width="50" height="50" src="http://m.c.lnkd.licdn.com/mpr/mpr/shrink_200_200/p/2/000/115/19c/16ad3ab.jpg"></div>
						<div class="mess-body">
							<div class="author-row">
								<a class="authot-name" href="#">Alex Sorin</a>
								<b class="time sub-line">web developer в компании Wargaming.net</b>
							</div>
							<table class="j-list">
								<tr>
									<td><span>Текущая</span></td>
									<td>Wargaming.net</td>
								</tr>
								<tr>
									<td><span>Предыдущие</span></td>
									<td>Agente, Volcano Soft, EPAM Systems</td>
								</tr>
								<tr>
									<td><span>Образование</span></td>
									<td>Belarusian National Technical University</td>
								</tr>
							</table>


						</div>
					</div>
					<div class="spot-cover slow">
						<div class="spot-activity">
							<a class="button round" href="javascripts:;">&#xe003;</a>
							<a class="button round" href="javascripts:;">&#xe005;</a>
							<a class="button round" href="javascripts:;">&#xe009;</a>
							<a class="button round" href="javascripts:;">&#xe00b;</a>
						</div>
						<div class="move-spot"><i></i><span>Move your link</span></div>
					</div>
				</div>
			</div>
		</div>
		</div>
        */ ?>

		<div id="wallet-block" class="spot-content_row tabs-item">
        <?php /*
			<div id="setPayment" class="row popup-row">
			<div class="">
				<div class="item-area item-area_w clearfix">
					<div class="row">
						<div class="twelve columns">
							<h3>Состояние счета
																<span class="b-account b-negative b-positive">
																  3402 руб.
																</span>
								<a id="block-card" class="spot-button spot-button_block red-button" href="#">
									<span class="block">Заблокировать</span>
									<span class="release">Разблокировать</span>
								</a>

							</h3>
							<ul style="color:blue; text-decoration: underline; cursor: pointer;">
								<li href="#smsHint" ng-click="showHint($event)">Hint bottom-left</li>
								<li href="#hint02" ng-click="showHint($event)">Hint bottom-right</li>
								<li href="#hint04" ng-click="showHint($event)">Hint right</li>
								<br>
							</ul>
						</div>
						<div class="twelve left columns">
							<form name="paymentForm" class="custom item-area__right clearfix ng-pristine ng-invalid ng-invalid-required clearfix" action="https://test.wpay.uniteller.ru/pay/">
								<input id="unitell_shop_id" type="hidden" name="Shop_IDP" value="">
								<input id="unitell_customer" type="hidden" name="Customer_IDP" value="">
								<input id="unitell_order_id" type="hidden" name="Order_IDP" value="">
								<input id="unitell_subtotal" type="hidden" name="Subtotal_P" value="">
								<input id="unitell_signature" type="hidden" name="Signature" value="">
								<input id="unitell_url_ok" type="hidden" name="URL_RETURN_OK" value="">
								<input id="unitell_url_no" type="hidden" name="URL_RETURN_NO" value="">
								<div class="row">
									<div class="twelve columns">
										<label for="payment">Введите сумму от 100 до 1000 руб.</label>
									</div>
								</div>
								<div class="row form-line">
									<div class="four columns">
										<input id="payment" type="text" ng-pattern="/[0-9]+/" ng-model="payment.summ" placeholder="100" maxlength="50" required="" class="ng-pristine ng-invalid ng-invalid-required ng-valid-pattern b-pay-input"><span class="right b-currency">руб.</span>
									</div>
									<div class="three left columns">
										<a class="spot-button button-disable text-center" href="javascript:;" ng-click="addSumm(payment, $event)">Пополнить</a><br>
									</div>
									<span id="j-rules" class="payment-rules settings-button right">Условия использования</span>

								</div>
							</form>
						</div>
					</div>
					<div class="row">
						<div class="m-auto-payment bg-gray">
							<div class="twelve columns">

								<h3>Автоплатежи</h3>
								<span class="sub-h">Система автопополнение баланса при остатке менее 100 руб.</span>
							</div>
							<div class="twelve m-auto-block">


								<form class="item-area__right custom">
									<div class="five columns">
										<label for="auto-payment">C какой карты</label>
										<div class="content-row twelve left g-clearfix">
											<select class="medium">
												<option class="123">1234 **** **** **** - 15/01/2013</option>
												<option DISABLED>Тип2</option>
												<option>Тип3</option>
												<option>Тип4</option>
											</select>
										</div>
									</div>
									<div class="four columns">
										<label for="auto-payment">Cумма до которой пополнять</label>
										<div class="clearfix form-line">
											<div class="twelve columns">
												<input id="auto-payment" type="text" ng-pattern="/[0-9]+/" ng-model="payment.summ" placeholder="100" maxlength="50" required="" class="ng-pristine ng-invalid ng-invalid-required ng-valid-pattern b-pay-input"><span class="right b-currency">руб.</span>
											</div>
										</div>
									</div>

									<p class="sub-txt toggle-active">
										<a class="checkbox agree" href="javascript:;">
											<i class="large"></i>
											*Включая автоплатежи вы соглашаетесь,
											что баланс кампусной карты "Мобиспот" будет автоматически пополняться при остатке менее 100 руб.
										</a>
									</p>
									<a class="terms" href="#">Условия проведения авто платежа</a>
								</form>
								<form class="item-area__left custom">

									<div class="m-card-block">
										<h5>Автоплатеж будет производится с карты:</h5>
										<div class="m-card-cur m-card_visa">
											<div>Карта: <span class="m-card-info">xxxx xxxx xxxx 1234</span></div>
											<div>Дата подключения: <span class="m-card-info">12.04.2013</span></div>
										</div>
									</div>
									<div>
										<div class="five input-sum columns">
											<h5>Cумма до которой будет пополняться:</h5>
											<div class="clearfix form-line">
												<div class="twelve columns text-right">
													<span class="m-card-info">2000<span class="right b-currency">руб.</span></span>
												</div>
											</div>
										</div>
									</div>
								</form>
								<div class="three apay-button columns">
									<a class="spot-button on-apay text-center" href="javascript:;" ng-click="addSumm(payment, $event)">Включить</a>
									<a class="spot-button off-apay red-button text-center" href="javascript:;" ng-click="addSumm(payment, $event)">Отключить</a>
								</div>

							</div>
						</div>
					</div>
					<div class="cover"></div>
				</div>

			</div>

		</div>
		<div class="row">
			<div class="twelve">
				<div class="item-area clearfix item-area_w  item-area_table">
					<h3>Последние операции</h3>
					<div class="m-table-wrapper">
						<table class="m-spot-table" ng-grid="gridOptions">
							<thead>
							<tr>
								<th><div></sia><span>Дата и время</span></div></th>
								<th><div><span>Место</span></div></th>
								<th><div><span>Сумма</span></div></th>
							</tr>
							</thead>
							<tbody>
							<tr>
								<td><div>12.10.2013, 20:00</div></td>
								<td><div>Uilliam’s</div></td>
								<td><div>50$</div></td>
							</tr>
							<tr>
								<td><div>12.10.2013, 20:00</div></td>
								<td><div>Uilliam’s</div></td>
								<td><div>50$</div></td>
							</tr>
							<tr>
								<td><div>12.10.2013, 20:00</div></td>
								<td><div>Uilliam’s</div></td>
								<td><div>50$</div></td>
							</tr>
							</tbody>
						</table>
					</div>
					<a href="javascripts:;" id="operationsOrder" class="toggle-box m-sub-slide-h color">Выписка по операциям</a>
					<form class="custom">
						<div id="operationsOrderForm" class="slide-box m-sub-slide-menu clearfix">
							<div class="once-only">
								<div class="row">
									<div class="columns five">
										<input type="email" placeholder="Email address">
									</div>
									<div class="columns five">
										<label for="report-from" class="label-cover">C:</label><input id="report-from" type="email" value="20/03/2013">
									</div>
									<div class="columns five">
										<label for="report-to" class="label-cover">По:</label><input id="report-to" type="email" value="30/03/2013">
									</div>
									<div class="columns five">
										<a class="spot-button">Отправить</a>
									</div>
									<i></i>
								</div>
							</div>
							<div class="periodical m-sub-item">
								<div class="row">
									<h5 class="columns toggle-active_loc">
										<a class="checkbox" href="javascript:;">
											<i class="large"></i>
											Переодический отчет
										</a>
									</h5>
								</div>
								<div class="row toggle-disabled m-disabled">
									<div class="columns five">
										<input type="email" placeholder="Email address">
									</div>
									<div class="columns four">
										<div class="custom dropdown medium" style="width: 272px;">
											<a href="#" class="current">Раз в три дня</a>
											<a href="#" class="selector"></a>
											<ul style="width: 270px;">
												<li>Раз в день</li>
												<li class="selected" style="">Раз в три дня</li>
												<li>Раз в неделю</li>
												<li>Раз в месяц</li>
											</ul>
										</div>
									</div>
									<div class="columns three">
										<a class="spot-button">Сохранить</a>
									</div>

								</div>
							</div>

						</div>
					</form>
				</div>
			</div>
		</div>

		<div class="row item-offers">
			<div class="twelve">
				<div class="item-area clearfix item-area_w  item-area_table">
					<h3>Специальные предложения<sup class="count">10</sup>
						<a id="block-card" class="spot-button__link spot-button__g spot-button_block" href="offers.html">
							Все имеющиеся
						</a>
					</h3>
					<div class="table-fltr add-active">
						<a class="spot-button active" href="#">Актуальные</a>
						<a class="spot-button" href="#">Прошедшие</a>
						<input class="no-active" type="text" ng-model="search" placeholder="Поиск">
					</div>
					<div class="m-table-wrapper">
						<table class="m-spot-table" ng-grid="gridOptions">
							<thead>
							<tr>
								<th><div></sia><span>Магазин</span></div></th>
								<th><div><span>Условие</span></div></th>
								<th><div><span>Описание</span></div></th>
								<th><div><span>Период</span></div></th>
								<th><div><span>Получено</span></div></th>
							</tr>
							</thead>
							<tbody>

							<tr>
								<td class="t-store"><div><a href="#"><img src="img/defoult-store.png"></a></div></td>
								<td class="t-condition"><div>
									<h2>5%</h2>
									<p>На все покупки</p>
								</div></td>
								<td class="t-descript"><div>
									<h5>octogo.ru</h5>
									<p>Вознагрождение начисляется при оплате бронирования отеля на сайте</p>
								</div></td>
								<td><div>02.10.13 - 02.12.13</div></td>
								<td class="t-bonus"><div>203<i class="icon">&#xe019;</i> </div></td>
							</tr>
							<tr>
								<td class="t-store"><div><a href="#"><img src="img/defoult-store.png"></a></div></td>
								<td class="t-condition"><div>
									<h2>2$</h2>
									<p>За каждую <b>5-ю</b> покупку</p>
								</div></td>
								<td class="t-descript"><div>
									<h5>octogo.ru</h5>
									<p>Вознагрождение начисляется при оплате бронирования отеля на сайте</p>
								</div></td>
								<td><div>02.10.13 - 02.12.13</div></td>
								<td class="t-bonus"><div>44<i class="icon">&#xe019;</i> </div></td>
							</tr>
							<tr>
								<td class="t-store"><div><a href="#"><img src="img/defoult-store.png"></a></div></td>
								<td class="t-condition"><div>
									<h2>2<i class="icon rub">&#xe019;</i></h2>
									<p>За каждую <b>5-ю</b> покупки, при условии регистрации в он-лайн магазие</p>
								</div></td>
								<td class="t-descript"><div>
									<h5>octogo.ru</h5>
									<p>Вознагрождение начисляется при оплате бронирования отеля на сайте</p>
								</div></td>
								<td><div>02.10.13 - 02.12.13</div></td>
								<td class="t-bonus"><div>23<i class="icon">&#xe019;</i> </div></td>
							</tr>
							<tr class="m-table-bottom">
								<td class="line-pagination" colspan="5">
									<div>
										<ul class="pagination">
											<li class="current"><a href="">1</a></li>
											<li><a href="">2</a></li>
											<li><a href="">3</a></li>
											<li><a href="">4</a></li>
											<li><a href="">5</a></li>
											<li><a href="">6</a></li>
											<li><a href="">7</a></li>
										</ul>
									</div>
								</td>
							</tr>
							</tbody>
						</table>
					</div>
				</div>
		</div>

		</div>
        */?>
		</div>
		<div id="wallet-block2" class="spot-content_row spot-coupon tabs-item">
        <?php foreach ($coupons as $coupon):?>
  			<div class="spot-item item-area type-coupon <?php echo $coupon->coupon_class; ?>">
				<?php //<i class="coupon-indicator coupon-indicator__new">New</i> ?>
				<div class="s-content">
					<img src="/uploads/action/<?php echo $coupon->img; ?>">
				</div>
				<div class="coupon-terms">
					<?php echo $coupon->desc; ?>
					<div class="soc-block">
					</div>
						<a ng-click="checkLike(<?php echo $coupon->id; ?>)" class="spot-button spot-button-blue">Подключить</a>
				</div>
			</div>     
        <?php endforeach; ?>

        <?php /*
			<div class="spot-item item-area type-coupon type-coupon__50">
				<i class="coupon-indicator coupon-indicator__new">New</i>
				<div class="s-content">
					<img src="/uploads/action/fish.jpg">
				</div>
				<div class="coupon-terms">
					<h3>Акция к 14 февроля</h3>
					<p>
						Пользователю нужно перейти на сайт соотвествующей соцсети и совершить там оговоренное действие (лайк, шеринг, фолловинг, публикация с хэштегом). Нужно описание, какого действия мы хотим (Поставьте лайк странице Самсунг в Фейсбуке) и кнопка (ссылка) для перехода.
					</p>
					<div class="soc-block">
						<a href="https://twitter.com/share" class="twitter-share-button" data-via="s_plashchynski">Tweet</a>
						<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
					</div>
						<a href="#" class="spot-button spot-button-blue">Подключить</a>
				</div>
			</div>
			<div class="active spot-item item-area type-coupon type-coupon__50">
				<div class="s-content">
					<img src="/uploads/action/fish03.jpg">
				</div>
				<div class="coupon-terms">
					<h3>Акция к 14 февроля <sup>Учавствую</sup></h3>
					<p>
						Пользователю нужно перейти на сайт соотвествующей соцсети и совершить там оговоренное действие (лайк, шеринг, фолловинг, публикация с хэштегом). Нужно описание, какого действия мы хотим (Поставьте лайк странице Самсунг в Фейсбуке) и кнопка (ссылка) для перехода.
					</p>
					<div class="soc-block">
						<div id="fb-root"></div>
						<script>(function(d, s, id) {
							var js, fjs = d.getElementsByTagName(s)[0];
							if (d.getElementById(id)) return;
							js = d.createElement(s); js.id = id;
							js.src = "//connect.facebook.net/ru_RU/all.js#xfbml=1";
							fjs.parentNode.insertBefore(js, fjs);
						}(document, 'script', 'facebook-jssdk'));</script>
						<div class="fb-like" data-href="https://developers.facebook.com/docs/plugins/" data-layout="button_count" data-action="like" data-show-faces="true" data-share="true"></div>
					</div>
					<a href="#" class="spot-button spot-button-red">Отключить</a>
				</div>
			</div>
			<div class="spot-item item-area type-coupon">
				<i class="coupon-indicator coupon-indicator__new">New</i>
				<div class="s-content">
					<img src="/uploads/action/fish02.jpg">
				</div>
				<div class="coupon-terms">
					<h3>Акция  к 14 февроля</h3>
					<p>
						Пользователю нужно перейти на сайт соотвествующей соцсети и совершить там оговоренное действие (лайк, шеринг, фолловинг, публикация с хэштегом). Нужно описание, какого действия мы хотим (Поставьте лайк странице Самсунг в Фейсбуке) и кнопка (ссылка) для перехода.
					</p>
					<div class="soc-block">
						<style>.ig-b- { display: inline-block; }
						.ig-b- img { visibility: hidden; }
						.ig-b-:hover { background-position: 0 -60px; } .ig-b-:active { background-position: 0 -120px; }
						.ig-b-v-24 { width: 137px; height: 24px; background: url(//badges.instagram.com/static/images/ig-badge-view-sprite-24.png) no-repeat 0 0; }
						@media only screen and (-webkit-min-device-pixel-ratio: 2), only screen and (min--moz-device-pixel-ratio: 2), only screen and (-o-min-device-pixel-ratio: 2 / 1), only screen and (min-device-pixel-ratio: 2), only screen and (min-resolution: 192dpi), only screen and (min-resolution: 2dppx) {
							.ig-b-v-24 { background-image: url(//badges.instagram.com/static/images/ig-badge-view-sprite-24@2x.png); background-size: 160px 178px; } }</style>
						<a href="http://instagram.com/s_plashchynski?ref=badge" class="ig-b- ig-b-v-24"><img src="//badges.instagram.com/static/images/ig-badge-view-24.png" alt="Instagram" /></a>
					</div>
					<a href="#" class="spot-button spot-button-blue">Подключить</a>
				</div>
			</div>
			<div class="spot-item item-area type-coupon type-coupon__50">
				<div class="s-content">
					<img src="/uploads/action/fish05.png">
				</div>
				<div class="coupon-terms">
					<h3>Акция  к 14 февроля</h3>
					<p>
						Пользователю нужно перейти на сайт соотвествующей соцсети и совершить там оговоренное действие (лайк, шеринг, фолловинг, публикация с хэштегом). Нужно описание, какого действия мы хотим (Поставьте лайк странице Самсунг в Фейсбуке) и кнопка (ссылка) для перехода.
					</p>
					<div class="soc-block">
						<!-- Place this anchor tag where you want the button to go -->
						<a href="https://foursquare.com/intent/venue.html" class="fourSq-widget" data-variant="wide">Save to Foursquare</a>

						<!-- Place this script somewhere after the anchor tag above. If you have multiple buttons, only include the script once. -->
						<script type='text/javascript'>
							(function() {
								window.___fourSq = {"uid":"32420409"};
								var s = document.createElement('script');
								s.type = 'text/javascript';
								s.src = 'http://platform.foursquare.com/js/widgets.js';
								s.async = true;
								var ph = document.getElementsByTagName('script')[0];
								ph.parentNode.insertBefore(s, ph);
							})();
						</script>
					</div>
					<a href="#" class="spot-button spot-button-blue">Подключить</a>
				</div>
			</div>
			<div class="spot-item item-area type-coupon type-coupon__50">
				<div class="s-content">
					<img src="/uploads/action/fish04.png">
				</div>
				<div class="coupon-terms">
					<h3>Акция к 14 февроля</h3>
					<p>
						Пользователю нужно перейти на сайт соотвествующей соцсети и совершить там оговоренное действие (лайк, шеринг, фолловинг, публикация с хэштегом). Нужно описание, какого действия мы хотим (Поставьте лайк странице Самсунг в Фейсбуке) и кнопка (ссылка) для перехода.
					</p>
					<div class="soc-block">
						<a href="https://twitter.com/share" class="twitter-share-button" data-via="s_plashchynski">Tweet</a>
						<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
					</div>
					<a href="#" class="spot-button spot-button-blue">Подключить</a>
				</div>
			</div>
            */ ?>

		</div>
		</div>
		</div>
		</li>
		</ul>
	</div>
</div>
	<div class="row">
    <?php /*
		<div class="column twelve text-center toggle-active">
			<a href="#actSpotForm" id="actSpot" class="add-spot toggle-box button round slideToThis">
				<i class="icon">&#xe015;</i>
				<span class="m-tooltip m-tooltip-open">Add another spot</span>
				<span class="m-tooltip m-tooltip-close">Close form</span>
			</a>
		</div>
    */ ?>
	</div>
	<div class="actSpot-wrapper">
		<div id="actSpotForm" class="slide-box add-spot-box">
			<div class="row">
				<div class="six centered column">
					<input type="text" placeholder="Spot activation code">
					<div class="form-row toggle-active">
						<a class="checkbox agree" href="javascript:;">
							<i></i>
							I agree to Mobispot Pages Terms
						</a>
					</div>
					<div class="form-control">
						<a  class="spot-button" href="#">Activate spot</a>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div id="smsHint"  class="hint-block hide bottom bottom__left">
		 <h5>Подсказка 01</h5> <a class="hint-hide" href="javascripts:;" ng-click="closeHint($event)">&#xe017;</a>
		 <p>Описание функции</p>
		 <img src="images/round-img.jpg">
		<a href="#" class="spot-button_w">Согласен</a>
	</div>
	<div id="hint02"  class="hint-block hide bottom bottom__right">
		<h5>Подсказка 02</h5> <a class="hint-hide" href="javascripts:;" ng-click="closeHint($event)">&#xe017;</a>
		<p>AngularJS is a toolset for building the framework most suited to your application development.</p>
		<a href="#" class="spot-button_w">Принять</a>
	</div>
	<div id="hint03"  class="hint-block hide left">
		<h5>SMS-информирование</h5> <a class="hint-hide" href="javascripts:;" ng-click="closeHint($event)">&#xe017;</a>
		<p>AngularJS is a toolset for building the framework most suited to your application development.</p>
		<input type="number" placeholder="phone number">
		<a href="#" class="spot-button_w">Подключить</a>
	</div>
	<div id="hint04"  class="hint-block hide right">
		<h5>SMS-информирование</h5> <a class="hint-hide" href="javascripts:;" ng-click="closeHint($event)">&#xe017;</a>
		<p>AngularJS is a toolset for building the framework most suited to your application development.</p>
		<input type="number" placeholder="phone number">
		<a href="#" class="spot-button_w">Подключить</a>
	</div>
</div>
