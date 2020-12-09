
<?php
class Board extends CI_Controller {

	public function __construct()
 	{
 		parent::__construct();
  		$this->load->model("User_Model");
  		$this->load->model("board_model");
  		$this->load->model("Header_M");
  		$this->load->helper('url'); 

 	}
	
	public function logout() {
		$this->session->unset_userdata("username");
		$this->session->unset_userdata("id");	
		redirect('Landing_page/index');
	}

	public function home() {
		$this->session->unset_userdata('projectid');
		
		$user= $this->session->userdata("username");
	    $where= array('username'=>$user);
	    
	    $header["data_user"] = $this->User_Model->data_user($where,'user')->result_array();

	    /* panggil project berdasarkan id dan save id dalam session*/

	    $id=$this->uri->segment(3);
	    $this->session->set_userdata('projectid',$id);

	    /* untuk Unset ada di pilihproject_c/pilihproject ;) */

	    $id_project=$this->session->userdata('projectid');
	    $clause=array('id_project'=>$id_project);

	    /* UP the board*/
	    $board["board"] = $this->board_model->board_data($clause,'board')->result();

	    /*bring up the content*/
	    $clause_status_activity = array("status"=>0,"id_project"=>$id_project);
	    $board["board_content"] = $this->board_model->activity_data('board_activity',$clause_status_activity)->result();

	    /*done activity*/
	    $clause_status_activity_done = ('(status = 1 AND id_project = "'.$id_project.'")');
	    $clause_status_activity_done_2 = ('(status = 2 AND id_project = "'.$id_project.'")');
	   
	    $board["board_content_done"] = $this->board_model->activity_data_done($clause_status_activity_done,$clause_status_activity_done_2)->result();

	    /*bring up the checklist activity*/
	    $board["board_checklist"] = $this->board_model->checklist_activity('board_checklist_activity')->result_array();

	    /*Retrive Board Document*/
	     $board["board_doc"] = $this->board_model->board_doc($clause,'board')->result();

	    /*member in project */
	    $board["member_project"] = $this->board_model->member_in_project($clause,'project_member')->result();

	    /*Activity change*/
	    $board["activity_change"] = $this->board_model->project_activity_change($clause,'project_change_activity')->result();

	    /*Project Information*/
	    $board["project_information"] = $this->board_model->project_data($id)->result();

	    /*Timeline Activity*/
	    $board["timeline_activity"] = $this->board_model->timeline_activity($clause)->result();

	    $board["id_user"] = $this->session->userdata("id_user");
	    $board["username"] = $this->session->userdata("username");

	    $id_user = $this->session->userdata("id");

	   	$header["NotifCount"] = $this->Header_M->NotificationCount($id_user)->num_rows();

		$this->load->view('template/header',$header);
		$this->load->view('Page/Home',$board);
	}


	public function board_member_access() {

		$data = array();

		$id_board = $this->input->post('id_board');
		$clause = array ("board_member.id_board" => $id_board);

		 /*member in board */
	    $data["idMemberBoard"] = $this->board_model->member_in_board($clause,'board_member')->result_array();

	    $user= $this->session->userdata("username");
	    $where= array('username'=>$user);

	    $data["idUser"] = $this->User_Model->id_only($where,'user')->result_array();

	    echo json_encode($data);

	}

	public function board_done_access() {
		/*Allow Chairman Acces Any Activity */
		$id_project=$this->session->userdata('projectid');
	   	$id_user= $this->session->userdata("id");

	   	$where = array(
	   		"id_user"=>$id_user,
	   		"id_project"=>$id_project
	   	);

	    $data["authority"] = $this->board_model->check_authority_everyaccess_activity($where)->result_array();

	    echo json_encode($data);
	}


	/* Add Friend To Project */

