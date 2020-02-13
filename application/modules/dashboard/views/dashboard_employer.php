<div class="dashboard-container">
<?php $this->load->view('dashboard-left'); ?>
<div class="dashboard-content-container">
    <div class="dashboard-content-inner" >
    <!-- Dashboard Headline -->
	<?php echo $breadcrumb; ?> 
	
	<div class="spacer-20"></div>
    <?php
	$user = $this->session->userdata('user');
	$verify = getField('verify', 'user', 'user_id', $user[0]->user_id);
	if($verify == 'N'){
	?>
	<div class="row-0 alert alert-danger">
		***<?php echo __('dashboard_you_can\'t_bid_on_job_until_your_account_has_not_verified_by_admin','You can\'t post job until your account has not verified by admin')?>.
	</div>
	<?php
	}
	?>
	
    <div class="fun-facts-container">
    	<div class="fun-fact">
        	<div id="chartContainer" style="height: 150px; width: 100%;"></div>    		
        </div>
        <div class="fun-fact" data-fun-fact-color="#8e54e9" style='cursor: pointer' onclick='window.location.href="<?php echo base_url('dashboard/myproject_client')?>"'>        	
        	<div class="fun-fact-text">
                <span>Posted Jobs</span>
                <h4><?php echo $total_posted_work; ?></h4>
            </div>            
            <div class="fun-fact-icon"><i class="icon-material-outline-business-center"></i></div>
        </div>
        <div class="fun-fact" data-fun-fact-color="#8e54e9" style='cursor: pointer' onclick='window.location.href="<?php echo base_url('myfinance/transaction')?>"'>         
			<div class="fun-fact-text">
				<span>Total Spent on Projects</span>
				<h2><?php echo CURRENCY. ' '.number_format($spend_amount);?></h2>
			</div> 
			<div class="fun-fact-icon"><i class="icon-feather-dollar-sign"></i></div>      
		</div>
    </div>
    <div class="fun-facts-container">
        <div class="fun-fact" data-fun-fact-color="#fc0" style='cursor: pointer' onclick='window.location.href="<?php echo base_url('dashboard/myproject_client').'?status=O'?>"'>
        	
            <div class="fun-fact-text">
                <span>Open project</span>
                <h4><?php echo $project_statics_show['open_projects']; ?></h4>
            </div> 
            <div class="fun-fact-icon"><i class="icon-material-outline-assignment"></i></div>           
        </div>
        <div class="fun-fact" data-fun-fact-color="#0c0" style='cursor: pointer' onclick='window.location.href="<?php echo base_url('dashboard/myproject_client').'?status=C'?>"'>
        	
            <div class="fun-fact-text">
                <span>Completed project</span>
                <h4><?php echo $project_statics_show['completed_projects']; ?></h4>
            </div>      
            <div class="fun-fact-icon"><i class="icon-material-outline-assignment"></i></div>      
        </div>
        <div class="fun-fact" data-fun-fact-color="#f06" style='cursor: pointer' onclick='window.location.href="<?php echo base_url('dashboard/myproject_client').'?status=P'?>"'>
        	
            <div class="fun-fact-text">
                <span>Processing project</span>
                <h4><?php echo $project_statics_show['active_projects']; ?></h4>
            </div>            
            <div class="fun-fact-icon"><i class="icon-material-outline-assignment"></i></div>
        </div>
	</div>
     
	
	<div class="card">
		<div class="card-header"><h4>Escrow View</h4></div>
        <div class="card-body">
		 <div class="table-responsive">
			<table class="table m-0">
			  <thead> 
				<tr>
					<th>#Project ID</th>
					<th>Project</th>
					<th>Escrowed Amount (<?php echo CURRENCY; ?>)</th>
					<th>Released Amount (<?php echo CURRENCY; ?>)</th>
				</tr>
				</thead>
				<tbody>
					<?php if(count($escrow_statics) > 0){foreach($escrow_statics as $k => $v){ ?>
					<tr>
						<td><a href="<?php echo base_url('myfinance/project_all_transaction/'.$v['project_id'])?>"><?php echo !empty($v['project_id']) ? '#'.$v['project_id'] : ''; ?></a></td>
						<td><?php echo !empty($v['title']) ? (strlen($v['title']) > 60 ? substr($v['title'], 0, 60).'...' : $v['title']) : ''; ?></td>
						<td style="color:green;"><?php echo !empty($v['total_credit']) ? $v['total_credit'] : ''; ?></td>
						<td style="color:red;"><?php echo !empty($v['total_debit']) ? $v['total_debit'] : ''; ?></td>
					</tr>
					<?php } }else{  ?>
					<tr>
						<td colspan="10" style="text-align:center;">No records found</td>
					</tr>
					<?php } ?>

				</tbody>
				
			</table>
		</div>
        </div>
	</div>
    
    <h4 class="float-left  margin-top-10">Recent Posted Work</h4>
    <a href="<?php echo base_url('postjob');?>" class="btn btn-site float-right margin-bottom-10">Post Job</a>
    <div class="clearfix"></div>
    <div class="table-responsive">
        <table class="table">
        <thead> 
        	<th>Project title</th><th>Bids</th><th>Hourly/Fixed</th><th>Posted on</th><th>Status</th>      	        	
        </thead>
        <tbody>
			
			<?php if(count($recent_project) > 0){foreach($recent_project as $k => $v){ 
			$url = '';
			
			if(($v['project_status'] == 'O') || ($v['project_status'] == 'E') || ($v['project_status'] == 'F')){
				$url =  base_url('jobdetails/details/'.$v['project_id'].'/'.seo_string($v['title']).'/');
			}else{
				$url = base_url('projectdashboard_new/employer/overview/'.$v['project_id']);
			}
			?>
            <tr>
              <td><a href="<?php echo $url; ?>"><?php echo strlen($v['title']) > 90 ? substr($v['title'], 0, 90).'...' : $v['title'];  ?></a></td>
			   <td><?php echo $v['total_bids']; ?></td>
			   <td><?php echo $v['project_type'] == 'F' ? 'Fixed' : 'Hourly';?></td>
			   <td><?php echo date('d M , Y', strtotime($v['post_date']));?></td>
			   <td><a href="<?php echo base_url('jobdetails/details/'.$v['project_id'].'/'.seo_string($v['title']).'/')?>">Details</a></td>
            </tr>             
			<?php } }else{  ?>
			<tr>
				<td colspan="10" style="text-align:center;">No recent project found</td>
			</tr>
			<?php } ?>
           
        </tbody>
        </table>
	</div>

</div>
</div>
</div>

<script>
window.onload = function () {

var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,	
	legend:{
		cursor: "pointer",
		horizontalAlign: "right",
		verticalAlign: "center",
		fontSize: 12,
		fontFamily: "sans-serif"
	},
	data: [{
		type: "pie",
		showInLegend: true,
		indexLabelWrap: false,  // change to true
		//indexLabel: "{name} - {y}%",
		dataPoints:<?php echo json_encode($project_statics);?>
	}]
});
chart.render();
}
</script>
<script src="<?php echo ASSETS;?>plugins/canvasjs/canvasjs.min.js" type="text/javascript"></script>











