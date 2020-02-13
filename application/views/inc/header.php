<?php
$unread_msg = 0;
$user= $this->session->userdata('user');
if($this->session->userdata('user')){
	
	$name=$this->auto_model->getFeild('fname','user','user_id',$user[0]->user_id)." ".$this->auto_model->getFeild('lname','user','user_id',$user[0]->user_id);
	
	$logo=$this->auto_model->getFeild('logo','user','user_id',$user[0]->user_id);
	
	if($logo==''){
		$logo="images/user.png";
	}else{
		if(file_exists('assets/uploaded/cropped_'.$logo)){
			$logo="uploaded/cropped_".$logo;
		}else{
			$logo="uploaded/".$logo;
		}
		
	}
	$plan=$user[0]->membership_plan;
	if($plan==1){$img="FREE_img.png";}elseif($plan==2){$img="SILVER_img.png";}elseif($plan==3){$img="GOLD_img.png";}elseif($plan==4){$img="PLATINUM_img.png";}	


	$dir = "user_message/";
	$filename=$dir."user_".$user[0]->user_id.".newmsg";
	if(!file_exists($filename)){
		$unread_msg = 0;
	}else{
		$unread_msg=file_get_contents($filename);
	}
	
}
$style='';
if($unread_msg == 0){
	$style = 'display:none;';
}
?>

<body>
<!-- Wrapper -->
<div id="wrapper">

<header id="header-container" class="transparent">
	<?php
$langMap = array(
	'arabic'=>IMAGE.'cuntryflag/uae.png',
	'spanish'=>IMAGE.'cuntryflag/spanish.png',
	'swedish'=>IMAGE.'cuntryflag/swedish.png',
	'english'=>IMAGE.'cuntryflag/britain.png',
);