	public function find_friend_to_invite(){
		$user= $this->session->userdata("username");
		$id_user= $this->session->userdata("id");

		$where1= ('(id_user_1 = '.$id_user.' AND status = "Friend")');
		$where2= ('(id_user_2 = '.$id_user.' AND status = "Friend")');
		

		$find_friend=$this->board_model->find_friend_to_invite($where1,$where2);

		$id_project=$this->session->userdata('projectid');
		$clause = array('id_project'=>$id_project);
		$member_project = $this->board_model->member_in_project($clause,'project_member');

		$auth_clause = array(
						'id_project'=>$id_project,
						'id_user'=>$id_user
						);

		$auth_check = $this->board_model->auth_check($auth_clause,'project_member');
		
		$output = '
		<div class="container" style="display:block;">
		<h3 style="font-weight:600;margin-bottom:20px;">Friend List</h3>';

		foreach($auth_check->result_array() as $row){
			$authority = $row["authority"];
		}


		if($authority != "Chairman") {
			$output .='	<div style="margin-bottom:20px;display:block;">
							<p style="text-align:center;"><span style="font-size:14px;">Sorry Youre Not A Chairman</span> <br>
								<span style="font-size:20px;font-weight:600;">Contact Chairman From Chat To Invite People.</span>	
							</p>

							<div id="messageIconFindFriend">
								<i class="far fa-comment-dots message-icon"></i>
							</div>
							
						</div>';
		}

		else {
		
		foreach($find_friend->result_array() as $row){
			if($row["id_user_1"] == $id_user) {
	           $output .= '
	             <div style="display:inline-block;margin-left:30px;">
	            	<form method="post" action="'.base_url().'board/addFriendProject">
		             	<div class="row">
		             		<img class="rounded-circle friend-pic userDetails" style="cursor:pointer;" alt="100x100" src="'.base_url().'assets/image/userImg.png" data-holder-rendered="true" data-toggle="modal" data-target="#userDetail" data-user="'.$row["id_user_2"].'">
		             	</div>
		             	
			            <div class="row" style="margin: 0 auto;">
			             		<h3 style="font-size: 16px; font-weight: 600;">'.$row["username_id_2"].'</h3>
			             		<input type="hidden" value="'.$row["id_user_2"].'" name="teman_user">	
			            </div>

			            <div class="row">
			             	<button type="submit" style="border-style:solid;padding:5px;border-radius:10px;background-color:#50d890;">Add To Project
			             	</button>
		             	</div>
	            	</form>
	    		</div>
	             ';
         	} else {
         		$output .= '
	             <div style="display:inline-block;margin-left:30px;">
	            	<form method="post" action="'.base_url().'board/addFriendProject">
		             	<div class="row">
		             		<img class="rounded-circle friend-pic userDetails" style="cursor:pointer;" alt="100x100" src="'.base_url().'assets/image/userImg.png" data-holder-rendered="true" data-toggle="modal" data-target="#userDetail" data-user="'.$row["id_user_1"].'">
		             	</div>
		             	
			            <div class="row" style="margin: 0 auto;">
			             		<h3 style="font-size: 16px; font-weight: 600;">'.$row["username_id_1"].'</h3>
			             		<input type="hidden" value="'.$row["id_user_1"].'" name="teman_user">	
			            </div>

			            <div class="row">
			             	<button type="submit" style="border-style:solid;padding:5px;border-radius:10px;background-color:#50d890;">Add To Project
			             	</button>
		             	</div>
	            	</form>
	    		</div>
	             ';
	         	}
	         }

	      }
	

          $output .= '
          <hr>
          <h3 style="font-weight:600;width:100%;margin-bottom:20px;">Friend In Project</h3>
          <div style="display:inline-block;width:100%;">
	            <div class="row">
	            	<table style="width:100%">
	            		<tr style="font-size:16px;margin-bottom:20px;">
	            			<th style="text-align:center;"></th>
	            			<th style="text-align:center;" >Username</th>
	            			<th style="text-align:center;" >Authority</th>
	            		</tr>
          ';  

        foreach ($member_project->result_array() as $values) {
          	$output .= '
	            		<tr style="font-size:16px;">
	            			<th style="text-align:center;"><img src="data:image/jpg;charset=utf8;base64,'.base64_encode($values["Image"]).'" style="width: 40px;margin-right: 10px;border-radius: 50%; cursor:pointer;" data-toggle="modal" data-target="#userDetail" data-user="'.$values["id_user"].'" class="userDetails"/></th>
	            			<th><p style="font-weight:200;text-align:center;">'.$values["username"].'</p></th>
	            			<th><p style="font-weight:200;text-align:center;">'.$values["authority"].'</p></th>
	            		</tr>

             ';
          } 
        

        $output .= '
	        		</table>
	        	</div>
        	</div>
        </div>

        <script type="text/javascript">


			$(".userDetails").click(function () {
				var idUser = $(this).data("user");
				console.log(idUser);
				$.ajax({
						url: "'.base_url().'Board/reportUser",
						method: "POST",
						data : {id:idUser},

						success:function(data) {
							$(".bodyReportUser").html(data);
					}	
				});

			});

      	</script>';

      	

        echo $output;
	}

	public function addFriendProject() {

		 $id_project=$this->session->userdata('projectid');
		 $id_user= $this->input->post("teman_user");

		 $data=array(
	    	'id_project'=>$id_project,
	    	'id_user'=>$id_user,
	    	'authority'=>'member',
	    	
	    );

		/*Notification Add To Project*/

		$project_name = $this->board_model->projectTitle($id_project)->result_array();

		$user= $this->session->userdata("username");
		$id = $this->session->userdata("id_user");

		date_default_timezone_set("Asia/Bangkok");
 		$dates= date("Y-m-d H:i:s");

 		foreach ($project_name as $val) {
 			$project_title = $val["project_title"];
 		}

			$dataNotif = array(
				'id_user' => $id_user,
				'Notification_title' => "Project Invite",
				'description' => "Anda diundang kedalam project ".$project_title. " dan diundang oleh ".$user,
				'date' =>  $dates,
				'read_status' => 0
			);

		

		$this->Header_M->NotificationProjectRequest($dataNotif);

		$this->board_model->add_friend_to_project($data);

		/*return to home*/
	   	redirect('Board/home/'.$id_project);


	}

	/*Add Friend To Board*/

