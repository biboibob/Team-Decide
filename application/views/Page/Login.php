<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

    <!-- font -->
    <link href="https://fonts.googleapis.com/css?family=Anton|Fredoka+One&display=swap" rel="stylesheet">

     <!--  t Alert -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

  	<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/Login.css"/>

</head>

<body>
	<div class="container">
	    <div class="row  content">
	        <div class="col-7 left">
	        	<div class="row">
	          		<img src="<?php echo base_url()?>assets/image/TDW.png" style="width: 100px;margin-top: 30px;margin-left: 30px;">
	      	 	</div>
	      	 	<div class="row" style="margin-top: 120px;margin-left: 90px;">
	      	 		<p style="line-height: 2em;color:white;font-family: Mabry Pro;"><span style="font-size: 35px;font-weight: 100;">Decide Faster.</span>
	      	 			<br>
	      	 		<span style="font-size: 50px;font-weight: bolder;">Work Better.</span></p>
	      	 	</div>
	      	 	<div class="row">
	      	 		<img src="<?php echo base_url()?>assets/image/Homepage.png" style="margin-left: 30px;position: absolute;bottom: 0;width: 100%;max-width: 600px;">
	      	 	</div>
	      	 	
	        </div>
	        <div class="col-5 right">

	        	<!-- Sign In -->

	        	<div class="signin">
		            <div class="row" style="margin-top: 60px;margin-left: 30px;">
		      	 		<p style="line-height: 2em;font-family: Mabry Pro;font-size: 30px;"><span style="color:#D45079;">Sign</span>In</p>
		      	 	</div>
		      	 	<hr>
		      	 	<div class="row" style="margin-left: 30px;margin-right: 30px;">
		      	 		<form  method="post" action="<?php echo base_url()?>PilihProject_C/Login">
							<label for="uname"><b>Username</b></label>
		      					<input name="username" style="width: 100%;" type="text" required>
		      				<label for="uname" style="margin-top: 15px;"><b>Password</b></label>
		      					<input name="password" style="width: 100%;" type="password" required>
							<input class="btn signIn" type="submit" value="SignIn">
						</form>
					
		      	 	</div>
		      	 	<div class="row" style="position: absolute;bottom: 0;width: 100%;">
		      	 		<div class="col" style="font-size: 12px;">
		      	 			<label>Don't Have Any Account?</label><a style="color: #0079BF;margin-left: 5px;cursor: pointer;font-weight: 600;" class="btnSignIn">Sign Up!</a>
		      	 		</div>
		      	 		<div class="col">
		      	 			<img src="<?php echo base_url()?>assets/image/TDB.png" style="width: 50px;float: right;">
		      	 		</div>
		      	 	</div>
		      	 </div>

		      	 <!-- Sign Up -->

		      	 <div class="signup" hidden>
		      	 	<div class="row" style="margin-top: 30px;margin-left: 30px;">
		      	 		<p style="line-height: 2em;font-family: Mabry Pro;font-size: 30px;"><span style="color:#D45079;">Sign</span>Up</p>
		      	 	</div>
		      	 	<hr style="margin-top: 0px;">
		      	 	<div class="row" style="margin-left: 30px;margin-right: 30px;">
		      	 		<form  method="POST" action="<?php echo base_url()?>PilihProject_C/signup" class="signUpForm" enctype="multipart/form-data">
							<label style="font-size: 12px;"><b>Username</b></label> <span class="spanUsername" style="font-weight: 600;float: right;"></span>
		      					<input name="username" id="username" style="width: 100%;" type="text" required>	
		      					
		      				<label style="margin-top: 5px;font-size: 12px;"><b>Password</b></label>
		      					<input name="password" style="width: 100%;" type="password" required>
		      					<div class = "row">
		      						<div class="col-4" style="margin-right: 0px;">
				      					<label style="margin-top: 5px;font-size: 12px;"><b>Phone</b></label>
				      					<input name="phone" style="width: 100%;" type="phone" required>
		      						</div>
		      						<div class="col-8" style="margin-left: 0px;">
				      					<label  style="margin-top: 5px;font-size: 12px;"><b>E-Mail</b></label>
				      					<input name="email" style="width: 100%;" type="email" required>
		      						</div>
		      					</div>
		      				<label  style="margin-top: 5px;font-size: 12px;"><b>Address</b></label>
		      					<input name="address" style="width: 100%;" type="address" required>
		      				<label  style="margin-top: 10px;font-size: 12px;"><b>Upload Profile Picture</b></label>
		      					<input name="image" style="width: 100%;" type="file" accept="image/*" required>
							<input class="btn signUp" type="submit" value="SignUp">
						</form>
					
		      	 	</div>
		      	 	<div class="row" style="position: absolute;bottom: 0;width: 100%;">
		      	 		<div class="col" style="font-size: 12px;">
		      	 			<label>Already Have Account?</label><a style="color: #0079BF;margin-left: 5px;cursor: pointer;font-weight: 600;" class="btnSignUp">Sign In</a>
		      	 		</div>
		      	 		<div class="col">
		      	 			<img src="<?php echo base_url()?>assets/image/TDB.png" style="width: 50px;float: right;">
		      	 		</div>
		      	 	</div>
		      	 </div>
	        </div>
	    </div>
	</div>
	
		
</body>
</html>


<script type="text/javascript">
	
	$(".btnSignIn").click(function () {
		$(".signin").slideUp(300);
		$(".signin").attr("hidden");


		$(".signup").slideDown(300);
		$(".signup").removeAttr("hidden");

	});

	$(".btnSignUp").click(function () {
		$(".signup").slideUp(300);
		$(".signup").attr("hidden");


		$(".signin").slideDown(300);
		$(".signin").removeAttr("hidden");

	});

	
	$('#username').on("change", function(){
	  var username = $('#username').val();

	  $.ajax({
	    url: '<?php echo base_url()?>PilihProject_C/usernameTaken',
	    type: "POST",
	    data: {username: username,},

	    success: function(response){
	      if (response == 'taken' ) {
	      	$('#username').removeClass();
	      	$('#username').addClass("form_error");
	      	$('.spanUsername').text('Sorry... Username already taken');
	      	$('.spanUsername').css({"color": "#D45079", "font-size": "14px", "padding":"5px","border-radius":"10px"});

	      }else if (response == 'not_taken') {
	      	$('#username').removeClass();
	      	$('#username').addClass("form_success");
	      	$('.spanUsername').text('Username available');
	      	$('.spanUsername').css({"color": "#58b4ae", "font-size": "14px", "padding":"5px","border-radius":"10px"});
	      }
	    }
	  });
	 });


	$(".signUpForm").on("submit", function() {
		if($("#username").hasClass("form_error")) {
			return false;
		}
	});

	
</script>
