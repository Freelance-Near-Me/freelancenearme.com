<script src="<?=JS?>mycustom.js"></script>
<div class="dashboard-container">
<?php $this->load->view('dashboard/dashboard-left'); ?>
<div class="dashboard-content-container">
    <div class="dashboard-content-inner" >
    <!-- Dashboard Headline -->
	<?php echo $breadcrumb; ?>

<!--ProfileRight Start-->
<?php
if($this->session->flashdata('succ_msg'))
{
?>
<div class="success alert-success alert"><?php echo $this->session->flashdata('succ_msg');?></div>
<?php	
}
if($this->session->flashdata('error_msg'))
{
?>
<div class="success alert-success alert"><?php echo $this->session->flashdata('error_msg');?></div>
<?php
}
?>
<ul class="nav nav-tabs">
    <li class="nav-item"><a href="<?php echo VPATH;?>myfinance/" ><?php echo __('myfinance_add_fund','Add Fund'); ?></a></li>
    <li class="hidden"><a href="<?php echo VPATH;?>myfinance/milestone" ><?php echo __('myfinance_milestone','Milestone'); ?></a></li> 
    <li class="nav-item"><a class="active" href="<?php echo VPATH;?>myfinance/withdraw" ><?php echo __('myfinance_withdraw_fund','Withdraw Fund'); ?></a></li> 
    <li class="nav-item"><a href="<?php echo VPATH;?>myfinance/transaction" ><?php echo __('myfinance_transaction_history','Transaction History'); ?></a></li> 
    <li class="hide"><a  href="<?php echo VPATH;?>membership/" ><?php echo __('myfinance_membership','Membership'); ?></a></li> 
</ul>

<div class="balance"><b>Balance: </b> <span class="badge badge-border"><?php echo CURRENCY;?><?php echo $balance;?></span></div>

<!--EditProfile Start-->
<div class="clearfix"></div>
<div id="editshow" class="table-responsive">	 	 	
<table class="table">
<thead>
<tr><th><?php echo __('myfinance_method','Method'); ?></th>	<th class="hidden"><?php echo __('myfinance_flance_fees_per_withdrawal','Flance Fees (per withdrawal)'); ?></th> 	<th><?php echo __('myfinance_account','Account'); ?></th> <th><?php echo __('myfinance_withdraw','Withdraw'); ?></th>  <th><?php echo __('myfinance_actions','Actions'); ?></th></tr>
</thead>
<tbody>
<?php 
$pay_pal="";
$wire_acn ="";
$pay_skrill="";
foreach($bank_account as $bank_acc){

    if($bank_acc['account_for'] =='P'){
    $pay_pal = $bank_acc['paypal_account'];
    
    }elseif($bank_acc['account_for'] =='W'){
    
    $wire_acn = $bank_acc['wire_account_no'];
    }elseif($bank_acc['account_for'] =='S'){
    
    $pay_skrill = $bank_acc['skrill_account'];
    }

}

?>


<?php 
if($paypal_setting=="Y"){ 
?>
<tr>
<td><?php echo __('myfinance_paypal','Paypal'); ?></td>
<td class="hidden"><?php echo $paypal_fees;?>%</td>
<td><?php if($pay_pal){

echo $pay_pal;

}
else{

echo __('myfinance_not_register','Not Registered');
}
?></td>
<td>
<?php if($pay_pal){ ?>


<?php  if($balance>0) {?>

<a href="transfer/p"> <?php echo __('myfinance_click_here','Click Here'); ?> </a>
<?php }else{ ?>

    <?php echo __('myfinance_no_balance','No Balance'); ?>
<?php } ?>
<?php }else{

echo '--------';
}
?>
</td>


<td>
<?php
if($pay_pal){ ?>
<a href="paypal_setting" title="<?php echo __('myfinance_edit_account','Edit Account'); ?>"><i class="icon-feather-edit"></i></a>
<?php }else{?>
<a href="paypal_setting" title="<?php echo __('myfinance_add_account','Add Account'); ?>"><i class="icon-feather-user-plus"></i></a>
<?php }?>
</td>
</tr>
<?php 
}
?>
<?php 
if($skrill_setting=="Y"){ 
?>
<tr>  
<td>Skrill</td>
<td><?php echo $skill_fees;?>%</td>
<td><?php if($pay_skrill){

echo $pay_skrill;

}else{

echo 'Not Registered';
}
?></td>
<td>
<?php if($pay_skrill){ ?>
<?php  if($balance>0) {?>

<a href="transfer/s"> Click Here </a>
<?php }else{ ?>

    No Balance
<?php } ?>
<?php }else{

echo '--------';
}
?></td>
<td><?php


if($pay_skrill){ ?>
<a href="skrill_setting">Edit Account</a>
<?php }else{?>
<a href="skrill_setting">Add Account</a>
<?php }?></td>
</tr>
<?php 
}
?>
<?php 
if($wire_setting=="Y"){ 
?>	
<tr>
<td>Wire Transfer</td>
<td><?php echo CURRENCY." ".$wire_transfer_fees;?></td>
<td><?php 


if($wire_acn){?>
Verified
<?php }else{?>
Not Registered
<?php } ?>
</td>
<td><?php if($wire_acn){?>
<?php  if($balance>0) {?>
<a href="transfer/w"> Click Here </a>
<? } else{?>
No Balance
<?php } ?>

<?php }else{?>
------
<?php } ?></td>
<td><a href="wire_setting">
<?php if($wire_acn){
echo 'Edit Account';
}else{
echo 'Add Account';
}
?>
</a></td>
</tr>
<?php 
}
?>
</tbody>
</table>
</div>
<!--EditProfile End-->
</div>
</div>
</div>     
                  
<script> 
  function setamt(){ 
    $("#amount").val($("#depositamt_txt").val());
  }
  
  // Check Answer Validation before Next step
  function securityCheckBeforePay(){
  
				var ans = $("#answer").val();	
				
			    if(ans == ''){
				
				$("#answerError").text("! Answer is required.");
				
				$("#answerError").css("color","#d50000");
				
				
				}	
			     else{
				 				
					var dataString = 'answer='+$("#answer").val();
					$.ajax({
					type:"POST",
					data:dataString,
					url:"<?php echo VPATH;?>myfinance/checkAnswerBeforePay",
					beforeSend: function (){
					   $(".error").remove();
					   
					},
					success:function(return_data){
					
					//alert(return_data);
					if(return_data == 'Y')
					{
					  alert("Answer Matched you can Edit Your Account !!");
					  $("#next").removeAttr('disabled');
					  $("#formCheck").hide();
					  $("#editshow").show();
					}
					else
					{
						//$('#formCheck').prepend('<span class="error">Answer Doesnt Match Try Again !!</span>');
						$("#answerError").text("Answer Do not Match Try Again !!");
						$("#editshow").hide();
					}
					}
				});
				 
				/* 	
				  var result = FormPost('#next',"<?=VPATH?>","<?=VPATH?>myfinance/checkAnswerBeforePay",'security_questionAnswer');
				  if(result == 'Y')
				  {
					  $("#create_btn").removeAttr('disabled');
					  $("#formCheck").hide();
					  $("#editshow").show();
				  }
					else
					{
					$("#editshow").hide();
					}	 */				
				 
               }
  
  }
  
</script>