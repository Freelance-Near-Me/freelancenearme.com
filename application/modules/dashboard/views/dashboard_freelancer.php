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
		***<?php echo __('dashboard_you_can\'t_bid_on_job_until_your_account_has_not_verified_by_admin','You can\'t bid on job until your account has not verified by admin')?>.
	</div>
	<?php
	}
	?>
	
    <!-- Fun Facts Container -->
    
    <div class="fun-facts-container">
        <div class="fun-fact" data-fun-fact-color="#8e54e9">        	
            <div class="fun-fact-text">
                <span>Looking for projects,<br /> FreelancerNearMe is here to help You!</span>
                <a href="<?php echo base_url('findjob');?>" class="btn btn-border">Browse Project</a>
            </div>
            <div class="fun-fact-icon"><i class="icon-feather-user"></i></div>
        </div>
        
        <div class="fun-fact" data-fun-fact-color="#8e54e9">        	
            <div class="fun-fact-text">
                <!--<span>Add more bid to your account</span>-->
				<span>Add more Bids</span>
                <a href="<?php echo base_url('dashboard/bid_plan');?>" class="btn btn-border">Buy Bid</a>
            </div>  
            <div class="fun-fact-icon"><i class="icon-feather-user-plus"></i></div>          
        </div>
    </div>
    <?php
	$available_bids = get_available_bids($user_id);
	/* $free_bid = get_available_bids($user_id, TRUE);
	$purchase_bid = getField('available_bids', 'user', 'user_id', $user_id); */
	?>
    <div class="fun-facts-container">
    	<div class="fun-fact" data-fun-fact-color="#8e54e9">        	
            <div class="fun-fact-text">
                <span>Available Bids</span>
                <h4><?php echo $available_bids; ?></h4>
            </div> 
            <div class="fun-fact-icon"><i class="icon-material-outline-gavel"></i></div>           
        </div>
        
        <div class="fun-fact" data-fun-fact-color="#8e54e9" style='cursor: pointer' onclick='window.location.href="<?php echo base_url('myfinance/transaction')?>"'>
            <div class="fun-fact-text">
                <span>Total Earnings</span>
                <h4><?php echo number_format($earned_amount,2);?></h4>
            </div>   
            <div class="fun-fact-icon"><i class="icon-feather-dollar-sign"></i></div>         
        </div>

        <!-- Last one has to be hidden below 1600px, sorry :( -->
        <div class="fun-fact" data-fun-fact-color="#8e54e9" style='cursor: pointer' onclick='window.location.href="<?php echo base_url('dashboard/myproject_professional')?>"'>        	
            <div class="fun-fact-text">
                <span>Total bids</span>
                <h4><?php echo $total_bids; ?></h4>
            </div>            
            <div class="fun-fact-icon"><i class="icon-material-outline-assignment"></i></div>
        </div>
    </div>
	<div class="fun-facts-container">
        <div class="fun-fact" data-fun-fact-color="#8e54e9" style='cursor: pointer' onclick='window.location.href="<?php echo base_url('dashboard/myproject_working')?>"'>        	
            <div class="fun-fact-text">
                <span>Active project</span>
                <h4><?php echo $project_statics_show['active_projects']; ?></h4>
            </div>     
            <div class="fun-fact-icon"><i class="icon-material-outline-assignment"></i></div>       
        </div>
        <div class="fun-fact" data-fun-fact-color="#8e54e9" style='cursor: pointer' onclick='window.location.href="<?php echo base_url('dashboard/myproject_completed')?>"'>        	
            <div class="fun-fact-text">
                <span>Completed project</span>
                <h4><?php echo $project_statics_show['completed_projects']; ?></h4>
            </div>            
            <div class="fun-fact-icon"><i class="icon-material-outline-assignment"></i></div>
        </div>
        <div class="fun-fact" data-fun-fact-color="#8e54e9" style='cursor: pointer' onclick='window.location.href="<?php echo base_url('dashboard/mycontest_entry')?>"'>        	
            <div class="fun-fact-text">
                <span>Total Contests</span>
                <h4><?php echo $project_statics_show['total_contest']; ?></h4>
            </div>           
            <div class="fun-fact-icon"><i class="icon-material-outline-assignment"></i></div> 
        </div>
	</div>
	<?php /*?>
    <?php
        $available_bids = get_available_bids($user_id);
        $free_bid = get_available_bids($user_id, TRUE);
        $purchase_bid = getField('available_bids', 'user', 'user_id', $user_id);
        ?>			
        <h5 class="text-uppercase"><i>Free Bid : <?php echo $free_bid; ?></i></h5>
        <h5 class="text-uppercase"><i>Purchase Bid : <?php echo $purchase_bid; ?></i></h5>
    <?php */?>
    
    <div class="card">
    <div class="card-header"><h4 class="m-0">Recent Bids</h4></div>
    <div class="card-body">
    <div class="table-responsive">
        <table class="table m-0">
        <thead> 
        	<th>Project title</th><th>Posted on</th><th>Hourly/Fixed</th><th>Bid amount</th><th>Status</th>      	        	
        </thead>
        <tbody>
			<?php if(count($recent_bids) > 0){foreach($recent_bids as $k => $v){ 
			$p_status = '';
			$all_bidders = explode(',', $v['all_bidders']);
			$href =  base_url('jobdetails/details/'.$v['project_id'].'/'.seo_string($v['title']));
			if($v['project_status'] == 'O'){
				
				$p_status = '<span class="badge badge-warning">Pending</span>';
				
			}else{
				
				if($v['project_type'] == 'F'){
					
					
					if(in_array($user_id, $all_bidders)){
						if($v['project_status'] == 'C'){
							$p_status = '<span class="badge badge-warning">Completed</span>';
							$href = base_url('projectdashboard_new/freelancer/overview/'.$v['project_id']);
						}else if($v['project_status'] == 'CNL'){
							$p_status = '<span class="badge badge-danger">Cancelled</span>';
						}else{
							$p_status = '<span class="badge badge-success">Active</span>';
							$href = base_url('projectdashboard_new/freelancer/overview/'.$v['project_id']);
						}
						
					}else if($v['project_status'] == '0'){
						$p_status = '<span class="badge badge-warning">Pending</span>';
					}else{
						$p_status = '<span class="badge badge-warning">Bid Lost</span>';
					}
					
					
				}elseif($v['project_type'] == 'H'){
					$schedulw_row = $this->db->where(array('project_id' => $v['project_id'], 'freelancer_id' => $user_id))->get('project_schedule')->row_array();
					
					if(!empty($schedulw_row)){
						if($schedulw_row['is_contract_end'] == 1){
							$p_status = '<span class="badge badge-danger">Ended</span>';
							$href = base_url('projectdashboard_new/freelancer/overview/'.$v['project_id']);
						}else{
							$p_status = '<span class="badge badge-success">Active</span>';
							$href = base_url('projectdashboard_new/freelancer/overview/'.$v['project_id']);
						}
						
					}else{
						$p_status = '<span class="badge badge-warning">Pending</span>';
					}
					
				}
			
			}
			
			
			?>
			
			<tr>
               <td><a href="<?php echo $href; ?>"><?php echo strlen($v['title']) > 90 ? substr($v['title'], 0, 90).'...' : $v['title'];  ?></a></td>
			   <td><?php echo date('d M , Y', strtotime($v['post_date']));?></td>
			   <td><?php echo $v['project_type'] == 'F' ? 'Fixed' : 'Hourly';?></td>
			   <td><?php echo CURRENCY.$v['bidder_amt']; if($v['project_type'] == 'H'){ echo ' /hr'; } ?></td>
			   <td><?php echo $p_status; ?> </td>
            </tr> 
			
			<?php } }else{ ?>
			<tr>
				<td colspan="10" style="text-align:center;">No records found</td>
			</tr>
			<?php  } ?>
       
        </tbody>
        </table>
	</div>
    </div>
    </div>
</div>
</div>
</div>












