<link rel="stylesheet" href="<?php echo ASSETS;?>plugins/taginput/tokenize2.min.css" type="text/css" />
<script src="<?php echo ASSETS;?>plugins/taginput/tokenize2.min.js" type="text/javascript"></script>
<!--<script src="<?php echo JS;?>formValidation.js"></script>
<script src="<?php echo JS;?>bootstrap.validate.js"></script>-->
<style>
.item.selected {
    background-color: #e2dfdf;
}
.invalid {
    border: 1px solid red;
}
</style>
<?php $lang=$this->session->userdata('lang'); ?>

<div class="dashboard-container">
<?php $this->load->view('dashboard/dashboard-left'); ?>
<div class="dashboard-content-container">
    <div class="dashboard-content-inner" >
    <!-- Dashboard Headline -->
	<?php echo $breadcrumb; ?>

		<div class="alert alert-success text-center" style="display:none;"><i class="fa fa-check-circle"></i> Your message has been sent successfully.</div>
			<?php
			$attributes = array('id' => 'postjob_frm','class' => 'form-horizontal margin-bottom-30','role'=>'form','name'=>'postjob_frm','onsubmit'=>"disable",'enctype'=>'multipart/form-data');
			echo form_open('', $attributes);
			?>        
        <div class="post-form">
     	<span id="agree_termsError" class="rerror error alert-error alert" style="display:none"></span>
		<span id="limit_termsError" class="rerror error alert-error alert" style="display:none"></span> 
		<span id="job_det">
		
		<div class="form-group">        	
            <label for="" class="control-label"><?php echo __('postjob_experience_level','Experience level'); ?>:</label>            	
            
            <?php
            $exp_levels = get_results(array('select' => '*', 'from' => 'experience_level', 'where' => array('status' => 'Y')));
            
            if(count($exp_levels) > 0){foreach($exp_levels as $k => $v){ 
            ?>
            <div class="checkbox radio-inline">
                <input class="magic-radio" type="radio" name="exp_level" data-text="<?php echo $v['name'];?>" value="<?php echo $v['id'];?>" id="exp_level_<?php echo $v['id'];?>"  <?php echo $k == 0 ? 'checked="checked"' : '';?>>
                <label title="<?php echo $v['description']; ?>" for="exp_level_<?php echo $v['id'];?>"> <?php echo $v['name'];?>
                <a href="javascript:void(0)" rel="infopop" data-toggle="popover" title="" data-placement="right" data-content="<?php echo $v['description']; ?>" data-original-title="<?php echo $v['name']; ?>"><i class="icon-feather-info fa-lg"></i></a>
                </label>
                
            </div>
            <?php } } ?>				                    	        	
        </div>
		
        <div class="form-group">        	
            <label for="" class="control-label"><?php echo __('postjob_project_title','Project Title'); ?>:</label>            	
            <input type="text" class="with-border" value="" name="title" id="title">
            <span id="titleError" class="error-msg13 rerror"></span>                        	        	
        </div>
		
        <div class="form-group">        	
            <label for="" class="control-label"><?php echo __('postjob_description_your_project_in_details','Describe Your Project in Detail'); ?>:</label>            	
            <textarea class="with-border" rows="3" name="description" id="description"></textarea>
            <span id="descriptionError" class="error-msg13 rerror"></span>
        </div>
        
        <div class="form-group">        	
            <div class="submit-field">
                <div class="uploadButton margin-top-30">
                    <input type="file" class="uploadButton-input" accept="image/*, pdf" name="userfile" id="userfile" onchange="movefile(this)" />
                    <input type="hidden" id="upload_file" name="upload_file" value="">
                    <label for="userfile" class="uploadButton-button ripple-effect">Upload Files</label>
                    <span class="uploadButton-file-name"><?php echo __('postjob_attachment','Attachment'); ?></span>
                </div>
            </div>                            	            	                								
            <div style="display: none;" id="flist_div"> </div>
        </div>
       
	   
	   <div class="form-group">
            <label><?php echo __('postjob_select_skills','Select Skill'); ?>: </label>
            <select class="with-border inputtag" name="subskill[]" multiple></select>
            <span id="subskill_idError" class="error-msg13 rerror"></span>
		</div>
		  
        <div class="row margin-bottom-20">        	
        	<div class="col-sm-4">
            	<p><?php echo __('postjob_project_environment','Project Environment'); ?>:</p>   
                <div class="checkbox radio-inline">
                    <input class="magic-radio" type="radio" name="environment" value="ON" id="1" checked>
                    <label for="1"> <?php echo __('postjob_online','Online'); ?></label>
                </div> 
                <div class="checkbox radio-inline">
                    <input class="magic-radio" type="radio" name="environment" id="2" value="OFF">
					<label for="2"> <?php echo __('postjob_offline','Offline'); ?></label>
                </div>                        	                                
        	</div>
            <div class="col-sm-4">
            	<p><?php echo __('postjob_project_visibility','Project Visibility'); ?>:</p>   
                <div class="radio radio-inline">
                    <input class="magic-radio" type="radio"  name="visibility" value="Public" id="3" checked>
                    <label for="3"> <?php echo __('postjob_public','Public'); ?></label>
                </div> 
                <div class="radio radio-inline">
                    <input class="magic-radio" type="radio" name="visibility" id="4" value="Private">
					<label for="4"> <?php echo __('postjob_private','Private'); ?></label>
                </div>                        	                                
        	</div>
            <div class="col-sm-4">
            	<p><?php echo __('postjob_project_type','Project Type'); ?>:</p>   
                <div class="radio radio-inline">
                    <input class="magic-radio" type="radio" name="project_type" value="F" id="5" checked>
                    <label for="5"> <?php echo __('postjob_fixed','Fixed'); ?></label>
                </div> 
                <div class="radio radio-inline">
                    <input class="magic-radio" type="radio" name="project_type" value="H" id="6">
					<label for="6"> <?php echo __('postjob_hourly','Hourly'); ?></label>
                </div>                        	                                
        	</div>
        </div>
		
		<div class="row form-group" id="hourly_budget" style="display:none;">        	
			<div class="col-6">
				<label for="" class="control-label"><?php echo __('postjob_minimum_budget','Minimum Budget'); ?></label>            	
				<input type="text" class="with-border" name="budget_min" value="0"/>
				<span id="budgetminError" class="error-msg7"></span>
				
			</div>
			<div class="col-6">
				<label for="" class="control-label"><?php echo __('postjob_miximum_budget','Maximum Budget'); ?></label>            	
				<input type="text" class="with-border" name="budget_max" value="0"/>
				<span id="budgetmaxError" class="error-msg7"></span>
			</div>
			
			<div class="login_form logi_width multi_freelancer" style="display: none;">
				<p><?php echo __('postjob_multi_freelancer','Multi-freelancer'); ?> :<span style="color:#F00">*</span></p>
				<input type="radio" name="multi_freelancer" class="acount-radio2" value="Y" checked="checked" onchange="getMulti(this.value)"> <?php echo __('postjob_yes','Yes'); ?>  
				<input type="radio" name="multi_freelancer" class="acount-radio2" value="N" onchange="getMulti(this.value)"> <?php echo __('postjob_no','No'); ?> 
				 <span id="multi_freelancerError" class="error-msg7"></span> 
			</div>
			
			<div class="col-6">
				<label for="" class="control-label"><?php echo __('postjob_number_of_freelancer','Number Of Freelancer'); ?></label>            	
				<input type="text" class="with-border" name="no_of_freelancer" value="1"/>
				<span id="no_of_freelancerError" class="error-msg7"></span>
			</div>
			
			<div class="col-6">
				<label for="" class="control-label"><?php echo __('postjob_hours_per_week','Hours per week'); ?></label>            	
				<input type="text" class="with-border" name="hr_per_week" placeholder="<?php echo __('postjob_hr_per_week','hr/week'); ?>"/>
				<span id="hr_per_weekError" class="error-msg7"></span>
			</div>
			
		</div>
		
		
        <div class="form-group" id="fixed_budget">        	
       
            	<label for="" class="control-label"><?php echo __('postjob_what_is_your_budget','What is your budget?'); ?></label>            	
        		<select class="with-border" name="budgetall" id="budgetall">
                	<option value="0" selected="">--- <?php echo __('postjob_please_select','Please Select'); ?> ---</option>
					<option value="0#100"><?php echo __('postjob_less_then','Less than'); ?> <?php echo CURRENCY;?> 100</option>
					<option value="100#250"><?php echo __('postjob_between','Between'); ?> <?php echo CURRENCY;?> 100 <?php echo __('postjob_and','and'); ?> <?php echo CURRENCY;?> 250</option>
					<option value="250#500"><?php echo __('postjob_between','Between'); ?> <?php echo CURRENCY;?> 250 <?php echo __('postjob_and','and'); ?> <?php echo CURRENCY;?> 500</option>
					<option value="500#1000" ><?php echo __('postjob_between','Between'); ?> <?php echo CURRENCY;?> 500 <?php echo __('postjob_and','and'); ?> <?php echo CURRENCY;?> 1,000</option>
					<option value="1000#2500" ><?php echo __('postjob_between','Between'); ?> <?php echo CURRENCY;?> 1,000 <?php echo __('postjob_and','and'); ?> <?php echo CURRENCY;?> 2,500</option>
					<option value="2500#5000" ><?php echo __('postjob_between','Between'); ?> <?php echo CURRENCY;?> 2,500 <?php echo __('postjob_and','and'); ?> <?php echo CURRENCY;?> 5,000</option>
					<option value="5000#10000" ><?php echo __('postjob_between','Between'); ?> <?php echo CURRENCY;?> 5,000 <?php echo __('postjob_and','and'); ?> <?php echo CURRENCY;?> 10,000</option>
					<option value="10000#25000" ><?php echo __('postjob_between','Between'); ?> <?php echo CURRENCY;?> 10,000 <?php echo __('postjob_and','and'); ?> <?php echo CURRENCY;?> 25,000</option>
					<option value="25000#" ><?php echo __('postjob_over','Over'); ?>  <?php echo CURRENCY;?> 25,000</option>
					<option value="other" style="display:none;"><?php echo __('postjob_optional_enter_exact_amount','Optional (Enter exact amount)'); ?></option>
                </select>
				<span id="budgetallError" class="error-msg13 rerror"></span>
        				
                <div id="budget_other" style="display:none">
                    <label for="" class="control-label"><?php echo __('postjob_budget_amount','Budget Amount'); ?></label>            	
                    <input class="with-border fixed_budeget" id="fixed_budeget" type="text" name="fixed_budeget" value="0" placeholder="<?php echo __('postjob_budget_amount','Budget Amount'); ?>">
                </div>
			
        </div>
		
		<div id="f_q_wapper"></div>
        
		<button class="btn btn-site margin-bottom-20" type="button" onclick="addQuestion()" id="add_qs_btn">Questions for freelancer <i class="zmdi zmdi-plus-circle-o"></i></button>
        
		
        <h5 class="text-uppercase b"><?php echo __('postjob_invite_user','Invite User'); ?></h5>
        
        <div class="ui fluid selection dropdown">
          <input type="hidden" name="user">
          <i class="dropdown icon"></i>
          <input type="text" class="with-border" placeholder="<?php echo __('postjob_search_user_by_name_and_email','Search user by name or email'); ?>" onkeyup="search_freelancer(this.value)"/>
          <div class="menu" id="freelancer_list" style="display:none"></div>
		  <div class="menu" id="selected_freelancer_list" style="display:none">
          </div>
        </div>

        <br />
        <h5 class="text-uppercase b"><?php echo __('postjob_promote_your_listing_optional','Promote your listing (Optional)'); ?></h5>
        
		<?php
		if($this->session->userdata('user'))
		{
		?>
		 <input type="hidden" name="user_id" value="<?php echo $user_id;?>"/>
		 <?php
		 }
		 ?>
	 
        <div class="form-group">        	
              <div class="checkbox checkbox-inline">
                <input class="magic-checkbox" type="checkbox" name="featured" id="featured1" value="Y" onchange="checkPrice(this)">
                <label for="featured1"> <img src="<?php echo VPATH;?>assets/images/featured_new.png" alt="" style="float:left">
            <?php echo __('postjob_featured_project_text','I want my project to be listed as a featured project. Featured projects attract more, higher quality bids. They appear prominently on the website.'); ?>
            </label>
              </div>                       
        </div>
		
		<div>
		<p id="featured_price_p_fixed" style="display:none;">Price to pay
			<span class=""><b><?php echo CURRENCY.''.FIXED_RATE; ?></b></span>
		</p>
		
		<p id="featured_price_p_hourly" style="display:none;">Price to pay
			<span  class="" ><b><?php echo  CURRENCY.''.HOURLY_RATE; ?></b></span>
		</p>
			
		</div>
		<div id="fundError" class="error-msg13 rerror"></div>
		</span>
		
		<!-- preview section -->
		<div class="preview_div" id="preview_div" style="display:none;">
		<h3 class="title-sm"><?php echo __('postjob_preview','PREVIEW'); ?></h3>
		<div class="labelBlock" id="labelBlock">
		<p><label> <?php echo __('postjob_project_title','Project Title'); ?> :</label><span id="p_title"></span></p>
		
		<p><label> <?php echo __('postjob_experience_level','Experience level'); ?> :</label><span id="p_exp_level"></span></p>
		
		
		<p><label> <?php echo __('postjob_your_project_in_details','Your Project in Detail'); ?>:</label><span id="p_description"></span></p>
		
		<p><label> <?php echo __('postjob_skills','Skills'); ?> :</label><span id="p_select2-search__field"></span></p>
		<p><label> <?php echo __('postjob_project_environment','Project Environment'); ?> :</label><span id="p_environment"></span></p>
		<p><label> <?php echo __('postjob_project_visibility','Project Visibility'); ?> :</label><span id="p_visibility"></span></p>
		<p><label> <?php echo __('postjob_project_type','Project Type'); ?> :</label><span id="p_project_type"></span></p>
		</div>
		</div>		        
       </div>
       <button type="button" class="btn btn-site" id="submit-check" onclick="JobFormPost()"><?php echo __('postjob_submit','SUBMIT'); ?></button>&nbsp;
        <button type="button" class="btn btn-site" id="edit-preview" onclick="EditJobFormPost()" style="display:none;"><?php echo __('postjob_edit','Edit'); ?></button>      
        <button type="button" class="btn btn-web" id="preview-check" onclick="PreviewJobFormPost()"><?php echo __('postjob_preview','PREVIEW'); ?></button>
        <a class="btn btn-warning hide" href="<?php echo base_url('dashboard/dashboard_new'); ?>"><?php echo __('postjob_cancel','CANCEL'); ?></a>
	  </form>
