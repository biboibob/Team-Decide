<?php
class Header_C extends CI_Controller {

	public function __construct() {
		parent::__construct();
  		$this->load->model("Header_M");
	}

	public function Notification() {
		$id_user = $this->input->post("id");
		$where = array("id_user" => $id_user);

		$data = $this->Header_M->NotificationModal($where)->result();

		$output = '';

		foreach($data as $row){
            $output .= '
             <div class="row" >
	             <div class="col-2" style="display: flex;align-items: center;justify-content: center">
	        ';

	        if($row->notification_title == "Friend Pending") {
	        	$output .= '<i  style="font-size:48px" class="fas fa-user-plus"></i>';	
	        }

	        else if($row->notification_title == "Project Invite") {
	        	$output .= '<i style="font-size:48px" class="fas fa-project-diagram"></i>';	
	        }

	        else if($row->notification_title == "Board Invite") {
	        	$output .= '<i style="font-size:48px" class="fas fa-list-alt"></i>';	
	        }

	        $output .= '
	            </div>
	            <div class="col-10">
	              <h5><strong>'.$row->notification_title.'</strong></h5>
	              <p style="font-size: 14px;">'.$row->description.'<br>
	              '.$row->date.'</p>
	            </div>
	          </div>
	        <hr>

        ';
    	}

    	echo $output;
	}

	public function NotificationReadChange() {
		$id_user = $this->input->post("id");
		$where = array("id_user" => $id_user);

		$data = array (
			'read_status' => 1
		);

		$data = $this->Header_M->changeReadStatus($data,$where);

	}

	public function backToProject() {
		$id_project=$this->session->userdata('projectid');
		redirect('Board/home/'.$id_project);
	}

	/*public function unsetProject() {
		$this->session->unset_userdata('projectid');
	}*/

}
?>