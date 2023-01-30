<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Banner extends CI_Controller
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


    

    // redirect if needed, otherwise display the user list
    public function index()
    {
       // $sess = $this->session->userdata();
        // echo "<pre>";
        // print_r($sess['pegawai']->username);
        // die;
        //$data["banner"] = $this->Banner_M->getAll();
        $data["title"] = "List Data Master banner";
        $this->template->load('template','banner/banner_v',$data);
     
    }


    public function ajax_list()
    {


       


        header('Content-Type: application/json');
        $list = $this->Banner_M->get_datatables();
        $data = array();
        $no = $this->input->post('start');
        //looping data mahasiswa
        foreach ($list as $data_banner) {

            $path_banner = base_url("assets/file_upload/banner/".$data_banner->img);
            $path_webianr2 = FCPATH.'assets/file_upload/banner/'.$data_banner->img;
         

            if($data_banner->img){
                if (file_exists($path_webianr2) ){
                    $img_banner = " <img widht='50' height='50' src='".$path_banner."'>";   
                   
                }else{
                    $img_banner =  $data_banner->img;
                  
                }

             }else{
                $img_banner =  $data_banner->img;
                  
             }



            $edit = "<a data-toggle='tooltip' title='Edit'  href=".base_url('master/banner/update/'.base64_encode($data_banner->id_banner))."><button class='btn btn-success btn-xs'><i class='fa fa-edit'></i></button></a>";
            $materi = "<a data-toggle='tooltip' title='materi'  href=".base_url('master/materi/index/'.base64_encode($data_banner->id_banner))."><button class='btn btn-info btn-xs'><i class='fa fa-edit'></i></button></a>";
			$delete =  "<a  data-toggle='tooltip' title='Hapus' id='$data_banner->id_banner' class='hapus_dokumen' ><button class='btn btn-xs btn-danger'><i class='fa fa-trash'></i></button></a>";


            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $img_banner;
           
            $row[] = $data_banner->kategori;
            $sess = $this->session->userdata();
            if($sess['pegawai']->role==1){
                $row[] = $edit." ".$delete." ".$materi;
            }else{
                $row[] = $edit."  ".$materi;
            }
          

            $data[] = $row;
        }
        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->Banner_M->count_all(),
            "recordsFiltered" => $this->Banner_M->count_filtered(),
            "data" => $data,
        );
        //output to json format
        $this->output->set_output(json_encode($output));
    }

    function tambah(){
          //$data["banner"] = $this->Banner_M->getAll();


      

        //   echo "<pre>";
        //   print_r($data['kategori']);
        //   die;
          $data["title"] = "List Data Master banner";
          $this->template->load('template','banner/banner_tambah',$data);
    }

    function simpan(){
        $this->load->library('upload');


        $kategori =  $this->input->post('kategori');
     



        $config_img['upload_path']          = './assets/file_upload/banner/';
        $config_img['allowed_types']        = 'gif|jpg|png|jpeg';
        $img_gambar                         = "banner".date('Ymd').mt_rand(1000, 9999);
        $config_img['file_name']            = $img_gambar;
     
  
        $this->upload->initialize($config_img);
  
        if ($this->upload->do_upload('img')){
  
          $data = array('upload_data' => $this->upload->data());
    
              $filename= $data['upload_data']['file_name'];

              $data_banner = array(
                'kategori'=>$kategori,
                
                'img'=>$filename,
               
            );
  
          
        }else{
          $error = array('error' => $this->upload->display_errors());
        
        }




       $simpan = $this->db->insert('banner',$data_banner);

       $sess = $this->session->userdata();
       $data_log = array(
         'aktifitas'=>$sess['pegawai']->username.''.' Menambahkan banner '.$filename.' id '.$this->db->insert_id(),
         'datetime'=>date('Y-m-d H:i:s'),
       );

       $this->db->insert('log',$data_log);



        if($simpan){
           $this->session->set_flashdata('status',"success");
			$this->session->set_flashdata('message', "<b>Success <i class='fa fa-check-square-o'></i></b> Tambah data berhasil");
            
            redirect('master/banner/');
        
        }else{

        }
    }

    function update($id){

        
        $data['banner'] = $this->Banner_M->getById(base64_decode($id));
        $data["title"] = "List Data Master banner";
        $this->template->load('template','banner/banner_edit',$data);
    }

    function update_simpan(){
        $this->load->library('upload');

        $id_banner  = $this->input->post('id_banner');
        $kategori  = $this->input->post('kategori');


        $config_img['upload_path']          = './assets/file_upload/banner/';
        $config_img['allowed_types']        = 'gif|jpg|png|jpeg';
        $img_gambar                         = "banner".date('Ymd').mt_rand(1000, 9999);
        $config_img['file_name']            = $img_gambar;
     
  
        $this->upload->initialize($config_img);
  
        if ($this->upload->do_upload('img')){
  
          $data = array('upload_data' => $this->upload->data());
    
  
              $filename= $data['upload_data']['file_name'];
           

              $data_banner = array(
                'kategori'=>$kategori,
               
                'img'=>$filename,
               
            );
    
         
            $this->db->where('id_banner',$id_banner);
            $simpan = $this->db->update('banner',$data_banner);


             $sess = $this->session->userdata();
        $data_log = array(
          'aktifitas'=>$sess['pegawai']->username.''.' Mengedit banner '.$kategori.' id '.$id_banner,
          'datetime'=>date('Y-m-d H:i:s'),
        );
 
        $this->db->insert('log',$data_log);



       


        if($simpan){
           $this->session->set_flashdata('status',"success");
            $this->session->set_flashdata('message', "<b>Success <i class='fa fa-check-square-o'></i></b>  Data berhasil di simpan");
            
            redirect('master/banner/');
        
        }else{

        }
  
          
        }else{
          $error = array('error' => $this->upload->display_errors());

          // echo "<pre>";
          // print_r($error);
          // die;


          $data_banner = array(
                'kategori'=>$kategori,
               
            );
    
         
            $this->db->where('id_banner',$id_banner);
            $simpan = $this->db->update('banner',$data_banner);


             $sess = $this->session->userdata();
        $data_log = array(
          'aktifitas'=>$sess['pegawai']->username.''.' Mengedit banner '.$kategori.' id '.$id_banner,
          'datetime'=>date('Y-m-d H:i:s'),
        );
 
        $this->db->insert('log',$data_log);



       


        if($simpan){
           $this->session->set_flashdata('status',"success");
            $this->session->set_flashdata('message', "<b>Success <i class='fa fa-check-square-o'></i></b>  Data berhasil di simpan");
            
            redirect('master/banner/');
        
        }else{

        }
        
        }

    }

    function hapus(){
        $id_banner = $this->input->post('id');

	

        $banner = $this->db->query('select * from banner where id_banner='.$id_banner)->result();
      

        
       $this->db->where('id_banner',$id_banner);
       $sql =  $this->db->delete('banner');



       $sess = $this->session->userdata();
       $data_log = array(
         'aktifitas'=>$sess['pegawai']->username.''.' menghapus banner id '.$id_banner,
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


    function materi(){

    }




    
    
}
