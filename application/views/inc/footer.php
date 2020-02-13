<!-- Footer Start -->
<?php
$page_partner=$this->auto_model->getFeild('partner','pagesetup','id','1');
$page_newsletter=$this->auto_model->getFeild('newsletter','pagesetup','id','1');
$page_posts=$this->auto_model->getFeild('posts','pagesetup','id','1');
$page_popular_links=$this->auto_model->getFeild('popular_links','pagesetup','id','1');
$footer_text=$this->auto_model->getFeild('footer_text','setting','id','1');

$event=$this->auto_model->getalldata('','event','status','Y');
$partner=$this->auto_model->getalldata('','partner','status','Y',6);
$popular=$this->auto_model->getalldata('','popular','id','1');

$lang = $this->session->userdata('lang');
?>


<!-- Footer -->
<div id="footer">
	
	

	<!-- Footer Middle Section -->
	<div class="footer-middle-section">
		<div class="container">
			<div class="row">

				<!-- Links -->
                <?php  if($page_popular_links=='Y') { ?>            
				<div class="col-lg-3 col-md-3">
					<div class="footer-links">
						<h3>Address</h3>
                        <address>
                        <!--40 Bloomsbury Way, $this->auto_model->
London, WC1A 2SE-->
							<?php
							echo nl2br($this->auto_model->getFeild('corporate_address','setting','id',1));
							?>
						</address>
						<div>
						<a class="twitter-timeline" data-width="220" data-height="180" data-theme="dark" href="https://twitter.com/freelancenearme?ref_src=twsrc%5Etfw">Tweets by freelancenearme</a> 
						<script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
						</div>
					</div>
				</div>
                <?php } ?>
				<?php
	$top_categories = $this->db->select("p.category , c.cat_name,c.arabic_cat_name,c.spanish_cat_name,c.swedish_cat_name, COUNT(p.id) AS total")->from('projects p')->join('categories c', 'c.cat_id=p.category', 'LEFT')->where(array('p.status'=>'O','p.project_status'=>'Y'))->group_by('p.category')->order_by('total' , 'DESC')->limit(5 , 0)->get()->result_array();
	?>
				<!-- Links -->
				<div class="col-lg-3 col-md-3">
					<div class="footer-links">
						<h3>Information</h3>
                        <ul>
							<li><a href="<?=VPATH?>about/" <? if($current_page=="about_us"){?>id="current"<? }?>><?php echo __('about_us','About Us'); ?></a></li>
							
							<li><a href="<?=VPATH?>our-partners/" <? if($current_page=="our-partners"){?>id="current"<? }?>><?php echo __('our_partners','Our Partners'); ?></a></li>
							
							<li><a href="<?=VPATH?>how-it-works/" <? if($current_page=="how-it-works"){?>id="current"<? }?>><?php echo __('how_it_works','How it Works'); ?></a></li>
							
          					<?php  foreach($popular as $vals){ ?>
							  
                              <?php /* if($vals->service=='Y'){ ?>
                              <li><a href="<?php echo  base_url()?>information/info/service_agreement"><?php echo __('service_provider_agreement','Service Provider Agreement'); ?></a></li>
                              <?php } */ ?>
                              <?php if($vals->contact=='Y'){ ?>
                              <li><a href="<?php echo VPATH;?>contact/"><?php echo __('contact_us','Contact Us'); ?></a></li>
                              <?php } ?>
                              <?php /* if($vals->refund=='Y'){ ?>
                              <li><a href="<?php echo  base_url()?>information/info/refund_policy"><?php echo __('refund_policy','Refund Policy'); ?></a></li>
                              <?php } */ ?>
                              
                              <?php if($vals->faq=='Y'){ ?>
                              <li><a href="<?php echo  base_url()?>faq_help"><?php echo __('faqs','FAQs'); ?></a></li>
                              <?php } ?>
                              <?php /* if($vals->sitemap=='Y'){ ?>
                              <li><a href="<?php echo  base_url()?>sitemap"><?php echo __('sitemap','Sitemap'); ?></a></li>
                              <?php } */ ?>
                              
                              <?php } ?>
							  
							  <li><a href="<?=VPATH?>blog/" <? if($current_page=="blog"){?>id="current"<? }?>><?php echo __('blog','Blog'); ?></a></li>
						</ul>
						
					</div>
				</div>

				<!-- Links -->
				<div class="col-lg-3 col-md-3">
					<div class="footer-links">
						<h3>Legal</h3>
						<ul>
							  <?php if($vals->privacy=='Y'){ ?>
                              <li><a href="<?php echo  base_url()?>privacy-policy"><?php echo __('privecy_policy','Privacy Policy'); ?></a></li>
                              <?php } ?>
                              <?php if($vals->terms=='Y'){ ?>
                              <li><a href="<?php echo  base_url()?>terms-conditions"><?php echo __('terms_&_conditions','Terms & Conditions'); ?></a></li>
                              <?php } ?>							
						</ul>
					</div>
				</div>

				<!-- Newsletter -->
                <?php  if($page_newsletter=='Y'){ ?>
				<div class="col-lg-3 col-md-3">
					<?php /*?><h3><i class="icon-feather-mail"></i> <?php echo __('subscribe_to_newsletter','Subscribe to Newsletter'); ?></h3>
					<p><?php echo __('subscribe_our_newsletter_to_get_reguler_update','Please subscribe our newsletter to get regular update'); ?></p>
					<form class="newsletter">
						<input type="email" id="sub_email" name="fname" placeholder="<?php echo __('email_address','Email Address'); ?>">
                        <span id="subs_error" style="float: left;margin-top: 0px; margin-bottom: 8px; width: 100%;color:#f00;font-size: 12px; display:none;"><?php echo __('enter_your_email','Enter your email'); ?>!!!</span>
						<button type="submit" id="subscription" value="Subscribe" onclick="getSubscription()"><i class="icon-feather-arrow-right"></i></button>                    </form><?php */?>
                    <div class="footer-links">  
                    	<h3>Apps</h3>  
                        <a href="https://play.google.com/store/apps/details?id=com.freelancerme.app"><img src="<?php echo IMAGE;?>google_play.svg" alt="" height="54" /></a>
                        <div class="spacer-20"></div>
                    	<p>freelancenearme is a trade name for  OneScope Limited</p>
					</div>
                </div>
                <?php } ?>
			</div>
		</div>
	</div>
	<!-- Footer Middle Section / End -->
	
	<!-- Footer Copyrights -->
	<div class="footer-bottom-section">
		<div class="container">
        <div class="footer-rows-container">
                
                <!-- Left Side -->
                <div class="footer-rows-left">
                    <a href="<?=VPATH?>" alt="<?=SITE_TITLE?>" title="<?=SITE_TITLE?>"><img src="<?php echo IMAGE;?>logo_white.png" alt="" title="" width="100"></a>
                </div>
            
                
                <!-- Right Side -->
                <div class="footer-rows-center">                       	
                    <p>© Copyright <?php echo date('Y')?>. <?php echo $footer_text; ?></p>                           
                </div>
                    
                    
                <div class="footer-rows-right">
                    <ul class="social-icons diamondShape-icon">
                    <?php
                    $popular=$this->auto_model->getalldata('','popular','id','1');
                    /* get_print($popular); */
                    if(!empty($popular)){foreach($popular as $vals){ ?>
                        <?php if($vals->facebook=='Y' && ADMIN_FACEBOOK!=''){ ?>
                        <li data-effect="helix"><a href="<?php echo ADMIN_FACEBOOK;?>" title="Facebook" data-tippy-placement="bottom" data-tippy-theme="light" target="_blank"><i class="zmdi zmdi-facebook"></i></a></li>
                        <?php } ?>
                        <?php if($vals->twitter=='Y' && ADMIN_TWITTER!=''){ ?>
                        <li data-effect="helix"><a href="<?php echo ADMIN_TWITTER;?>" title="Twitter" data-tippy-placement="bottom" data-tippy-theme="light" target="_blank"><i class="zmdi zmdi-twitter"></i></a></li>
                        <?php } ?>
                        <?php if($vals->linkedin=='Y' && ADMIN_LINKEDIN!=''){ ?>
                        <li data-effect="helix"><a href="<?php echo ADMIN_LINKEDIN;?>" title="LinkedIn" data-tippy-placement="bottom" data-tippy-theme="light" target="_blank"><i class="zmdi zmdi-linkedin"></i></a></li>
                        <?php } ?>
                        <?php  if($vals->instagram=='Y' && ADMIN_INSTAGRAM!=''){ ?>
                        <li data-effect="helix"><a href="<?php echo ADMIN_INSTAGRAM;?>" title="Instagram" data-tippy-placement="bottom" data-tippy-theme="light" target="_blank"><i class="zmdi zmdi-instagram"></i></a></li>
                        <?php }  ?>
                    <?php } } ?>
                          
                    </ul>
                </div>

            </div>			
		</div>
	</div>
	<!-- Footer Copyrights / End -->

