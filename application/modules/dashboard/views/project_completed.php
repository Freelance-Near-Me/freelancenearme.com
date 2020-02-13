
<script src="<?=JS?>mycustom.js"></script>
<link rel="stylesheet" type="text/css" href="<?=CSS?>datatable/dataTables.responsive.css">
<link rel="stylesheet" type="text/css" href="<?=CSS?>datatable/dataTables.bootstrap.css">
<script type="text/javascript" language="javascript" src="<?=CSS?>datatable/jquery.dataTables.min.js"></script> 
<script type="text/javascript" language="javascript" src="<?=CSS?>datatable/dataTables.responsive.min.js"></script> 
<script type="text/javascript" language="javascript" src="<?=CSS?>datatable/dataTables.bootstrap.js"></script> 
<script type="text/javascript" charset="utf-8">
$(document).ready(function() {
$('#example').dataTable({
columns: [
{},
{ },
{ orderable:      false, },
{  },
{ orderable:      false,},

],
"order": [[ 4, "desc" ]]
});
} );
</script> 
<div class="dashboard-container">
<?php $this->load->view('dashboard-left'); ?>
<div class="dashboard-content-container">
    <div class="dashboard-content-inner">
    <!-- Dashboard Headline -->
	<?php echo $breadcrumb; ?>
	<ul class="nav nav-tabs">
        <li class="nav-item"><a href="<?php echo VPATH?>dashboard/myproject_professional">My Bid</a></li>
        <li class="nav-item"><a href="<?php echo VPATH?>dashboard/myproject_working">Active Projects</a></li>
        <li class="nav-item"><a class="active" href="<?php echo VPATH?>dashboard/myproject_completed">Completed Projects</a></li>
		<li class="nav-item"><a href="<?php echo VPATH?>dashboard/mycontest_entry">My Contests</a></li>
    </ul>  
    <div id="editprofile">
        <table id="example" class="table" cellspacing="0" width="100%">
          <thead>
            <tr>
              <th>Project Name</th>
              <th>Project Type</th>
              <th>Posted By</th>
              <th>Posted date</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
if(count($working_projects)>0)
{
foreach($working_projects as $key=>$val)
{
$project_name=$this->auto_model->getFeild('title','projects','project_id',$val['project_id']);
$username=$this->auto_model->getFeild('username','user','user_id',$val['user_id']);
$bidder_name=$this->auto_model->getFeild('username','user','user_id',$val['bidder_id']);
$count_review=$this->dashboard_model->countReview($val['project_id'],$user_id,$val['user_id']);
$type="";
if($val['project_type']=="F")
{
$type="Fixed";
}
else
{
$type="Hourly";
}
?>
                <tr>
                  <td><?php echo $project_name;?></td>
                  <td><?php echo $type;?></td>
                  <td><?php echo $username;?></td>
                  <td><?php echo $this->auto_model->date_format($val['post_date']);?></td>
                  <td>
				  <a href="<?=VPATH?>projectdashboard_new/freelancer/overview/<?php echo $val['project_id'];?>"><i class="fa fa-home"></i></a>
				  <?php 
		/* if($count_review>0)
		{
		echo "<a href='".VPATH."dashboard/viewfeedback/".$val['project_id']."/".$val['user_id']."/".$project_name."'>View Feedback</a>";	
		}
		else
		{
		echo "<a href='".VPATH."dashboard/rating/".$val['project_id']."/".$val['user_id']."/".$project_name."'>Give Feedback</a>";	
		} */
		
?></td>
                </tr>
                <?php
}
}

?>
              </tbody>
		</table>
           
</div>

  </div>
</div>
</div>