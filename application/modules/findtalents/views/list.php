<script type="text/javascript" src="<?php echo JS;?>jQuery-plugin-progressbar.js"></script>

<link href="<?php echo CSS;?>jQuery-plugin-progressbar.css" rel="stylesheet" type="text/css">

<?php $lang=$this->session->userdata('lang'); ?>





<section class="sec">

  <div class="container">

  <?php echo $breadcrumb;?>

    <div class="row">

      <?php $this->load->view('left_sidebar');?>

      <aside class="col-md-9 col-sm-12 col-xs-12">

        <h4 class="title-sm"><?php echo __('findtalents_freelancers','Freelancers'); ?></h4>

        <div class="searchbox">

          <form>

            <div class="input-group input-group-lg">

              <input type="text" class="form-control" placeholder="<?php echo __('findtalents_find_talents_by_name','Find talents by name'); ?>..." aria-describedby="basic-addon1" name="term" value="<?php echo !empty($srch_param['q']) ? $srch_param['q'] : ''; ?>">

              <span class="input-group-addon" id="basic-addon1">

              <button type="submit" class="btn btn-site"><i class="zmdi zmdi-search"></i> <?php echo __('findtalents_search','Search'); ?></button>

              </span> </div>

          </form>

          <p class="text-right" style="display:none;"><a href="#"><?php echo __('findtalents_advanced_search','Advanced Search'); ?></a></p>

        </div>



        <div class="freelancers-container freelancers-list-layout margin-top-35 findtalent" id="talent">

       <?php /*   <p>( <?php echo $total_freelancers;?> ) Freelancer found</p> */ ?>

          <?php 

  

