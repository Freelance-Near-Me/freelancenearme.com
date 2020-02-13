<?php
$lang_selected = $this->session->userdata('lang');
if($lang_selected=='arabic'){
	$lang = 'ar';
}else{
	$lang = 'en';
}
?>
<?php $seoUrlWordLimit=50; ?>
<?php /* <div class="bannerAll intro-banner">
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
</div> */ ?>

<section class="sec blogThumb">
  <div class="container">
  <div class="dashboard-headline">
			<?php echo $breadcrumb;?>
   </div>
  
  
	<div class="row">
		<?php
		
		if(count($event) > 0){
		    
			foreach($event as $key=>$val){
			    
				$image = explode('.',$val['image']);
				$image[0] = $image[0].'_thumb';
				$image2 = implode('.',$image);
				$title = $this->db->select('title,description')->from('event_detail')->where(array('event_id'=>$val['event_id'],'lang'=>$lang))->get()->row_array();
			
			if(!empty($val['event_slug'])){
				$link = base_url('blog').'/'.$val['event_slug'];
			}else{
				$link = base_url('blog-details').'/'.$val['event_id'].'-'.$this->auto_model->seofriendly($title['title'],$seoUrlWordLimit);
			}
				
					//echo 'asim111';exit;
		?>
		<div class="col-sm-6 col-md-4">    	
			<div class="card">
			  <div class="card-image"><img src="<?php echo base_url('assets/img/event').'/'.$image2;?>" class="card-img-top" alt="<?php echo $val['event_image_alt_title']?>" title="<?php echo $val['event_image_alt_title']?>"></div>
			  <div class="card-body">
				<h5 class="card-title"><?php echo $title['title']?></h5>
				<p class="card-text"><?php echo (strlen(strip_tags($title['description'])) > 120)? substr(strip_tags($title['description']),0,120).'...' : strip_tags($title['description']); ?></p>
				<a href="<?php echo $link; ?>" class="btn btn-border"><?php echo __('view_more','View more')?></a>
			  </div>
			</div>
		</div>
		<?php
			}
		} else {
			?>
			<div class="col-sm-12 col-md-12">
				<h4><?php echo __('no_blog_available','No Blog Available')?></h4>
			</div>
			<?php
		}
		?>
    </div>
  </div>
  
  <?php echo $links; ?> 
</section>