	public function find_friend_to_board() {

		$id_board=$this->input->post('id_board');
		$this->session->set_userdata('id_board',$id_board);

		$id_project=$this->session->userdata('projectid');
		$where=array('project_member.id_project'=>$id_project);

		$find_friend=$this->board_model->find_friend_by_project($where,'project_member');

		$where2=array('id_board'=>$id_board);
		$friend_in_member=$this->board_model->all_friend_in_board($where2,'board_member');

		/*Auth Check*/
		$id_user= $this->session->userdata("id");
		$auth_clause = array(
						'id_project'=>$id_project,
						'id_user'=>$id_user
						);

		$auth_check = $this->board_model->auth_check($auth_clause,'project_member');

		$output = '<div class="container" style="margin:0 auto; margin-left:10px;">
				   <div class="row">
				   ';

		foreach($auth_check->result_array() as $row){
			$authority = $row["authority"];
		}


		if($authority != "Chairman") {
			$output .='	<div style="margin-bottom:20px;display:block;margin-left:20%;">
							<p style="text-align:center;"><span style="font-size:14px;">Sorry Youre Not A Chairman</span> <br>
								<span style="font-size:20px;font-weight:600;">Contact Chairman From Chat To Invite Member To Board.</span>	
							</p>

							<div id="messageIconFindFriend">
								<i class="far fa-comment-dots message-icon"></i>
							</div>
							
						</div>';
		}

		else {

		foreach($find_friend->result_array() as $row){
             $output .= '
         
            <form method="post" action="'.base_url().'board/add_friend_to_board">
	             	<div style="display:block">
	             		<img src="data:image/jpg;charset=utf8;base64,'.base64_encode($row["Image"]).'" style="width: 80px;margin-right: 10px;border-radius: 50%;cursor:pointer;" data-toggle="modal" data-target="#userDetail" data-user="'.$row["id_user"].'" class="userDetails"/>
	            	</div> 	
	            	<div style="display:block;text-align:center;">
	             		<h3 style="font-size: 16px; font-weight: 600; " >'.$row["username"].'</h3>
	             		<input type="hidden" value="'.$row["id_project_member"].'" name="teman_user">

	      			</div>
	             	<div style="display:block">
		             	<button type="submit" style="border-style:solid;padding:5px;border-radius:10px;background-color:#50d890;">
		             		Add To Board
		             	</button>
             		</div>
             	
            </form>
    	
             ';
          }
     	}

          $output .='
          </div>
          <hr>
          	<h3 style="font-weight:600;">Member In Board</h3>
          	<div class="row" style="float:left;">
          ';

          foreach($friend_in_member->result_array() as $row){
          $output .='
          	
          			<div style="display:block">
	             		<img src="data:image/jpg;charset=utf8;base64,'.base64_encode($row["Image"]).'" style="width: 80px;margin-right: 10px;border-radius: 50%;cursor:pointer;" data-toggle="modal" data-target="#userDetail" data-user="'.$row["id_user"].'" class="userDetails" />
	             		<h3 style="font-size: 16px; font-weight: 600;text-align:center; " >'.$row["username"].'</h3>
	            	</div>
	                
          ';
      	}

      	$output .='
      		</div>
      	</div>

      	<script type="text/javascript">

			$(".userDetails").click(function () {
				var idUser = $(this).data("user");
				console.log(idUser);
				$.ajax({
						url: "'.base_url().'Board/reportUser",
						method: "POST",
						data : {id:idUser},

						success:function(data) {
							$(".bodyReportUser").html(data);
					}	
				});

			});

      	</script>';
        echo $output;
		
	}

	public function add_friend_to_board() {

		$id_project=$this->session->userdata('projectid');

		$id_board=$this->session->userdata('id_board');
		$id_project_member=$this->input->post('teman_user');
	
		$data=array(
			"id_board"=>$id_board,
			"id_project_member"=>$id_project_member,
		);

		$this->board_model->add_friend_to_board($data);
		

		/*Notification Add To Project*/
		$id_user_invited = $this->board_model->id_user_in_project_member($id_project_member)->result_array();

		$board_name = $this->board_model->boardTitle($id_board)->result_array();
		$user= $this->session->userdata("username");

		date_default_timezone_set("Asia/Bangkok");
 		$dates= date("Y-m-d H:i:s");

 		foreach ($board_name as $val) {
 			$board_title = $val["board_title"];
 		}

 		foreach ($id_user_invited as $val) {
 			$id_user_invited = $val["id_user"];
 		}

			$dataNotif = array(
				'id_user' => $id_user_invited,
				'Notification_title' => "Board Invite",
				'description' => "Anda diundang kedalam board ".$board_title. " dan diundang oleh ".$user,
				'date' =>  $dates,
				'read_status' => 0
			);

		$this->Header_M->NotificationBoardRequest($dataNotif);

		$this->session->unset_userdata('id_board');
		redirect('Board/home/'.$id_project);


	}

	public function add_activity() {

   	   	$id_project=$this->session->userdata('projectid');
   	   	/*data id_board */
   	   	$id_board=$this->input->post('id_board');

   	   	/*data activity*/
	    $activity=$this->input->post('activity');
	

	    $data=array(
	    
	    	'id_board'=>$id_board,
	    	'activity_title'=>$activity,
	    	
	    );

	    $this->board_model->add_activity($data);

	    /*return to home*/
	   	redirect('Board/home/'.$id_project);	
	}

	public function add_board() {
		$user= $this->session->userdata("username");
	    $where= array('username'=>$user);
	
	    $header["data_user"] = $this->User_Model->data_user($where,'user')->result();

	    $id_project=$this->session->userdata('projectid');

   	   	/*data board*/
   	   	$board_title=$this->input->post('board-title');
 

   	   	$data=array (
   	   		'id_project'=>$id_project,
   	   		"board_title"=>$board_title,
   	   	);

   	   	$this->board_model->add_new_board($data);

   	   	/*return to home*/
	   	redirect('Board/home/'.$id_project);

	}

	/*DETAIL ACTIVITY MANAGE */

	public function detail_activity() {

		$id_board = $this->input->post('id_board');
		$id_activity = $this->input->post('id_activity');

		$data = $this->board_model->get_detail_act($id_activity)->result_array();
		echo json_encode($data);

		foreach ($data as $data) {
			$activity_title = $data["activity_title"];
		}
		

        /*Disini Set ID board/activity dan Unset ID board/activity activity ya bois!*/

        $this->session->unset_userdata('id_board');
        $this->session->set_userdata('id_board',$id_board);


        $this->session->unset_userdata('id_activity');
   		$this->session->unset_userdata('act_title');
        $this->session->set_userdata('id_activity',$id_activity);
        $this->session->set_userdata('act_title',$activity_title);
       
	}

	public function mark_as_done() {
		$id_activity = $this->session->userdata("id_activity");
		$data = array('status' => 1,);
		$this->board_model->update_activity_to_done($data,$id_activity);
	}

	public function mark_as_revision() {
		$id_activity = $this->input->post('id_activity');
		$data = array('status' => 0,);
		$this->board_model->update_activity_to_revision($data,$id_activity);
	}

	public function mark_as_complete() {
		$id_activity = $this->input->post('id_activity');
		$data = array('status' => 2,);
		$this->board_model->update_activity_to_complete($data,$id_activity);
	}

