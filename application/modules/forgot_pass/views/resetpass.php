<?php echo $breadcrumb;?>
<script src="<?=JS?>mycustom.js"></script>
<script type="text/javascript">

function loginFormPost(){

FormPost('#submit-check',"<?=VPATH?>","<?=VPATH?>forgot_pass/resetpass",'forgot_pass');

}

</script>
         
<div class="clearfix"></div>
<section class="sec">
<div class="container" style="min-height:300px">
<div class="row">
	<aside class="col col-md-6 offset-md-3"> 
            
      <div class="success alert-success alert" style="display:none"> </div>
      <?php

		$attributes = array('id' => 'forgot_pass','class' => 'form-horizontal','role'=>'form','name'=>'forgot_pass','onsubmit'=>"disable");

		echo form_open('', $attributes);

		?>
      <span id="agree_termsError" class="rerror error alert-error alert" style="display:none"></span>
      
      
      <div class="general-form"> 
      <div class="general-form-body">
      	  <input type="hidden" name="uid" value="<?php echo $user_id?>" />  
          <div class="welcome-text">
               <h3><?php echo __('forgotpass_reset_password','Reset Password'); ?></h3>
           </div>            
           
      	  <div class="form-group" title="Should be at least 8 characters long" data-tippy-placement="bottom">
              <input type="password" class="form-control" value="<?php echo set_value('user_pass');?>" name="user_pass" id="user_pass" placeholder="<?php echo __('forgotpass_enter_new_password','Enter New Password'); ?>" />
              <span id="user_passError" class="rerror"></span>
          </div>                      
          
          <div class="form-group">               
               <input type="password" class="form-control" value="<?php echo set_value('conf_pass');?>" name="conf_pass" id="conf_pass" placeholder="<?php echo __('forgotpass_confirm_new_password','Confirm New Password'); ?>" />
               <span id="conf_passError" class="rerror"></span> 
          </div>
          
          <button type="button" class="btn btn-gradient btn-block button-sliding-icon ripple-effect margin-top-10" id="submit-check" onclick="loginFormPost()"><?php echo __('forgotpass_submit','Submit'); ?> <i class="icon-material-outline-arrow-right-alt"></i></button>
                        
	  </div>
      </div>
      </form>              
    </aside>
</div>
</div>  
</section>

<div class="clearfix"></div>
