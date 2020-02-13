<style>
.input-with-icon-left .error-msg13 {
    position: relative;
    top: -10px;
}
</style>
<script type="text/javascript">
 var RecaptchaOptions = {
    theme : 'white'
 };
 </script>
<?php /* echo $breadcrumb; */?>
<script type="text/javascript">	
function registerFormPost(){
$('.error-msg').html('');
FormPost('#submit-ckck',"<?=VPATH?>","<?=VPATH?>signup/check",'register');
//Recaptcha.reload();
}
function checkuname(user)
 {
	var dataString = 'user='+user;
	$.ajax({
		type:"POST",
		data:dataString,
		url:"<?php echo VPATH;?>signup/usercheck",
		success:function(return_data){
		//  alert(return_data);
			if(return_data==0)
			{
			 //  alert('run');
			  $("#uisname").show();
			  $("#uisname").text("<?php echo __('signup_error_username_exist','This username is already in use, please try another'); ?>");
			  $( "#regusername" ).addClass( "error" );				  
			}else
			{
				$("#uisname").hide();
				$( "#regusername" ).removeClass( "error" );	
				$( "#regusername" ).addClass( "success" );
			}
		}
		})
 }
 function checkemail(email)
 {
	var dataString = 'email='+email;
//	alert(dataString);
	$.ajax({
		type:"POST",
		data:dataString,
		url:"<?php echo VPATH;?>signup/emailcheck",
		success:function(return_data){			
		//alert(return_data);
			if(return_data==0)
			{
			  $("#umail").show();
			  $("#umail").text("<?php echo __('signup_error_email_exist','This email is already in use, please try another'); ?>");
			  $( "#email" ).addClass( "error" );				  
			}else
			{
				$("#umail").hide();
				$( "#email" ).removeClass( "error" );	
			   $( "#email" ).addClass( "success" );
			}
		}
		})
 }
</script>      
<script src="<?=JS?>mycustom.js"></script>	        
			 	
<!--ProfileRight Start-->
<div class="profile_right" style="margin-top:0px !important;">
<div class="success alert-success alert" style="display:none"></div> 
<div id="signupForm">
<section class="sec section gray">
<div class="container"><?php /* echo 'test'; */if(isset($acc_type)){	if($acc_type == 'E'){		?>		<script>		$(document).ready(function(){			$("#employer-radio").prop("checked", true);		})		</script>		<?php	} else if($acc_type == 'F') {		?>		<script>		$(document).ready(function(){			$("#freelancer-radio").prop("checked", true);		})		</script>		<?php	}}?>
<div class="row">
	<aside class="col col-md-6 offset-md-3">
        <div class="success alert-success alert" style="display:none"></div> 
        <div class="general-form"> 
        <div class="general-form-body"> 
        <div class="welcome-text">
            <h3><?php echo __('signup_register','Register'); ?></h3>             
        </div>        
                       
        <!--<form class="form-horizontal" id="signUpForm">-->
        <?php $attributes = array('id' => 'register','class' => 'form-horizontal','role'=>'form','name'=>'register','onsubmit' =>"registerFormPost();return false;");
echo form_open('', $attributes);

