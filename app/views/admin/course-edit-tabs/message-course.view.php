<form method="post" enctype="multipart/form-data">
		<div  class="h5"><b>Message Course </b></div>
		<input type="hidden" name="page" value="message-course">

        <div class="row mb-3">
          <label for="inputPassword" class="col-sm-3 col-form-label"><b>Welcome Message</b></label>
          <div class="col-sm-8">
            <textarea name="welcome_message" class="form-control" style="height: 100px"><?=$row->welcome_message?></textarea>
          </div>
          <?php if(!empty($errors['welcome_message'])):?>
            <small class="text-danger"><?=$errors['welcome_message']?></small>
          <?php endif;?>
        </div>

 
        <div class="row mb-3">
          <label for="inputPassword" class="col-sm-3 col-form-label"><b>Congratulation Message</b></label>
          <div class="col-sm-8">
            <textarea name="congratulation_message" class="form-control" style="height: 100px"><?=$row->congratulation_message?></textarea>
          </div>
          <?php if(!empty($errors['congratulation_message'])):?>
            <small class="text-danger"><?=$errors['congratulation_message']?></small>
          <?php endif;?>
        </div>

		<input type="submit" class="btn btn-success" value="Save Change">				
        
</form>
<?php
 