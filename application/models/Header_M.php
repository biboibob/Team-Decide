<?php
class Header_M extends CI_Model {

	public function NotificationModal($where) {
		$this->db->select("*");
		$this->db->from("notification");
		$this->db->where($where);
		$this->db->order_by("date","DESC");
		return $this->db->get();
	}

	public function NotificationCount($id) {
		$this->db->select("*");
		$this->db->from("notification");
		$this->db->where("id_user",$id);
		$this->db->where("read_status",0);
		return $this->db->get();
	}

	public function changeReadStatus($data,$where) {
		$this->db->set($data);
		$this->db->where($where);
		$this->db->update('notification');
	}

	public function NotificationFriendRequest($dataNotif) {
		$this->db->insert("notification",$dataNotif);
	}

	public function NotificationProjectRequest($data) {
		$this->db->insert("notification",$data);
	}

	public function NotificationBoardRequest($data) {
		$this->db->insert("notification",$data);
	}
}
?>