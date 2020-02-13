<div class="dashboard-container">
<?php $this->load->view('dashboard/dashboard-left'); ?>
<div class="dashboard-content-container">
    <div class="dashboard-content-inner" >
    <!-- Dashboard Headline -->
	<?php echo $breadcrumb; ?>
		
	<div class="table-responsive">
			<table class="table">
				<thead>  	
					<tr>
						<th>Txn ID #</th>
						<th>Wallet Info</th>
						<th>Datetime</th>
						<th>Info</th>
						<th>Status</th>
						<th>Debit (Dr)</th>
						<th>Credit (Cr)</th>
						
					</tr>
				</thead>
				<tbody>
				<?php
				if (count($all_data) > 0) {
					foreach ($all_data as $key => $val) { ?>

						<tr> 

							<td><?php echo !empty($val['txn_id']) ? $val['txn_id'] : '-'; ?></td>
							<td>
								<?php
								$wallet_id = $val['wallet_id'];
								$wallet_title = getField('title', 'wallet', 'wallet_id', $wallet_id);
								$type = 'From :';
								if($val['credit'] > 0){
									$type = 'To :';
								}
								?>
								<?php /*<b>Wallet ID # : </b><?php echo $wallet_id; ?><br/>*/ ?>
								<b><?php echo $type; ?>  </b><?php echo $wallet_title; ?> (Wallet)
							</td>
							<td><?php echo !empty($val['datetime']) ? $val['datetime'] : 'N/A'; ?></td>
							<td><?php echo !empty($val['info']) ? $val['info'] : ''; ?></td>
							<td>
							<?php
							$status = '';
							switch($val['status']){
								case 'Y' : 
									$status = '<font color="green">Success</font>';
								break;
								case 'P' : 
									$status = '<font color="blue">Pending</font>';
								break;
								case 'N' : 
									$status = '<font color="red">Rejected</font>';
								break;
							}
							echo $status;
							?>
							</td>
							<td><?php echo CURRENCY;?> <?php echo !empty($val['debit']) ? $val['debit'] : '0.00'; ?></td>
							<td><?php echo CURRENCY;?> <?php echo !empty($val['credit']) ? $val['credit'] : '0.00'; ?></td>
							
						</tr>



						<?php
					}
				} else {
					?>
					<tr>
						<td colspan="7" style="color:#F00">No records found...</td>
					</tr>
				
					<?php
				}
				?>
				</tbody>
			</table>
		</div>
</div>
</div>
</div>










