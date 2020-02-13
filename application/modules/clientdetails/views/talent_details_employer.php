<style>
.icon-round{		
	margin-left: 10px;
}
.panel-body .list-group {
	margin-bottom:0
}
.panel-body .list-group-item {
    border-left: none;
	border-right:none
}
@media (min-width: 992px) {
.modal-sm {
    width: 400px;
}
}
</style>

<script src="<?=JS?>mycustom.js"></script>
<script src="<?=JS?>jquery.lightbox.min.js"></script>
<?php /*?><div class="single-page-header freelancer-header">
	<div class="container">
    <div class="single-page-header-inner">
        <div class="left-side">
            <div class="header-image freelancer-avatar">
<?php
if($logo!='')
{
    if(file_exists('assets/uploaded/cropped_'.$logo)){
        $logo = 'cropped_'.$logo;
    }
?>
<img src="<?php echo VPATH;?>assets/uploaded/<?php echo $logo;?>" alt="">   
<?php    
}    
else
{
?>
<img  src="<?php echo VPATH;?>assets/images/user.png" alt="">
<?php } ?>
            
            </div>
 
<?php 
$flag=$this->auto_model->getFeild("code2","country","Code",$country);
$flag=  strtolower($flag).".svg";
// echo $city.", ".$country;
if(is_numeric($city)){
$city = getField('Name', 'city', 'ID', $city);
}
$c = getField('Name', 'country', 'Code',$country);
?>
            <div class="header-details">
                <h3><?php echo $fname." ".$lname;?> 
                <?php 
if($this->session->userdata('user')){
$userid=$this->session->userdata('user');
$user_login=$userid[0]->user_id;
$u_acc_type =  $userid[0]->account_type;			
?>

<?php  if($user_id==$user_login) { ?><a href="<?php echo base_url('dashboard/editprofile_professional')?>"><i class="icon-feather-edit-3"></i></a> <?php } ?>

<?php }  ?>
				<span>iOS Expert + Node Dev</span>
                </h3>
                
                <ul>
                    <li>
                    <?php
					$avg_rating=0;
					if($rating[0]['num']>0){
						$avg_rating=round($rating[0]['avg']/$rating[0]['num'],2);
					}
					?>
					<div class="star-rating" data-rating="<?php echo $avg_rating?>"></div>
        			</li>
                    <li><img class="flag" src="<?php echo IMAGE;?>flags/<?php echo $flag;?>" alt=""> <?php echo $city; ?>, <?php echo $c; ?></li>
                    <li><div class="verified-badge-with-title">Verified</div></li>
                	<?php 
				if($account_type == 'E'){ 
					$this->load->model('jobdetails/jobdetails_model');
					$user_totalproject = $this->jobdetails_model->gettotaluserproject($user_id);
					$total_posted = $this->dashboard_model->getProjectStatics($user_id);
					if(count($total_posted) > 0){
						foreach($total_posted as $k => $v){
				?>
				 <li><span><?php echo $v['name'] ?>:</span> <strong><?php echo $v['y'] ?></strong></li>
				<?php } } ?>							
				
                 <li><span><?php echo __('clientdetails_sidebar_total_spent','Total Spent'); ?>:</span> <strong><?php echo CURRENCY;?><?php echo get_project_spend_amount($user_id);?></strong></li>
				 <li><span><?php echo __('clientdetails_sidebar_posted_job','Posted Job'); ?>:</span> <strong><?php echo $user_totalproject;?></strong></li>				 
				<?php  } ?>
                
                <?php if($account_type == 'F'){ ?>
                <li><span><?php echo __('clientdetails_sidebar_hourly_rate','Hourly Rate'); ?>:</span> <strong><?php echo CURRENCY;?><?php echo $rate;?></strong></li>
                <li><span><?php echo __('clientdetails_sidebar_completed_project','Completed Project'); ?>:</span> <strong><?php echo get_freelancer_project($user_id, 'C');?></strong></li>
                <li><span><?php echo __('clientdetails_sidebar_amount_earned','Amount Earned'); ?>:</span> <strong><?php echo CURRENCY;?> <?php echo get_earned_amount($user_id);?></strong></li>
                <?php } ?>
                
                
                
                </ul>
            </div>
        </div>
        <div class="right-side">
			<?php
			if($this->session->userdata('user')){
			 $userid=$this->session->userdata('user');
			 $user_login=$userid[0]->user_id;
			 if($user_id!=$user_login && $account_type == 'F') {
			?>  
				<a href="javascript:void(0)" class="apply-now-button" data-toggle="modal" data-target="#myModal2" onclick="setProject2('<?php echo $user_id;?>','<?php echo $user_login;?>')"><?php echo __('clientdetails_sidebar_send_message','Send Message'); ?> <i class="icon-material-outline-arrow-right-alt"></i></a>
					
			<?php
				 }
			 }
			?> 
        </div>
        </div>		
	</div>
    <div class="background-image-container" style="background-image:url(<?php echo ASSETS;?>images/freelancercover.jpg)"></div>
</div><?php */?>

