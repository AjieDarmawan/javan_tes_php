<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Users extends CI_Controller
{


    function __construct(){
		parent::__construct();
        $sess = $this->session->userdata();

        // echo "<pre>";
        // print_r($sess);
        // die;
      


  //       if($sess['pegawai']->username){
		// 	//redirect('auth');
		// }else{
  //           redirect('auth');
  //       }
        $this->load->model(array('Users_M'));
		
    }


    

    // redirect if needed, otherwise display the user list
    public function index()
    {
        
        // $sess = $this->session->userdata(['pegawai']['username']);
        // echo "<pre>";
        // print_r($sess);
        // die;
        //$data["users"] = $this->Users_M->getAll();
        $data["title"] = "List Data Master users";
        $this->template->load('template','users/users_v',$data);
     
    }


    public function ajax_list()
    {

        
        header('Content-Type: application/json');
        $list = $this->Users_M->get_datatables();
        $data = array();
        $no = $this->input->post('start');
        //looping data mahasiswa
        foreach ($list as $data_users) {


            $edit = "<a data-toggle='tooltip' title='Edit'  href=".base_url('master/users/update/'.base64_encode($data_users->id_users))."><button class='btn btn-success btn-xs'><i class='fa fa-edit'></i></button></a>";
			$delete =  "<a  data-toggle='tooltip' title='Hapus' id='$data_users->id_users' class='hapus_dokumen' ><button class='btn btn-xs btn-danger'><i class='fa fa-trash'></i></button></a>";

            if($data_users->role==1){
                $role = "Admin";
            }elseif($data_users->role==2){
                $role = "Users";
            }

            if($data_users->status==1){
                $status = "Aktif";
            }elseif($data_users->status==2){
                $status = "Non Aktif";
            }

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $data_users->username;
            $row[] = $role;
            $row[] = $status;
           	$row[] = $edit." ".$delete;

            $data[] = $row;
        }
        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->Users_M->count_all(),
            "recordsFiltered" => $this->Users_M->count_filtered(),
            "data" => $data,
        );
        //output to json format
        $this->output->set_output(json_encode($output));
    }

    function tambah(){
          //$data["users"] = $this->Users_M->getAll();
          $data["title"] = "List Data Master users";
          $this->template->load('template','users/users_tambah',$data);
    }

    function simpan(){
        $users =  $this->input->post('username');
        $password =  $this->input->post('password');
        $role =  $this->input->post('role');

        $simpan = $this->Users_M->save($users,$password,$role);

        if($simpan){

            $sess = $this->session->userdata();
            $data_log = array(
              'aktifitas'=>$sess['pegawai']->username.''.' Menambahkan User '.$users.' id '.$this->db->insert_id(),
              'datetime'=>date('Y-m-d H:i:s'),
            );
     
            $this->db->insert('log',$data_log);


           $this->session->set_flashdata('status',"success");
			$this->session->set_flashdata('message', "<b>Success <i class='fa fa-check-square-o'></i></b> Tambah data berhasil");
            
            redirect('master/users/');
        
        }else{

        }
    }

    function update($id){
         
        $data['users'] = $this->Users_M->getById(base64_decode($id));
        $data["title"] = "List Data Master users";
        $this->template->load('template','users/users_edit',$data);
    }

    function update_simpan(){
        $id_users  = $this->input->post('id_users');
        $users =  $this->input->post('username');
        $password =  $this->input->post('password');
        $role =  $this->input->post('role');


        $simpan = $this->Users_M->update($id_users,$users,$password,$role);

        if($simpan){

            $sess = $this->session->userdata();
            $data_log = array(
              'aktifitas'=>$sess['pegawai']->username.''.' Mengedit User '.$users.' id '.$id_users,
              'datetime'=>date('Y-m-d H:i:s'),
            );
     
            $this->db->insert('log',$data_log);


           $this->session->set_flashdata('status',"success");
			$this->session->set_flashdata('message', "<b>Success <i class='fa fa-check-square-o'></i></b>  Data berhasil di simpan");
            
            redirect('master/users/');
        
        }else{

        }

    }

    function hapus(){
        $id_users = $this->input->post('id');

		$this->db->where('id_users',$id_users);
		$sql = $this->db->delete('users');

        $sess = $this->session->userdata();
            $data_log = array(
              'aktifitas'=>$sess['pegawai']->username.''.' Menghapus User  id '.$id_users,
              'datetime'=>date('Y-m-d H:i:s'),
            );
     
            $this->db->insert('log',$data_log);


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

      function emoji_replace($text){
    global $emoji_maps;
    return str_ireplace($emoji_maps, array_keys($emoji_maps), $text);
  }


    function blast(){

       error_reporting(0);


    




       $url = 'https://fcm.googleapis.com/fcm/send';
       // $id = "ftl1QFrblQM:APA91bHsQWYsrTG02YKByx7xbAtexhn0F9DHtom4pjlFqbmB9anDWCDoznOXjHyLWRypJj05SY9eWhewPkjBBIL3g1bdxQJPuSKDwsXukp-PJaoSXbLX2XKikKLB1DB_JyqEA0TmqCme";
      //    $tokenarray = array($id);

          // $id_token =  DB::table('token')
          // ->select('token')
          // ->get();

       $id_token = $this->db->query("select * from token")->result();




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
            "image"       => "https://file.edunitas.com/assets/banner/img/lg/medium-cover_2021062614305210.jpg",

            "title"         => "Hallo Selamat Datang ",
            "body"          => "Terimakasih Anda Telah Menginstall Edunovasi !",


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


    echo json_encode($result);
   // return $result;


  }



    
    
}