?> 

    <!-- Account Type -->
    <div class="account-type">
        <div>
            <input type="radio" name="account_type" value="F" id="freelancer-radio" class="account-type-radio" checked/>
            <label for="freelancer-radio" class="ripple-effect-dark"><i class="icon-material-outline-account-circle"></i> Freelancer</label>
        </div>
        <div>
            <input type="radio" name="account_type" value="E" id="employer-radio" class="account-type-radio"/>
            <label for="employer-radio" class="ripple-effect-dark"><i class="icon-material-outline-business-center"></i> Employer</label>
        </div>
    </div>

    	<div class="row row-10">
        <div class="col-md-6">
        <div class="input-with-icon-left">
            <input type="text" class="form-control" value="<?php echo set_value('fname');?>" id="fname" name="fname" placeholder="<?php echo __('signup_first_name','First Name'); ?>"/>
            <span id="fnameError" class="error-msg13"></span>
        </div>
        </div>
		<div class="col-md-6">
        <div class="input-with-icon-left">
            <input type="text" class="form-control" value="<?php echo set_value('lname');?>" id="lname" name="lname" placeholder="<?php echo __('signup_last_name','Last Name'); ?>"/>
            <span id="lnameError" class="error-msg13"></span>
        </div>
        </div>
        </div>

        <div class="input-with-icon-left">
            <input type="text" class="form-control" value="<?php echo set_value('regusername');?>" id="regusername" name="regusername" onblur="checkuname(this.value)" placeholder="<?php echo __('signup_username','Username'); ?>"/>
            <span id="uisname" style="display:none;" class="errormsg13 rerror"></span>
			<span id="regusernameError" class="error-msg13"></span>
        </div>                


        <div class="input-with-icon-left">

            <input type="text" class="form-control" value="<?php echo set_value('email');?>" name="email" id="email" onblur="checkemail(this.value)" placeholder="<?php echo __('signup_email_id','Email ID'); ?>"/>

            <span id="umail" style="display:none;" class="errormsg13 rerror"></span>

			<span id="emailError" class="error-msg13"></span>

        </div>


        <div class="input-with-icon-left">

            <input type="email" class="form-control" name="cnfemail" id="cnfemail" placeholder="<?php echo __('signup_conf_email_id','Confirm Email ID'); ?>"/>

            <span id="cnfemailError" class="error-msg13"></span>

        </div>        

        
        <div class="input-with-icon-left" title="Should be at least 8 characters long" data-tippy-placement="bottom">

            <input type="password" class="form-control" name="regpassword" id="regpassword" placeholder="<?php echo __('signup_password','Password'); ?>"/>

        	<span id="regpasswordError" class="error-msg13"></span>

        </div>


        <div class="input-with-icon-left">

            <input type="password" class="form-control" name="cpassword" id="cpassword" placeholder="<?php echo __('signup_conf_password','Confirm Password'); ?>"/>

            <span id="cpasswordError" class="error-msg13"></span>

        </div>

        <div class="form-group">

            <select class="with-border" id="country" name="country" onchange="citylist(this.value)">

                <?php foreach($country_list as $k => $v){ ?>

                <option value="<?php echo $v['code']; ?>"><?php echo $v['name']; ?></option>

                <?php } ?>

            </select>

            <span id="countryError" class="error-msg13"></span>

        </div>
        <div class="form-group">            	    	
            <select class="with-border" id="city" name="city">
            <option> --<?php echo __('signup_select_city','Select City') ?>--</option>	
            </select>
            <span id="cityError" class="error-msg13"></span>
        </div>
        <div class="form-group">

            <div class="checkbox checkbox-inline">                								            	

            <input class="magic-checkbox" type="checkbox" name="termsandcondition" value="Y" id="termsandcondition">

            <label for="termsandcondition" ><?php echo __('signup_tc_conf','By registering you confirm that you accept the') ?> 

                <a href="<?php echo VPATH;?>information/info/terms_condition" target="_blank"><?php echo __('signup_terms_&_conditions','Terms & Conditions') ?></a> &amp; 

                <a href="<?php echo VPATH;?>information/info/privacy_policy" target="_blank"><?php echo __('signup_privecy_policy','Privacy Policy'); ?></a>.                                 
            </label>
            </div>

            <br />

            <span id="termsandconditionError" class="error-msg13 rerror"></span>            	        		

		</div>
                

        <button type="submit" id="submit-ckck" class="margin-top-10 btn btn-gradient btn-block button-sliding-icon ripple-effect"><?php echo __('signup_register','Register'); ?> <i class="icon-material-outline-arrow-right-alt"></i></button>
         
	  </form>
      <!-- Social Login -->  
        <div class="social-login-separator"><span>Or register via social networks</span></div>

        <div class="social-login-buttons">
            <!--<button class="facebook-login ripple-effect"><i class="icon-brand-facebook-f"></i> Register via Facebook</button>
            <button class="google-login ripple-effect"><i class="icon-brand-google-plus-g"></i> Register via Google+</button>-->
			<button class="facebook-login ripple-effect" onclick="facebook_login();" id="login-button2"><i class="icon-brand-facebook-f"></i></button>
            <!--<button id="login-button" disabled class="google-login ripple-effect"><i class="icon-brand-google-plus-g"></i></button>-->
        </div> 
      </div>
        <div class="general-form-footer text-center">
              <span>Already have an account? <a href="<?php echo VPATH;?>login"><?php echo __('login_sign_in','Sign In'); ?></a></span>
        </div>
        </div>
        <input type="hidden" name="account_type" id="account_type" value="freelancer" />

                   
	</aside>

