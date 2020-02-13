<!DOCTYPE html>
<html>
<head>
<title>Checkout with Stripe Payment Gateway</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<style type="text/css">
.card-gradient	{
    background-image: linear-gradient(to right,#6772e5 0%,#0094e7 100%);
    padding: 12px;
	text-align:center
}
.card-title {
	display: inline;
	font-weight: bold;
}
.display-table {
    display: table;
}
.display-tr {
    display: table-row;
}
.display-td {
    display: table-cell;
    vertical-align: middle;
    width: 61%;
}
</style>
</head>
<body>
     
<div class="container">
     
    <h1>&nbsp;</h1>
     <?php 
	 $amount = $this->input->post('amount');
	 if($amount==''){
		 $amount = 100;
	 }
	 ?>
    <div class="row">		
        <div class="col-md-6 offset-md-3">
            <div class="card credit-card-box">
            	<div class="card-gradient"><img src="<?php echo IMAGE;?>stripe_white_logo.png" alt=""></div>
                <div class="card-header display-table" >
                    <div class="row display-tr" >                    	
                        <h4 class="card-title display-td" >Payment Details</h4>
                        <div class="display-td" >                            
                            <img class="img-responsive pull-right" src="http://i76.imgup.net/accepted_c22e0.png">
                        </div>
                    </div>                    
                </div>
                <div class="card-body">
    
                    <?php if($this->session->flashdata('success')){ ?>
                    <div class="alert alert-success text-center">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                            <p><?php echo $this->session->flashdata('success'); ?></p>
                        </div>
                    <?php } ?>
					
					<?php
					$stripe_mode = $this->auto_model->getFeild('stripe_mode','setting','id',1);
					if($stripe_mode=='DEMO'){
						$stripe_key = get_option_value('demo_stripe_key');
					} else {
						$stripe_key = get_option_value('live_stripe_key');
					}
					?>
					
					<form role="form" action="<?php echo base_url('StripeController/stripePost')?>" method="post" class="require-validation" data-cc-on-file="false" data-stripe-publishable-key="<?php echo $stripe_key ?>" id="payment-form">
						<input type='hidden' name="amt" value="<?php echo $amount?>" >
                        <div class='form-row row'>
                            <div class='col-sm-12 form-group required'>
                                <label class='control-label'>Name on Card</label> <input class='form-control' size='4' type='text'>
                            </div>
                        </div>
     
                        <div class='form-row row'>
                            <div class='col-sm-12 form-group card_old required'>
                                <label class='control-label'>Card Number</label> <input autocomplete='off' class='form-control card-number' size='20' type='text'>
                            </div>
                        </div>
      
                        <div class='form-row row'>
                            <div class='col-sm-12 col-md-4 form-group cvc required'>
                                <label class='control-label'>CVC</label> <input autocomplete='off' class='form-control card-cvc' placeholder='ex. 311' size='4' type='text'>
                            </div>
                            <div class='col-sm-12 col-md-4 form-group expiration required'>
                                <label class='control-label'>Expiration Month</label> <input class='form-control card-expiry-month' placeholder='MM' size='2' type='text'>
                            </div>
                            <div class='col-sm-12 col-md-4 form-group expiration required'>
                                <label class='control-label'>Expiration Year</label> <input class='form-control card-expiry-year' placeholder='YYYY' size='4' type='text'>
                            </div>
                        </div>
      
                        <div class='form-row row'>
                            <div class='col-sm-12 error form-group d-none'>
                                <div class='alert-danger alert'>Please correct the errors and try again.</div>
                            </div>
                        </div>
      
                        <div class="row">
                            <div class="col-sm-12">
                                <button class="btn btn-primary btn-lg btn-block" type="submit">Pay Now (<?php echo CURRENCY.' '.$amount?>)</button>
                            </div>
                        </div>
                             
                    </form>
                </div>
            </div>        
        </div>
    </div>
         
</div>
     
</body>  
     
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
     
<script type="text/javascript">
$(function() {
    var $form         = $(".require-validation");
  $('form.require-validation').bind('submit', function(e) {
    var $form         = $(".require-validation"),
        inputSelector = ['input[type=email]', 'input[type=password]',
                         'input[type=text]', 'input[type=file]',
                         'textarea'].join(', '),
        $inputs       = $form.find('.required').find(inputSelector),
        $errorMessage = $form.find('div.error'),
        valid         = true;
        $errorMessage.addClass('d-none');
 
        $('.has-error').removeClass('has-error');
    $inputs.each(function(i, el) {
      var $input = $(el);
      if ($input.val() === '') {
        $input.parent().addClass('has-error');
        $errorMessage.removeClass('d-none');
        e.preventDefault();
      }
    });
     
    if (!$form.data('cc-on-file')) {
      e.preventDefault();
      Stripe.setPublishableKey($form.data('stripe-publishable-key'));
      Stripe.createToken({
        number: $('.card-number').val(),
        cvc: $('.card-cvc').val(),
        exp_month: $('.card-expiry-month').val(),
        exp_year: $('.card-expiry-year').val()
      }, stripeResponseHandler);
    }
    
  });
      
  function stripeResponseHandler(status, response) {
        if (response.error) {
            $('.error')
                .removeClass('d-none')
                .find('.alert')
                .text(response.error.message);
        } else {
            var token = response['id'];
            $form.find('input[type=text]').empty();
            $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
            $form.get(0).submit();
        }
    }
     
});
</script>
</html>