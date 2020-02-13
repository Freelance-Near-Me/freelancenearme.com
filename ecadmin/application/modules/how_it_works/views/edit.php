<section id="content">
  <div class="wrapper">    
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url()?>"><i class="la la-home"></i> Home</a></li>   
        <li class="breadcrumb-item"><a href="<?= base_url() ?>how_it_works/">How it Works Management</a></li>     
        <li class="breadcrumb-item active"><a>Edit How it Works</a></li>
      </ol>
    </nav> 
    <div class="container-fluid">
      <?php
            $id = $this->uri->segment(3);
            ?>
      <?php
    if ($this->session->flashdata('succ_msg')) {
        ?>
      <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong><i class="la la-check-circle la-2x"></i> Well done!</strong>
        <?= $this->session->flashdata('succ_msg') ?>
      </div>
      <?php
    }
    if ($this->session->flashdata('error_msg')) {
        ?>
      <div class="alert alert-error">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong><i class="icon24 i-close-4"></i> Oh snap!</strong>
        <?= $this->session->flashdata('error_msg') ?>
      </div>
      <?php
}
?>
      <div class="panel panel-default">
        <div class="panel-heading">          
          <h5><i class="la la-edit"></i> Edit How it Works </h5>
          <a href="#" class="minimize2"></a> </div>        
        <div class="panel-body">
          <form id="validate" action="<?php echo base_url(); ?>how_it_works/edit/<?=$id?>" class="form-horizontal" role="form" name="team" method="post" enctype="multipart/form-data">
				<div class="row">
                    <label class="col-form-label col-sm-2">Title</label>
					<div class="col-sm-10">
						<input type="text" value="<?php if(isset($all_data[0]['title'])){ echo $all_data[0]['title'];  }?>" name="title" class="form-control">
					</div>
                </div>
            <!-- End .control-group  -->
            
            <div class="row">
              <label class="col-form-label col-sm-2" for="elastic">Description</label>
				<div class="col-sm-10">
					<textarea class="required form-control elastic" id="textarea1" rows="3" name="description" style="overflow: hidden; word-wrap: break-word; resize: horizontal; height: 76px;"><?php if(isset($all_data[0]['description'])){ echo $all_data[0]['description'];  }?></textarea>
				</div>
            </div>
            <?php if ($all_data[0]['site_logo'] != '') { ?>
            <div class="row">
              <label class="col-lg-2 col-md-3 col-form-label" for="required">Current Background Image</label>
              <div class="col-lg-10 col-md-9"> <img src="<?php echo SITE_URL . "assets/images/" . $all_data[0]['site_logo']; ?>"  style="max-height: 50px;"/>
                <input type="hidden" value="<?php echo $all_data[0]['site_logo']; ?>" name="site_logo" />
              </div>
            </div>
            <?php } ?>
			
			<div class="row">
              <label class="col-lg-2 col-md-3 col-form-label" for="required">Category Background Image (150px X 150px)</label>
				<div class="col-lg-10 col-md-9">
                	<div style="position:relative">
                  <input type="file" class="custom-file-input" value="" id="site_logo" name="site_logo">
                  <label class="custom-file-label" for="customFile">Choose file</label>
                  </div>
                </div>
            </div>
			
			<div class="row">
                <label class="col-form-label col-sm-2">Icon Class Name</label>
                <div class="col-sm-10">
                    <input type="text" value="<?php if(isset($all_data[0]['icon_class'])){ echo $all_data[0]['icon_class'];  }?>" name="icon_class" class="form-control">
                </div>
            </div>
            
            <div class="form-group">
              <label class="col-form-label" for="agree">Status</label><br />
              <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" class="custom-control-input" id="status" name="status" value="Y" checked="checked" <?php if (isset($all_data[0]['status']) && $all_data[0]['status'] == 'Y') {	echo "checked";	} ?>>
                  <label class="custom-control-label" for="status">Online</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" class="custom-control-input" id="status_2" name="status" value="N" <?php if (isset($all_data[0]['status']) && $all_data[0]['status'] == 'N') {	echo "checked";	} ?>>
                  <label class="custom-control-label" for="status_2">Offline</label>
                </div>                              
            </div>
            
            <input type="submit" name="submit" class="btn btn-primary" value="Save">&nbsp;
            <button type="button" onclick="redirect_to('<?php echo base_url() . 'how_it_works/'; ?>');" class="btn btn-secondary">Cancel</button>
            
          </form>
        </div>
      </div>
    </div>
    <!-- End .container-fluid  --> 
  </div>
  <!-- End .wrapper  --> 
</section>