	public function delete_complete_activity() {
		$id_activity = $this->input->post('id_activity');
		$where = array ("id_activity" => $id_activity);
		$this->board_model->deleteActivity($where);
	}


	public function detail_activity_checklist() {

		$id_activity = $this->input->post('id_activity');
		$data = $this->board_model->detail_act_checklist($id_activity);
		
		$output = '';
		foreach($data->result_array() as $row){
			if($row['status'] == "1") {
             	$output .= '

           		<div class="col-11">
				    <label style=" text-decoration: line-through;">'.$row["checklist_title"].'</label>
			    </div>
			   
			    <div class="col-1 coba">
			        <input class="choose checkbox" type="checkbox" name="checks" id='.$row["id_checklist"].'  checked>
			    </div>
        ';
             
         	} else {
         		$output .= '
           		<div class="col-11">
				   	<label>'.$row["checklist_title"].'
				    </label>
			    </div>
			
			    <div class="col-1 coba">
			        <input class="choose checkbox" type="checkbox" name="checks" id='.$row["id_checklist"].'>
			    </div>
        ';
         	}
          }

      
          $output.='

				<div class="progress" style="width:100%;margin:15px 30px 15px 15px;height:16px;">
				  <div class="progress-bar" id="CheckProgress" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
				</div>
        ';
        
			

          $output .= '
           <script type="text/javascript">
           	$(document).ready(function() {

	          	$(".coba input").on("change", function(e) {
	          		e.preventDefault();
						var id  = $(this).attr("id");
						if($(this).is(":checked")) {
							var status = 1;

						}
						else {
							var status = 0;
						}
						
						$.ajax ({
							url : "'.base_url().'Board/detail_activity_checklist_2",
							method: "POST",
							data : {id_checklist:id,status:status},
								  		
							success:function(data) {
								  				
							}
						});					
				});


				$(".checkbox").on("change", function(e) { 
					e.preventDefault();
					 if ($(".checkbox:checked").length == $(".checkbox").length) {
			
						Swal.fire(
							"Well Done!",
							"All Checkbox Has Been Checked",
							"success"
						)

				    }
				});


				
					  var $checkboxes = $(".checkbox");
					  var $progress = $("#CheckProgress");
					  var total = $checkboxes.length;
					  
					  $checkboxes.on("change", function() {
					    var checked = $checkboxes.filter(":checked").length;
					    var progressWidth = (checked / total) * 100;
					    $(".progress-bar").css("width", progressWidth + "%");

						});


					  	setTimeout(function(){
							var checked = $checkboxes.filter(":checked").length;
						    var progressWidth = (checked / total) * 100;
						    $(".progress-bar").css("width", progressWidth + "%");
						}, 1); 

	
				});

				
			</script>
		';
          
        echo $output;


	}

	public function delete_every_checklist() {
		$data = $this->input->post("result");

		$where=array("id_activity" => $data);
		
		$this->board_model->delete_every_checklist($where);

		/*Activity Change*/

		date_default_timezone_set("Asia/Bangkok");
 		$dates= date("Y-m-d H:i:s");
 		$act_title=$this->session->userdata('act_title');
 		$user= $this->session->userdata("username");
 		$id_project=$this->session->userdata('projectid');

 		$data = array(
 			"id_project" => $id_project,
 			"username" => $user,
 			"change_description" => "Semua checkbox pada activity $act_title telah terselesaikan!",
 			"date" => $dates
 		);

		$this->board_model->insert_change_activity($data);	


	}


	public function detail_activity_checklist_2() {
		$id_checklist = $this->input->post('id_checklist');
		$status = $this->input->post('status');

		$where = array(
			'id_checklist' => $id_checklist,
		);

		$data = array(
			'status' => $status,
		);

		$this->board_model->update_checkbox($data,$where);

	}

	// Change value of checkbox checked and unchecked

	public function update_checkbox() {
		$id = $this->input->post('id');
		$status = $this->input->post('apply');

		$data=array(
			'status'=>$status
		);
		$this->board_model->update_checkbox($id,$data);
	}

	//Comment Section 

	public function activity_comment() {
		$id_act = $this->session->userdata('id_activity');

		$where = array("id_activity"=>$id_act);

		/*bring up comment*/
	    $data = $this->board_model->comment_activity($where)->result_array();

	    $output = '';

	    foreach ($data as $val) {
	    	$output .= '<div class="row">
	    					<div class="col-2" style="display:flex;align-items: center;justify-content: center">
	    						<img src="data:image/jpg;charset=utf8;base64,'.base64_encode($val["Image"]).'" style="width: 60px;height:60px;border-radius: 50%;" />
	    					</div>
	    					<div class="col-10">
	    						<p style="font-size: 14px;"><span>'.$val["username"].'</span><br><span>'.$val["comment"].'</span><br><span>'.$val["date"].'</span></p>
	    					</div>
	    				</div>
	    				<hr style="margin-top:0px;margin-bottom:0px;">';
	    }

	    echo $output;
	}

	public function insert_comment() {
		$id_act = $this->session->userdata('id_activity');
		$username = $this->session->userdata('username');
		$comment = $this->input->post('comment');


		date_default_timezone_set("Asia/Bangkok");
 		$dates= date("Y-m-d");

 		$data = array(
 			"id_activity"=>$id_act,
 			"username"=>$username,
 			"comment"=>$comment,
 			"date"=>$dates,
 		);

 		$this->board_model->insert_comment($data);


	}

	/*Detail Activity content*/ 

