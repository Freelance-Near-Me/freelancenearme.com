<?php

$total_working_minutes_week = get_project_min_week(date('Y-m-d'), $freelancer_id, $project_id);
$total_working_minutes = get_project_all_minutes($freelancer_id, $project_id);

$total_hours = $total_hours_curr_week = 0;
$total_mins = $total_mins_curr_week = 0;

if($total_working_minutes_week > 60){
	$total_hours_curr_week = round($total_working_minutes_week/60);
	$total_mins_curr_week = $total_working_minutes_week % 60;
}else{
	$total_mins_curr_week = $total_working_minutes_week;
}

if($total_working_minutes > 60){
	$total_hours = round($total_working_minutes/60);
	$total_mins = $total_working_minutes % 60;
}else{
	$total_mins = $total_working_minutes;
}



?>

<div class="row">
  <div class="col-sm-6">
    <div class="well text-center margin-bottom-20">
      <h4>This week</h4>
      <i class="far fa-clock fa-4x site-text"></i>
      <h2><?php echo $total_hours_curr_week.':'.$total_mins_curr_week;?>hrs</h2>
    </div>
  </div>
  <div class="col-sm-6">
    <div class="well text-center margin-bottom-20">
      <h4>Since start</h4>
      <i class="far fa-clock fa-4x site-text"></i>
      <h2><?php echo $total_hours.':'.$total_mins;?>hrs</h2>
    </div>
  </div>
</div>
<div class="h-title">Time Tracking</div>
<p>Memo : Forums Check</p>