/* get_print($freelancers); */

  if(count($freelancers)){ 

	



  foreach ($freelancers as $row){

  	$previouscon=in_array($row['user_id'],$previousfreelancer);

?>

          <?php

if($this->session->userdata('user'))

{

	$user=$this->session->userdata('user');

	$account_type=$user[0]->account_type;

	if($user[0]->user_id==$row['user_id'])

	{

		$lnk=VPATH."dashboard/profile_professional";

	}

	else

	{

		$lnk=VPATH."clientdetails/showdetails/".$row['user_id']."/".$this->auto_model->getcleanurl($row['fname']." ".$row['lname'])."/";

	}	

}

else

{

	$lnk=VPATH."clientdetails/showdetails/".$row['user_id']."/".$this->auto_model->getcleanurl($row['fname']." ".$row['lname'])."/";	

}

?>

        <!--Freelancer -->

        <div class="freelancer d-block">

        	<div class="media">

        	<!-- Overview -->

			<div class="freelancer-overview media-body">

            <div class="freelancer-overview-inner">

            	<!-- Avatar -->

                <div class="freelancer-avatar">

                    <div class="verified-badge"></div>                    

                    <a href="<?php echo $lnk;?>">

                          <?php 

                      if($row['logo']!=""){ 

                      

                          if(file_exists('assets/uploaded/cropped_'.$row['logo'])){

                                $logo="cropped_".$row['logo'];

                            }else{

                                $logo=$row['logo'];

                            }

                      

                    ?>

                          <img src="<?php echo VPATH."assets/uploaded/".$logo;?>" alt="" />

                          <?php             

                      }

                      else{ 

                    ?>

                          <img src="<?php echo VPATH;?>assets/images/user.png" alt="" />

                          <?php   

                      }

                    ?>

                    </a>

                </div>

                

	<?php 

      $membership_logo="";

	  $membership_logo=$this->auto_model->getFeild('icon','membership_plan','id',$row['membership_plan']); 

	  $membership_title=$this->auto_model->getFeild('name','membership_plan','id',$row['membership_plan']); 

    

    ?>

	<?php 

	   $contry_info="";

	 

	   if($row['city']!=""){ 

		   $contry_info.=$this->auto_model->getFeild('Name' , 'city' , 'id' , $row['city']).", ";

	   } 

	   $contry_info.=$this->auto_model->getFeild('Name','country','Code',$row['country']);

	   

	?>

	<?php 

		$code=strtolower($this->auto_model->getFeild('code2','country','Code',$row['country']));
		$slogan =$row['slogan'];
		$overview =$row['overview'];
		//$slogan = $this->auto_model->getFeild('slogan','user','user_id',$row['user_id']);

		//$overview = $this->auto_model->getFeild('overview','user','user_id',$row['user_id']);

	?>

            	<!-- Name -->

				<div class="freelancer-name">

                    <h4><a href="<?php echo $lnk;?>"><?php echo $row['fname']." ".$row['lname']?></a><a href="#"> <img class="flag" src="<?php echo VPATH;?>assets/images/flags/<?php echo $code;?>.svg" alt="" title="<?php echo $contry_info;?>" data-tippy-placement="top"></a></h4>

                    <span><a href="<?php echo $lnk;?>"><?php echo $slogan;?></a></span>

                    <!-- Rating -->

                    <div class="freelancer-rating">

					<?php

						$avg_rating=0;

						if($row['rating'][0]['num']>0){

							$avg_rating=round($row['rating'][0]['avg']/$row['rating'][0]['num'],2);

						}

					?>

					<div class="star-rating" data-rating="<?php echo $avg_rating;?>"></div>

                    </div>

                   

					 <?php /*

                    if($row['rating'][0]['num']>0){

                        

                        $avg_rating=$row['rating'][0]['avg']/$row['rating'][0]['num'];

                        

                        for($i=1; $i<=5; $i++){

                            if($i <= $avg_rating){

                                echo ' <i class="zmdi zmdi-star"></i> ';

                            }else{

                                echo ' <i class="zmdi zmdi-star-outline"></i> ';

                            }

                        }

        

                    } else{ ?>

                    <i class="zmdi zmdi-star-outline"></i> 

                    <i class="zmdi zmdi-star-outline"></i> 

                    <i class="zmdi zmdi-star-outline"></i> 

                    <i class="zmdi zmdi-star-outline"></i> 

                    <i class="zmdi zmdi-star-outline"></i>

                    <?php } */?>

			

              		

                </div>       

            </div>

			</div>    

            <!-- Details -->     

			<div class="freelancer-details media-body">

                <div class="freelancer-details-list">

				<?php 

					$row['total_project'] = $row['total_project'] == 0 ? 1 : $row['total_project'];

					$success_prjct = (int) $row['com_project'] * 100 / (int) $row['total_project'];

				?>

                    <ul>

                        <li>Rate <strong> <?php echo CURRENCY;?> <?php echo $row['hourly_rate'];?>/<?php echo __('findtalents_hr','hr'); ?></strong></li>

                        <li>C Project <strong><?php echo $row['com_project'];?></strong></li>

                        <li><?php echo __('findtalents_job_success','Job Success'); ?> <strong><?php echo round($success_prjct,2);?>%</strong></li>

                    </ul>

                    <?php /*?><div class="circle-bar position" data-percent="<?php echo round($success_prjct,2);?>" data-duration="1000" data-color="#dedede,#0c0"></div><?php */?>

                </div>                

            </div>

            </div>

            

            <div class="media desc">

            <div class="media-body">

            <p><?php echo strlen(strip_tags($overview)) > 200 ? substr(strip_tags($overview) , 0 , 200).'... <a href="'.$lnk.'">'.__('findtalents_more','more').'</a>' : strip_tags($overview); ?> </p>                                

                        

            <ul class="skills">

              <?php 

      $skill_list=$row['skills'];

	

      if(count($skill_list)){

		foreach($skill_list as $k => $v){

			

			$skill_name=$v['skill_name'];

			switch($lang){

				case 'arabic':

					$skill_name = !empty($v['arabic_skill_name'])? $v['arabic_skill_name'] : $v['skill_name'];

					break;

				case 'spanish':

					//$categoryName = $val['spanish_cat_name'];

					$skill_name = !empty($v['spanish_skill_name'])? $v['spanish_skill_name'] : $v['skill_name'];

					break;

				case 'swedish':

					//$categoryName = $val['swedish_cat_name'];

					

					$skill_name = !empty($v['swedish_skill_name'])? $v['swedish_skill_name'] : $v['skill_name'];

					break;

				default :

					$skill_name = $v['skill_name'];

					break;

			}

	?>

              <li><a href="<?php echo base_url('findtalents/browse').'/'.$this->auto_model->getcleanurl($v['parent_skill_name']).'/'.$v['parent_skill_id'].'/'.$this->auto_model->getcleanurl($v['skill']).'/'.$v['skill_id'];?>"> <?php // echo $v['skill'];?>

			  <?php echo $skill_name; ?> </a> </li>

              <?php

             

      } } 

      else{ 

    ?>

              <li><a href="javascript:void(0);"><?php echo __('findtalents_skills_not_set_yet','Skill Not Set Yet'); ?></a> </li>

              <?php  

      }

   ?>

            </ul>

            </div>

            <div class="media-right">

            	<a href="<?php echo $lnk;?>" class="button button-sliding-icon ripple-effect">View Profile <i class="icon-material-outline-arrow-right-alt"></i></a>

            </div>

            </div>

          </div>

          <?php 

}



}

else{ 

    echo "<div class='alert alert-danger'>".__('findtalents_no_record_found','No record found')."</div>";

}

?>

        </div>

        <nav aria-label="Page navigation" id="pagi_span">

          <?php     echo $links;  ?>

        </nav>

      </aside>

    </div>

  </div>

</section>

<div class="clearfix"></div>

<script type="text/javascript">

<?php $srch_url = !empty($srch_param) ? '?'.http_build_query($srch_param, '', '&').'&' : '?';?>

var srch_url = '<?php echo base_url('findtalents/ajaxsearch').$srch_url;?>';



$(document).ready(function(){

	$('#srch').keyup(function(){

		var val = $(this).val();

		$.get(srch_url+'q='+val , function(res , status){

			$('#talent').html(res);

			$('#pagi_span').hide();

		});

	});

});



$(".circle-bar").loading();



</script>