</div>
<!-- Footer / End -->

</div>
<!-- Wrapper / End -->
  
<link href="<?=CSS?>bootstrap-datetimepicker.css" rel="stylesheet" type="text/css" />
<script src="<?=JS?>moment-with-locales.js"></script> 
<script src="<?=JS?>bootstrap-datetimepicker.min.js"></script> 
<script type="text/javascript">
	$(function () {
		$('.datepicker').datetimepicker({
		format: 'YYYY-MM-DD',
		minDate: new Date()
		//debug:true
	});
	});
</script> 
<script src="<?=JSN?>popper.min.js"></script> 
<script src="<?=JSN?>bootstrap.min.js"></script> 
 
<script>
var is_open_notification = 0;
jQuery(document).ready(function(){
    setInterval(function(){
		var dataString = '';
	 	 jQuery.ajax({
		 type:"POST",
		 data:dataString,
		 url:"<?php echo base_url();?>dashboard/getNotificationcount/",
		 success:function(return_data)
		 {
			
			if(return_data>0)
			{
			jQuery("#head_noti").html(return_data).show();
			jQuery('.count_list').html('');
			jQuery('.count_list').html(return_data);
			jQuery('.count_list').show();
			}else{
			jQuery("#head_noti").hide();
			}
		 }
		});
	}, 3000);		
	
	setInterval(function(){		
	var dataString = '';	 	 
	jQuery.ajax({		
		type:"POST",		
		data:dataString,		 
		url:"<?php echo base_url();?>dashboard/getMessagecount/",		 
		success:function(return_data){			
				
			if(return_data>0){				
				jQuery("#msg_count").html(return_data).show();			
			}else{				
				jQuery("#msg_count").hide();			
			}		 
		}		
	});	
	}, 30000);	
	
	setTimeout(function(){
		var matches=[];
		 jQuery('.notifid').each(function() {
		 	if(jQuery(this).hasClass('unread')){
				matches.push(jQuery(this).val());
			}
		
		});
	var dataString = 'notifid='+matches;
	 	 jQuery.ajax({
		 type:"POST",
		 data:dataString,
		 url:"<?php echo base_url();?>dashboard/updatenotification/",
		 success:function(return_data)
		 {
			/*alert(return_data);*/
			if(return_data>0)
			{
				jQuery('.notifbox').removeClass('notif_active');
			}
		 }
		});
		
	}, 6000);


	
jQuery( "li.headnotification" ).on('click',function(e) {
	e.stopPropagation();
console.log(is_open_notification);
if(is_open_notification > 0){
	jQuery(".notiH").fadeOut();
	is_open_notification = 0;
}else{
	
is_open_notification = 1;	
if(jQuery(".headnotification").length){
var positionright=jQuery(".headnotification").position();

var head_noti= document.getElementById("head_noti").offsetWidth;
if(head_noti>0){
var mimx=215+parseFloat(head_noti);
}else{
var mimx=245;
}
var l=parseFloat(positionright.left)-parseFloat(mimx);
jQuery('.notiH').css('left',l+"px");
}
jQuery('.notiH').html(' <li><a href="#" class="">Loading...</a></li>');
		jQuery.ajax({
		 type:"POST",
		 url:"<?php echo base_url();?>dashboard/getnotification/",
		 success:function(return_data)
		 {
			
				jQuery('.notiH').html(return_data);
				jQuery('.notiH').show();
				/*var matches=jQuery('.readids').val();
				var dataString = 'notifid='+matches;
				jQuery.ajax({
					type:"POST",
					data:dataString,
					url:"<?php echo base_url();?>dashboard/updatenotification/",
					success:function(return_data)
					{
					//alert(return_data);
						if(return_data>0)
						{
							jQuery('.notifbox').removeClass('notif_active');
						}
					}
				})*/
		 }
		});
}
		
});
<?php 
$currLang='';
 if($this->session->userdata('lang')){
	$currLang = $this->session->userdata('lang');
}
$lang_pos = 'ltr';
if($currLang == 'arabic'){
	$lang_pos = 'rtl';
	}
?>
<?php if($currLang == 'arabic'){ ?>
 jQuery('.sidebar-close-alt').click(function(e) {
		jQuery(".quicknav").css('left','-280px');
		});
jQuery('.toggle-leftbar img').click(function(e) {
		jQuery(".quicknav").css('left','0');
		});
<?php }else{ ?>
 jQuery('.sidebar-close-alt').click(function(e) {
		jQuery(".quicknav").css('right','-280px');
		});
jQuery('.toggle-leftbar img').click(function(e) {
		jQuery(".quicknav").css('right','0');
		});
<?php } ?>
		
		
jQuery('.toggle-leftbar').click(function(e) {
	if(jQuery(".profile-imgEcnLi").length){
var positionright=jQuery(".profile-imgEcnLi").position();
/* console.log(positionright);

console.log(head_noti); */

var mimx=297;
var l=parseFloat(positionright.left)-parseFloat(mimx);
jQuery('.profileSe').css('left',l+"px");
}
		//jQuery(".profileSe").fadeIn();
		})	
});
jQuery(document).click(function(e) {
if(!jQuery(e.target).is('.toggle-leftbar') && jQuery('.profileSe').has(e.target).length=== 0) {
jQuery(".profileSe").fadeOut();
}

is_open_notification = 0;


jQuery(".notiH").fadeOut();


if(!jQuery(e.target).is('.headnotification a') && jQuery('.notiH').has(e.target).length=== 0) {

}
})

