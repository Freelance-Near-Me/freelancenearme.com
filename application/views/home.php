<link href="<?=ASSETS?>plugins/testimonial/slick.min.css" rel="stylesheet" type="text/css">
<link href="<?php echo ASSETS?>css/bootstrap-tagsinput.css" rel="stylesheet" type="text/css">
<?php
$page_skill=$this->auto_model->getFeild('skills','pagesetup','id','1');
$page_testimonial=$this->auto_model->getFeild('testimonial','pagesetup','id','1');
$page_cms=$this->auto_model->getFeild('cms','pagesetup','id','1');
$page_counting=$this->auto_model->getFeild('counting','pagesetup','id','1');
$cms_sec1=$this->auto_model->getalldata('','cms','id','1');
$cms_sec2=$this->auto_model->getalldata('','cms','id','2');
$cms_sec3=$this->auto_model->getalldata('','cms','id','3');

$lang = $this->session->userdata('lang');

?>
<?php 
 $user = $this->session->userdata('user');
 if(!empty($user)){
 $user_id=$user[0]->user_id;
 }
?>
<?php /* if(count($banner) > 0){ foreach($banner as $key =>$val){ ?>
<div class="intro-banner banner">
	<div class="container">
		<!-- Intro Headline -->
        <div class="banner-headline">
			<h1><strong><?php echo $val['title']; ?></strong></h1>							
            <?php // echo $val['description']; ?>
			<?php if(!empty($user_id)){ ?>
            <a href="<?=VPATH?>postjob" class="btn btn-lg btn-gradient">Click Here</a><span class="hidden-xs">&nbsp;&nbsp;</span>
            <?php }else{ ?>
            <a href="<?php echo base_url('signup?type=E')?>" class="btn btn-lg btn-gradient">Hire Freelancer</a><span class="hidden-xs">&nbsp;&nbsp;</span>
            <?php } ?>
            <?php if(empty($user_id)){ ?>
            <a href="<?php echo base_url('signup?type=F');?>" class="btn btn-lg btn-gradient">Apply As Freelancer</a>
			<?php } ?>
        </div>							
	</div>

<div class="background-image-container" style="background-image: url('<?php echo ASSETS.'banner_image/'.$val['image'];?>')"></div>
    
</div>
<?php }} */?>

<!-- Banner -->
<div id="carouselExampleCaptions" class="carousel slide banner" data-ride="carousel">
    <ol class="carousel-indicators">
    	<?php if(count($banner) > 0){ foreach($banner as $key =>$val){  ?>
      <li data-target="#carouselExampleCaptions" data-slide-to="<?php echo $key;?>" class="<?php echo $key == 0 ? 'active' : '';?>"></li>
      <?php } } ?>
    </ol>
    <div class="carousel-inner">
    	<?php if(count($banner) > 0){ foreach($banner as $key =>$val){  ?>
       
      <div class="carousel-item <?php echo $key == 0 ? 'active' : '';?>">
      <div class="overlay"></div>
        <img src="<?php echo ASSETS;?>banner_image/<?php echo $val['image']; ?>" class="d-block w-100" alt="...">
        
        <div class="carousel-caption d-none d-md-block">
        <div class="container">
        	<div class="banner-headline margin-bottom-50">
            <h1><?php echo $val['title']; ?></h1>
			<!--<h4><?php // echo $val['description']; ?></h4>-->
            </div>
            <?php if(!empty($user_id)){ ?>
            <a href="<?=VPATH?>postjob" class="btn btn-lg btn-gradient">Click Here</a><span class="hidden-xs">&nbsp;&nbsp;</span>
            <?php }else{ ?>
            <a href="<?php echo base_url('signup?type=E')?>" class="btn btn-lg btn-gradient">Hire Freelancer</a><span class="hidden-xs">&nbsp;&nbsp;</span>
            <?php } ?>
            <?php if(empty($user_id)){ ?>
            <a href="<?php echo base_url('signup?type=F');?>" class="btn btn-lg btn-gradient">Apply As Freelancer</a>
			<?php } ?>
        </div>
        </div>
      </div>
       <?php } } ?>
    </div>
    
    <!-- Search Bar -->	
    
  </div>
