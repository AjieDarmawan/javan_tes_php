<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{


    function __construct(){
		parent::__construct();
		// if(!$this->session->userdata(['pegawai']['kar_pvl']=='U')){
		// 	redirect('auth');
		// }
       // $this->load->model(array('auth_model','keluarga/Keluarga_model'));
		
    }


    

    // redirect if needed, otherwise display the user list
    public function index()
    {
       // $this->template->load('template','login');

        $this->load->view('login');
        //redirect('auth/logout', 'refresh');
    }

    // log the user in
     public function login()
    {   
        $username =  $this->input->post('username');
        $password = $this->input->post('password');


        if($username=='admin' && $password=='123456'){

           
            redirect('keluarga');
        }else{
            echo "<script> alert('User ini Tidak Berhak Untuk Akses Halaman ini');</script>";
           echo "<script>window.location.href = 'index';</script>";
        }

        
       
           

            
    }

    // log the user out
    public function logout()
    {
        $this->session->sess_destroy();
        redirect('auth', false);
    }

    function error(){
        $this->load->view('errors/html/error_404');
    }
    function tes(){

        $this->load->view('layouts/template');

    }

}
