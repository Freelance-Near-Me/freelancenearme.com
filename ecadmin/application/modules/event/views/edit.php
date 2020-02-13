<?php $lang = $this->session->userdata('user')->lang; ?><?php $id = $all_data['event_id']; ?><section id="content">
<div class="wrapper"><nav aria-label="breadcrumb">  <ol class="breadcrumb">	<li class="breadcrumb-item"><a href="<?= base_url()?>"><i class="la la-home"></i> Home</a></li>  	<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>event/page">Blog List</a></li>	<li class="breadcrumb-item active"><a>Edit Blog</a></li>  </ol></nav> 

<div class="container-fluid">
    <?php
	if ($this->session->flashdata('succ_msg')) {
		?>
		<div class="alert alert-success">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			<strong><i class="la la-check-circle la-2x"></i> Well done!</strong> <?= $this->session->flashdata('succ_msg') ?>
		</div> 
		<?php
	}
	if ($this->session->flashdata('error_msg')) {
		?>
		<div class="alert alert-error">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			<strong><i class="icon24 i-close-4"></i> Oh snap!</strong> <?= $this->session->flashdata('error_msg') ?>
		</div>
    <?php
}
?>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h5><i class="la la-edit"></i> Modify BLog </h5>
				<a href="#" class="minimize2"></a>
			</div><!-- End .panel-heading -->
		
			<div class="panel-body"><?php echo validation_errors('<div class=" red alert ">', '</div>'); ?>
			<form id="validate" action="<?php echo base_url(); ?>event/edit/<?=$all_data['event_id']?>" class="form-horizontal" role="form" name="event" method="post">
			   <input type="hidden" name="id" value="<?php echo $all_data['event_id']; ?>" />
			   <div class="row">	
				<label class="col-lg-2 col-md-3 col-form-label" for="required1_ar">Blog URL</label>		
				<div class="col-lg-10 col-md-9">	
				<input id="event_slug" value="<?php echo $all_data['event_slug']?>" type="text" name="event_slug" class="required form-control" />	
				<p><small style="color: red">Do not use space and special character.Url should be unique</small></p>
				<?php echo form_error('event_slug', '<label class="error" for="event_slug">', '</label>'); ?>
				</div>				
				</div>
			
				<?php
					$title = $this->db->select('title')->from('event_detail')->where(array('event_id'=>$id,'lang'=>'en'))->get()->row_array();
					?>
					<div class="row">
						<label class="col-lg-2 col-md-3 col-form-label">Title</label>
						<div class="col-lg-10 col-md-9">
						<input class="required form-control" id="title" value="<?php echo !empty($title['title']) ? $title['title'] : ''; ?>" name="title" type="text" />
						</div>
					</div>
					<?php echo form_error('title', '<label class="error" for="title">', '</label>'); ?>
					<?php
						$description = $this->db->select('description')->from('event_detail')->where(array('event_id'=>$id,'lang'=>'en'))->get()->row_array();
						?>
					<div class="row">
						<label class="col-lg-2 col-md-3 col-form-label" for="digits">Description</label>
						<div class="col-lg-10 col-md-9">
							<textarea name="description" id="description" class="valid form-control" rows="5" cols="40"><?php echo html_entity_decode(!empty($description['description']) ? $description['description'] : ''); ?></textarea>
							<?php echo display_ckeditor($ckeditor); ?>
						</div>
					</div>
					<?php if ($all_data['image'] != '') { ?>
					<div class="row">
						<label class="col-md-2 control-label">Current Image</label>
						<div class="col-md-10">
							<img src="<?php echo SITE_URL . "assets/img/event/" . $all_data['image']; ?>" style="max-height: 80px;"/>
							<input type="hidden" value="<?php echo $all_data['image']; ?>" name="blog_image" />
						</div>
					</div>
					<?php } ?>
					<div class="row">
						<label class="col-md-2 control-label" >Choose image</label>
						<div class="col-md-10">
							<div class="custom-file">
								<input type="file" class="custom-file-input" value="" id="image" onchange="uploadFiles(this);">
								<label class="custom-file-label" for="customFile">Choose file</label>
							</div>
							<p style="color: red">Width: 440px, Height: 280px</p>
							<div id="uploaded_files"></div>
						</div>
					</div>
					<div class="row">	
					<label class="col-lg-2 col-md-3 col-form-label" for="required1_en">Image Alt Title</label>		
					<div class="col-lg-10 col-md-9">	
					<input id="event_image_alt_title" value="<?php echo $all_data['event_image_alt_title']?>" type="text" name="event_image_alt_title" class=" form-control" />	
					</div>				
					</div>
					<div class="row">
						<label class="col-lg-2 col-md-3 col-form-label" for="required1">Meta Title</label>
						<div class="col-lg-10 col-md-9">
							<input id="required1" value="<?php echo $all_data['meta_title']; ?>" type="text" name="meta_title" class="required form-control" />
							<?php echo form_error('meta_title', '<label class="error" for="required1">', '</label>'); ?>
						</div>
					</div>
					<div class="row">
						<label class="col-lg-2 col-md-3 col-form-label" for="required2">Meta Keywords</label>
						<div class="col-lg-10 col-md-9">
							<input id="required2" value="<?php echo $all_data['meta_keys']; ?>" type="text" name="meta_keys" class="required form-control" />
							<?php echo form_error('meta_keys', '<label class="error" for="required2">', '</label>'); ?>
						</div>
					</div>
					<div class="row">
						<label class="col-lg-2 col-md-3 col-form-label" for="required3">Meta Description</label>
						<div class="col-lg-10 col-md-9">
							<textarea class="form-control elastic required" id="required3" name="meta_desc" rows="3" style="overflow: hidden; word-wrap: break-word; resize: horizontal; height: 100px;"><?php echo $all_data['meta_desc'] ?></textarea>
							<?php echo form_error('meta_keys', '<label class="error" for="required2">', '</label>'); ?>
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
								<input type="radio" class="custom-control-input" id="status_2" name="status" value="N" <?php if ($all_data['status'] == 'N') {													echo 'checked';												} ?>>
								<label class="custom-control-label" for="status_2">Offline</label>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-2 col-md-3">&nbsp;</div>
						<div class="col-lg-10 col-md-9">
							<button type="submit" class="btn btn-primary">Save</button>
							&nbsp;
							<button type="button" onclick="redirect_to('<?php echo base_url() . 'event/page'; ?>');" class="btn btn-secondary">Cancel</button>
						</div>
					</div>
				</form>
			</div><!-- End .panel-body -->
		</div><!-- End .widget -->
	