<!-- Banner End -->

<!-- Category Boxes -->
<div class="sec section gray">
	<div class="container">
		<div class="section-headline centered margin-bottom-25">
            <h3>Popular job categories</h3>
        </div>
        <div class="row">

        <?php
			if($catagories>0){
				foreach($catagories as $key => $val){
					$count_cat = $count_project[$val['id']];
			?>
            <div class="col-lg-4 col-md-6">
                <div class="services-block-three">
                    <a href="<?php echo base_url('findjob/browse').'/'.$this->auto_model->getcleanurl($val['skill_name']).'/'.$val['id']?>">
                        <div class="margin-bottom-15">
                            <i class="<?php echo $val['icon_class']?>"></i>
                            
                        </div>                        
                        <h4><?php echo $val['skill_name']?> (<?php echo $count_cat?>)</h4>
                        <p style='height: 75px;'><?php echo $val['description']?></p>
                    </a>
                </div>
            </div>
            
			<?php
				}
			}
			?>
        
        <!-- end -->
    </div>
		<!-- Category Boxes Container -->        
        <div class="text-center margin-top-30"><a href="<?php echo base_url('findjob')?>" class="btn btn-gradient">See All Categories</a></div>
	</div>
</div>
<!-- Category Boxes End -->
<!-- How It Works? -->
<div class="section padding-top-65 padding-bottom-65">
	<div class="container">
    	<!-- Section Headline -->
        <div class="section-headline centered margin-bottom-35">
            <h3><?php echo __('home_how_it_works','How it works'); ?></h3>
        </div>
		<div class="row">
		<?php
		$how_it_works = $this->db->select('*')->from('how_it_works')->where('status','Y')->get()->result_array();
		$i=1;
		//$c_how_it_works = count($how_it_works);
		foreach($how_it_works as $hkey=>$hval){
		?>
			<div class="col-lg-3 col-sm-6">
				<!-- Icon Box -->
				<div class="icon-box">
					<!-- Icon -->
					<div class="icon-box-circle">
						<div class="icon-box-circle-inner">
							<!--<i class="<?php echo $hval['icon_class'];?>"></i>-->
							<img src="<?php echo IMAGE.$hval['site_logo'];?>" alt="" />
						</div>
					</div>					
					<p><?php echo $hval['description'];?></p>					
				</div>
			</div>
		<?php
		$i++;
		}
		?>		
		</div>
	</div>
</div>
<!-- How It Works? End -->

<!-- Highest Rated Freelancers -->
<div class="section gray padding-top-65 padding-bottom-70 ourTeam">
  <?php