</div>

</div>  

</section>



<!--SingupLeft End-->



</div>

<?php //$this->load->view('google_login'); ?>
<?php $this->load->view('facebook_login'); ?>

<div class="clearfix"></div>

<!--SingupRight Start--> 

<?php /*?><div class="rightlogin" style="width:100%;">

<div class="signtext"><h2>How it works for employer</h2>

<div class="logimg"><img title="" alt="" src="<?php echo ASSETS;?>images/postright_bg2.png"></div>

<div class="signbuttons"><button type="button" id="freelancer" class="btn-normal btn-color submit  bottom-pad" value="employee" onclick="setAccountType(this.value)">HIRE</button></div>

</div>





<div class="signtext"><h2>How it works for Freelancer</h2>

<div class="logimg"><img title="" alt="" src="<?php echo ASSETS;?>images/works_freelancerbg.png"></div>

<div class="signbuttons"><button type="button" id="freelancer" class="btn-normal btn-color submit  bottom-pad" value="freelancer" onclick="setAccountType(this.value)">WORK</button></div>

</div>



</div><?php */?>





<?php /*?><section class="sec signup hidden-xs" id="work_hire">

<div class="container">

<div class="row">

	<aside class="col-sm-6 col-xs-12" data-effect="slide-left">

    	<div class="for-employer">   

        <h3><?php echo __('signup_how_it_works_for_employer','How it works for employer'); ?></h3>

        <div class="row"> 

              <article class="col-sm-5 col-xs-12">                

                <img src="<?php echo VPATH;?>assets/images/post-jobs.png" alt="">

                <h5><a href="javascript:void(0);"><?php echo __('signup_post_job','Post Jobs'); ?></a></h5>

              </article>

              <article class="col-sm-5 col-xs-12 pull-right">

                <img src="<?php echo VPATH;?>assets/images/manage-bids.png" alt="">

                <h5><a href="#"><?php echo __('signup_manage_bids','Manage Bids'); ?></a></h5>

              </article>

              <div class="clearfix"></div>

              	<a href="JavaScript:Void(0);" class="btn btn-site" id="employee" value="employee" onclick="setAccountType('E')"><?php echo __('signup_hire','Hire'); ?></a>

              <div class="clearfix"></div>

              <article class="col-sm-5 col-xs-12">                

                <img src="<?php echo VPATH;?>assets/images/get-payment.png" alt="">

                <h5><a href="javascript:void(0);"><?php echo __('signup_get_paid','Get Payment'); ?></a></h5>

              </article>

              <article class="col-sm-5 col-xs-12 pull-right">

                <img src="<?php echo VPATH;?>assets/images/service-provider.png" alt="">

                <h5><a href="javascript:void(0);"><?php echo __('signup_service_provider','Service Provider'); ?></a></h5>

              </article>

          </div>

                             

        </div>

	</aside>



	<aside class="col-sm-6 col-xs-12" data-effect="slide-right">

    	<div class="for-freelancer">     

    	<h3><?php echo __('signup_how_it_works_for_freelancer','How it works for freelancer'); ?></h3>

		<div class="row"> 

              <article class="col-sm-5 col-xs-12">                

                <img src="<?php echo VPATH;?>assets/images/post-jobs.png" alt="">

                <h5><a href="javascript:void(0);"><?php echo __('signup_search_jobs','Search Jobs'); ?></a></h5>

              </article>

              <article class="col-sm-5 col-xs-12 pull-right">

                <img src="<?php echo VPATH;?>assets/images/place-bids.png" alt="">

                <h5><a href="#"><?php echo __('signup_place_bids_on_jobs','Place Bid on Jobs'); ?></a></h5>

              </article>

              <div class="clearfix"></div>

              	<a href="JavaScript:Void(0);" class="btn btn-primary" id="freelancer"  onclick="setAccountType('F')"><?php echo __('signup_work','Work'); ?></a>

              <div class="clearfix"></div>

              <article class="col-sm-5 col-xs-12">                

                <img src="<?php echo VPATH;?>assets/images/get-payment-02.png" alt="">

                <h5><a href="JavaScript:Void(0);"><?php echo __('signup_get_paid','Get Payment'); ?></a></h5>

              </article>

              <article class="col-sm-5 col-xs-12 pull-right">

                <img src="<?php echo VPATH;?>assets/images/worker.png" alt="">

                <h5><a href="JavaScript:Void(0);"><?php echo __('signup_do_work_for_employer','Do Work for Employer'); ?></a></h5>

              </article>

          </div>  

                       

		</div>

	</aside>

</div>

</div>  

</section>



<section class="sec signup hidden-sm hidden-md hidden-lg" id="work_hireMobile">

<ul class="nav nav-tabs" role="tablist">

    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab"><?php echo __('signup_employer','Employer'); ?></a></li>

    <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab"><?php echo __('signup_freelancer','Freelancer'); ?></a></li>

</ul>

<div class="container">

  

  <div class="tab-content">

    <div role="tabpanel" class="tab-pane active" id="home">

    	<div class="row">

        <aside class="col-sm-6 col-xs-12" style="background-color: #2C597A;">

        <div class="for-employer">   

        <h3><?php echo __('signup_how_it_works_for_employer','How it works for employer'); ?></h3>

        <div class="row"> 

              <article class="col-sm-5 col-xs-12">                

                <img src="<?php echo VPATH;?>assets/images/post-jobs.png" alt="">

                <h5><a href="JavaScript:Void(0);"><?php echo __('signup_post_job','Post Jobs'); ?></a></h5>

              </article>

              <article class="col-sm-5 col-xs-12 pull-right">

                <img src="<?php echo VPATH;?>assets/images/manage-bids.png" alt="">

                <h5><a href="JavaScript:Void(0);"><?php echo __('signup_manage_bids','Manage Bids'); ?></a></h5>

              </article>

              <div class="clearfix"></div>

              	<a href="JavaScript:Void(0);" class="btn btn-site" id="employee" value="employee" onclick="setAccountType('E')">Hire</a>

              <div class="clearfix"></div>

              <article class="col-sm-5 col-xs-12">                

                <img src="<?php echo VPATH;?>assets/images/get-payment.png" alt="">

                <h5><a href="JavaScript:Void(0);"><?php echo __('signup_get_paid','Get Payment'); ?></a></h5>

              </article>

              <article class="col-sm-5 col-xs-12 pull-right">

                <img src="<?php echo VPATH;?>assets/images/service-provider.png" alt="">

                <h5><a href="JavaScript:Void(0);"><?php echo __('signup_service_provider','Service Provider'); ?></a></h5>

              </article>

          </div>                             

        </div>

        </aside>

        </div>

    </div>

    <div role="tabpanel" class="tab-pane" id="profile">

    	<div class="row">

        <aside class="col-sm-6 col-xs-12" style="background-color: #29b6f6;">

    	<div class="for-freelancer">     

    	<h3><?php echo __('signup_how_it_works_for_freelancer','How it works for freelancer'); ?></h3>

		<div class="row"> 

              <article class="col-sm-5 col-xs-12">                

                <img src="<?php echo VPATH;?>assets/images/post-jobs.png" alt="">

                <h5><a href="JavaScript:Void(0);"><?php echo __('signup_search_jobs','Search Jobs'); ?></a></h5>

              </article>

              <article class="col-sm-5 col-xs-12 pull-right">

                <img src="<?php echo VPATH;?>assets/images/place-bids.png" alt="">

                <h5><a href="JavaScript:Void(0);"><?php echo __('signup_place_bids_on_jobs','Place Bid on Jobs'); ?></a></h5>

              </article>

              <div class="clearfix"></div>

              	<a href="JavaScript:Void(0);" class="btn btn-primary" id="freelancer"  onclick="setAccountType('F')">Work</a>

              <div class="clearfix"></div>

              <article class="col-sm-5 col-xs-12">                

                <img src="<?php echo VPATH;?>assets/images/get-payment-02.png" alt="">

                <h5><a href="JavaScript:Void(0);"><?php echo __('signup_get_paid','Get Payment'); ?></a></h5>

              </article>

              <article class="col-sm-5 col-xs-12 pull-right">

                <img src="<?php echo VPATH;?>assets/images/worker.png" alt="">

                <h5><a href="JavaScript:Void(0);"><?php echo __('signup_do_work_for_employer','Do Work for Employer'); ?></a></h5>

              </article>

          </div>  

                       

		</div>

        </aside>

        </div>

	</div>

  </div>

</div>  

</section><?php */?>



