<?php

class PilihProject_M extends CI_Model{

	public function all_user($search) {
		$this->db->select('*');
		$this->db->from('user');
		$this->db->where('username', $search);
		return $this->db->get();
		
	}	

	/*Check Sign Up Form*/

	public function dataTakenCheck($where) {
		$this->db->select("*");
		$this->db->from("user");
		$this->db->where($where);
		return $this->db->get();

	}

	public function insertUser($data) {
		$this->db->insert("user",$data);
	}

	/*Seleksi Board yang dimiliki */

	public function select_all_project(){
		$this->db->select("*");
		$this->db->from('project');
		return $this->db->get();
	}

	public function seleksi_project($id,$table) {
		$this->db->select("project.*");
		$this->db->from($table);
		$this->db->where("project_member.id_user",$id);
		$this->db->join('user','user.id_user = project_member.id_user');
		$this->db->join('project','project.id_project = project_member.id_project');
		return $this->db->get();
	}

	public function ambil_id($where,$table){
		$this->db->select('id_user');
		return $this->db->get_where($table,$where);
	}

	/*Add Friend*/

	public function AddToPending($data) {
		$this->db->insert('relationship',$data);
	}
	
	/* Display Friend */
	public function DisplayFriend($clauseFromID1,$clauseFromID2) {
		$this->db->select('*');
		$this->db->from("relationship");
		$this->db->where($clauseFromID1);
		$this->db->or_Where($clauseFromID2);
		return $this->db->get();
	}

/*	public function fetchImageUser() {
		$this->db->select("id_user,Image");
		$this->db->from("user");
		return $this->db->get();
	}*/

	public function PendingFriend($clause3,$table) {
		$this->db->select('*');
		$this->db->join('user','user.id_user = relationship.id_user_2');
		return $this->db->get_where($table,$clause3);
	}

	public function removePendingFriend($where) {
		$this->db->delete("relationship",$where);
	}

	public function addPendingFriend($where) {
		$this->db->set("status", "Friend");
		$this->db->where($where);
		$this->db->update("relationship");
	}

	/*INPUT PROJECT AND INSERT USER AS HEAD*/

	public function add_project($data) {
		$this->db->insert('project',$data);	
	}

	public function last_project() {
		$this->db->select_max('id_project');
		$this->db->from('project');
		return $this->db->get();
	}

	public function get_id($where,$table) {
		$this->db->select('id_user');
		return $this->db->get_where($table,$where);
	}

	public function add_project_member($data_member) {
		$this->db->insert('project_member',$data_member);
	}
}

?>