$this->load->model('findtalents/findtalents_model');
$this->load->model('dashboard/dashboard_model');
$data['srch_param'] = array();
$data['limit'] = 0;
$data['offset']= 3;
$our_teams = $this->findtalents_model->list_freelancer($data['srch_param'] , $data['limit'] , $data['offset']);
/* $our_teams = $this->db->select('user_id,fname,lname,logo,slogan,country,avg(r.average) as average_rating,hourly_rate')->from('user u')->join('review_new r' , "r.review_to_user=u.user_id" , "LEFT")->where(array('status' => 'Y', 'account_type' => 'F'))->limit(4)->order_by("user_id", "RANDOM")->get()->result_array(); */
/* get_print($our_teams); */
?>
	<div class="container">		
            <!-- Section Headline -->
            <div class="section-headline centered margin-bottom-25">
                <h3>Invite freelancers to work on your projects</h3>                
            </div>

            <div class=" freelancers-container freelancers-grid-layout">
			<?php if(count($our_teams) > 0){foreach($our_teams as $k => $v){ 
			$logo = '';
            if($v['logo']!=''){
                
                if(file_exists('assets/uploaded/cropped_'.$v['logo'])){
                    $logo = 'uploaded/cropped_'.$v['logo'];
                }else{
                    $logo = 'uploaded/'.$v['logo'];
                }
            }else{
                $logo = 'images/user.png';
            }
            ?>
                <!--Freelancer -->
                <div class="freelancer">

                    <!-- Overview -->
                    <div class="freelancer-overview">
                    	<!-- Avatar -->
                        
                        <div class="freelancer-overview-inner">
                            <div class="freelancer-avatar">
                            <div class="verified-badge"></div>
                            <?php if(!empty($v['country'])){ ?>
                            <a href="<?php echo base_url('clientdetails/showdetails/'.$v['user_id']); ?>"> <img src="<?php echo ASSETS.$logo;?>" alt="" title="" /></a>                                 
                            <?php } ?>                                
                        </div>
                            <!-- Name -->
                            <div class="freelancer-name">
                            	<h4>
									<a href="<?php echo base_url('clientdetails/showdetails/'.$v['user_id']); ?>"><?php echo $v['fname'].' '.$v['lname'];?>
									<img class="flag" src="<?php echo IMAGE;?>flags/<?php echo strtolower(getField('code2', 'country', 'Code',$v['country'])); ?>.svg" alt="" title="<?php echo getField('Name', 'country', 'Code',$v['country']); ?>" data-tippy-placement="top">
									</a>
								</h4>                                
                                <!--<span><?php echo $v['slogan'];?></span>-->
                            </div>

                            <!-- Rating -->
							<?php
							$avg_rating=0;
							if($v['rating'][0]['num']>0){
								$avg_rating=round($v['rating'][0]['avg']/$v['rating'][0]['num'],2);
							}
							?>
                            <div class="freelancer-rating">
                                <div class="star-rating" data-rating="<?php echo round($avg_rating, 1);?>"></div>
                            </div>
                        </div>
                    </div>
                    <?php 
					$v['total_project'] = $v['total_project'] == 0 ? 1 : $v['total_project'];
					$success_prjct = (int) $v['com_project'] * 100 / (int) $v['total_project'];
					?>
                    <!-- Details -->
                    <div class="freelancer-details">
                        <div class="freelancer-details-list">
                            <ul>
                                <li>Location <strong><i class="icon-material-outline-location-on"></i> <?php echo getField('Name', 'country', 'Code',$v['country']); ?></strong></li>
                                <li>Rate <strong><?php echo CURRENCY;?> <?php echo $v['hourly_rate'];?>/<?php echo __('findtalents_hr','hr'); ?></strong></li>
                                <li>Job Success <strong><?php echo round($success_prjct,2);?>%</strong></li>
                            </ul>
                        </div>                                                                
                    </div>
                </div>
                <!-- Freelancer / End -->
			<?php } } ?>
            </div>
            <div class="text-center margin-top-30">
				<a href="<?php echo base_url('findtalents');?>" class="btn btn-gradient">Browse All Freelancers</a>
            </div>
	</div>
</div>
<!-- Highest Rated Freelancers / End-->

