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

<div class="single-page-header freelancer-header">
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
                <span><?php echo $slogan?></span></h3>
                
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
					if(count($total_posted) > 0){foreach($total_posted as $k => $v){
				?>
				 <li><span><?php echo $v['name'] ?>: </span> <strong><?php echo $v['y'] ?></strong></li>
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
        <div class="right-side d-block">
            <!-- Profile Overview -->
            
			<?php
			if($this->session->userdata('user')){
			 $userid=$this->session->userdata('user');
			 $user_login=$userid[0]->user_id;
			 $email_id = $userid[0]->email;
			 if($user_id!=$user_login && $account_type == 'F') {
			?>  
				<!--<a href="javascript:void(0)" class="apply-now-button" data-toggle="modal" data-target="#myModal2" onclick="send_mail('<?php echo $user_id?>','<?php echo $email_id ?>')"><?php echo __('clientdetails_sidebar_send_message','Send Message'); ?> <i class="icon-material-outline-arrow-right-alt"></i></a>-->
				<a href="javascript:void(0)" class="apply-now-button" data-toggle="modal" data-target="#myModal2" onclick="setProject2('<?php echo $user_id;?>','<?php echo $user_login;?>')"><?php echo __('clientdetails_sidebar_hire_me','Hire Me'); ?> <i class="icon-material-outline-arrow-right-alt"></i></a>
					
			<?php
				 }
			 }
			?>            
			</div>
    </div>		
	</div>
<?php
$bg_pic= $this->auto_model->getFeild("profile_bg_pic","user","user_id",$user_id);
$bg_full_path = ASSETS.'images/parallax1.jpg';
if(!empty($bg_pic)){
	if(file_exists('assets/uploaded/bgcropped_'.$bg_pic)){
		$bg_full_path = ASSETS.'uploaded/bgcropped_'.$bg_pic;
	}else if(file_exists('assets/uploaded/'.$bg_pic)){
		$bg_full_path = ASSETS.'uploaded/'.$bg_pic;
	}
	
}
?>
    <div class="background-image-container" style="background-image:url(<?php echo $bg_full_path;?>)"></div>
</div>
<div class="clearfix"></div>

<section class="sec">
<?php // $this->load->view('left_sidebar'); ?>
<div class="container">
	<div class="row">		
		<!-- Content -->
    <div class="col-xl-8 col-lg-8">        
        <!-- Page Content -->
        <div class="single-page-section">
        	<h3><?php echo __('talentdetails_email_overview','Overview'); ?></h3>
  			<?php echo $overview;?>                    
        </div>
        <!-- Boxed List -->
        <div class="boxed-list margin-bottom-30">
            <div class="boxed-list-headline">
                <h3><i class="icon-material-outline-thumb-up"></i> <?php echo __('talentdetails_work_experience','Work Experience'); ?></h3>
            </div>
            <ul class="boxed-list-ul">
				<?php if(count($experiences) > 0){foreach($experiences as $k => $v){ ?>
                <li>
                    <div class="boxed-list-item">
                        <!-- Content -->
                        <div class="item-content">
                        	
                            <div id="experience_<?php echo $v['experience_id'];?>">
								<h4><?php echo $v['title'];?> <span><?php echo $v['company'];?> <?php echo $v['start_year'];?> - <?php echo $v['currently_working'] == 'Y' ? 'Present' : $v['end_year'];?></span></h4>
								<!--<div class="item-details margin-top-10 hide">
									<div class="star-rating" data-rating="5.0"></div>
									<div class="detail-item"><i class="icon-material-outline-date-range"></i> August 2018</div>
								</div>-->
								<div class="item-description">
									<p><?php echo $v['summary'];?></p>
								</div>                            
                            </div>
                        </div>
                    </div>
                </li>
                <?php } }else{ ?>
                <li id="no_experience"><b><?php echo __('talentdetails_no_experience_added_yet','No experience added yet'); ?></b></li>
                <?php } ?>
            </ul>
        </div>
        
        <!-- Boxed List -->
        <div class="boxed-list margin-bottom-30">
            <div class="boxed-list-headline">
                <h3><i class="icon-line-awesome-graduation-cap"></i> <?php echo __('talentdetails_education','Education'); ?></h3>
            </div>
            <ul class="boxed-list-ul">
            	<?php if(count($educations) > 0){foreach($educations as $k => $v){ 
				$c = $this->auto_model->getFeild('Name', 'country', 'Code', $v['country']);
				$u = $this->auto_model->getFeild('university', 'university', 'university_id', $v['university']);
				?>
                <li id="education_<?php echo $v['education_id'];?>">
                    <div class="boxed-list-item">                        
                        <!-- Content -->
                        <div class="item-content">
                            <h4><?php echo $v['degree'];?></h4>                            
                            <div class="item-details margin-top-7">
                                <div class="detail-item"><a href="#"><i class="icon-material-outline-business"></i> <?php echo $u;?> , <?php echo $c;?></a></div>
                                <div class="detail-item"><i class="icon-material-outline-date-range"></i> <?php echo $v['start_year'];?>-<?php echo $v['end_year'];?></div>
                            </div>                            
                        </div>
                    </div>
                </li>
				<?php } }else{ ?>
                <div id="no_education"><p><b><?php echo __('talentdetails_you_have_not_added_any_education_yet','You have not added any education yet'); ?>.</b></p></div>
				<?php } ?>
        	</ul>
        </div>
        
        <!-- Boxed List -->
        <div class="boxed-list margin-bottom-30">
            <div class="boxed-list-headline">
                <h3><i class="icon-line-awesome-wordpress"></i> <?php echo __('talentdetails_skills_and_knowledge','Skills & Knowledge'); ?></h3>
            </div>
            <div class="well">
            <ul class="skills">    
			<?php
			if(!empty($user_skill)){ 
				
			  foreach($user_skill as $key => $val){  
			  
			  $skill_name=$val['skill_name'];
			  switch($lang){
				case 'arabic':
					$skill_name = !empty($val['arabic_skill_name'])? $val['arabic_skill_name'] : $val['skill_name'];
					break;
				case 'spanish':
					//$categoryName = $val['spanish_cat_name'];
					$skill_name = !empty($val['spanish_skill_name'])? $val['spanish_skill_name'] : $val['skill_name'];
					break;
				case 'swedish':
					//$categoryName = $val['swedish_cat_name'];
					
					$skill_name = !empty($val['swedish_skill_name'])? $val['swedish_skill_name'] : $val['skill_name'];
					break;
				default :
					$skill_name = $val['skill_name'];
					break;
			}
			  
			?>
			  <li><a href="<?php echo base_url('findtalents/browse').'/'.$this->auto_model->getcleanurl($val['parent_skill_name']).'/'.$val['parent_skill_id'].'/'.$this->auto_model->getcleanurl($val['skill']).'/'.$val['skill_id'];?>" class="skilslinks"><?php // echo $val['skill'];?><?php echo $skill_name;?></a></li>               
			<?php        
			  }    
			}
			else{
				  echo __('talentdetails_no_skill_set_yet','No Skill Set Yet'); 
			}
			 
			?>
		</ul>
        	</div>
        </div>
        
        <!-- Boxed List -->
        <div class="boxed-list margin-bottom-30">
            <div class="boxed-list-headline">
                <h3><i class="icon-line-awesome-certificate"></i> <?php echo __('talentdetails_certificate','Certificates'); ?></h3>
            </div>
            <ul class="boxed-list-ul">
            	<?php if(count($certificates) > 0){foreach($certificates as $k => $v){ ?>
                <li id="certificate_<?php echo $v['certificate_id'];?>">
                    <div class="boxed-list-item">                                               
                        <!-- Content -->
                        <div class="item-content">
                            <h4><?php echo $v['title'];?> </h4>
                            <div class="item-details margin-top-7">                                
                                <div class="detail-item"><i class="icon-material-outline-date-range"></i> <?php echo $v['duration'];?> <?php echo __('talentdetails_month','month'); ?></div>
                            </div>
                            <div class="item-description">
                                <p><?php echo $v['institute']; ?></p>
                            </div>
                        </div>
                    </div>
                </li>
                <?php } }else{  ?>
				<li><?php echo __('talentdetails_no_certificates_added','No certificates added'); ?> </li>
				<?php } ?>
    
    		</ul>
        </div>
        
        <!-- Boxed List -->
        <div class="listing boxed-list margin-bottom-30">
            <div class="boxed-list-headline">
                <h3><i class="icon-material-outline-broken-image"></i> <?php echo __('talentdetails_portfolio','Portfolio'); ?></h3>
            </div>
            
		<?php if(count($user_portfolio)>0){ ?>
		
        
        <div id="masonryG">
        <div class="row">
		<?php   
			foreach($user_portfolio as $key=>$val){
			$extension = end(explode(".", $val['thumb_img'])); 
			if($extension!="zip" && $extension!="doc" && $extension!="docx" && $extension!="pdf" && $extension!="xls" && $extension!="xlsx" && $extension!="txt"){  
		?>
        	<article class="col-sm-4 col-xs-12">
        	<div class="itm">
        	<img src="<?php echo VPATH."assets/portfolio/".$val['thumb_img'];?>" alt="" class="img-responsive">            
            <a href="#" data-toggle="modal" data-target="#portfolioModal" class="show_big" data-image="<?php echo VPATH."assets/portfolio/".$val['thumb_img'];?>">
            <div class="hover_itm">
            
            <h5 class="port_title"><?php echo $val['title'];?></h5>
            <p class="port_dscr" style="max-height:80px; overflow:hidden"><?php echo $val['description'];?>.</p>
            <!--<a href="#" class="btn btn-sm">View More</a>-->
                       
            </div>
            </a>
            </div>
        	</article>
			<?php } } ?>
        </div>
        </div>
		<?php } ?>
       
        </div>
        
        
        <div class="listing">    	                				                        
		<aside class="panel panel-default block d-none">
        <div class="panel-heading">
	        <h4 class="block-title"><?php echo __('talentdetails_other_portfolio','Other Portfolio'); ?></h4>
        </div>
        <div class="panel-body">
		<?php if(count($user_portfolio)>0){ ?>
		
        <ul>
		<?php   
			foreach($user_portfolio as $key=>$val){
			$extension = end(explode(".", $val['thumb_img'])); 
			if($extension=="zip" && $extension=="doc" && $extension=="docx" && $extension=="pdf" && $extension=="xls" && $extension=="xlsx" && $extension=="txt"){  
		?>
		 <li><a style="cursor: pointer;" href="<?php echo VPATH."assets/portfolio/".$val['thumb_img'];?>" target="_blank" class="skilslinks"><?php echo $val['title'];?></a> <br>
			<span><?php echo $val['description'];?></span>
		</li> 
			<?php } } ?>
        </ul>
		<?php } ?>
        </div>
        </aside>
		
		<div class="boxed-list margin-bottom-30">
            <div class="boxed-list-headline">
                <h3><i class="icon-material-outline-star-border"></i> <?php echo __('talentdetails_reviews_and_ratings','Reviews & Ratings'); ?></h3>
            </div>
            
            <ul class="boxed-list-ul">   
                		
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
                <li>
                <div class="ratingreview">
                <div class="row">
                <aside class="col-sm-9">
                
                <h4><?php
                  echo $this->auto_model->getFeild('title','projects','project_id',$val['project_id']);      
                ?></h4>
                <div class="star-rating" data-rating="<?php echo $val['average']?>"></div>
               
                <?php /*
                for($i=1; $i<=5; $i++){
                    if($i <= $val['average']){
                        echo ' <i class="zmdi zmdi-star"></i>';
                    }else{
                        echo ' <i class="zmdi zmdi-star-outline"></i>';
                    }
                }
                */?>
               
                <div class="ratingAll">                
                <p><a href="javascript:void(0)" class="seeAll">See all skills rating <i class="zmdi zmdi-chevron-down"></i></a></p>
                <div class="ratingtext" style="display: none;">
                <div class="divider margin-top-10 margin-bottom-10"></div>
                
               
               <p>
                Skills : 
                <?php
                for($i=1; $i<=5; $i++){
                    if($i <= $val['skills']){
                        echo ' <i class="zmdi zmdi-star"></i>';
                    }else{
                        echo ' <i class="zmdi zmdi-star-outline"></i>';
                    }
                }
                ?>
               </p>
               
                <p>
                Quality of works : 
                <?php
                for($i=1; $i<=5; $i++){
                    if($i <= $val['quality_of_work']){
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
                <aside class="col-sm-3">
                <div class="text-right">
                <p><?php echo ucwords( $given_name);?><br />
                <span><?php echo date('d M,Y',strtotime($val['added_date']));?></span></p>
                </div>
                </aside>
                </div>
                </div>
        		</li>
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
                
            </ul>
        </div>
        
        				
	</div>
	</div> 
    <!-- Sidebar -->
    <div class="col-xl-4 col-lg-4">
        <div class="sidebar-container">								
				<!-- Freelancer Indicators -->
				<div class="sidebar-widget">
					<div class="freelancer-indicators">
						<?php
						$completeness = $this->auto_model->getCompleteness($user_id);
						?>
						<!-- Indicator -->
						<div class="indicator">
							<strong><?php echo round($completeness)?>%</strong>
							<div class="indicator-bar" data-indicator-percentage="<?php echo round($completeness)?>"><span></span></div>
							<span>Profile Completeness</span>
						</div>
						
						<!-- Indicator -->
						<div class="indicator">
							<strong><?php echo round($quality_of_work['total'])?>%</strong>
							<div class="indicator-bar" data-indicator-percentage="<?php echo round($quality_of_work['total'])?>"><span></span></div>
							<span>On Quality of work</span>
						</div>
						
						<!-- Indicator -->
						<div class="indicator">
							<strong><?php echo round($communication['total'])?>%</strong>
							<div class="indicator-bar" data-indicator-percentage="<?php echo round($communication['total'])?>"><span></span></div>
							<span>On Communication</span>
						</div>
						
						<!-- Indicator -->
						<div class="indicator">
							<strong><?php echo round($cooperation['total'])?>%</strong>
							<div class="indicator-bar" data-indicator-percentage="<?php echo round($cooperation['total'])?>"><span></span></div>
							<span>On Cooperation</span>
						</div>
					</div>
				</div>
				
				<!-- Widget -->
				<div class="sidebar-widget hide">
					<h3>Social Profiles</h3>
					<div class="freelancer-socials margin-top-25">
						<ul>
							<li><a href="#" title="Dribbble" data-tippy-placement="top"><i class="icon-brand-dribbble"></i></a></li>
							<li><a href="#" title="Twitter" data-tippy-placement="top"><i class="icon-brand-twitter"></i></a></li>
							<li><a href="#" title="Behance" data-tippy-placement="top"><i class="icon-brand-behance"></i></a></li>
							<li><a href="#" title="GitHub" data-tippy-placement="top"><i class="icon-brand-github"></i></a></li>
						
						</ul>
					</div>
				</div>

				<!-- Widget -->
				<div class="sidebar-widget hide">
					<h3>Skills</h3>
					<div class="task-tags">
						<span>iOS</span>
						<span>Android</span>
						<span>mobile apps</span>
						<span>design</span>
						<span>Python</span>
						<span>Flask</span>
						<span>PHP</span>
						<span>WordPress</span>
					</div>
				</div>

				<!-- Widget -->
				<div class="sidebar-widget hide">
					<h3>Attachments</h3>
					<div class="attachments-container">
						<a href="#" class="attachment-box ripple-effect"><span>Cover Letter</span><i>PDF</i></a>
						<a href="#" class="attachment-box ripple-effect"><span>Contract</span><i>DOCX</i></a>
					</div>
				</div>

				<!-- Sidebar Widget -->
				<div class="sidebar-widget">
					<h3 class="hide">Bookmark or Share</h3>

					<!-- Bookmark Button -->
					<button class="bookmark-button margin-bottom-25 hide">
						<span class="bookmark-icon"></span>
						<span class="bookmark-text">Bookmark</span>
						<span class="bookmarked-text">Bookmarked</span>
					</button>

					<!-- Copy URL -->
					<div class="copy-url">
						<input id="copy-url" type="text" value="" class="with-border">
						<button class="copy-url-button ripple-effect" data-clipboard-target="#copy-url" title="Copy to Clipboard" data-tippy-placement="top"><i class="icon-material-outline-file-copy"></i></button>
					</div>

					<!-- Share Buttons -->
					<div class="share-buttons margin-top-25">
						<div class="share-buttons-trigger"><i class="icon-feather-share-2"></i></div>
						<div class="share-buttons-content">
							<span>Interesting? <strong>Share It!</strong></span>
							<ul class="share-buttons-icons">
								<li><a href="#" data-button-color="#3b5998" title="Share on Facebook" data-tippy-placement="top"><i class="icon-brand-facebook-f"></i></a></li>
								<li><a href="#" data-button-color="#1da1f2" title="Share on Twitter" data-tippy-placement="top"><i class="icon-brand-twitter"></i></a></li>
								<li><a href="#" data-button-color="#dd4b39" title="Share on Google Plus" data-tippy-placement="top"><i class="icon-brand-google-plus-g"></i></a></li>
								<li><a href="#" data-button-color="#0077b5" title="Share on LinkedIn" data-tippy-placement="top"><i class="icon-brand-linkedin-in"></i></a></li>
							</ul>
						</div>
					</div>
				</div>

			</div>
    </div>    
</div>
                   

    <?php /*?>
    <div class="profileEdit">               
       
     <?php 
	 $lang=$this->session->userdata('lang');
			$u_row = get_row(array('select' => 'payment_verified,phone_verified,email_verified', 'from' => 'user', 'where' => array('user_id' => $user_id)));
			if($this->session->userdata('user')){
				$userid=$this->session->userdata('user');
				$user_login=$userid[0]->user_id;
				$u_acc_type =  $userid[0]->account_type;
			}
			
		?>
        
        
        <br />
        <h4>Verifications</h4>  
        <ul class="list-group">
        <li class="list-group-item hidden"><i class="zmdi zmdi-facebook-box"></i>
     <?php echo __('talentdetails_facebook_connected','Facebook Connected'); ?> <span class="pull-right"><i class="zmdi zmdi-hc-2x zmdi-check-circle" title="<?php echo __('talentdetails_verified','Verified'); ?>" style="color:#0c0;line-height:20px"></i></span></li>
        <li class="list-group-item hidden"><i class="zmdi zmdi-smartphone"></i> <?php echo __('talentdetails_facebook_payment_verified','Payment Verified'); ?>
          <?php if($u_row['payment_verified'] == 'Y'){ echo '<span class="pull-right f-12">'.__('talentdetails_verified','Verified').'</span>'; }else{ ?>
          <span class="pull-right"><i class="zmdi zmdi-hc-2x zmdi-close" title="<?php echo __('talentdetails_unverified','Unverify'); ?>" style="color:#f00;line-height:20px"></i></span>
          <?php } ?>
        </li>
        <li class="list-group-item">
        <i class="zmdi zmdi-email"></i> <?php echo __('talentdetails_email_verified','Email Verified'); ?>
          <?php if($u_row['email_verified'] == 'Y'){ echo '<span class="pull-right"><i class="zmdi zmdi-hc-2x zmdi-check-circle" title="Verified" style="color:#0c0;line-height:20px"></i></span>'; }else{ ?>
          <span class="pull-right"><i class="zmdi zmdi-hc-2x zmdi-close" title="Unverify" style="color:#f00;line-height:20px"></i></span>
          <?php } ?>
        </li>
        <li class="list-group-item">
    	<i class="zmdi zmdi-smartphone"></i> <?php echo __('talentdetails_phone_verified','Phone Verified'); ?>
          <?php if($u_row['phone_verified'] == 'Y'){ echo '<span class="pull-right"><i class="zmdi zmdi-hc-2x zmdi-check-circle" title="'.__('talentdetails_verified','Verified').'" style="color:#0c0;line-height:20px"></i></span>'; }else{ ?>
          <span class="pull-right"><i class="zmdi zmdi-hc-2x zmdi-close" title="'.__('talentdetails_unverified','Unverify').'" style="color:#f00;line-height:20px"></i></span>
          <?php } ?>
        </li>
      </ul>
              
      </div>
	  <aside class="col-sm-4 col-xs-12">		    	      
	<div class="panel panel-default hidden">
        <div class="panel-heading">
            <h4>Certifications</h4>
        </div>
        <div class="panel-body">
            <a class="btn btn-site btn-block">Get Certified</a>
            <br>
            <p>You do not have any certifications.</p>
        </div>
    </div>
    
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4><?php echo __('talentdetails_my_top_skills','My Top Skills'); ?></h4>
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
				<li class="list-group-item"><?php echo __('talentdetails_no_skills_found','No Skills found'); ?></li>
				<?php } ?>
            </ul>
        </div>
    </div>
	</aside>
    <?php */?>

</div>
</section>
<script src="<?=JS?>imagesloaded.pkgd.min.js"></script>
<script>
jQuery().waypoint && jQuery("body").imagesLoaded(function () {
        jQuery(".animate_afc, .animate_afl, .animate_afr, .animate_aft, .animate_afb, .animate_wfc, .animate_hfc, .animate_rfc, .animate_rfl, .animate_rfr").waypoint(function () {
            if (!jQuery(this).hasClass("animate_start")) {
                var e = jQuery(this);
                setTimeout(function () {
                    e.addClass("animate_start")
                }, 20)
            }
        }, {
            offset: "85%",
            triggerOnce: !0
        })
    });
</script>
<script src="<?=JS?>masonry.min.js"></script>
<script>

  $(function(){
    var $container = $('#masonryG');
    $container.imagesLoaded( function(){
      $container.masonry({
        itemSelector : '.col-sm-4'
      });
    });
  
  });
</script>   
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
        <h4 class="modal-title" id="myModalLabel"><?php echo __('clientdetails_select_your_project_to_invite_freelancer','Select your project to invite freelancer')?></h4>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="freelancer_id" id="freelancer_id" value=""/>
		<div class="form-group">
			<label><?php echo __('clientdetails_message','Message')?></label>
			<textarea class="with-border" id="msg_details"><?php echo __('clientdetails_hi','Hi')?> <?php echo $fname." ".$lname;?>, <?php echo __('clientdetails_hinvite_msg_txt','I noticed your profile and would like to offer you my job. We can discuss any details over chat')?>.</textarea>
			<p id='detailsError' style='display: none; color: red'><?php echo __('clientdetails_enter_msg','Enter message')?>!!!</p>
		</div>
        
		<div class="form-group">
			<label><?php echo __('clientdetails_active_jobs','Active Jobs')?></label>
			<div id="job_wrapper">
				<div id="allprojects"></div>
				<p id='projectError' style='display: none; color: red'><?php echo __('clientdetails_please_select_job','Please select job')?>!!!</p>
			</div>
		</div>
      </div>
      <div class="modal-footer">
        <!--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
        <button type="button" onclick="hdd2()" id="sbmt" class="btn btn-primary"><?php echo __('clientdetails_invite','Invite')?></button>
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


/* function setProject(user_id,project_user)
{
	//alert(user_id+' '+project_user);
	jQuery("#freelancer_id").val(user_id);
	var datastring="user_id="+project_user;
	jQuery.ajax({
		data:datastring,
		type:"POST",
		url:"<?php echo VPATH;?>clientdetails/getProject",
		success:function(return_data){
			alert(return_data);
			if(return_data!=0)
			{
				jQuery("#allprojects").html('');	
				jQuery("#allprojects").html(return_data);
				jQuery("#sbmt").show();
				jQuery('#myModal').modal('show'); 
			}
			else
			{
				jQuery("#allprojects").html('<b>You dont have any open projects to invite</b>');	
				jQuery("#sbmt").hide();	
				jQuery('#myModal').modal('show'); 
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
 */
function setProject2(user_id,project_user)
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
				jQuery('#myModal').modal('show'); 
			}
			else
			{
				jQuery("#allprojects").html('<b>You dont have any open projects to invite</b>');	
				jQuery("#sbmt").hide();
				jQuery('#myModal').modal('show'); 
			}
		}
	});
}

