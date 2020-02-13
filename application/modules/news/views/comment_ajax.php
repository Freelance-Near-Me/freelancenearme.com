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
        <div class="comment-content"><div class="arrow-comment"></div>
            <div class="comment-by"><?php echo $name;?><span class="date"><?php echo date('d M, Y', strtotime($v['datetime']));?></span>
                <a href="javascript:void(0);" onclick="replyComment(<?php echo $v['comment_id'];?>)" class="reply"><i class="fa fa-reply"></i> Reply</a>
            </div>
            <p><?php echo $v['comment'];?></p>
			<?php if($replies > 0){ ?>
		<a href="javascript:void(0);" onclick="loadReplies('<?php echo $v['comment_id']; ?>', this)">View Replies (<?php echo $replies;?>)</a>
		<?php } ?>
        </div>
			
		<ul class="child"></ul>
		
    </li>
	
	<?php } } ?>