<!-- Features Jobs -->
<div class="sec section">
	<div class="container">
    <!-- Section Headline -->
		<div class="section-headline centered margin-top-0 margin-bottom-35">
            <h3>Browse &amp; bid on freelance jobs</h3>            
        </div>
		<!-- Jobs Container -->
        <div class="listings-container compacty-list-layout margin-top-35">
        <ul class="jobList">
            <?php /* get_print($projects); */
			if(count($projects) > 0){
				foreach($projects as $key=>$val){
			?>
            	<li>                   
                    <div class="jobs-title">
                        <p><?php echo $val['title']?></p>                 
                    </div>                    

                
                <!-- Job Listing Footer -->
                <div><i class="icon-material-outline-access-time"></i> 
									<?php echo __(strtolower(date('M',strtotime($val['post_date']))),date('M',strtotime($val['post_date']))).' '.date('d',strtotime($val['post_date'])).','.date('Y',strtotime($val['post_date']));?>
				</div>
             
                    <div><i class="icon-material-outline-location-on"></i>
                        <?php
                        $code=strtolower($this->auto_model->getFeild('code2','country','Code',$val['country']));
                        if($val['user_city']!="" AND is_numeric($val['user_city'])){
                            echo getField('Name', 'city', 'id', $val['user_city'])." ";
                        }
                        ?>
                        &nbsp;<img src="<?php echo VPATH;?>assets/images/flags/<?php echo $code;?>.svg" alt="" class="flag" width="20" title="<?php echo getField('Name', 'country', 'Code', $val['country']);?>" data-tippy-placement="top">
                    </div>
                    <div>
                        
                        <?php echo ($val['project_type']=='F') ? '<i class="icon-feather-lock"></i> Fixed' : '<i class="icon-feather-clock"></i> Hourly' ?>                        
                    </div>
                    <div class="hourly_rate"><strong><?php echo CURRENCY;?><!-- <?php echo $val['buget_min'];?> - --><?php echo $val['buget_max'];?></strong><?php if($val['project_type']=='H'){?>/hr<?php }?></div>
                                        
                	<div>
            		<a href="<?php echo base_url()?>jobdetails/details/<?php echo $val['project_id']?>/<?php echo strtolower(str_replace(' ','-',$val['title']))?>/" class="btn btn-border">View Details</a>
                    </div>
            	</li>
			<?php
				}//for
			}//if
			?>
            </ul>
        </div>
        <div class="text-center margin-top-30">
        	<a href="<?php echo base_url('findjob/browse') ?>" class="btn btn-gradient">Browse All Jobs</a>
        </div>
		<!-- Jobs Container / End -->
	</div>
</div>
<!-- Featured Jobs / End -->



<?php if($page_skill=='Y') { ?>
<!-- skill secton start -->

<section class="sec skills">
  <div class="container">
    <h2 class="title"><?php echo __('home_work_with_someone_perfect_for_your_team','Work with someone perfect for your team'); ?><br>
    </h2>
    <div class="row-10">
      <?php

 if(count($skills) > 0){ foreach($skills as $k => $v){
	$img = !empty($v['image']) ? ASSETS.'skill_image/'.$v['image'] : IMAGE.'no-image_60x60.png';
	$img = str_replace('_thumb', '', $img);
	
	$skill_name=$v['skill_name'];
			  switch($lang){
				case 'arabic':
					$skill_name = !empty($v['arabic_skill_name'])? $v['arabic_skill_name'] : $v['skill_name'];
					break;
				case 'spanish':
					//$categoryName = $val['spanish_cat_name'];
					$skill_name = !empty($v['spanish_skill_name'])? $v['spanish_skill_name'] : $v['skill_name'];
					break;
				case 'swedish':
					//$categoryName = $val['swedish_cat_name'];
					
					$skill_name = !empty($v['swedish_skill_name'])? $v['swedish_skill_name'] : $v['skill_name'];
					break;
				default :
					$skill_name = $v['skill_name'];
					break;
			}
?>
      <article class="col-md-3 col-sm-4 col-50 col-xs-12" data-effect="slide-left">
        <div class="skill-widgets">
          <a href="<?php echo base_url('findtalents/browse').'/'.$this->auto_model->getcleanurl($v['skill_name']).'/'.$v['id']?>" class="icon"><img  src="<?php echo $img;?>" alt=""/> </a>
          <a class="skillOverlay" href="<?php echo base_url('findtalents/browse').'/'.$this->auto_model->getcleanurl($v['skill_name']).'/'.$v['id']?>"><h5><?php echo strlen($v['skill_name']) > 20 ? strip_tags(substr(ucwords($skill_name) , 0, 20)).'..' : strip_tags(ucwords($skill_name));?></h5>
          <p> Starting from $99</p>
          <span class="btn btn-default">Post a Project Like This</span>
          </a>
          
        </div>
      </article>
      <?php } } ?>
    </div>
    
  </div>
</section>

<!-- skill section end -->
<?php } ?>


