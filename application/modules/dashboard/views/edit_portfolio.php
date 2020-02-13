
<!-- Title, Breadcrumb Start-->
      

<script src="<?=JS?>mycustom.js"></script>

<!-- Main Content start-->
<?php 
$count=$total_row;
?>

<div class="clearfix"></div>
<section class="sec section gray">
<div class="container">
<?php echo $breadcrumb;?>
<?php //echo $leftpanel;?>


<div class="row margin-bottom-20">
<div class="col-sm-8 col-xs-12">
	<h4><?php echo __('dashboard_editportfolio_all_items','All Items'); ?> (<?php echo $count;?>)</h4>
</div> 
<div class="col-sm-4 col-xs-12 text-right"> 
	<a href="<?php echo VPATH;?>dashboard/profile_professional"><i class="zmdi zmdi-long-arrow-left"></i> <?php echo __('dashboard_editportfolio_back_to_profile','Back to profile'); ?></a> &nbsp; 
	<?php 
    if($total_plan_portfolio>=$logeduser_portfolio){ 
    ?>
    <a href="<?php echo VPATH;?>dashboard/addportfolio" class="btn btn-site">+&nbsp;<?php echo __('dashboard_editportfolio_upload_new','Upload New '); ?></a>
    <?php
    }
    ?>
</div>    
</div>

<div class="row row-10">
<?php 
if($count>0){ 
foreach ($user_portfolio as $key=>$val){ 
$extension = end(explode(".", $val['thumb_img'])); 
?>
<article class="col-md-3 col-sm-4 col-xs-12">
<div class="card">
						 
<?php 
if($extension=="zip" || $extension=="doc" || $extension=="docx" || $extension=="pdf" || $extension=="xls" || $extension=="xlsx" || $extension=="txt"  ){ 

}
else{ 
?>
<div class="picture"><img src="<?php echo VPATH."assets/portfolio/".$val['thumb_img'];?>"></div>    
<?php    
}
?>    
<div class="card-body">
<h4 class="card-title"><?php echo $val['title'];?> &nbsp;</h4>
<p><?php echo __('dashboard_editportfolio_updated_on','Updated on'); ?> <?php echo $this->auto_model->date_format($val['add_date']);?></p>
<p><?php echo __('dashboard_editportfolio_tags','Tags'); ?>: <span><?php echo $val['tags'];?></span></p>

<?php
if($val['status']=="Y"){ 
?>
<a href="<?php echo VPATH;?>dashboard/activeportfolio/<?php echo $val['id'];?>/D" class="btn-del"><i class="zmdi zmdi-thumb-down" title="Deactive It"></i></a>
<?php
}
else{ 
?>
<a href="<?php echo VPATH;?>dashboard/activeportfolio/<?php echo $val['id'];?>/A" class="btn-aktive"><i class="zmdi zmdi-thumb-up" title="Active It"></i></a>
<?php 
}
?>
<a href="<?php echo VPATH;?>dashboard/addportfolio/<?php echo $val['id'];?>" class="btn-edit"><i class="zmdi zmdi-edit"></i></a>
<a href="<?php echo VPATH;?>dashboard/deleteportfolio/<?php echo $val['id'];?>" class="btn-del"><i class="zmdi zmdi-delete"></i></a>
</div>
</div>
</article>
<?php        
}
}
else{ 
?>
<div class="col-xs-12"><p style="margin-top:15px;">(<?php echo __('dashboard_editportfolio_no_portfolio_uploaded_yet','No Portfolio Uploaded Yet.'); ?>)</p></div>
<?php 
}
?>
</div>

<?php echo $links;?>                    

</div>
</section>       
<script>

  function add_portfolio_div(){ 
    $("#add_portfolio_div").show();    
  }

 function movefile(evt){ 
    var n=document.getElementById('userfile').files[0];         
       
        $.ajaxFileUpload({
            url:'<?php echo VPATH;?>dashboard/uploadportfolio/',
            secureuri:false,
            fileElementId:'userfile',
            dataType: 'json',
            data:{name:n.name, id:'id'},
            success: function (data){
                $("#pid").val(data.pid);
               // window.location.href="<?php echo VPATH;?>dashboard/editportfolio";                
            }
    });
     
  }  
</script>
