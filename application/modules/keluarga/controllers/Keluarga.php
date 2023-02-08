<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Keluarga extends CI_Controller {


	function __construct(){
		parent::__construct();
		// $sess = $this->session->userdata();
		// if(!$sess['pegawai']['kar_pvl']=='U'){
		// 	redirect('auth');
		// }
         $this->load->model(array('Keluarga_model'));
		
    }

	public function index()
	{

		$data = $this->db->query('select * from keluarga')->result();
		
		$this->template->load('template','keluarga_v', $data);
	}

	

	function Anak_budi(){
		$data['data'] = $this->db->query('select * from keluarga where id_parent = 1')->result();
		$data['title'] = "ANAK BUDI";
		
		$this->template->load('template','anak_budi_v', $data);
	}

	function Cucu_budi(){
		$data['data'] = $this->db->query('select * from keluarga WHERE id_parent NOT IN ( 1,0 )')->result();
		$data['title'] = "Cucu BUDI";
		
		$this->template->load('template','cucu_budi_v', $data);
	}

	function Cucu_budi_perempuan(){
		$data['data'] = $this->db->query('select * from keluarga WHERE id_parent NOT IN ( 1,0 ) and jk = 2 ')->result();
		$data['title'] = "Cucu BUDI Perempuan";
		
		$this->template->load('template','cucu_budi_perempuan_v', $data);
	}

	function Cucu_budi_laki(){
		$data['data'] = $this->db->query('select * from keluarga WHERE id_parent NOT IN ( 1,0 ) and jk = 1')->result();
		$data['title'] = "Cucu BUDI LAKI - LAKI";
		
		$this->template->load('template','cucu_budi_laki_v', $data);
	}

	function bibi_farah(){
		$data['data'] = $this->db->query('select * from keluarga WHERE id_parent = 1 and jk = 2')->result();
		$data['title'] = "Bibi Farah";
		
		$this->template->load('template','bibi_farah_v', $data);
	}

	function sepupu_laki_laki_dari_Hani(){
		
		$data['data'] = $this->db->query('select * from keluarga WHERE id_parent NOT IN ( 1,0 ) and jk = 1')->result();
		$data['title'] = "Sepupu laki_laki dari Hani";
		
		$this->template->load('template','sepupu_laki_laki_dari_Hani_v', $data);
	}

	function crud(){
		$data["title"] = "List Data Keluarga";
        $this->template->load('template','crud_v',$data);
	}

	public function ajax_list()
    {
        header('Content-Type: application/json');
        $list = $this->Keluarga_model->get_datatables();
        $data = array();
        $no = $this->input->post('start');
        //looping data mahasiswa
        foreach ($list as $data_k) {


            $edit = "<a data-toggle='tooltip' title='Edit'  href=".base_url('Keluarga/update/'.base64_encode($data_k->id_keluarga))."><button class='btn btn-success btn-xs'><i class='fa fa-edit'></i></button></a>";
			 $delete =  "<a  data-toggle='tooltip' title='Hapus' id='$data_k->id_keluarga' class='hapus_dokumen' ><button class='btn btn-xs btn-danger'><i class='fa fa-trash'></i></button></a>";

			if($data_k->jk==1){
				$jk = "Laki-Laki";
			}else{
				$jk = "Perempuan";
			}

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $data_k->nama;
            $row[] = $jk;
          
           
           	$row[] = $edit.''.$delete;

            $data[] = $row;
        }
        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->Keluarga_model->count_all(),
            "recordsFiltered" => $this->Keluarga_model->count_filtered(),
            "data" => $data,
        );
        //output to json format
        $this->output->set_output(json_encode($output));
    }

	function tambah(){
		$data["title"] = "Tambah Data Keluarga";
		$data['keluarga'] = $this->db->query('select * from keluarga')->result();
        $this->template->load('template','tambah',$data);
	}

	function simpan(){
		$data_simpan = array(
			'nama'=>$this->input->post('nama'),
			'id_parent'=>$this->input->post('id_parent'),
			'jk'=>$this->input->post('jk'),
			'status'=>1,
		);

		$this->db->insert('keluarga',$data_simpan);

		
			$this->session->set_flashdata('status',"success");
			 $this->session->set_flashdata('message', "<b>Success <i class='fa fa-check-square-o'></i></b> Tambah data berhasil");
			 
			 redirect('Keluarga/Crud');
		 
		
	}

	function update($id){
		$id2 = base64_decode($id);
		$data["title"] = "Edit Data Keluarga";
		$data['keluarga'] = $this->db->query('select * from keluarga where id_keluarga = "'.$id2.'"')->row();
		$data['lengkap'] = $this->db->query('select * from keluarga')->result();
        $this->template->load('template','edit',$data);
	}


	function update_simpan(){
		$data_simpan = array(
			'nama'=>$this->input->post('nama'),
			'id_parent'=>$this->input->post('id_parent'),
			'jk'=>$this->input->post('jk'),
			'status'=>1,
		);

		$id_keluarga = $this->input->post('id_keluarga');

		$this->db->where('id_keluarga',$id_keluarga);
		$this->db->update('keluarga',$data_simpan);

		
			$this->session->set_flashdata('status',"success");
			 $this->session->set_flashdata('message', "<b>Success <i class='fa fa-check-square-o'></i></b> Tambah data berhasil");
			 
			 redirect('Keluarga/Crud');
	}

	function hapus(){

		$id = $this->input->post('id');

		$this->db->where('id_keluarga',$id);
		
		$sql = $this->db->delete('keluarga');
		if($sql){
			$datas= array(
				'status' =>true,
			);
		}else{
			$datas= array(
				'status' =>false,
			);
		}

		echo json_encode($datas);
	}

	function Tree(){
	
		$data["title"] = "Edit Data Keluarga";
	
        $this->template->load('template','Tree',$data);
	}

	
}
