<?php
class board_model extends CI_Model{

	public function board_data($clause,$table) {
		$this->db->select('*');
		return $this->db->get_where($table,$clause);
	}

	public function project_data($id) {
		$this->db->select('*');
		$this->db->from("project");
		$this->db->where("id_project",$id);
		return $this->db->get();

	}

	public function activity_data($table,$clause_status_activity) {
		$this->db->select('board_activity.*');
		$this->db->join('board', 'board.id_board = board_activity.id_board');
		$this->db->where($clause_status_activity);
		return $this->db->get_where($table);
	}

	public function activity_data_done($clause_status_activity_done,$clause_status_activity_done_2) {
		$this->db->select('board_activity.*');
		$this->db->from("board_activity");
		$this->db->join('board', 'board.id_board = board_activity.id_board');
		$this->db->where($clause_status_activity_done);
		$this->db->or_where($clause_status_activity_done_2);
		$this->db->order_by("status","DESC");
		return $this->db->get();
	}

	public function checklist_activity($table) {
		$this->db->select("*");
		$this->db->from($table);
		return $this->db->get();
	}

	public function member_in_project($clause,$table) {
		$this->db->select('*');
		$this->db->join('user','user.id_user = project_member.id_user');
		return $this->db->get_where($table,$clause);
	}

	public function auth_check($auth_clause,$table) {
		$this->db->select('id_user,authority');
		return $this->db->get_where($table,$auth_clause);
	}

	public function member_in_board($clause,$table) {
		$this->db->select("id_user");
		$this->db->join("project_member","project_member.id_project_member = board_member.id_project_member");
		return $this->db->get_where($table,$clause);
	}

	public function check_authority_everyaccess_activity($where) {
		$this->db->select("*");
		return $this->db->get_where("project_member",$where);
	}

	public function board_doc($clause,$table) {
		$this->db->select("board_document.*,board_activity.*");
		$this->db->join("board_activity", "board_activity.id_board = board.id_board");
		$this->db->join("board_document", "board_document.id_activity = board_activity.id_activity");
		return $this->db->get_where($table,$clause);

	}
	/* Friend Add To Project */


	public function find_friend_to_invite($where1,$where2) {
		$this->db->select('*');
		$this->db->from("relationship");
		$this->db->where($where1);
		$this->db->or_where($where2);
		$this->db->join('user','user.id_user = relationship.id_user_2');
		return $this->db->get();
	}

	public function add_friend_to_project($data) {
		$this->db->insert('project_member',$data);
	} 

	public function all_friend_in_board($where2,$table) {
		$this->db->select('*');
		$this->db->join('project_member','project_member.id_project_member = board_member.id_project_member');
		$this->db->join('user','user.id_user = project_member.id_user');
		return $this->db->get_where($table,$where2);
	
	}

	/*Friend Add To Board*/

	public function find_friend_by_project($where,$table) {
		$this->db->select('*');
		$this->db->join('user','user.id_user = project_member.id_user');
		return $this->db->get_where($table,$where);
	}

	public function add_friend_to_board($data) {
		$this->db->insert('board_member',$data);
	}

	/* Board And All inside it */

	public function update_activity_to_done($data,$id_activity) {
		$this->db->set($data);
		$this->db->where("id_activity",$id_activity);
		$this->db->update('board_activity');
	}

	public function update_activity_to_revision($data,$id_activity) {
		$this->db->set($data);
		$this->db->where("id_activity",$id_activity);
		$this->db->update('board_activity');
	}

	public function update_activity_to_complete($data,$id_activity) {
		$this->db->set($data);
		$this->db->where("id_activity",$id_activity);
		$this->db->update('board_activity');
	}

	public function deleteActivity($where) {
		$this->db->delete('board_activity', $where); 
	}

	public function add_activity($data) {
		$this->db->insert('board_activity', $data);
	}

	public function add_new_board($data) {
		$this->db->insert('board',$data);
	}

	public function get_detail_act($id_activity) {
		$this->db->select('*');
		$this->db->from('board_activity');
  		$this->db->where('board_activity.id_activity',$id_activity);
  		$result = $this->db->get();
  		return $result;
	}

	public function detail_act_checklist($id_activity) {
		$this->db->select('*');
		$this->db->from('board_checklist_activity');
		$this->db->where('id_activity',$id_activity);
		return $this->db->get();
	}

	public function update_checkbox($data,$where) {
		$this->db->set($data);
		$this->db->where($where);
		$this->db->update('board_checklist_activity');

	}


	public function comment_activity($where) {
		$this->db->select("*");
		$this->db->from("board_comment_activity");
		$this->db->join("user", "user.username = board_comment_activity.username");
		$this->db->where($where);
		$this->db->order_by("date","DESC");
		return $this->db->get();
	}

	public function insert_comment($data) {
		$this->db->insert("board_comment_activity",$data);
	}

	public function check_data_description($id_act) {
		$this->db->select('description');
		$this->db->from('board_activity');
		$this->db->where('id_activity',$id_act);
		return $this->db->get();
	}

	public function change_data_description($description,$where) {
		$this->db->set('description',$description);
		$this->db->where($where);
		$this->db->update('board_activity'); 
	}

	public function insert_data_description($description,$where) {
		$this->db->set('description',$description);
		$this->db->where($where);
		$this->db->insert('board_activity'); 
	}

	
	public function check_data_date($id_act) {
		$this->db->select('DueDate');
		$this->db->from('board_activity');
		$this->db->where('id_activity',$id_act);
		return $this->db->get();
	}

	public function change_data_date($date,$where) {
		$this->db->set('DueDate',$date);
		$this->db->where($where);
		$this->db->update('board_activity');
	}

