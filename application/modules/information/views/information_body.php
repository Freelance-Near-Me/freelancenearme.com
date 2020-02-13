<section class="sec">
<div class="container">	
	<!-- Headline -->
    <div class="dashboard-headline">
        <h3><?=ucwords($page_info[0]['content_title'])?></h3>

        <!-- Breadcrumbs -->
        <nav id="breadcrumbs">
            <ul>
                <li><a href="<?php echo base_url();?>">Home</a></li>
      			<li class="active"><?=ucwords($page_info[0]['content_title'])?></li>
            </ul>
        </nav>
    </div>       
    <div class="post-content">    	
        <p><?=html_entity_decode( $page_info[0]['contents'])?></p>
    </div>
	
<div class="clearfix"></div>
<?php 

if(isset($ad_page)){ 
$type=$this->auto_model->getFeild("type","advartise","","",array("page_name"=>$ad_page,"add_pos"=>"M"));
if($type=='A') 
{
$code=$this->auto_model->getFeild("advertise_code","advartise","","",array("page_name"=>$ad_page,"add_pos"=>"M")); 
}
else
{
$image=$this->auto_model->getFeild("banner_image","advartise","","",array("page_name"=>$ad_page,"add_pos"=>"M"));
$url=$this->auto_model->getFeild("banner_url","advartise","","",array("page_name"=>$ad_page,"add_pos"=>"M")); 
}

if($type=='A'&& $code!=""){ 
?>
<div class="addbox2">
<?php 
echo $code;
?>
</div>                      
<?php                      
}
elseif($type=='B'&& $image!="")
{
?>
<div class="addbox2">
<a href="<?php echo $url;?>" target="_blank"><img src="<?=ASSETS?>ad_image/<?php echo $image;?>" alt="" title="" /></a>
</div>
<?php  
}
}

?>
<div class="clearfix"></div>

</div>

</section>         