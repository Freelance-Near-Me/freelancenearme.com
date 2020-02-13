<section class="sec">  
  <div class="container">
    <?php echo $breadcrumb?>
     

<div class="row"> 
		<div class="container">
	<div class="accordionMod panel-group">
          <?php foreach($faq_question_parent  as $key=> $val){?>
          <div class="accordion-item panel-default">
            <h4 class="accordion-toggle"><?=$val['name']?></h4>                         
            <section class="accordion-inner panel-body">
            <div class="inner_cont">
                <p><?php foreach($val['sub_title']  as $key=> $show){?>
                <h4 class="qstn"><?=$show['faq_question']?></h4>
                
                <div class="ans"><?php echo html_entity_decode($show['faq_answers']);?></div>
                <?php }?>
                </p>
              </div>
            </section>
          </div>
          <?php }?>
        </div>
      
    <div class="clearfix"></div>
    <?php 
  
  if(isset($ad_page)){ 
    $type=$this->auto_model->getFeild("type","advartise","","",array("page_name"=>$ad_page,"add_pos"=>"M","status"=>"Y"));
  if($type=='A') 
  {
   $code=$this->auto_model->getFeild("advertise_code","advartise","","",array("page_name"=>$ad_page,"add_pos"=>"M","status"=>"Y")); 
  }
  else
  {
   $image=$this->auto_model->getFeild("banner_image","advartise","","",array("page_name"=>$ad_page,"add_pos"=>"M","status"=>"Y"));
    $url=$this->auto_model->getFeild("banner_url","advartise","","",array("page_name"=>$ad_page,"add_pos"=>"M","status"=>"Y")); 
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
    <div class="addbox2"> <a href="<?php echo $url;?>" target="_blank"><img src="<?=ASSETS?>ad_image/<?php echo $image;?>" alt="" title="" /></a> </div>
    <?php  
 }
  }

?>
    <div class="clearfix"></div>
  </div>
  </div>
  </div>
</section>