<div class="parallax-banner-sm" style="background-image:url(<?php echo ASSETS;?>images/freelancercover.jpg)">
</div>
<section class="sec">
<div class="container">
<div class="profile-section">
<div class="row">
<?php $this->load->view('left_sidebar'); ?>
<div class="col-lg-6 col-md-8">
    <div class="spacer-20"></div>
	<?php echo $overview;?>
</div>
<div class="col-lg-3 col-md-4" style="border-left:1px solid #e0e0e0; padding:15px; min-height:520px">
    <div class="spacer-20"></div>
    <div class="profileEdit">               
       
     <?php 
			$u_row = get_row(array('select' => 'payment_verified,phone_verified,email_verified', 'from' => 'user', 'where' => array('user_id' => $user_id)));
			if($this->session->userdata('user')){
				$userid=$this->session->userdata('user');
				$user_login=$userid[0]->user_id;
				$u_acc_type =  $userid[0]->account_type;
			}
			
		?>
        <h3>Verifications</h3>  
        <ul class="list-group">
        <li class="list-group-item hidden"><i class="zmdi zmdi-facebook-box"></i>
     <?php echo __('talentdetails_facebook_connected','Facebook Connected'); ?> <span class="pull-right"><i class="zmdi zmdi-22x zmdi-check-circle" title="<?php echo __('talentdetails_verified','Verified'); ?>" style="color:#0c0;line-height:20px"></i></span></li>
        <li class="list-group-item hidden"><i class="zmdi zmdi-smartphone"></i> <?php echo __('talentdetails_facebook_payment_verified','Payment Verified'); ?>
          <?php if($u_row['payment_verified'] == 'Y'){ echo '<span class="pull-right f-12">'.__('talentdetails_verified','Verified').'</span>'; }else{ ?>
          <span class="pull-right"><i class="zmdi zmdi-22x zmdi-close" title="<?php echo __('talentdetails_unverified','Unverify'); ?>" style="color:#f00;line-height:20px"></i></span>
          <?php } ?>
        </li>
        <li class="list-group-item">
        <i class="zmdi zmdi-email"></i> <?php echo __('talentdetails_email_verified','Email Verified'); ?>
          <?php if($u_row['email_verified'] == 'Y'){ echo '<span class="pull-right"><i class="zmdi zmdi-22x zmdi-check-circle" title="'.__('talentdetails_verified','Verified').'" style="color:#0c0;line-height:20px"></i></span>'; }else{ ?>
          <span class="pull-right"><i class="zmdi zmdi-22x zmdi-close" title="<?php echo __('talentdetails_unverified','Unverify'); ?>" style="color:#f00;line-height:20px"></i></span>
          <?php } ?>
        </li>
        <li class="list-group-item">
    	<i class="zmdi zmdi-smartphone"></i> <?php echo __('talentdetails_phone_verified','Phone Verified'); ?>
          <?php if($u_row['phone_verified'] == 'Y'){ echo '<span class="pull-right"><i class="zmdi zmdi-22x zmdi-check-circle" title="'.__('talentdetails_verified','Verified').'" style="color:#0c0;line-height:20px"></i></span>'; }else{ ?>
          <span class="pull-right"><i class="zmdi zmdi-22x zmdi-close" title="<?php echo __('talentdetails_unverified','Unverify'); ?>" style="color:#f00;line-height:20px"></i></span>
          <?php } ?>
        </li>
      </ul>
              
      </div>
