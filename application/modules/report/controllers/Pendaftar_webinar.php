<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Pendaftar_webinar extends CI_Controller
{


    function __construct(){
		parent::__construct();
        $sess = $this->session->userdata();
		if($sess['pegawai']->username){
			//redirect('auth');
		}else{
            redirect('auth');
        }
        $this->load->model(array('Pendaftar_webinar_M'));
		
    }


    

    // redirect if needed, otherwise display the user list
    public function index()
    {
        
        $tanggal_awal = date('Y-m-d');
        $tanggal_akhir = date('Y-m-d');


        $tgl_a = $this->input->get('mulai');
        $tgl_b = $this->input->get('selesai');

        if($tgl_a){
            $tanggal_awal = $tgl_a;
             $tanggal_akhir = $tgl_b;

        }


        $data['tanggal_awal'] = $tanggal_awal;
        $data['tanggal_akhir'] = $tanggal_akhir;
        $data["title"] = "List Data  Pendaftar Webinar";
        $this->template->load('template','pendaftaran_webinar/pendaftar_webinar_v',$data);
     
    }


    public function ajax_list($tanggal_awal,$tanggal_akhir)
    {


       


        header('Content-Type: application/json');
        $list = $this->Pendaftar_webinar_M->get_datatables($tanggal_awal,$tanggal_akhir);
        $data = array();
        $no = $this->input->post('start');
        //looping data mahasiswa
        foreach ($list as $data_Pendaftar_webinar) {


          

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $data_Pendaftar_webinar->topik;
            $row[] = $data_Pendaftar_webinar->email;
            $row[] = $data_Pendaftar_webinar->nama;
            $row[] = $data_Pendaftar_webinar->wilayah;
            $row[] = $data_Pendaftar_webinar->no_wa;
           
            $row[] = $data_Pendaftar_webinar->kampus_impian;
            $row[] = $data_Pendaftar_webinar->jurusan_diinginkan;
            $row[] = $data_Pendaftar_webinar->asal_sekolah;

            $row[] = $data_Pendaftar_webinar->provinsi;
            $row[] = $data_Pendaftar_webinar->sumber_informasi;
            $row[] = $data_Pendaftar_webinar->tingkatan;





    
         
            $row[] = TanggalIndo($data_Pendaftar_webinar->create_add);
            
          

            $data[] = $row;
        }
        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->Pendaftar_webinar_M->count_all($tanggal_awal,$tanggal_akhir),
            "recordsFiltered" => $this->Pendaftar_webinar_M->count_filtered($tanggal_awal,$tanggal_akhir),
            "data" => $data,
        );
        //output to json format
        $this->output->set_output(json_encode($output));
    }


    function print($tanggal_awal,$tanggal_akhir){

        $data['data'] = $this->Pendaftar_webinar_M->getAll($tanggal_awal,$tanggal_akhir);

        $data['tanggal_awal'] = $tanggal_awal;

        $data['tanggal_akhir'] = $tanggal_akhir;

       

       // $this->template->load('template','print_Pendaftar_webinar',$data);

        $this->load->view('pendaftaran_webinar/print_pendaftar_webinar',$data);







    }

   



    
    
}
