<?php

class Profile_M extends CI_Model{

	public function TakeDataMerge($where,$table) {
		$this->db->select("*");
		$this->db->from($table);
		$this->db->where($where);
		return $this->db->get();
	}

	public function ProjectOwned($where,$table) {
		$this->db->select("*");
		$this->db->from($table);
		$this->db->join("project_member","project_member.id_user = user.id_user");
		$this->db->join("project","project.id_project = project_member.id_project");
		$this->db->where($where);
		return $this->db->get();
	}

	public function update_profile($data,$where) {
		$this->db->set($data);
		$this->db->where($where);
		$this->db->update("user");
	}
}

?>