<div class="clearfix"></div>
<?php if($page_testimonial=='Y') {
		if(count($testimonials)>0){
?>
<!-- Testimonials -->
<div class="sec section gray testimonials">
	
	<div class="container">
		<!-- Section Headline -->
        <div class="section-headline centered margin-top-0 margin-bottom-5">
            <h3>Hear what our customers have to say</h3>
        </div>
	</div>
    
	<div class="testimonial-style-5 testimonial-slider-2 poss--relative">

		<!-- Start Testimonial Nav -->
        <div class="testimonal-nav">
			<?php
			foreach($testimonials as $tkey=>$tval) {
				$client = $this->db->select('fname , lname , logo')->where('user_id' , $tval['user_id'])->get('user')->row_array();
				$client['logo'] = !empty($client['logo']) ? ASSETS.'uploaded/'.$client['logo'] : ASSETS.'images/user.png';
			?>
            <div class="testimonal-img">
                <img src="<?php echo $client['logo'];?>" alt="author">
            </div>
			<?php
			}//for
			?>
        </div>
		<!-- End Testimonial Nav -->

		<!-- Start Testimonial For -->
        
        <div class="testimonial-for">			
            <?php
			$this->load->model('dashboard/dashboard_model');
			foreach($testimonials as $tkey=>$tval) {
				$client = $this->db->select('fname , lname , logo')->where('user_id' , $tval['user_id'])->get('user')->row_array();
				
				$rating = $this->dashboard_model->getrating_new($tval['user_id']);
				$avg_rating=5;
				/* if($rating[0]['num']>0){
					$avg_rating=round($rating[0]['avg']/$rating[0]['num'],2);
				} */
			?>
            <div class="testimonial-desc">
                <div class="triangle"></div>
                <div class="client">
                    <h6><?php echo strtoupper($client['fname'].' '.$client['lname']);?></h6>
                    <div class="star-rating" data-rating="<?php echo round($avg_rating, 1);?>"></div>
                </div>
                <p><?php echo $tval['description'];?></p>
            </div>
			<?php
			}//for
			?>
        </div>         
		<!-- End Testimonial For -->



	</div>
                            
	<!-- Categories Carousel -->
	<div class="fullwidth-carousel-container margin-top-20 d-none">
		<div class="testimonial-carousel">
			<?php 
			  if(count($testimonials) > 0){ foreach($testimonials as $k => $v){   
				if($k > 3){
					break;
				}
				
				$client = $this->db->select('fname , lname , logo')->where('user_id' , $v['user_id'])->get('user')->row_array();
				$client['logo'] = !empty($client['logo']) ? ASSETS.'uploaded/'.$client['logo'] : ASSETS.'images/user.png';
			?>
			<!-- Item -->
			<div class="fw-carousel-review <?php if($k == 0){ echo 'active';} ?>">
				<div class="testimonial-box">
					<div class="testimonial-avatar">
						<img src="<?php echo $client['logo'];?>" alt="">
					</div>
					<div class="testimonial-author">
						<h4><?php echo strtoupper($client['fname'].' '.$client['lname']);?></h4>
						 <span><?php echo date('d M , Y' , strtotime($v['posted']));?></span>
					</div>
					<div class="testimonial"><?php echo $v['description'];?></div>
				</div>
			</div>			
            
		<?php   } } ?>
		</div>
	</div>
	<!-- Categories Carousel / End -->

</div>
<!-- Testimonials / End -->
<?php
	}
}
?>

