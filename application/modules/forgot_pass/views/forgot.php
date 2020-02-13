<style>
.input-with-icon-left .rerror {
    position: relative;
    top: -10px;
}
</style>
<script type="text/javascript">
function loginFormPost(){
	FormPost('#submit-check',"<?=VPATH?>","<?=VPATH?>forgot_pass/check",'forgotPass');
}
</script>
<script src="<?=JS?>mycustom.js"></script>
<script src="<?php echo JS;?>formValidation.js"></script>
<script src="<?php echo JS;?>bootstrap.validate.js"></script>

<section class="sec section gray">
  <div class="container" style="min-height:300px">
    <div class="row">
      
      <aside class="col col-md-6 offset-md-3"> 
        <div class="success alert-success alert" style="display:none"> <?php echo __('forgotpass_new_password_has_been_sent_to_your_email','New password was sent to your email.'); ?></div>
        <?php $attributes = array('id' => 'forgotPass','class' => 'form-horizontal','role'=>'form','name'=>'register','onsubmit'=>"disable");
        echo form_open('', $attributes);
        ?>
        <!--<h3 class="form-title">Forgot Password</h3>-->
        <div class="general-form">
        <div class="general-form-body">
          <!-- Welcome Text -->
          <div class="welcome-text">
			 <h3><?php echo __('login_forget_passowrd','Forgot Password?'); ?></h3>
             <span><?php echo __('forgotpass_to_recover_your_password_end_text','To recover your password, enter the email address associated with your account.'); ?></span>
          </div>
          <div class="form-group">               
               <input type="email" class="form-control" value="<?php echo set_value('user_email');?>" name="user_email" id="user_email" placeholder="<?php echo __('forgotpass_email_id','Email ID'); ?>" />
               <span id="agree_termsError" class="rerror"></span> <span id="user_emailError" class="rerror"></span>
          </div>
          <span><?php echo __('forgotpass_go_back_to','Go back to'); ?> <a href="<?php echo VPATH;?>login"><?php echo __('forgotpass_sign_in','Sign In'); ?></a></span>
          
          <button type="submit" id="submit-check" class="btn btn-gradient btn-block button-sliding-icon ripple-effect margin-top-10" onclick="loginFormPost()"><?php echo __('forgotpass_submit','Submit'); ?> <i class="icon-material-outline-arrow-right-alt"></i></button>
          
        </div>
        </div>
        </form>
      </aside>
    </div>
  </div>
</section>
<?php /*?><div class="container">
      <div class="row">
     <div class="col-lg-8 col-md-8 col-sm-6 col-xs-12" id="contact-form" style="width:100%;">
       <h3 class="title">Forgot Password</h3>
        <div class="loginright"></div>
      
        
        <?php $attributes = array('id' => 'register','class' => 'form-horizontal','role'=>'form','name'=>'register','onsubmit'=>"disable");
        echo form_open('', $attributes);
        ?>
     <span id="agree_termsError" class="rerror error alert-error alert" style="display:none"></span>
        
        <div class="divider"></div>
           <fieldset>              
             
              <div class="row">
              <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">                                        
                    <label>Enter Your Email: <span>*</span></label>
                    <input class="form-control" id="user_email" name="user_email" type="text" value="<?php echo set_value('user_email');?>" required tooltipText="Enter Your registered email id" /> 
                    
                </div>
              </div>
              
           </fieldset>
           <input class="btn-normal btn-color submit  bottom-pad" type="button" value="Submit" />  
           <a class="btn-normal btn-color submit  bottom-pad" href="<?php echo VPATH;?>login">Cancel</a>
           
           <div class="clearfix">
           
           </div>
        </form>
     </div>
  </div>
</div><?php */?>
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
<div class="addbox2"> <a href="<?php echo $url;?>" target="_blank"><img src="<?=ASSETS?>ad_image/<?php echo $image;?>" alt="" title="" /></a> </div>
<?php  
 }
  }

?>
<div class="clearfix"></div>
<script type="text/javascript">
$(document).ready(function() {
    $('#forgotPass').formValidation({
        framework: 'bootstrap',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        
        fields: {                
            
            user_email: {
                validators: {
                    notEmpty: {
                        message: '<?php echo __('forgotpass_the_email_address_is_required','The email address is required'); ?>'
                    },
                    emailAddress: {
                        message: '<?php echo __('forgotpass_the_input_is_not_a_valid_email_address','The input is not a valid email address'); ?>'
                    }
                }
            }            			
					
        }
    });
   
});

</script>