<?php
class Document_M extends CI_Model{
		
	public function data_document($where2) {
		$this->db->select("*");
		$this->db->from("board_document");
		$this->db->where($where2);
		return $this->db->get();
	}

	public function check_document_data($where) {
		$this->db->select("*");
		$this->db->from('board_document');
		$this->db->where($where);
		return $this->db->get();
	}

	public function insert_data_content($data,$where) {
		$this->db->set($data);
		$this->db->where($where);
		$this->db->insert('board_document');
	}

	public function change_data_content($data,$where) {
		$this->db->set($data);
		$this->db->where($where);
		$this->db->update('board_document');
	} 
}
?>