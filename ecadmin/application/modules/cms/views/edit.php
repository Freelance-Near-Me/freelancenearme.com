
<section id="content">
  <div class="wrapper">
  <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url()?>"><i class="la la-home"></i> Home</a></li>  
		<li class="breadcrumb-item"><a href="<?php echo base_url() . 'cms'; ?>">Content List</a></li>
        <li class="breadcrumb-item active"><a>Edit Content</a></li>
      </ol>
    </nav>     
    <div class="container-fluid">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h5><i class="la la-edit"></i> Modify Content</h5>
          <a href="#" class="minimize2"></a> </div>
        <!-- End .panel-heading -->
        
        <div class="panel-body">
          <form id="validate" action="<?php echo base_url(); ?>cms/edit/" class="form-horizontal" role="form" name="cms" method="post">
            <input type="hidden" name="id" value="<?php echo $id; ?>" />
            <div class="row">
              <label class="col-lg-2 col-md-3 col-form-label" for="required">Enter Title</label>
              <div class="col-lg-10 col-md-9">
                <input type="text" id="required" value="<?php echo $cont_title; ?>" name="cont_title" class="required form-control">
                <?php echo form_error('cont_title', '<label class="error" for="required">', '</label>'); ?> </div>
            </div>
            <!-- End .control-group  -->
            <div class="row">
              <label class="col-lg-2 col-md-3 col-form-label" for="url">Enter Page Name</label>
              <div class="col-lg-10 col-md-9">
                <input id="pagename" readonly value="<?php echo $pagename; ?>" type="text" name="pagename" class="required form-control" />
                <?php echo form_error('pagename', '<label class="error" for="required">', '</label>'); ?> </div>
            </div>
            <!-- End .control-group  -->
            <div class="row">
              <label class="col-lg-2 col-md-3 col-form-label" for="digits">Contents</label>
              <div class="col-lg-10 col-md-9">
                <textarea name="contents" id="contents" class="valid form-control" rows="5" cols="40">
                <?php echo html_entity_decode($contents); ?>
                </textarea>
                <?php echo display_ckeditor($ckeditor); ?> </div>
            </div>
            <!-- End .control-group  -->
            
            <div class="row">
              <label class="col-lg-2 col-md-3 col-form-label" for="url">Meta Title</label>
              <div class="col-lg-10 col-md-9">
                <input id="curl" value="<?php echo $meta_title; ?>" type="text" name="meta_title" class="required form-control" />
                <?php echo form_error('meta_title', '<label class="error" for="required">', '</label>'); ?> </div>
            </div>
            <div class="row">
              <label class="col-lg-2 col-md-3 col-form-label" for="url">Meta Keywords</label>
              <div class="col-lg-10 col-md-9">
                <input id="curl" value="<?php echo $meta_keys; ?>" type="text" name="meta_keys" class="required form-control" />
                <?php echo form_error('meta_keys', '<label class="error" for="required">', '</label>'); ?> </div>
            </div>
            <div class="row">
              <label class="col-lg-2 col-md-3 col-form-label" for="digits">Meta Description</label>
              <div class="col-lg-10 col-md-9">
                <textarea class="form-control elastic" id="textarea1" name="meta_desc" rows="3" style="overflow: hidden; word-wrap: break-word; resize: horizontal; height: 100px;"><?php echo $meta_desc ?></textarea>
              </div>
            </div>
            <div class="row">
              <label for="radio" class="col-lg-2 col-md-3 col-form-label">Status</label>
              <div class="col-lg-10 col-md-9">
              	 <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" class="custom-control-input" id="status" name="status" value="Y" checked="checked">
                  <label class="custom-control-label" for="status">Online</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" class="custom-control-input" id="status_2" name="status" value="N" <?php if ($status == 'N') {
                                            echo 'checked';
                                        } ?>>
                  <label class="custom-control-label" for="status_2">Offline</label>
                </div>
              </div>
            </div>
            
            <!-- End .control-group  -->
            <div class="row">
              <div class="col-lg-2 col-md-3">&nbsp;</div>
				<div class="col-lg-10 col-md-9">
                  <button type="submit" class="btn btn-primary">Save</button>&nbsp;
                  <button type="button" onclick="redirect_to('<?php echo base_url() . 'cms'; ?>');" class="btn btn-secondary">Cancel</button>                
              </div>
            </div>
            <!-- End .row  -->
            
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