function hdd2()
{
	var free_id=jQuery("#freelancer_id").val();
	var project_id=jQuery(".prjct").val();
	var message=jQuery("#msg_details").val();	
	if(message=='')
	{
		jQuery("#detailsError").css("display", "block");
		setTimeout( "jQuery('#detailsError').hide();",3000 );		
	} else if(project_id=='')
	{
		jQuery("#projectError").css("display", "block");
		setTimeout( "jQuery('#projectError').hide();",3000 );	
	}
	else
	{
		var datastring="freelancer_id="+free_id+"&projects_id="+project_id+"&message="+message;
		jQuery.ajax({
			data:datastring,
			type:"POST",
			url:"<?php echo VPATH;?>clientdetails/sendMessagenew",
			success:function(return_data){
				/* alert(return_data); */
				if(return_data==1){
					jQuery('#myModal').find('.modal-body').html('Your Invitation Send Successfuly').css({'background-color':'#0080004a','text-align':'center'});
					jQuery("#sbmt").hide();
				}
				setTimeout(function(){
					window.location.href='<?php echo VPATH;?>clientdetails/showdetails/'+free_id+'/';
				}, 3000);
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
        
        <h4 class="modal-title" id="portmyModalLabel"><?php echo $val['title'];?></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="$('#portfolioModal').modal('hide');"><span aria-hidden="true">&times;</span></button>
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

<div id="sendmailModal" class="modal fade" role="dialog">
	<div class="modal-dialog">  
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Send Message</h4>
				<button type="button" class="close" data-dismiss="modal" onclick="$('#sendmailModal').modal('hide');">&times;</button>
			</div>
			<div class="modal-body">
				<input type="hidden" name="user_id" id="user_id">
				<p style='display: inline-block'><b>To : </b></p>
				<?php
				$to_user = $this->db->select('fname,lname,email')->from('user')->where('user_id',$user_id)->get()->row();
				?>
				<label style='display: inline-block' ><?php echo $to_user->fname.' '.$to_user->lname?></label><br>
				<input type="hidden" name="to_email_id" id="to_email_id" value='<?php echo $to_user->email?>'>
				
				<p style='display: inline-block'><b>E-Mail id : </b></p>
				<?php
				$user_email = '';
				$userEmail = $this->session->userdata('user');
				if($userEmail){
					$user_email = $userEmail[0]->email;
				}
				?>
				<input type="text" name="from_email_id" id="from_email_id" class="form-control" value='<?php echo $user_email?>' readonly>
				
				<p><b>Subject</b></p>
				<input type="text" name="subject" id="subject" class="form-control" value=''>
				
				<p><b>Message</b></p>
				<textarea name="msg" id="msg" class="form-control"></textarea>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary" id="send_mail_btn">Send</button>
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
function send_mail(user_id,email_id){
	
	$('#sendmailModal').find('.modal-body #user_id').val(user_id);
	$('#sendmailModal').find('.modal-body #subject').val('');
	$('#sendmailModal').find('.modal-body #email_id').html(email_id);
}
$('#send_mail_btn').click(function(){
	var user_id = $('#sendmailModal').find('.modal-body #user_id').val();
	var to_email_id = $('#sendmailModal').find('.modal-body #to_email_id').val();
	var from_email_id = $('#sendmailModal').find('.modal-body #from_email_id').val();
	var subject = $('#sendmailModal').find('.modal-body #subject').val();
	var msg = $('#sendmailModal').find('.modal-body #msg').val();
	
	$.ajax({
		url : '<?php echo base_url('clientdetails/send_mail')?>',
		data: {user_id: user_id, to_email_id: to_email_id, from_email_id: from_email_id, subject: subject, msg: msg},
		type: 'POST',
		success: function(res){
			/* console.log(res); */
			if(res==1){
				$('#sendmailModal').find('.modal-body').html('Message send successfully.').css({"text-align": "center", "background-color": "rgba(0, 128, 0, 0.39)"});
			} else if(res==2){
				$('#sendmailModal').find('.modal-body').html('Unable to send message.').css({"text-align": "center", "background-color": "rgba(230, 20, 20, 0.39)"});
			} else {
				$('#sendmailModal').find('.modal-body').html('Email sending failed.').css({"text-align": "center", "background-color": "rgba(230, 20, 20, 0.39)"});
			}
			$('#sendmailModal').find('.modal-footer').html('');
			setTimeout(function(){ location.reload(); }, 3000);
		}
	});
});
</script>