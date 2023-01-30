<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Irt_tarik extends CI_Controller
{


    function __construct(){
		parent::__construct();
        $sess = $this->session->userdata();
		if($sess['pegawai']->username){
			//redirect('auth');
		}else{
            redirect('auth');
        }
        $this->load->model(array('Event_M','Materi_M','Jenis_M','Kategori_M','Irt_tarik_M','Kedinasan_tarik_M','Mandiri_tarik_M','Irt_tarik_Sekolah_M'));
		
    }


     // redirect if needed, otherwise display the user list
     public function index()
     {
       
         $data["title"] = "List Data Master Event";
         $this->template->load('template','irt_tarik/irt_tarik_v',$data);
      
     }


     public function ajax_list()
     {
 
 
        
 
 
         header('Content-Type: application/json');
         $list = $this->Event_M->get_datatables();
         $data = array();
         $no = $this->input->post('start');
         //looping data mahasiswa
         foreach ($list as $data_Event) {

              if($data_Event->mode=='event'){
                 $mode_model = 1;
             }elseif($data_Event->mode=='latihan'){
                 $mode_model = 2;
             }
            
             $total_peserta = $this->db->query("select email from jawaban where mode ='".$mode_model."' and id_event = '".$data_Event->id_event."'  group by email")->result();
 
 
             $edit = "<a data-toggle='tooltip' title='Edit'  href=".base_url('master/Irt_tarik/detail/'.base64_encode($data_Event->id_event).'/'.count($total_peserta))."><button class='btn btn-success btn-xs'><i class='fa fa-edit'></i></button></a>";
            
            
           
 
             $no++;
             $row = array();
             $row[] = $no;
             $row[] = $data_Event->judul;
             $row[] = $data_Event->kategori_nama;
 
             
             $row[] = date('d-m-Y',strtotime($data_Event->tgl_mulai));
             $row[] = date('d-m-Y',strtotime($data_Event->tgl_selesai));
             $row[] = $data_Event->desc;
           
             $row[] = count($total_peserta);
             $row[] = $data_Event->mode;
             $sess = $this->session->userdata();
             if($sess['pegawai']->role==1){
                 $row[] = $edit;
             }else{
                 $row[] = "";
             }
           
 
             $data[] = $row;
         }
         $output = array(
             "draw" => $this->input->post('draw'),
             "recordsTotal" => $this->Event_M->count_all(),
             "recordsFiltered" => $this->Event_M->count_filtered(),
             "data" => $data,
         );
         //output to json format
         $this->output->set_output(json_encode($output));
     }

    function detail($id_event,$total_peserta){

        error_reporting(0);
        $data["title"] = "List Data ";

          
       $data['total_peserta'] = $total_peserta;
        $data['id_event'] = base64_decode($id_event);
         $cek = $this->db->query('select es.*,s.nama_sekolah from event_sekolah as es  inner join m_sekolah as s on s.id_m_sekolah = es.id_sekolah where es.id_event ="'.base64_decode($id_event).'"')->result();

         $data['sekolah'] = $cek;

        if($cek[0]){
            $this->template->load('template','irt_tarik/sekolah/irt_sekolah_detail',$data);
        }else{
           $this->template->load('template','irt_tarik/irt_tarik_detail',$data);
 
           // $this->template->load('template','irt_tarik/sekolah/irt_sekolah_detail',$data);
        }

     }

     function ajax_list_skor($id_event){

        error_reporting(0);
        header('Content-Type: application/json');


        $ev = $this->db->query('select kedinasan from event where id_event='.$id_event)->row();



        if($ev->kedinasan==1){
             $list = $this->Kedinasan_tarik_M->get_datatables($id_event);
        }else if($ev->kedinasan==2){
             $list = $this->Mandiri_tarik_M->get_datatables($id_event);
        }else{
             $list = $this->Irt_tarik_M->get_datatables($id_event);
        }
       
        $data = array();
        $no = $this->input->post('start');
        //looping data mahasiswa

        //$id_event = 49;
        foreach ($list as $data_irt) {

            $peserta = $this->db->query("select * from peserta where email = '".$data_irt->email."' and id_event = '".$id_event."'" )->row();

              $count_materi = $this->db->query("select materi_id from materi where id_event = '".$id_event."'" )->result();

              
           
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $peserta->nama;
            $row[] = $data_irt->email;
            $row[] = $peserta->asal_sekolah;
            $row[] = round($data_irt->skor2/count($count_materi),2);

           // $row[] = $data_irt->skor2;
           
           
          

            $data[] = $row;
        }
        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->Irt_tarik_M->count_all($id_event),
            "recordsFiltered" => $this->Irt_tarik_M->count_filtered($id_event),
            "data" => $data,
        );
        //output to json format
        $this->output->set_output(json_encode($output));
     }


     function print($id_event,$id_sekolah=null){
        error_reporting(0);
        
  
  
  
  
  
  
          $ev = $this->db->query('select kedinasan from event where id_event='.$id_event)->row();



        if($ev->kedinasan==1){
             $sql = $this->db->query("select *,sum(skor) as skor2  from jawaban where  id_event = '" . $id_event . "' and mode = 1 and email != '' group by email  order by skor2 desc ")->result();
        }
        if($ev->kedinasan==2){
             $sql = $this->db->query("select *,sum(skor) as skor2  from jawaban where  id_event = '" . $id_event . "' and mode = 1 and email != '' group by email  order by skor2 desc ")->result();
        }
        if($ev->kedinasan==3){
             $sql = $this->db->query("select j.*,(select sum(skor) from irt where irt.id_event='" . $id_event . "' and irt.email=p.email) as skor2
                from jawaban as j 
                inner join peserta as p on p.id_peserta = j.id_peserta 

                where  j.id_event = '" . $id_event . "' and j.mode = 1 and j.email != '' and p.id_sekolah = '".$id_sekolah."'
                group by j.email  order by skor2 desc ")->result();
        }


        else{
             $sql = $this->db->query("select *,sum(skor) as skor2  from irt where  id_event = '" . $id_event . "' and email != '' group by email  order by skor2 desc ")->result();
        }
  
          
  
  
           // echo "<pre>";
           // print_r($sql);
           // die;
  
  
          $skor = 0;
         // $no_ranking2 = 0;
          foreach ($sql as $s) {
  
  
  
               // $jurusan = $this->db->query("select * from jurusan where id_jurusan = " . $s->id_jurusan)->row();
  
              // $jenis = $this->db->query("select * from jenis where id_jenis = " . $jurusan->id_jenis)->row();
  
              // $kategori = $this->db->query("select * from kategori where id_kategori = " . $s->id_kategori)->row();
  
             // $irt = $this->db->query("select * from irt where email = '".$s->email."' and id_event = '".$id_event."'")->result();
  
               $peserta = $this->db->query("select * from peserta where email = '".$s->email."' and id_event = '".$id_event."'" )->row();
  
               $jawaban = $this->db->query("select tgl_mulai,create_add from jawaban where email = '".$s->email."' and id_event = '".$id_event."'" )->row();
  
                $count_materi = $this->db->query("select materi_id from materi where id_event = '".$id_event."'" )->result();

                $nama_event = $this->db->query('select judul from event where id_event="'.$id_event.'"')->row();

                
  
                 $waktu_awal        = strtotime($jawaban->tgl_mulai);
                $waktu_akhir    = strtotime($jawaban->create_add); // bisa juga waktu sekarang now()
  
              //menghitung selisih dengan hasil detik
              $diff    = $waktu_akhir - $waktu_awal;
  
  
              //  $skor = 0;
              // foreach($irt as $i){
              //      $skor += round($i->skor,2);
              // }
  
            //   echo "<pre>";
            //   print_r($nama_event);
            //   die;
  
             
  
              $data_api[] = array(
  
                 
                  //'no'=>$no_ranking2++,
                  'nama_judul'=>$nama_event->judul,
                  'nama'=>$peserta->nama,
                  'email'=>$s->email,
                  //'skor'=>round($s->skor2/count($count_materi),2),
                   'skor'=>$s->skor2,
                  'id_peserta'=>$peserta->id_peserta,
                  'asal_sekolah'=>$peserta->asal_sekolah,
                  'waktu' => floor($diff / 60),
                   'waktu_pengerjaan' => TanggalIndo(date('Y-m-d', strtotime($jawaban->tgl_mulai))) . ' ' . date('H:i:s', strtotime($jawaban->tgl_mulai)),
  
                   // 'waktu_pengerjaan' => $jawaban->tgl_mulai,
  
                   // 'waktu_pengerjaan' => TanggalIndo(date('Y-m-d', strtotime($peserta->create_add))) . ' ' . date('H:i:s', strtotime($peserta->create_add)),
                  
  
              );
          }

        //   echo "<pre>";
        //   print_r($data_api);
        //   die;
  
  
        //   if($data_api){
        //         echo json_encode($data_api);
        //     }else{
        //       $data_error = array(
  
        //           'status'=>400,
        //           'message'=>"tidak ditemukan",
  
        //       );
  
        //       echo json_encode($data_error);
  
        //    }

        $data['data_api'] = $data_api;

        $data['id_event'] = $id_event;

        $data['kedinasan'] = $ev->kedinasan;



        //$this->template->load('template','irt_tarik/print_irt_tarik.php',$data);

        $this->load->view('irt_tarik/print_irt_tarik.php',$data);
     }


     function sekolah_detail($id_sekolah2){
        $id_sekolah = base64_decode($id_sekolah2);

        $data['id_sekolah']= $id_sekolah2;
        $data['title'] = "Sekolah";

         $this->template->load('template','irt_tarik/sekolah/irt_sekolah_detail_v',$data);
     }

     function ajax_list_sekolah_detail($id_sekolah2){

        error_reporting(0);
               header('Content-Type: application/json');

          $id_sekolah = base64_decode($id_sekolah2);

         
         $list = $this->Irt_tarik_Sekolah_M->get_datatables($id_sekolah);
         // echo "<pre>";
         // print_r($list);
         // die;
         $data = array();
         $no = $this->input->post('start');
         //looping data mahasiswa
         foreach ($list as $data_event_sekolah) {



           
            
             $total_peserta = $this->db->query("select j.email from jawaban as j inner join peserta as p on p.id_peserta = j.id_peserta 
                where j.mode ='1' and j.id_event = '".$data_event_sekolah->id_event."' and p.id_sekolah = '".$data_event_sekolah->id_sekolah."'  group by j.email")->result();
 
 
             $print = "<a data-toggle='tooltip' title='Print'  href=".base_url('master/Irt_tarik/print/'.$data_event_sekolah->id_event.'/'.$data_event_sekolah->id_sekolah)."><button class='btn btn-primary btn-xs'>PRINT</button></a>";

            
              $tarik_irt = "<a data-toggle='tooltip' title='IRT'  onclick='return confirm(\"Apakah Anda Yakin \")' target='_blank' href=".base_url('api_mobile/Api_irt_sekolah/kirim_irt_skor/'.$data_event_sekolah->id_event.'/'.$data_event_sekolah->id_sekolah)."><button class='btn btn-success btn-xs'>Proses IRT</button></a>";
            
            
            
           
 
             $no++;
             $row = array();
             $row[] = $no;
             $row[] = $data_event_sekolah->judul;
            $row[] = date('d-m-Y',strtotime($data_event_sekolah->tgl_mulai_sekolah));
            $row[] = date('d-m-Y',strtotime($data_event_sekolah->tgl_selesai_sekolah));
             $row[] = count($total_peserta);
             $row[] = $tarik_irt;
              $row[] = $print;
            
           
 
             $data[] = $row;
         }
         $output = array(
             "draw" => $this->input->post('draw'),
             "recordsTotal" => $this->Event_M->count_all(),
             "recordsFiltered" => $this->Event_M->count_filtered(),
             "data" => $data,
         );
         //output to json format
         $this->output->set_output(json_encode($output));
     }


    

  



    
    
}
