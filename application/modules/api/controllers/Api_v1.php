<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Api_v1 extends CI_Controller
{


  function __construct()
  {
    parent::__construct();
    // if(!$this->session->userdata(['pegawai']['kar_pvl']=='U')){
    //  redirect('auth');
    // }
    // $this->load->model(array('auth/auth_model'));

  }

  public function lengkap()
	{

		$data = $this->db->query('select * from keluarga')->result();
		
		echo json_encode($data);
	}

	

	function Anak_budi(){
		$data = $this->db->query('select * from keluarga where id_parent = 1')->result();
	
		echo json_encode($data);
	}

	function Cucu_budi(){
		$data = $this->db->query('select * from keluarga WHERE id_parent NOT IN ( 1,0 )')->result();
		echo json_encode($data);
	}

	function Cucu_budi_perempuan(){
		$data = $this->db->query('select * from keluarga WHERE id_parent NOT IN ( 1,0 ) and jk = 2 ')->result();
		echo json_encode($data);
	}

	function Cucu_budi_laki(){
		$data = $this->db->query('select * from keluarga WHERE id_parent NOT IN ( 1,0 ) and jk = 1')->result();
		$data['title'] = "Cucu BUDI LAKI - LAKI";
		
		$this->template->load('template','cucu_budi_laki_v', $data);
	}

	function bibi_farah(){
		$data = $this->db->query('select * from keluarga WHERE id_parent = 1 and jk = 2')->result();
		$data['title'] = "Bibi Farah";
		
		$this->template->load('template','bibi_farah_v', $data);
	}

	function sepupu_laki_laki_dari_Hani(){
		
		$data = $this->db->query('select * from keluarga WHERE id_parent NOT IN ( 1,0 ) and jk = 1')->result();
		$data['title'] = "Sepupu laki_laki dari Hani";
		
		$this->template->load('template','sepupu_laki_laki_dari_Hani_v', $data);
	}


}