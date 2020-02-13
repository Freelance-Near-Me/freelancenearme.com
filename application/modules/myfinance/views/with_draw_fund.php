<?php echo $breadcrumb;?>      

<script src="<?=JS?>mycustom.js"></script>
<section class="sec-60">
<div class="container">
<div class="row">
<?php echo $leftpanel;?> 
<!-- Sidebar End -->
<div class="col-md-9 col-sm-8 col-xs-12">
<ul class="nav nav-tabs">
    <li class="nav-item"><a href="<?php echo VPATH;?>myfinance/" >Add Fund</a></li>
    <li class="nav-item"><a href="<?php echo VPATH;?>myfinance/milestone" >Milestone</a></li> 
    <li class="nav-item"><a href="<?php echo VPATH;?>myfinance/withdraw" >Withdraw Fund</a></li> 
    <li class="nav-item"><a class="active" href="<?php echo VPATH;?>myfinance/transaction" >Transaction History</a></li> 
    <li class="nav-item"><a href="<?php echo VPATH;?>membership/" >Membership</a></li> 
</ul>
<div class="balance"><b>Balance: </b> <span class="badge badge-border"><?php echo CURRENCY;?><?php echo $balance;?></span></div>
<!--EditProfile Start-->
<div class="table-responsive"> 	 
<table class="table table-dashboard">	
<thead> 	
<tr>
    <th>Transaction For</th>	
    <th>Transaction Amount</th> 	
    <th>Transaction Date</th>
    <th>Transaction Status</th>
</tr>
</thead>
<tbody>
<tr>
<?php 
 if($transaction_count){ 
    foreach($transaction_list as $row){ 
?>
<td>
    <?php echo $row['transaction_for'];?>
</td>    
<td>$ <?php echo $row['amount'];?></td>
<td><?php echo date("d M,Y",  strtotime($row['transction_date']));?></td>    
<td>         

        <?php 
          if($row['status']=="Y"){ 
              echo "Success";
          }
          else{ 
              echo "Faild";
          }
        
        ?>
</td>
<?php    
    }  
    echo $this->pagination->create_links();   
 }
 else{ 
?>
<td colspan="4">No Record Found</td>
       
<?php    
 }

?>   

</tr>
</tbody>
</table> 
</div>
<!--EditProfile End-->

</div>                       

 </div>
 <!-- Left Section End -->
</div>
</section>    
         
<script> 
  function setamt(){ 
    $("#amount").val($("#depositamt_txt").val());
  }
</script>
         <?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
