<?php

defined('BASEPATH') or exit('No direct script access allowed');

Header('Access-Control-Allow-Origin: *'); //for allow any domain, insecure
Header('Access-Control-Allow-Headers: *'); //for allow any headers, insecure
Header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');

class Api_testimoni extends CI_Controller
{


    function __construct()
    {
        parent::__construct();
        date_default_timezone_set("Asia/Jakarta");
        // if(!$this->session->userdata(['pegawai']['kar_pvl']=='U')){
        //  redirect('auth');
        // }
        // $this->load->model(array('auth/auth_model'));

        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
    }


    function cek_email(){
        $email = $this->input->get('email');
        $query = $this->db->query('select * from testimoni where email = "'.$email.'"')->row();

        if($query){
            // udh ada email

             $datajson['status']  = 500;
            $datajson['message'] = "Email Sudah Ada"; 
         }else{
            $datajson['status']  = 200;
            $datajson['message'] = "ok"; 
         }   

            echo json_encode($datajson);
    }

    function simpan(){

         $bintang = $this->input->post('bintang');
        $email = $this->input->post('email');
        $saran = $this->input->post('saran');


        $query = $this->db->query('select * from testimoni where email = "'.$email.'"')->row();

        if($query){
            // udh ada email

             $datajson['status']  = 500;
            $datajson['message'] = "Email Sudah Ada"; 

            echo json_encode($datajson);


        }else{
            //belum ada
            $this->simpan_testi($bintang,$email,$saran);
        }
    }

    function simpan_testi($bintang,$email,$saran)
    {
        // $bintang = $this->input->post('bintang');
        // $email = $this->input->post('email');
        // $saran = $this->input->post('saran');

        $data_simpan = array(
            'bintang'=>$bintang,
            'email'=>$email,
            'saran'=>$saran,
            'crdt'=>date('Y-m-d H:i:s'),
            'status'=>'0',
        );

        $q = $this->db->insert('testimoni',$data_simpan);

        if($q){
            $datajson['status']  = 200;
            $datajson['message'] = "sukses"; 
        }else{
            $datajson['status']  = 400;
            $datajson['message'] = "gagal"; 
        }

        echo json_encode($datajson);
    }

    function tampil(){

        error_reporting(0);

         $query = $this->db->query('select t.*,l.nama from 
            testimoni as t 
            left join log_login as l on t.email = l.email
            where status = 1 group by t.email order by id_testimoni desc limit 10')->result();

         foreach($query as $q){
            $data_list[] = array(
                'email'=> $q->email,
                'bintang'=> $q->bintang,
                'saran'=> $q->saran,
               'status'=> $q->status,
               'nama'=>$q->nama,
            );
         }

         if($query){
            $data_json = array(
                'status'=>200,
                'message'=>'sukses',
                'data'=>$data_list,
            );
           
         }else{
            $data_json = array(
                'status'=>400,
                'message'=>'Data Kosong',
                'data'=>[],
            );
         }

          echo json_encode($data_json);

    }

}