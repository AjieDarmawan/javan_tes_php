<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		if(!$this->session->userdata('devs')){
			redirect('auth/login');
		}
		$this->load->model(array('auth_model'));
		$this->load->library('Menu');
	}
	
	public function index()
	{
		$user = $this->session->userdata('devs');

		$permission = $this->auth_model->permission($user['id']);
		$this->session->set_userdata(array('permission'=>$permission));

		// echo '<pre>';
		// print_r($this->session->userdata());
		// exit();
		
		$showMenu = $this->menu->showMenu($permission);
		$this->session->set_userdata(array('showMenu'=>$showMenu));

		// $karyawan = array(
		// 	'nama'	=> 'admin testing'
		// );
		// $this->session->set_userdata(array('karyawan'=>$karyawan));

		if ($showMenu['all_menu']=="show"){
			redirect('Document');
		}
		else if($showMenu['policy']=="show"){
			redirect('Document/Policy/'.base64_encode('policy'));
		}
		else if($showMenu['sop']=="show"){
			redirect('Document/Sop/'.base64_encode('sop'));
		}
		else if($showMenu['sk']=="show"){
			redirect('Document/SK/'.base64_encode('sk'));
		}
		else if($showMenu['se']=="show"){
			redirect('Document/SE/'.base64_encode('se'));
		}
		else if($showMenu['memo']=="show"){
			redirect('Document/Memo/'.base64_encode('memo'));
		}
		
	}


}
