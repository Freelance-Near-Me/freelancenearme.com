<!-- Content Start -->
<script type="text/javascript">
 var RecaptchaOptions = {
    theme : 'white'
 };
 </script>

<?php echo $breadcrumb;?> 

<section class="sec">
<div class="container">
<div class="row">
	<aside class="col-md-offset-3 col-md-6 col-sm-offset-1 col-sm-10 col-xs-12" data-effect="slide-top">
		<!--login through g+ and facebook-->
		<!--<a href="<?php echo $loginURL; ?>"><img src="<?php echo base_url().'assets/images/sign-in-with-google.png'; ?>" /></a>-->
<!--<script src="//ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>-->
<style type="text/css">

body {
	margin: 0;
	font-size: 14px;
	color: #333333;
}

#login-button {
	width: 200px;
	margin: 50px auto;
	display: block;
}

#user-information {
	width: 400px;
	display: none;
	margin: 50px auto;
}

#user-information div {
	margin: 0 0 20px 0;
}

#user-information div label {
	display: inline-block;
	vertical-align: middle;
	width: 100px;
	font-weight: 700;
}

#user-information div span {
	display: inline-block;
	vertical-align: middle;
}

</style>
<button id="login-button" disabled>Login with Google</button>

<div id="user-information">
	<div>
		<label>Name</label>
		<span></span>
	</div>
	<div>
		<label>ID</label>
		<span></span>
	</div>
	<div>
		<label>Gender</label>
		<span></span>
	</div>
	<div>
		<label>Picture</label>
		<span></span>
	</div>
	<div>
		<label>Email</label>
		<span></span>
	</div>
</div>

<script async defer src="https://apis.google.com/js/api.js" onload="this.onload=function(){};HandleGoogleApiLibrary()" onreadystatechange="if (this.readyState === 'complete') this.onload()"></script>

<script>

// Called when Google Javascript API Javascript is loaded
function HandleGoogleApiLibrary() {
	// Load "client" & "auth2" libraries
	gapi.load('client:auth2', {
		callback: function() {
			// Initialize client library
			// clientId & scope is provided => automatically initializes auth2 library
			gapi.client.init({
		    	apiKey: 'AIzaSyDuIxpJQIrmvMXu_LFoiFccw1lpDF8_v0E',
		    	clientId: '277431235340-712vdird95p6sangoglc8buon6h35m4k.apps.googleusercontent.com',
		    	scope: 'https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/plus.me'
			}).then(
				// On success
				function(success) {
			  		// After library is successfully loaded then enable the login button
			  		$("#login-button").removeAttr('disabled');
				}, 
				// On error
				function(error) {
					alert('Error : Failed to Load Library');
			  	}
			);
		},
		onerror: function() {
			// Failed to load libraries
		}
	});
}

// Click on login button
$("#login-button").on('click', function() {
	$("#login-button").attr('disabled', 'disabled');
			
	// API call for Google login
	gapi.auth2.getAuthInstance().signIn().then(
		// On success
		function(success) {
			// API call to get user information
			gapi.client.request({ path: 'https://www.googleapis.com/plus/v1/people/me' }).then(
				// On success
				function(success) {
					console.log(success);
					var user_info = JSON.parse(success.body);
					console.log(user_info);

					$("#user-information div").eq(0).find("span").text(user_info.displayName);
					$("#user-information div").eq(1).find("span").text(user_info.id);
					$("#user-information div").eq(2).find("span").text(user_info.gender);
					$("#user-information div").eq(3).find("span").html('<img src="' + user_info.image.url + '" />');
					$("#user-information div").eq(4).find("span").text(user_info.emails[0].value);

					$("#user-information").show();
					$("#login-button").hide();
				},
				// On error
				function(error) {
					$("#login-button").removeAttr('disabled');
					alert('Error : Failed to get user user information');
				}
			);
		},
		// On error
		function(error) {
			$("#login-button").removeAttr('disabled');
			alert('Error : Login Failed');
		}
	);
});

</script>
	</aside>

	
</div>
</div>  
</section>
<div class="clearfix"></div>

    
    
    
    