</div>
</div>
</div>
</div>
<div class="container">
<div class="row">
    <div class="col-xl-8 col-lg-8">
	    
        <article class="boxed-list margin-bottom-30"> 
        <div class="boxed-list-headline">
        	<h3><i class="icon-material-outline-business-center"></i> <?php echo __('talentdetails_emp_job_history','Job History'); ?></h3>
        </div>
        <div class="panel-body">
			<h4><?php echo __('talentdetails_emp_completed_project','Completed project'); ?></h4>
			<table class="table">
            	<tbody>
				<?php if(count($completed_projects) > 0){foreach($completed_projects as $k => $v){ ?>
				<tr>
					<td><a href="<?php echo base_url('jobdetails/details/'.$v['project_id']); ?>"><?php echo $v['title']; ?></a></td>
					<td><?php echo $v['project_type'] == 'F' ? 'Fixed' : 'Hourly'; ?></td>
					<td><?php echo __('talentdetails_emp_posted_on','Posted on'); ?> : <?php echo date('d M, Y', strtotime($v['post_date'])); ?></td>
					
				</tr>
				<?php } }else{  ?>
				<tr>
					<td colspan="10"><?php echo __('talentdetails_emp_no_completed_projects','No completed project'); ?></td>
				</tr>
				<?php } ?>
				</tbody>
			</table>
            <div class="spacer-20"></div>
			<h4><?php echo __('talentdetails_emp_open_projects','Open project'); ?></h4>
			<table class="table m-0">
            	<tbody>
				<?php if(count($open_projects) > 0){foreach($open_projects as $k => $v){ ?>
				<tr>
					<td><a href="<?php echo base_url('jobdetails/details/'.$v['project_id']); ?>"><?php echo $v['title']; ?></a></td>
					<td><?php echo $v['project_type'] == 'F' ? 'Fixed' : 'Hourly'; ?></td>
					<td><?php echo __('talentdetails_emp_posted_on','Posted on'); ?> : <?php echo date('d M, Y', strtotime($v['post_date'])); ?></td>
					
				</tr>
				<?php } }else{  ?>
				<tr>
					<td colspan="10"><?php echo __('ntdetails_emp_no_open_projects','No open project'); ?></td>
				</tr>
				<?php } ?>
				</tbody>
			</table>
		</div>  
        </article>		
		
		<article class="boxed-list margin-bottom-30"> 
        <div class="boxed-list-headline">
        	<h3><i class="icon-material-outline-thumb-up"></i> <?php echo __('talentdetails_emp_reviews_and_rating','Reviews & Ratings'); ?></h3>
        </div>
        <div class="panel-body">
        <?php
        if(count($review)>0){ 
		//get_print($review);
        ?>

        <!--Rating Review-->
        <?php
        foreach($review as $key => $val){  
              
            $username=$this->auto_model->getFeild('username','user','user_id',$val['review_to_user']);      
            $given_name=$this->auto_model->getFeild('username','user','user_id',$val['review_by_user']);      
          
        ?>
        <div class="ratingreview">
       <div class="row">
        <aside class="col-sm-9 col-xs-12">
       
        <h4><?php
          echo $this->auto_model->getFeild('title','projects','project_id',$val['project_id']);      
        ?></h4>
        
		<div class="star-rating" data-rating="<?php echo $val['average'];?>"></div>
        
		<?php 
		/*for($i=1; $i<=5; $i++){
			if($i <= $val['average']){
				echo ' <i class="zmdi zmdi-star"></i>';
			}else{
				echo ' <i class="zmdi zmdi-star-outline"></i>';
			}
		}*/
		?>       
	   
        <div class="ratingAll">                
        <p><a href="javascript:void(0)" class="seeAll">See all skills rating <i class="zmdi zmdi-chevron-down"></i></a></p>
        <div class="ratingtext" style="display: none;">
        <div class="divider margin-top-10 margin-bottom-10"></div>

	   <p>
		Behaviour : 
		<?php
		for($i=1; $i<=5; $i++){
			if($i <= $val['behaviour']){
				echo ' <i class="zmdi zmdi-star"></i>';
			}else{
				echo ' <i class="zmdi zmdi-star-outline"></i>';
			}
		}
		?>
	   </p>
	   
	    <p>
		Payment : 
		<?php
		for($i=1; $i<=5; $i++){
			if($i <= $val['payment']){
				echo ' <i class="zmdi zmdi-star"></i>';
			}else{
				echo ' <i class="zmdi zmdi-star-outline"></i>';
			}
		}
		?>
	   </p>
	   
	   <p>
		Availability : 
		<?php
		for($i=1; $i<=5; $i++){
			if($i <= $val['availablity']){
				echo ' <i class="zmdi zmdi-star"></i>';
			}else{
				echo ' <i class="zmdi zmdi-star-outline"></i>';
			}
		}
		?>
	   </p>
	   
	   <p>
		Communication : 
		<?php
		for($i=1; $i<=5; $i++){
			if($i <= $val['communication']){
				echo ' <i class="zmdi zmdi-star"></i>';
			}else{
				echo ' <i class="zmdi zmdi-star-outline"></i>';
			}
		}
		?>
	   </p>
	   
	    <p>
		Cooperation : 
		<?php
		for($i=1; $i<=5; $i++){
			if($i <= $val['cooperation']){
				echo ' <i class="zmdi zmdi-star"></i>';
			}else{
				echo ' <i class="zmdi zmdi-star-outline"></i>';
			}
		}
		?>
	   </p>       
	   
        </div>
        </div>
        <p><?php echo $val['comment'];?></p>
        </aside>
       
		 <aside class="col-sm-3 col-xs-12">
		  <div class="text-right">
            <p><?php echo ucwords( $given_name);?><br />
            <span><?php echo date('d M,Y',strtotime($val['added_date']));?></span></p>
        </div>
		</aside>

        </div>
        </div>
		<hr />
        <!--Rating Review End-->
        <?php        
          }    
        } else{
             ?>
        <!--Rating Review-->
        <div class="ratingreview">
        	<p class="text-muted"><?php echo __('myprofile_no_review_yet','No Review Yet.'); ?></p>
        </div>
            <?php
        }
         
        ?>
        </div>
        
        </article>	
    </div>
	<!-- Sidebar -->
    <div class="col-xl-4 col-lg-4">
    
      <div class="panel panel-default hidden">
        <div class="panel-heading">
            <h4>Certifications</h4>
        </div>
        <div class="panel-body">
            <a class="btn btn-site btn-block"><?php echo __('talentdetails_emp_get_certificate','Get Certified'); ?></a>
            <br>
            <p><?php echo __('talentdetails_emp_you_do_not_have_any_certificate','You do not have any certifications.'); ?></p>
        </div>
    </div>
    
    <div class="panel panel-default hidden">
        <div class="panel-heading">
            <h4><?php echo __('talentdetails_emp_my_top_skills','My Top Skills'); ?></h4>
        </div>
        <div class="panel-body" style="padding:0; margin:-1px 0 0">
            <ul class="list-group">
				<?php 
				if(!empty($user_skill)){ 
				
				foreach($user_skill as $key => $val){   
				?>
				<li class="list-group-item"><a href="<?php echo base_url('findtalents/browse').'/'.$this->auto_model->getcleanurl($val['parent_skill_name']).'/'.$val['parent_skill_id'].'/'.$this->auto_model->getcleanurl($val['skill']).'/'.$val['skill_id'];?>"><?php echo $val['skill'];?></a> <span class="badge hidden">100</span></li>
				<?php
				}
				}else{ 
				?>
				<li class="list-group-item"><?php echo __('talentdetails_emp_no_skills_found','No Skills found'); ?></li>
				<?php } ?>
            </ul>
        </div>
    </div>
    </div>
