<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Fcm extends CI_Controller
{


    function __construct(){
		parent::__construct();
        $sess = $this->session->userdata();
		if($sess['pegawai']->username){
			//redirect('auth');
		}else{
            redirect('auth');
        }
        $this->load->model(array('Banner_M'));
		
    }

    function index(){
        $data["title"] = "List Data Master FCM";
        $this->template->load('template','fcm/fcm_push',$data);
    }

    function blast(){

        error_reporting(0);
 
 
     
         $title = $this->input->post('title');
          $body = $this->input->post('body');

           $img = $this->input->post('img');
 
 
        $url = 'https://fcm.googleapis.com/fcm/send';
        // $id = "ftl1QFrblQM:APA91bHsQWYsrTG02YKByx7xbAtexhn0F9DHtom4pjlFqbmB9anDWCDoznOXjHyLWRypJj05SY9eWhewPkjBBIL3g1bdxQJPuSKDwsXukp-PJaoSXbLX2XKikKLB1DB_JyqEA0TmqCme";
       //    $tokenarray = array($id);
 
           // $id_token =  DB::table('token')
           // ->select('token')
           // ->get();
 
        $id_token = $this->db->query("select * from token order by id_token desc limit 999")->result();
 
 
 
 
           foreach($id_token as $token_id){
              $tokenarray[] = $token_id->token;
           }
 
           // echo "<pre>";
           // print_r($tokenarray);
           // echo "</pre>";
           // die;
 
          // $message12 = $this->emoji_replace("\xf0\x9f\x91\x8d");
 
 
           $msg = array
           (
               'name'       => "Arman",
               'number'     => "777",
           );
 
           $lightning = html_entity_decode('U+1F44D',ENT_NOQUOTES,'UTF-8');
 
            $notification = array(
             "priority"    => "high",
 
             // banner launching
            // "image"       => "https://file.edunitas.com/assets/banner/img/lg/medium-cover_2021062614305210.jpg",
             "image"         =>$img,
             "title"         => $title,
             "body"          => $body,
 
 
             //  "image"       => "https://file.edunitas.com/assets/banner/img/lg/medium-cover_2021061912075455.jpg",
 
             // "title"         => "Bayar Kuliah Dulu, Ikut Ujian Kemudian ".$message12,
             // "body"          => "Kini bayar kuliah semakin mudah, Bayar kapan saja & dimana saja !",
 
 
             //push 2
 
             // "image" => "https://file.edunitas.com/assets/banner/img/lg/medium-cover_2021061912082663.jpg",
             //   "title"         => "Yukkk... Bayar Uang Kuliah Tepat Waktu... ".$message12,
             // "body"          => "Dengan menjaga kelancaran pembayaran, anda turut serta membantu kelancaran proses perkuliahan !",
             "click_action"=>"FLUTTER_NOTIFICATION_CLICK"
          );
 
         $fields = array
         (
             'notification'         => $notification,
             'data'                 => $msg,
             'registration_ids'     => $tokenarray,
         );
 
         // echo "<pre>";
         // print_r($fields);
         // die;
 
     $fields = json_encode ( $fields );
     $headers = array (
             'Authorization: key=' . "AAAA4gMFSOY:APA91bG1RNOwF66jxVnNiPTsjclj69EHHxaSYLkSblZlpVeAfQVWDrRXCncjmqh6wnluJGoXLIPdQ-tbWwS8I8-TJ8YXQeMqogZ2gi_N5LFZ2vkuP4e8OrD2Kt5XB2HFP9Ye_ARrtR98",
             'Content-Type: application/json'
 
 
     );
     $ch = curl_init ();
     curl_setopt ( $ch, CURLOPT_URL, $url );
     curl_setopt ( $ch, CURLOPT_POST, true );
     curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
     curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
     curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );
 
     $result = curl_exec ( $ch );
     echo $result;
     curl_close ( $ch );
 
 
     //echo json_encode($result);
    

     echo "<pre>";
     print_r($result);
    // return $result;
 
 
   }


    




    
    
}
