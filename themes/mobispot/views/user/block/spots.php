<li id="<?php echo $data->discodes_id;?>" class="bg-gray toggle-box onlyOpen">
  <h3><?php echo $data->name?></h3>
    <div id="<?php echo $data->discodes_id;?>Form" class="spot-content slide-content">
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