</div>


</div>
</section>   

<script>
$(document).ready(function(){ 
$('.seeAll').click(function(){
	var content=$(this).closest('.ratingAll').find('.ratingtext');
	if(content.is(':visible')){
		content.hide();
	}else{
		$('.ratingtext').hide();
		content.show();
	}
});
}); 
</script> 
<!-- Content End -->
<div class="modal fade" id="inviteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
    <div class="modal-header">
        <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" onclick="$('#inviteModal').modal('hide');">&times;</span></button> -->
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" onclick="window.location.reload()">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Send a private message</h4>
    </div>
    <div class="modal-body">
		<?php
			$usr = $this->session->userdata('user');
			$user_project=$this->findtalents_model->getprojects($usr[0]->user_id);
			
		?>
		<form class="form-horizontal" id="project_invitation_form">
		<input type="hidden" name="freelancer_id" value="<?php echo $user_id;?>"/>
		<input type="hidden" name="employer_id" value="<?php echo $usr[0]->user_id;?>"/>
        <textarea rows="4" name="message" class="form-control" placeholder="Write your invitation" style="margin-bottom:10px">Hi <?php echo $fname; ?>, I noticed your profile and would like to offer you my project. We can discuss any details over chat.</textarea>
		
		
		
        <select id="choosen_project" class="form-control" style="margin-bottom:10px" name="project_id" onchange="check_project_type();">
		<option value="">Choose project</option>
			<?php if(count($user_project) > 0){foreach($user_project as $k => $v){ ?>
				<option value="<?php echo $v['project_id'];?>" data-project-type="<?php echo $v['project_type'];?>"><?php echo $v['title']; ?></option>
			<?php } }  ?>
        
		</select>
		<input type="hidden" name="project_type" id="project_type" value=""/>
        <div class="clearfix"></div>
        <!--<h5>My Budget (Minimum: <i class="fa fa-inr hide"></i> ₹ 600)</h5>-->
		
		<div id="invitation_price_type">
			<div class="checkbox radio-inline" style="margin:0; display:none;" id="fixed_rate">
			<input type="radio" class="magic-radio" id="1" checked="">
			<label for="1"> Set Fixed Price</label>
			</div>
			
			<div class="checkbox radio-inline" style="margin:0 ; display:none;" id="hourly_rate">
			<input type="radio" class="magic-radio" id="2" checked="">
			<label for="2"> Set An Hourly Rate</label>
			</div>
		</div>
        <div class="spacer-15"></div>
       
        <div class="form-group row-5">
		
            <div class="col-sm-7 col-xs-12" id="invitation_amount_fixed" style="display:none;">
            <div class="input-group">
              <span class="input-group-addon">$</span>
              <input type="number" class="form-control" name="amount_fixed" value="" style="padding-right:0" placeholder="150" />
              <span class="input-group-addon" style="padding:0; background:none"><select style="height:32px; border:none; padding:0 6px"><option>USD</option></select></span>
            </div>
            </div>
			
            <div class="col-sm-5 col-xs-12" id="invitation_amount_hourly" style="display:none;">
            <div class="input-group"> 	
            <input type="number" class="form-control" name="amount_hourly" value="" style="padding-right:0" placeholder=" 10"/>
            <span class="input-group-addon">$/hr</span>
            </div>
            </div>
        </div>
       
        <div class="checkbox checkbox-inline">
            <input class="magic-checkbox" name="condition" id="confirm" value="Y" type="checkbox">
            <label for="confirm" style="font-size:12px">Please send me bids from other freelancers if my project is not accepted.</label>
        </div>	
        <button type="button" onclick="invite_user();" class="btn btn-success btn-block" style="margin:5px 0">Hire Now</button>
        <p style="font-size:12px">By clicking the button, you have read and agree to our Terms &amp; Conditions and Privacy Policy.</p>
		</form>    
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="top:5%">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Select Your project to invite freelancer</h4>
      </div>
      <div class="modal-body">
        <input type="hidden" name="freelancer_id" id="freelancer_id" value=""/>
        <div id="allprojects"></div>
      </div>
      <div class="modal-footer">
        <!--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
        <button type="button" onclick="hdd()" id="sbmt" class="btn btn-primary">Invite</button>
      </div>
    </div>
  </div>
