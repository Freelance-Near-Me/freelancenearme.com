<link rel="stylesheet" href="<?php echo ASSETS;?>plugins/taginput/tokenize2.min.css" type="text/css" />

<script src="<?php echo ASSETS;?>plugins/taginput/tokenize2.min.js" type="text/javascript"></script>

<script>

    $(window).load(function(){

      $("#sticky_panel").sticky({ topSpacing: 75 , bottomSpacing: 485});

    });

</script>



<style>

input.invalid, select.invalid, textarea.invalid{

	border: 1px solid red;

	border-bottom: 2px solid red;

}
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    padding: 8px;
    line-height: 1.42857143;
    vertical-align: top;
    border-top: 1px solid #ddd;
    word-break: initial;
}

.table > tbody > tr > td,.table > tfoot > tr > td {
	border: none;
    border-top: 1px solid #e0e0e0;
}
.table thead > tr > td:last-child, .table thead > tr > th:last-child, .table tbody > tr > td:last-child, .table tbody > tr > th:last-child, .table tfoot > tr > td:last-child, .table tfoot > tr > th:last-child {
    text-align: right;
}
.label {
    display: inline;
    padding: .2em .6em .3em;
    font-size: 75%;
    font-weight: bold;
    line-height: 1;
    color: #fff;
    text-align: center;
    white-space: nowrap;
    vertical-align: baseline;
    border-radius: .25em;
}
.label-success {
    background-color: #5cb85c;
}
.label-warning {
    background-color: #f0ad4e;
}
.label-info {
    background-color: #5bc0de;
}
</style>



<section class="sec">

<div class="container">

	<?php echo $breadcrumb; ?> 	

		<div class="row">



			<aside class="col-sm-8 col-xs-12">

      		<div class="whiteBg shadow_1 p-15">

				

				<form onsubmit="ajaxSubmit(this, event);">

				

				<h4>What work do you require?</h4>



				<div class="form-group">

					<select class="form-control" name="category_id">

						<option value="">Choose category</option>

						<?php if(count($categories) > 0){foreach($categories as $k => $v){ ?>

						<option value="<?php echo $v['cat_id'];?>"><?php echo $v['cat_name'];?></option>

						<?php } } ?>

					</select>

				</div>



				

				<!-- <div class="form-group">

					<select class="form-control">

						<option>Select a job</option>

					</select>

				</div> -->



				<h4>Tell us more about the contest ?</h4>



				<div class="form-group">

				<label>Contest Name: </label>

					<input type="text" name="title" class="form-control" placeholder="What is the contest title ?">

				</div>



				<div class="form-group">

				<label>Enter some skills that relate to the contest: </label>

					<select class="form-control inputtag" name="skills[]" multiple></select>

				</div>



				<div class="form-group">

				<label>Describe your contest in detail: </label>

					<textarea class="form-control" placeholder="Describe your contest here..." rows="3" name="description"></textarea>

				</div>



				<div class="form-group">

					<label>Add File: </label>

                    <div class="uploadButton">

                        <input class="uploadButton-input" type="file" onchange="uploadFiles(this);" accept="image/*, pdf" id="upload" multiple/>

                        <label class="uploadButton-button ripple-effect" for="upload">Upload Files</label>

                        <span class="uploadButton-file-name">Images or documents that might be helpful in describing your job</span>

                    </div>                                                            

				

				<ul class="list-group" id="attachments_list_group">

				  

				</ul>

				

				</div>

				<div class="row">				

					<div class="col-sm-6">

                      <label>What's your budget?</label>

                      <div class="input-group mb-3">

                      <div class="input-group-prepend">

                        <span class="input-group-text"><?php echo CURRENCY; ?></span>

                      </div>				  

                      <input type="text" class="form-control" placeholder="Budget" name="budget">

                    </div>

                    </div>

					<div class="col-sm-6">

                      <label>Run your contest for: </label>

                      <div class="input-group mb-3">

                      <div class="input-group-prepend">

                        <span class="input-group-text">Days</span>

                      </div>				  

                      <input type="text" class="form-control" placeholder="" name="days_run">

                    </div>

                    </div>

                </div>



				<div class="clearfix spacer-10"></div>



				<h4>Get the most from your contest ! (optional) </h4>

				<table class="table">

					<tr>

						<td><div class="checkbox m-0"><input type="checkbox" class="magic-checkbox" name="is_guranteed" id="is_guranteed" value="1" checked /><label for="is_guranteed">&nbsp;</label></div></td>

						<td><span class="label label-success">GURANTEED</span></td>

						<td>Guarntee freelancers that a winner will be chosen and awareded the prize. This will attract better entries from more freelancers. Moneyback guarntee is not applicable if a contest has a guaranteed upgrade.</td>

						<td> <b>FREE </b></td>

					</tr>





					<tr>

						<td><div class="checkbox m-0"><input type="checkbox" class="magic-checkbox" id="is_featured" name="is_featured" value="1"/><label for="is_featured">&nbsp;</label></div></td>

						<td><span class="label label-warning">FEATURED</span></td>

						<td>Attract more freelancers with a prominent placement in our Featured Jobs and Contest's page.</td>

						<td><b><?php echo CURRENCY.'&nbsp;'.CONTEST_FEATURED_PRICE;?>  </b></td>

					</tr>

					

					<tr>

						<td><div class="checkbox m-0"><input type="checkbox" class="magic-checkbox" id="is_sealed" name="is_sealed" value="1"/><label for="is_sealed">&nbsp;</label></div></td>

						<td><span class="label label-info">SEALED</span></td>

						<td>Only you can see individual entries</td>

						<td><b><?php echo CURRENCY.'&nbsp;'.CONTEST_SEALED_PRICE;?>  </b></td>

					</tr>

					



				</table>





				<div class="form-group">

					<button class="btn btn-site">Get Entries Now</button>

				</div>

				

				</form>



			</div>

			</aside>



			<aside class="col-sm-4 col-xs-12">

      		

				<div class="whiteBg shadow_1 p-15" id="sticky_panel">

				<ol class="counter-list">

					<li>Post a contest and put up a prize for work required</li>

					<li>Freelancers complete by submitting hundreds of ideas</li>

					<li>Award your prize to the best entry !</li>

				</ol>

				</div>

			</aside>

		</div>



	</div>

