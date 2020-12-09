	<!DOCTYPE html>
	<html>
	<head>
		<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/Home.css"/>
		<link rel="stylesheet" href="<?php echo base_url() ?>assets/js/Home.js"/>
	</head>
	<body style="height: 100%;">
		<div class="container-fluid">
			<div class="row" style="height: 100%;">

				<div id="board" class="col-md cont tab-content">
					<?php foreach($project_information as $val) { ?>
						<div class="row parent" style="position: fixed;display:flex;width: 100%;">	
							<p style="color:white;padding-top: 5px;padding-left: 20px;line-height: 1;">Logged To Project : <br>
							<span style="font-weight: 600;font-size: 26px;"><?php echo $val->project_title?></span>
							</p>
						</div>
					<?php } ?>

					<!-- Display Board Done -->
					<div style="margin-top: 50px;">
						<div class="list listdone">
							<div style="display: inline-block; width: 100%;">
								<h2 class="list-title" style="font-size: 18px; display: inline-block;color:#b6eb7a;background-color: transparent;">Done Activity</h2>
							</div>

							<ul class="list-items list-items-done">
								<?php 
								foreach($board_content_done as $content) {  
									if($content->status == 2) { ?>
										<li class="Done" style="cursor:context-menu;">
											<a style="font-size: 15px;cursor:pointer;" data-title="<?php echo $content->activity_title ?>" id="<?php echo $content->id_activity?>" class="activityDetailDone"><?php echo $content->activity_title ?></a>

											<div style="float: right;">
												<i style="margin-right: 10px;" class="fas fa-trash-alt actionDoneActivity deleteDoneActivity" id="<?php echo $content->id_activity?>"></i>
											</div>

										</li>	
								<?php }
									else if ($content->status == 1) { ?>	
										<li  class="Pending" style="cursor:context-menu;">
											<a style="font-size: 15px;cursor:pointer;" data-title="<?php echo $content->activity_title ?>" id="<?php echo $content->id_activity?>" class="activityDetailDone"><?php echo $content->activity_title ?></a>

											<div style="float: right;">
												<i style="margin-right: 10px;" class="fas fa-check-circle actionDoneActivity complete" id="<?php echo $content->id_activity?>"></i>
												<i style="margin-right: 10px;" class="fas fa-undo-alt actionDoneActivity revision" id="<?php echo $content->id_activity?>"></i>
											</div>

										</li>	
								<?php } 									
									 } ?>
							</ul>
						</div>	
						



					<!-- Display Board -->
					<?php foreach($board as $board) { ?>
						<div class="list">
							<div style="display: inline-block; width: 100%;">
								<h2 class="list-title" style="font-size: 18px; display: inline-block;"><?php echo $board->board_title ?></h2>
								<div class="opt-board" style="display: inline-block;font-size: 16px;">
									<div class="col">
										<a class="addToBoard" data-toggle="modal" data-target="#AddMemberToBoard" style="cursor: pointer;" id="<?php echo $board->id_board ?>">
											<i class="fas fa-users addUserToBoard"></i>
										</a>

										<a class="reportBoard" data-toggle="modal" data-target="#ReportBoardModal" style="margin-left: 10px;cursor: pointer;" data-board="<?php echo $board->board_title ?>">
											<i class="fas fa-exclamation-triangle"></i>
										</a>
									</div>
								</div>
							</div>


							<ul class="list-items">
								<?php 

								foreach($board_content as $content) { 
									if($board->id_board == $content->id_board) { ?>
										<li  data-board="<?php echo $board->id_board ?>" data-title="<?php echo $content->activity_title ?>" id="<?php echo $content->id_activity?>" class="activityDetail">

											<?php if(!empty($content->label)) { ?>
												<div style="background-color: <?php echo $content->label?>;height: 8px;width: 40px;border-radius: 5px;"></div>
											<?php } ?>

											<a style="font-size: 15px;" ><?php echo $content->activity_title ?></a>
											<?php 
												$i = 0;
												$x = 0;
												foreach($board_checklist as $checklist) {
														if($content->id_activity == $checklist["id_activity"]) {
															$i++;
														if ($checklist["status"] == 1) {
															$x++;
														}	
												}  } 
											?>
											

											<div style="float: right;margin-top: 20px;font-size: 12px;">
												Checklist Activity : <?php echo $x; ?>/<?php echo $i; ?>
											</div>

										</li>											
									<?php } } ?>
								</ul>


								<button  class="add-card-btn btn-add btn" style="margin-bottom: -10px;">+ Add New Activity</button>
								<form method="post" action="<?php echo base_url() ?>Board/add_activity">
									<!-- post data board -->
									<input type="hidden" value="<?php echo $board->board_title ?>" name="board_title">
									<input type="hidden" value="<?php echo $board->id_board ?>" name="id_board">
									<!--  -->

									<div id="add-list" class="cdropdate" style="display:none;">
										<div class="row detail-list">
											<h5 style="text-align: center;margin-top: 20px;font-weight: bold;">Add New Activity!</h5>
											<label style="color:black;font-weight: 600;">Activity Title :</label>	
											<input name="activity" type="text" class="add-detail" style="margin-top: 0px">
											
										</div>
										<input type="submit" class="add-opt">
									</div>
								</form>

							</div>
						<?php }  ?>	

						<!-- modal untuk detail activity -->



						<!-- The Modal -->
						<div class="modal fade" id="DetailActivity" tabindex="-1" role="dialog">
							<div class="modal-dialog" style="min-width: 1200px !Important">
								<div class="modal-content">

									<!-- Modal Header -->
									<div class="modal-header">
										<h2 class="modal-title title_dari_modal" style="font-weight: 600;"></h2>
										<button type="button" class="close" data-dismiss="modal">&times;</button>
									</div>

									<!-- Modal body -->
									<div class="modal-body">
										<!-- <div id="activity_result"></div> -->
										<div class="containter">

											<div class="row">
												<div class="col-md-9 desc-detail">
													<div style="display: flex;margin-bottom: 30px;">
														<div style="display: inline-block; margin-right: 50px;">
															<label style="font-size: 12px;">Labeled As :</label>
															<div class="square" style="height: 20px;width: 90px;border-radius:20px;"></div>
														</div>
														<div style="display: inline-block">
															<label style="font-size: 12px;">Due Date :</label>	
															<p class="date" style="font-size: 13px;"></p>
														</div>
													</div>
													<div>
														<i class="fas fa-plus-square" id="minimize-toggle-description"></i>
														<label><strong>Description :</strong></label>

														<div class="form-group description_change description-content">
															<textarea class="form-control form-desc" name="description"></textarea>

															<input type="submit" value="save" class="save-desc btn-desc" style="float:right; background-color: #0f4c75;">
														</div>
													</div>
												<script>
														/*alasan pake script dibanding post = tidak ada button untuk send value*/

														$(document).ready(function() {
															$('.save-desc').click(function() {
																var description = $('.form-desc').val();							 
																console.log(description);

																$.ajax ({
																	url : '<?php echo base_url()?>Board/save_description_activity',
																	method: 'POST',
																	data : {description:description},

																	success:function(data) {
																		Swal.fire(
																			 'Succes!',
																			 'Deskripsi telah berhasil di update',
																			 'success'
																		 )
																	}
																});
															});
														});


														</script>
												<div>
													<i class="fas fa-plus-square" id="minimize-toggle-checkbox"></i>
													<label style="margin-top: 30px;	"><strong>Checkbox Activity :</strong></label>
													<div class="container-fluid checkbox-content">
														<div class="row checklist_activity">

														</div>
													</div>
												</div>

												<div>
													<i class="fas fa-plus-square" id="minimize-toggle-comment"></i>
													<label style="margin-top: 30px;	"><strong>Comment :</strong></label>
														<div class="toggleComment">
															<div class="container commentSection" style="max-height:130px;">
						
															</div>
															<div class="container" style="margin-top:20px;">
																
																	<div class="form-group" style="display: flex">
																	    <input type="text" class="form-control" id="comment" placeholder="Insert your Comment">
																	    <input type="submit" class="btn btn-info btnComment" style="margin-left: 10px;" value="Submit">
																	</div>
																
															</div>
														</div>
												</div>

						</div>

						<!-- Side Activity Inside Modal -->
						<div class="col-md-3">
							<ul>
								<h5><strong>Add To Card</strong></h5>

								<li class="detailActivityContent" data-toggle="collapse" href="#DueDateSet" aria-expanded="false" aria-controls="#DueDateSet">
									<i class="fas fa-calendar-alt"></i>
									<a style="margin-left:5px;">Due Date</a>
								</li>


								<div class="collapse multi-collapse" id="DueDateSet" style="position: absolute;">
									<div class="card card-body card-modal">
										<form method="POST" action="<?php echo base_url() ?>Board/due_date">
											<h5 style="text-align: center;font-weight: 600;">Set Activity Due Date</h5>
											<p style="margin-top: 20px;">End Date :</p>
											<input type="date" name="date" style="margin-top: -10px; width: 100%;">
											<div style="display: block;text-align: center;margin-top: 20px;">
												<input type="submit" value="save">
											</div>
										</form>
									</div>
								</div>

								<li class="detailActivityContent" style="top:0;" data-toggle="collapse" href="#LabelSet" aria-expanded="false" aria-controls="#LabelSet">
									<i class="fas fa-tags"></i>
									<a style="margin-left:5px;">Label</a>
								</li>


								<div class="collapse multi-collapse" id="LabelSet" style="position: absolute;">
									<div class="card card-body card-modal">
										<h5 style="text-align: center;font-weight: 600;">Set Label</h5>
										<p style="margin-top: 20px;">Label Option :</p>
										<div id="red" style="cursor: pointer;">
											<div style="background-color: red;width: 100%;height: 30px;border-radius: 20px;padding:5px;text-align: center;color:white;margin-top: 10px;"><strong>Important</strong></div>
										</div>
										<div id="yellow" style="cursor: pointer;">
											<div style="background-color: yellow;width: 100%;height: 30px;border-radius: 20px;padding:5px;text-align: center;color:black;margin-top: 10px;"><strong>Intermediate</strong></div>
										</div>
										<div id="blue" style="cursor: pointer;">
											<div style="background-color: blue;width: 100%;height: 30px;border-radius: 20px;padding:5px;text-align: center;color:white;margin-top: 10px;"><strong>Ordinary</strong></div>
										</div>
									</div>
								</div>

								<script type="text/javascript">
									$(document).ready(function() {
										$('#red').click(function(){
											var label = $(this).attr('id');
											console.log(label);
											$.ajax ({
												url : '<?php echo base_url()?>Board/set_label',
												method: 'POST',
												data : {label:label},

												success:function(data) {
													setTimeout(function(){// wait for 5 secs(2)
											           location.reload(); // then reload the page.(3)
											      }, 1); 
												}

											});
										});

										$('#yellow').click(function(){
											var label = $(this).attr('id');
											console.log(label);
											$.ajax ({
												url : '<?php echo base_url()?>Board/set_label',
												method: 'POST',
												data : {label:label},

												success:function(data) {
													setTimeout(function(){// wait for 5 secs(2)
											           location.reload(); // then reload the page.(3)
											      }, 1); 
												}

											});
										});

										$('#blue').click(function(){
											var label = $(this).attr('id');
											console.log(label);
											$.ajax ({
												url : '<?php echo base_url()?>Board/set_label',
												method: 'POST',
												data : {label:label},

												success:function(data) {
													setTimeout(function(){// wait for 5 secs(2)
											           location.reload(); // then reload the page.(3)
											      }, 1); 
												}

											});
										});
									});
								</script>

								<li class="detailActivityContent" data-toggle="collapse" href="#CheckboxSet" aria-expanded="false" aria-controls="#CheckboxSet">
									<i class="fas fa-check-square"></i>
									<a style="margin-left:5px;">Checkbox</a>
								</li>

								<div class="collapse multi-collapse" id="CheckboxSet" style="position: absolute;">
									<div class="card card-body card-modal">
										<form method="POST" action="<?php echo base_url() ?>Board/add_checkbox">
											<h5 style="text-align: center;font-weight: 600;">Add Checklist Activity</h5>
											<p style="margin-top: 20px;">Add Checkbox Activity</p>
											<input name="newCheckbox" style="width: 100%;margin-top: -10px;">
											<div style="display: block;text-align: center;margin-top: 20px;">
												<input type="submit" value="save">
											</div>
										</form>
									</div>
								</div>


							</ul>

							<ul style="margin-top: 30px;">
								<h5><strong>Complete This Activity</strong></h5>
									<li class="doneActivity">
										<i class="fas fa-check-circle"></i>
										<a style="margin-left:5px;">Mark As Done</a>
									</li>
							</ul>

							<ul style="margin-top: 20px;">
								<h5><strong>Report This Activity</strong></h5>
								<li class="ReportActivity" data-toggle="modal" data-target="#ReportBoardActivityModal">
									<i class="fas fa-exclamation-triangle"></i>
									<a style="margin-left:5px;">Report This Activity</a>
								</li>


							</ul>

						</div>
					</div>
				</div>
			</div>

			<!-- Modal footer -->
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary btn-close-detailAct" data-dismiss="modal">Close</button>
			</div> 

				</div>
			</div>
			</div>


				<!-- add new board! -->

					<div class="list add_new_board" style="background-color: #006AA7;margin-right: 20px">
						<a class="add-list-btn btn btn-add" id="add-list" style="color: white;">+ Add New Board</a> 	
						<form method="post" action="<?php echo base_url() ?>Board/add_board">
							<div id="add-board" class="cdropdate" style="display: none;">
								<div class="row detail-list">	
									<center><h4 style="color: white;">Add New Board!</h4></center>
									<label style="color:white;font-weight: 600;">Board Title :</label>
									<input name="board-title" type="text" class="add-detail" style="margin-top: 0px;">

								</div>
								<input type="submit" class="add-opt">
							</div>
						</form>
					</div>
				</div>
			</div>
	

				

				<!-- DOCUMENT HALAMAN -->

				<div id="document" class="col-md-9 tab-content document">
					<div class="container" style="display: block;margin-left: 50px;margin-right: 50px;">
						<div class="row" style="display:block;">
							<h3>Recent Document</h3>

							<?php foreach ($board_doc as $val) { ?>
								<form method="post" action="<?php echo base_url()?>Document_C/Home_Doc" style="display: inline-block;">
									<div class="choose_doc" style="display: inline-block;">
										
										<div class="col card" style="width: 150px;height: 150px;">
											<div class="row card-content">
												

											</div>
										</div>
										<div style="margin-top: 10px; padding-left: 5px; width: 150px; word-wrap: break-word;color: white;">
											<p style="font-size: 14px;font-weight: 600; margin:0;"><?= $val->judul_dokumen ?></p>
											<p style="margin:0;">Activity : <?= $val->activity_title ?></p>
											<p style="margin:0;">Last Updated : <?= $val->last_update ?></p>

										</div>
										<div style="display: block;padding-left: 5px;margin-top: 10px;">
											<input class="btn-open-doc" type="submit" value="open" style="text-align: center;cursor: pointer; width: 100%;">
										</div>
										<input type="hidden" name="id_doc" value="<?= $val->id_document?>">
									</div>
								</form>

							<?php } ?>
						</div>
						
						<script type="text/javascript">
							$(document).ready(function() {
								$('.choose_doc').click(function(){
									var id_doc = $(this).attr('id');
									console.log(id_doc);
									$.ajax ({
										url : "<?php echo base_url()?>Document_C/Home_Doc",
										method: 'POST',
										data: {id_doc:id_doc},

									});
								});
							});
						</script>

						<div class="row" style="display: block;margin-top: 50px;">
							
							<h3>New Document</h3>
							<!-- <input value="<?php echo $val->id_document?>"> -->
							<div class="col card docAdd" style="width: 150px;height: 150px;" data-toggle="collapse" data-target="#AddDocument" aria-expanded="false" aria-controls="#AddDocument">

								<div class="row card-content">
									<p class="plus" style="color: white;font-weight: 600;font-size: 100px;position: absolute;left: 30%;z-index: 1;">+</p>
								</div>
							</div>
						</div>

						<script type="text/javascript">
							$(document).ready(function() {
								$('.docAdd').click(function(){
									$.ajax ({
										url : "<?php echo base_url()?>Board/Add_document_based_board",
										method: 'GET',

										/*data: {id_board:id_board},*/
										success: function(data){
											$('.documentAdd').html(data);
										}  	
									});
								});
							});
						</script>
						
					</div>
				</div>


				<!-- Timeline HALAMAN -->

				<div id="timeline" class="col-md-9 tab-content">
					<div class="container">
						<div class="row" >
							<div class="timelineSection" style="display:inline-block;width:100%;overflow-y:auto;">
								<ul class="timeline timeline-horizontal">
									<?php foreach ($timeline_activity as $val) { ?>
										<?php if($val->DueDate > 0) { ?>
										<li class="timeline-item">
											<div class="timeline-badge primary timelineClick" data-idboard="<?php echo $val->id_board?>" data-idactivity="<?php echo $val->id_activity?>"><i class="glyphicon glyphicon-check"></i></div>
											<div class="timeline-panel">
												<div class="timeline-heading">
													<h4 class="timeline-title" style="font-weight: bold"><?php echo $val->activity_title ?></h4>
														<p><medium class="text-muted"><i class="glyphicon glyphicon-time"></i>
															<?php $date=date_create($val->DueDate); echo date_format($date,"d/m/Y"); ?></medium>
														</p>
												</div>
											</div>
										</li>
									<?php } } ?>
								</ul>

							</div>
						</div>



						<div class="row timelineContent" style="color:white;">
						
			
						</div>
    			
					</div>
				</div>



				<!-- Menu pada kanan sidebar -->

				<div class="col-md-3" style="background-color: white">
					<h2 style="text-align: center; margin-top: 10px;">Menu</h2>
					<div class="dropdown-divider" style="margin-top: 10px;"></div>
					<div class="container">
						<div class="row mt-4">
							<div class="col fitur">
								<h3  style="font-weight: 600;">Features</h3>
								<a  href="#board" style="text-decoration: none;">
									<li class="pilihan-features mt-2" style="font-size: 16px;color:black;">
										<i class="fab fa-flipboard mr-4"></i>Board
									</li>
								</a>

								<a  href="#timeline" style="text-decoration: none;">
									<li class="pilihan-features mt-2" style="font-size: 16px;color:black;">
										<i class="fas fa-hourglass-end mr-4"></i>Timeline
									</li>
								</a>	

								<a  href="#document" style="text-decoration: none;">
									<li class="pilihan-features mt-2" style="font-size: 16px;color:black;">
										<i class="fas fa-folder-open mr-4"></i>Document
									</li>
								</a>

							</div>
						</div>

						<div class="dropdown-divider" style="margin-top: 10px;"></div>
						<div class="row mt-4">
							<div class="col">
								<h3 style="font-weight: 600;">Member</h3>

								<div class="row member-config mt-3">			
									<div class="row mt-4" style="margin-left: 5px;">
											<?php foreach (array_slice($member_project, 0, 4) as $member) { ?>
												<div style="text-align: center; margin-left: 5px;">
													<img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($member->Image); ?>" style="width: 55px;height: 55px; margin-right: 10px;border-radius: 50%;cursor: pointer;" data-toggle="modal" data-target="#userDetail" data-user="<?php echo $member->id_user ?>" class="userDetails"/>
													<p><?php echo $member->username ?></p>
												</div>
											<?php } ?>

										
											<div style="margin-left: 10px;">
												<p style="font-size:40px;" class="show-more find" data-toggle="modal" data-target="#AddFriendToProject">+</p> 
											</div>
									
									</div>
								</div>
							</div>
						</div>

						<div class="dropdown-divider" style="margin-top: 10px;"></div>
						<div class="row mt-4">
							<div class="col">
								<h3 style="font-weight: 600;">Activity</h3>
								<div class="activityChange">
									<?php foreach ($activity_change as $value) { ?>
								
									<div class="row mt-4">
										<div class="col-2">
											<img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($value->Image); ?>" style="width: 50px;height: 50px;margin-right: 10px;border-radius: 50%;cursor: pointer;" data-toggle="modal" data-target="#userDetail" data-user="<?php echo $value->id_user?>" class="userDetails"/>
										</div>
										<div class="col-10 user-activity">
											<h5 style="font-weight: 600;"><?php echo $value->username ?></h5>
											<section style="line-height: 10px;">
												<p style="font-size:13px;line-height: normal;"><?php echo $value->change_description ?></p>
												<p class="Date" style="font-size:10px;"><?php echo $value->date ?></p>
											</section>
										</div>
									</div>

									<?php } ?>

								</div>

							</div>
						</div>
					</div>
				</div>

				
				<div id="message" style="display: flex;justify-content: center;align-items: center;">
					<i class="far fa-comment-dots message-icon"></i>
				</div>

				<div class="setPlacement">
					<div class="containter" id="message-list" style="display: none;z-index: 2;">
							<div class="row" style="margin-top: 5px;margin-left: 5px;margin-right: 5px;display: flex;">
								<div class="col-9">
									<div >
										<p style="font-size: 14px;font-weight: 600;color:white;">Personal Message</p>
									</div>
								</div>
								<div class="col-3" style="text-align: right;">
								
									<div class="minimize-message" style="display: inline-block;margin-left: 5px;cursor: pointer;">
										<p style="font-size: 14px;font-weight: 600;color:white;">X</p>
									</div>
								</div>
							</div>
								<hr style="border:1.2px solid white;margin-top:0px;margin-left: 10px;margin-right: 10px;">
						<?php foreach ($member_project as $val) { ?>
							<div class="set-message-list">
								<a class="row FriendListMessage" style="margin-left: 1px;margin-right: 1px;" href="#" data-user="<?php echo $val->username ?>" data-id="<?php echo $val->id_user ?>"> 
									<div class="col-2" style="margin-right: 5px;">
										<img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($val->Image); ?>" style="width: 35px;margin-right: 10px;border-radius: 50%;" />
									</div>
									<div class="col-7" style="text-align: left;font-size: 16px;padding-top: 6px;color: white;">
										<p><?php echo $val->username ?></p>
									</div>
									<div class="col-1" style="padding-top: 10px;font-size: 16px;color: white;">
										<i class="fas fa-comment-dots"></i>
									</div>
								</a>
							</div>
						<?php } ?>
					</div>


					<div class="messageTab">
						
					</div>


					<script type="text/javascript">
						$(document).ready(function(){
				
							$('.FriendListMessage').click(function(){
								
									var id = $(this).data("id");
									var user = $(this).data("user");

									console.log(id);
									console.log(user);

										$.ajax ({
							 				url : '<?php echo base_url()?>Board/show_message_tab',
							 				method: 'POST',
							 				data : {id:id,user:user},
		 
							 				success: function(data){

							 					$('.messageTab').append(data);	

							 				}

							 			});

									setInterval(function()
														{
															console.log(id);
															console.log(user);

																$.ajax ({
													 				url : "<?php echo base_url()?>Board/interval_chat",
													 				method: "POST",
													 				data : {id:id,user:user},
								 
													 				success: function(data){
													 					$("." + user).html(data);
													 				}
													 			});
														}, 1000); 
							 		

							});


							$("#minimize-specific-msg").click(function() {
								$(this).closest(".container").hide();
							});
			
						});
						

					</script>

					</div>
				</div>
			</div>	
		</div>


		

		<!-- Modal Add New Document  -->

		<div class="modal fade" role="dialog" id="AddDocument">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">

					<!-- Modal Header -->
					<div class="modal-header" >
						<h2 class="modal-title" style="margin-left: 40%;"><strong>Add New Document</strong></h2>
						<button type="button" class="close" data-dismiss="modal">x</button>
					</div>

					<!-- Modal body -->

					<div class="modal-body documentAdd" style="display: inline-flex;">
					</div>


					<!-- Modal footer -->
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					</div> 

				</div>
			</div>
		</div>


	<!-- Modal Add Friend To Project  -->

	<div class="modal fade" id="AddFriendToProject">
		<div class="modal-dialog" style="min-width: 1200px !Important">
			<div class="modal-content">

				<!-- Modal Header -->
				<div class="modal-header" style="padding-left: 40%;">
					<h2 class="modal-title" ><strong>Add Friend To Project</strong></h2>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>

				<!-- Modal body -->


				<div class="modal-body addFriendToProj" style="display: flex;">
				</div>


				<!-- Modal footer -->
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div> 

			</div>
		</div>
	</div>
	</div>

	<!-- Modal Add Friend To Board -->

	<div class="modal fade" id="AddMemberToBoard">
		<div class="modal-dialog" style="min-width: 1000px;">
			<div class="modal-content">

				<!-- Modal Header -->
				<div class="modal-header" style="padding-left: 38%;">
					<h2 class="modal-title"><strong>Add Member To Board</strong></h2>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>

				<!-- Modal body -->

				<div class="modal-body member-project" style="display: inline-flex;">
				</div>


				<!-- Modal footer -->
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div> 

			</div>
		</div>
	</div>

	<!-- Modal Report Board -->

	<div class="modal fade" id="ReportBoardModal">
		<div class="modal-dialog modal-lg" >
			<div class="modal-content">

				<!-- Modal Header -->
				<div class="modal-header" style="padding-left: 35%;">
					<h2 class="modal-title" ><strong>Report Board</strong></h2>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>

				<!-- Modal body -->

				<div class="modal-body" style="padding-left: 30px;">
					
				        
				            <label class="col-form-label">User :</label>
				            <input type="text" class="form-control usernameBoard"  value="<?php echo $username ?>" readonly>
				        
				        	<label class="col-form-label">Reported Board :</label>
				            <input type="text" class="form-control boardInput Board" readonly>
				  
				            <label class="col-form-label">Description Report :</label>
				            <textarea class="form-control descriptionBoard"></textarea>
				
				</div>


				<!-- Modal footer -->
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="button" class="btn btnReportBoard" style="background-color: #d9455f;color:white;">Send Report</button>
				</div> 
					

			</div>
		</div>
	</div>

	<!-- Modal Report Activity -->

	<div class="modal fade" id="ReportBoardActivityModal">
		<div class="modal-dialog modal-lg" >
			<div class="modal-content">

				<!-- Modal Header -->
				<div class="modal-header" style="padding-left: 35%;">
					<h2 class="modal-title" ><strong>Report Activity</strong></h2>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>

				<!-- Modal body -->

				<div class="modal-body" style="padding-left: 30px;">
					
				        
				            <label class="col-form-label">User :</label>
				            <input type="text" class="form-control usernameActivity"  value="<?php echo $username ?>" readonly>
				        
				        	<label class="col-form-label">Reported Activity :</label>
				            <input type="text" class="form-control ActivityInput Activity" readonly>
				  
				            <label class="col-form-label">Description Report :</label>
				            <textarea class="form-control descriptionActivity"></textarea>
				
				</div>


				<!-- Modal footer -->
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="button" class="btn btnReportActivity" style="background-color: #d9455f;color:white;">Send Report</button>
				</div> 
					

			</div>
		</div>
	</div>


	<!-- Modal User Detail -->

	<div class="modal fade" id="userDetail">
		<div class="modal-dialog modal-lg" >
			<div class="modal-content">

				<!-- Modal Header -->
				<div class="modal-header" style="padding-left: 45%;background-color: #D45079;color:white;">
					<h2 class="modal-title" style="font-size: 20px;"><strong>User Detail</strong></h2>
					<button type="button" class="close" data-dismiss="modal" style="background-color: white;">&times;</button>
				</div>

				<!-- Modal body -->

				<div class="modal-body bodyReportUser" style="padding-left: 30px;">
					
				</div>
					

			</div>
		</div>
	</div>


	</div>

	</body>
	</html>


	<script type="text/javascript">

		jQuery(document).ready(function() {
			jQuery('.btn-add').on('click', function(event) {
				jQuery(this).closest('div').find('.cdropdate').toggle(200);
			});
		});


		
		/*Chat Transition*/

		$(document).ready(function(){
			$('#message').click(function(){
				$('#message').hide();
				$('#message-list').css('display','inline-block');
			});


		/*toggle detail activity*/

			$("#minimize-toggle-checkbox").click(function() {
				$(".checkbox-content").toggle();
			});

			$("#minimize-toggle-description").click(function() {
				$(".description-content").toggle();
			});

			$("#minimize-toggle-comment").click(function() {
				$(".toggleComment").toggle();
			});

		
			$('.minimize-message').click(function(){
				$('#message').show();
				$('#message-list').css('display','none');
			});
		});

		/*Mark Activity Step By Step*/

		$(".list-items-done").click(function () {
			$.ajax({
					url: "<?php echo base_url() ?>board/board_done_access",
					method: "GET",
					dataType: "json",

					success: function(response){
						console.log(response);
						var status = response.authority[0].authority;

						if(status != "Chairman") {
							Swal.fire(
								"Akses Ditolak!",
								"Hanya Chairman yang dapat melakukan perubahan pada done board!",
								"error"
							)
						}

						else {

							$('.activityDetailDone').click(function(){
									var id_activity = $(this).attr("id");
									var id_board = $(this).data("board");

											$('.activityDetailDone').attr('data-toggle', "modal");
											$('.activityDetailDone').attr('data-target', "#DetailActivity");

												$.ajax({
													url: "<?php echo base_url()?>Board/activity_comment",
													type: "GET",

													success: function(data){
														$(".commentSection").html(data);
													}
												});

												$.ajax({
													url: "<?php echo base_url() ?>board/detail_activity_checklist",
													method: "POST",
													data: {id_activity:id_activity},

													success: function(data){
														$('.checklist_activity').html(data);
													}

												}); 
																								
												$.ajax({
													url: "<?php echo base_url() ?>board/detail_activity",
													method: "POST",
													data: {id_activity:id_activity, id_board:id_board},
													dataType : 'json',

														success: function(response){
															var len = response.length;
																    if(len > 0 ) {
																        var des = response[0].description;
																        $('.form-desc').val(des);

																        var label = response[0].label;
																        $('.square').css("background-color",label);

																        var hari=response[0].DueDate;
																        $('.date').text(hari);

																        var title=response[0].activity_title;
																        $('.title_dari_modal').text(title);
																    }							        
														}

												});

								});

							$(".revision").click(function () {
								var id_activity = $(this).attr("id");
								Swal.fire({
										  title: 'Revisi Activity Ini?',
										  text: "Activity Akan Ke Board!",
										  icon: 'warning',
										  showCancelButton: true,
										  confirmButtonColor: '#3085d6',
										  cancelButtonColor: '#d33',
										  confirmButtonText: 'Revisi Activity Ini!'
										}).then((result) => {
										  if (result.value) {

										  	$.ajax({
												url: "<?php echo base_url()?>Board/revisionActivity",
												type: "GET"
											});

										  	$.ajax({
									        url: "<?php echo base_url() ?>Board/mark_as_revision",
									        data: {id_activity:id_activity},
									        type: "POST",

									        success:function(data) {
									        	Swal.fire(
													 'Succes!',
													 'Anda telah merevisi activity ini',
													 'success'
												 )

												 setTimeout(function() {
													location.reload();
												 },3000);
									        	}
											});
											 	
										  }
										});
							});

							$(".complete").click(function() {
								var id_activity = $(this).attr("id");
								Swal.fire({
										  title: 'Setujui Activity Ini?',
										  text: "Activity Akan Anda Verifikasi!",
										  icon: 'warning',
										  showCancelButton: true,
										  confirmButtonColor: '#3085d6',
										  cancelButtonColor: '#d33',
										  confirmButtonText: 'Complete Activity Ini!'
										}).then((result) => {
										  if (result.value) {

										  	$.ajax({
												url: "<?php echo base_url()?>Board/completeActivity",
												type: "GET"
											});

										  	$.ajax({
									        url: "<?php echo base_url() ?>Board/mark_as_complete",
									        data: {id_activity:id_activity},
									        type: "POST",

									        success:function(data) {
									        	Swal.fire(
													 'Succes!',
													 'Anda telah verifikasi activity ini',
													 'success'
												 )

												 setTimeout(function() {
													location.reload();
												 },3000);
									        	}
											});
											 	
										  }
										});
							});

							$(".deleteDoneActivity").click(function() {
								var id_activity = $(this).attr("id");
								Swal.fire({
										  title: 'Delete Activity Ini?',
										  text: "Anda akan menghapus activity yang sudah complete!",
										  icon: 'warning',
										  showCancelButton: true,
										  confirmButtonColor: '#3085d6',
										  cancelButtonColor: '#d33',
										  confirmButtonText: 'Delete Activity Ini!'
										}).then((result) => {
										  if (result.value) {

										  	$.ajax({
												url: "<?php echo base_url()?>Board/deleteActivity",
												type: "GET"
											});


										  	$.ajax({
									        url: "<?php echo base_url() ?>Board/delete_complete_activity",
									        data: {id_activity:id_activity},
									        type: "POST",

									        success:function(data) {
									        	Swal.fire(
													 'Succes!',
													 'Anda telah menghapus activity ini',
													 'success'
												 )

												 setTimeout(function() {
													location.reload();
												 },3000);
									        	}
											});
											 	
										  }
										});
							});
						}
					}
			});
		});

			$(".doneActivity").click(function () {
					Swal.fire({
						title: 'Acivity Ini Sudah Selesai?',
						text: "Pastikan Semua Kerjaan Sudah Selesai!",
						icon: 'warning',
						showCancelButton: true,
						confirmButtonColor: '#3085d6',
						cancelButtonColor: '#d33',
						confirmButtonText: 'Yes, Im Done!'
						}).then((result) => {
							if (result.value) {

							$.ajax({
								url: "<?php echo base_url()?>Board/doneActivity",
								type: "GET"
							});

							$.ajax({
									url: "<?php echo base_url() ?>Board/mark_as_done",
									type: "GET",

									success:function(data) {
										Swal.fire(
											'Succes!',
											'Anda telah menyelesaikan aktivitas ini',
											'success'
										)

									setTimeout(function() {
										location.reload();
									},3000);
								}
							});						 	
					}
				});
			});




		/*Untuk memanggil modal pada detail activity*/

		$(document).ready(function(){
			$('.activityDetail').click(function(){
				var id_activity = $(this).attr("id");
				var id_board = $(this).data("board");
				var title = $(this).data("title");

				$(".ActivityInput").val(title);

				$.ajax({
					url: "<?php echo base_url() ?>board/board_member_access",
					method: "POST",
					data: {id_board:id_board},
					dataType: "json",

					success: function(response){
						console.log(response);
						var id_user = response.idUser[0].id_user;
						var len = response.idMemberBoard.length;
						
						var arrMem = [];
						
	            			for(var i=0; i<len; i++){
								var boardMember = response.idMemberBoard[i].id_user;
								arrMem.push(boardMember);
							}	

						console.log(id_user);
						console.log (arrMem);

						if(arrMem.indexOf(id_user) == -1) {
							Swal.fire(
								"Akses Ditolak!",
								"Anda Bukan Anggota Didalam Board Ini!",
								"error"
							)

						}

						else {

							$('.activityDetail').attr('data-toggle', "modal");
							$('.activityDetail').attr('data-target', "#DetailActivity");
														
										
									$.ajax({
											url: "<?php echo base_url() ?>board/detail_activity",
											method: "POST",
											data: {id_activity:id_activity, id_board:id_board},
											dataType : 'json',

											success: function(response){
										            var len = response.length;

										                 if(len > 0 ) {
										                     var des = response[0].description;
										                     $('.form-desc').val(des);

										                      var label = response[0].label;
										                      $('.square').css("background-color",label);

										                     var hari=response[0].DueDate;
										                     $('.date').text(hari);

										                      var title=response[0].activity_title;
										                      $('.title_dari_modal').text(title);
										           		}
										    }
									}); 

									$.ajax({
										url: "<?php echo base_url()?>Board/activity_comment",
										type: "GET",

										success: function(data){
											$(".commentSection").html(data);
										}
									});
		
						}
					}

				}); 
		
			});

			
		});


		$("#DetailActivity").on('hidden.bs.modal', function(){

			$('.activityDetail').removeAttr('data-toggle', "modal");
			$('.activityDetail').removeAttr('data-target', "#DetailActivity");

			location.reload();
		  
		});

		/*Untuk memanggil checklist activity*/
		/*Alasan class activityDetail double karena tidak bisa melakukan join/belum mengerti menggunakannya*/

		$(document).ready(function(){
			$('.activityDetail').click(function(){
				var id_activity = $(this).attr("id");

				$.ajax({
					url: "<?php echo base_url() ?>board/detail_activity_checklist",
					method: "POST",
					data: {id_activity:id_activity},

					success: function(data){
						$('.checklist_activity').html(data);
					}

				}); 
			});

		});

	


		/*Untuk memanggil modal pada available invites member*/

		$(document).ready(function(){
			$('.find').click(function(){
				$.ajax({
					url: "<?php echo base_url()?>Board/find_friend_to_invite",
					method:"GET",

					success:function(data){
						$('.addFriendToProj').html(data);
					}
				});
			});
		});

			/*Report Board Modal*/

			$(".reportBoard").click(function () {
				var board = $(this).data("board");
				$(".boardInput").val(board);
			});

			$(".btnReportBoard").click(function () {

				var username = $(".usernameBoard").val();
				var board = $(".Board").val();
				var description = $(".descriptionBoard").val();
				
				console.log(username);
				console.log(board);
				console.log(description);

				$.ajax({
						url: "<?php echo base_url()?>Board/reportBoard",
						method: "POST",
						data : {username:username,board:board,description:description},

						success:function(data) {
							Swal.fire(
								"Well Done!",
								"Your Report Has Been Sent",
								"success"
							)

							setTimeout(function() {
										location.reload();
									},3000);
							
					}
				});
				
			});

			/*Report Activity Modal*/

			$(".btnReportActivity").click(function () {

				var username = $(".usernameActivity").val();
				var activity = $(".Activity").val();
				var description = $(".descriptionActivity").val();
				

				$.ajax({
						url: "<?php echo base_url()?>Board/reportActivity",
						method: "POST",
						data : {username:username,activity:activity,description:description},

						success:function(data) {
							Swal.fire(
								"Well Done!",
								"Your Report Has Been Sent",
								"success"
							)

							setTimeout(function() {
										location.reload();
									},3000);
					}
				});
				
			});

			/*Report And User Detail*/

			$(".userDetails").click(function () {
				var idUser = $(this).data("user");
				console.log(idUser);
				$.ajax({
						url: "<?php echo base_url()?>Board/reportUser",
						method: "POST",
						data : {id:idUser},

						success:function(data) {
							$(".bodyReportUser").html(data);
					}	
				});

			});

			$(".btnComment").click(function () {
				var comment = $("#comment").val();

				$.ajax({
						url: "<?php echo base_url()?>Board/insert_comment",
						method: "POST",
						data : {comment:comment},

						success:function(data) {
							Swal.fire(
								"Success!",
								"Your Comment Has Been Submit",
								"success"
							)

							setTimeout(function() {
										location.reload();
							},2000);
					}	
				});
			});


		

		 	/*kirim data ke function find friend */

		 	$(document).ready(function() {
		 		$('.addToBoard').click(function() {
		 			var id = $(this).attr('id');
		 			console.log(id);
		 			$.ajax ({
		 				url : '<?php echo base_url()?>Board/find_friend_to_board',
		 				method: 'POST',
		 				data : {id_board:id},

		 				success:function(data) {
		 					$('.member-project').html(data);
		 				}
		 			});
		 		});
		 	});


		 	$(document).ready(function () {
		 		$('.fitur a:first').addClass('active');
		 		$('.tab-content:not(:first)').hide();
		 		$('.fitur a').click(function (event) {
		 			event.preventDefault();
		 			var content = $(this).attr('href');
		 			$(this).parent().addClass('active');
		 			$(this).parent().siblings().removeClass('active');
		 			$(content).show();
		 			$(content).siblings('.tab-content').hide();
		 		});
		 	});  


		 	/*Timeline*/

		 	$(".timelineClick").click(function () {
		 		var id_board = $(this).data("idboard");
		 		var id_activity = $(this).data("idactivity");

		 		console.log(id_board);
		 		console.log(id_activity);
		 		
		 		$.ajax ({
		 				url : '<?php echo base_url()?>Board/timelineActivity',
		 				method: 'POST',
		 				data : {id_activity:id_activity},

		 				success:function(data) {
		 					$('.timelineContent').html(data);

		 					$.ajax ({
					 				url : '<?php echo base_url()?>Board/timelineMember',
					 				method: 'POST',
					 				data : {id_board:id_board},

					 				success:function(data) {
					 					$('.timelineMember').html(data);
					 				}
					 		});
		 				}
		 		});

		 		


		 	});

	

		 	
 </script>

