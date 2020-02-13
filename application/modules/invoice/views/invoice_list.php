<style>
.table > tbody > tr.blank_row > td {
	border-left:0;
	border-right:0;
	padding:3px;
}
@media (min-width: 768px) and (max-width: 991px){
.invoice_search {
	margin-top:10px
}
}
</style>
<div class="dashboard-container">
<?php $this->load->view('dashboard/dashboard-left'); ?>
<div class="dashboard-content-container">
    <div class="dashboard-content-inner" >
    <!-- Dashboard Headline -->
	<?php echo $breadcrumb; ?>
    

	<form>
	<div class="row row-10 invoice_search">	
				<div class="col-sm-5">
					<input type="text" class="form-control" placeholder="Invoice number" name="invoice_number" value="<?php echo !empty($srch['invoice_number']) ? $srch['invoice_number'] : ''; ?>"/>
				</div>
				<div class="col-sm-5">
					<select class="selectpicker hide-tick form-control mb-3" name="invoice_type">
						<option value="">Choose invoice type</option>
						<?php if(count($invoice_type)> 0){foreach($invoice_type as $k => $v){ ?>
						<option value="<?php echo $v['invoice_type_id'];?>" <?php echo (!empty($srch['invoice_type']) AND $srch['invoice_type'] == $v['invoice_type_id']) ? 'selected="selected"' : ''; ?>><?php echo $v['type'];?></option>
						<?php } } ?>
					</select>
				</div>
				<div class="col-sm-2">
				<button type="submit" class="btn btn-site btn-block">Search</button>
				</div>
				
			</div>
	</form>
	<div class="spacer-20"></div>
	<div class="table-responsive">
    
	<table class="table">
        <thead>
        <tr>
            <th>Invoice Number</th> <th>Invoice type</th> <th>Date</th><th>From/To</th><th>Status</th><th>Invoice</th>
        </tr>
        </thead>
        <tbody>
		<?php if(count($invoice_list) > 0){foreach($invoice_list as $k => $v){
		if($v['sender_id'] == $user_id){
			$user_info = getField('fname', 'user', 'user_id', $v['receiver_id']);
		}else{
			if($v['sender_id']  > 0){
				$user_info = getField('fname', 'user', 'user_id', $v['sender_id']);
			}else{
				$user_info = SITE_TITLE;
			}
			
		}
		
		$is_paid = $is_deleted = $is_pending = 0;
		$row_class = '';
		if($v['is_paid'] != '0000-00-00 00:00:00'){
			
			$is_paid = 1;
			$row_class = 'paid';
		}else if($v['is_deleted'] != '0000-00-00 00:00:00'){
			$is_deleted = 1;
			$row_class = 'deleted';
		}else{
			$is_pending = 1;
			$row_class = 'pending';
		}
		?>
		<tr class="<?php echo $row_class; ?>">
           <td><?php echo $v['invoice_number']; ?></td>
           <td><?php echo $v['type']; ?></td>
           <td><?php echo $v['invoice_date']; ?></td>
           <td><?php echo $user_info; ?></td>
		     <td class="status">
		   <?php 
		   
		   if($is_pending == 1){
			   echo '<span class="badge badge-warning">Pending</span>';
		   }elseif($is_deleted == 1){
			   echo '<span class="badge badge-danger">Deleted</span>';
		   }elseif($is_paid == 1){
			   echo '<span class="badge badge-success">Paid</span>';
		   }
		   
		   ?>
		   </td>
		   <td><a href="<?php echo base_url('invoice/detail/'.$v['invoice_id'])?>" target="_blank"><i class="icon-feather-eye" title="view"></i></a></td>
        </tr>
		<?php if(($k+1) != count($invoice_list)){ ?>
		<tr class="blank_row"><td colspan="6"></td></tr>
		<?php } ?>
		<?php } }else{   ?>
		<tr>
			<td colspan="10" align="center">No records</td>
		</tr>
		<?php }   ?>
		
        </tbody>
        </table>
    
    </div>
    <?php echo $links; ?>
	
</div>
</div>
</div>