<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Document extends CI_Controller {

	function __construct(){
		parent::__construct();
		if(!$this->session->userdata('devs')){
			redirect('auth/login');
		}
		error_reporting(0);
		$this->load->library('upload');
		$this->load->model('Kategori_model');
		$this->load->model('Document_model');


		
		
    }


    public function index()
	{
		$keyword = $this->input->post('search');
		$post 	 = $this->input->post();

		$data['title'] 			= 'Document';
		$data['search'] 		= $keyword;
		$data['search_box'] 	= true;
		$data['active_menu'] 	= 'list_kategori';
		$data['action'] 		= base_url('document/index');
		$data['css'] 			= array(
			'plugins/datepicker/datepicker3.css',
			'plugins/sweet-alert/sweetalert.css'
		); // css tambahan
		$data['js']				= array(
			'plugins/sweet-alert/sweetalert.min.js',
			'plugins/datepicker/bootstrap-datepicker.js'
		); // js tambahan


		$data['policy_url'] = site_url('document/getIndexPolicy/policy/'.$keyword);
		$data['sop_url'] 	= site_url('document/getIndexPolicy/sop/'.$keyword);
		$data['memo_url'] 	= site_url('document/getIndex2/memo/'.$keyword);
		$data['sk_url'] 	= site_url('document/getIndex2/sk/'.$keyword);
		$data['se_url'] 	= site_url('document/getIndex2/se/'.$keyword);

		$this->template->load('template','document/index', $data);
	}

	public function getIndexPolicy($kategori,$keyword="-")
	{
		$permission = $this->session->userdata('permission');
		$advance_search = $this->input->post();
		if($this->input->post('no_surat')!="" OR $this->input->post('perihal')!="" OR $this->input->post('keyword')!=""){
			$keyword = "-";
		}else{
			$keyword = $keyword;
		}

		$list = $this->Document_model->get_datatables($kategori,$keyword,$advance_search);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $field) {
			 
			 $dokumen = "<a data-toggle='tooltip' title='View Dokumen' target='_blank' href=".base_url('userfiles/dokumen/'.$field->document)."> <img src='".base_url('assets/img/pdf_icon.png')."' width='20px'> </a>";
			 $edit = "<a data-toggle='tooltip' title='Edit'  href=".base_url('Document/update_document/'.base64_encode($kategori).'/'.base64_encode($field->id))."><button class='btn btn-success btn-xs'><span class='glyphicon glyphicon-pencil'></span> </button></a>";
			 $delete =  "<a  data-toggle='tooltip' title='Hapus' id='$field->id' class='hapus_dokumen' ><button class='btn btn-xs btn-danger'><span class='glyphicon glyphicon-trash'></span></button></a>";

				 $no++;
				 $row = array();
				 $row[] = $no;
				 $row[] = $field->perihal;
				 $row[] = $field->tanggal_surat;
				 $row[] = $dokumen;
				 if(in_array('admin policy', $permission) OR in_array('admin sop', $permission)){
					$row[] = $edit." ".$delete;
				 }			 
				 $data[] = $row;
		 }

		 $output = array(
				 "draw" => $_POST['draw'],
				 "recordsTotal" => $this->Document_model->count_all($kategori,$keyword,$advance_search),
				 "recordsFiltered" => $this->Document_model->count_filtered($kategori,$keyword,$advance_search),
				 "data" => $data,
		 );
		 //output dalam format JSON
		 echo json_encode($output);
	}

	public function getIndex2($kategori,$keyword="-")
	{
		$permission = $this->session->userdata('permission');
		$advance_search = $this->input->post();
		if($this->input->post('no_surat')!="" OR $this->input->post('perihal')!="" OR $this->input->post('keyword')!=""){
			$keyword = "-";
		}else{
			$keyword = $keyword;
		}

		$list = $this->Document_model->get_datatables($kategori,$keyword,$advance_search);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $field) {
			 
			 $dokumen = "<a data-toggle='tooltip' title='View Dokumen' target='_blank' href=".base_url('userfiles/dokumen/'.$field->document)."> <img src='".base_url('assets/img/pdf_icon.png')."' width='20px'> </a>";
			 $edit = "<a data-toggle='tooltip' title='Edit'  href=".base_url('Document/update_document/'.base64_encode($kategori).'/'.base64_encode($field->id))."><button class='btn btn-success btn-xs'><span class='glyphicon glyphicon-pencil'></span> </button></a>";
			 $delete =  "<a  data-toggle='tooltip' title='Hapus' id='$field->id' class='hapus_dokumen' ><button class='btn btn-xs btn-danger'><span class='glyphicon glyphicon-trash'></span></button></a>";

				 $no++;
				 $row = array();
				 $row[] = $no;
				 $row[] = $field->no_surat;
				 $row[] = $field->perihal;
				 $row[] = $field->tanggal_surat;
				 $row[] = $dokumen;
				 if(in_array('admin sk', $permission) OR in_array('admin se', $permission) OR in_array('admin memo', $permission)){
					$row[] = $edit." ".$delete;
				 }				 
				 $data[] = $row;
		 }

		 $output = array(
				 "draw" => $_POST['draw'],
				 "recordsTotal" => $this->Document_model->count_all($kategori,$keyword,$advance_search),
				 "recordsFiltered" => $this->Document_model->count_filtered($kategori,$keyword,$advance_search),
				 "data" => $data,
		 );
		 //output dalam format JSON
		 echo json_encode($output);
	}

	public function advance_search()
	{
		$advace_search = $this->input->post();
		
		$data['title'] 			= 'Document';
		$data['search_box'] 	= true;
		$data['active_menu'] 	= 'list_kategori';
		$data['css'] 			= array(
			'plugins/datepicker/datepicker3.css',
			'plugins/sweet-alert/sweetalert.css'
		); // css tambahan
		$data['js']				= array(
			'plugins/sweet-alert/sweetalert.min.js',
			'plugins/datepicker/bootstrap-datepicker.js'
		); // js tambahan


		$data['policy_url'] = site_url('document/getAdvanceSearch1/policy/'.$advace_search);
		$data['sop_url'] 	= site_url('document/getAdvanceSearch1/sop/'.$advace_search);
		$data['memo_url'] 	= site_url('document/getAdvanceSearch2/memo/'.$advace_search);
		$data['sk_url'] 	= site_url('document/getAdvanceSearch2/sk/'.$advace_search);
		$data['se_url'] 	= site_url('document/getAdvanceSearch2/se/'.$advace_search);


		$this->template->load('template','document/index', $data);
	}

	function Policy()
	{
		$keyword = $this->input->post('search');

		$data['title'] 			= 'Document';
		$data['search_box'] 	= true;
		$data['search'] 		= $keyword;
		$data['active_menu'] 	= 'list_kategori';
		$data['policy_url'] 	= site_url('document/getIndexPolicy/policy/'.$keyword);
		$data['css'] 			= array(
			'plugins/datepicker/datepicker3.css',
			'plugins/sweet-alert/sweetalert.css'
		); // css tambahan
		$data['js']				= array(
			'plugins/sweet-alert/sweetalert.min.js',
			'plugins/datepicker/bootstrap-datepicker.js'
		); // js tambahan
		$data['policy'] = $this->Kategori_model->policy();
		$this->template->load('template','document/policy', $data);
	}



	function tambah($_kategori=""){

		$kategori = base64_decode($_kategori);
		if($kategori=="policy" OR $kategori=="sop"){
			$setNomor = "hidden";
		}else{
			$setNomor = "text";
		}
		// die;

		// jquery validate
		$this->rules = array(
			array(
				'field'   => 'perihal','label'   => 'Perihal Document' ,'rules'   => 'required'
			)
        );
        $this->message = array(

			'perihal'  			=> array( 'required'    => "Harus diisi"),
			'tanggal'  			=> array( 'required'    => "Harus diisi"),
			'tanggal_efektif'  	=> array( 'required'    => "Harus diisi"),
			'keyword'  			=> array( 'required'    => "Harus diisi"),
			'berkas'  			=> array( 'required'    => "Harus diisi")
		);
		$this->jquery_validation->set_rules($this->rules);
		$this->jquery_validation->set_messages($this->message);

		$data['title'] 			= 'Tambah Document '.$kategori;
		$data['search_box'] 	= false;
		$data['active_menu'] 	= 'list_kategori';
		$data['setNomor'] 		= $setNomor;
		$data['css'] 			= array(
			
			'plugins/datepicker/datepicker3.css',
			'plugins/sweet-alert/sweetalert.css'
		); // css tambahan
		$data['js']				= array(
			'js/jquery.validate.js',
			'plugins/datepicker/bootstrap-datepicker.js',
			'plugins/sweet-alert/sweetalert.min.js'
		); // js tambahan


		$data['hasil']    = $kategori;

		$data['kategori'] = $this->Kategori_model->getindex();
		$this->template->load('template','document/tambah', $data);
	}

	function document_simpan(){

		$kategori		 =  $this->input->post('kategori');
		$nomor			 =  $this->input->post('nomor');
		$tanggal 		 =  date('Y-m-d',strtotime($this->input->post('tanggal')));
		$perihal 		 =  $this->input->post('perihal');
		$tanggal_efektif =  date('Y-m-d',strtotime($this->input->post('tanggal_efektif')));
		$keyword 	     =  $this->input->post('keyword');


		$config['upload_path'] = 'userfiles/dokumen/';
		$config['allowed_types'] = 'pdf';
		
	   $this->upload->initialize($config);


		if (!$this->upload->do_upload('berkas'))
		{
			$error = array('error' => $this->upload->display_errors());
			$this->session->set_flashdata('status',"danger");
			$this->session->set_flashdata('message', $error);
			redirect(site_url('Document/tambah/'.base64_encode($kategori)));
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());
			$file = $data['upload_data']['orig_name'];
        
			$data1 = array
			(
				'kategori' 			=> $kategori,
				'no_surat' 	  		=> $nomor,
				'perihal'     		=> $perihal,
				'keyword'     		=> $keyword,
				'document'	  		=> $file,
				'tanggal_surat'		=> $tanggal,
				'tanggal_berlaku'	=> $tanggal_efektif,
				'createdBy'			=> $this->session->userdata('karyawan')['nama'],
				'createdAt'			=> date('Y-m-d H:i:s')
			);

			$this->db->insert('document',$data1);
			
			$this->session->set_flashdata('status',"success");
			$this->session->set_flashdata('message', "<b>Success <i class='fa fa-check-square-o'></i></b> Tambah data berhasil");
			
		}
			

			if($kategori=='policy')
			{
				redirect('document/Policy/cG9saWN5');
			}
			else if($kategori=='sop')
			{
				redirect('document/Sop/c29w');
			}
			else if($kategori=='sk')
			{
				redirect('document/SK/c2s=');
			}
			else if($kategori=='se')
			{
				redirect('document/SE/c2U=');
			}
			else if($kategori=='memo')
			{
				redirect('document/Memo/bWVtbw==');
			}
			


	}

	function Sop($id){
		$keyword = $this->input->post('search');
		$data['title'] 			= 'Document';
		$data['search_box'] 	= true;
		$data['search'] 		= $keyword;
		$data['active_menu'] 	= 'list_kategori';
		$data['sop_url'] 		= site_url('document/getIndexPolicy/sop/'.$keyword);
		$data['css'] 			= array(
			'plugins/datepicker/datepicker3.css',
			'plugins/sweet-alert/sweetalert.css'
		); // css tambahan
		$data['js']				= array(
			'plugins/sweet-alert/sweetalert.min.js',
			'plugins/datepicker/bootstrap-datepicker.js'
		); // js tambahan
		$data['sop'] = $this->Kategori_model->sop();


		$this->template->load('template','document/Sop', $data);
	}

	function SK($id){
		$keyword = $this->input->post('search');
		$data['title'] 			= 'Document';
		$data['search_box'] 	= true;
		$data['search'] 		= $keyword;
		$data['active_menu'] 	= 'list_kategori';
		$data['sk_url'] 		= site_url('document/getIndex2/sk/'.$keyword);
		$data['css'] 			= array(
			'plugins/datepicker/datepicker3.css',
			'plugins/sweet-alert/sweetalert.css'
		); // css tambahan
		$data['js']				= array(
			'plugins/sweet-alert/sweetalert.min.js',
			'plugins/datepicker/bootstrap-datepicker.js'
		); // js tambahan

		$data['sk'] = $this->Kategori_model->sk();
		$this->template->load('template','document/Sk', $data);
	}

	function SE($id){
		$keyword = $this->input->post('search');
		$data['title'] 			= 'Document';
		$data['search_box'] 	= true;
		$data['search'] 		= $keyword;
		$data['se_url'] 		= site_url('document/getIndex2/se/'.$keyword);
		$data['active_menu'] 	= 'list_kategori';
		$data['css'] 			= array(
			'plugins/datepicker/datepicker3.css',
			'plugins/sweet-alert/sweetalert.css'
		); // css tambahan
		$data['js']				= array(
			'plugins/sweet-alert/sweetalert.min.js',
			'plugins/datepicker/bootstrap-datepicker.js',
		); // js tambahan

		$data['se'] = $this->Kategori_model->se();
		$this->template->load('template','document/Se', $data);
	}


	function Memo($id){
		$keyword = $this->input->post('search');
		$data['title'] 			= 'Document';
		$data['search_box'] 	= true;
		$data['active_menu'] 	= 'list_kategori';
		$data['search'] 		= $keyword;
		$data['memo_url'] 		= site_url('document/getIndex2/memo/'.$keyword);
		$data['css'] 			= array(
			'plugins/datepicker/datepicker3.css',
			'plugins/sweet-alert/sweetalert.css'
		); // css tambahan
		$data['js']				= array(
			'plugins/sweet-alert/sweetalert.min.js',
			'plugins/datepicker/bootstrap-datepicker.js',
		); // js tambahan

		$data['memo'] = $this->Kategori_model->memo();
		$this->template->load('template','document/Memo', $data);
	}

	public function update_document($_kategori,$_id){
		$kategori = base64_decode($_kategori);
		$id = base64_decode($_id);

		if($kategori=="policy" OR $kategori=="sop"){
			$setNomor = "hidden";
		}else{
			$setNomor = "text";
		}

		$data['title'] 			= 'Document';
		$data['search_box'] 	= false;
		$data['active_menu'] 	= 'Dokumen';
		$data['kategori'] 		= $kategori;
		$data['setNomor'] 		= $setNomor;
		$data['css'] 			= array(
				'plugins/datepicker/datepicker3.css',
				'plugins/sweet-alert/sweetalert.css'
			); // css tambahan
			$data['js']				= array(
				'js/jquery.validate.js',
				'plugins/datepicker/bootstrap-datepicker.js',
				'plugins/sweet-alert/sweetalert.min.js'
			); // js tambahan

		

		$data['update'] = $this->Kategori_model->getindexid_document($kategori,$id);
		$this->template->load('template','document/edit_document', $data);
	}

	function document_update(){
		$kategori		 =  $this->input->post('kategori');
		$nomor			 =  $this->input->post('nomor');
		$tanggal 		 =  date('Y-m-d',strtotime($this->input->post('tanggal')));
		$perihal 		 =  $this->input->post('perihal');
		$tanggal_efektif =  date('Y-m-d',strtotime($this->input->post('tanggal_efektif')));
		$keyword 	     =  $this->input->post('keyword');

		$data1 = array
		(
			'kategori' => $kategori,
			'no_surat' 	  => $nomor,
			'perihal'     => $perihal,
			'keyword'     => $keyword,
			'tanggal_surat'=>$tanggal,
			'tanggal_berlaku'=>$tanggal_efektif
		);

		if(!empty($_FILES['replace']['size']) && $_FILES['replace']['size'] != 0){


			$config['upload_path'] = 'userfiles/dokumen/';
			$config['allowed_types'] = 'pdf';
			$this->upload->initialize($config);

			if (!$this->upload->do_upload('replace'))
			{
				$error = array('error' => $this->upload->display_errors());
				$this->session->set_flashdata('status',"danger");
				$this->session->set_flashdata('message', $error);
			}else{

				$data = array('upload_data' => $this->upload->data());
				$file = $data['upload_data']['orig_name'];
				
				if($file!=""){
					$data1['document'] = $file;
				}
			}
		}

		$this->db->where('id',$this->input->post('id'));
		$this->db->update('document',$data1);
		$this->session->set_flashdata('status',"success");
		$this->session->set_flashdata('message', "<b>Success <i class='fa fa-check-square-o'></i></b> Update data berhasil");
		
		if($kategori=='policy')
		{
			redirect('document/Policy/cG9saWN5');
		}
		else if($kategori=='sop')
		{
			redirect('document/Sop/c29w');
		}
		else if($kategori=='sk')
		{
			redirect('document/SK/c2s=');
		}
		else if($kategori=='se')
		{
			redirect('SE/c2U=');
		}
		else if($kategori=='memo')
		{
			redirect('document/Memo/bWVtbw==');
		}
	}

	function document_hapus(){
		$id = $this->input->post('id');

		$this->db->where('id',$id);
		$sql = $this->db->delete('document');
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

	function pencarian(){

			$data['title'] 			= 'Document';
			$data['active_menu'] 	= 'list_kategori';
			$data['css'] 			= array(
				'plugins/sweet-alert/sweetalert.css','plugins/select2/select2.min.css'
			); // css tambahan
			$data['js']				= array(
				'plugins/sweet-alert/sweetalert.min.js','plugins/select2/select2.full.min.js'
			); // js tambahan

			$nomor 					 = $this->input->post('nomor');
			$perihal 				 = $this->input->post('perihal');
			$tanggal_mulai   = $this->input->post('tanggal_mulai');
			$tanggal_selesai = $this->input->post('tanggal_selesai');

			$keyword								 = $this->input->post('keyword');
			$tanggal_efektif_mulai   = $this->input->post('tanggal_efektif_mulai');
			$tanggal_efektif_selesai = $this->input->post('tanggal_efektif_selesai');

			list($d,$m,$y)=explode('-',$tanggal_mulai);
			$tanggal_mulai1 = $y.'-'.$m.'-'.$d;

			list($d,$m,$y)=explode('-',$tanggal_selesai);
			$tanggal_selesai1 = $y.'-'.$m.'-'.$d;

			list($d,$m,$y)=explode('-',$tanggal_efektif_mulai);
			$tanggal_efektif_mulai1 = $y.'-'.$m.'-'.$d;

			list($d,$m,$y)=explode('-',$tanggal_efektif_selesai);
			$tanggal_efektif_selesai1 = $y.'-'.$m.'-'.$d;

		if($nomor){
				$nomor1 = "and no_surat like '%".$nomor."%'";
		}

		if($perihal){
			 $perihal1 = "and perihal like  '%".$perihal."%'";
		}

		if($keyword){
			 $keyword1 = "and keyword like  '%".$keyword."%'";
		}
		//
		

		$data['pencarian'] = $this->Kategori_model->pencarian($nomor1,$perihal1,$keyword1);

		// echo "<pre>";
		// print_r($data['pencarian']);
		// echo "</pre>";

		$this->template->load('template','document/list_pencarian', $data);
	}

	public function pencarian_search(){

			$serach = $this->input->post('search');
			$data['pencarian'] = $this->Kategori_model->search($serach);
			$this->template->load('template','document/list_pencarian', $data);


	}

	/*public function getPolicy()
	{
		$list = $this->Kategori_model->get_datatables();
		 $data = array();
		 $no = $_POST['start'];
		 foreach ($list as $field) {
			 
			//  $action = "
			//  <div class='btn-group'>
			// 		 <button type='button' class='btn btn-flat btn-default btn-sm dropdown-toggle' data-toggle='dropdown' style='width: 80px;' aria-expanded='false'>Action  <span class='caret'></span></button>
			// 				 <ul class='dropdown-menu' role='menu'>
			// 						 <li><a href=".base_url('Document/update_document/'.base64_encode('policy').'/'.base64_encode($field->id))."><span class='glyphicon glyphicon-pencil'></span> Update </a>
			// 						 </li>

			// 						 <li><a  id='$field->id' class='hapus_kategori'><span class='glyphicon glyphicon-trash'></span> Hapus</a>
			// 						 </li>

			// 				 </ul>
			//  </div>";
			 $dokumen = "<a data-toggle='tooltip' title='View Dokumen' target='_blank' href=".base_url('userfiles/dokumen/'.$field->document)."> <img src='".base_url('assets/img/pdf_icon.png')."' width='20px'> </a>";

			 $edit = "<a data-toggle='tooltip' title='Edit'  href=".base_url('Document/update_document/'.base64_encode('policy').'/'.base64_encode($field->id))."><button class='btn btn-success btn-xs'><span class='glyphicon glyphicon-pencil'></span> </button></a>";
			 $delete =  "<a  data-toggle='tooltip' title='Hapus' id='$field->id' class='hapus_policy' ><button class='btn btn-xs btn-danger'><span class='glyphicon glyphicon-trash'></span></button></a>";

				 $no++;
				 $row = array();
				 $row[] = $no;
				 //$row[] = $field->no_surat;
				 $row[] = $field->perihal;
				 $row[] = $field->tanggal_surat;
				 $row[] = $dokumen;
				 if(in_array('admin policy', $this->session->userdata('permission'))){
				 	$row[] = $edit." ".$delete;
				 }
				 				 
				 $data[] = $row;
		 }

		 $output = array(
				 "draw" => $_POST['draw'],
				 "recordsTotal" => $this->Kategori_model->count_all(),
				 "recordsFiltered" => $this->Kategori_model->count_filtered(),
				 "data" => $data,
		 );
		 //output dalam format JSON
		 echo json_encode($output);
	}*/


	/*public function getSOP()
	{
		$list = $this->SOP_Model->get_datatables();
		 $data = array();
		 $no = $_POST['start'];
		 foreach ($list as $field) {
			
			 $dokumen = "<a data-toggle='tooltip' title='View Dokumen' target='_blank' href=".base_url('userfiles/dokumen/'.$field->document)."> <img src='".base_url('assets/img/pdf_icon.png')."' width='20px'> </a>";

			 $edit = "<a data-toggle='tooltip' title='Edit'  href=".base_url('Document/update_document/'.base64_encode('sop').'/'.base64_encode($field->id))."><button class='btn btn-success btn-xs'><span class='glyphicon glyphicon-pencil'></span> </button></a>";
			 $delete =  "<a  data-toggle='tooltip' title='Hapus' id='$field->id' class='hapus_kategori' ><button class='btn btn-xs btn-danger'><span class='glyphicon glyphicon-trash'></span></button></a>";

				 $no++;
				 $row = array();
				 $row[] = $no;
				 //$row[] = $field->no_surat;
				 $row[] = $field->perihal;
				 $row[] = $field->tanggal_surat;
				 $row[] = $dokumen;
				 if(in_array('admin sop', $this->session->userdata('permission'))){
					$row[] = $edit." ".$delete;
				 }

				 $data[] = $row;
		 }

		 $output = array(
				 "draw" => $_POST['draw'],
				 "recordsTotal" => $this->SOP_Model->count_all(),
				 "recordsFiltered" => $this->SOP_Model->count_filtered(),
				 "data" => $data,
		 );
		 //output dalam format JSON
		 echo json_encode($output);
	}*/

	/*public function getSK()
	{
		$list = $this->SK_Model->get_datatables();
		 $data = array();
		 $no = $_POST['start'];
		 foreach ($list as $field) {
			 $dokumen = "<a target='_blank' href=".base_url('userfiles/dokumen/'.$field->document)." class='btn btn-primary btn-sm' >Download</a>";

			 $dokumen = "<a data-toggle='tooltip' title='View Dokumen' target='_blank' href=".base_url('userfiles/dokumen/'.$field->document)."> <img src='".base_url('assets/img/pdf_icon.png')."' width='20px'> </a>";

			 $edit = "<a data-toggle='tooltip' title='Edit'  href=".base_url('Document/update_document/'.base64_encode('sk').'/'.base64_encode($field->id))."><button class='btn btn-success btn-xs'><span class='glyphicon glyphicon-pencil'></span> </button></a>";
			 $delete =  "<a  data-toggle='tooltip' title='Hapus' id='$field->id' class='hapus_kategori' ><button class='btn btn-xs btn-danger'><span class='glyphicon glyphicon-trash'></span></button></a>";



				 $no++;
				 $row = array();
				 $row[] = $no;
				 $row[] = $field->no_surat;
				 $row[] = $field->perihal;
				 $row[] = $field->tanggal_surat;
				 $row[] = $dokumen;
				 if(in_array('admin sk', $this->session->userdata('permission'))){
				 $row[] = $edit." ".$delete;
				 }
				 $data[] = $row;
		 }

		 $output = array(
				 "draw" => $_POST['draw'],
				 "recordsTotal" => $this->SK_Model->count_all(),
				 "recordsFiltered" => $this->SK_Model->count_filtered(),
				 "data" => $data,
		 );
		 //output dalam format JSON
		 echo json_encode($output);
	}*/

	/*function getSE()
	{
		$list = $this->SE_Model->get_datatables();
		 $data = array();
		 $no = $_POST['start'];
		 foreach ($list as $field) {
			 $dokumen = "<a target='_blank' href=".base_url('userfiles/dokumen/'.$field->document)." class='btn btn-primary btn-sm' >Download</a>";
			 
			 $dokumen = "<a data-toggle='tooltip' title='View Dokumen' target='_blank' href=".base_url('userfiles/dokumen/'.$field->document)."> <img src='".base_url('assets/img/pdf_icon.png')."' width='20px'> </a>";

			 $edit = "<a data-toggle='tooltip' title='Edit'  href=".base_url('Document/update_document/'.base64_encode('se').'/'.base64_encode($field->id))."><button class='btn btn-success btn-xs'><span class='glyphicon glyphicon-pencil'></span> </button></a>";
			 $delete =  "<a  data-toggle='tooltip' title='Hapus' id='$field->id' class='hapus_kategori' ><button class='btn btn-xs btn-danger'><span class='glyphicon glyphicon-trash'></span></button></a>";

				 $no++;
				 $row = array();
				 $row[] = $no;
				 $row[] = $field->no_surat;
				 $row[] = $field->perihal;
				 $row[] = $field->tanggal_surat;
				 $row[] = $dokumen;
				 if(in_array('admin se', $this->session->userdata('permission'))){
				 $row[] = $edit." ".$delete;
				 }
				 $data[] = $row;
		 }

		 $output = array(
				 "draw" => $_POST['draw'],
				 "recordsTotal" => $this->SE_Model->count_all(),
				 "recordsFiltered" => $this->SE_Model->count_filtered(),
				 "data" => $data,
		 );
		 //output dalam format JSON
		 echo json_encode($output);
	}*/

	/*function getMemo()
	{
		$list = $this->Memo_Model->get_datatables();
		 $data = array();
		 $no = $_POST['start'];
		 foreach ($list as $field) {
			 $dokumen = "<a target='_blank' href=".base_url('userfiles/dokumen/'.$field->document)." class='btn btn-primary btn-sm' >Download</a>";

			 $dokumen = "<a data-toggle='tooltip' title='View Dokumen' target='_blank' href=".base_url('userfiles/dokumen/'.$field->document)."> <img src='".base_url('assets/img/pdf_icon.png')."' width='20px'> </a>";

			 $edit = "<a data-toggle='tooltip' title='Edit'  href=".base_url('Document/update_document/'.base64_encode('memo').'/'.base64_encode($field->id))."><button class='btn btn-success btn-xs'><span class='glyphicon glyphicon-pencil'></span> </button></a>";
			 $delete =  "<a  data-toggle='tooltip' title='Hapus' id='$field->id' class='hapus_kategori' ><button class='btn btn-xs btn-danger'><span class='glyphicon glyphicon-trash'></span></button></a>";



				 $no++;
				 $row = array();
				 $row[] = $no;
				 $row[] = $field->no_surat;
				 $row[] = $field->perihal;
				 $row[] = $field->tanggal_surat;
				 $row[] = $dokumen;
				 if(in_array('admin memo', $this->session->userdata('permission'))){
				 $row[] = $edit." ".$delete;
				 }

				 $data[] = $row;
		 }

		 $output = array(
				 "draw" => $_POST['draw'],
				 "recordsTotal" => $this->Memo_Model->count_all(),
				 "recordsFiltered" => $this->Memo_Model->count_filtered(),
				 "data" => $data,
		 );
		 //output dalam format JSON
		 echo json_encode($output);
	}*/


}