</script>

<?php
      if($current_page=='jobdetails')
	  {
	  ?>
<script type="text/javascript" src="<?php echo ASSETS;?>js/new_ajaxfileupload.js"></script>
<?php
	  }
	  ?>
<?php
      if($current_page=='dashboard' || $current_page=="talentdetails")
	  {
	  ?>
<!--<script src="<?php echo VPATH?>assets/js/mootools-1.2.1-core-yc.js" type="text/javascript"></script> 
<script src="<?php echo VPATH?>assets/js/mootools-1.2-more.js" type="text/javascript"></script> 
<script src="<?php echo VPATH?>assets/js/jd.gallery.js" type="text/javascript"></script> 
<script type="text/javascript">
			function startGallery() {
				var myGallery = new gallery($('myGallery'), {
					timed: true
				});
			}
			window.addEvent('domready',startGallery);
		</script>-->
<?php
		}
		if($current_page=='editprofile_professional' || $current_page=='postjob' || $current_page=='editportfolio' || $current_page=='addportfolio')
		{
				if($current_page!='postjob'){
		?>
<!--<script type="text/javascript" src="<?php echo JS;?>jquery.min.js"></script>-->
<? }?>
<script type="text/javascript" src="<?php echo JS;?>ajaxfileupload.js"></script>
<?php
		}
      ?>
