<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Pendaftar_event extends CI_Controller
{


    function __construct(){
		parent::__construct();
        $sess = $this->session->userdata();
		if($sess['pegawai']->username){
			//redirect('auth');
		}else{
            redirect('auth');
        }
        $this->load->model(array('Pendaftar_event_M'));
		
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
        $data["title"] = "List Data  Pendaftar Event";
        $this->template->load('template','pendaftaran_event/pendaftar_event_v',$data);
     
    }


    public function ajax_list($tanggal_awal,$tanggal_akhir)
    {


       


        header('Content-Type: application/json');
        $list = $this->Pendaftar_event_M->get_datatables($tanggal_awal,$tanggal_akhir);
        $data = array();
        $no = $this->input->post('start');
        //looping data mahasiswa
        foreach ($list as $data_Pendaftar_event) {


          

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $data_Pendaftar_event->topik;
            $row[] = $data_Pendaftar_event->email;
            $row[] = $data_Pendaftar_event->nama;
            $row[] = $data_Pendaftar_event->wilayah;
            $row[] = $data_Pendaftar_event->no_wa;
           
            $row[] = $data_Pendaftar_event->kampus_impian;
            $row[] = $data_Pendaftar_event->jurusan_diinginkan;
            $row[] = $data_Pendaftar_event->asal_sekolah;

                  $row[] = $data_Pendaftar_event->provinsi;
            $row[] = $data_Pendaftar_event->sumber_informasi;
            $row[] = $data_Pendaftar_event->tingkatan;


    
         
            $row[] = TanggalIndo($data_Pendaftar_event->create_add);
            
          

            $data[] = $row;
        }
        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->Pendaftar_event_M->count_all($tanggal_awal,$tanggal_akhir),
            "recordsFiltered" => $this->Pendaftar_event_M->count_filtered($tanggal_awal,$tanggal_akhir),
            "data" => $data,
        );
        //output to json format
        $this->output->set_output(json_encode($output));
    }


    function print($tanggal_awal,$tanggal_akhir){

        $data['data'] = $this->Pendaftar_event_M->getAll($tanggal_awal,$tanggal_akhir);

        $data['tanggal_awal'] = $tanggal_awal;

        $data['tanggal_akhir'] = $tanggal_akhir;

       

       // $this->template->load('template','print_pendaftar_event',$data);

        $this->load->view('pendaftaran_event/print_pendaftar_event',$data);


    }

   



    
    
}