	public function save_description_activity() {
		$id_act = $this->session->userdata('id_activity');
		$description = $this->input->post('description');

		$check_data = $this->board_model->check_data_description($id_act);

		$where = array('id_activity' => $id_act);

		if(empty($check_data->result())) {
			$this->board_model->insert_data_description($description,$where);	
		}

		else {	
			$this->board_model->change_data_description($description,$where);
		}

		/*Activity Change*/

		date_default_timezone_set("Asia/Bangkok");
 		$dates= date("Y-m-d H:i:s");
 		$act_title=$this->session->userdata('act_title');
 		$user= $this->session->userdata("username");
 		$id_project=$this->session->userdata('projectid');

 		$data = array(
 			"id_project" => $id_project,
 			"username" => $user,
 			"change_description" => "Telah melakukan perubahan deskripsi pada activity $act_title",
 			"date" => $dates
 		);

		$this->board_model->insert_change_activity($data);	
	}

	public function due_date() {
		$id_act = $this->session->userdata('id_activity');
		$date = $this->input->post('date');

		$id_project=$this->session->userdata('projectid');
		$user= $this->session->userdata("username");

		$check_data = $this->board_model->check_data_date($id_act);
		
		$where = array(
				'id_activity'=>$id_act
		);

		if(empty($check_data->result())) {
			$this->board_model->insert_data_date($date,$where);	
		}

		else {	
			$this->board_model->change_data_date($date,$where);
		}

		/*Activity Change*/

		date_default_timezone_set("Asia/Bangkok");
 		$dates= date("Y-m-d H:i:s");
 		$act_title=$this->session->userdata('act_title');

 		$data = array(
 			"id_project" => $id_project,
 			"username" => $user,
 			"change_description" => "Telah melakukan perubahan tanggal pada activity $act_title ke tanggal $date",
 			"date" => $dates
 		);

		$this->board_model->insert_change_activity($data);

		redirect('Board/home/'.$id_project);
	}

	public function set_label() {
		$label = $this->input->post('label');
		$id_act = $this->session->userdata('id_activity');

		$id_project = $this->session->userdata('projectid');

		$check_data = $this->board_model->check_data_label($id_act);

		$where = array(
				'id_activity'=>$id_act
		);

		if(empty($check_data->result())) {
			$this->board_model->insert_data_label($label,$where);
		}

		else {	
			$this->board_model->change_data_label($label,$where);
		}


		/*Activity Change*/

		date_default_timezone_set("Asia/Bangkok");
 		$dates= date("Y-m-d H:i:s");
 		$act_title=$this->session->userdata('act_title');
 		$user= $this->session->userdata("username");

 		$data = array(
 			"id_project" => $id_project,
 			"username" => $user,
 			"change_description" => "Telah melakukan perubahan label pada activity $act_title menjadi label $label",
 			"date" => $dates
 		);

		$this->board_model->insert_change_activity($data);

		redirect('Board/home/'.$id_project);	
	}

	public function add_checkbox() {
		$id_act = $this->session->userdata('id_activity');
		$checkbox_title = $this->input->post('newCheckbox');

		$id_project=$this->session->userdata('projectid');

		$data = array(
			'id_activity' => $id_act,
			'checklist_title'=>$checkbox_title,
			'status'=>'0'
		);

		$this->board_model->insert_activity($data);

		/*Activity Change*/

		date_default_timezone_set("Asia/Bangkok");
 		$dates= date("Y-m-d H:i:s");
 		$act_title=$this->session->userdata('act_title');
 		$user= $this->session->userdata("username");

 		$data = array(
 			"id_project" => $id_project,
 			"username" => $user,
 			"change_description" => "Telah melakukan penambahan checkbox pada activity $act_title yaitu $checkbox_title",
 			"date" => $dates
 		);

		$this->board_model->insert_change_activity($data);

		redirect('Board/home/'.$id_project);
	}

	// Check if user member/chairman

	public function check_previllage_add_board() {
		$id_user = $this->session->userdata("id");

		$data_check = $this->board_model->check_previllage_add_board($id_user)->result_array();
		
		echo json_encode($data_check);

	}

	public function Add_document_based_board() {
 		$id_project = $this->session->userdata('projectid');

	    $data = $this->board_model->Check_document_based_board($id_project);

	    $output = '
	    	
	    <div class="container" style="padding-left:50px;padding-right:50px;">
	    	<form method="POST" action="'.base_url().'board/add_new_doc">
		    	<div class="row">
		    		<div class="col-2">
		    			<label style="font-size:13px;font-weight600;">Document Title</label>
		    		</div>
		    		<div class="col-1">
		    		<label style="font-size:14px;font-weight600;">:</label>
		    		</div>
		    		<div class="col-9">
		    			<input name="documentTitle" style="width:100%;font-size:12px;padding:5px;">
		    		</div>
		    	</div>
		    	
		    	<div class="row" style="margin-top:20px;">
		    		<div class="col-2">
		    			<label style="font-size:14px;font-weight600;">From Board</label>
		    		</div>
		    		<div class="col-1">
		    			<label style="font-size:14px;font-weight600;">:</label>
		    		</div>
		    		<div class="col-9">
		    			<select class="select-board">
		    				<option value="" disabled selected>-- Select Board --</option>
			    ';

			    foreach ($data->result_array() as $val) {
			    	$output .='
			    		<option value="'.$val["board_title"].'">'.$val["board_title"].'</option>
			    	';
			    }

			    $output .= '

	    				</select>
	    			</div>
	    		</div>

	    		<div class="row" style="margin-top:15px;">
		    		<div class="col-2">
		    			<label style="font-size:14px;font-weight600;">From Activity</label>
		    		</div>
		    		<div class="col-1">
		    			<label style="font-size:14px;font-weight600;">:</label>
		    		</div>
		    		<div class="col-9">
		    			<select class="activity-option" name="selectId">
		    				<option value="" disabled selected>-- Select Board Above --</option>
		    			</select>
		    		</div>
		    	</div>
		    		<input type="submit" value="Make New Document" style="margin-top:20px;margin-left:40%;cursor:pointer;background-color:#0079BF;border: 0;box-shadow:none;border-radius5px;padding:10px;color:white;font-size:14px;" class="btn-new-doc">
		    	</form>
	    	</div>
	    	
	    ';

	    $output .= '
	    	<script type="text/javascript">
	    		$(".select-board").change(function () {
				    var title = $(this).val();
				    console.log(title);
					    $.ajax({
					    	url: "'.base_url().'Board/Selected_Board_Doc",
							method:"POST",
							data: {title:title},
							dataType : "json",

							success:function(response) {

								var len = response.length;

								$(".activity-option").empty();
								for(var i = 0; i < len; i++) {

									var act_title = response[i]["activity_title"];
									var id = response[i]["id_activity"];

									$(".activity-option").append("<option value="+id+">"+act_title+"</option>");
                    				
								}
							}
					   	});
				});
	    	</script>
	    ';

		echo $output;
 	}

