<?php
$this->load->model('dashboard/dashboard_model');
$user = $this->session->userdata('user');
$user_id = $user[0]->user_id;
$completeness = $this->auto_model->getCompleteness($user[0]->user_id);

$logo=$this->auto_model->getFeild('logo','user','user_id',$user[0]->user_id);

if($logo==''){
	$logo=base_url("assets/images/user.png");
}else{
	if(file_exists('assets/uploaded/cropped_'.$logo)){
		$logo=base_url("assets/uploaded/cropped_".$logo);
	}else{
		$logo=base_url("assets/uploaded/".$logo);
	}
}

$rating=$this->dashboard_model->getrating_new($user[0]->user_id);

$available_hr = $this->autoload_model->getFeild('available_hr','user','user_id',$user[0]->user_id);
if(empty($available_hr)){
	$available_hr = 'N/A';
}
$user_name=$this->auto_model->getFeild('fname','user','user_id',$user_id);
$user_name.= ' '.$this->auto_model->getFeild('lname','user','user_id',$user_id);	
$plan=$user[0]->membership_plan;

if($rating[0]['num'] > 0){
	$avg_rating=$rating[0]['avg']/$rating[0]['num'];
}else{
	$avg_rating=0;
}


$img = '';
if($plan==1){
	$img="FREE_img.png";	
}elseif($plan==2){
	$img="SILVER_img.png";	
}elseif($plan==3){
	$img="GOLD_img.png";	
}elseif($plan==4){
	$img="PLATINUM_img.png";	
}

$acc_balance=getField('acc_balance','user','user_id',$user[0]->user_id);
$user_wallet_id = get_user_wallet($user[0]->user_id);
$acc_balance=get_wallet_balance($user_wallet_id);
$accountType=$user[0]->account_type;		
?>			
<div class="dashboard-sidebar">
<div class="dashboard-sidebar-inner" data-simplebar>

