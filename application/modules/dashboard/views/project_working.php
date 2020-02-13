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
    <li class="nav-item"><a class="active" href="<?php echo VPATH?>dashboard/myproject_working">Active Projects</a></li>
    <li class="nav-item"><a href="<?php echo VPATH?>dashboard/myproject_completed">Completed Projects</a></li> 
	<li class="nav-item"><a href="<?php echo VPATH?>dashboard/mycontest_entry">My Contests</a></li>
</ul>
<div id="editprofile">
<table id="example" class="table" cellspacing="0" width="100%">
<thead><tr><th>Project Name</th><th>Project Type</th><th>Posted By</th><th>Posted date</th><th>Action</th></tr>
</thead>
<tbody>	
<?php
if(count($working_projects)>0)
{
foreach($working_projects as $key=>$val)
{
	
$allend=explode(",",$val['end_contractor']);
$project_name=$this->auto_model->getFeild('title','projects','project_id',$val['project_id']);
$username=$this->auto_model->getFeild('username','user','user_id',$val['user_id']);

///////////////////////////Check Milestone Status/////////////////////////////
$count_milestone=$this->auto_model->count_results('id','project_milestone','project_id',$val['project_id']);
if($count_milestone>0)
{
$client_approval_Y=$this->auto_model->count_results('id','project_milestone','','',array('project_id'=> $val['project_id'],'client_approval'=>'Y'));
$client_approval_N=$this->auto_model->count_results('id','project_milestone','','',array('project_id'=> $val['project_id'],'client_approval'=>'N'));
$client_approval_D=$this->auto_model->count_results('id','project_milestone','','',array('project_id'=> $val['project_id'],'client_approval'=>'D'));
$request_by=$this->auto_model->getFeild('request_by','project_milestone','project_id',$val['project_id']);
}
//////////////////////////End Checkinh Milestone////////////////////////////////
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
<tr><td>
<?php
if($val['project_type']=='F')
{
?>
<a href="<?=VPATH?>projectdashboard_new/freelancer/overview/<?php echo $val['project_id'];?>"><?php echo $project_name;?></a>
<?php
}
else
{
?>
<a href="<?=VPATH?>projectdashboard_new/freelancer/overview/<?php echo $val['project_id'];?>"><?php echo $project_name;?></a>
<?php	
}
?>
</td>
<td><?php echo $type;?></td>
<td><?php echo $username;?></td>
<td><?php echo $this->auto_model->date_format($val['post_date']);?></td>
<?php
if($val['project_type']=='F')
{  
?>
<td class="text-center">
<!--<a href="<?=VPATH?>projectdashboard/index_freelancer/<?php echo $val['project_id'];?>"><i class="fa fa-home"></i></a>-->
<a href="<?=VPATH?>projectdashboard_new/freelancer/overview/<?php echo $val['project_id'];?>"><i class="fa fa-home"></i></a>
<?php if($val['is_completed'] == 'R'){ ?>
 &nbsp; &nbsp; Completed?<br /> <a href="<?php echo base_url('dashboard/project_complete_confirm/'.$val['project_id'].'/'.'Y?next=dashboard/myproject_working');?>">Yes</a> | <a href="<?php echo base_url('dashboard/project_complete_confirm/'.$val['project_id'].'/'.'N?next=dashboard/myproject_working');?>">No </a> 
<?php } ?>

<?php if($val['is_cancelled'] == 'R'){ ?>
 &nbsp; &nbsp; Cancelled?<br /> <a href="<?php echo base_url('dashboard/project_cancel_confirm/'.$val['project_id'].'/'.'Y?next=dashboard/myproject_working');?>">Yes</a> | <a href="<?php echo base_url('dashboard/project_cancel_confirm/'.$val['project_id'].'/'.'N?next=dashboard/myproject_working');?>">No </a> 
<?php } ?>

</td>
<?php
}
else
{
?>	
<td class="text-center"><? if($allend && in_array($user_id,$allend)){?><a href="<?=VPATH?>projectcontractor/freelancer/<?php echo $val['project_id'];?>">End Contract</a> |<? } ?> 
<!-- <a href="<?=VPATH?>projectdashboard/index_freelancer/<?php echo $val['project_id'];?>"><i class="fa fa-home"></i></a> -->
<a href="<?=VPATH?>projectdashboard_new/freelancer/overview/<?php echo $val['project_id'];?>"><i class="fa fa-home"></i></a>

<?php if($val['is_completed'] == 'R'){ ?>
 &nbsp; &nbsp; Completed?<br /> <a href="<?php echo base_url('dashboard/project_complete_confirm/'.$val['project_id'].'/'.'Y?next=dashboard/myproject_working');?>">Yes</a> | <a href="<?php echo base_url('dashboard/project_complete_confirm/'.$val['project_id'].'/'.'N?next=dashboard/myproject_working');?>">No </a> 
<?php } ?>

<?php if($val['is_cancelled'] == 'R'){ ?>
 &nbsp; &nbsp; Cancelled?<br /> <a href="<?php echo base_url('dashboard/project_cancel_confirm/'.$val['project_id'].'/'.'Y?next=dashboard/myproject_working');?>">Yes</a> | <a href="<?php echo base_url('dashboard/project_cancel_confirm/'.$val['project_id'].'/'.'N?next=dashboard/myproject_working');?>">No </a> 
<?php } ?>

</td>
<?php	
}
?>
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