<!--<script src="<?//=JS?>jquery.parallax.js"></script> 
<script src="<?//=JS?>modernizr-2.6.2.min.js"></script> 
<script src="<?//=JS?>revolution-slider/js/jquery.themepunch.revolution.min.js"></script> 
<script src="<?//=JS?>jquery.nivo.slider.pack.js"></script> 
<script src="<?//=JS?>jquery.prettyPhoto.js"></script>-->
 
 
<script src="<?=JS?>tytabs.js"></script> 
<script src="<?=JS?>jquery.gmap.min.js"></script> 
<script src="<?=JS?>circularnav.js"></script> 
<script src="<?=ASSETS?>plugins/sticky/jquery.sticky.js"></script> 
<script src="<?=JS?>custom.js"></script>

<script src="<?=JSN?>mmenu.min.js"></script>
<script src="<?=JSN?>tippy.all.min.js" type="text/javascript"></script>
<script src="<?=JSN?>bootstrap-slider.min.js" type="text/javascript"></script>
<script src="<?=JSN?>bootstrap-select.min.js" type="text/javascript"></script>
<script src="<?=JSN?>clipboard.min.js" type="text/javascript"></script>
<script src="<?=JSN?>magnific-popup.min.js" type="text/javascript"></script>
<script src="<?=JSN?>counterup.min.js" type="text/javascript"></script>
<script src="<?=JSN?>slick.min.js" type="text/javascript"></script>
<script src="<?=JSN?>custom.js"></script>
<script>
	var $ = jQuery;	
	
	function getSubscription(){ 
	     if($("#sub_email").val()==""){ 
		   $("#subs_error").show();
		 }
		 else{ 
			 var dataString = 'email='+$("#sub_email").val();
			 
			  $.ajax({
				 type:"POST",
				 data:dataString,
				 url:"<?php echo VPATH;?>user/newsletterSubscription",
				 success:function(return_data){
					  if(return_data== '1'){
						$("#subs_error").text("<?php echo __('subscription_successful','Thank you. Your newsletter subscription is successful.'); ?>");  
						$("#subs_error").css("color","#FFFFFF");
						$("#subs_error").show();
						$("#sub_email").val('');
					  }
					  else if(return_data== '2'){ 
						$("#subs_error").text("<?php echo __('subscription_failed','Sorry..! Unable to process your request.'); ?>");  
						$("#subs_error").show();					  
					  }
					  else if(return_data== '3'){ 
						$("#subs_error").text("<?php echo __('alert_email_exist','Sorry..! This Email Id already exist.'); ?>");  
						$("#subs_error").show();					  
					  }
					   else if(return_data== '4'){ 
						$("#subs_error").text("<?php echo __('alert_valid_email','Enter a valid email.'); ?>");  
						$("#subs_error").show();					  
					  }
					  else{ 
    					  $("#subs_error").show();	
					  }
				 }
			  });		   
		   
		   
		 }
	  }
	
	
	</script> 
