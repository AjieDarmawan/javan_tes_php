<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Webinar extends CI_Controller
{


    function __construct(){
		parent::__construct();
        $sess = $this->session->userdata();
		if($sess['pegawai']->username){
			//redirect('auth');
		}else{
            redirect('auth');
        }
        $this->load->model(array('Webinar_M'));
		
    }


    

    // redirect if needed, otherwise display the user list
    public function index()
    {
       // $sess = $this->session->userdata();
        // echo "<pre>";
        // print_r($sess['pegawai']->username);
        // die;
        //$data["webinar"] = $this->Webinar_M->getAll();
        $data["title"] = "List Data Master Webinar";
        $this->template->load('template','webinar/webinar_v',$data);
     
    }


    public function ajax_list()
    {


       


        header('Content-Type: application/json');
        $list = $this->Webinar_M->get_datatables();
        $data = array();
        $no = $this->input->post('start');
        //looping data mahasiswa
        foreach ($list as $data_webinar) {

            $path_webinar = base_url("assets/file_upload/webinar/".$data_webinar->img);
            $path_webianr2 = FCPATH.'assets/file_upload/webinar/'.$data_webinar->img;
         

            if($data_webinar->img){
                if (file_exists($path_webianr2) ){
                    $img_webinar = " <img widht='50' height='50' src='".$path_webinar."'>";   
                   
                }else{
                    $img_webinar =  $data_webinar->img;
                  
                }

             }else{
                $img_webinar =  $data_webinar->img;
                  
             }



             $m = $this->db->query('select publish from webinar where id_webinar="'.$data_webinar->id_webinar.'"')->row();

          

            $edit = "<a data-toggle='tooltip' title='Edit'  href=".base_url('master/webinar/update/'.base64_encode($data_webinar->id_webinar))."><button class='btn btn-success btn-xs'><i class='fa fa-edit'></i></button></a>";
           
        
            $delete =  "<a  data-toggle='tooltip' title='Hapus' id='$data_webinar->id_webinar' class='hapus_dokumen' ><button class='btn btn-xs btn-danger'><i class='fa fa-trash'></i></button></a>";

            if($m->publish==1){
                $publish = "<a data-toggle='tooltip' class='disabled' title='PUBISH'  href=".base_url('master/webinar/publish/'.base64_encode($data_webinar->id_webinar))."><button class='btn btn-info btn-xs'><i class='fa fa-edit'></i></button></a>";
		
                $tombol_aksi = $edit." ".$delete."  ".$publish;
             }else{ 
                $publish = "<a data-toggle='tooltip' title='PUBISH'  href=".base_url('master/webinar/publish/'.base64_encode($data_webinar->id_webinar))."><button class='btn btn-info btn-xs'><i class='fa fa-edit'></i></button></a>";
		
                $tombol_aksi = $edit." ".$delete." ".$publish;
             }

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $img_webinar;
            $row[] = $data_webinar->topik;
            $row[] = $data_webinar->pembicara;

            $row[] = $data_webinar->jabatan_pembicara;
            $row[] = $data_webinar->moderator;
            $row[] = $data_webinar->jabatan_moderator;

            
            $row[] = date('d-m-Y',strtotime($data_webinar->tanggal)). ' ' .$data_webinar->waktu;
           
            $row[] = $data_webinar->desc;
            
            // $sess = $this->session->userdata();
            // if($sess['pegawai']->role==1){
            //     $row[] = $edit." ".$delete." ".$publish;
            // }else{
            //     $row[] = $edit."  ".$publish;
            // }

            $sess = $this->session->userdata();
               if($sess['pegawai']->role==1){
                $row[] = $tombol_aksi;
               }else{
                   $row[] = $edit."  ".$lihat_soal;
               }
          

            $data[] = $row;
        }
        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->Webinar_M->count_all(),
            "recordsFiltered" => $this->Webinar_M->count_filtered(),
            "data" => $data,
        );
        //output to json format
        $this->output->set_output(json_encode($output));
    }

    function tambah(){
          //$data["webinar"] = $this->Webinar_M->getAll();


         // $data["kategori"] = $this->Kategori_M->getAll();


          $data["title"] = "List Data Master webinar";
          $this->template->load('template','webinar/webinar_tambah',$data);
    }

    function simpan(){

        $this->load->library('upload');


        $topik =  $this->input->post('topik');
        $tanggal =  $this->input->post('tanggal');
        $pembicara =  $this->input->post('pembicara');
        $jabatan_pembicara =  $this->input->post('jabatan_pembicara');
        $moderator =  $this->input->post('moderator');
        $jabatan_moderator = $this->input->post('jabatan_moderator');
        $link = $this->input->post('link');
        $desc = $this->input->post('desc');

        $waktu_mulai_jam = $this->input->post('waktu_mulai_jam');
        $waktu_mulai_menit = $this->input->post('waktu_mulai_menit');

        $waktu_selesai_jam = $this->input->post('waktu_selesai_jam');
        $waktu_selesai_menit = $this->input->post('waktu_selesai_menit');
        $share_link = $this->input->post('share_link');



        $config_img['upload_path']          = './assets/file_upload/webinar/';
        $config_img['allowed_types']        = 'gif|jpg|png|jpeg';
        $img_gambar                         = "webinar".date('Ymd').mt_rand(1000, 9999);
        $config_img['file_name']            = $img_gambar;
     
  
        $this->upload->initialize($config_img);
  
        if ($this->upload->do_upload('img')){
  
          $data = array('upload_data' => $this->upload->data());
    
  
              $filename= $data['upload_data']['file_name'];
           

              $data_webinar = array(
                'topik'=>$topik,
                'tanggal'=>$tanggal,
                'pembicara'=>$pembicara,
                'desc'=>$desc,
                'jabatan_pembicara'=>$jabatan_pembicara,
                'moderator'=>$moderator,
                'jabatan_moderator'=>$jabatan_moderator,
                'link'=>$link,
                'moderator'=>$moderator,
                'moderator'=>$moderator,
                'publish'=>0,
                'img'=>$filename,
                'share_link'=>$share_link,
                'create_add'=>date('Y-m-d H:i:s'),
                'waktu'=>$waktu_mulai_jam.':'.$waktu_mulai_menit .'-'. $waktu_selesai_jam.':'.$waktu_selesai_menit
    
            );
  
          
        }else{
          $error = array('error' => $this->upload->display_errors());
        
        }





        

       $simpan = $this->db->insert('webinar',$data_webinar);

       $sess = $this->session->userdata();
       $data_log = array(
         'aktifitas'=>$sess['pegawai']->username.''.' Menambahkan webinar '.$topik.' id '.$this->db->insert_id(),
         'datetime'=>date('Y-m-d H:i:s'),
       );

       $this->db->insert('log',$data_log);



      

        if($simpan){
           $this->session->set_flashdata('status',"success");
			$this->session->set_flashdata('message', "<b>Success <i class='fa fa-check-square-o'></i></b> Tambah data berhasil");
            
            redirect('master/webinar/');
        
        }else{

        }
    }

    function update($id){

      
        $data['webinar'] = $this->Webinar_M->getById(base64_decode($id));

       
        $data["title"] = "List Data Master webinar";
        $this->template->load('template','webinar/webinar_edit',$data);
    }

    function update_simpan(){
        $this->load->library('upload');
        
        $id_webinar  = $this->input->post('id_webinar');
        $topik =  $this->input->post('topik');
        $tanggal =  $this->input->post('tanggal');
        $pembicara =  $this->input->post('pembicara');
        $jabatan_pembicara =  $this->input->post('jabatan_pembicara');
        $moderator =  $this->input->post('moderator');
        $jabatan_moderator = $this->input->post('jabatan_moderator');
        $link = $this->input->post('link');
        $desc = $this->input->post('desc');

        $waktu_mulai_jam = $this->input->post('waktu_mulai_jam');
        $waktu_mulai_menit = $this->input->post('waktu_mulai_menit');

        $waktu_selesai_jam = $this->input->post('waktu_selesai_jam');
        $waktu_selesai_menit = $this->input->post('waktu_selesai_menit');
        $share_link = $this->input->post('share_link');


        $config_img['upload_path']          = './assets/file_upload/webinar/';
        $config_img['allowed_types']        = 'gif|jpg|png|jpeg';
        $img_gambar                         = "webinar".date('Ymd').mt_rand(1000, 9999);
        $config_img['file_name']            = $img_gambar;
     
  
        $this->upload->initialize($config_img);
  
        if ($this->upload->do_upload('img')){
  
          $data = array('upload_data' => $this->upload->data());
    
  
              $filename= $data['upload_data']['file_name'];
           

              $data_webinar = array(
                'topik'=>$topik,
                'tanggal'=>$tanggal,
                'pembicara'=>$pembicara,
                'desc'=>$desc,
                'jabatan_pembicara'=>$jabatan_pembicara,
                'moderator'=>$moderator,
                'jabatan_moderator'=>$jabatan_moderator,
                'link'=>$link,
                'moderator'=>$moderator,
                'moderator'=>$moderator,
               
                'img'=>$filename,
                'share_link'=>$share_link,
                'create_add'=>date('Y-m-d H:i:s'),
                'waktu'=>$waktu_mulai_jam.':'.$waktu_mulai_menit .'-'. $waktu_selesai_jam.':'.$waktu_selesai_menit
    
            );
    
         
            $this->db->where('id_webinar',$id_webinar);
            $simpan = $this->db->update('webinar',$data_webinar);


             $sess = $this->session->userdata();
        $data_log = array(
          'aktifitas'=>$sess['pegawai']->username.''.' Mengedit webinar '.$topik.' id '.$id_webinar,
          'datetime'=>date('Y-m-d H:i:s'),
        );
 
        $this->db->insert('log',$data_log);



       


        if($simpan){
           $this->session->set_flashdata('status',"success");
            $this->session->set_flashdata('message', "<b>Success <i class='fa fa-check-square-o'></i></b>  Data berhasil di simpan");
            
            redirect('master/webinar/');
        
        }else{

        }
  
          
        }else{
          $error = array('error' => $this->upload->display_errors());

          // echo "<pre>";
          // print_r($error);
          // die;


          $data_webinar = array(
                'topik'=>$topik,
                'tanggal'=>$tanggal,
                'pembicara'=>$pembicara,
                'desc'=>$desc,
                'jabatan_pembicara'=>$jabatan_pembicara,
                'moderator'=>$moderator,
                'jabatan_moderator'=>$jabatan_moderator,
                'link'=>$link,
                'moderator'=>$moderator,
                'moderator'=>$moderator,
               
                'share_link'=>$share_link,
              
                'create_add'=>date('Y-m-d H:i:s'),
                'waktu'=>$waktu_mulai_jam.':'.$waktu_mulai_menit .'-'. $waktu_selesai_jam.':'.$waktu_selesai_menit
    
            );
    
         
            $this->db->where('id_webinar',$id_webinar);
            $simpan = $this->db->update('webinar',$data_webinar);


             $sess = $this->session->userdata();
        $data_log = array(
          'aktifitas'=>$sess['pegawai']->username.''.' Mengedit webinar '.$topik.' id '.$id_webinar,
          'datetime'=>date('Y-m-d H:i:s'),
        );
 
        $this->db->insert('log',$data_log);



       


        if($simpan){
           $this->session->set_flashdata('status',"success");
            $this->session->set_flashdata('message', "<b>Success <i class='fa fa-check-square-o'></i></b>  Data berhasil di simpan");
            
            redirect('master/webinar/');
        
        }else{

        }
        
        }





     


       

    }

    function hapus(){
        $id_webinar = $this->input->post('id');

	

       

       $this->db->where('id_webinar',$id_webinar);
       $sql =  $this->db->delete('webinar');



       $sess = $this->session->userdata();
       $data_log = array(
         'aktifitas'=>$sess['pegawai']->username.''.' menghapus webinar id '.$id_webinar,
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


    function publish($id_webinar){

        
        $id_webinar2 = base64_decode($id_webinar);

        $data_update = array(
            'publish'=>1,
        );

        $this->db->where('id_webinar',$id_webinar2);
        $this->db->update('webinar',$data_update);

        $this->session->set_flashdata('status',"success");
        $this->session->set_flashdata('message', "<b>Success <i class='fa fa-check-square-o'></i></b>  Data berhasil di simpan");
        
        redirect('master/webinar/');


        
    }




    
    
}
