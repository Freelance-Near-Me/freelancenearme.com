    <?php echo $breadcrumb; ?>      

    <script src="<?= JS ?>mycustom.js"></script>

        <div class="container">

            <div class="row">

                <?php echo $leftpanel; ?> 

                <!-- Sidebar End -->

                <div class="col-md-9 col-sm-8 col-xs-12">
                        <!--ProfileRight Start-->

                        <div class="profile_right">

                          


                            
                          



                            <div class="latest_worbox lst">

                                <div class="latest_text"><h1>Affiliate User</h1></div>
                                <div style="clear:both;"></div>

                                <div class="latest_work clearafter">

                                    <div class="notifications ">



                                        <?php
                                        if($affiliatelist && is_array($affiliatelist)){

                                        foreach ($affiliatelist as $row) {
                                            ?>
                                            <div class="notifbox">

                                                <p><?=$row['name']?>(<?php echo $row['status']; ?>)</p>
                                                <span><?php echo date('d M,Y', strtotime($row['add_date'])); ?></span>
                                            </div>
    <?php
}
}else{
	echo '  <div class="notifbox" style="text-align: center;">No record found.</div>';
}
?>
<p id="pagi">
<?php  
if(isset($links))
{                     
 echo $links;   
}
 ?> 
 </p>
                                    </div>
                                </div>
                            </div>





 <div class="clr"></div>





                          





                        </div>                       

                        <!--ProfileRight Start-->
                        
                    <div class="clearfix"></div>
<?php
if (isset($ad_page)) {
    $type = $this->auto_model->getFeild("type", "advartise", "", "", array("page_name" => $ad_page, "add_pos" => "M"));
    if ($type == 'A') {
        $code = $this->auto_model->getFeild("advertise_code", "advartise", "", "", array("page_name" => $ad_page, "add_pos" => "M"));
    } else {
        $image = $this->auto_model->getFeild("banner_image", "advartise", "", "", array("page_name" => $ad_page, "add_pos" => "M"));
        $url = $this->auto_model->getFeild("banner_url", "advartise", "", "", array("page_name" => $ad_page, "add_pos" => "M"));
    }

    if ($type == 'A' && $code != "") {
        ?>
                            <div class="addbox2">
                            <?php
                            echo $code;
                            ?>
                            </div>                      
                            <?php
                        } elseif ($type == 'B' && $image != "") {
                            ?>
                            <div class="addbox2">
                                <a href="<?php echo $url; ?>" target="_blank"><img src="<?= ASSETS ?>ad_image/<?php echo $image; ?>" alt="" title="" /></a>
                            </div>
                                <?php
                            }
                        }
                        ?>
                    <div style="clear:both;"></div>

                </div>

                <!-- Left Section End -->

            </div>

        </div>


<!-- Content End -->
<link rel="stylesheet" href="<?php echo ASSETS ?>tags/bootstrap-tagsinput.css">
<link rel="stylesheet" href="<?php echo ASSETS ?>tags/app.css">

<script src="<?php echo ASSETS ?>tags/typeahead.bundle.min.js"></script>
<script src="<?php echo ASSETS ?>tags/bootstrap-tagsinput.js"></script>
<script>
    var substringMatcher = function(strs) {
        return function findMatches(q, cb) {
            var matches, substrRegex;
            matches = [];
            substrRegex = new RegExp(q, 'i');
            jQuery.each(strs, function(i, str) {
                if (substrRegex.test(str)) {
                    matches.push({value: str});
                }
            });
            cb(matches);
        };
    };
    var states = [<?php echo $ahead; ?>];
    jQuery('.tagging').tagsinput({
        typeaheadjs: {
            name: 'states',
            displayKey: 'value',
            valueKey: 'value',
            source: substringMatcher(states)
        }
    });


    function addspan()
    {
        jQuery('.delete_remove').show();
        jQuery('#tags').show();
        jQuery('#edt').hide();
        jQuery('#sv_dv').show();

    }
    function rmvspan()
    {
        jQuery('.delete_remove').hide();
        jQuery('#tags').hide();
        jQuery('#edt').show();
        jQuery('#sv_dv').hide();

    }
    function userrmv_skill(id)
    {
        var datastring = "id=" + id;
        jQuery.ajax({
            data: datastring,
            type: 'post',
            url: '<?php echo VPATH; ?>dashboard/delete_skill/' + id,
            success: function(return_data) {

                jQuery('#all_skills').html(return_data);

            }

        });
    }
    function saveskill()
    {
        var skill = jQuery('.tagging').val();
        var datastring = "skill=" + skill;
        jQuery.ajax({
            data: datastring,
            type: 'post',
            url: '<?php echo VPATH; ?>dashboard/add_skill/',
            success: function(return_data) {

                jQuery('#all_skills').html(return_data);
                jQuery('#tags').hide();
                jQuery('#edt').show();
                jQuery('#sv_dv').hide();
            }

        });
    }
</script>