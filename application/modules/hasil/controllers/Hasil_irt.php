<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Hasil_irt extends CI_Controller
{


    function __construct(){
		parent::__construct();
		// $sess = $this->session->userdata();
		// if($sess['pegawai']->username){
		// 	//redirect('auth');
		// }else{
    //         redirect('auth');
    //     }
      // $this->load->model(array('Hasil_latihan_M',));
		
    }

    
    

    // redirect if needed, otherwise display the user list
    public function index()
    {
        // echo "string";
        // die;

         $materi_id = 340;

         $event_materi = $this->db->query('select e.judul,m.materi_nama,e.desc from 
                                        event as e join materi as m 
                                        where m.materi_id = "'.$materi_id.'" and e.id_event = 49')->row();


         $url = "https://backend.edunovasi.com/api_mobile/api_irt/hitung_irt_testing/".$materi_id;

            $headers = array (
                    'Content-Type: application/json'  );

            $ch = curl_init($url);
            curl_setopt(
                $ch,
                CURLOPT_HTTPHEADER,
                array(
                    'Content-Type: application/json', // if the content type is json
                    //  'bearer: '.$token // if you need token in header
                )
            );
            //  curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
            //curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

            $result = curl_exec($ch);
            curl_close($ch);

            //   return $result;

            $data['irt'] = json_decode($result);


            // echo "<pre>";
            // print_r($data);
            // die;



            $data["title"] = "List Hasil IRT";

            $data["judul"] = $event_materi->materi_nama.' - '.$event_materi->desc;

            

            $this->load->view('hasil_irt/print_materi_irt',$data);
          //  $this->template->load('template',);

            // echo json_encode($output);
     
    }


    public function irt(){

      $materi_id = 217;

      
      $url = "https://backend.edunovasi.com/api_mobile/api_irt/hitung_irt/".$materi_id;

      $headers = array (
              'Content-Type: application/json'  );

      $ch = curl_init($url);
      curl_setopt(
          $ch,
          CURLOPT_HTTPHEADER,
          array(
              'Content-Type: application/json', // if the content type is json
              //  'bearer: '.$token // if you need token in header
          )
      );
      //  curl_setopt($ch, CURLOPT_HEADER, false);
      curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
      //curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

      $result = curl_exec($ch);
      curl_close($ch);

      //   return $result;

      $data['irt'] = json_decode($result);

  
      $this->load->view('hasil_irt/irt',$data);
    }

   


  
   

}
