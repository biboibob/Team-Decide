<?php
class Admin_C extends CI_Controller {

	public function __construct()
 	{
 		parent::__construct();
  		$this->load->model("Admin_M");
  		$this->load->helper('url'); 

 	}

	public function HomeAdmin() {

		$data["all_project"] = $this->Admin_M->all_Project()->result();
		$data["total"] = $this->Admin_M->all_Project()->num_rows();
		$data["totalUser"] = $this->Admin_M->all_User()->num_rows();

		/*Report User*/
		$data["userReport"] = $this->Admin_M->uReport()->num_rows();
		$data["boardReport"] = $this->Admin_M->bReport()->num_rows();
		$data["activityReport"] = $this->Admin_M->aReport()->num_rows();

		/*Statistic*/
		$data["statisticUserReport"] = $this->Admin_M->showReportedUser()->result();
		$data["statisticBoardReport"] = $this->Admin_M->showReportedBoard()->result();
		$data["statisticActivityReport"] = $this->Admin_M->showReportedActivity()->result();

		$data["statisticUserIncreement"] = $this->Admin_M->statisticUserIncreement()->result();

		$data["statisticProject"] = $this->Admin_M->statisticProject()->result();


		$this->load->view("Page/Admin",$data);

	}

	public function showSelectedProject(){
		$id_project = $this->input->post("id_project");

		$dataProject['boardData'] = $this->Admin_M->boardData($id_project)->result();
		$dataProject['projectMember'] = $this->Admin_M->projectMember($id_project)->result();
		$dataProject['boardActivity'] = $this->Admin_M->boardActivity($id_project)->result();
		$dataProject['boardDocument'] = $this->Admin_M->boardDocument($id_project)->result();

		echo json_encode($dataProject);
	}

	public function showAllUser() {
		$user = $this->Admin_M->showAll()->result();
		echo json_encode($user);
	}

	public function deleteBoard() {
		$idBoard = $this->input->post("id");
		$this->Admin_M->deleteBoard($idBoard);
	}

	public function changeAuthUser() {
		$idUser = $this->input->post("idUname");
		$select = $this->input->post("selectAuth");
	
		$data = array (
			"authority"=>$select
		);	

		$where = array (
			"id_user" => $idUser
		);

		$this->Admin_M->changeAuth($data,$where);
		redirect('Admin_C/HomeAdmin/');
	}

	public function deleteUserProject() {
		$idUser = $this->input->post("id");
		$this->Admin_M->deleteUserProject($idUser);

	}

	public function deleteActivity() {
		$idActivity = $this->input->post("id");
		$this->Admin_M->deleteActivity($idActivity);

		redirect('Admin_C/HomeAdmin/');
	}

	public function deleteDocument() {
		$id_Document = $this->input->post("id");
		$this->Admin_M->deleteDocument($id_Document);

		redirect('Admin_C/HomeAdmin/');		
	}

	public function deleteUser () {
		$id = $this->input->post("id");
		$this->Admin_M->deleteUser($id);
	}

	public function showAllReportUser() {
		$userReport = $this->Admin_M->showReportedUser()->result();
		echo json_encode($userReport);
	}

	public function showAllReportBoard() {
		$boardReport = $this->Admin_M->showReportedBoard()->result();
		echo json_encode($boardReport);
	}

	public function showAllReportActivity() {
		$activityReport = $this->Admin_M->showReportedActivity()->result();
		echo json_encode($activityReport);
	}

	//Detail Report//
	public function showDetailReportUser() {
		$user = $this->input->post("user");

		$where = array (
			"reported_user" => $user
		);

		$detailUser = $this->Admin_M->showDetailReportedUser($where)->result();
		echo json_encode($detailUser);
	}

	public function showDetailReportBoard() {
		$board = $this->input->post("board");

		$where = array (
			"reported_board" => $board
		);

		$detailBoard = $this->Admin_M->showDetailReportedBoard($where)->result();
		echo json_encode($detailBoard);
	}

	public function showDetailReportActivity() {
		$activity = $this->input->post("activity");

		$where = array (
			"reported_board_activity" => $activity
		);

		$detailBoard = $this->Admin_M->showDetailReportedActivity($where)->result();
		echo json_encode($detailBoard);
	}

	//Delete From Report//

	public function deleteUserReport() {
		$user = $this->input->post("user");
		$this->Admin_M->deleteUserReport($user);
	}

	public function deleteBoardReport() {
		$board = $this->input->post("board");
		$this->Admin_M->deleteBoardReport($board);
	}

	public function deleteActivityReport() {
		$activity = $this->input->post("activity");
		$this->Admin_M->deleteActivityReport($activity);
	}



	


}
?>