<div id="fb-root"></div>
<script type="text/javascript">
  window.fbAsyncInit = function() {
	  //Initiallize the facebook using the facebook javascript sdk
     FB.init({ 
       appId:'<?php echo get_option_value('facebook_appId'); ?>', // App ID 
	   cookie:true, // enable cookies to allow the server to access the session
       status:true, // check login status
	   xfbml:true, // parse XFBML
	   oauth : true //enable Oauth 
     });
   };
   //Read the baseurl from the config.php file
   (function(d){
           var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
           if (d.getElementById(id)) {return;}
           js = d.createElement('script'); js.id = id; js.async = true;
           js.src = "//connect.facebook.net/en_US/all.js";
           ref.parentNode.insertBefore(js, ref);
         }(document));
	//Onclick for fb login
 jQuery('.facebook').click(function(e) {
    FB.login(function(response) {
	  if(response.authResponse) {
		  parent.location ='<?php echo base_url(); ?>login/fblogin'; //redirect uri after closing the facebook popup
	  }
 },{scope: 'email,read_stream,publish_stream,user_birthday,user_location,user_work_history,user_hometown,user_photos'}); //permissions for facebook
});
   </script> 
<script src="<?php echo JS;?>select2.min.js"></script> 
<script type="text/javascript">
function select2load(){
//$(".select2-selection__choice").remove(); // clear out values selected
}
</script>
<script>
(function(){
  // setup your carousels as you normally would using JS
  // or via data attributes according to the documentation
  // http://getbootstrap.com/javascript/#carousel
  $('#carousel123').carousel({ interval: 2000 });
})();

(function(){
  $('.carousel-showsixmoveone .item').each(function(){
    var itemToClone = $(this);

    for (var i=1;i<6;i++) {
      itemToClone = itemToClone.next();

      // wrap around if at end of item collection
      if (!itemToClone.length) {
        itemToClone = $(this).siblings(':first');
      }

      // grab item, clone, add marker class, add to collection
      itemToClone.children(':first-child').clone()
        .addClass("cloneditem-"+(i))
        .appendTo($(this));
    }
  });
}());

/*$(".carousel").swipe({

  swipe: function(event, direction, distance, duration, fingerCount, fingerData) {

    if (direction == 'left') $(this).carousel('next');
    if (direction == 'right') $(this).carousel('prev');

  },
  allowPageScroll:"vertical"

});*/
</script>
<script>
function changeLang(ele,lang){
	//alert(lang);
	$.ajax({
		url:"<?php echo base_url('user/changeLanguage'); ?>",
		type:"post",
		dataType:"JSON",
		data : {language:lang},
		success : function(data){
			if(data.status==1){
				 //$(this).parent().parent().prev().html($(this).html() + '<span class="caret"></span>');    
				location.reload();
			}
		}
	});
}
</script>
</body>
</html>