<div class="clearfix"></div>

                       

<!--ProfileRight Start-->                       

<div class="clearfix"></div>

<?php 



if(isset($ad_page)){ 

$type=$this->auto_model->getFeild("type","advartise","","",array("page_name"=>$ad_page,"add_pos"=>"M"));

if($type=='A') 

{

$code=$this->auto_model->getFeild("advertise_code","advartise","","",array("page_name"=>$ad_page,"add_pos"=>"M")); 

}

else

{

$image=$this->auto_model->getFeild("banner_image","advartise","","",array("page_name"=>$ad_page,"add_pos"=>"M"));

$url=$this->auto_model->getFeild("banner_url","advartise","","",array("page_name"=>$ad_page,"add_pos"=>"M")); 

}

	

  if($type=='A'&& $code!=""){ 

?>

<div class="addbox2">

<?php 

echo $code;

?>

</div>                      

<?php                      

  }

elseif($type=='B'&& $image!="")

{

?>

	<div class="addbox2">

	<a href="<?php echo $url;?>" target="_blank"><img src="<?=ASSETS?>ad_image/<?php echo $image;?>" alt="" title="" /></a>

	</div>

	<?php  

}

}



?>

<div class="clearfix"></div>

</div>

          



<script type="text/javascript">

$(document).ready(function() {

    /* $('#register').formValidation({
        framework: 'bootstrap',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
			fname: {
				row: '.col-12',
				validators: {
					notEmpty: {
						message: 'The first name is required'
					}
				}
			},
			lname: {
				row: '.col-xs-12',
				validators: {
					notEmpty: {
						message: 'The last name is required'
					}
				}
			},
            regusername: {
                validators: {
                    notEmpty: {
                        message: 'The username is required'
                    },
                    stringLength: {
                        min: 6,
                        max: 30,
                        message: 'The username must be more than 6 and less than 30 characters long'
                    },
                    regexp: {
                        regexp: /^[a-zA-Z0-9_\.]+$/,
                        message: 'The username can only consist of alphabetical, number, dot and underscore'
                    }
                }
            },
            email: {
                validators: {
                    notEmpty: {
                        message: 'The email address is required'
                    },
                    emailAddress: {
                        message: 'The input is not a valid email address'
                    }
                }
            },
            regpassword: {
                validators: {
                    notEmpty: {
                        message: 'The password is required'
                    },
                    different: {
                        field: 'username',
                        message: 'The password cannot be the same as username'
                    },
					identical: {
						field: 'confirmPassword',
						message: 'The password and its confirm are not the same'
                	}
				}
			},	
			confirmPassword: {
				validators: {
					identical: {
						field: 'password',
						message: 'The password and its confirm are not the same'
					}
				}
			}
        }
    }); */
});



</script>



<script>

  function showState(v){ 

	  if(v!="Nigeria"){ 

		  $("#state_div").hide();

	  }

	  else{ 

		$("#state_div").show();

	  }

  }

  function setAccountType(accounttype){

	  $("#account_type").val(accounttype);

	//alert(accounttype);

	  $("#work_hire, #work_hireMobile").hide();

	  $("#signupForm").show();

  }

function citylist(country)

{	var dataString = 'cid='+country;

  $.ajax({

     type:"POST",

     data:dataString,

     url:"<?php echo base_url();?>login/getcity/"+country,

     success:function(return_data)

     {

	 	//alert(return_data);

      	$('#city').html('');

		$('#city').html(return_data);

     }

    });

}





</script>