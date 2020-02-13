<!--<script>
    $(window).load(function(){
      $("#sticky_panel").sticky({ topSpacing: 75 , bottomSpacing: 485});
    });
</script>-->

<div class="dashboard-container">
<?php $this->load->view('dashboard/dashboard-left'); ?>
<div class="dashboard-content-container">
    <div class="dashboard-content-inner">
    <!-- Dashboard Headline -->
	<?php echo $breadcrumb; ?>
    
	<div class="row">
    <aside class="col-md-9 col-xs-12">
    
    <!-- Nav tabs -->
    <?php if($user_type == 'freelancer'){ $this->load->view('freelancer_tab'); }?>
    <?php if($user_type == 'employer'){ $this->load->view('employer_tab'); } ?>
    
    <!-- Tab panes -->
    <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="overview">
        <h4>Screen Shots <span class="port_time"><?php echo date('d F, Y',strtotime($screenshot_date));?></span></h4>
        <div class="row-10">
        <ul id="lightgallery" class="lightgallery">
            <?php 
            foreach($tracker_details as $key=>$val){
            $image_name=$pid."_".$val['id'].".jpg";
            ?>
             
            <li class="col-xs-6 col-sm-4 col-md-3" data-src="<?php echo base_url();?>time_tracker/mediafile/<?php echo $image_name;?>">
            <div>
            <h5><?php echo date('d F, Y h:i:s',strtotime($val['project_work_snap_time']));?></h5>
            <a href="javascript:void(0)"><img src="<?php echo base_url();?>time_tracker/mediafile/<?php echo $image_name;?>" alt="<?php echo date('d F, Y h:i:s',strtotime($val['project_work_snap_time']));?>" class="img-responsive" /></a>
            </div>
            </li>                                   		                           
            <?php	
            }
            ?>                
    </ul>
    </div>
    </div>
    <?php echo "<div class='pagin'>".$links."</div>"; ?>
    
    </div>
    </aside>
    <aside class="col-md-3 col-xs-12">
        <?php $this->load->view('right-section'); ?>
    </aside>
</div>
	</div>
</div>
</div>

<link rel="stylesheet" href="<?php echo ASSETS;?>plugins/lightbox/lightgallery.min.css"/>

<script src="<?php echo ASSETS;?>plugins/lightbox/lightgallery-all.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $("#lightgallery").lightGallery(); 
    });
</script>