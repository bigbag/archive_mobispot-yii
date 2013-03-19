<li id="<?php echo $data->discodes_id;?>" class="spot-content_li bg-gray">
  <h3 ng-click="accordion($event)"><?php echo $data->name?></h3>
    <div class="spot-content">
				<div class="spot-content_row"><a class="settings-button spot-button right text-center" href="javascript:;">Settings</a></div>
					<div class="spot-content_row">
						<div class="spot-item">
							<textarea></textarea>
							<label class="text-center label-cover">
								<h4>Drag your files here or begin to type info or links</h4>
								<span>A maximum file size limit of 25mb for free accounts</span>
							</label>
						</div>
					</div>
					<div class="spot-content_row spot-options add-active">
						<a class="radio-link active" href="javascript:;">
							<i class="large"></i>
							Allow download spot as a card
						</a>
						<a class="radio-link" href="javascript:;">
							<i class="large"></i>
							Make it private
						</a>
					</div>
    </div>
</li>