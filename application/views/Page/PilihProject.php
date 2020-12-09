<!DOCTYPE html>
<head>
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/PilihProject_css.css"/>
	
</head>

<html>
	<div class="container mt-4">
		<div class="row">
			<div class="col-md-3 left">
				<div class="sidebar mt-5">
					<ul>
						<a href="#project-section">
							<li class="content">
								<i class="fab fa-flipboard mr-3"></i>
								<p>Project</p>
							</li>
						</a>
					</ul>
					<ul>
						<a href="#friend-section">
							<li class="content">
								<i class="fas fa-user mr-3"></i>
								<p>Friends</p>
							</li>
						</a>
					</ul>
				</div> 
			</div>

				

			<div id="project-section" class="col-md-9 right tab-content">
				
				<h3>Personal Board</h3>

				<?php foreach($project_own as $project_own) { ?>
						<a href="<?php echo base_url()?>board/home/<?php echo $project_own->id_project ?>">
							<div class="card mt-3">
								<h5 class="card-title"><?php echo $project_own->project_title ?></h5>
							</div>
						</a>
					
				<?php }  ?>
					<a href="#addproject" class="addproject" type="button" class="btn btn-primary" data-toggle="modal" data-target="#addproject">
						<div class="card mt-3"  style="opacity: 80%; background-color: #D0D0D0">
							<h5 class="card-title">Add New Project</h5>
						</div>
					</a>
			</div>

			<!-- Friend Section --> 

			<div id="friend-section" class="col-md-9 right tab-content" >
				<div>
					<h3>Find Friend</h3>
					  <div class="input-group mt-3 search">
					    <input type="text" class="form-control search-value" placeholder="Search Friends. . ." name="friend">
					    <div class="input-group-append">
					      <button class="btn btn-secondary btn-friend" type="button" data-toggle="modal" data-target="#friendtab">
					        <i class="fa fa-search"></i>
					      </button>
					    </div>
					  </div>
				</div>
				
				<div>
				  <h3 class="mt-5">Friend List</h3>
				  	<?php foreach ($friend_list as $friend) { ?>
					  	<div class="friend-list" style=" text-align: center;">
					  		<?php if($friend->username_id_1 == $you_uname ) { ?>
					 			 <img class="rounded-circle friend-pic" alt="100x100" src="<?php echo base_url()?>assets/image/userImg.png" data-holder-rendered="true"> 
					 			<!-- <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($friend->Image)?>" style="width: 80px;margin-right: 10px;border-radius: 50%;" /> -->
					 			<a style="font-size: 16px; font-weight: 600;color:white;"><?php echo $friend->username_id_2 ?></a>
					 		<?php } else { ?>
					 			<img class="rounded-circle friend-pic" alt="100x100" src="<?php echo base_url()?>assets/image/userImg.png" data-holder-rendered="true"> 
					 			<!-- <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($friend->Image)?>" style="width: 80px;margin-right: 10px;border-radius: 50%;" /> -->
					 			<a style="font-size: 16px; font-weight: 600;color:white;"><?php echo $friend->username_id_1 ?></a>
					 		<?php } ?>
					 	
					 	</div>
				 	<?php } ?>
				</div>

				<div>
					<h3 class="mt-3">Friend Request</h3>
					<?php foreach ($friend_pending as $pending) { ?>
					  	<div class="friend-list" style=" text-align: center;">

					 		<img class="rounded-circle friend-pic" alt="100x100" src="<?php echo base_url()?>assets/image/userImg.png" data-holder-rendered="true">

					 		<div style="background-color:white;border-radius: 5px;margin-top: 10px;">
						 		<a style="font-size: 16px; font-weight: 600;"><?php echo $pending->username_id_1 ?></a>
						 		<hr style="padding: 0;margin:0;">
						 		<div class="row" style="padding: 2px;">
							 		<div class="col" >
							 			<i class="fas fa-times fa-lg rejectFriend" style="margin-left: 50%;color: #e43f5a;;cursor:pointer; ?>" data-id1="<?php echo $pending->id_user_1 ?>" data-id2="<?php echo $pending->id_user_2 ?>"></i>
							 		</div>
							 		<div class="col" >
							 			<i class="fas fa-plus fa-lg acceptFriend" style="margin-right: 50%;color: #77d8d8; cursor: pointer;" data-id1="<?php echo $pending->id_user_1 ?>" data-id2="<?php echo $pending->id_user_2 ?>"></i>
							 		</div>
						 		</div>
					 		</div>
					 	</div>
				 	<?php } ?>
				</div>

				 	
			</div>
		</div>
	</div>

	<!-- Modal friends search -->

	 <div class="modal fade" id="friendtab">
	    <div class="modal-dialog">
	      <div class="modal-content">
	      
	        <!-- Modal Header -->
	        <div class="modal-header">
	          <h2 class="modal-title"><strong>Modal Heading</strong></h2>
	          <button type="button" class="close" data-dismiss="modal">&times;</button>
	        </div>
	        
	        <!-- Modal body -->
	        <div class="modal-body ">
	        	
	        </div>
	        
	        <!-- Modal footer -->
	        <div class="modal-footer">
	          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	        </div> 
	        
	      </div>
	    </div>
	  </div>
	 </div>

	

    <!-- Modal tambah project -->
    <form method="post" action="<?php echo base_url()?>PilihProject_C/AddProject">
	 <div class="modal fade" id="addproject">
	 	
	    <div class="modal-dialog">
	      <div class="modal-content">
	      
	        <!-- Modal Header -->
	        <div class="modal-header">
	          <h3 class="modal-title title-tambah-project"><strong>Add New Project</strong></h3>
	          <button type="button" class="close" data-dismiss="modal">&times;</button>
	        </div>
	        
	        
	        <!-- Modal body -->
	        <div class="modal-body">
	        	 <label class="label">Project Title :</label>
          			<div class="form-group">
          				<input name="project-title" type="text" class="form-control" required>
          			</div>
	        </div>
	        
	        <!-- Modal footer -->
	        <div class="modal-footer">
	        	<button type="submit" class="btn btn-primary">Add New Project</button>
	          	<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	        </div> 

	        
	      </div>
	    </div>
	  </div>
	  </form>

	 </div>

	  

