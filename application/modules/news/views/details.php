<script type='text/javascript' src='//platform-api.sharethis.com/js/sharethis.js#property=5c5855dd83748d0011314d1d&product=inline-share-buttons' async='async'></script>
<?php
$lang_selected = $this->session->userdata('lang');
if($lang_selected=='arabic'){
	$lang = 'ar';
}else{
	$lang = 'en';
}
?>
<?php
/*
?>
<div class="bannerAll intro-banner">
  <?php if(count($banner) > 0){

		 foreach($banner as $key =>$val){ ?>
			<div class="background-image-container" style="background-image:url(<?php echo ASSETS;?>banner_image/<?php echo $val['image']?>)"></div>
           <?php 
		}//for
	}//if
  ?>

  <div class="container">
    <?php if(count($banner) > 0){
		 foreach($banner as $key =>$val){
			 $title = $this->db->select('title,description')->from('banner_detail')->where(array('banner_id'=>$val['id'],'lang'=>$lang))->get()->row_array();
	?>
    <!-- Intro Headline -->
    <div class="banner-headline">
		<h3> <strong><?php echo $title['title']?></strong> </h3>
		<h4><?php echo $title['description']?></h4>
    </div>
    <?php
		}//for
	}//if
	?>
  </div>
</div>
<?php
*/
?>

<section class="sec blogDetail">
  <div class="container">
    <div class="dashboard-headline"> <?php echo $breadcrumb;?> </div>
    <div class="card">
      <div class="card-image"><img src="<?php echo base_url('assets/img/event').'/'.$event['image'];?>" class="card-img-top"  alt="<?php echo $event['event_image_alt_title']?>" title="<?php echo $event['event_image_alt_title']?>"></div>
      <div class="card-body">
        <?php
			$title = $this->db->select('title,description')->from('event_detail')->where(array('event_id'=>$event['event_id'],'lang'=>$lang))->get()->row_array();
			?>
        <?php /*
            <ul class="social-links header-social-links float-right">
             <li> <a href="https://www.facebook.com/" target="_blank" data-tippy-placement="bottom" data-tippy-theme="light" data-tippy="" data-original-title="Facebook"> <i class="icon-brand-facebook-f"></i> </a> </li>
            <li> <a href="https://twitter.com/" target="_blank" data-tippy-placement="bottom" data-tippy-theme="light" data-tippy="" data-original-title="Twitter"> <i class="icon-brand-twitter"></i> </a> </li>
            <li> <a href="http://www.linkedin.com/" target="_blank" data-tippy-placement="bottom" data-tippy-theme="light" data-tippy="" data-original-title="LinkedIn"> <i class="icon-brand-linkedin"></i> </a> </li>
          </ul>
          */ ?>
        <div class="sharethis-inline-share-buttons pull-right"></div>
        <h3 class="card-title" style='display: inline-block'><?php echo $title['title']?></h3>
        - <?php echo date('F d, Y',strtotime($event['created']));?> <?php echo $title['description']?> </div>
    </div>
    <div class="spacer-30"></div>
       <?php /* ?>
    <!-- Comments -->
    <div class="comments hide">
      <h3><?php echo __('comments','Comments')?> <span class="comments-amount" data-count="<?php echo count($comments); ?>">(<?php echo count($comments); ?>)</span></h3>
      <ul id="comment_list">
        <?php if($comments){foreach($comments as $k => $v){ 
	$user_logo = IMAGE.'user.png';
	if($v['logo']){
		$user_logo = base_url('assets/uploaded/'.$v['logo']);
	}
	if($v['user_id'] > 0){
		$name = $v['fname'].' '.$v['lname'];
	}else{
		$name = $v['name'];
	}
	$replies = $this->db->where('parent_id', $v['comment_id'])->count_all_results('comments');
	?>
        <li id="comment_row_<?php echo $v['comment_id'];?>">
          <div class="avatar"><img src="<?php echo $user_logo;?>" alt=""> </div>
          <div class="comment-content">
            <div class="arrow-comment"></div>
            <div class="comment-by"><?php echo $name;?><span class="date"><?php echo date('d M, Y', strtotime($v['datetime']));?></span> <a href="javascript:void(0);" onclick="replyComment(<?php echo $v['comment_id'];?>)" class="reply"><i class="fa fa-reply"></i> <?php echo __('reply','Reply')?></a> </div>
            <p><?php echo $v['comment'];?></p>
            <?php if($replies > 0){ ?>
            <a href="javascript:void(0);" onclick="loadReplies('<?php echo $v['comment_id']; ?>', this)"><?php echo __('news_view_replies','View Replies')?> (<?php echo $replies;?>)</a>
            <?php } ?>
          </div>
          <ul class="child">
          </ul>
        </li>
        <?php } } ?>
        
       
      </ul>
    </div>
    <!-- Comments / End -->
    <div class="spacer-20"></div>
    <!-- Leava a Comment -->
   
    <h3><?php echo __('add_comment','Add Comment')?></h3>
    
    <!-- Form -->
    <form method="post" class="form-horizontal" id="commentForm">
      <div>
        <?php if(!$this->session->userdata('user')){ ?>
        <div class="row">
          <div class="col-sm-6">
            <input type="text" class="form-control input-lg" name="name" id="namecomment" placeholder="<?php echo __('name','Name')?>" required/>
          </div>
          <div class="col-sm-6">
            <input type="text" class="form-control input-lg" name="email" id="emailaddress" placeholder="<?php echo __('email_address','Email Address')?>" required/>
          </div>
        </div>
        <?php } ?>
        <div class="form-group">
          <div class="col-xs-12">
            <textarea class="form-control input-lg" name="comment" cols="30" rows="5" placeholder="<?php echo __('comment','Comment')?>"></textarea>
          </div>
        </div>
        
        <!-- Button -->
        <button class="btn btn-site btn-lg" type="submit"><?php echo __('add_comment','Add Comment')?> <i class="icon-material-outline-arrow-right-alt"></i></button>
      </div>
    </form>
    
    <!-- Leava a Comment / End --> 
      <?php */ ?>
  </div>
