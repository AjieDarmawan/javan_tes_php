<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Sekolah extends CI_Controller
{


    function __construct(){
        parent::__construct();
        $sess = $this->session->userdata();
        if($sess['pegawai']->username){
            //redirect('auth');
        }else{
            redirect('auth');
        }
        $this->load->model(array('Jenis_M','Kategori_M','Sekolah_M','Paket_M'));
        
    }


    

    // redirect if needed, otherwise display the user list
    public function index()
    {

      
        
        // $sess = $this->session->userdata(['pegawai']['username']);
        // echo "<pre>";
        // print_r($sess);
        // die;
        //$data["sekolah"] = $this->Jenis_M->getAll();
        $data["title"] = "List Data Master Sekolah";
        $this->template->load('template','sekolah/sekolah_v',$data);
     
    }


    public function ajax_list()
    {

         
         error_reporting(0);  
        header('Content-Type: application/json');
        $list = $this->Sekolah_M->get_datatables();
        $data = array();
        $no = $this->input->post('start');
        //looping data mahasiswa
        foreach ($list as $data_sekolah) {

            $paket = $this->db->query('select p.nama_paket from paket_sekolah as p inner join event
         
            as e on e.id_paket=p.id_paket where p.tgl_mulai <= CURRENT_DATE() and p.tgl_selesai <= CURRENT_DATE() ')->row();



            $cek = $this->db->query('select kode_sekolah,status from m_sekolah where id_m_sekolah="'.$data_sekolah->id_m_sekolah.'"')->row();

            if($cek->kode_sekolah){

                if($cek->status==1){
                    $status = "<a data-toggle='tooltip' title='List Sekolah' onclick='return confirm(\"Apakah Anda Yakin \")'  href=".base_url('master/Sekolah/status_sekolah/'.base64_encode($data_sekolah->id_m_sekolah))."><button class='btn btn-primary btn-xs'>Aktif</button></a>";
                }else{
                    $status = "<a data-toggle='tooltip' title='List Sekolah' onclick='return confirm(\"Apakah Anda Yakin \")'  href=".base_url('master/Sekolah/status_sekolah/'.base64_encode($data_sekolah->id_m_sekolah))."><button class='btn btn-danger btn-xs'>Tidak Aktif</button></a>";
                }






                $even_sekolah = $this->db->query('select * from event_sekolah where id_sekolah="'.$data_sekolah->id_m_sekolah.'"')->row();

                if($even_sekolah){


                    if($cek->kode_sekolah!=null){
                        $list_paket = "<a data-toggle='tooltip' title='List Sekolah'  href=".base_url('master/Sekolah/list_sekolah/'.base64_encode($data_sekolah->id_m_sekolah))."><button class='btn btn-primary btn-xs'>Paket Sekolah</button></a>";


                    }else{

                        $list_ = "";
                        $list_paket = "<a data-toggle='tooltip'  title='Generate'  href=".base_url('master/Sekolah/list_event_generate/'.base64_encode($data_sekolah->id_m_sekolah))."><button  class='btn btn-info btn-xs'>Pilih Paket</i></button></a>";
                    

                    }

                  

                }else{
                    $list_ = "";
                    $list_paket = "<a data-toggle='tooltip'  title='Generate'  href=".base_url('master/Sekolah/list_event_generate/'.base64_encode($data_sekolah->id_m_sekolah))."><button  class='btn btn-info btn-xs'>Pilih Paket</i></button></a>";
                    
                     
                }




              
                $edit = "<a data-toggle='tooltip' title='List Sekolah'  href=".base_url('master/Sekolah/edit_sekolah/'.base64_encode($data_sekolah->id_m_sekolah))."><button class='btn btn-info btn-xs'>Edit</button></a>";


            }else{


               
            
                $list_ = "";
               
               $list_paket = "<a data-toggle='tooltip' onclick='return confirm(\"Apakah Anda Yakin Menyetujui  ".$list_." \")' title='Generate'  href=".base_url('master/Sekolah/generate_kode/'.base64_encode($data_sekolah->id_m_sekolah))."><button  class='btn btn-success btn-xs'>Setuju</i></button></a>";
                    
                $status = "";
                $edit = "";
            }

           
           
            

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $data_sekolah->nama_sekolah;
            $row[] = $data_sekolah->nama_pendaftar;
             $row[] = $data_sekolah->email;

             $row[] = $data_sekolah->alamat_sekolah;
              $row[] = $data_sekolah->jumlah_siswa;
               $row[] = $data_sekolah->provinsi;
                $row[] = $data_sekolah->kota;
                $row[] = $data_sekolah->no_wa;
                $row[] = $data_sekolah->kode_sekolah;
                 $row[] = $data_sekolah->password;

            
            $row[] = $list_paket;
               $row[] = $status;
               $row[] = $edit;

            $data[] = $row;
        }
        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->Sekolah_M->count_all(),
            "recordsFiltered" => $this->Sekolah_M->count_filtered(),
            "data" => $data,
        );
        //output to json format
        $this->output->set_output(json_encode($output));
    }

    function tambah(){
          $data["kategori"] = $this->Kategori_M->getAll();
          $data["title"] = "List Data Master sekolah";
          $this->template->load('template','sekolah/sekolah_tambah',$data);
    }

    function simpan(){
        $sekolah =  $this->input->post('sekolah');

        $id_kategori =  $this->input->post('id_kategori');

        $simpan = $this->Jenis_M->save($sekolah,$id_kategori);

        if($simpan){
           $this->session->set_flashdata('status',"success");
            $this->session->set_flashdata('message', "<b>Success <i class='fa fa-check-square-o'></i></b> Tambah data berhasil");
            
            redirect('master/sekolah/');
        
        }else{

        }
    }

    function update($id){
         
        $data["kategori"] = $this->Kategori_M->getAll();
        $data['sekolah'] = $this->Jenis_M->getById(base64_decode($id));
        $data["title"] = "List Data Master sekolah";
        $this->template->load('template','sekolah/sekolah_edit',$data);
    }

    function update_simpan(){
        $id_jenis  = $this->input->post('id_jenis');
        $sekolah_nama  = $this->input->post('sekolah');
        $id_kategori =  $this->input->post('id_kategori');


        $simpan = $this->Jenis_M->update($id_jenis,$sekolah_nama,$id_kategori);

        if($simpan){
           $this->session->set_flashdata('status',"success");
            $this->session->set_flashdata('message', "<b>Success <i class='fa fa-check-square-o'></i></b>  Data berhasil di simpan");
            
            redirect('master/sekolah/');
        
        }else{

        }

    }

    function generateRandomString($length = 6) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    function hapus(){
        $id_jenis = $this->input->post('id');

        $this->db->where('id_jenis',$id_jenis);
        $sql = $this->db->delete('jenis');
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

    function generate_kode($id_m_sekolah){


       $password =  $this->generateRandomString();

        $random_satu = rand(6,999999);
        $random_tiga = rand(3,999);

        // $cek = $this->db->query('select kode_sekolah form m_sekolah where kode_sekolah="'.$random_satu.'"')->row();

        // if($cek){
        //     $random_dua = date('s').''.$random_tiga;
        // }else{
           // $random_dua = $random_satu;
        //}

        $data_update = array(

            'kode_sekolah'=>$random_satu,
            'password'=>$password,
            'status'=>1,
        );

        $id_sekolah = base64_decode($id_m_sekolah);

         // die;

        $this->db->where('id_m_sekolah',$id_sekolah);
        $this->db->update('m_sekolah',$data_update);


        redirect('master/sekolah/list_event_generate/'.$id_m_sekolah);
        


       


       

    }


    function list_event_generate($id_m_sekolah){
        $data['id_sekolah'] = base64_decode($id_m_sekolah);
        
        $data['paket'] = $this->db->query('select *  from paket_sekolah 

        where tgl_mulai <= CURRENT_DATE() and tgl_selesai >= CURRENT_DATE()')->result();


        $data["title"] = "List Data Event Paket";
        $this->template->load('template','sekolah/list_event_generate',$data);



        // echo "<pre>";
        // print_r($paket);
        // die;


        // foreach($paket as $p){

        //     if($p->no_urut_paket==1 || $p->no_urut_paket==2){
        //         $publish = 1;
        //     }else{
        //         $publish = 0;
        //     }
        //     $data_paket = array(
        //         'id_event'=> $p->id_event,
        //         'id_sekolah'=>$id_sekolah,
        //         'tgl_mulai_sekolah'=>$p->tgl_mulai,
        //         'tgl_selesai_sekolah'=>$p->tgl_selesai,
        //         'id_paket'=>$p->id_paket,
        //         'no_urut_paket'=>$p->no_urut_paket,
        //         'publish_sekolah'=>$publish,
        //     );
        //     $this->db->insert('event_sekolah',$data_paket);
        // }
        // redirect('master/Sekolah');
    }

    function paket_simpan_event($id_m_sekolah){
      
        $data['id_sekolah'] = base64_decode($id_m_sekolah);
         $data['id_paket'] = $this->input->post('id_paket');

 

        $data['paket'] = $this->db->query('select p.*,e.no_urut_paket,e.id_event,e.judul  from paket_sekolah as p inner join event
         
        as e on e.id_paket=p.id_paket where e.id_paket="'.$this->input->post('id_paket').'" order by e.no_urut_paket asc')->result();


        $data["title"] = "Rencana Event Paket";
        $this->template->load('template','sekolah/paket_simpan_event',$data);
    }


    public function ajax_list_sekolah($id_m_sekolah)
    {


       

       
        $id_sekolah = base64_decode($id_m_sekolah);
        
        header('Content-Type: application/json');
        $list = $this->Paket_M->get_datatables_get_id_sekolah($id_sekolah);
        $data = array();
        $no = $this->input->post('start');
        //looping data mahasiswa
        foreach ($list as $data_paket) {

         

           
             $cek_publish = $this->db->query('select publish_sekolah from event_sekolah where id_event_sekolah="'.$data_paket->id_event_sekolah.'"')->row();

            if($cek_publish->publish_sekolah==1){
                $publish = "<a data-toggle='tooltip' onclick='return confirm(\"Apakah Anda Yakin \")' title='Publish'  href=".base_url('master/sekolah/publish/'.base64_encode($data_paket->id_event_sekolah).'/'.base64_encode($data_paket->id_sekolah))."><button class='btn btn-danger btn-xs'>UnPublish</button></a>";
                $edit = "";
            }else{
                $publish = "<a data-toggle='tooltip' onclick='return confirm(\"Apakah Anda Yakin \")' title='Publish'  href=".base_url('master/sekolah/publish/'.base64_encode($data_paket->id_event_sekolah).'/'.base64_encode($data_paket->id_sekolah))."><button class='btn btn-info btn-xs'>Publish</button></a>";
                $edit = "<a data-toggle='tooltip' title='Edit'  href=".base_url('master/sekolah/update_event_sekolah/'.base64_encode($data_paket->id_event_sekolah))."><button class='btn btn-success btn-xs'><i class='fa fa-edit'></i></button></a>";
          
            }
          
            // $delete =  "<a  data-toggle='tooltip' title='Hapus' id='$data_paket->id_paket' class='hapus_dokumen' ><button class='btn btn-xs btn-danger'><i class='fa fa-trash'></i></button></a>";


            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $data_paket->nama_paket;
            $row[] = $data_paket->nama_sekolah;
            $row[] = $data_paket->judul;
            $row[] = TanggalIndo($data_paket->tgl_mulai_sekolah) ;
            $row[] = TanggalIndo($data_paket->tgl_selesai_sekolah);
            $row[] = $data_paket->no_urut_paket;
            
            
            $sess = $this->session->userdata();
            if($sess['pegawai']->role==1){
                $row[] = $publish  .' '.  $edit;
            }else{
                $row[] = "";
            }
          

            $data[] = $row;
        }
        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->Paket_M->count_all(),
            "recordsFiltered" => $this->Paket_M->count_filtered_get_id_sekolah($id_sekolah),
            "data" => $data,
        );
        //output to json format
        $this->output->set_output(json_encode($output));
    }


    function list_sekolah($id_sekolah){
       
      //  $data['id_paket'] = $id_paket2;
        $data['id_sekolah'] = $id_sekolah;


        
        $data["title"] = "List Data Master Paket Sekolah";
        $this->template->load('template','sekolah/list_sekolah_v',$data);
    }

    function publish($id_event_sekolah,$id_sekolah){

        $event_sekolah = $this->db->query('select publish_sekolah from event_sekolah where id_event_sekolah="'.base64_decode($id_event_sekolah).'" 
        and id_sekolah = "'.base64_decode($id_sekolah).'" ')->row();

        if($event_sekolah->publish_sekolah==0){
            $publish_sekolah = 1;
        }else{
            $publish_sekolah = 0;
        }

        $data_update= array(
            'publish_sekolah'=>$publish_sekolah,  
            'date_action_publish'=>date('Y-m-d H:i:s'),
        );

        $this->db->where('id_event_sekolah',base64_decode($id_event_sekolah));
        $this->db->update('event_sekolah',$data_update);


        $this->session->set_flashdata('status',"success");
        $this->session->set_flashdata('message', "<b>Success <i class='fa fa-check-square-o'></i></b> berhasil Publish");


        redirect('master/Sekolah/list_sekolah/'.$id_sekolah);
    }


    function update_event_sekolah($id_event_sekolah2){
        $id_event_sekolah =  base64_decode($id_event_sekolah2);

        

        $data['event_sekolah'] = $this->db->query('select id_sekolah,id_event_sekolah,tgl_mulai_sekolah,tgl_selesai_sekolah from event_sekolah where id_event_sekolah = "'.$id_event_sekolah.'"')->row();
      
        $data["title"] = "List Data  Update Event Sekolah";
        $this->template->load('template','sekolah/update_event_sekolah',$data);
    }

    function simpan_update_event_sekolah(){
        $id_event_sekolah = $this->input->post('id_event_sekolah');

        $tgl_mulai_sekolah = $this->input->post('tgl_mulai_sekolah');
        $id_sekolah = $this->input->post('id_sekolah');
        $tgl_selesai_sekolah = $this->input->post('tgl_selesai_sekolah');

        $data_update = array(
            'tgl_mulai_sekolah'=>$tgl_mulai_sekolah,
            'tgl_selesai_sekolah'=>$tgl_selesai_sekolah,
        );

        $this->db->where('id_event_sekolah',$id_event_sekolah);
        $this->db->update('event_sekolah',$data_update);

        $this->session->set_flashdata('status',"success");
        $this->session->set_flashdata('message', "<b>Success <i class='fa fa-check-square-o'></i></b> berhasil Publish");


        redirect('master/Sekolah/list_sekolah/'.base64_encode($id_sekolah));



    }


    function status_sekolah($id_sekolah_m){


        $cek = $this->db->query("select status from m_sekolah where id_m_sekolah = '".base64_decode($id_sekolah_m)."'")->row();

        if($cek->status==1){
            $data_update = array(
                'status'=>0,
            );
        }else{
            $data_update = array(
                'status'=>1,
            );
            
        }

        $this->db->where('id_m_sekolah',base64_decode($id_sekolah_m));

        $this->db->update('m_sekolah',$data_update);

        $this->session->set_flashdata('status',"success");
        $this->session->set_flashdata('message', "<b>Success <i class='fa fa-check-square-o'></i></b> Data Berhasil Berubah");


        redirect('master/Sekolah');
    }


    function edit_sekolah($id_m_sekolah){
        $id_sekolah = base64_decode($id_m_sekolah);
        $data['data_sekolah'] = $this->db->query('select * from m_sekolah where id_m_sekolah = "'.$id_sekolah.'"')->row();
// echo "<pre>";
// print_r($data);
      //  die;
        $data["title"] = "List Data  Edit Sekolah";
        $data["id_sekolah"] = $id_sekolah;
        $this->template->load('template','sekolah/edit_sekolah',$data);
    }


    function edit_sekolah_simpan(){
        $this->load->library('upload');

        $id_sekolah =  $this->input->post('id_sekolah');

        $email = $this->input->post('email');
        $nama = $this->input->post('nama');
        $jumlah_siswa = $this->input->post('jumlah_siswa');
        $no_wa = $this->input->post('no_wa');

    
       
        $config_img['upload_path']          = './assets/file_upload/sekolah/';
        $config_img['allowed_types']        = 'gif|jpg|png|jpeg';
        $img_gambar                         = "sekolah".date('Ymd').mt_rand(1000, 9999);
        $config_img['file_name']            = $img_gambar;
     
  
        $this->upload->initialize($config_img);
  
        if ($this->upload->do_upload('img')){
  
          $data = array('upload_data' => $this->upload->data());
    
              $filename= $data['upload_data']['file_name'];

              $data_simpan = array(
                'photo'=>$filename,
            );
  
          
        }else{
          $error = array('error' => $this->upload->display_errors());
            $data_simpan = array(
                'email'=>$email,
                'nama_pendaftar'=>$nama,
                'jumlah_siswa'=>$jumlah_siswa,
                'no_wa'=>$no_wa,
                );
        }



       $this->db->where('id_m_sekolah',$id_sekolah);
       $simpan = $this->db->update('m_sekolah',$data_simpan);

    


        if($simpan){
           $this->session->set_flashdata('status',"success");
            $this->session->set_flashdata('message', "<b>Success <i class='fa fa-check-square-o'></i></b> Tambah data berhasil");
            
            redirect('master/Sekolah/');
        
        }else{

        }
    }


    function paket_simpan_event_simpan(){
      

        $id_event = $this->input->post('id_event');
        // echo "<pre>";
        // print_r($id_event);
        // die;    
        $tgl_mulai_sekolah = $this->input->post('tgl_mulai_sekolah');
        $tgl_selesai_sekolah = $this->input->post('tgl_selesai_sekolah');
        $no_urut_paket = $this->input->post('no_urut_paket');
        $publish = $this->input->post('publish');

        $id_sekolah = $this->input->post('id_sekolah');
        $id_paket = $this->input->post('id_paket');

        foreach($id_event as $key => $p){

          
            $data_paket = array(
                'id_event'=> $id_event[$key],
                'id_sekolah'=>$id_sekolah,
                'tgl_mulai_sekolah'=>$tgl_mulai_sekolah[$key],
                'tgl_selesai_sekolah'=>$tgl_selesai_sekolah[$key],
                'id_paket'=>$id_paket,
                'no_urut_paket'=>$no_urut_paket[$key],
                'publish_sekolah'=>$publish[$key],
            );
            $this->db->insert('event_sekolah',$data_paket);
        }
        redirect('master/Sekolah');


        
    }



    
    
}