 	public function Selected_Board_Doc() {
 		$board_title = $this->input->post("title");
 		$data_check = $this->board_model->selected_board_check_activity($board_title)->result_array(); 

 		echo json_encode($data_check);
 	}

 	public function add_new_doc() {
 		$title = $this->input->post("documentTitle");
 		$id = $this->input->post("selectId");

 		$id_project = $this->session->userdata('projectid');


 		$data= array(
 			'id_activity' => $id,
 			'judul_dokumen'=> $title,
 		);

 		$this->board_model->insert_document($data);

		redirect('Board/home/'.$id_project); 		
 	}

 	public function show_message_tab() {
 		$id_friend = $this->input->post("id");
 		$name_user = $this->input->post("user");
 		
 		$id_project = $this->session->userdata('projectid');

 		// Take ID :)

 		$user= $this->session->userdata("username");
	  	$id_you = $this->session->userdata("id");

		//

 		$where_send = ('(send_by = '.$id_you.' AND send_to = '.$id_friend.' AND id_project = '.$id_project.')');
 		$where_rec = ('(send_by = '.$id_friend.' AND send_to = '.$id_you.' AND id_project = '.$id_project.')');


 		$data = $this->board_model->chat_message($where_send,$where_rec);

 
 		$output = '
 			<div class="container" style="display: inline-block;margin-left: 10px;z-index: 2;" id="FriendMessageTab">
					<div class="row" style="margin-top: 5px;">
						
						<div class="col-7" style="text-align: left;font-size: 16px;padding-top: 3px;color: white;">
								<p>'.$name_user.'</p>
						</div>
						<div id="minimize-specific-msg" class="col" style="text-align: right;font-weight: 600;color: white;margin-top: 5px;cursor: pointer;">
							<span>__</span>
						</div>
					</div>
					<div class="row chatRoom '.$name_user.'">
						<div class="card-body msg_card_body">';
			
					
					foreach ($data->result_array() as $val) {

					if($val["send_by"] != $id_you)  {
		$output .='
							<div class="d-flex justify-content-start mb-4">
								<div class="img_cont_msg" style="margin-right: 5px;">
									<img src="data:image/jpg;charset=utf8;base64,'.base64_encode($val["Image"]).'" style="width: 30px;margin-right: 10px;border-radius: 50%;" />
								</div>
								<div class="msg_cotainer" style="background-color: #d45079;color:white;padding: 3px;border-radius: 5px;padding-left:8px;">
									'.$val["message"].'
								</div><br>
								
							</div>
							<p class="msg_time" style="font-size:8px;text-align:left;margin-top:-13px;">'.$val["time"].'</p>
							';

						} else {
		
		$output .='
							<div class="d-flex justify-content-end mb-4" >
								<div class="msg_cotainer_send" style="text-align: right;background-color: #979797;color:white;padding: 3px;border-radius: 5px;padding-right:8px;">
									'.$val["message"].'
								</div>
								
								<div class="img_cont_msg" style="margin-left: 5px;">
									

								</div>
							</div> 
							<p class="msg_time" style="font-size:8px;text-align:right;margin-top:-13px;">'.$val["time"].'</p>
							';

							}
						}

		$output .='	 
						</div>
					</div>


					<form id="formSend" data-you="'.$id_you.'" data-friend="'.$id_friend.'" data-project="'.$id_project.'">
						<div class="row textareaChat">

							<textarea class="col-9" id="sendMessage"></textarea>
							<input type="submit" value="send" class="col-3">

						</div>
					</form>
				</div>

 				<script type="text/javascript">
					$(document).ready(function(){

						
						$("#minimize-specific-msg").click(function() {
							$(this).parent().parent().hide();
						});



						$("#formSend").submit(function(event) {
					      event.preventDefault();

					      var id_project = $(this).data("project");
					      var id_friend = $(this).data("friend");
					      var id_you = $(this).data("you");

					     	$.ajax({

						    	url: "'.base_url().'board/insert_message",
								method:"POST",
								data: {id_you:id_you, id_friend:id_friend, id_project:id_project, message:$("#sendMessage").val()},

								success: function(data){
					 				$("#sendMessage").val("");
					 			}

					   		});
					    });

					    
					});
				</script>
 		';



 		echo $output;
 	}

