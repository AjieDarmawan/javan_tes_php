<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Testimoni extends CI_Controller
{


    function __construct(){
		parent::__construct();
        $sess = $this->session->userdata();
		if($sess['pegawai']->username){
			//redirect('auth');
		}else{
            redirect('auth');
        }
         $this->load->model(array('Testimoni_M'));
		
    }


    

    // redirect if needed, otherwise display the user list
    public function index()
    {
       // $sess = $this->session->userdata();
        // echo "<pre>";
        // print_r($sess['pegawai']->username);
        // die;
        //$data["Testimoni"] = $this->Testimoni_M->getAll();
        $data["title"] = "List Data  Testimoni";
        $this->template->load('template','testimoni/testimoni_v',$data);
     
    }


    public function ajax_list()
    {


       


        header('Content-Type: application/json');
        $list = $this->Testimoni_M->get_datatables();
        $data = array();
        $no = $this->input->post('start');
        //looping data mahasiswa
        foreach ($list as $data_Testimoni) {

            


            
            $update = "<a data-toggle='tooltip' title='update'  href=".base_url('master/Testimoni/update_status/'.base64_encode($data_Testimoni->id_testimoni).'/'.$data_Testimoni->status)."><button class='btn btn-info btn-xs'><i class='fa fa-edit'></i></button></a>";
			$delete =  "<a  data-toggle='tooltip' title='Hapus' id='$data_Testimoni->id_testimoni' class='hapus_dokumen' ><button class='btn btn-xs btn-danger'><i class='fa fa-trash'></i></button></a>";

            if($data_Testimoni->status=='1'){
                $status = 'Aktif';
            }else{
                $status = 'Belum Aktif';
            }


            $no++;
            $row = array();
            $row[] = $no;
           
           
            $row[] = $data_Testimoni->email;
            $row[] = $data_Testimoni->bintang;
            $row[] = $data_Testimoni->saran;
            $row[] = $status;
            $sess = $this->session->userdata();
            if($sess['pegawai']->role==1){
                $row[] = $delete." ".$update;
            }else{
                $row[] = $update;
            }
          

            $data[] = $row;
        }
        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->Testimoni_M->count_all(),
            "recordsFiltered" => $this->Testimoni_M->count_filtered(),
            "data" => $data,
        );
        //output to json format
        $this->output->set_output(json_encode($output));
    }

    function tambah(){
          //$data["Testimoni"] = $this->Testimoni_M->getAll();


      

        //   echo "<pre>";
        //   print_r($data['kategori']);
        //   die;
          $data["title"] = "List Data Master Testimoni";
          $this->template->load('template','testimoni/testimoni_tambah',$data);
    }

    function simpan(){
        $this->load->library('upload');


        $kategori =  $this->input->post('kategori');
     



        $config_img['upload_path']          = './assets/file_upload/Testimoni/';
        $config_img['allowed_types']        = 'gif|jpg|png|jpeg';
        $img_gambar                         = "Testimoni".date('Ymd').mt_rand(1000, 9999);
        $config_img['file_name']            = $img_gambar;
     
  
        $this->upload->initialize($config_img);
  
        if ($this->upload->do_upload('img')){
  
          $data = array('upload_data' => $this->upload->data());
    
              $filename= $data['upload_data']['file_name'];

              $data_Testimoni = array(
                'kategori'=>$kategori,
                
                'img'=>$filename,
               
            );
  
          
        }else{
          $error = array('error' => $this->upload->display_errors());
        
        }




       $simpan = $this->db->insert('Testimoni',$data_Testimoni);

       $sess = $this->session->userdata();
       $data_log = array(
         'aktifitas'=>$sess['pegawai']->username.''.' Menambahkan Testimoni '.$filename.' id '.$this->db->insert_id(),
         'datetime'=>date('Y-m-d H:i:s'),
       );

       $this->db->insert('log',$data_log);



        if($simpan){
           $this->session->set_flashdata('status',"success");
			$this->session->set_flashdata('message', "<b>Success <i class='fa fa-check-square-o'></i></b> Tambah data berhasil");
            
            redirect('master/Testimoni/');
        
        }else{

        }
    }

    function update($id){

        
        $data['Testimoni'] = $this->Testimoni_M->getById(base64_decode($id));
        $data["title"] = "List Data Master Testimoni";
        $this->template->load('template','testimoni/testimoni_edit',$data);
    }

    function update_simpan(){
        $this->load->library('upload');

        $id_testimoni  = $this->input->post('id_testimoni');
        $kategori  = $this->input->post('kategori');


        $config_img['upload_path']          = './assets/file_upload/Testimoni/';
        $config_img['allowed_types']        = 'gif|jpg|png|jpeg';
        $img_gambar                         = "Testimoni".date('Ymd').mt_rand(1000, 9999);
        $config_img['file_name']            = $img_gambar;
     
  
        $this->upload->initialize($config_img);
  
        if ($this->upload->do_upload('img')){
  
          $data = array('upload_data' => $this->upload->data());
    
  
              $filename= $data['upload_data']['file_name'];
           

              $data_Testimoni = array(
                'kategori'=>$kategori,
               
                'img'=>$filename,
               
            );
    
         
            $this->db->where('id_testimoni',$id_testimoni);
            $simpan = $this->db->update('Testimoni',$data_Testimoni);


             $sess = $this->session->userdata();
        $data_log = array(
          'aktifitas'=>$sess['pegawai']->username.''.' Mengedit Testimoni '.$kategori.' id '.$id_testimoni,
          'datetime'=>date('Y-m-d H:i:s'),
        );
 
        $this->db->insert('log',$data_log);



       


        if($simpan){
           $this->session->set_flashdata('status',"success");
            $this->session->set_flashdata('message', "<b>Success <i class='fa fa-check-square-o'></i></b>  Data berhasil di simpan");
            
            redirect('master/Testimoni/');
        
        }else{

        }
  
          
        }else{
          $error = array('error' => $this->upload->display_errors());

          // echo "<pre>";
          // print_r($error);
          // die;


          $data_Testimoni = array(
                'kategori'=>$kategori,
               
            );
    
         
            $this->db->where('id_testimoni',$id_testimoni);
            $simpan = $this->db->update('testimoni',$data_Testimoni);


             $sess = $this->session->userdata();
        $data_log = array(
          'aktifitas'=>$sess['pegawai']->username.''.' Mengedit Testimoni '.$kategori.' id '.$id_testimoni,
          'datetime'=>date('Y-m-d H:i:s'),
        );
 
        $this->db->insert('log',$data_log);



       


        if($simpan){
           $this->session->set_flashdata('status',"success");
            $this->session->set_flashdata('message', "<b>Success <i class='fa fa-check-square-o'></i></b>  Data berhasil di simpan");
            
            redirect('master/Testimoni/');
        
        }else{

        }
        
        }

    }

    function hapus(){
        $id_testimoni = $this->input->post('id');

	

        $Testimoni = $this->db->query('select * from testimoni where id_testimoni='.$id_testimoni)->result();
      

        
       $this->db->where('id_testimoni',$id_testimoni);
       $sql =  $this->db->delete('testimoni');



       $sess = $this->session->userdata();
       $data_log = array(
         'aktifitas'=>$sess['pegawai']->username.''.' menghapus Testimoni id '.$id_testimoni,
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


    function update_status($id_testimoni,$status){

        //echo base64_decode($id_testimoni);

        if($status==0){
            $status_update = 1;
        }else{
            $status_update = 0;
        }

        $data_update = array(
            'status'=>$status_update,
        );

        $q = $this->db->update('testimoni',$data_update,array('id_testimoni'=>base64_decode($id_testimoni)));

        if($q){
            redirect('master/testimoni/');
        }

    }




    
    
}