$curr_lang = 'english';
if($this->session->userdata('lang')){
	$curr_lang = $this->session->userdata('lang');
}

 ?>
	<!-- Header -->
	<div id="header">
		<div class="container">
			
			<!-- Left Side Content -->
			<div class="left-side">
				
				<!-- Logo -->				
			<?php 
            $currLang='';
             if($this->session->userdata('lang')){
                $currLang = $this->session->userdata('lang');
            }
            ?>
            <div id="logo">
				<?php if($currLang == 'arabic'){ ?>
				<a href="<?=VPATH?>" alt="<?=SITE_TITLE?>" title="<?=SITE_TITLE?>"><img src="<?=ASSETS?>img/logo_ar.png" alt="" title="" class="img-responsive"></a>
				<?php }else{ ?>
				<a href="<?=VPATH?>" alt="<?=SITE_TITLE?>" title="<?=SITE_TITLE?>"><img src="<?=ASSETS?>img/<?php echo SITE_LOGO;?>" alt="" title="" class="img-responsive"></a>
				<?php } ?>
			</div>

				<!-- Main Navigation -->
				<!--<form class="shortSearch hide-under-992px">
                	<div class="input-group">
                    	<div class="input-group-append">
                        <div class="dropdown">
                            <button type="button" class="btn btn-white dropdown-toggle" id="dropdownMenuOffset" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-offset="10,20">
                              <i class="icon-feather-search"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuOffset">
                              <a class="dropdown-item" href="#">Freelancers</a>
                              <a class="dropdown-item" href="#">Jobs</a>
                              <a class="dropdown-item" href="#">Contest</a>
                            </div>
                          </div>
                        </div>
                    	<input type="text" class="form-control" placeholder="Search">                        
                    </div>
                </form>-->
				<?php if(!$this->session->userdata('user')){ ?>
		
				<form class="shortSearch hide-under-992px" action="<?php echo VPATH.'findtalents';?>" id="header_search_form">
				<!--<form class="" action="<?php echo VPATH.'findtalents';?>" id="header_search_form">-->
                	<div class="input-group">
                    	<div class="input-group-append">
                        <div class="dropdown">
                            <button class="btn btn-default dropdown-toggle" type="button" id="menu1" data-toggle="dropdown"><span id="srch_txt">
								<?php
								if(!empty($_GET['lookin'])){
									if($_GET['lookin'] == 'findjob'){
										echo __('jobs','Jobs');
									} else if($_GET['lookin'] == 'contest'){
										echo __('contest','Contest');
									} else{
										echo __('freelancer','Freelancer');
									}
								} else {
									echo __('freelancer','Freelancer');
								}
								?>
								</span></button>
                            
							 <ul class="dropdown-menu show" role="menu" aria-labelledby="menu1" style="left:0;right:auto">
								  <li role="presentation"><a role="menuitem" href="#" class="srch_dropdown_item" data-srch="Freelancer"><?php echo __('freelancer','Freelancer'); ?></a></li>
								  <li role="presentation"><a role="menuitem" href="#" class="srch_dropdown_item" data-srch="Jobs"><?php echo __('jobs','Jobs'); ?></a></li>
								  <li role="presentation"><a role="menuitem" href="#" class="srch_dropdown_item" data-srch="Contest"><?php echo __('contest','Contest'); ?></a></li>
							 </ul>
                          </div>
                        </div>
						<input type="hidden" value="<?php
								if(!empty($_GET['lookin'])){
									if($_GET['lookin'] == 'findjob'){
										echo __('jobs','Jobs');
									} else if($_GET['lookin'] == 'contest'){
										echo __('contest','Contest');
									} else{
										echo __('freelancer','Freelancer');
									}
								} else {
									echo __('freelancer','Freelancer');
								}
								?>" id="lookin"/>
                    	<input type="text" class="form-control" placeholder="Search" name='term'>                        
                    </div>
                </form>
			<?php } ?>
				
				<nav id="navigation">
		<ul id="responsive">	
        							
		<?php  if($this->session->userdata('user')){
			$user= $this->session->userdata('user'); //print_r($user);
        	if($user[0]->account_type == 'F'){ ?>
          <li><a href="javascript:void(0)">Browse <i class="fas fa-caret-down"></i></a>        	
          <ul class="dropdown-nav">
            <li><a href="<?=VPATH?>findjob/browse"><?php echo __('find_job','Find Job'); ?></a></li>
            <li><a href="<?=VPATH?>contest/browse"><?php echo __('find_contest','Find Contest'); ?></a></li>
          </ul>
        </li>  
        
        <?php } else if($user[0]->account_type == 'E'){
		?>
			<li><a href="javascript:void(0)">Post <i class="fas fa-caret-down"></i></a>        	
          <ul class="dropdown-nav">
            <li><a href="<?=VPATH?>postjob" <? if($current_page=="postjob"){?> id="current"<? }?>><?php echo __('post_job','Post Job'); ?></a></li>
			<li><a href="<?=VPATH?>contest/post_contest" <? if($current_page=="post_contest"){?> id="current"<? }?>><?php echo __('post_contest','Post Contest'); ?></a></li>
          </ul>
        </li>
			
		<?php }
        }else{ ?>
        <li><a href="javascript:void(0)">Work <i class="fas fa-caret-down"></i></a>        	
          <ul class="dropdown-nav">
            <li><a href="<?=VPATH?>findjob/browse"><?php echo __('find_job','Find Job'); ?></a></li>
            <li><a href="<?=VPATH?>contest/browse"><?php echo __('find_contest','Find Contest'); ?></a></li>
          </ul>
        </li> 
        <li><a href="<?=VPATH?>findtalents">Find Freelancer</a></li>
        
		<?php }  ?>

       
		
		<?php /* if($this->session->userdata('user')){
			$user= $this->session->userdata('user');
        	if($user[0]->account_type == 'E'){?>
			<li><a href="<?=VPATH?>findtalents/" <? if($current_page=="findtalent"){?> id="current"<? }?>>Find Freelancers</a></li>
        <?php }
        }else{?>
         <li><a href="<?=VPATH?>findtalents/" <? if($current_page=="findtalent"){?> id="current"<? }?>>Freelancers</a></li> 
        <?php } */ ?>  
		<?php if($this->session->userdata('user')) { ?>
            <li> <a href="<?=VPATH?>message/browse" <? if($current_page=="membership"){?>id="current"<? }?>><?php echo __('message','Messages'); ?></a>
            <span class="badge badge-success" id="msg_count" style="position: absolute;top: -5px;right: 0; <?php echo $style;?>"><?php echo $unread_msg; ?></span></li>			
            <li> <a href="<?=VPATH?>dashboard"><?php echo __('dashboard','Dashboard'); ?></a> </li>
        <?php } ?>         
												
		</ul>
				</nav>
                <div class="clearfix"></div>
				<!-- Main Navigation / End -->
			</div>
			<!-- Left Side Content / End -->


			<!-- Right Side Content / End -->
        <div class="right-side">
        
				<?php if(!$this->session->userdata('user')){ ?> 
                <div class="header-widget">                 
                 <ul class="display-inline">
<?php
         
  if($this->router->fetch_class()=="affiliate"){
		if(!$this->session->userdata('user_affiliate')){
		?>
		         <a class="btn btn-accent" href="<?=VPATH?>affiliate/" <? if($current_page=="signup"){?>id="current"<? }?>> <?php echo strtoupper(__('register','REGISTER')); ?></a>
		         <a class="btn btn-warning" href="<?=VPATH?>affiliate/"> <?php echo strtoupper(__('login','Login')); ?></a>
		        <?php
		}
		?>
<?php
 }else{ 
  if(!$this->session->userdata('user')){
 ?>		<li class="hide-under-768px"><a href="<?=VPATH?>login/">Log In</a></li>
        <li class="d-md-none"><a class="btn btn-border" href="<?=VPATH?>login/"><i class="icon-feather-log-in"></i></a></li>
        <li class="hide-under-768px"><a href="<?=VPATH?>signup/" <? if($current_page=="signup"){?>id="current"<? }?>>Sign Up</a></li>
        <li class="hide-under-768px"><a class="btn btn-gradient" href="<?=VPATH?>login?refer=postjob/" <? if($current_page=="postjob"){?> id="current"<? }?>>Post Job</a></li> 
        <li class="d-md-none"><a class="btn btn-gradient" href="<?=VPATH?>login?refer=postjob/" <? if($current_page=="postjob"){?> id="current"<? }?>><i class="icon-feather-briefcase"></i></a></li>
<?php }
}?> 


	 			</ul>
     			</div>                
<?php } ?>

		

	
 <?php
 if($this->session->userdata('user')){
	
 	  if($this->router->fetch_class()=="affiliate"){
?>
 		<ul class="nav navbar-nav">
            <li class="profile-imgEcnLi"><a href="<?=VPATH?>affiliate/dashboard/" <? if($current_page=="dashboard"){?>id="current"<? }?>><i class="fa fa-user" style="font-size:20px"  id="head_noti_profile"></i>&nbsp;</a>
              <ul>
                <li><a href="<?=VPATH?>affiliate/dashboard/" <? if($current_page=="dashboard"){?>id="current"<? }?>><?php echo strtoupper(__('dashboard','DASHBOARD')); ?></a></li>
                <li><a href="<?=VPATH?>affiliate/logout/" <? if($current_page=="logout"){?>id="current"<? }?>><?php echo strtoupper(__('logout','LOGOUT')); ?></a></li>
              </ul>
            </li>
		</ul>
 	  	
<?php	  }else{
	
?>

	<div class="header-widget hide-on-mobile">
        <span class="log-in-button">        	       
        <div class="headnotification visible-xs visible-sm"><a href="<?=VPATH?>notification"><i class="zmdi zmdi-notifications" style="font-size:20px"></i><span class="badge" id="head_noti" style="position:absolute;top:0;left:18px;background-color:#f5f5f5;color:#f00;"></span> </a> 						
        </div>
        </span>	
    </div>
    <div class="header-widget">
        <!-- Messages -->
        <div class="header-notifications user-menu">
            <div class="header-notifications-trigger">
                <a href="#"><div class="user-avatar status-online toggle-leftbar"><img src="<?=VPATH?>assets/<?=$logo?>" alt=""></div></a>
            </div>
    
            <!-- Dropdown -->
            <div class="header-notifications-dropdown">
    
                <!-- User Status -->
                <div class="user-status">
    
                    <!-- User Name / Avatar -->
                    <!-- class="profile-imgEc toggle-leftbar" -->
                    <div class="user-details">
                        <div class="user-avatar status-online"><img src="<?=VPATH?>assets/<?=$logo?>" alt=""></div>
                        <div class="user-name">
                            <?=ucwords($name)?>
                            <?php if($user[0]->account_type == 'F'){ ?>
                                <span>Freelancer</span>
                            <?php } ?>                        
                        </div>
                    </div>
                    
            </div>
            
            <ul class="user-menu-small-nav">            
                
              <li><a class="sidebar-link"  href="<?=VPATH?>dashboard/"><i class="zmdi zmdi-account"></i> <?php echo __('header_sticky_my_account','My Account'); ?></a></li>
              <li class="hide"> <a class="sidebar-link"  href="<?=VPATH?>membership/"><i class="zmdi zmdi-account"></i> <?php echo __('header_sticky_membership','Membership'); ?> </a></li>
            <?php if($user[0]->account_type == 'E'){ ?>
              <li><a href="<?=VPATH?>dashboard/myproject_client"><i class="fa fa-briefcase"></i> <?php echo __('header_sticky_my_posted_job','My Posted Jobs'); ?></a></li> <?php } ?>
             <?php if($user[0]->account_type == 'F'){ ?>
              <li><a href="<?=VPATH?>dashboard/myproject_working"><i class="fa fa-briefcase"></i> <?php echo __('header_sticky_my_working_job','My Working Jobs'); ?></a></li>
             <?php } ?>
             
              <li><a href="<?=VPATH?>myfinance"><i class="fa fa-dollar-sign"></i> <?php echo __('header_sticky_add_fund','Add Fund'); ?></a></li>
              
              <li><a href="<?=VPATH?>myfinance/transaction"><i class="fa fa-list-alt"></i> <?php echo __('header_sticky_transaction_history','Transaction History'); ?></a></li>
            
              <li><a href="<?=VPATH?>dashboard/setting"><i class="icon-material-outline-settings"></i> <?php echo __('header_sticky_settings','Settings'); ?></a></li>
              <li><a href="<?=VPATH?>user/logout/"><i class="icon-material-outline-power-settings-new"></i> <?php echo __('header_sticky_logout','Logout'); ?></a></li>
            </ul>
    
            </div>
        </div>
        
	
    </div>
    <!-- Mobile Navigation Button -->
        

<?php			
	  }
 	
 	}
 
 ?>		
 <span class="mmenu-trigger">
					<button class="hamburger hamburger--collapse" type="button">
						<span class="hamburger-box">
							<span class="hamburger-inner"></span>
						</span>
					</button>
				</span>	