</div>



<script>

function invite_user(){
	var f = $('#project_invitation_form'),
		fdata = f.serialize();
	
	if(f.find('select[name="project_id"]').val() != ''){
		$.ajax({
			url : '<?php echo base_url('clientdetails/invite_user');?>',
			data: fdata,
			type: 'POST',
			dataType: 'JSON',
			success: function(res){
				if(res['status'] == 1){
					$('#inviteModal').find('.modal-body').html('<p>Invitation successfully send</p>');
				}
			}
		});
	}else{
		alert('Please choose a project first');
	}
}
function check_project_type(){
	
	var val = $('#choosen_project').val(),
		p_type = $('#choosen_project :selected').attr('data-project-type');
		$('#project_type').val(p_type);
		if(p_type == 'H'){
			$('#invitation_price_type').find('#fixed_rate').hide();
			$('#invitation_price_type').find('#hourly_rate').show();
			$('#invitation_amount_fixed').hide();
			$('#invitation_amount_hourly').show();
		}else{
			$('#invitation_price_type').find('#fixed_rate').show();
			$('#invitation_price_type').find('#hourly_rate').hide();
			$('#invitation_amount_fixed').show();
			$('#invitation_amount_hourly').hide();
		}
}


function setProject(user_id,project_user)
{
	//alert(user_id+' '+project_user);
	jQuery("#freelancer_id").val(user_id);
	var datastring="user_id="+project_user;
	jQuery.ajax({
		data:datastring,
		type:"POST",
		url:"<?php echo VPATH;?>clientdetails/getProject",
		success:function(return_data){
			//alert(return_data);
				if(return_data!=0)
				{
					jQuery("#allprojects").html('');	
					jQuery("#allprojects").html(return_data);
					jQuery("#sbmt").show();
				}
				else
				{
					jQuery("#allprojects").html('<b>You dont have any open projects to invite</b>');	
					jQuery("#sbmt").hide();	
				}
			}
		});
}
function hdd()
{
	var free_id=jQuery("#freelancer_id").val();
	var project_id=jQuery(".prjct").val();
	var page='clientdetails';
	window.location.href='<?php echo VPATH;?>invitetalents/invitefreelancer/'+free_id+'/'+project_id+'/'+'/'+page+'/';	
}
/*
function setProject2(user_id,project_user)
{
	//alert(user_id+' '+project_user);
	jQuery("#freelancer_id2").val(user_id);
	var datastring="user_id="+project_user;
	jQuery.ajax({
		data:datastring,
		type:"POST",
		url:"<?php echo VPATH;?>clientdetails/getProject",
		success:function(return_data){
			//alert(return_data);
				if(return_data!=0)
				{
					jQuery("#allprojects2").html('');	
					jQuery("#allprojects2").html(return_data);
					jQuery("#sbmt2").show();
				}
				else
				{
					jQuery("#allprojects2").html('<b>You dont have any open projects to invite</b>');	
					jQuery("#sbmt2").hide();	
				}
			}
		});
}
*/
function hdd2()
{
	var free_id=jQuery("#freelancer_id2").val();
	var project_id=jQuery(".prjct").val();
	var message=jQuery("#msg_details").val();	
	if(message=='')
	{
		jQuery("#detailsError").css("display", "block");
		setTimeout( "jQuery('#detailsError').hide();",3000 );		
	}
	else
	{
		var datastring="freelancer_id="+free_id+"&projects_id="+project_id+"&message="+message;
		jQuery.ajax({
		data:datastring,
		type:"POST",
		url:"<?php echo VPATH;?>clientdetails/sendMessagenew",
		success:function(return_data){
			window.location.href='<?php echo VPATH;?>clientdetails/showdetails/'+free_id+'/';
			}
		});
		//window.location.href='<?php echo VPATH;?>clientdetails/sendMessage/'+free_id+'/'+project_id+'/'+'/'+encodeURI(message)+'/';	
	}
}
</script> 


