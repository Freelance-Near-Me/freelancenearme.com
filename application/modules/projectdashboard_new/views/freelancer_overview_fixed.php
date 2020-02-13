<div class="dashboard-container">
<?php $this->load->view('dashboard/dashboard-left'); ?>
<div class="dashboard-content-container">
    <div class="dashboard-content-inner" >
    <!-- Dashboard Headline -->
	<?php echo $breadcrumb; ?>
     
    <div class="row">
    <aside class="col-md-9 col-xs-12">
    <!-- Nav tabs -->
    <?php $this->load->view('freelancer_tab'); ?>
    
    <!-- Tab panes -->
    <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="overview">
        
        <div class="row">
        <article class="col-sm-6 col-xs-12">
            <?php
            $bidder_id=$this->auto_model->getFeild('bidder_id','projects','project_id',$project_detail['project_id']);
            $bidder_amt=$this->auto_model->getFeild('bidder_amt','bids','','',array('project_id'=>$project_detail['project_id'],'bidder_id'=>$bidder_id));
            $paid_amount=$this->autoload_model->getPaidAmount($project_detail['project_id'],$bidder_id);
            if(!$paid_amount){
                $paid_amount = 0;
            }
            $commission_amount = $this->projectdashboard_model->getCommission($project_detail['project_id'], $bidder_id);
			if(!$commission_amount){
				$commission_amount = 0;
			}
			
            $pending_dispute_amount = $this->projectdashboard_model->getPendingDispute($project_detail['project_id'], $bidder_id);
            $dispute_amount = $this->projectdashboard_model->getApproveDispute($project_detail['project_id']);
          
			$remaining_bal = (number_format($bidder_amt) - number_format($paid_amount) - number_format($pending_dispute_amount) - number_format($dispute_amount) - number_format($commission_amount));
            ?>
            
            <h4>Summary</h4>
            
            <ul class="list-group proamount">
                <li class="list-group-item">Project Amount : <span class="badge"><?php echo CURRENCY. $bidder_amt; ?></span></li>
                <li class="list-group-item">Paid Amount : <span class="badge"><?php echo CURRENCY. $paid_amount; ?></span></li>
                
                <?php if($pending_dispute_amount > 0){ ?>
                <li class="list-group-item">Pending Dispute Amount : <span class="badge"><?php echo CURRENCY. $pending_dispute_amount;?></span></li>
                <?php } ?>
                
                <?php if($dispute_amount > 0){ ?>
                <li class="list-group-item">Dispute Amount : <span class="badge"><?php echo ' - '.CURRENCY. $dispute_amount; ?></span></li>
                <?php } ?>
                <li class="list-group-item">Commission : <span class="badge"><?php echo CURRENCY. ($commission_amount); ?></span></li>						
                <li class="list-group-item">Remaining Amount : <span class="badge"><?php echo CURRENCY. ($remaining_bal); ?></span></li>			
            </ul>
            
        </article>
        
        <article class="col-sm-6 col-xs-12">
            <h4>&nbsp;</h4>
            <div class="alert alert-info text-left">        	
               <h4>About Job</h4>
                <p><?php echo !empty($project_detail['description']) ? $project_detail['description'] : '' ; ?></p>
            </div>
        </article>
        
        </div>
        
        <?php  
        $user_info = get_row(array('select' => '*', 'from' => 'user', 'where' => array('user_id' => $project_detail['user_id'])));
        $employer_fname = getField('fname', 'user', 'user_id', $project_detail['user_id']);
        $employer_lname = getField('lname', 'user', 'user_id', $project_detail['user_id']);
        $employer_name = $employer_fname.' '.$employer_lname;
            
        $employer_public_feedback = $employer_given_public_feedback = $employer_given_private_feedback = array();
            
        /* if(!empty($feedback['private'][$v['freelancer_id']])){
            $freelancer_private_feedback = $feedback['private'][$v['freelancer_id']];
        } */
        
        $is_employer_feedback_done = false;
        
        if(!empty($feedback['public'][$user_id.'|'.$project_detail['user_id']])){
            $employer_public_feedback = $feedback['public'][$user_id.'|'.$project_detail['user_id']];
        }
        
        if(!empty($feedback['public'][$project_detail['user_id'].'|'.$user_id])){
            $employer_given_public_feedback =$feedback['public'][$project_detail['user_id'].'|'.$user_id];
            $is_employer_feedback_done=true;
        }
        
        if(!empty($feedback['private'][$project_detail['user_id'].'|'.$user_id])){
            $employer_given_private_feedback =$feedback['private'][$project_detail['user_id'].'|'.$user_id];
            $is_employer_feedback_done=true;
        }
            
        ?>
        <h4>Employer </h4>
            <div class="table-responsive">
            <table class="table">
             <thead>
                <tr>
                    <th>Employer </th><th>Requests</th><th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php echo $user_info['fname'].' '.$user_info['lname'];?></td>
                     <td>
                    <?php if($is_employer_feedback_done){ ?>
                        <a href="javascript:void(0);" onclick="ReadFeedback(this)" data-public-feedback='<?php echo json_encode($employer_given_public_feedback); ?>' data-private-feedback='<?php echo json_encode($employer_given_private_feedback); ?>' data-name="<?php echo $employer_name; ?>">View Employer Feedback</a>
                    <?php }else{ echo ' - ';} ?>
                   </td>
                    <td class="text-right">
                        <?php if($project_detail['status'] == 'P'){ ?>
                            <a href="<?php echo base_url('message/browse/'.$project_detail['project_id'].'/'.$project_detail['user_id']);?>"><i class="zmdi zmdi-email zmdi-18x" title="Message"></i></a>&nbsp;
                            <?php } ?>
                            
                            <?php if($project_detail['status'] == 'C'){ ?>
                            
                            <!--<a href="<?php echo base_url('dashboard/rating/'.$project_detail['project_id'].'/'.$project_detail['user_id']); ?>"><i class="zmdi zmdi-star zmdi-18x" title="Rating"></i></a>-->
                            
                            <?php if(!empty($employer_public_feedback)){ ?>
                            <a href="javascript:void(0);" title="Update Feedback" onclick="updateFeedback(this)" data-employer-id="<?php echo $project_detail['user_id']; ?>" data-name="<?php echo $employer_name; ?>" data-public-feedback='<?php echo json_encode($employer_public_feedback);?>'><i class="zmdi zmdi-star zmdi-18x"></i></a>
                            <?php }else{ ?>
                                <a href="javascript:void(0);" title="Given Feedback" onclick="newFeedbackOpen(this)" data-employer-id="<?php echo $project_detail['user_id']; ?>" data-name="<?php echo $employer_name; ?>"><i class="zmdi zmdi-star zmdi-18x"></i></a>
                                
                                <?php } ?>
                                
                            <?php } ?>
                    </td>
                </tr>
            </tbody>
            </table>
            </div>
    
    </div>
    
    
    </div>
    </aside>    
    <aside class="col-md-3 col-xs-12">
    <?php $this->load->view('right-section'); ?>
    </aside>
    </div>
</div>
</div>
</div>

<?php $this->load->view('freelancer_rating_review'); ?>
