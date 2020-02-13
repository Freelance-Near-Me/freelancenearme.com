<script src="<?=JS?>mycustom.js"></script>

<div class="dashboard-container">
<?php $this->load->view('dashboard/dashboard-left'); ?>
<div class="dashboard-content-container">
    <div class="dashboard-content-inner" >
    <!-- Dashboard Headline -->
	<?php echo $breadcrumb; ?>
        <ul class="nav nav-tabs">
          <li class="nav-item"><a  href="<?php echo VPATH;?>myfinance/" ><?php echo __('myfinance_add_fund','Add Fund'); ?></a></li>
          <li class="hidden"><a  href="<?php echo VPATH;?>myfinance/milestone" ><?php echo __('myfinance_milestone','Milestone'); ?></a></li>
          <li class="nav-item"><a href="<?php echo VPATH;?>myfinance/withdraw" ><?php echo __('myfinance_withdraw_fund','Withdraw Fund'); ?></a></li>
          <li class="nav-item"><a class="active" href="<?php echo VPATH;?>myfinance/transaction" ><?php echo __('myfinance_transaction_history','Transaction History'); ?></a></li>
          <li class="hide"><a href="<?php echo VPATH;?>membership/" ><?php echo __('myfinance_membership','Membership'); ?></a></li>
        </ul>
        <div class="balance"><b>Balance: </b> <span class="badge badge-border"><?php echo CURRENCY;?><?php echo $balance;?></span></div>
        <!--EditProfile Start-->
        <div class="editprofile">
          <div class="row">
          <aside class="col-md-9">
            <h4><?php echo __('myfinance_select_date_for_which_transaction_history_want','Select date for which you want your transaction history'); ?></h4>
          </aside>
          <aside class="col-md-3">
            <a href="<?php echo VPATH;?>myfinance/generateCSV_new/" class="btn btn-border pull-right" style="margin-bottom:10px"><?php echo __('myfinance_download_statement','Download Statement'); ?></a>
		  </aside>
          </div>
          <div class="transbox d-block padding-bottom-20">
            <form class="form-horizontal">
              <div class="row" style="margin-top:15px">              
                <div class="col-sm-5">                    
                  <div class='input-group'>
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="icon-feather-calendar"></i>
                    </span>
                    </div>
                    <input type='text' class="form-control datepicker" id="datepicker_from" name="from" placeholder="<?php echo __('myfinance_from','From'); ?>" value="<?php echo !empty($srch['from']) ? $srch['from'] : '';?>" />                    
                  </div>                           
                </div>
				<div class="col-sm-5">                     
                   <div class='input-group'>
                   <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="icon-feather-calendar"></i>
                    </span>
                    </div>
                    <input type='text' class="form-control datepicker" id="datepicker_to" name="to" placeholder="<?php echo __('myfinance_to','To'); ?>"  value="<?php echo !empty($srch['to']) ? $srch['to'] : '';?>" />                    
                  </div>              
                </div>
                <div class="col-sm-2">
                	<input type="submit" name="submit" class="btn btn-site btn-block" value="<?php echo __('myfinance_go','Go'); ?>">
              	</div>
              </div>
            </form>
          </div>
          <div class="transbox">
            <h5><?php echo __('myfinance_statement_period','Statement Period'); ?>:</h5>
            <p><span><?php echo __('myfinance_all_transaction','All transactions'); ?></span></p>
          </div>
          <div class="transbox">
            <h5><?php echo __('myfinance_beginning_balance','Beginning Balance');; ?>:</h5>
            <p><span><?php echo CURRENCY;?> 0.00 </span></p>
          </div>
          <div class="transbox">
            <h5><?php echo __('myfinance_total_debits','Total Debits'); ?>:</h5>
            <p>
			<span class="hidden"><?php echo CURRENCY;?>
              <?php if($tot_debit[0]->amount!='') {echo $tot_debit[0]->amount;} else {echo '0.00';}?>
              </span>
			  
			  <span>
				<?php echo !empty($debit_total) ? CURRENCY.' '.$debit_total : CURRENCY. ' 0.00'; ?>
              </span>
			  
			  </p>
          </div>
          <div class="transbox">
            <h5><?php echo __('myfinance_total_cradits','Total Credits'); ?>:</h5>
            <p>
			<span class="hidden"><?php echo CURRENCY;?>
              <?php if($tot_credit[0]->amount!='') {echo $tot_credit[0]->amount;} else {echo '0.00';}?>
              </span>
			  
			  <span>
              <?php echo !empty($credit_total) ? CURRENCY.' '.$credit_total : CURRENCY. ' 0.00'; ?>
              </span>
			  
			  </p>
          </div>
          <div class="transbox">
            <h5><?php echo __('myfinance_ending_balance','Ending Balance'); ?>:</h5>
            <p><span><?php echo CURRENCY;?> <?php echo $credit_total - $debit_total;?></span></p>
          </div>
        </div>
        <!--EditProfile End-->
        
        <div class="spacer-20"></div>
		<div class="clearfix"></div>
		<!-- new transaction history (Bishu) -->
		<h4><?php echo __('myfinance_transaction_details','Transaction Details'); ?></h4>
        <div class="table-responsive">
			<table class="table">
					<thead>
					  <tr>
						<th><?php echo __('myfinance_date','Date'); ?></th>
						<th><?php echo __('myfinance_txn_id','TXN ID'); ?></th>
						<th><?php echo __('myfinance_info','Info'); ?></th>
						<th><?php echo __('myfinance_cradit_cr','Credit (Cr)'); ?></th>
						<th><?php echo __('myfinance_debit_dr','Debit (Dr)'); ?></th>
						<th><?php echo __('myfinance_status','Status'); ?></th>
						<th><?php echo __('myfinance_invoice','Invoice'); ?></th>
					  </tr>
					</thead>
					<tbody>
						<?php if(count($all_data) > 0){foreach($all_data as $k => $v){ ?>
						<tr>
							<td><?php echo !empty($v['datetime']) ? date('d M, Y h:i A', strtotime($v['datetime'])) : '' ;?></td>
							<td><?php echo !empty($v['txn_id']) ? $v['txn_id'] : '' ;?></td>
							<td> <?php echo !empty($v['info']) ? $v['info'] : '' ;?></td>
							<td> <?php echo !empty($v['credit']) ? CURRENCY.' '.$v['credit'] : CURRENCY. ' 0.00' ;?></td>
							<td><?php echo !empty($v['debit']) ? CURRENCY. ' '.$v['debit'] : CURRENCY. ' 0.00' ;?></td>
							<td>
							<?php
								$status = '';
								switch($v['status']){
									case 'Y' : 
										$status = '<span class="badge badge-success">'.__('myfinance_success','Success').'</span>';
									break;
									case 'P' : 
										$status = '<span class="badge badge-warning">'.__('myfinance_pending','Pending').'</span>';
									break;
									case 'N' : 
										$status = '<span class="badge badge-danger">'.__('myfinance_rejected','Rejected').'</span>';
									break;
								}
								echo $status;
								?>
							</td>
							<td>&nbsp;
								<?php if($v['invoice_id'] > 0){ ?>
								<a href="<?php echo base_url('invoice/detail/'.$v['invoice_id']); ?>" target="_blank">Invoice</a>
								<?php	} ?>
							</td>
						</tr>
						<?php } }else{  ?>
						<tr>
							<td colspan="10" align="center"><?php echo __('myfinance_no_transaction_found','No transacion found'); ?> </td>
						</tr>
						<?php } ?>
					</tbody>
			  
			
			
			</table>
  
		</div>
        
		<?php  echo $links2; ?>
		
	</div>
</div>
</div>