</div>
</div>
</div>  
</section>

<script src="<?=JS?>mycustom.js"></script>
<script type="text/javascript">
 var RecaptchaOptions = {
    theme : 'white'
 };
 
 
 </script>
        
    <script type="text/javascript">
	
	$('.inputtag').tokenize2({
		placeholder: "<?php echo __('postjob_select_a_skill','Select a Skill'); ?>",
		dataSource: function(search, object){
			$.ajax({
				url : '<?php echo base_url('contest/get_skills')?>',
				data: {search: search},
				dataType: 'json',
				success: function(data){
					var $items = [];
					$.each(data, function(k, v){
						$items.push(v);
					});
					object.trigger('tokenize:dropdown:fill', [$items]);
				}
			});
		}
	});
	
	
	function JobFormPost(){	
	$('span.error-msg').hide();
	$(window).scrollTop(0);
	FormPost('#submit-check',"<?=VPATH?>","<?=VPATH?>postjob/check",'postjob_frm');
	$('#job_det').show();
	$('#job_det_1').show();
	$('#job_det_2').show();
	$('#preview-check').show();
	$('#preview_div').hide();
    }
	
	function PreviewJobFormPost(){
		
		var p_form = true;
		
		var title = $('#title').val();
		var exp_level_txt = $('[name="exp_level"]:checked').data('text');
		var description = $('#description').val();
		var category = $("#category_id").val();
		var subcategory = $('#subcategory_id').val();
		var optionTexts = [];
        $(".tokenize li.token").each(function() { optionTexts.push($(this).text()) });
        var skill = optionTexts.join('<br>');
        //var skill = skill.substr(1);

		// var environment = $('input[name=environment').val();
		var environment = $('input[name=environment]:checked').val();
			if ( environment == 'ON' ){
				environment = '<?php echo __('postjob_online','Online'); ?>';
			} else if ( environment == 'OFF' ){
				environment = '<?php echo __('postjob_offline','Offline'); ?>';
			}
		var visibility = $('input[name=visibility]:checked').val();
			if(visibility=='Public'){
				visibility = '<?php echo __('postjob_public','Public'); ?>';
			}
			if(visibility=='Private'){
				visibility = '<?php echo __('postjob_private','Private'); ?>';
			}
			
		var project_type = $('input[name="project_type"]:checked').val();
		
		$('#appended').remove();
			if ( project_type == 'F' ){
				project_type = '<?php echo __('postjob_fixed','Fixed'); ?>';
				$('#appended').remove();
				if ( $('#budgetall').val() == 'other' ){
					$('#labelBlock').append('<p id="appended"><label> <?php echo __('postjob_your_budget','Your Budget'); ?> :</label><span> '+$('#fixed_budeget').val()+'</span></p>');
				} else {
					var bgt =  $('#budgetall').val().split('#');
					var bgt_all = '';
					if(bgt[1] == ''){
						bgt_all = ' Over <?php echo CURRENCY; ?>' + bgt[0];
					}else{
						bgt_all = bgt.map(function(v){ return '<?php echo CURRENCY;?> '+v}).join(' to ');
					}
					
					$('#labelBlock').append('<p id="appended"><label> <?php echo __('postjob_your_budget','Your Budget'); ?> :</label><span>'+bgt_all+'</span></p>');
				}
			} else if ( project_type == 'H' ){
				project_type = '<?php echo __('postjob_hourly','Hourly'); ?>';
				$('#appended').remove();
				$('#labelBlock').append('<p id="appended"><label> <?php echo __('postjob_your_average_hourly_rate','Your average hourly rate'); ?> :</label><span> <?php echo __('postjob_min','Min'); ?>: $'+$('input[name=budget_min').val()+' <?php echo __('postjob_max','Max'); ?>: $'+$('input[name=budget_max').val()+'</span></p><p id="appended"><label> <?php echo __('postjob_number_of_freelancer','No Of Freelancer'); ?> :</label><span>'+$('input[name=no_of_freelancer').val()+'</span></p>');
			}
		
		if(title == ''){
			$('#titleError').html('<?php echo __('postjob_please_enter_job_title','Please Enter Job Title'); ?>');
			p_form = false;
		}else{
			$('#titleError').html('');
		}
		
		if(description == ''){
			$('#descriptionError').html('<?php echo __('postjob_please_enter_description','Please Enter Description'); ?>');
			p_form = false;
		}else{
			$('#descriptionError').html('');
		}
		
		if(category == ''){
			$('#category_idError').html('<?php echo __('postjob_please_select_category','Please Select Category'); ?>');
			p_form = false;
		}else{
			$('#category_idError').html('');
		}
		
		if(subcategory == ''){
			$('#subcategory_idError').html('<?php echo __('postjob_please_select_sub_category','Please Select Sub Category'); ?>');
			p_form = false;
		}else{
			$('#subcategory_idError').html('');
		}
		
		var skill_len = $(".tokenize li.token").length;
		console.log(skill_len);
		if(skill_len == 0){
			
			$('#subskill_idError').html('<?php echo __('postjob_please_select_sub_skill','Please Select Sub Skill'); ?>');
			p_form = false;
		}else{
			$('#subskill_idError').html('');
		}
		
		if(p_form){
			$('#job_det').hide();
			$('#job_det_1').hide();
			$('#job_det_2').hide();
			$('#preview-check').hide();
			$('#edit-preview').show();
			$('#preview_div').show();
			
			category = $('#category_id :selected').text();
			subcategory = $('#subcategory_id :selected').text();
			 
			$('#p_title').html(title);
			$('#p_exp_level').html(exp_level_txt);
			$('#p_description').html(description);
			$('#p_category_id').html(category);
			$('#p_subcategory_id').html(subcategory);
			$('#p_select2-search__field').html(skill);
			$('#p_environment').html(environment);
			$('#p_visibility').html(visibility);
			$('#p_project_type').html(project_type);
		}else{
			var error_ele = $('.rerror').not(':empty').offset();
			if(error_ele){
				$(window).scrollTop(error_ele.top - 180);
			}else{
				$(window).scrollTop(300);
			}
			
		}
		
		
	}
	
	function EditJobFormPost(){
		$('#job_det').show();
		$('#job_det_1').show();
		$('#job_det_2').show();
		$('#preview_div').hide();
		$('#preview-check').show();
		$('#edit-preview').hide();
	}
	
