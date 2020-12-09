public function interval_detailActivity() {

		$id_project=$this->session->userdata('projectid');
	    $clause=array('id_project'=>$id_project);

	    /* UP the board*/
	    $board = $this->board_model->board_data($clause,'board')->result();

	    /*bring up the content*/
	    $board_content = $this->board_model->activity_data('board_activity')->result();

	    /*bring up the checklist activity*/


	    $board_checklist = $this->board_model->checklist_activity('board_checklist_activity')->result_array();


		$output = '';

				foreach($board as $board) { 
		$output .= '<div class="list">
						<div style="display: inline-block; width: 100%;">
							<h2 class="list-title" style="font-size: 18px; display: inline-block;">'.$board->board_title.'</h2>
							<div class="opt-board" style="display: inline-block;font-size: 16px;">
								<div class="col">
									<a class="addToBoard" data-toggle="modal" data-target="#AddMemberToBoard" style="cursor: pointer;" id="'.$board->id_board.'">
										<i class="fas fa-users"></i>
									</a>
								</div>
							</div>
						</div>
					<ul class="list-items">';

							foreach($board_content as $content) { 
								if($board->id_board == $content->id_board) { 

		$output .='		<li data-toggle="modal" data-target="#DetailActivity" data-board="'.$board->id_board.'" id="'.$content->id_activity.'" class="activityDetail"> ';

					if(!empty($content->label)) { 
		$output .='										
						<div style="background-color:'.$content->label.';height: 8px;width: 40px;border-radius: 5px;"></div>';
					} 

		$output .='		<a style="font-size: 15px;" >'.$content->activity_title.'</a>';
										

										
					$i = 0;
					$x = 0;
						foreach($board_checklist as $checklist) {
								if($content->id_activity == $checklist["id_activity"]) {
								$i++;
									if ($checklist["status"] == 1) {
										$x++;
									}	
								}  
							} 

		$output .='				<div style="float: right;margin-top: 20px;font-size: 12px;">
									Checklist Activity : '.$x.'/'.$i.'
								</div>

								</li>';									
						 } }
		$output .='		</ul>

							<button  class="add-card-btn btn-add btn" style="margin-bottom: -10px;">+ Add a card</button>
							<form method="post" action="'.base_url().'Board/add_activity">
								<!-- post data board -->
								<input type="hidden" value="'.$board->board_title.'" name="board_title">
								<input type="hidden" value="'.$board->id_board.'" name="id_board">
								<!--  -->

								<div id="add-list" class="cdropdate" style="display:none;">
									<div class="row detail-list">	
										<input name="activity" type="text" class="add-detail" placeholder="Input Activity...">
										<input name="description" type="text" class="add-detail" placeholder="Input Description...">
										<i id="icon" class="fas fa-tag fa-2x" href="#" style="margin:20px 10px 10px 10px; color:#727882;"></i>
										<i id="icon" class="fas fa-calendar-alt fa-2x" href="#" style="margin:20px 10px 10px 10px; color:#727882;"></i>
									</div>
									<input type="submit" class="add-opt" style="background-color:#27B6BA; border:none; text-decoration: none; padding:5px; color:white; border-radius: 10px; font-size: 18px;">
								</div>
							</form>

						</div>';
					 } 
					 
		$output .='

					<div class="modal fade" id="DetailActivity">
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
													<label><strong>Description :</strong></label>

													<div class="form-group description_change">
														<textarea class="form-control form-desc" name="description"></textarea>

														<input type="submit" value="save" class="save-desc btn-desc" style="float:right; background-color: #0f4c75;">
													</div>
												</div>
											
											<div>
												<label style="margin-top: 30px;	"><strong>Checkbox Activity :</strong></label>
												<div class="container-fluid">
													<div class="row checklist_activity">

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
									<form method="POST" action="'.base_url().'Board/due_date">
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
									$("#red").click(function(){
										var label = $(this).attr("id");
										console.log(label);
										$.ajax ({
											url : "'.base_url().'Board/set_label",
											method: "POST",
											data : {label:label},

											success:function(data) {
												setTimeout(function(){// wait for 5 secs(2)
										           location.reload(); // then reload the page.(3)
										      }, 1); 
											}

										});
									});

									$("#yellow").click(function(){
										var label = $(this).attr("id");
										console.log(label);
										$.ajax ({
											url : "'.base_url().'Board/set_label",
											method: "POST",
											data : {label:label},

											success:function(data) {
												setTimeout(function(){// wait for 5 secs(2)
										           location.reload(); // then reload the page.(3)
										      }, 1); 
											}

										});
									});

									$("#blue").click(function(){
										var label = $(this).attr("id");
										console.log(label);
										$.ajax ({
											url : "'.base_url().'Board/set_label",
											method: "POST",
											data : {label:label},

											success:function(data) {
												setTimeout(function(){// wait for 5 secs(2)
										           location.reload(); // then reload the page.(3)
										      }, 1); 
											}

										});
									});
								});


								/*alasan pake script dibanding post = tidak ada button untuk send value*/

									$(document).ready(function() {
										$(".save-desc").click(function() {
												var description = $(".form-desc").val();							 
												console.log(description);

													$.ajax ({
														url : "'.base_url().'Board/save_description_activity",
														method: "POST",
														data : {description:description},

														success:function(data) {

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
									<form method="POST" action="'.base_url().'Board/add_checkbox">
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

						<ul style="margin-top: 50px;">
							<h5><strong>Add-On</strong></h5>
							<li class="detailActivityContent">
								<i class="fas fa-user"></i>
								<a style="margin-left:5px;">Document</a>
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

		<div class="list add_new_board" style="background-color: #006AA7;">
			<a class="add-list-btn btn btn-add" id="add-list" style="color: white;">+ Add New Board</a> 	
			<form method="post" action="'.base_url().'Board/add_board">
				<div id="add-board" class="cdropdate" style="display: none;">
					<div class="row detail-list">	
						<center><h4 style="color: white;">Add New Board!</h4></center>
						<input name="board-title" type="text" class="add-detail" placeholder="Input Here...">
						<input name="board-desc" type="text" class="add-detail" placeholder="Input Here...">

					</div>
					<input type="submit" class="add-opt" style="background-color:#27B6BA; border:none; text-decoration: none; padding:5px; color:white; border-radius: 10px; font-size: 18px;">
				</form>

		</div>
		<script>
			$(document).ready(function(){
				$(".activityDetail").click(function(){
					var id_activity = $(this).attr("id");
					var id_board = $(this).data("board");

					$.ajax({
						url: "'.base_url().'board/detail_activity",
						method: "POST",
						data: {id_activity:id_activity, id_board:id_board},
						dataType : "json",

						success: function(response){

			                        var len = response.length;

			                        if(len > 0 ) {
			                        	var des = response[0].description;
			                        	$(".form-desc").val(des);

			                        	var label = response[0].label;
			                        	$(".square").css("background-color",label);

			                        	var hari=response[0].DueDate;
			                        	$(".date").text(hari);

			                        	var title=response[0].activity_title;
			                        	$(".title_dari_modal").text(title);

			                        }
			                    }

			                }); 
				});

				$(".activityDetail").click(function(){
					var id_activity = $(this).attr("id");
					console.log(id_activity);
					$.ajax({
						url: "'.base_url().'board/detail_activity_checklist",
						method: "POST",
						data: {id_activity:id_activity},

						success: function(data){
							$(".checklist_activity").html(data);
						}

					}); 
				});


				jQuery(document).ready(function() {
					jQuery(".btn-add").on("click", function(event) {
						jQuery(this).closest("div").find(".cdropdate").toggle(200);
					});
				});
			});
		</script>
	
				'; 

		

		echo $output;
	}