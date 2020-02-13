<?php
$user=$this->session->userdata('user');
$u_row = get_row(array('select' => 'payment_verified,phone_verified,email_verified', 'from' => 'user', 'where' => array('user_id' => $user[0]->user_id)));

?>

<div class="col-lg-3 col-md-4 col-sm-12" style="border-right:1px solid #e0e0e0; min-height:520px">
  <div class="left_sidebar">
    <div class="profile">
      <div class="profile_pic"> 
      <a href="javascript:void(0)" class="profile-pic-cam" title="<?php echo __('myprofile_emp_update_profile_picture','Update profile picture'); ?>"><i class="zmdi zmdi-hc-2x zmdi-camera" style="line-height: 0.5;vertical-align: middle;" onclick="$('#profileModal').modal('show');"></i></a>     
        <span>
			<?php
            if($logo!='')
            {
				if(file_exists('assets/uploaded/cropped_'.$logo)){
					$logo = 'cropped_'.$logo;
				}
				
            ?>
            <img alt="" src="<?php echo VPATH;?>assets/uploaded/<?php echo $logo;?>"  class="img-circle">
            <?php
            }
            else
            {
            ?>
            <img alt="" src="<?php echo VPATH;?>assets/images/user.png"  class="img-circle">
            <?php } ?>
	    </span>
		 <?php if($verify=='Y'){ ?>
		<a class="btn- approved" style="opacity:1;border-radius:15px" title="<?php echo __('myprofile_emp_approved','APPROVED'); ?>"><i class="zmdi zmdi-thumb-up"></i></a>
		 <?php }  ?>
       </div>   
       <?php 
			if($this->session->userdata('user')){
			$userid=$this->session->userdata('user');
			$user_login=$userid[0]->user_id; 
		?>
      <?php  if($user_id==$user_login) { ?>
      <a href="<?php echo base_url('dashboard/editprofile_professional')?>" class="edit_info"><i class="icon-feather-edit-2"></i></a>
      <?php } ?>
      <?php }  ?>
    </div>
    	
    <div class="profile-details" style="padding:0">    	        
       <h4 class="text-center"><?php echo $fname." ".$lname;?></h4> 
       <p class="text-center"><span><?php echo $slogan?></span></p>
       
	<?php if($account_type == 'F'){ ?>
	<p class="" style="background-color: #333; padding: 6px 15px; color: #fff;"><i class="icon-feather-tag-box"></i> <?php echo __('myprofile_emp_available','Available'); ?> <span class="pull-right"><?php echo $available_hr;?> <?php echo __('myprofile_emp_hr_per_week','hr/week'); ?> <a href="javascript:void(0);" data-toggle="modal" data-target="#hourly_rateModal" style="color:#fff"><i class="icon-feather-edit-2"></i></a></span></p>
	<?php } ?>
    
      
      
      <?php
		$avg_rating=0;
		if($rating[0]['num']>0){
			$avg_rating=round($rating[0]['avg']/$rating[0]['num'],2);
		}
		?>
		<div class="star-rating mb-3 d-block" data-rating="<?php echo $avg_rating?>" style="max-width:175px; margin:0 auto"></div>
      <?php 
		$this->load->model('clientdetails/clientdetails_model');
	   $flag=$this->auto_model->getFeild("code2","country","Code",$user_country);
	   $flag=  strtolower($flag).".png";
	   // echo $city.", ".$country;
	   if(is_numeric($city)){
		   $city = getField('Name', 'city', 'ID', $city);
	   }
	   $c = getField('Name', 'country', 'Code',$user_country);
	?>
    <ul class="profile-list">
        <li class="hidden"><i class="zmdi zmdi-account-box"></i> Member since March, 2014</li>
        <li><img class="flag" src="<?php echo base_url('assets')?>/images/flags/<?php echo strtolower($this->auto_model->getFeild('code', 'countries', 'iso3', $country))?>.svg" alt="" height="16"> &nbsp;<span><?php echo $city; ?>,</span> <?php echo $c; ?></li>
		
		<?php if($account_type == 'F'){ ?>
        <li><i class="zmdi zmdi-time"></i> <?php echo __('myprofile_emp_hourly_rate','Hourly Rate'); ?>: <?php echo CURRENCY; ?><?php echo $hourly_rate;?>
		<?php  if($user_id==$user_login) { ?>
      <a href="#hourly_rateModal" data-toggle="modal" class="pull-right"><i class="icon-feather-edit-2" style="font-size:15px; min-width:0"></i> Edit</a>
      <?php } ?>
		</li>
		<?php } ?>
        <li><i class="icon-line-awesome-sign-out"></i> <?php echo __('myprofile_emp_last_logged_on','Last logged on'); ?>: <?php echo date('d M,Y',strtotime($ldate));?></li>
		
		<?php 
		if($account_type == 'E'){ 
			$this->load->model('jobdetails/jobdetails_model');
			$user_totalproject = $this->jobdetails_model->gettotaluserproject($user_id);
			$total_posted = $this->dashboard_model->getProjectStatics($user_id);
			
			if(count($total_posted) > 0){foreach($total_posted as $k => $v){
			?>
		 <li><i class="icon-feather-briefcase"></i> <?php echo $v['name'] ?> : <?php echo $v['y'] ?></li>
		<?php } } ?>
		
		 <li><i class="icon-feather-briefcase"></i> <?php echo __('myprofile_emp_posted_job','Posted Job'); ?>: <?php echo $user_totalproject;?></li>
		 
		 <li><i class="icon-feather-tag"></i> <?php echo __('myprofile_emp_sidebar_total_spent','Total Spent'); ?>: <?php echo CURRENCY;?><?php echo get_project_spend_amount($user_id);?></li>
		 
		<?php  } ?>
		<?php if($account_type == 'F'){ ?>
        <li><i class="icon-feather-tag"></i> <?php echo __('myprofile_emp_amount_earned','Amount Earned'); ?>: <?php echo CURRENCY;?> <?php echo get_earned_amount($user_id);?></li>
		
        <li><i class="icon-feather-tag"></i> <?php echo __('myprofile_completed_project','Completed Project'); ?>: <?php echo get_freelancer_project($user_id, 'C');?></li>
		 <li><a href="<?=VPATH?>findjob/"><i class="zmdi zmdi-search"></i> <?php echo __('myprofile_emp_browse_jobs','Browse jobs'); ?></a></li>
        <li><a href="<?php echo base_url('favourite'); ?>"><i class="icon-feather-heart"></i> <?php echo __('myprofile_emp_favorite_projects','Favourite Projects'); ?></a></li>
		 
		<?php }else{  ?>
		 <li><a href="<?=VPATH?>findtalents/"><i class="zmdi zmdi-search"></i> <?php echo __('myprofile_emp_browse_freelancer','Browse freelancer'); ?></a></li>
		<?php } ?>
       
      
    </ul>        
    <!--
    <p><a href="<?=VPATH?>dashboard/tracker/" target="_blank"><i class="zmdi zmdi-time"></i> Track time with the desktop app</a></p>
    <p style="display:none;"><a href="#"><i class="fa fa-handshake-o"></i> Hiring Headquarters</a></p>    
    <p><i class="icon-feather-tag"></i> Over <?php// echo CURRENCY;?> <?php// echo $this->clientdetails_model->get_total_expenditure($curr_user[0]->user_id);?> Total Spent</p>
    <p style="display:none;"><span>20 Hire, 6 Active</span></p>
    <p style="display:none;">$10.50/hr Avg Hourly Rate Paid</p>
    <p style="display:none;"><span>100 Hours</span></p>-->
    </div>
  </div>
</div>



