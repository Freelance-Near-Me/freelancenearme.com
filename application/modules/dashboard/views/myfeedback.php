<link rel="stylesheet" href="<?php echo ASSETS;?>plugins/rating/jquery.rateyo.css"/>
<script src="<?php echo ASSETS;?>plugins/rating/jquery.rateyo.js"></script>   
<script src="<?=JS?>mycustom.js"></script>
<div class="dashboard-container">
<?php $this->load->view('dashboard-left'); ?>
<div class="dashboard-content-container">
    <div class="dashboard-content-inner">
    <!-- Dashboard Headline -->
	<?php echo $breadcrumb; ?>
    

<div id="editprofile">
<div class="table-responsive">
<table class="table">
<thead>
	<tr>
	<th>Date</th><th>Project name</th><th>Given by</th><th>Action</th>
    </tr>
</thead>
<tbody>
<?php
if(count($allfeedback)>0)
{
foreach($allfeedback as $key=>$val)
{
$project_name=$this->auto_model->getFeild('title','projects','project_id',$val['project_id']);
$username=$this->auto_model->getFeild('username','user','user_id',$val['review_by_user']);
$employer_fname = $this->auto_model->getFeild('fname','user','user_id',$val['review_by_user']);
$employer_lname = $this->auto_model->getFeild('lname','user','user_id',$val['review_by_user']);
$employer_name = $employer_fname.' '.$employer_lname;
$private_feedback = get_row(array('select' => '*', 'from' => 'feedback', 'where' => array('project_id' => $val['project_id'], 'feedback_by_user' => $val['review_by_user'], 'feedback_to_user' => $val['review_to_user'])));

$u_type = getField('account_type','user','user_id',$val['review_by_user']);

?>
<tr>
<td><?php echo date('d M,Y',strtotime($val['added_date']));?></td>
<td><?php echo ucwords($project_name);?></td>
<td><?php echo ucwords($username);?></td>
<td><!--<a href="<?php echo VPATH;?>dashboard/feedbackdetails/<?php echo $val['project_id']?>/<?php echo $val['given_user_id'];?>/<?php echo $project_name;?>">View Feedback</a>--> 

<a href="javascript:void(0)"  onclick="ReadFeedback(this)" data-public-feedback='<?php echo json_encode($val); ?>' data-private-feedback='<?php echo json_encode($private_feedback); ?>' data-user-type="<?php echo $u_type;?>" data-name="<?php echo $employer_name; ?>"><i class="icon-feather-eye" title="view feedback"></i></a>

</td>
</tr>
<?php
}
}
else
{
?>
<tr><td colspan="4" align="center">No feedback to display</td></tr>
<?php
}
?>	 

</tbody>
</table>
</div>
</div>                   



     </div>
  </div>
</div>
   

<!-- View Feedback Modal -->
<div class="modal fade" id="readReviewModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
	 <div class="modal-header">       
        <h4 class="modal-title" id="myModalLabel">Feedback By Vk Bishu</h4>
        <button type="button" class="close" onclick="$('#readReviewModal').modal('hide');"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body" style="background-color:#f5f5f5">
		<div class="feedback" id="private_feedback_readonly_box">
		 <h4>Private Feedback</h4>
		 <div class="row">
			<div class="col-sm-6">Reason for ending contract</div>
			<div class="col-sm-6"><span id="reason_readonly"></span></div>
		 </div>
		 
		  <div class="row">
			<div class="col-sm-6">Recommend to friend</div>
			<div class="col-sm-6"><span id="recommend_to_friend_readonly"></span></div>
		 </div>
		 
		  <div class="row">
			<div class="col-sm-6">Your strength</div>
			<div class="col-sm-6"><span id="strength_readonly"></span></div>
		 </div>
		 
		  <div class="row">
			<div class="col-sm-6">English proficiency</div>
			<div class="col-sm-6"><span id="english_proficiency_readonly"></span></div>
		 </div>
		 
		</div>
		
		<div class="feedback" id="public_feedback_readonly_box">
        <h4>Public Feedback</h4>
        <div class="form-group">
        <div class="col-xs-12">
        <div class='rating-widget'>
          <div class='rating-stars'>  
			<table class="table-rating">
				<tr class="F_show">
					<td><div id="rating_behaviour_readonly"></div></td>
					<td>Behavior</td>
				</tr>
				<tr class="F_show">
					<td><div id="rating_payment_readonly"></div></td>
					<td>Payment</td>
				</tr>
				
				<tr class="E_show">
					<td><div id="rating_skills_readonly"></div></td>
					<td>Skills</td>
				</tr>
				<tr class="E_show">
					<td><div id="rating_quality_readonly"></div></td>
					<td>Quality of works</td>
				</tr>
				<tr>
					<td><div id="rating_availablity_readonly"></div></td>
					<td>Availability</td>
				</tr>
				<tr>
					<td><div id="rating_communication_readonly"></div></td>
					<td>Communication</td>
				</tr>
				<tr>
					<td><div id="rating_cooperation_readonly"></div></td>
					<td>Cooperation</td>
				</tr>
			</table>
			
          </div>
	   </div>
		</div>
        </div>
		
		<div class="clearfix"></div>
		
        <div class="form-group">
        <div class="col-xs-12">
			<div id="comment_readonly"></div>
        </div>
        </div>
        
        </div>
      </div>	        
	
    </div>
  </div>
</div>

