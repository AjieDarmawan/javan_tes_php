<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Paket extends CI_Controller
{


    function __construct(){
        parent::__construct();
        $sess = $this->session->userdata();
        if($sess['pegawai']->username){
            //redirect('auth');
        }else{
            redirect('auth');
        }
        $this->load->model(array('Paket_M'));
        
    }


    

    // redirect if needed, otherwise display the user list
    public function index()
    {
       // $sess = $this->session->userdata();
        // echo "<pre>";
        // print_r($sess['pegawai']->username);
        // die;
        //$data["paket"] = $this->Paket_M->getAll();
        $data["title"] = "List Data Master Paket";
        $this->template->load('template','paket/paket_v',$data);
     
    }


    public function ajax_list()
    {


       


        header('Content-Type: application/json');
        $list = $this->Paket_M->get_datatables();
        $data = array();
        $no = $this->input->post('start');
        //looping data mahasiswa
        foreach ($list as $data_paket) {

         

           



            $edit = "<a data-toggle='tooltip' title='Edit'  href=".base_url('master/paket/update/'.base64_encode($data_paket->id_paket))."><button class='btn btn-success btn-xs'><i class='fa fa-edit'></i></button></a>";
            $materi = "<a data-toggle='tooltip' title='materi'  href=".base_url('master/paket/list_paket/'.base64_encode($data_paket->id_paket))."><button class='btn btn-info btn-xs'><i class='fa fa-edit'></i></button></a>";

            $list_event = "<a data-toggle='tooltip' title='List Event Paket'  href=".base_url('master/paket/list_event_paket/'.base64_encode($data_paket->id_paket))."><button class='btn btn-success'>List Event</button></a>";
            $delete =  "<a  data-toggle='tooltip' title='Hapus' id='$data_paket->id_paket' class='hapus_dokumen' ><button class='btn btn-xs btn-danger'><i class='fa fa-trash'></i></button></a>";


            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $data_paket->nama_paket;
            $row[] = TanggalIndo($data_paket->tgl_mulai) ;
            $row[] = TanggalIndo($data_paket->tgl_selesai);
            $row[] = $data_paket->desc;
            $sess = $this->session->userdata();
            if($sess['pegawai']->role==1){
                $row[] = $edit." ".$delete." ".$materi." ".$list_event;
            }else{
                $row[] = $edit."  ".$materi." ".$list_event;
            }
          

            $data[] = $row;
        }
        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->Paket_M->count_all(),
            "recordsFiltered" => $this->Paket_M->count_filtered(),
            "data" => $data,
        );
        //output to json format
        $this->output->set_output(json_encode($output));
    }

    function tambah(){
          //$data["paket"] = $this->Paket_M->getAll();


      

        //   echo "<pre>";
        //   print_r($data['kategori']);
        //   die;
          $data["title"] = "List Data Master paket";
          $this->template->load('template','paket/paket_tambah',$data);
    }

    function simpan(){
       $nama_paket = $this->input->post('nama_paket');

       $tgl_mulai = $this->input->post('tgl_mulai');
       $tgl_selesai = $this->input->post('tgl_selesai');

       $desc = $this->input->post('desc');

       $data_simpan = array(
        'nama_paket'=>$nama_paket,
        'tgl_mulai'=>$tgl_mulai,
        'tgl_selesai'=>$tgl_selesai,
        'desc'=>$desc,
       );

       $this->db->insert('paket_sekolah',$data_simpan);

        redirect('master/paket/');
    }

    function update($id){

        
        $data['paket'] = $this->Paket_M->getById(base64_decode($id));

        
        $data["title"] = "List Data Master paket";
        $this->template->load('template','paket/paket_edit',$data);
    }

    function update_simpan(){
        $nama_paket = $this->input->post('nama_paket');

       $tgl_mulai = $this->input->post('tgl_mulai');
       $tgl_selesai = $this->input->post('tgl_selesai');

       $id_paket = $this->input->post('id_paket');

       $desc = $this->input->post('desc');

       $data_simpan = array(
        'nama_paket'=>$nama_paket,
        'tgl_mulai'=>$tgl_mulai,
        'tgl_selesai'=>$tgl_selesai,
        'desc'=>$desc,
       );

       $this->db->where('id_paket',$id_paket);
       $this->db->update('paket_sekolah',$data_simpan);

        redirect('master/paket/');

    }

    function hapus(){
        $id_paket = $this->input->post('id');

    

        $paket = $this->db->query('select * from paket_sekolah where id_paket='.$id_paket)->result();
      

        
       $this->db->where('id_paket',$id_paket);
       $sql =  $this->db->delete('paket_sekolah');



       $sess = $this->session->userdata();
       $data_log = array(
         'aktifitas'=>$sess['pegawai']->username.''.' menghapus paket id '.$id_paket,
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




    public function ajax_list_paket($id_paket2)
    {


       

        $id_paket = base64_decode($id_paket2);
        
        header('Content-Type: application/json');
        $list = $this->Paket_M->get_datatables_get_id($id_paket);
        $data = array();
        $no = $this->input->post('start');
        //looping data mahasiswa
        foreach ($list as $data_paket) {

         

           



            // $edit = "<a data-toggle='tooltip' title='Edit'  href=".base_url('master/paket/update/'.base64_encode($data_paket->id_paket))."><button class='btn btn-success btn-xs'><i class='fa fa-edit'></i></button></a>";
            // $materi = "<a data-toggle='tooltip' title='materi'  href=".base_url('master/paket/list_paket/'.base64_encode($data_paket->id_paket))."><button class='btn btn-info btn-xs'><i class='fa fa-edit'></i></button></a>";
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
            $row[] = "";
            
            $sess = $this->session->userdata();
            // if($sess['pegawai']->role==1){
            //     $row[] = $edit." ".$delete." ".$materi;
            // }else{
            //     $row[] = $edit."  ".$materi;
            // }
          

            $data[] = $row;
        }
        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->Paket_M->count_all(),
            "recordsFiltered" => $this->Paket_M->count_filtered_get_id($id_paket),
            "data" => $data,
        );
        //output to json format
        $this->output->set_output(json_encode($output));
    }


    function list_paket($id_paket2){
        $data['id_paket'] = $id_paket2;

        
        $data["title"] = "List Data Paket Di Sekolah";
        $this->template->load('template','paket/list_paket_v',$data);
    }


    public function ajax_list_event_paket($id_paket2)
    {


       

        $id_paket = base64_decode($id_paket2);
        
        header('Content-Type: application/json');
        $list = $this->Paket_M->get_datatables_get_id_event($id_paket);
        $data = array();
        $no = $this->input->post('start');
        //looping data mahasiswa
        foreach ($list as $data_paket) {

         

           
            


            // $edit = "<a data-toggle='tooltip' title='Edit'  href=".base_url('master/paket/update/'.base64_encode($data_paket->id_paket))."><button class='btn btn-success btn-xs'><i class='fa fa-edit'></i></button></a>";
            // $materi = "<a data-toggle='tooltip' title='materi'  href=".base_url('master/paket/list_paket/'.base64_encode($data_paket->id_paket))."><button class='btn btn-info btn-xs'><i class='fa fa-edit'></i></button></a>";
            // $delete =  "<a  data-toggle='tooltip' title='Hapus' id='$data_paket->id_paket' class='hapus_dokumen' ><button class='btn btn-xs btn-danger'><i class='fa fa-trash'></i></button></a>";


            $no++;
            $row = array();
            $row[] = $no; 
            $row[] = $data_paket->nama_paket;
            $row[] = $data_paket->judul;
            $row[] = TanggalIndo($data_paket->tgl_mulai) ;
            $row[] = TanggalIndo($data_paket->tgl_selesai);
            $row[] = $data_paket->no_urut_paket;
            $row[] = "";
            
            $sess = $this->session->userdata();
            // if($sess['pegawai']->role==1){
            //     $row[] = $edit." ".$delete." ".$materi;
            // }else{
            //     $row[] = $edit."  ".$materi;
            // }
          

            $data[] = $row;
        }
        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->Paket_M->count_all(),
            "recordsFiltered" => $this->Paket_M->count_filtered_get_id_event($id_paket),
            "data" => $data,
        );
        //output to json format
        $this->output->set_output(json_encode($output));
    }



    function list_event_paket($id_paket2){
        $data['id_paket'] = $id_paket2;

        
        $data["title"] = "List Data Master Event Paket";
        $this->template->load('template','paket/list_event_paket_v',$data);
    }





    
    
}
