<html>
<head>

<title>Set account type</title>
<script src="<?=JS?>jquery.min.js"></script>
<link href="<?=CSS?>bootstrap.css" rel="stylesheet" type="text/css">
<link href="<?=CSS?>style_en.css" rel="stylesheet" type="text/css">

<link href="<?=CSS?>themestyle.css" rel="stylesheet" type="text/css">
<style>
body {
    font-family: "Nunito", Arial, sans-serif;
    background-color: #fff;
}
header {
	background-color:#fff;
	border-bottom:1px solid #ddd;
	padding:10px;
}
.sec {
    padding: 40px 0;
}
.general-form {
    background-color: #fff;
    box-shadow: 0 0 5px #ccc;
    padding: 25px;
    position: relative;
}
</style>
</head>
<body>
<header>
<div class="container">
<?php if($currLang == 'arabic'){ ?>
    <img src="<?=ASSETS?>img/logo_ar.png" alt="" title="">
    <?php }else{ ?>
    <img src="<?=ASSETS?>img/<?php echo SITE_LOGO;?>" alt="" title="">
<?php } ?>
</div>
</header>
<section class="sec">
<div class="container">
<div class="row">
	<aside class="col col-md-6 offset-md-3">
        <div class="success alert-success alert" style="display:none"></div>         
        <div class="general-form">        
        <div class="welcome-text">
            <h3>Choose your account type:</h3>    
        </div>
        
            <form id="acc_type_sub" class="text-center">
				<div class="account-type">            
					<input type="hidden" value="<?php echo $token?>" name="token" id="token">
					<div>
						<input type="radio" name="account_type" class="account-type-radio" id="employer" value="E" checked='checked'>
						<label for="employer" class="ripple-effect-dark"><i class="icon-material-outline-account-circle"></i> Employer</label>
					</div>
					<div>
						<input type="radio" name="account_type" class="account-type-radio" id="freelancer" value="F">  
						<label for="freelancer" class="ripple-effect-dark"><i class="icon-material-outline-business-center"></i> Freelancer</label>
					</div>
				</div>
				<button type="submit" class="margin-top-10 button full-width button-sliding-icon ripple-effect">Continue <i class="icon-material-outline-arrow-right-alt"></i></button>
            </form>
        
        </div>
     </aside>
</div>
</div>
</section>


</body>
<script>
		$( "#acc_type_sub" ).submit(function( event ) {
			event.preventDefault();
			var acc_type_data = {
				token: $("#token").val(),
				acc_type: $("input[name='account_type']:checked").val()
			};
			$.ajax({
				url : '<?php echo base_url('user/acc_type_update')?>',
				data: acc_type_data,
				type: 'POST',
				dataType: 'json',
				success: function(res){
					if(res.status == 1){
						if(res.next){
							location.href = res.next;
						}else{
							location.href = '<?php echo base_url('dashboard'); ?>';
						}
					}else{
						alert('Something went wrong');
					}
				}
			});
		});
	</script>
</html>