	public function insert_data_date($date,$where) {
		$this->db->set('DueDate',$date);
		$this->db->where($where);
		$this->db->insert('board_activity');
	}

	public function check_data_label($id_act) {
		$this->db->select('label');
		$this->db->from('board_activity');
		$this->db->where('id_activity',$id_act);
		return $this->db->get();
	}

	public function change_data_label($label,$where) {
		$this->db->set('label',$label);
		$this->db->where($where);
		$this->db->update('board_activity');
	}

	public function insert_data_label($label,$where) {
		$this->db->set('label',$label);
		$this->db->where($where);
		$this->db->insert('board_activity');
	}

	public function insert_activity($data) {
		$this->db->insert('board_checklist_activity',$data);
	}

	public function check_previllage_add_board($id_user) {
		$this->db->select('authority');
		$this->db->from('project_member');
		$this->db->where('id_user', $id);
		return $this->db->get();
	}

	/*Check new Document board*/

	public function Check_document_based_board($id_project) {
		$this->db->select("*");
		$this->db->from("project");
		$this->db->join("board","board.id_project = project.id_project");
		$this->db->where("project.id_project",$id_project);
		return $this->db->get();
	}

	public function selected_board_check_activity($board_title) {
		$this->db->select("*");
		$this->db->from("board");
		$this->db->join("board_activity","board_activity.id_board = board.id_board");
		$this->db->where("board.board_title",$board_title);
		return $this->db->get();
	}

	public function CheckIdActivity($activity) {
		$this->db->select("id_activity");
		$this->db->from("board_activity");
		$this->db->where("activity_title",$activity);
		return $this->db->get();
	}

	public function insert_document($data) {
		$this->db->insert("board_document",$data);
	}
	
	public function chat_message($where_send,$where_rec) {
		$this->db->select("*");
		$this->db->from("chat");
		$this->db->join("user", "user.id_user = chat.send_by");
		$this->db->where($where_send);
		$this->db->Or_Where($where_rec);
		$this->db->order_by('time', 'ASC');
		return $this->db->get();
	}

	public function insert_message($data) {
		$this->db->insert("chat",$data);
	}

	public function delete_every_checklist($where) {
		$this->db->where($where);
		$this->db->delete("board_checklist_activity");
	}



	///////*UPDATE EVERY ACTIVITY*/////

	public function project_activity_change($where,$table) {
		$this->db->select("*");
		$this->db->join("user", "user.username = project_change_activity.username");
		$this->db->order_by("date","DESC");
		return $this->db->get_where($table,$where);
	}

	public function insert_change_activity($data) {
		$this->db->insert("project_change_activity", $data);
	}


	public function activity_done($data) {
		$this->db->insert("project_change_activity", $data);
	}

	public function activity_revision($data) {
		$this->db->insert("project_change_activity", $data);
	}

	public function activity_complete($data) {
		$this->db->insert("project_change_activity", $data);
	}

	public function activity_delete($data) {
		$this->db->insert("project_change_activity", $data);
	}



	/*User Details*/
	
	public function DisplayFriend($clauseFromID1,$clauseFromID2) {
		$this->db->select('count(id_relation) as totalUserInDetail');
		$this->db->from("relationship");
		$this->db->where($clauseFromID1);
		$this->db->or_Where($clauseFromID2);
		return $this->db->get();
	}

	public function seleksi_project($id,$table) {
		$this->db->select("count(project_title) as totalProjectOwned");
		$this->db->from($table);
		$this->db->where("project_member.id_user",$id);
		$this->db->join('user','user.id_user = project_member.id_user');
		$this->db->join('project','project.id_project = project_member.id_project');
		return $this->db->get();
	}

	public function reportUserDetail($username) {
		$this->db->select("count(reported_user) as totalReportDetail");
		$this->db->from("report_user");
		$this->db->where("reported_user",$username);
		return $this->db->get();
	}

	/*Report function*/

	public function insertReportBoard($data) {
		$this->db->insert("report_board",$data);
	}

	public function insertReportBoardActivity($data) {
		$this->db->insert("report_board_activity",$data);
	}

	public function insertReportUser($data) {
		$this->db->insert("report_user",$data);
	}

	// Fetch Title Project, Board, ETC //

	public function projectTitle($id_project) {
		$this->db->select("project_title");
		$this->db->from("project");
		$this->db->where("id_project",$id_project);
		return $this->db->get();
	}

	public function boardTitle($id_board) {
		$this->db->select("board_title");
		$this->db->from("board");
		$this->db->where("id_board",$id_board);
		return $this->db->get();
	}

	public function id_user_in_project_member($id_project_member) {
		$this->db->select("id_user");
		$this->db->from("project_member");
		$this->db->where("id_project_member",$id_project_member);
		return $this->db->get();

	}

	/*Timeline Activity*/

	public function timeline_activity($clause) {
		$this->db->select("*");
		$this->db->from("board_activity");
		$this->db->join("board","board.id_board = board_activity.id_board");
		$this->db->where($clause);
		$this->db->order_by("DueDate","ASC");
		return $this->db->get();
	}

	public function timelineActivityClick($id_activity) {
		$this->db->select("*");
		$this->db->from("board_activity");
		$this->db->join("board","board.id_board = board_activity.id_board");
		$this->db->where("id_activity",$id_activity);
		return $this->db->get();
	}

	public function timelineMember($id_board) {
		$this->db->select("Image");
		$this->db->from("board_member");
		$this->db->join("project_member","project_member.id_project_member = board_member.id_project_member");
		$this->db->join("user","user.id_user = project_member.id_user");
		$this->db->where("id_board",$id_board);
		return $this->db->get();
	}


}

?>