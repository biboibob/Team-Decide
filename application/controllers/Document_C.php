<?php
class Document_C extends CI_Controller {

	public function __construct()
 	{
 		parent::__construct();
  		$this->load->model("User_Model");
  		$this->load->model("Document_M");
  		$this->load->model("Header_M");
 	}

 	public function Home_Doc() {

 		$user= $this->session->userdata("username");
	    $where= array('username'=>$user);
 		$header["data_user"] = $this->User_Model->data_user($where,'user')->result_array();

 		$id_document = $this->input->post("id_doc");
 		$where2 = array('id_document'=>$id_document);
 		$data["data_doc"] = $this->Document_M->data_document($where2)->result();

 		 $id_user = $this->session->userdata("id");

	   	$header["NotifCount"] = $this->Header_M->NotificationCount($id_user)->num_rows();

 		$this->load->view('template/header',$header);
		$this->load->view('Page/Document',$data);
 	}

 	public function Save_Doc() {
 		$content = $this->input->post("val");
 		$id = $this->input->post("id_doc");

 		$where = array('id_document'=>$id);

 		$data = array(
 			'konten_dokumen'=>$content,
 			'last_update'=>date('Y-m-d H:i:s'),
 		);

 		$check_data = $this->Document_M->check_document_data($where);

 		if(empty($check_data->result())) {
			$this->Document_M->insert_data_content($data,$where);	
		}

		else {	
			$this->Document_M->change_data_content($data,$where);
		}
 	}

 	


 }

 ?>