<section class="padding-top-40 padding-bottom-40">
<div class="container">
	<div class="row">
        <!--<div class="col-lg-10 col-md-9"><h2>Need work done? Join Freelance Near Me for Free</h2></div>-->
		<div class="col-lg-10 col-md-9"><h2>Find your Freelance Partner today!</h2></div>
        <div class="col-lg-2 col-md-3 text-right"><a href="<?php echo base_url('findtalents')?>" class="btn btn-gradient">Get Started</a></div>
	</div>
</div>
</section>

<section class="sec projects" data-effect="slide-left">
  <div class="overlay" style="background-color:#8e54e9cc"></div>
  <div class="container">
    <h2 class="title">Fantastic facts</h2>
    <h5 class="text-center subtitle">Thinking about working as a freelancer or want to be an employer!</h5>
    <h5 class="text-center subtitle">Freelancenearme is an excellent portal that has allowed millions of freelancers & employers to get connected under one roof.</h5>
    <div class="row">
    <article class="col-sm-4 col-xs-12">
      <div class="facts">
      	<i class="icon-feather-user-plus fa-4x"></i>
        <h2 class="counter"><?php echo $this->auto_model->getFeild('no_of_users','setting','id',1)?></h2>
        <h5>Total user</h5>
      </div>
    </article>
    <article class="col-sm-4 col-xs-12">
      <div class="facts">
      	<i class="icon-material-outline-assignment fa-4x"></i>
        <h2 class="counter"><?php echo $this->auto_model->getFeild('no_of_projects','setting','id',1)?></h2>
        <h5>Total projects</h5>
      </div>
    </article>
    <article class="col-sm-4 col-xs-12">
      <div class="facts">
      	<i class="icon-material-outline-assignment fa-4x"></i>
        <h2 class="counter"><?php echo $this->auto_model->getFeild('no_of_completed_prolects','setting','id',1)?></h2>
        <h5>Total completed projects</h5>
      </div>
    </article>
    </div>
    <?php /*
$show_counter = getField('show_counter', 'setting', 'id', '1');
if($show_counter == 'Y'){
?>
<ul class="intro-stats margin-top-45 hide-under-992px">
	<?php
	$no_of_users = getField('no_of_users', 'setting', 'id', '1');
	$no_of_projects = getField('no_of_projects', 'setting', 'id', '1');
	$no_of_completed_prolects = getField('no_of_completed_prolects', 'setting', 'id', '1');
	?>
	<li>
		<strong class="counter"><?php echo (!empty($no_of_users)) ? $no_of_users : '0';?></strong>
		<span>Jobs Posted</span>
	</li>
	<li>
		<strong class="counter"><?php echo (!empty($no_of_projects)) ? $no_of_projects : '0';?></strong>
		<span>Tasks Posted</span>
	</li>
	<li>
		<strong class="counter"><?php echo (!empty($no_of_completed_prolects)) ? $no_of_completed_prolects : '0';?></strong>
		<span>Freelancers</span>
	</li>
</ul>
<?php
}
 */ ?>
  </div>
</section>

