<script src="<?=JS?>mycustom.js"></script>
<div class="dashboard-container">
<?php $this->load->view('dashboard-left'); ?>
<div class="dashboard-content-container">
    <div class="dashboard-content-inner">
    <!-- Dashboard Headline -->
	<?php echo $breadcrumb; ?>
<!--ProfileRight Start-->
<div class="profile_right">
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

<!--EditProfile Start-->

<form name="testimonial" class="form-horizontal" id="testimonial" action="<?php echo VPATH;?>dashboard/closeacc/" method="post"> 
<input type="hidden" name="uid" value="<?php echo $user_id;?>"/>
<p>We are sorry to see you go. Please spare a few minutes to tell us why you are leaving (optional) : </p>
<div class="form-group">
<textarea class="form-control" size="30" name="description" id="description" tooltipText="Write Your Reason for Leaving" ></textarea>
<div class="error-msg2"> <?php echo form_error('description'); ?></div>
</div>
<div class="acount_form">
<div class="masg3"></div>
<input class="btn btn-site" type="submit" id="submit-check" value="Confirm" />
</div>
</form>

</div>                       
     </div>
  </div>
</div>
           