<body>
</body>
</html>


<script type="text/javascript">

	$(document).ready(function () {
    $('.sidebar ul:first').addClass('active');
    $('.tab-content:not(:first)').hide();
    $('.sidebar ul a').click(function (event) {
        event.preventDefault();
        var content = $(this).attr('href');
        $(this).parent().addClass('active');
        $(this).parent().siblings().removeClass('active');
        $(content).show();
        $(content).siblings('.tab-content').hide();
    });
});

/*search friend awal halaman*/

	$(document).ready(function(){
	 	 $('.btn-friend').click(function(){
	 	 	var search = $(".search-value").val();
	 	 	 console.log(search);
	 	 		$.ajax({
	 	 			url: "<?php echo base_url()?>PilihProject_C/find_friends/" + search,
	 	 			method:"GET",
	 	 	
	 	 			success:function(data){
	 	 				$('.modal-body').html(data);
 
                    }
	 	 		});
	 	 });
	 });

	/*Maintain Pending Friend Request*/

	$(".rejectFriend").click(function() {
		id1 = $(this).data("id1");
		id2 = $(this).data("id2");

		console.log(id1);
		console.log(id2);

			$.ajax({
					url: "<?php echo base_url() ?>PilihProject_C/removePendingFriend",
					method: "POST",
					data: {id1:id1,id2:id2},

					success: function(response){
						Swal.fire(
								 'Reject Friend',
								 'Anda Menolak Permintaan Teman',
								 'error'
							 )

						setTimeout(function(){
   							location.reload();
       					}, 3000);

					}
			});
	});

	$(".acceptFriend").click(function() {
		id1 = $(this).data("id1");
		id2 = $(this).data("id2");

		console.log(id1);
		console.log(id2);

			$.ajax({
					url: "<?php echo base_url() ?>PilihProject_C/addPendingFriend",
					method: "POST",
					data: {id1:id1,id2:id2},

					success: function(response){
						Swal.fire(
								 'Well Done!',
								 'Permintaan Pertemanan Diterima',
								 'success'
							 )

						setTimeout(function(){
   							location.reload();
       					}, 3000);
						
					}
			});
	});

</script>