<!-- Button trigger modal -->

<!-- Modal -->
<div class="modal fade" id="portfolioModal" tabindex="-1" role="dialog" aria-labelledby="portmyModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="$('#portfolioModal').modal('hide');"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="portmyModalLabel"><?php echo $val['title'];?></h4>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-sm-8 col-xs-12">
                <img src="<?php echo ASSETS;?>portfolio/Hydrangeas.jpg" alt="" class="img-responsive" id="port_big_img" style="width:100%;">
            </div>    
            <div class="col-sm-4 col-xs-12">
            <div class="profile_pic pic-sm">
              <span>
                <?php
        
                if($logo!='' && file_exists('assets/uploaded/cropped_'.$logo))
        
                {
        
                ?>
                <img alt="" src="<?php echo VPATH;?>assets/uploaded/<?php echo 'cropped_'.$logo;?>"  class="img-circle">
                <?php
        
                }
        
                else
        
                {
        
                ?>
                <img alt="" src="<?php echo VPATH;?>assets/images/face_icon.gif"  class="img-circle">
                <?php } ?>
                </span>
            </div>
        	<div class="pull-left">
			<?php 
			   $flag=$this->auto_model->getFeild("code2","country","Code",$country);
			   $flag=  strtolower($flag).".png";
			   // echo $city.", ".$country;
			   if(is_numeric($city)){
				   $city = getField('Name', 'city', 'ID', $city);
			   }
			   $c = getField('Name', 'country', 'Code',$country);
			?>
			
            	<h4><?php echo $fname." ".$lname;?></h4>
                <p><img src="<?php echo VPATH;?>assets/images/cuntryflag/<?php echo $flag;?>" alt=""> &nbsp;<span><?php echo (is_numeric($city)) ? getField('Name', 'city', 'ID', $city) : $city ; ?>,</span> <?php echo $c; ?></p>      
            </div>
			
			<?php if($account_type == 'F'){ ?>
            <a href="#" onclick="$('#portfolioModal').modal('hide');" data-target="#inviteModal" data-toggle="modal" class="btn btn-site btn-lg btn-block"><i class="zmdi zmdi-account"></i> Hire</a>
			<?php } ?>
            <div class="spacer-10"></div>                
            <p class="hidden"><b>Hourly Rate:</b> <?php echo CURRENCY;?><?php echo $rate;?></p>
            <h5>About the project</h5>
            <ul class="skills hidden">                    
                <li><a href="#">Graphic Design</a></li>
            </ul>
            <p id="port_dscr"><?php echo $val['description'];?>.</p>
            </div>
        </div>
      </div>
      
    </div>
  </div>
</div>

<script type="text/javascript">
	jQuery(document).ready(function($){
		$('.show_big').click(function(e){
			var img = $(this).attr('data-image');
			var dscr = $(this).find('p.port_dscr').text();
			var title =  $(this).find('h5.port_title').text();
			$('#port_big_img').attr('src' , img);
			$('#port_dscr').html(dscr);
			$('#portmyModalLabel').html(title);
		});
	});
</script>