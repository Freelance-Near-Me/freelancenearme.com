<link rel="stylesheet" href="<?php echo ASSETS;?>plugins/taginput/tokenize2.min.css" type="text/css" />
<script src="<?php echo ASSETS;?>plugins/taginput/tokenize2.min.js" type="text/javascript"></script>

<section class="sec">
	<div class="container">
	<?php echo $breadcrumb;?>  
	<div class="categorySec">
            <h4><?php echo __('findtalents_choose_category','Choose Category')?></h4>
            <ul class="catList">
                <?php
                if(count($category_list)>0){
                    foreach($category_list as $key=>$val){
                        $cat_url = $this->auto_model->getcleanurl($val['cat_name']).'/'.$val['cat_id'];
                ?>
                <li><a href="<?php echo base_url().'findjob/browse/'.$cat_url;?>"><?php echo $val['cat_name'];?></a></li>
                <?php }//for
                }//if
                ?>
            </ul>
        </div>
	</div>
</section>