</section>



<script>



	$('.inputtag').tokenize2({

		placeholder: "<?php echo __('postjob_select_a_skill','Select a Skill'); ?>",

		dataSource: function(search, object){

			$.ajax({

				url : '<?php echo base_url('contest/get_skills')?>',

				data: {search: search},

				dataType: 'json',

				success: function(data){

					var $items = [];

					$.each(data, function(k, v){

						$items.push(v);

					});

					object.trigger('tokenize:dropdown:fill', [$items]);

				}

			});

		}

	});

	

	function ajaxSubmit(f, e){

		$('.invalid').removeClass('invalid');

		e.preventDefault();

		var fdata = $(f).serialize();

		$.ajax({

			url : '<?php echo base_url('contest/post_contest_ajax')?>',

			data: fdata,

			dataType: 'json',

			type: 'POST',

			success: function(res){

				if(res.errors){

					for(var i in res.errors){

						i = i.replace('[]', '');

						$('[name="'+i+'"]').addClass('invalid');

						$('#'+i+'Error').html(res.errors[i]);

					}

					

					var offset = $('.invalid:first').offset();

					

					if(offset){

						$('html, body').animate({

							scrollTop: offset.top

						});

					}

					

					

				}else{

					location.href = '<?php echo base_url('contest/contest_detail')?>/'+res.data.contest_id;

				}

			}

		});

	}

	

	function uploadFiles(ele){

		var files = $(ele)[0].files;

		var fdata = new FormData();

		fdata.append('file', files[0]);

		

		var key = Date.now();

		

		var html = '<li class="list-group-item" id="file_'+key+'"><div class="progress"><div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%"><span class="sr-only">0% </span></div></div></li>';

		

		$('#attachments_list_group').html(html);

		

		$.ajax({

			 xhr: function() {

				var xhr = new window.XMLHttpRequest();



				xhr.upload.addEventListener("progress", function(evt) {

				  if (evt.lengthComputable) {

					

					var percentComplete = evt.loaded / evt.total;

					percentComplete = parseInt(percentComplete * 100);

					$('#file_'+key).find('.progress-bar').css('width', percentComplete+'%').attr('aria-valuenow', percentComplete);

					$('#file_'+key).find('.sr-only').html(percentComplete+'%');



				  }

				}, false);



				return xhr;

			},

			url : '<?php echo base_url('contest/upload_attachment')?>',

			data: fdata,

			dataType: 'JSON',

			processData: false,

			contentType: false,

			type: 'POST',

			success: function(res){

				console.log(res);

				if(res.status == 1){

					html = res['data']['org_filename']+'<input type="hidden" name="attachment" value=\''+res['data']['file_str']+'\'/> <a href="javascript:void(0);" onclick="removeAttachment('+key+')" class="pull-right"><i class="zmdi zmdi-delete red-text"></i></a>';

					$('#file_'+key).html(html);

				}else{

					$('#file_'+key).html(res.errors['file']);

				}

			}

		});

		

	}

	

	function removeAttachment(key){

		$('#file_'+key).remove();

	}

	

</script>