<?php
class user_model extends CI_Model{
	
	public function data_user($where,$table) {
		$this->db->select("*");
		return $this->db->get_where($table,$where);
	}

	public function user($id_friend) {
		$this->db->select("*");
		$this->db->from("user");
		$this->db->where("id_user",$id_friend);
		return $this->db->get();
	}

	public function id_only($where,$table) {
		$this->db->select("id_user");
		return $this->db->get_where($table,$where);
	}

	


}
?>