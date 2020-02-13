<section id="content">
  <div class="wrapper">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url()?>"><i class="la la-home"></i> Home</a></li>
        <li class="breadcrumb-item active"><a>Site Under Settings</a> </li>
      </ol>
    </nav>
    <div class="container-fluid">
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
      <ul class="nav nav-pills nav-fill mb-3">
        <li class="nav-item"> <a class="nav-link" href="<?= base_url() ?>settings/edit/45">Site Setting</a> </li>
        <li class="nav-item"> <a class="nav-link" href="<?= base_url() ?>settings/account_edit/45">Account Setting</a> </li>
        <li class="nav-item"> <a class="nav-link" href="<?= base_url() ?>settings/transfer_edit/45">Transfer Setting</a> </li>
        <li class="nav-item"> <a class="nav-link active" href="<?= base_url() ?>settings/maintenance_setting/45">Site Under Maintenance</a> </li>
        <li class="nav-item"> <a class="nav-link" href="<?= base_url() ?>settings/email_setting/1">Email Setting</a> </li>
      </ul>
      <div class="panel panel-default">
        <div class="panel-heading">
          <h5><i class="la la-check-square"></i> Modify Site Settings</h5>
          <a href="#" class="minimize2"></a> </div>
        <!-- End .panel-heading -->
        
        <div class="panel-body"> <?php echo validation_errors('<div class=" red alert ">', '</div>'); ?>
          <form id="validate" action="<?php echo base_url(); ?>settings/maintenance_setting/45" class="form-horizontal" enctype="multipart/form-data" role="form" name="settings" method="post">
            <div class="row">
              <label class="col-lg-2 col-md-3 control-label" >Show messege :</label>
              <div class="col-lg-10 col-md-9">
                <input type="text" id="maintaince_heading" value="<?php echo $all_data['maintaince_heading']?>" name="maintaince_heading" class="required form-control">
                <?php echo form_error('maintaince_heading', '<label class="error" >', '</label>'); ?> </div>
            </div>
            <div class="row">
              <label class="col-lg-2 col-md-3 control-label" >Show description :</label>
              <div class="col-lg-10 col-md-9">
                <textarea name="maintaince_description" class="required form-control elastic" rows="5" cols="6" id="contents" style="overflow: hidden; word-wrap: break-word; resize: horizontal; height: 114px;"><?php echo html_entity_decode($all_data['maintaince_description'])?></textarea>
                <?php echo display_ckeditor($ckeditor); ?> <?php echo form_error('maintaince_description', '<label class="error" >', '</label>'); ?> </div>
            </div>
            <div class="row">
              <div class="col-lg-2 col-md-3">&nbsp;</div>
              <div class="col-lg-10 col-md-9">
                <button type="submit" class="btn btn-primary">Save</button>
                &nbsp;
                <button type="button" onclick="redirect_to('<?php echo base_url() . 'settings/edit/45' ?>');" class="btn btn-secondary">Cancel</button>
              </div>
            </div>
            <!-- End .form-group  -->
            
          </form>
        </div>
        <!-- End .panel-body --> 
      </div>
      <!-- End .widget --> 
      
    </div>
    <!-- End .container-fluid  --> 
  </div>
  <!-- End .wrapper  --> 
</section>