 	public function interval_chat() {

 		$id_friend = $this->input->post("id");
 		$name_user = $this->input->post("user");
 		
 		$id_project = $this->session->userdata('projectid');

 		// Take ID :)

 		$user= $this->session->userdata("username");
	    $clause= array('username'=>$user);

	    $id_temp = $this->User_Model->data_user($clause,'user')->result();

	    foreach ($id_temp as $user) {
			$id_you=($user->id_user);
		}

		//

 		$where_send = ('(send_by = '.$id_you.' AND send_to = '.$id_friend.' AND id_project = '.$id_project.')');
 		$where_rec = ('(send_by = '.$id_friend.' AND send_to = '.$id_you.' AND id_project = '.$id_project.')');


 		$data = $this->board_model->chat_message($where_send,$where_rec);

 		/*$dataImgBy = $this->User_Model->user($id_you);
 		$dataImgTo = $this->User_Model->user($id_friend);*/


 		$output = '<div class="card-body msg_card_body">';
	
					 foreach ($data->result_array() as $val) {
					 	if($val["send_by"] != $id_you) {

		$output .='	
							<div class="d-flex justify-content-start mb-4">
								<div class="img_cont_msg" style="margin-right: 5px;">
									<img src="data:image/jpg;charset=utf8;base64,'.base64_encode($val["Image"]).'" style="width: 30px;margin-right: 10px;border-radius: 50%;" />
								</div>
								<div class="msg_cotainer" style="background-color: #d45079;color:white;padding: 3px;border-radius: 5px;padding-left:8px;">
									'.$val["message"].'
								</div><br>
								
							</div>
							<p class="msg_time" style="font-size:8px;text-align:left;margin-top:-13px;">'.$val["time"].'</p>
							';

						} else {
		
		$output .='
							<div class="d-flex justify-content-end mb-4" >
								<div class="msg_cotainer_send" style="text-align: right;background-color: #979797;color:white;padding: 3px;border-radius: 5px;padding-right:8px;">
									'.$val["message"].'
								</div>
								
								<div class="img_cont_msg" style="margin-left: 5px;">
									
								</div>
							</div> 
							<p class="msg_time" style="font-size:8px;text-align:right;margin-top:-13px;">'.$val["time"].'</p>
							';

							}
						}

		$output .='</div>';

		echo $output;

 	}

 	public function insert_message() {

 		$id_you = $this->input->post("id_you");
 		$id_friend = $this->input->post("id_friend");
 		$id_project = $this->input->post("id_project");
 		$message = $this->input->post("message");
		
		date_default_timezone_set("Asia/Bangkok");
 		$date= date("Y-m-d H:i:s");

 		$data =  array (
 			'id_project'=>$id_project,
 			'send_by'=>$id_you,
 			'send_to'=>$id_friend,
 			'message'=>$message,
 			'time'=>$date,

 		);

 		$this->board_model->insert_message($data);
 	}


 	/*Report Function*/

 	public function reportBoard() {
 		date_default_timezone_set("Asia/Bangkok");
 		$date= date("Y-m-d");

 		$uname = $this->input->post("username");
 		$board = $this->input->post("board");
 		$description = $this->input->post("description");

 		$data = array (
 			"username" => $uname,
 			"reported_board" => $board,
 			"description" => $description,
 			"date" => $date
 		);

 		$this->board_model->insertReportBoard($data);

 	}

 	public function reportActivity() {
 		date_default_timezone_set("Asia/Bangkok");
 		$date= date("Y-m-d");

 		$uname = $this->input->post("username");
 		$activity = $this->input->post("activity");
 		$description = $this->input->post("description");

 		$data = array (
 			"username" => $uname,
 			"reported_board_activity" => $activity,
 			"description" => $description,
 			"date" => $date
 		);

 		$this->board_model->insertReportBoardActivity($data);
 	}

 	//report for user 

 	public function reportUser() {

 		$id = $this->input->post("id");

 		$where= array(
 			"id_user"=>$id
 		);

 		$dataUser = $this->User_Model->data_user($where,"user")->result_array(); 

 		/*Display User Friend In Detail*/

 		$clauseFromID1 = ('(relationship.id_user_1 = '.$id.' AND status = "Friend")');
	    $clauseFromID2 = ('(relationship.id_user_2 = '.$id.' AND status = "Friend")');
	    $friendList = $this->board_model->DisplayFriend($clauseFromID1,$clauseFromID2)->result();

	    //

	    /*Dispaly User Project*/

	    $projectOwned = $this->board_model->seleksi_project($id,'project_member')->result();

	    //

	    /*Display Reported User*/

	    foreach ($dataUser as $val) {
	    	$username = $val["username"];
	    }

	    $reportUserDetail = $this->board_model->reportUserDetail($username)->result();

	    //

 		$output = '
 		<div class="row">
 					';

 		
 					foreach ($dataUser as $val) {
		$output .= 	'	
						<div class="col-4" style="display: flex;justify-content: center;align-items: center;">
							<img src="data:image/jpg;charset=utf8;base64,'.base64_encode($val["Image"]).'" style="width: 100px;margin-right: 10px;border-radius: 50%;" />
						</div>
						<div class="col-8">
							
							<h3 style="font-weight: bold;">'.$val["username"].'</h3>
							<div class="row">
								<div class="col-2">
									Phone
								</div>
								<div class="col-1">
									:
								</div>
								<div class="col-9">
									0'.$val["phone"].'
								</div>
							</div>
							<div class="row">
								<div class="col-2">
									E-mail
								</div>
								<div class="col-1">
									:
								</div>
								<div class="col-9">
									'.$val["email"].'
								</div>
							</div>
							<div class="row">
								<div class="col-2">
									Address
								</div>
								<div class="col-1">
									:
								</div>
								<div class="col-9">
									'.$val["address"].'
								</div>
							</div>

						</div>
					</div>
					';
					}

			$output .= 	'
					<hr style="border:1.5px solid #D45079; ">
					<div class="row">
						<div class="col" style="text-align: center;">
							<h4>Friend</h4>';
							foreach ($friendList as $val) {
			$output .= '
							<h2>'.$val->totalUserInDetail.'</h2>
						';
						}

			$output .=	'
						</div>
						<div class="verticalSeperator"></div>
						<div class="col" style="text-align: center;">
							<h4>Project</h4>';

							foreach($projectOwned as $val) {
			$output .= '
							<h2>'.$val->totalProjectOwned.'</h2>';
						}
			$output .=  '
						</div>
						<div class="verticalSeperator"></div>
						<div class="col" style="text-align: center;">
							<h4>Report</h4>';
							foreach ($reportUserDetail as $val) {
			$output .= 
						'
							<h2>'.$val->totalReportDetail.'</h2>';
						}
			$output .= '
						</div>
					</div>
					<div class="row" style="text-align: center;display: flex;align-items: center;justify-content: center;">
						<button class="reportUserBtn" data-id="'.$id.'"><i class="fas fa-exclamation-triangle" style="margin-right: 4px;"></i>Report This User</button>
					</div>
			
				<script>

					$(".reportUserBtn").click(function () {

						var id = $(this).data("id");

						Swal.fire({
							icon: "warning",
						    title: "Report User",
						    text: "Write Your Report Below!",
						    input: "text",
						    confirmButtonText: "Report This User",
						    confirmButtonColor: "#D45079",
						    showCancelButton: true        
						}).then((result) => {
						    	console.log(result);
						    	$.ajax({
						    	url: "'.base_url().'board/insertReportUser",
								method:"POST",
								data: {id:id,desc:result.value},
									success:function(data) {
										Swal.fire(
											"Well Done!",
											"Your Report Has Been Sent!",
											"success"
										)
									}
									
						      	});
						    
						});
					
					});
				</script>';

			echo $output;
 	}