</section>

<!-- Modal -->
<div id="replyModal" class="modal fade" role="dialog">
  <div class="modal-dialog"> 
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" onclick="$('#replyModal').modal('hide');">&times;</button>
        <h4 class="modal-title"><?php echo __('reply','Reply')?></h4>
      </div>
      <div class="modal-body">
        <form method="post" class="form-horizontal" id="commentReplyForm">
        </form>
      </div>
    </div>
  </div>
</div>
<script id="comment_form_temp" type="text/template">
<div>
	<?php if(!$this->session->userdata('user')){ ?>
	<div class="form-group">
		<div class="col-sm-6">
			<input type="text" class="form-control input-lg" name="name" id="namecomment" placeholder="<?php echo __('name','Name')?>" required/>
		</div>
		<div class="col-sm-6">
			<input type="text" class="form-control input-lg" name="email" id="emailaddress" placeholder="<?php echo __('email_address','Email Address')?>" required/>
		</div>
	</div>
	<?php } ?>
    <div class="form-group">
		<div class="col-xs-12">
	        <textarea class="form-control input-lg" name="comment" cols="30" rows="5" placeholder="<?php echo __('comment','Comment')?>"></textarea>
	    </div>
    </div>
	
	<!-- Button -->
<button class="btn btn-site btn-lg" type="submit"><?php echo __('add_comment','Add Comment')?> <i class="icon-material-outline-arrow-right-alt"></i></button>
</div>
</script> 
<script id="comment_row_temp" type="text/template">
<li id="comment_row_{COMMENT_ID}">
	<div class="avatar"><img src="{USER_LOGO}" alt=""> </div>
	<div class="comment-content"><div class="arrow-comment"></div>
		<div class="comment-by">{NAME}<span class="date">{DATE}</span>
			<a href="javascript:void(0)" class="reply" onclick="replyComment({COMMENT_ID})"><i class="fa fa-reply"></i> <?php echo __('reply','Reply')?></a>
		</div>
		<p>{COMMENT}</p>
	</div>
	<ul class="child"></ul>
</li>
</script> 
<script>

$('#commentForm').submit(function(e){
	e.preventDefault();
	$('#commentForm').find('button').text('Checking..');
	$('#commentForm').find('button').attr('disabled', 'disabled');
	var name = $(this).find('[name="name"]').val();
	var email = $(this).find('[name="email"]').val();
	var comment = $(this).find('[name="comment"]').val();
	var container = $('#comment_list');
	postComment(name, email, comment, container);
});

$('#commentReplyForm').submit(function(e){
	e.preventDefault();
	$('#commentReplyForm').find('button').text('Checking..');
	$('#commentReplyForm').find('button').attr('disabled', 'disabled');
	var frm_data = $(this).serialize();
	var parent_id = $(this).find('[name="parent_id"]').val();
	var container = $('#comment_row_'+parent_id + ' > .child');
	postReplyComment(frm_data, container, parent_id);
});