</div>
				

			</div>
			<!-- Right Side Content / End -->
	</div>

	<!-- Header / End -->
    


<?php /* if($this->session->userdata('user')) { ?>
            
<?php }
else {
 ?> 
<div class="headerCat hide-under-992px">
    <div class="container">
        <ul>
            <li><a href="#">App Development</a></li>
            <!--<li><a href="#">Accounting &amp; Consulting</a></li>-->
            <li><a href="#">Admin Supports</a></li>
            <li><a href="#">Design &amp; Creative</a></li>
            <li><a href="#">Engineering &amp; Architecture</a></li>
            <li><a href="#">IT &amp; Networking</a></li>
            <li><a href="#">Legal</a></li>            
            <li><a href="#">Tutoring</a></li>
            <li><a href="#">Web Development</a></li>
        </ul>
    </div>
</div>
<style>
#wrapper {
    padding-top: 110px;
}
</style>

<?php } */?>
</header>
<!-- Header End --> 
<script type="text/javascript">

function postjob_fn(){
	$("#post_div").toggle();
	document.getElementById("login_div").style.display="none";
	}
	
function login_fn(){
	document.getElementById("post_div").style.display="none";
	$("#login_div").toggle();
}
 
 function check()
 {
	var title=$('#title_name').val();
	var mail=$('#mail').val();
    var atpos = mail.indexOf("@");
    var dotpos = mail.lastIndexOf(".");
    
	if(title=='' || title=='What do want to get done?')
	{
		alert('job title cant be left blank');
		return false;	
	}
	else if(mail=='' || mail=='Your email address')
	{
		alert('email cant be left blank');
		return false;	
	}
	else if (atpos< 1 || dotpos<atpos+2 || dotpos+2>=x.length) {
        alert("Not a valid e-mail address");
        return false;
    }
	else
	{
		return true; 
	}
}      
   