 	public function insertReportUser() {
 		$id = $this->input->post("id");

 		$where = array(
 			"id_user" => $id
 		);

 		$dataUser = $this->User_Model->data_user($where,"user")->result();

 		foreach ($dataUser as $val) {
 			$userReported = ($val->username);
 		}

 		$description = $this->input->post("desc");
 		$username = $this->session->userdata("username");

 		date_default_timezone_set("Asia/Bangkok");
 		$date= date("Y-m-d");

 		$data = array (
 			"username" => $username,
 			"reported_user" => $userReported,
 			"description" => $description,
 			"date" => $date
 		);

 		$this->board_model->insertReportUser($data);
 	}

 	/*Revision, Done, Approve*/

 	public function doneActivity() {

 		$user = $this->session->userdata("username");
 		$id_project = $this->session->userdata("projectid");
 		$act_title = $this->session->userdata('act_title');

 		/*Activity Change*/
		date_default_timezone_set("Asia/Bangkok");
 		$dates= date("Y-m-d H:i:s");

 		$data = array(
 			"id_project" => $id_project,
 			"username" => $user,
 			"change_description" => "Telah menyelesaikan activity $act_title dan menunggu penilaian dari chairman pada board done",
 			"date" => $dates
 		);

		$this->board_model->activity_done($data);

 	}

 	public function revisionActivity() {

 		$user = $this->session->userdata("username");
 		$id_project = $this->session->userdata("projectid");
 		$act_title = $this->session->userdata('act_title');

 		/*Activity Change*/
		date_default_timezone_set("Asia/Bangkok");
 		$dates= date("Y-m-d H:i:s");

 		$data = array(
 			"id_project" => $id_project,
 			"username" => $user,
 			"change_description" => "Activity $act_title masuk ke tahap revisi dan dikembalikan ke board",
 			"date" => $dates
 		);

		$this->board_model->activity_revision($data);
 	}

 	public function completeActivity() {
 		$user = $this->session->userdata("username");
 		$id_project = $this->session->userdata("projectid");
 		$act_title = $this->session->userdata('act_title');

 		/*Activity Change*/
		date_default_timezone_set("Asia/Bangkok");
 		$dates= date("Y-m-d H:i:s");

 		$data = array(
 			"id_project" => $id_project,
 			"username" => $user,
 			"change_description" => "Activity $act_title masuk ke tahap approve dari chairman",
 			"date" => $dates
 		);

		$this->board_model->activity_complete($data);
 	}

 	public function deleteActivity() {
 		$user = $this->session->userdata("username");
 		$id_project = $this->session->userdata("projectid");
 		$act_title = $this->session->userdata('act_title');

 		/*Activity Change*/
		date_default_timezone_set("Asia/Bangkok");
 		$dates= date("Y-m-d H:i:s");

 		$data = array(
 			"id_project" => $id_project,
 			"username" => $user,
 			"change_description" => "Activity $act_title telah dihapus dari project",
 			"date" => $dates
 		);

		$this->board_model->activity_delete($data);
 	}

 	/*TIMELINE*/

 	public function timelineActivity() {
 		$id_activity = $this->input->post("id_activity");

 		$activity = $this->board_model->timelineActivityClick($id_activity)->result();

 		$output = '';
 		foreach ($activity as $val) {
 		$date=date_create($val->DueDate);
 		$output .= '
 						<h1 style="font-weight: 600;">'.$val->activity_title.'</h1>
								<p style="font-size: 18px;margin-top: 20px;">'.$val->description.'</p>
								<div style="display: flex;margin-top: 40px;">
									<div style="display: inline-block;">
										<label style="font-size: 12px;">Member :</label>	
										<div class="timelineMember" style="inline-block"></div>
									</div>
									<div style="display: inline-block;margin-left: 200px;">
										<label style="font-size: 12px;">From Board :</label>	
										<p style="font-size: 16px;font-weight:600;">'.$val->board_title.'</p>
									</div>
									<div style="display: inline-block;margin-left: 200px;">
										<label style="font-size: 12px;">Deadline :</label>	
										<p class="date" style="font-size: 16px;font-weight:600;">'.date_format($date,"d/m/Y").'</p>
									</div>
								</div>';


		}

		echo $output;

 	}

 	public function timelineMember() {
 		$id_board = $this->input->post("id_board");
 		
 		$image = $this->board_model->timelineMember($id_board)->result_array();

 		$output = '';
 		foreach ($image as $val) {
 			$output .= '<img src="data:image/jpg;charset=utf8;base64,'.base64_encode($val["Image"]).'" style="width: 40px;height:40px;margin-right: 10px;border-radius: 50%;" />';
		}

		echo $output;
 	}

 	

}
	
?>