<?php /*?><section class="sec whiteBg browseCat">
  <div class="container">
    <h2 class="title"><?php echo __('home_browae_top_skills','Browse top skills'); ?></h2>
    <div class="row">
      <?php
	$count = 0;
	foreach($catagories as $k => $val){
		
		if($count == 0){
			$color = 'blue';
		}
		if($count ==1){
			$color = 'pink';
		}
		if($count == 2){
			$color = 'green';
		}
		if($count == 3){
			$color = 'yellow';
		}
		
		switch($lang){
				case 'arabic':
					$categoryName = !empty($val['arabic_cat_name'])? $val['arabic_cat_name'] : $val['skill_name'];
					break;
				case 'spanish':
					//$categoryName = $val['spanish_cat_name'];
					$categoryName = !empty($val['spanish_cat_name'])? $val['spanish_cat_name'] : $val['skill_name'];
					break;
				case 'swedish':
					//$categoryName = $val['swedish_cat_name'];
					
					$categoryName = !empty($val['swedish_cat_name'])? $val['swedish_cat_name'] : $val['skill_name'];
					break;
				default :
					$categoryName = $val['skill_name'];
					break;
			}
		
	?>
      <article class="col-sm-6 col-md-4 col-xs-12 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0s"> <a href="<?php echo base_url('findjob/browse').'/'.$this->auto_model->getcleanurl($val['skill_name']).'/'.$val['id']?>">
        <div class="box-color text-center <?php echo $color; ?>">
          <div class="icon-large"><i class="<?php echo $val['icon_class']; ?>"></i></div>
          <!--  <h4><?php // echo $val['skill_name']; ?></h4> -->
          <h4><?php echo $categoryName; ?></h4>
          <p> <?php echo $count_project[$val['id']]; ?> <?php echo __('home_projects','Projects'); ?></p>
        </div>
        </a> </article>
      <?php
	$count=$count+1;
if($count > 3){
	$count = 0;
}
	} ?>
    </div>
    <div class="center-block text-center"> <a href="<?php echo base_url('findjob'); ?>" class="btn btn-lg btn-danger xs-block"><?php echo __('home_browae_all_skills','Browse All Skills'); ?></a><span class="hidden-xs">&nbsp;&nbsp;</span> <a href="<?php echo base_url('signup');?>" class="btn btn-lg btn-site xs-block"><?php echo __('home_get_started','Get Started'); ?></a> </div>
  </div>
</section><?php */?> 
<script src="<?=ASSETS?>plugins/testimonial/plugins.js"></script>
<script src="<?=ASSETS?>plugins/testimonial/main.js"></script>

<script src="<?php echo ASSETS?>js/typeahead.bundle.js" type="text/javascript"></script>


<script>
$(function() {
  $('body').addClass('home');
});
var skills_list = new Bloodhound({
  datumTokenizer: Bloodhound.tokenizers.obj.whitespace('text'),
  queryTokenizer: Bloodhound.tokenizers.whitespace,
  prefetch: '<?php echo base_url('contest/get_skills')?>',
  remote: {
    url: '<?php echo base_url('contest/get_skills')?>?search=%QUERY',
    wildcard: '%QUERY'
  }
});

$('#remote_typehead').typeahead(null, {
  name: 'value',
  display: 'text',
  source: skills_list
});

$('#remote_typehead').bind('typeahead:select', function(ev, suggestion) {
  $('#hidden_input_skill').val(suggestion.value);
});
</script> 

<!-- Google Autocomplete -->
<script>
		var placeSearch, autocomplete;
      var componentForm = {
        street_number: 'short_name',
        route: 'long_name',
        locality: 'long_name',
        administrative_area_level_1: 'short_name',
        country: 'long_name',
        postal_code: 'short_name'
      };
	  
	function initAutocomplete() {
		 var options = {
		  types: ['(cities)']
		  //componentRestrictions: {country: "ind"}
		 };

		 var input = document.getElementById('autocomplete-input');
		 autocomplete = new google.maps.places.Autocomplete(input, options);
		 autocomplete.addListener('place_changed', fillInAddress);
	}
	
	function fillInAddress() {
        
        var place = autocomplete.getPlace();

        for (var i = 0; i < place.address_components.length; i++) {
          var addressType = place.address_components[i].types[0];
          if (componentForm[addressType]) {
            var val = place.address_components[i][componentForm[addressType]];
			console.log(val);
			$('#'+addressType+'_autocomplete').val(val);
            /* document.getElementById(addressType+'_autocomplete').value = val; */
          }
        }
      }
	  

	// Autocomplete adjustment for homepage
	if ($('.intro-banner-search-form')[0]) {
	    setTimeout(function(){ 
	        $(".pac-container").prependTo(".intro-search-field.with-autocomplete");
	    }, 300);
	}
</script>

<!-- Google API 
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCuZsZjk-oi_W_c9j-eslyO_LkTwU-8X8U&libraries=places&callback=initAutocomplete" async defer></script>
-->