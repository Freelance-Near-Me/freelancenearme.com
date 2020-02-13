<script src="<?=JS?>mycustom.js"></script>
<div class="dashboard-container">
<?php $this->load->view('dashboard/dashboard-left'); ?>
<div class="dashboard-content-container">
    <div class="dashboard-content-inner" >
    <!-- Dashboard Headline -->
	<?php echo $breadcrumb; ?>

     
          <?php

		if($this->session->flashdata('succ_msg'))
		
		{
		
		?>
		<div class="success alert-success alert"><?php echo $this->session->flashdata('succ_msg');?></div>
		<?php
		
		}
		
		if($this->session->flashdata('error_msg'))
		
		{
		
		?>
		  <span id="agree_termsError" class="error-msg2"><?php echo $this->session->flashdata('error_msg');?></span>
		  <?php
		
		}
		
		?>
        <form name="testimonial" id="testimonial" action="<?php echo VPATH;?>testimonial" method="post" class="form-horizontal">         
          <input type="hidden" name="uid" value="<?php echo $user_id;?>"/>
                <?php //echo __('testimonial_username','Username'); ?> 
     
          <div class="form-group">          	
            <label><?php //echo __('testimonial_your_feedback','Your Feedback'); ?> Feedback by &nbsp;<span class="badge badge-border"><?php echo $username;?></span></label>
            <textarea class="form-control" size="30" rows="3" name="description" id="description" tooltipText="Write Your Proper Feedback" ></textarea>
            <?php echo form_error('description', '<span class="error-msg13" style="margin: 0px !important;width: auto;">', '</span>'); ?> 
          </div>  

              <input class="btn btn-site" type="submit" id="submit-check" value="<?php echo __('testimonial_submit','Submit'); ?>" />
         
       
        </form>
       
    </div>    
  </div>
</div>