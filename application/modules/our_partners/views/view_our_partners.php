<section class="sec">
  <div class="container">
  <?php echo $breadcrumb; ?>
  <div class="section-headline centered margin-bottom-25">
  	<h3>Freelance near me partners</h3>
  </div>
    <div class="row">
		<?php
		if($our_partners){
			foreach($our_partners as $okey=>$oval){
		?>
        <div class="col-lg-6 col-sm-12">
            <div class="media mb-3">
                <a href='<?php echo $oval['url']?>' target='_blank'><img src="<?php echo ASSETS;?>partner_image/<?php echo $oval['image']?>" alt="partner name" class="mr-3" style='width: 190px;'/></a>
                <div class="media-body align-self-center">
					<p><?php echo $oval['description']?></p>
                </div>
            </div>
        </div>
		<?php
			}
		}
		?>
        <!--<div class="col-lg-6 col-sm-12">
            <div class="media mb-3">
                <img src="<?php echo ASSETS;?>partner_image/c3.png" alt="partner name" class="mr-3" />
                <div class="media-body align-self-center">
                <p>Starting out on your own? Tide are ready and rooting for you. And if your business is already up and running, just try Tide out alongside your old bank account.</p>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-sm-12">
            <div class="media mb-3">
                <img src="<?php echo ASSETS;?>partner_image/c4.png" alt="partner name" class="mr-3" />
                <div class="media-body align-self-center">
                <p>PAYSAP follows-up on your unpaid invoices and makes sure you get paid faster & on time, every time. Find out how we can help you reclaim unpaid invoices.</p>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-sm-12">
            <div class="media mb-3">
                <img src="<?php echo ASSETS;?>partner_image/c5.png" alt="partner name" class="mr-3" />
                <div class="media-body align-self-center">
                <p>Paperwrk manages important documentation for a Client when working with contractors.</p>
                </div>
            </div>
        </div>-->
    </div>
    <div class="spacer-20"></div>
  </div>
</section>