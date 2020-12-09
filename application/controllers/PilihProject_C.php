<?php
class PilihProject_C extends CI_Controller {

	public function __construct()
 	{
 		parent::__construct();
  		$this->load->model("User_Model");
  		$this->load->model("Board_Model");
  		$this->load->model("PilihProject_M");
  		$this->load->model("Header_M");
  		$this->load->helper('url');
 	}



	public function Login(){

		$uname = $this->input->post("username");
		$pass = $this->input->post("password");

		$where=array(
			'username' => $uname,
			'password' => $pass
		);

		$idU = $this->User_Model->data_user($where,"user")->result();
		$datak = $this->User_Model->data_user($where,"user")->num_rows();

		foreach ($idU as $id) {
			$id_user = $id->id_user;
		}

		if ($datak > 0) {
			$data_session = array(
				'id' => $id_user,
				'username' => $uname,
			);
				
			$this->session->set_userdata($data_session);

			if ($this->session->userdata("username") == "admin") {
				redirect("Admin_C/HomeAdmin");
			}
			else {
				redirect("PilihProject_C/PilihProject");
			}
		}

		else {


		 	echo "
		 		<head>
		 		<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js'></script>
		 		<script src='https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js'></script>
		 		</head>
		 		<SCRIPT> //not showing me this
			 			$(document).ready(function() {
			 				swal('Akses Gagal!', 'Username Atau Password Salah!', 'error');

			 				setTimeout(function() {
		 						window.location.replace('http://localhost/skripsi');
		 					},2000);

			 			});  
			    </SCRIPT>";

			
		}
			
	}

	public function usernameTaken() {
		  	$username = $this->input->post("username");
		  	$where = array("username"=>$username);
		  	$res = $this->PilihProject_M->dataTakenCheck($where)->num_rows();
		  	if ($res > 0) {
		  	  echo "taken";	
		  	}else{
		  	  echo 'not_taken';
		  	}
		  	exit();	  
	}

	public function signup() {

		$username = $this->input->post("username");
		$password = $this->input->post("password");
		$phone = $this->input->post("phone");
		$email = $this->input->post("email");
		$address = $this->input->post("address");

		$config['upload_path']          = './uploads/';
		$config['allowed_types']        = 'gif|jpg|png';
	
		$this->load->library('upload', $config);

		if ($this->upload->do_upload("image")) {
			$image_data = $this->upload->data();
			$imgdata = file_get_contents($image_data['full_path']);

			date_default_timezone_set("Asia/Bangkok");
	 		$dates= date("Y-m-d");

	 		$data = array (
	 			"username" =>$username,
	 			"password" =>$password,
	 			"phone" =>$phone,
	 			"email" =>$email,
	 			"address" => $address,
	 			"Image" => $imgdata,
	 			"join_date" =>$dates
	 		);
		}

	

 		$this->PilihProject_M->insertUser($data);
 		unlink($image_data['full_path']);

 		redirect('Landing_page/index');
	}


	public function logout() {
		$this->session->unset_userdata("username");
		$this->session->unset_userdata("id");	
		redirect('Landing_page/index');
	}

	public function PilihProject() {
		
		$user= $this->session->userdata("username");
	    $where= array('username'=>$user);
	    
	    $header["data_user"] = $this->User_Model->data_user($where,'user')->result_array();


	    /*seleksi project*/
	    $id = $this->session->userdata("id");

	    /* Project yang dimiliki user */

	    $project_need["project_own"] = $this->PilihProject_M->seleksi_project($id,'project_member')->result();

	    /* Fungsi Menampilkan Teman */
	    

	     $clauseFromID1 = ('(relationship.id_user_1 = '.$id.' AND status = "Friend")');
	     $clauseFromID2 = ('(relationship.id_user_2 = '.$id.' AND status = "Friend")');


	    $project_need["friend_list"] = $this->PilihProject_M->DisplayFriend($clauseFromID1,$clauseFromID2)->result();
	    $project_need["you_uname"] = $this->session->userdata("username");

	    $clause3 = array("relationship.id_user_2" => $id,
						 "status" => "pending");

	    $project_need["friend_pending"] = $this->PilihProject_M->PendingFriend($clause3,'relationship')->result();

	  	$header["NotifCount"] = $this->Header_M->NotificationCount($id)->num_rows();

	    $this->load->view('template/header',$header);
		$this->load->view('Page/PilihProject',$project_need);
	}

