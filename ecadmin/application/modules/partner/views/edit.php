<section id="content">
  <div class="wrapper">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url()?>"><i class="la la-home"></i> Home</a></li>
        <li class="breadcrumb-item active"><a href="<?= base_url() ?>partner/">Partner Management</a></li>
        <li class="breadcrumb-item active">Edit Partner</a></li>
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
          <h5><i class="la la-edit"></i> Edit partner </h5>
          <a href="#" class="minimize2"></a> </div>        
        <div class="panel-body">
          <form id="validate" action="<?php echo base_url(); ?>partner/edit/<?=$all_data[0]['id']?>" class="form-horizontal" role="form" name="team" method="post" enctype="multipart/form-data">
            <input type="hidden" name="currimg" value="<?php echo $all_data[0]['image']; ?>" />
            <div class="row">
              <label class="col-lg-2 col-md-3 col-form-label" for="required">Partner Name</label>
              <div class="col-lg-10 col-md-9">
                <input type="text" id="required" value="<?php if(isset($all_data[0]['name'])){ echo $all_data[0]['name'];  }?>" name="name" class="required form-control">
                <?php echo form_error('name', '<label class="error" for="required">', '</label>'); ?> </div>
            </div>
            <!-- End .control-group  -->
            
            <div class="row">
              <label class="col-lg-2 col-md-3 col-form-label" for="agree">Add image</label>
              <div class="col-lg-10 col-md-9">
                <?php
                                            if ($all_data[0]['image'] != '') {
                                                ?>
                <img src="<?php echo SITE_URL . "assets/partner_image/" . $all_data[0]['image']; ?>" style="max-height: 75px; max-width: 100px;" />
                <?php }else{ ?>
                <img src="<?php echo SITE_URL . "assets/partner_image/noimg.jpg" ; ?>" style="max-height: 75px; max-width: 100px;" />
                <?php
											
				} ?>
                <div class="custom-file mt-2">
                  <!--<input type="file" class="custom-file-input" id="userfile" name="userfile">
                  <label class="custom-file-label" for="customFile">Choose file</label>-->					<input class="custom-file-input" type="file" onchange="uploadFile(this)" id="image_upload_file" >					<label class="custom-file-label" for="image_upload_file">Choose file</label>					  <div id="uploadError" class="text-red"></div>					  <div class="clearfix"></div>					  <div id="loader" style="display:none;">						<div class="progress">							<div class="progress-bar progress-bar-success" role="progressbar" style="width:0%">							0%							</div>						</div>					  </div>					  <div id="img_upload" style="display: none; width: 110px">						<a href="javaScript:void(0);" id="img_close" style="float: right"><i class="la la-times"></i></a>						<img src="" id="userfile" style="width: 110px"/>						<input type='hidden' name="userfile" id='userfile_id'>					  </div>
                </div>
              </div>
            </div>						<div class="row">              <label class="col-lg-2 col-md-3 col-form-label" for="elastic" style='margin-top: 20px;'>Description</label>              <div class="col-lg-10 col-md-9" style='margin-top: 20px;'>                <textarea class="required form-control elastic" id="textarea2" rows="3" name="description" style="overflow: hidden; word-wrap: break-word; resize: horizontal; height: 100px;"><?php if(isset($all_data[0]['description'])){ echo $all_data[0]['description'];  }?></textarea>              </div>            </div>
            <!-- End .control-group  -->
            
            <div class="row">
              <label class="col-lg-2 col-md-3 col-form-label" for="elastic">URL</label>
              <div class="col-lg-10 col-md-9">
                <textarea class="required form-control elastic" id="textarea1" rows="3" name="url" style="overflow: hidden; word-wrap: break-word; resize: horizontal; height: 76px;"><?php if(isset($all_data[0]['url'])){ echo $all_data[0]['url'];  }?></textarea>
              </div>
            </div>
            <!-- End .control-group  -->
            
            <div class="row">
              <label class="col-lg-2 col-md-3 col-form-label" for="agree">Status</label>
              <div class="col-lg-10 col-md-9">
              	<div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" class="custom-control-input" id="status" name="status" value="Y" checked="checked" <?php if (isset($all_data[0]['status']) && $all_data[0]['status'] == 'Y') {
					echo "checked";
					} ?>>
                  <label class="custom-control-label" for="status">Online</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" class="custom-control-input" id="status_2" name="status" value="N" <?php if (isset($all_data[0]['status']) && $all_data[0]['status'] == 'N') {
					echo "checked";
					} ?>>
                  <label class="custom-control-label" for="status_2">Offline</label>
                </div>              
              </div>
            </div>
            <!-- End .control-group  -->
            <div class="row">
              <div class="col-lg-2 col-md-3">&nbsp;</div>
				<div class="col-lg-10 col-md-9">
                  <input type="submit" name="submit" class="btn btn-primary" value="Add">&nbsp;
                  <button type="button" onclick="redirect_to('<?php echo base_url() . 'partner/'; ?>');" class="btn btn-secondary">Cancel</button>
              </div>
            </div>
            <!-- End .row  -->
            
          </form>
        </div>
        	</div>
      </div>      
    </div>
  </div>
</section>
 <script> function uploadFile(ele){	 var allowed_types = ["image/jpeg", "image/jpg" ,"image/png", "image/gif"];	 var file = $(ele)[0].files[0];	 if(allowed_types.indexOf(file.type) == -1){		 $('#uploadError').html('Only image file allowed');		 return false;	 }else{		 $('#uploadError').html('');	 }	 var fdata = new FormData();	 fdata.append('file', file);	 $('#loader').show();	 $.ajax({		 xhr: function() {			 var xhr = new window.XMLHttpRequest();			 xhr.upload.addEventListener("progress", function(evt) {				 if (evt.lengthComputable) {					 var percentComplete = evt.loaded / evt.total;					 percentComplete = parseInt(percentComplete * 100);					 $('#loader').find('.progress-bar').css('width', percentComplete+'%');					 $('#loader').find('.progress-bar').html(percentComplete+'%');					 if (percentComplete === 100) {						 $('#loader').hide();						 $('#loader').find('.progress-bar').css('width', '0%');						 $('#loader').find('.progress-bar').html('0%');					 }				 }			 }, false);			 return xhr;		 },		 url: '<?php echo base_url('partner/upload_file_ajax')?>',		 type: "POST",		 data: fdata,		 contentType: false,		 processData: false,		 dataType: "json",		 success: function(res) {			 console.log(res);			 if(res.status == 1){				 $('#userfile').attr('src', res.file_url);				 $('#userfile_id').val(res.file_name);				 $('#img_upload').show();			 }else{				 if(res.status == 0 && res.error){					 $('#uploadError').html(res.error);				 }			 }		 }	 }); } $('#img_close').click(function(){	 $('#img_upload').hide();	 $('#userfile').attr('src', '');	 $('#userfile_id').val('');	 $('#image_upload_file').val(''); }); </script>