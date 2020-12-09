<?php
class Profile_C extends CI_Controller {

	public function __construct()
 	{
 		parent::__construct();
  		$this->load->model("User_Model");
  		$this->load->model("Profile_M");
  		$this->load->model("Header_M");
  		$this->load->helper('url'); 

 	}

 	public function Home_Profile() {
 		$user= $this->session->userdata("username");
	    $where= array('username'=>$user);
 		$header["data_user"] = $this->User_Model->data_user($where,'user')->result_array();

 		$data["data_user"] = $this->Profile_M->TakeDataMerge($where,'user')->result();

 		$data["data_project"] = $this->Profile_M->ProjectOwned($where,'user')->result();

 		 $id_user = $this->session->userdata("id");

	   	$header["NotifCount"] = $this->Header_M->NotificationCount($id_user)->num_rows();

 		$this->load->view('template/header',$header);
		$this->load->view('Page/Profile',$data);
 	}

 	public function change_value() {
 		$uname = $this->input->post('uname');
 		$password = $this->input->post('password');
 		$phone = $this->input->post('phone');
 		$email = $this->input->post('email');
 		$address = $this->input->post('address');

 		$data =array(
 			"username"=>$uname,
 			"password"=>$password,
 			"phone"=>$phone,
 			"email"=>$email,
 			"address"=>$address
 		);

 		$where = array (
 			"username"=>$uname,
 		);

 		$this->Profile_M->update_profile($data,$where);

 		

 	}

}

?>