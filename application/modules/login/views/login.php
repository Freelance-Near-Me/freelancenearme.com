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
<script type="text/javascript">



function loginFormPost(){

//	alert('alert');

FormPost('#submit-check',"<?=VPATH?>","<?=VPATH?>login/check",'logform');



}

</script>
<script src="<?=JS?>mycustom.js"></script>

<!--<link rel="stylesheet" href="<?=JS?>css/formValidation.css"/>

<script src="<?=JS?>js/formValidation.js"></script>

<script src="<?=JS?>js/bootstrap.validate.js"></script>-->

<section class="sec section gray">

<div class="container">
  <div class="row">
    <aside class="col col-md-6 offset-md-3">
      <div class="general-form">
      <div class="general-form-body">
        <div class="welcome-text">
          <h3>Log In</h3>
        </div>
        <?php

		$attributes = array('id' => 'logform','class' => 'form-horizontal','role'=>'form','name'=>'logform','onsubmit' =>"loginFormPost();return false;");

		echo form_open('', $attributes);

		  ?>
        <div id="agree_termsError" class="error-msg5 error alert-error mb-3" style="display:none"></div>
        <input type="hidden" name="refer" value="<?php echo $refer;?>" readonly="readonly"/>
        <div class="form-group">
          <input type="text" class="form-control" name="username" id="username" placeholder="<?php echo __('login_username','Username'); ?> / <?php echo __('login_email_id','Email ID'); ?>"/>
          <span id="usernameError" class="error-msg13"></span>
        </div>
        <div class="form-group">
          <input type="password" class="form-control" name="password" id="password" placeholder="<?php echo __('login_password','Password'); ?>"/>
          <span id="passwordError" class="error-msg13"></span> </div>
        
        <button type="submit" class="btn btn-gradient btn-block button-sliding-icon ripple-effect margin-top-10"><?php echo __('login_sign_in','Sign In'); ?> <i class="icon-material-outline-arrow-right-alt"></i></button>
        </form>
        <?php /*?><!--login through g+ and facebook -->

		<img id="login-button" disabled src="<?php echo base_url();?>assets/images/sign-in-with-google.png" alt="" style="width: 45%; margin-top: 20px; display: none; pointer: cursor" />

		

		<a href="javascript:void(0);">

			<img id="login-button2" disabled src="<?php echo base_url();?>assets/images/fb-sign-in-button.png" alt="" style="width: 45%; margin-top: 20px; float: right" />

		</a><?php */?>
        
        <!-- Social Login -->
        
        <div class="social-login-separator"><span>Or register via social networks</span></div>
        <div class="social-login-buttons"> 
          <!--<button class="facebook-login ripple-effect"><i class="icon-brand-facebook-f"></i> Log In via Facebook</button>
            <button class="google-login ripple-effect" onclick="facebook_login();"><i class="icon-brand-google-plus-g"></i> Log In via Google+</button>-->
          <button class="facebook-login ripple-effect" onclick="facebook_login();" id="login-button2" ><i class="icon-brand-facebook-f"></i></button>
          <!--<button id="login-button" disabled class="google-login ripple-effect"><i class="icon-brand-google-plus-g"></i></button>-->
        </div>
      </div>
      <div class="general-form-footer">
          <div class="row">
              <div class="col-sm-6"><a href="<?php echo VPATH;?>forgot_pass" class="forgot-password"><?php echo __('login_forget_passowrd','Forgot Password?'); ?></a></div>
              <div class="col-sm-6"><span>Don't have an account? <a href="<?php echo VPATH;?>signup"><?php echo __('signup_register','Register'); ?></a></span></div>
          </div>
      </div>
      </div>
      
    </aside>
  </div>
</div>
</section>
<?php $this->load->view('google_login'); ?>
<div class="clearfix"></div>
<script type="text/javascript">

$(document).ready(function() {

    /* $('#logform').formValidation({
        framework: 'bootstrap',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            username: {
                validators: {
                    notEmpty: {
                        message: '<?php echo __('login_username_field_required','The username or email id is required'); ?>'
                    },
                    stringLength: {
                        min: 6,
                        max: 20,
                        message: '<?php echo __('The username must be more than 6 and less than 12 characters long','The username must be more than 6 and less than 12 characters long'); ?>'
                    },
                    regexp: {
                        regexp: /^[a-zA-Z0-9_\.]+$/,
                        message: '<?php echo __('login_username_field_required_alphabetic_number','The username can only consist of alphabetical, number, dot and underscore'); ?>'
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
            password: {
                validators: {
                    notEmpty: {
                        message: '<?php echo __('login_password_required','The password is required'); ?>'
                    },
                    different: {
                        field: 'username',
                        message: '<?php echo __('login_password_username_required','The password cannot be the same as username'); ?>'
                    },
				}
			},
        }
    }); */
	// Reset form
	/* $('#signUpForm').formValidation('resetForm', true); */

    });



</script>
<?php $this->load->view('facebook_login'); ?>
