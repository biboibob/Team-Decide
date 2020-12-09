<?php
class Admin_M extends CI_Model{

	public function all_Project(){
		$this->db->select("*");
		$this->db->from("project");
		return $this->db->get();
	}

	public function all_User() {
		$this->db->select("*");
		$this->db->from("user");
		return $this->db->get();
	}

	/*Statistic*/

	/*Count All Report*/ 
	public function uReport() {
		$this->db->select("*");
		$this->db->from("report_user");
		return $this->db->get();
	}

	public function bReport() {
		$this->db->select("*");
		$this->db->from("report_board");
		return $this->db->get();
	}

	public function aReport() {
		$this->db->select("*");
		$this->db->from("report_board_activity");
		return $this->db->get();
	}

	/*End Report*/

	/*User Increement*/

	public function statisticUserIncreement() {
		$this->db->select("count(username) as total, join_date");
		$this->db->from("user");
		$this->db->group_by("join_date");
		return $this->db->get();
	}

	/*End User Increement*/

	/*Project Statistic*/

	public function statisticProject() {
		$this->db->select("project_title, count(DISTINCT board.id_board) as totalBoard, count(DISTINCT id_activity) as totalActivity");
		$this->db->from("project");
		$this->db->join("board", "board.id_project = project.id_project", "left");
		$this->db->join("board_activity","board_activity.id_board = board.id_board", "left");
		$this->db->group_by("project_title");
		return $this->db->get();
	}

	public function boardData($id_project) {
		$this->db->select("*");
		$this->db->from("board");
		$this->db->where("id_project",$id_project);
		return $this->db->get();
	}

	public function projectMember($id_project) {
		$this->db->select("project_member.*,username");
		$this->db->from("project_member");
		$this->db->join('user','user.id_user = project_member.id_user');
		$this->db->where("project_member.id_project",$id_project);
		return $this->db->get();
	}

	public function boardActivity($id_project) {
		$this->db->select("board_activity.*,board_title");
		$this->db->from("board_activity");
		$this->db->join('board','board.id_board = board_activity.id_board');
		$this->db->where("board.id_project",$id_project);
		return $this->db->get();
	}

	public function boardDocument($id_project) {
		$this->db->select("board_document.*,board_title");
		$this->db->from("board_document");
		$this->db->join('board_activity','board_activity.id_activity = board_document.id_activity');
		$this->db->join('board','board.id_board = board_activity.id_board');
		$this->db->where("board.id_project",$id_project);
		return $this->db->get();
	}

	public function showAll() {
		$this->db->select("id_user,username,password,email");
		$this->db->from("user");
		return $this->db->get();
	}

	public function deleteBoard($idBoard) {
		$this->db->where("id_board",$idBoard);	
		$this->db->delete("board");
	}

	public function changeAuth($data,$where) {
		$this->db->where($where);
		$this->db->update("project_member",$data);
	}

	public function deleteUserProject($idUser) {
		$this->db->where("id_user",$idUser);	
		$this->db->delete("project_member");
	}

	public function deleteActivity($idActivity) {
		$this->db->where("id_activity",$idActivity);	
		$this->db->delete("board_activity");	
	}

	public function deleteDocument($id_Document) {
		$this->db->where("id_document",$id_Document);	
		$this->db->delete("board_document");
	}

	public function deleteUser($id) {
		$this->db->where("id_user",$id);	
		$this->db->delete("user");
	}

	/*report section*/

	public function showReportedUser() {
		$this->db->select("id_user_r,reported_user,COUNT(reported_user) AS total");
		$this->db->from("report_user");
		$this->db->group_by("username");
		$this->db->order_by('total', 'DESC');
		return $this->db->get();
	}

	public function showReportedBoard() {
		$this->db->select("reported_board,COUNT(reported_board) AS total");
		$this->db->from("report_board");
		$this->db->group_by("reported_board");
		$this->db->order_by('total', 'DESC');
		return $this->db->get();
	}

	public function showReportedActivity() {
		$this->db->select("reported_board_activity,COUNT(reported_board_activity) AS total");
		$this->db->from("report_board_activity");
		$this->db->group_by("reported_board_activity");
		$this->db->order_by('total', 'DESC');
		return $this->db->get();
	}

	public function showDetailReportedUser($where) {
		$this->db->select("*");
		$this->db->from("report_user");
		$this->db->where($where);
		return $this->db->get();
	}

	public function showDetailReportedBoard($where) {
		$this->db->select("*");
		$this->db->from("report_board");
		$this->db->where($where);
		return $this->db->get();
	}

	public function showDetailReportedActivity($where) {
		$this->db->select("*");
		$this->db->from("report_board_activity");
		$this->db->where($where);
		return $this->db->get();
	}

	//delete from report//

	public function deleteUserReport($user) {
		$this->db->where("reported_user",$user);
		$this->db->delete("report_user");
	}

	public function deleteBoardReport($board) {
		$this->db->where("reported_board",$board);
		$this->db->delete("report_board");
	}

	public function deleteActivityReport($activity) {
		$this->db->where("reported_board_activity",$activity);
		$this->db->delete("report_board_activity");
	}

} 

?>