<script>
 $(function () {
	
	/* read only star */
	
	$("#rating_behaviour_readonly").rateYo({
		normalFill: "#ddd",
		ratedFill: "#FF912C",
		rating    : 0,
		fullStar: true,
		starWidth: "20px",
		spacing: "5px",
		readOnly: true
	});
	
	$("#rating_payment_readonly").rateYo({
		normalFill: "#ddd",
		ratedFill: "#FF912C",
		rating    : 0,
		fullStar: true,
		starWidth: "20px",
		spacing: "5px",
		readOnly: true
	});
	
	
	$("#rating_skills_readonly").rateYo({
		normalFill: "#ddd",
		ratedFill: "#FF912C",
		rating    : 0,
		fullStar: true,
		starWidth: "20px",
		spacing: "5px",
		readOnly: true
	});
	
	$("#rating_quality_readonly").rateYo({
		normalFill: "#ddd",
		ratedFill: "#FF912C",
		rating    : 0,
		fullStar: true,
		starWidth: "20px",
		spacing: "5px",
		readOnly: true
		
	});
	
	$("#rating_availablity_readonly").rateYo({
		normalFill: "#ddd",
		ratedFill: "#FF912C",
		rating    : 0,
		fullStar: true,
		starWidth: "20px",
		spacing: "5px",
		readOnly: true
		
	});
	
	$("#rating_communication_readonly").rateYo({
		normalFill: "#ddd",
		ratedFill: "#FF912C",
		rating    : 0,
		fullStar: true,
		starWidth: "20px",
		spacing: "5px",
		readOnly: true
		
	});
	
	$("#rating_cooperation_readonly").rateYo({
		normalFill: "#ddd",
		ratedFill: "#FF912C",
		rating    : 0,
		fullStar: true,
		starWidth: "20px",
		spacing: "5px",
		readOnly: true
		
	});
	
	$('.activityLOG').popover({
		 selector: '[rel=infopop]',
         trigger: "click",
		}).on("show.bs.popover", function(e){
		$("[rel=infopop]").not(e.target).popover("destroy");
		$(".popover").remove();                    
	});
	

});
 </script>

 
<script>

function ReadFeedback(ele){
	
	<?php
		$this->config->load('rating_reviews', TRUE);
		$reason = $this->config->item('reason', 'rating_reviews');
		$strength = $this->config->item('strength', 'rating_reviews');
		$english_proficiency = $this->config->item('english_proficiency', 'rating_reviews');
		$reason_arr = $strength_arr = $english_proficiency_arr = array();
		if(count($reason) > 0){
			foreach($reason as $k => $v){
				$reason_arr[$v['val']] = $v['text'];
			}
		}
		
		if(count($strength) > 0){
			foreach($strength as $k => $v){
				$strength_arr[$v['val']] = $v['text'];
			}
		}
		
		if(count($english_proficiency) > 0){
			foreach($english_proficiency as $k => $v){
				$english_proficiency_arr[$v['val']] = $v['text'];
			}
		}
	?>
	
	var reason , strength , english_proficiency;
	reason = <?php echo json_encode($reason_arr);?>;
	strength = <?php echo json_encode($strength_arr);?>;
	english_proficiency = <?php echo json_encode($english_proficiency_arr);?>;
	
	var public_feedback = $(ele).data('publicFeedback');
	var private_feedback = $(ele).data('privateFeedback');
	var name = $(ele).data('name');
	var u_type = $(ele).data('userType');
	
	if(!$.isEmptyObject(private_feedback)){
		
		if(reason[private_feedback.reason]){
			$('#private_feedback_readonly_box').find('#reason_readonly').html(reason[private_feedback.reason]);
		}else{
			$('#private_feedback_readonly_box').find('#reason_readonly').html('');
		}
		
		if(english_proficiency[private_feedback.english_proficiency]){
			$('#private_feedback_readonly_box').find('#english_proficiency_readonly').html(english_proficiency[private_feedback.english_proficiency]);
		}else{
			$('#private_feedback_readonly_box').find('#english_proficiency_readonly').html('');
		}
		
		
		if(private_feedback.strength){
			
			var strength_text_arr = [];
			var strength_arr = JSON.parse(private_feedback.strength);
		
			for(var i=0; i<strength_arr.length;i++){
				var st_txt = strength[strength_arr[i]] || '';
				
				strength_text_arr.push(st_txt);
			}
			
			$('#private_feedback_readonly_box').find('#strength_readonly').html(strength_text_arr.join(', '));
			console.log(strength_text_arr.join(','));
			console.log(strength_text_arr);
			
		}else{
			$('#private_feedback_readonly_box').find('#strength_readonly').html('');
		}
		
		$('#private_feedback_readonly_box').find('#recommend_to_friend_readonly').html(private_feedback.recommend_to_friend);
		
	}else{
		$('#private_feedback_readonly_box').hide();
	}
	
	if(u_type == 'E'){
		$('.E_show').show();
		$('.F_show').hide();
		$("#rating_skills_readonly").rateYo("rating", public_feedback.skills);
		$("#rating_quality_readonly").rateYo("rating", public_feedback.quality_of_work);
	}else{
		$('.F_show').show();
		$('.E_show').hide();
		$("#rating_behaviour_readonly").rateYo("rating", public_feedback.behaviour);
		$("#rating_payment_readonly").rateYo("rating", public_feedback.payment);
	}

	$("#rating_availablity_readonly").rateYo("rating", public_feedback.availablity);
	$("#rating_communication_readonly").rateYo("rating", public_feedback.communication);
	$("#rating_cooperation_readonly").rateYo("rating", public_feedback.cooperation);
	$('#comment_readonly').html(public_feedback.comment);
	$('#readReviewModal').find('.modal-title').html('Feedback by ' +  name);
	$('#readReviewModal').modal('show');
	
}

</script>                