	public function find_friends($search) {
		$user= $this->session->userdata("username");
	    $where= array('username'=>$user);
	    
	    $header["data_user"] = $this->User_Model->data_user($where,'user')->result();

		/*menerima post input untuk mencari teman*/
		
		$all_user_list = $this->PilihProject_M->all_user($search);

		$output = '';
		foreach($all_user_list->result_array() as $row){
             $output .= '
		<form method="post" action="friendPending">	

             <div class="container" style="margin:0 auto;">
             	<div class="row">
             		<img class="rounded-circle friend-pic" alt="100x100" src="'.base_url().'assets/image/userImg.png" data-holder-rendered="true">
             	</div>
             	
	             	<div class="row">
	             		<h3 style="font-size: 16px; font-weight: 600;" >'.$row["username"].'</h3>
	             		<input type="hidden" value="'.$row["id_user"].'" name="idTeman">
	             		<input type="hidden" value="'.$row["username"].'" name="usernameTeman">
	           			
	             	</div>
	             	<div class="row">
	             	<button type="submit" style="border-style:solid;padding:5px;border-radius:10px;background-color:#50d890;">Add As Friend</button>
             	</div>
             </div>
    	</form>
             ';
          }

        echo $output;
	}

	public function friendPending() {
		$user= $this->session->userdata("username");
	    $where= array('username'=>$user);
		$id = $this->User_Model->data_user($where,'user')->result(); 
	  	
	  	foreach ($id as $id) {
	    	$id_1=$id->id_user;
	    }

	    $id_2= $this->input->post("idTeman");
	    $usernameTeman= $this->input->post("usernameTeman");

		$data=array (
   	   		"id_user_1"=>$id_1,
   	   		"username_id_1" => $user,
   	   		"id_user_2"=>$id_2,
   	   		"username_id_2" => $usernameTeman,
   	   		"status"=>"Pending",
   	   	);


		/*Notification Friend Pending*/

		date_default_timezone_set("Asia/Bangkok");
 		$dates= date("Y-m-d H:i:s");

		$dataNotif = array(
			'id_user' => $id_2,
			'Notification_title' => "Friend Pending",
			'description' => "Anda telah menerima permintaan pertamanan dari ".$user,
			'date' =>  $dates,
			'read_status' => 0
		);

		$this->Header_M->NotificationFriendRequest($dataNotif);


   	   	$this->PilihProject_M->AddToPending($data);

   	   	redirect('PilihProject_C/PilihProject');
	}

	public function removePendingFriend() {
		$id1 = $this->input->post("id1");
		$id2 = $this->input->post("id2");

		$where = array (
			"id_user_1" => $id1,
			"id_user_2" => $id2,
			"status" => "Pending",
		);

		$this->PilihProject_M->removePendingFriend($where);

		redirect('PilihProject_C/PilihProject');

	}	

	public function addPendingFriend() {
		
		$id1 = $this->input->post("id1");
		$id2 = $this->input->post("id2");

		$where = array (
			"id_user_1" => $id1,
			"id_user_2" => $id2,
		);

		$this->PilihProject_M->addPendingFriend($where);

   	   	redirect('PilihProject_C/PilihProject');
	    
	}



	/*Add Project*/

	public function AddProject() {	

		$project_title=$this->input->post("project-title");

		$data=array (
   	   		"project_title"=>$project_title,
   	   	);

   	   	$this->PilihProject_M->add_project($data);

	   	redirect('PilihProject_C/AddProjectMember');
	   		
	}

	public function AddProjectMember() {
		/*Add user as first member in project*/
		
		$user= $this->session->userdata("username");
	    $where= array('username'=>$user);
		$id = $this->User_Model->data_user($where,'user')->result(); 
	  	
	  	foreach ($id as $id) {
	    	$clause=$id->id_user;
	    }


   	  	$id_project=$this->PilihProject_M->last_project()->result();

   	  	foreach ($id_project as $proj) {
   	  		$id_project=$proj->id_project;
   	  	} 
   		
   	   	
	   	$data_member=array (
	   	   	"id_project"=>$id_project,
	   	   	"id_user"=>$clause,
	   	   	"authority"=>"Chairman",
	   	   	
	   	);
   	   	

   	   	$this->PilihProject_M->add_project_member($data_member);
   	   	/*return to home*/

   	   	redirect('PilihProject_C/PilihProject');
	   
	}

}
	
?>