<div class="dashboard-nav-container">
	
    <!-- Responsive Navigation Trigger -->
    <a href="#" class="dashboard-responsive-nav-trigger">
        <span class="hamburger hamburger--collapse" >
            <span class="hamburger-box">
                <span class="hamburger-inner"></span>
            </span>
        </span>
        <span class="trigger-title">Navigation</span>
    </a>
    
    <!-- Navigation -->
    <div class="dashboard-nav">
        <div class="dashboard-nav-inner">
        <div class="c_details">
                <div class="profile">
                    <div class="profile_pic">
                        <span><a href="<?php echo base_url('dashboard/profile_professional');?>"> <img src="<?php echo $logo;?>"></a></span>
                    </div>
                </div>
           
                <div class="profile-details text-center">
                    <h4><a href="<?php echo base_url('dashboard/profile_professional');?>" class=""><?php echo $user_name;?></a> &nbsp; <a href="<?php echo base_url('dashboard/profile_professional'); ?>" class="site-text" title="Edit Profile"><i class="icon-feather-edit"></i></a></h4>
                    <?php if($accountType == 'F'){ ?>
                    <p><?php echo $available_hr; ?> hrs/week</p>				
                    <?php } ?>
                    <div class="star-rating margin-bottom-15" data-rating="<?php echo round($avg_rating, 1); ?>"></div>
                    <h4>
                    <?php  /*
                    for($i=1; $i<=5; $i++){ 
                        if($i <= $avg_rating){
                            echo '<i class="zmdi zmdi-star"></i> ';
                        }else{
                            echo '<i class="zmdi zmdi-star-outline"></i> ';
                        }
                    }
                    */?>
                    </h4>  	
                   <div class="progress-outer">														                   					   
                   <div class="progress">
                      <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo round($completeness);?>%">
                       <div class="progress-value"><span><?php echo round($completeness);?></span> %</div>
                      </div>
                    </div>  
                    </div>    
                </div>
            </div>
        <div class="myfund">						  						  	
            <div class="body">
                <h4 class="title-sm">Add Fund</h4>
                <a href="<?php echo base_url('myfinance'); ?>">Add Fund</a><span class="badge badge-border pull-right"><?php echo CURRENCY.' '.$acc_balance;?></span>
            </div>
        </div>
        <ul data-submenu-title="Dashboard">
            <li class="<?php echo ($this->uri->segment(2) == 'overview') ? 'active' : '' ;?>">
                <a href="<?=VPATH?>dashboard"><i class="icon-line-awesome-dashboard"></i> <?php echo __('dashboard','Dashboard'); ?></a>
            </li>
            <li>
                <a href="<?=VPATH?>message/browse"><i class="icon-feather-message-square"></i> <?php echo __('message','Messages'); ?> </a>
            </li>
            
            <?php if($accountType == 'F'){ ?>  
              <li class="<?php echo ($this->uri->segment(2) == 'myproject_professional') ? 'active' : '' ;?>"><a href="<?php echo base_url('dashboard/myproject_professional'); ?>"><i class="icon-material-outline-assignment"></i> Project</a></li>
              <li class="<?php echo ($this->uri->segment(2) == 'mycontest_entry') ? 'active' : '' ;?>"><a href="<?php echo base_url('dashboard/mycontest_entry'); ?>"><i class="icon-line-awesome-trophy"></i> Contest</a></li>                  
            <?php }else{ ?>
            <li class="<?php echo ($this->uri->segment(2) == 'myproject_client') ? 'active' : '' ;?>"><a href="<?php echo base_url('dashboard/myproject_client'); ?>"><i class="icon-material-outline-assignment"></i> Project</a></li>
            <li class="<?php echo ($this->uri->segment(2) == 'mycontest') ? 'active' : '' ;?>"><a href="<?php echo base_url('dashboard/mycontest'); ?>"><i class="icon-line-awesome-trophy"></i> Contest</a></li>
            
            <?php } ?>   	
         </ul>
         
         <ul data-submenu-title="My Finance">   
            <li class="<?php echo ($this->uri->segment(1) == 'myfinance' && $this->uri->segment(2) == '') ? 'active' : '' ;?>">
                <a href="<?php echo base_url('myfinance'); ?>"><i class="icon-feather-dollar-sign"></i> Add Funds</a>
            </li>		        
            <li class="<?php echo ($this->uri->segment(2) == 'list_all') ? 'active' : '' ;?>">
                <a href="<?php echo base_url('invoice/list_all'); ?>"><i class="icon-line-awesome-file-text"></i> Invoices</a>
            </li>	
         </ul>
         <ul data-submenu-title="Feedback">      
            <li class="<?php echo ($this->uri->segment(2) == 'myfeedback') ? 'active' : '' ;?>">
                <a href="<?php echo base_url('dashboard/myfeedback'); ?>"><i class="icon-feather-star"></i> Reviews</a>
            </li>							  
            <li class="<?php echo ($this->uri->segment(1) == 'testimonial') ? 'active' : '' ;?>">
                <a href="<?php echo base_url('testimonial'); ?>"><i class="icon-line-awesome-comment-o"></i> Give Testimonial</a>
            </li>
        </ul>
                    

        <ul data-submenu-title="Account">                
            <li class="<?php echo ($this->uri->segment(2) == 'setting') ? 'active' : '' ;?>"><a href="<?php echo base_url('dashboard/setting'); ?>"><i class="icon-feather-settings"></i> Settings</a></li>
            <li class="<?php echo ($this->uri->segment(2) == 'closeacc') ? 'active' : '' ;?>"><a href="<?php echo base_url('dashboard/closeacc'); ?>"><i class="icon-feather-user"></i> Close Account</a></li>
            <li><a href="<?php echo base_url('user/logout'); ?>"><i class="icon-line-awesome-sign-out"></i> Logout</a></li>
        </ul>
            
        </div>
    </div>
    <!-- Navigation / End -->

</div>			
</div>	
</div>

<script src="<?=JSN;?>simplebar.min.js" type="text/javascript"></script>
<script>
/* $(window).load(function(){
	$('#mainpage').css('min-height', 900);
    var height = $('#mainpage').height();
    $('.left_panel').css('height', height);	
	$('.mobile-menu').click(function() {
    	$('.left_panel').toggle(300);
	});
	//$(".left_panel").niceScroll();
});*/  
</script>

