<script src="<?=JS?>mycustom.js"></script>  
<div class="dashboard-container">
<?php $this->load->view('dashboard/dashboard-left'); ?>
<div class="dashboard-content-container">
    <div class="dashboard-content-inner" >
    <!-- Dashboard Headline -->
	<?php echo $breadcrumb; ?>         
          <ul class="nav nav-tabs">
            <li class="nav-item"><a class="active" href="<?php echo VPATH;?>myfinance/">Add Fund</a></li>
            <?php /*?><li><a href="<?php echo VPATH;?>myfinance/milestone">Milestone</a></li>
			<li><a href="<?php echo VPATH;?>membership/">Membership</a></li><?php */?>
            <li class="nav-item"><a href="<?php echo VPATH;?>myfinance">Withdraw Fund</a></li>
            <li class="nav-item"><a href="<?php echo VPATH;?>myfinance/transaction">Transaction History</a></li>            
          </ul>
            <div class="balance"><span>Balance: </span><?php echo CURRENCY;?> <?php echo $balance;?></div>
            <br />
            <div class="alert alert-success">
            <i class="zmdi zmdi-check-circle"></i> Your payment is successful. Fund was added to your wallet.                       
            </div>
          
          
          <?php 
  
  if(isset($ad_page)){ 
    $type=$this->auto_model->getFeild("type","advartise","","",array("page_name"=>$ad_page,"add_pos"=>"M"));
  if($type=='A') 
  {
   $code=$this->auto_model->getFeild("advertise_code","advartise","","",array("page_name"=>$ad_page,"add_pos"=>"M")); 
  }
  else
  {
   $image=$this->auto_model->getFeild("banner_image","advartise","","",array("page_name"=>$ad_page,"add_pos"=>"M"));
    $url=$this->auto_model->getFeild("banner_url","advartise","","",array("page_name"=>$ad_page,"add_pos"=>"M")); 
  }
        
      if($type=='A'&& $code!=""){ 
?>
          <div class="addbox">
            <?php 
   echo $code;
 ?>
          </div>
          <?php                      
      }
   elseif($type=='B'&& $image!="")
   {
  ?>
          <div class="addbox"> <a href="<?php echo $url;?>" target="_blank"><img src="<?=ASSETS?>ad_image/<?php echo $image;?>" alt="" title="" /></a> </div>
          <?php  
 }
  }

?>
        </div>
        <!-- Left Section End --> 
      </div>
    </div>