</script>
<?php 
 if($this->session->userdata('user')){ 
 $user=$this->session->userdata('user');
   
	$acc_balance=$this->auto_model->getFeild('acc_balance','user','user_id',$user[0]->user_id);
	$user_wallet_id = get_user_wallet($user[0]->user_id);
	$acc_balance=get_wallet_balance($user_wallet_id);
 
 ?>

  <div class="user-sidebar-container quicknav" style="right:-280px">
    <div class="sidebar user-sidebar">
      <div class="user-sidebar-info">
        <figure class="profile-img"> <a href="<?=VPATH?>dashboard"> <img src="<?=VPATH?>assets/<?=$logo?>"> </a> </figure>
        <div class="user-sidebar-name">
          <h4><?=ucwords($name)?></h4>
          <?php if($user[0]->account_type == 'F'){ ?>
               <span>Freelancer</span>
           <?php } ?>
		  <b><?php echo strtoupper(__('header_sticky_balance','BALANCE')); ?> :</b> <?php echo CURRENCY.' '.$acc_balance;?>
		   
        </div>
        <!--<div class="user-sidebar-status" style="margin-bottom:10px"> <img src="<?php// echo IMAGE;?><?=$img?>"> </div>-->
        
        <!--<a href="<?//=VPATH?>dashboard/tracker/" target="_blank" class="btn btn-warning btn-sm" style="color:#FFF">Download Timetracker</a>-->
      </div>
      
      <nav class="sidebar-nav menu">
            <ul>            
                
              <li><a class="sidebar-link"  href="<?=VPATH?>dashboard/"><i class="zmdi zmdi-account"></i> <?php echo __('header_sticky_my_account','My Account'); ?></a></li>
              <li class="hide"> <a class="sidebar-link"  href="<?=VPATH?>membership/"><i class="zmdi zmdi-account"></i> <?php echo __('header_sticky_membership','Membership'); ?> </a></li>
            <?php if($user[0]->account_type == 'E'){ ?>
              <li><a href="<?=VPATH?>dashboard/myproject_client"><i class="fa fa-briefcase"></i> <?php echo __('header_sticky_my_posted_job','My Posted Jobs'); ?></a></li> <?php } ?>
             <?php if($user[0]->account_type == 'F'){ ?>
              <li><a href="<?=VPATH?>dashboard/myproject_working"><i class="fa fa-briefcase"></i> <?php echo __('header_sticky_my_working_job','My Working Jobs'); ?></a></li>
             <?php } ?>
             
              <li><a href="<?=VPATH?>myfinance"><i class="fa fa-dollar-sign"></i> <?php echo __('header_sticky_add_fund','Add Fund'); ?></a></li>
              
              <li><a href="<?=VPATH?>myfinance/transaction"><i class="fa fa-list-alt"></i> <?php echo __('header_sticky_transaction_history','Transaction History'); ?></a></li>
            
              <li><a href="<?=VPATH?>dashboard/setting"><i class="icon-material-outline-settings"></i> <?php echo __('header_sticky_settings','Settings'); ?></a></li>
              <li><a href="<?=VPATH?>user/logout/"><i class="icon-material-outline-power-settings-new"></i> <?php echo __('header_sticky_logout','Logout'); ?></a></li>
            </ul>
    		</nav>           
      <span class="sidebar-close-alt"><i class="icon-line-awesome-close"></i></span> </div>
  </div>

<? }?>
<?php 
 if($this->session->userdata('user')){ 
 ?>
<div class="profileSe" style="display: none">
    <!--<div class="profileSetop">
      <div class="profileSetopBTN">
        <input name="view" checked="" id="online" type="radio">
        <label class="BtN btnSec" for="online">Online</label>
        <input name="view" id="invisible" type="radio">
        <label class="BtN btnSec" for="invisible">Invisible</label>
      </div>      
    </div>-->
    <ul class="secentList">
      <li title="<?=ucwords($name)?>" class="secentListInactive"> <a href="<?=VPATH?>dashboard" class="secentListItem secentListItemActive"> <span class=""> <img src="<?=VPATH?>assets/<?=$logo?>" style="height: 36px;width: 36px;border-radius: 18px;"></span>
        <?=ucwords($name)?>
        </a> </li>
   
    <!--<li><a href="<?//=VPATH?>dashboard/setting" class="secentListItem SectionBottom"><i class="fa fa-cogs"></i> Settings</a> </li>-->
    <li><a href="<?=VPATH?>user/logout/" class="secentListItem" title="Log out"> <i class="fa fa-sign-out"></i> Log out <span class="float-right">
    <?=$user[0]->username?>
    </span> </a> </li></ul>
    </div>
<ul class="notiH" role="menu" style="width:300px; display:none"></ul>

<?php 
}
 ?>
 <style>
 
 .notification:after, .notification:before {
	right: 100%;
	border: solid transparent;
	content: " ";
	height: 0;
	width: 0;
	position: absolute;
	pointer-events: none;
}
.notification {
    -webkit-border-radius: 3px;
    border-radius: 3px;
    border: 1px solid #5b6779;
    background: #6f7a8a;
    padding: 0px 6px;
    position: relative;
    color: #f2f2f2;
    font-weight: bold;
    font-size: 12px;
}
.notification.red {
    border-color: #be3d3c;
    background: #d8605f;
    color: #f2f2f2;
}
.notification:before {
    border-color: rgba(182, 119, 9, 0);
    border-right-color: #5b6779;
    border-width: 7px;
    top: 50%;
    margin-top: -7px;
}
.notification.red:before {
    border-color: rgba(190, 61, 60, 0);
    border-right-color: #be3d3c;
}
.notification.red:after {
    border-color: rgba(216, 96, 95, 0);
    border-right-color: #d8605f;
}
.notification:after {
    border-color: rgba(111, 122, 138, 0);
    border-right-color: #6f7a8a;
    border-width: 6px;
    top: 50%;
    margin-top: -6px;
}
</style>
<script>
	jQuery(document).ready(function($){
		$('.srch_dropdown_item').click(function(e){
			e.preventDefault();
			var srch = $(this).attr('data-srch');
			if(srch == 'Freelancer'){
				$('#srch_txt').html('<?php echo __('freelancer','Freelancer'); ?>');
				$('#header_search_form').attr('action' , '<?php echo VPATH;?>findtalents');
				$('#lookin').val('freelancer');
			}
			
			if(srch == 'Jobs'){
				$('#srch_txt').html('<?php echo __('jobs','Jobs'); ?>');
				$('#header_search_form').attr('action' , '<?php echo VPATH;?>findjob/browse');
				$('#lookin').val('findjob');
			}
			
			if(srch == 'Contest'){
				$('#srch_txt').html('<?php echo __('content','Contest'); ?>');
				$('#header_search_form').attr('action' , '<?php echo VPATH;?>contest/browse');
				$('#lookin').val('contest');
			}
		});
	});
