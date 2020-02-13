<?php function check_query($key='' , $arr=array()){	if(is_array($key)){		foreach($key as $v){			if(array_key_exists($v , $arr)){				unset($arr[$v]);			}		}	}else{		if(array_key_exists($key , $arr)){			unset($arr[$key]);		}	}	return count($arr) > 0 ? http_build_query($arr).'&' : '';}$lang=$this->session->userdata('lang');?>
<aside class="col-md-3 col-sm-12 col-xs-12">
    <div class="left_sidebar">	<form id="srchForm">
		<div class="sidebar-widget">
			<h4 class="title-sm"><?php echo __('findtalents_sidebar_skills','Skills'); ?></h4>
			<select class="selectpicker" title="All" name="skill_id" data-size="" onchange="submitForm()">
				<option value="">All</option>
				<?php foreach($parent_skills as $key =>$val){
				switch($lang){
					case 'arabic':
						$parentSkillName = !empty($val['arabic_skill_name'])? $val['arabic_skill_name'] : $val['skill_name'];
						break;
					case 'spanish':
						//$categoryName = $val['spanish_cat_name'];
						$parentSkillName = !empty($val['spanish_skill_name'])? $val['spanish_skill_name'] : $val['skill_name'];
						break;
					case 'swedish':
						//$categoryName = $val['swedish_cat_name'];
						$parentSkillName = !empty($val['swedish_skill_name'])? $val['swedish_skill_name'] : $val['skill_name'];
						break;
					default :
						$parentSkillName = $val['skill_name'];
						break;
				}
				?>    
				<option value="<?php echo $val['id']?>" <?php echo ($skill_id == $val['id']) ? 'selected' : ''?>><?php echo $parentSkillName;?></option>
				<?php } ?>
			</select>
		</div>	
<?php if(!empty($srch_param['skill_id'])){ ?>
		<div class="sidebar-widget">
			<h4 class="title-sm"><?php echo __('findtalents_sidebar_sub_skills','Sub Skills'); ?></h4>			<select class="selectpicker" title="All" name="sub_skill_id" onchange="submitForm()">
				<option value="All"><?php echo __('findtalents_sidebar_all','All'); ?></option>
				<?php foreach($child_skills as $key =>$val){ 		
				switch($lang){
					case 'arabic':
						$childSkillName = !empty($val['arabic_skill_name'])? $val['arabic_skill_name'] : $val['skill_name'];
						break;
					case 'spanish':
						//$categoryName = $val['spanish_cat_name'];
						$childSkillName = !empty($val['spanish_skill_name'])? $val['spanish_skill_name'] : $val['skill_name'];
						break;
					case 'swedish':
						//$categoryName = $val['swedish_cat_name'];
						$childSkillName = !empty($val['swedish_skill_name'])? $val['swedish_skill_name'] : $val['skill_name'];
						break;
					default :
						$childSkillName = $val['skill_name'];
						break;
				}				
				?>
				<option value="<?php echo $val['id']?>" <?php echo ($sub_skill_id == $val['id']) ? 'selected' : ''?>><?php echo $childSkillName;?></option>
				<?php } ?>
			</select>
		</div>
<?php } ?>
		<div class="sidebar-widget">		
			<h4 class="title-sm"><?php echo __('findtalents_sidebar_membership_plan','Membership Plan'); ?></h4>
			<?php $url = !empty($srch_string) ? '?'.check_query('memplan' , $srch_string)  : '?'; ?>
			<select class="selectpicker" title="All" name="memplan" onchange="submitForm()">
				<option value="All"><?php echo __('findjob_sidebar_all','All'); ?></option>
				<?php
					foreach($all_plans as $key=>$val)
					{
					?>
				<option value="<?php echo $val['id'];?>" <?php echo ($memplan == $val['id']) ? 'selected' : ''?>><?php echo $val['name'];?></option>
				<?php
					}
					?>
			</select>
		</div>
		<div class="sidebar-widget">
			<h4 class="title-sm"><?php echo __('findtalents_sidebar_country','Country'); ?></h4>
			<?php $url = !empty($srch_string) ? '?'.check_query(array('ccode' , 'country' , 'city') , $srch_string) : '?'; ?>
			<select class="selectpicker" title="All" name="ccode" data-size="10" onchange="submitForm()">
				<option value="All"><?php echo __('findjob_sidebar_all','All'); ?></option>
				<?php foreach($countries as $key=>$val) { ?>
				<option value="<?php echo $val['Code']?>" <?php echo ($country == $val['Code']) ? 'selected' : ''?>><?php echo $val['Name'];?></option>
				<?php } ?>
			</select>
        </div>				
		<?php if(!empty($srch_param['ccode']) AND $srch_param['ccode'] != 'All'){ ?>
        <div class="sidebar-widget">        
			<h4 class="title-sm"><?php echo __('findtalents_sidebar_city','City'); ?></h4>        
			<?php $url = !empty($srch_string) ? '?'.check_query('city' , $srch_string) : '?'; ?>
			<select class="selectpicker" title="All" name="city" data-size="10" onchange="submitForm()">
				<option value="All"><?php echo __('findjob_sidebar_all','All'); ?></option>
				<?php foreach($cities as $key=>$val) { ?>
				<option value="<?php echo $val['ID']?>" <?php echo ($city == $val['ID']) ? 'selected' : ''?>><?php echo $val['Name'];?></option>
				<?php } ?>
			</select>  
        </div>
		<?php } ?>	</form>
    </div>
</aside>
<script src="<?php echo JS;?>jquery.nicescroll.min.js"></script>
<script>
  $(document).ready(function() {  	    	$(".scroll-bar").niceScroll();
  });    function submitForm(){	  var frm = $('#srchForm').serialize();	  var frm2 = $('#srchForm2').serialize();	  if(frm2 != ''){		  frm += '&'+frm2;	  }	  location.href = '<?php echo base_url('findtalents')?>?'+frm;  }  
</script>