function replyComment(parent_id){
	$('#replyModal').modal('show');
	$('#replyModal').find('#commentReplyForm').html($('#comment_form_temp').html());
	$('#replyModal').find('#commentReplyForm').prepend('<input type="hidden" name="parent_id" value="'+parent_id+'"/>');
}

function postReplyComment(data, container, parent_id){
	$('#commentReplyForm').find('input,textarea').removeClass('invalid');
	$.ajax({
		url : '<?php echo base_url('news/post_comment/'.$blog_id)?>',
		data: data,
		type: 'POST',
		dataType: 'JSON',
		success: function(res){
			if(res.errors){
				for(var i in res.errors){
					$('#commentReplyForm').find('[name="'+i+'"]').addClass('invalid');
				}
				$('#commentReplyForm').find('button').removeAttr('disabled');
				$('#commentReplyForm').find('button').text('Add Comment');
			}else{
				var guest_logo = '<?php echo IMAGE;?>user.png';
				var comment_row = res.data.comment;
				comment_html = $('#comment_row_temp').html();
				if(comment_row.user_logo){
					comment_html = comment_html.replace(/{USER_LOGO}/g, comment_row.user_logo);
				}else{
					comment_html = comment_html.replace(/{USER_LOGO}/g, guest_logo);
				}
				
				if(comment_row.fname){
					comment_html = comment_html.replace(/{NAME}/g, comment_row.fname+' '+comment_row.lname);
				}else{
					comment_html = comment_html.replace(/{NAME}/g, comment_row.name);
				}
				comment_html = comment_html.replace(/{DATE}/g, comment_row.display_date);
				comment_html = comment_html.replace(/{COMMENT}/g, comment_row.comment);
				comment_html = comment_html.replace(/{COMMENT_ID}/g, comment_row.comment_id);
				
				$(container).append(comment_html);
				
				$('#commentReplyForm').html($('#comment_form_temp').html());
				$('#commentReplyForm').prepend('<input type="hidden" name="parent_id" value="'+parent_id+'"/>');
				
				/* var comment_count = parseInt($('.comments-amount').data('count'));
				comment_count += 1;
				
				$('.comments-amount').html('('+comment_count+')');
				$('.comments-amount').data('count', comment_count); */
				
				$('#replyModal').modal('hide');
				
			}
		}
	});
}

function postComment(name, email, comment, container){
	$('#commentForm').find('input,textarea').removeClass('invalid');
	$.ajax({
		url : '<?php echo base_url('news/post_comment/'.$blog_id)?>',
		data: {name: name, email: email, comment: comment},
		type: 'POST',
		dataType: 'JSON',
		success: function(res){
			if(res.errors){
				for(var i in res.errors){
					$('#commentForm').find('[name="'+i+'"]').addClass('invalid');
				}
				$('#commentForm').find('button').removeAttr('disabled');
				$('#commentForm').find('button').text('Add Comment');
			}else{
				var guest_logo = '<?php echo IMAGE;?>user.png';
				var comment_row = res.data.comment;
				comment_html = $('#comment_row_temp').html();
				if(comment_row.user_logo){
					comment_html = comment_html.replace(/{USER_LOGO}/g, comment_row.user_logo);
				}else{
					comment_html = comment_html.replace(/{USER_LOGO}/g, guest_logo);
				}
				
				if(comment_row.fname){
					comment_html = comment_html.replace(/{NAME}/g, comment_row.fname+' '+comment_row.lname);
				}else{
					comment_html = comment_html.replace(/{NAME}/g, comment_row.name);
				}
				comment_html = comment_html.replace(/{DATE}/g, comment_row.display_date);
				comment_html = comment_html.replace(/{COMMENT}/g, comment_row.comment);
				comment_html = comment_html.replace(/{COMMENT_ID}/g, comment_row.comment_id);
				
				$(container).append(comment_html);
				
				$('#commentForm').html($('#comment_form_temp').html());
				
				var comment_count = parseInt($('.comments-amount').data('count'));
				comment_count += 1;
				
				$('.comments-amount').html('('+comment_count+')');
				$('.comments-amount').data('count', comment_count);
				
				
			}
		}
	});
}

function loadReplies(comment_id='', ele){
	$.get('<?php echo base_url('news/get_comment_ajax')?>/'+comment_id+'?blog_id=<?php echo $blog_id;?>', function(res){
		$('#comment_row_'+comment_id+' > .child').html(res);
		$(ele).hide();
	});
}

</script> 