</div> <!-- End .container-fluid  -->
</div> <!-- End .wrapper  -->
</section>
<script>
function uploadFiles(ele){
	var files = ele.files;
	if(files.length > 0){
		for(i=0; i < files.length; i++){
			uploadOne(files[i] , i);
		}
	}
	$('#file_chooser').html('<input type="file" name="file[]" multiple="" style="position: absolute; cursor: pointer; top: 0px; width: 66px; height: 28px; left: 0px; z-index: 100; opacity: 0;" onchange="uploadFiles(this);">');
}
function uploadOne(file , ind){
	var formdata = new FormData();
	formdata.append('file', file);
	var file_name = file.name;
	var u_key = new Date().getTime()+'_'+ind;
	var html2 = ' <div class="uploaded_wrapper" id="file_'+u_key+'"> <div class="row"><div class="col-sm-6" id="file_name_preview">'+file_name+'</div><div class="col-sm-6"><div id="progress_'+u_key+'"><div class="progress"><div class="progress-bar" role="progressbar" id="progress_bar_'+u_key+'" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:0%;"> 0 % </div></div></div></div></div></div>';
	$('#uploaded_files').html(html2);
	$.ajax({
		xhr: function() {
			var xhr = new window.XMLHttpRequest();
			xhr.upload.addEventListener("progress", function(evt) {
				if (evt.lengthComputable) {
					var percentComplete = evt.loaded / evt.total;
					percentComplete = parseInt(percentComplete * 100);
					$('#progress_bar_'+u_key).css("width" , percentComplete + '%');
					$('#progress_bar_'+u_key).html(percentComplete + '%');
				}
			}, false);
			return xhr;
		},
		url : '<?php echo base_url('event/upload_file2')?>',
		type: 'POST',
		data : formdata,
		dataType: 'json',
		contentType: false,
		processData: false,
		success: function(res){
			console.log(res);
			if(res['result'] == 1){
				var file_obj = {
					file_name:  res['file_name'],
					org_file_name:  res['org_file_name']
				}
				var file_name = res['file_name'];
				var json_string = JSON.stringify(file_obj);
				var html = '<input type="hidden" name="uploaded_files" value=\''+json_string+'\'/><input type="hidden" name="blog_image" value=\''+file_name+'\'/>';
				$('#file_'+u_key).append(html);
				$('#file_'+u_key+' #file_name_preview').html('<img src="<?php echo SITE_URL.'assets/img/event/';?>'+file_name+'" style="width:80px">');
			}else{
				var html = '<p style="color:red">'+res['error']+'</p>';
				$('#progress_'+u_key).html(html + ' <a href="javascript:void(0)" class="pull-right red-text" onclick="removeFile(\''+u_key+'\')"><i class="icon-material-outline-delete fa-lg"></i></a>');
			}
		}
	});
}
</script>