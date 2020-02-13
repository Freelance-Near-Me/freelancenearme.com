<div class="dashboard-container">
<?php $this->load->view('dashboard-left'); ?>
<div class="dashboard-content-container">
    <div class="dashboard-content-inner">
    <!-- Dashboard Headline -->
	<?php echo $breadcrumb; ?>
    
    <h4>Bid Plan</h4>
	<div class="row">
		<div class="col-sm-8">
			<div class="table-responsive">
				<table class="table">
				<thead> 
					<th>Plan Name</th><th>Bids</th><th>Price (<?php echo CURRENCY;?>)</th><th></th>   	
				</thead>
				<tbody>
					<?php if(count($bid_plan) > 0){foreach($bid_plan as $k => $v){ ?>
					<tr>
						<td><?php echo $v['plan_name']; ?></td>
						<td><?php echo $v['bids']; ?></td>
						<td><?php echo $v['price']; ?></td>
						<td><button class="btn btn-primary" onclick="buy_bid('<?php echo $v['id']; ?>', this)">Buy</button></td>
					</tr>
					<?php } } ?>
				</tbody>
				</table>
			</div>
		</div>
		<div class="col-sm-4">
			<div id="fundError"></div>
		</div>
	</div>
    
</div>
</div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Buy Bid</h5>
        <button type="button" class="close btn_okay" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Bid plan buy successful.
      </div>
      <div class="modal-footer">
        <!--<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>-->
        <button type="button" class="btn btn-primary btn_okay">Okay</button>
      </div>
    </div>
  </div>
</div>


<script>

function buy_bid(id, ele){
	if(id == ''){
		return false;
	}
	
	$('.errorBx').empty();
	if(ele){
		$(ele).html('Checking...').attr('disabled', 'disabled');
	}
	
	$.ajax({
		url : '<?php echo base_url('dashboard/buy_bid_ajax'); ?>',
		data: {plan_id: id},
		dataType: 'json',
		type: 'post',
		success: function(res){
			if(res.status == 1){
				$('#exampleModal').modal('show');
			}else{
				var errors = res.errors;
				for(var i in errors){
					$('#'+i+'Error').addClass('errorBx').html(errors[i]);
				}
			}
		}
	});
}
$('.btn_okay').click(function(){
	location.href = '<?php echo base_url('dashboard/dashboard_new')?>';
});
</script>