$(document).ready(function(){
	$('input[name="project_type"]').change(function(){
		var val = $(this).val();
		if(val == 'F'){
			$('#hourly_budget').hide();
			$('#fixed_budget').show();
			
		}else{
			$('#fixed_budget').hide();
			$('#hourly_budget').show();
			
		}
		
		checkPrice($('input[name="featured"]'));
	});
	
	
	$('select[name="budgetall"]').change(function(){
		var val = $(this).val();
		if(val == 'other'){
			$('#budget_other').show();
		}else{
			$('#budget_other').hide();
			$(".fixed_budeget").val('0');
		}
	});
	
	$('.form-group').popover({
		selector: '[rel=infopop]',
		trigger: "click",
		}).on("show.bs.popover", function(e){
		$("[rel=infopop]").not(e.target).popover("destroy");
		$(".popover").remove();                    
	});
	
	$('body').click(function(e){
		var target = $(e.target);
		if(!target.is('i')){
			$("[rel=infopop]").popover("destroy");
			$(".popover").remove(); 
		}
		
	});

});

</script>      

<script>
  function getscat(v){
	 $('.abc').removeClass('selected');
	 $(".abc").fadeTo("slow",0.4);
	 $('#li_'+v).fadeTo("fast",1.0); 
	 $('#li_'+v).attr('class','abc selected');  
     var dataString = 'pid='+v;
    
  $.ajax({
     type:"POST",
     data:dataString,
     url:"<?php echo VPATH;?>postjob/getsubcat",
     success:function(return_data){
		$("#category_id").val(v);
        $("#subcat_dv").html(return_data);
        $("#subcat_select").show();
        select2load();
     }
    });
  }
  
  function getsubcat(v)
  {  	
  	  var dataString = 'pid='+v;    
	  $.ajax({
		 type:"POST",
		 data:dataString,
		 url:"<?php echo VPATH;?>postjob/getsubcat",
		 success:function(return_data){
			//$("#category_id").val(v);
			$("#subcategory_id").html(return_data);
			 select2load();
			//$("#subcat_select").show();
		 }
     });
  }
  
  function putscat(v){
	 $('.def').removeClass('selected');
	 $(".def").fadeTo("slow",0.4);
	 $('#li_'+v).fadeTo("fast",1.0); 
	 $('#li_'+v).attr('class','def selected');  
     var dataString = 'catid='+v;
    
  $.ajax({
     type:"POST",
     data:dataString,
     url:"<?php echo VPATH;?>postjob/getsubcatname",
     success:function(return_data){
		$("#subcategory_id").val(return_data);
     }
    });
  }
  
  function putskill(v){
	 $("#ls_"+v).fadeTo("slow",0.4); 
	 $('#li_'+v).attr('class','sus selected');
	 $('#chk_'+v).attr('checked','checked');  
     
  }
  
 function getsubskill(v){  
	 
     var dataString = 'sid='+v;
    
  $.ajax({
     type:"POST",
     data:dataString,
     url:"<?php echo VPATH;?>postjob/getsubskill",
	 beforeSend: function() {  
       // $("#subskill").html('<option value="">Loading...</option>');
    },
     success:function(return_data){	 	
	 	
        //$("#subskill").html(return_data);
		/*$('.inputtag').tokenize2();*/
		$("#subskill").html('');
		$('.tokenize').find('.token').remove();
        //select2load();
		
     }
    });
  }
  
 function getskill(v){ 
 
 	$('.stu').removeClass('selected');
	 $(".stu").fadeTo("slow",0.4);
	 $('#lis_'+v).fadeTo("fast",1.0); 
	 $('#lis_'+v).attr('class','stu selected'); 
	 
     var dataString = 'sid='+v;
    
  $.ajax({
     type:"POST",
     data:dataString,
     url:"<?php echo VPATH;?>postjob/getsubskill",
     success:function(return_data){
		$("#skill_id").val(v); 
        $("#subskill_id").html(return_data);
        $("#subskill_select").show();
		
     }
    });
  }
  
  
  function project_type_box(v){ 
  var multi_freelancer=$("input[name=multi_freelancer]:checked").val();
     if(v=="H"){ 
       $("#ptype_h").show();
       $("#ptype_f").hide();
	   $("#price_span").html("<?php echo html_entity_decode(CURRENCY)." ".HOURLY_RATE;?>");
	  // $(".multi_freelancer").show(); 
	   if(multi_freelancer!='Y'){
			  $(".multi_freelancer_number").hide();
		}else{
			 $(".multi_freelancer_number").show();
		}
     }
     else{ 
       $("#ptype_f").show();
       $("#ptype_h").hide();
	   $("#price_span").html("<?php echo html_entity_decode(CURRENCY)." ".FIXED_RATE;?>");    
	   //$(".multi_freelancer").hide();    
	   $(".multi_freelancer_number").hide(); 
     }
  }
  function getMulti(val){
  	if(val=='Y'){
		$(".multi_freelancer_number").show();
	}else{
	$(".multi_freelancer_number").hide();	
	}
  }
 function movefile(evt){ 
      
        var n=document.getElementById('userfile').files[0];
       
        $.ajaxFileUpload({
            url:'<?php echo VPATH;?>postjob/test/',
            secureuri:false,
            fileElementId:'userfile',
            dataType: 'json',
            data:{name:n.name, id:'id'},
            success: function (data){              
                var flist=$("#upload_file").val()+","+data.msg;
                
                $("#upload_file").val(flist);                
                //$("#flist_div").append("<div class='flisttext' id='sp_"+data.msg.replace(".","")+"'>"+data.msg+"<img id='"+data.msg+"' onclick='removespan(this.id)' style='float: right;' src='<?php// echo VPATH;?>assets/images/bin.png' /></div>");
                $("#flist_div").append("<div class='flisttext' id='sp_"+data.msg.replace(".","")+"'>"+data.msg+"<i class='zmdi zmdi-delete' id='"+data.msg+"' onclick='removespan(this.id)' style='float:right;color:#f00;font-size:19px;cursor:pointer'></i></div>");
               // $("flist_div").text(data.msg);
                $("#flist_div").show();
                
            }
    });
      
     
  }
  
  
  /*function check_featured(){     
    if($("#featured").is(':checked')){ 
        
      var b='<?php echo $balance;?>';  
      var fprice='<?php echo FIXED_RATE;?>';
      if(b<fprice){        
        $("#submit-check").attr('disabled', 'true');
        $("#featuredlError").show();
        $("#featuredlError").text("You don't have enough balance..!");
      }
      else{ 
        $("#submit-check").removeAttr('disabled');
         $("#featuredlError").hide();
      }
    }
    else{ 
      $("#submit-check").removeAttr('disabled');
       $("#featuredlError").hide();
    }    
  }*/
  

  function showsignup(){ 
    $("#signup_frm").show();
    $("#login_frm").hide();
	$("#user_inf").val('s');
	$("#su").attr('class','selected');
	$("#lg").removeAttr('class','selected');
	
  }
  function showlogin(){ 
    $("#signup_frm").hide();
    $("#login_frm").show();
	$("#user_inf").val('l');
	$("#lg").attr('class','selected');
	$("#su").removeAttr('class','selected');
	
  } 
  
  function citylist(country)
{
	
	var dataString = 'cid='+country;
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
function GetContents() {
	// Get the editor instance that you want to interact with.
	var editor = CKEDITOR.instances.description;

	// Get editor contents
	// http://docs.ckeditor.com/#!/api/CKEDITOR.editor-method-getData
	var con=editor.getData();
	$('#description').text(con);
	var t=$('#description').text();
	if(t=='')
	{
		return false;	
	}
	else
	{
		return true;	
	}
	
	
} 
function removespan(v)
{
	
	var dataString = 'img='+v;
  $.ajax({
     type:"POST",
     data:dataString,
     url:"<?php echo base_url();?>postjob/rmvimage/"+v,
     success:function(return_data)
     {
		var flist=$("#upload_file").val();
		flist=flist.replace(v, "");
		$("#upload_file").val(flist);
		$('#sp_'+v.replace(".","")).remove();
      	
     }
    });	
}   
function getfixed(val){
	if(val=='other'){
		$(".fixed_budeget").show();
	}else{
		$(".fixed_budeget").hide();
		$(".fixed_budeget").val('0');
	}
} 
</script>


<script type="text/javascript">
function formatRepo (repo) {
    if (repo.loading) return repo.text;

    var markup = '<div class="clearfix">' +
    '<div class="col-sm-1">' +
    '</div>' +
    '<div clas="col-sm-10">' +
    '<div class="clearfix">' +
    '<div class="col-sm-6">' + repo.full_name + '</div>'+
    '</div>';

    if (repo.description) {
      markup += '<div>' + repo.description + '</div>';
    }

    markup += '</div></div>';

    return markup;
  }

  function formatRepoSelection (repo) {
    return repo.full_name || repo.text;
  }
  
</script>

<script>
function search_freelancer(val){
	$.get('<?php echo base_url('postjob/search_freelancer')?>?term='+val, function(res){
		$('#freelancer_list').html(res);
	});
}
</script>

<script>
/*function setActive(e){
	var u_id = $(e).attr('data-user');
	if($(e).is('.selected')){
		$(e).removeClass('selected');
		$(e).find('input[name="freelancer[]"]').remove();
	}else{
		$(e).addClass('selected');
		$(e).append('<input type="hidden" name="freelancer[]" value="'+u_id+'"/>');
	}
}*/
function search_freelancer(val){
	$.get('<?php echo base_url('postjob/search_freelancer')?>?term='+val, function(res){
		$('#freelancer_list').show();
		$('#freelancer_list').html(res);
	});
}

function setActive(e){
	var choosen_f = $(e).clone();
	var u_id = $(e).attr('data-user');
	if($(e).is('.selected')){
		$(e).remove();
		$('#freelancer_row_'+u_id).show();
		if($('#selected_freelancer_list').find('.item.selected').length == 0){
			$('#selected_freelancer_list').hide();
		}
	}else{
		choosen_f.addClass('selected');
		choosen_f.append('<input type="hidden" name="freelancer[]" value="'+u_id+'"/>');
		$('#freelancer_row_'+u_id).hide();
		$('#selected_freelancer_list').show();
		if($('#selected_freelancer_list').find('#freelancer_row_'+u_id).length == 0){
			$('#selected_freelancer_list').append(choosen_f);
		}
		
	}
}

function checkPrice(ele){
	var is_checked = $(ele).is(':checked');
	if(is_checked){
		var p_type = $('input[name="project_type"]:checked').val();
		if(p_type == 'F'){
			$('#featured_price_p_fixed').show();
			$('#featured_price_p_hourly').hide();
		}else{
			$('#featured_price_p_fixed').hide();
			$('#featured_price_p_hourly').show();
		}
	}else{
		$('#featured_price_p_fixed').hide();
		$('#featured_price_p_hourly').hide();
	}
}

var qs_count = 1;
function addQuestion(){
	var l = $('#f_q_wapper').find('.qBx').length +1;
	var html = '<div class="qBx" id="qs_item_'+qs_count+'"><div class="input-group mb-3"><input type="text" class="form-control" placeholder="Question '+l+'" name="questions[]"/><div class="input-group-append"><button type="button" class="btn btn-success save-btn" onclick="saveQs('+qs_count+')">Ok</button>&nbsp;<button type="button" class="btn btn-danger" onclick="removeQs('+qs_count+')">Remove</button></div></div></div>';
	$('#f_q_wapper').append(html);
	qs_count++;
	$('#add_qs_btn').hide();
	
}

function saveQs(i){
	var qs_val = $('#qs_item_'+i).find('input').val();
	if(qs_val.trim() == ''){
		$('#qs_item_'+i).find('input').addClass('invalid');
		return false;
	}else{
		$('#qs_item_'+i).find('input').removeClass('invalid');
	}
	
	$('#qs_item_'+i).find('input').attr('readonly', 'readonly');
	
	$('#f_q_wapper').find('.save-btn').hide();
	$('#add_qs_btn').show();
}


function removeQs(i){
	$('#qs_item_'+i).remove();
	$('#add_qs_btn').show();
	return false;
	
}


</script>
