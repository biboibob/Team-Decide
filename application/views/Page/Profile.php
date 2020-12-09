<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/Profile.css"/>
	<script src="croppie.js"></script>
	<link rel="stylesheet" href="croppie.css"/>
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.min.js"></script> -->
</head>
<body>
	<div class="container">

		<?php foreach($data_user as $val) { ?>
				<div class="row img_wrap" data-id="<?php echo $val->id_user ?>" style=" display: flex;align-items: center;justify-content: center;margin-top: 50px;" >

					<img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($val->Image); ?>" style="width: 200px;margin-right: 10px;border-radius: 50%;" class="imageProfile" />

					<div class="centered">Change Your Photo</div>

				</div>
				<div class="row" style=" display: flex;align-items: center;justify-content: center;">
					<p style="font-size: 30px;font-weight: 600;color:white;"><?php echo $val->username ?>, #ID-<?php echo $val->id_user?></p>
				</div>

				<div class="row">
					<div class="col-7">

						<p style="font-size: 25px;color: white;font-weight: 600;">Profile</p>

						<div class="profile" style="padding: 20px;">
							<div class="row" style="margin-top: 5px;">
								<div class="col-2">
									Username
								</div>
								<div class="col-1">
									:
								</div>
								<div class="col-9" style="font-weight: 600;">
									<span><?php echo $val->username ?></span>
									<input type="text" value="<?php echo $val->username ?>" class="text-input username">
								</div>
							</div>

							<div class="row" style="margin-top: 5px;">
								<div class="col-2">
									Password
								</div>
								<div class="col-1">
									:
								</div>
								<div class="col-9" style="font-weight: 600; display: inline-flex;">
									<span>-</span>
									<input type="password" value="<?php echo $val->password ?>" class="text-input password" id="password">
									<i class="far fa-eye seePass" onclick="myFunction()" ></i>
								</div>
							</div>

							<script type="text/javascript">
								function myFunction() {
								  var x = document.getElementById("password");
								  if (x.type === "password") {
								    x.type = "text";
								  } else {
								    x.type = "password";
								  }
								}
							</script>

							<div class="row" style="margin-top: 5px;">
								<div class="col-2">
									Email
								</div>
								<div class="col-1">
									:
								</div>
								<div class="col-9" style="font-weight: 600;">
									<span><?php echo $val->email ?></span>
									<input type="text" value="<?php echo $val->email ?>" class="text-input email">
								</div>
							</div>

							<div class="row" style="margin-top: 5px;">
								<div class="col-2">
									Phone
								</div>
								<div class="col-1">
									:
								</div>
								<div class="col-9" style="font-weight: 600;">
									<span><?php echo $val->phone ?></span>
									<input type="text" value="<?php echo $val->phone ?>" class="text-input phone">
								</div>
							</div>

							<div class="row" style="margin-top: 5px;">
								<div class="col-2">
									Address
								</div>
								<div class="col-1">
									:
								</div>
								<div class="col-9" style="font-weight: 600;">
									<span><?php echo $val->address ?></span>
									<textarea type="text" class="text-input" id="address" style="height: 60px;"><?php echo $val->address ?></textarea>
								</div>
							</div>

						</div>


						<button class="editProfile">Edit</button>
						<button class="saveProfile">Save</button>

					</div>
					<div class="col-5">
						<p style="font-size: 25px;color: white;font-weight: 600;">Project</p>

						<div class="project">
							<ul class="list-group list-project">
								<?php foreach ($data_project as $attach) { ?>
							    	<li class="list-group-item" style="font-weight: 600;"><a href="<?php echo base_url('Board/Home/'.$attach->id_project)?>"><?php echo $attach->project_title ?></a></li>
							    <?php } ?>
							 </ul>
						</div>

					</div>
				</div>


		<?php } ?>

			

			<div id="insertimageModal" class="modal" role="dialog">
				 <div class="modal-dialog">
				  <div class="modal-content">
				      <div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal">&times;</button>
				        <h4 class="modal-title">Crop & Insert Image</h4>
				      </div>
				      <div class="modal-body">
				        <div class="row">
				          <div class="col-md-8 text-center">
				            <div id="image_demo" style="width:350px; margin-top:30px"></div>
				          </div>
				          <div class="col-md-4" style="padding-top:30px;">
				        <br />
				        <br />
				        <br/>
				            <button class="btn btn-success crop_image">Crop & Insert Image</button>
				          </div>
				        </div>
				      </div>
				      <div class="modal-footer">
				        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				      </div>
				    </div>
				  </div>
				</div>


		<script type="text/javascript">
			$(document).ready(function() {
					$('.saveProfile').hide();

					$('.editProfile').click(function(){

						var dad = $(this).parent();
						dad.find('span').hide();
						dad.find('input[type="password"]').show().focus();
						dad.find('input[type="text"]').show().focus();
						dad.find('textarea').show().focus();
						dad.find('i').show().focus();

						dad.find('.editProfile').hide();
						dad.find('.saveProfile').show();
					});

					$('.saveProfile').click(function(){

						var dad = $(this).parent();
						dad.find('span').show();
						dad.find('input[type="text"]').hide();
						dad.find('input[type="password"]').hide();
						dad.find('textarea').hide();
						dad.find('i').hide();

						dad.find('.editProfile').show();
						dad.find('.saveProfile').hide();


						var uname = $('.username').val();
						var password = $('.password').val();
						var email = $('.email').val();
						var phone = $('.phone').val();
						var address = $('#address').val();

						console.log(uname);
						console.log(password);
						console.log(email);
						console.log(phone);
						console.log(address);

							$.ajax({
								method:'POST',
								url : '<?php echo base_url()?>Profile_C/change_value',
								data : {uname:uname,password:password,email:email,phone:phone,address:address},

								success: function(data){
										setTimeout(function(){// wait for 5 secs(2)
									           location.reload(); // then reload the page.(3)
									      }, 1); 
									}  	

							})
					});


					$(document).ready(function(){
						$('.img_wrap').click(function(){
							
							var id_user = $(this).data("id");

							console.log(id_user);
							/*$.ajax({
								url: "<?php echo base_url() ?>board/detail_activity",
								method: "POST",
								data: {id_activity:id_activity, id_board:id_board},
								dataType : 'json',

								success: function(response){

					                    }

					            }); */
						});

						$image_crop = $('#image_demo').croppie({
						    enableExif: true,
						    viewport: {
						      width:200,
						      height:200,
						      type:'square' //circle
						    },
						    boundary:{
						      width:300,
						      height:300
						    }    
						});

						$('.insert_image').on('change', function(){
						    var reader = new FileReader();
						    reader.onload = function (event) {
						      $image_crop.croppie('bind', {
						        url: event.target.result
						      }).then(function(){
						        console.log('jQuery bind complete');
						      });
						    }
						    reader.readAsDataURL(this.files[0]);
						    $('#insertimageModal').modal('show');
						});
					});




			});
		</script>
	</div>
</body>
</html>