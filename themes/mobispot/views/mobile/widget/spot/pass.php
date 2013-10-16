			<div class="spot-content_row">
				<div class="spot-item spot-password">
					<h1 class="text-center color"><?php echo Yii::t('spot', "Enter spot's password") ?></h1>
				</div>
				<div class="spot-item text-center spot-password">
					<form id="passForm" method="post">
						<input maxlength="4" name="pass" type="password" disabled>
						<input type="hidden" name="token" value="<?php echo Yii::app()->request->csrfToken ?>">
					</form>
				</div>
					<div class="spot-item spot-password">
						<table>
							<tr>
								<td class="text-right"><a href="javascript:;">1</a></td>
								<td class="text-center"><a href="javascript:;">2</a></td>
								<td class="text-left"><a href="javascript:;">3</a></td>
							</tr>
							<tr>
								<td class="text-right"><a href="javascript:;">4</a></td>
								<td class="text-center"><a href="javascript:;">5</a></td>
								<td class="text-left"><a href="javascript:;">6</a></td>
							</tr>
							<tr>
								<td class="text-right"><a href="javascript:;">7</a></td>
								<td class="text-center"><a href="javascript:;">8</a></td>
								<td class="text-left"><a href="javascript:;">9</a></td>
							</tr>
							<tr>
								<td></td>
								<td class="text-center"><a href="javascript:;">0</a></td>
								<td><span class="backspace">&#xe019;</span></td>
							</tr>
						</table>
					</div>
				</div>