</script>

<script>
$(document).ready(function () {


    //stick in the fixed 100% height behind the navbar but don't wrap it
    //$('#slide-nav.navbar-inverse').after($('<div class="inverse" id="navbar-height-col"></div>'));
  
    $('#slide-nav.navbar-default').after($('<div id="navbar-height-col"></div>'));  

    // Enter your ids or classes
    var toggler = '.navbar-toggle';
    var pagewrapper = '#page-content';
    var navigationwrapper = '.navbar-header';
    var menuwidth = '100%'; // the menu inside the slide menu itself
    var slidewidth = '80%';
    var menuneg = '-100%';
    var slideneg = '-100%';


    $("#slide-nav").on("click", toggler, function (e) {

        var selected = $(this).hasClass('slide-active');
        $('#slidemenu').stop().animate({
            left: selected ? menuneg : '0px'
        });
        $('#navbar-height-col').stop().animate({
            left: selected ? slideneg : '0px'
        });
        $(pagewrapper).stop().animate({
            left: selected ? '0px' : slidewidth
        });
        $(navigationwrapper).stop().animate({
            left: selected ? '0px' : slidewidth
        });
        $(this).toggleClass('slide-active', !selected);
        $('#slidemenu').toggleClass('slide-active');
        $('#page-content, .navbar, .navbar-header').toggleClass('slide-active');
    });

    var selected = '#slidemenu, #page-content, .navbar, .navbar-header';

    $(window).on("resize", function () {

        if ($(window).width() > 767 && $('.navbar-toggle').is(':hidden')) {
            $(selected).removeClass('slide-active');
        }
    });

});

</script>

<div id="page-content">
