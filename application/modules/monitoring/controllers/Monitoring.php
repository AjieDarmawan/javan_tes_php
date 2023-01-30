<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Monitoring extends CI_Controller
{


    function __construct(){
        parent::__construct();
        
         //$this->load->model(array('report/Pendaftar_webinar_M','report/Pendaftar_event_M'));
    
    }


    

    // redirect if needed, otherwise display the user list
    public function index()
    {

      error_reporting(0);
        $tgl_mulai = date('Y-m-d');
        $tgl_selesai = date('Y-m-d');



    

        $mulai = $_GET['mulai'];
        $selesai = $_GET['selesai'];

       if($mulai){ 
        $tgl_mulai = $mulai;
       }

       if($selesai){
        $tgl_selesai = $selesai;
       }

        
       
       $data["title"] = "List";
        $data_login = $this->db->query("select * from log_login where date(last_login)  BETWEEN '".$tgl_mulai."' AND '".$tgl_selesai."' and   email not in ('dymasgemilang@gmail.com','ajie.darmawan106@gmail.com','rahmandaroki@gmail.com','apreak@gmail.com','daniyal.hafidz@gmail.com','danil.mrprince@gmail.com','traffandy@gmail.com','arisaldi@edunovasi.com') group by email order by id_login desc ")->result();
        $data['login'] = $data_login;


        //  $total_data_login = $this->db->query("select count(*) as total from log_login where email not in ('dymasgemilang@gmail.com','ajie.darmawan106@gmail.com','rahmandaroki@gmail.com','apreak@gmail.com','daniyal.hafidz@gmail.com','danil.mrprince@gmail.com')
        //      and date(last_login)  BETWEEN '".$tgl_mulai."' AND '".$tgl_selesai."' group by email order by id_login desc ")->row();
        // $data['total_login'] = $total_data_login;



        $data_latihan = $this->db->query("select * from jawaban where date(create_add) BETWEEN '".$tgl_mulai."' AND '".$tgl_selesai."' and mode=2 and email not in ('dymasgemilang@gmail.com','ajie.darmawan106@gmail.com','rahmandaroki@gmail.com','apreak@gmail.com','daniyal.hafidz@gmail.com','danil.mrprince@gmail.com','traffandy@gmail.com','arisaldi@edunovasi.com')order by id_jawaban desc")->result();
        $data['latihan'] = $data_latihan;

         $total_data_latihan = $this->db->query("select count(*) as total from jawaban where mode=2 and email not in ('dymasgemilang@gmail.com','ajie.darmawan106@gmail.com','rahmandaroki@gmail.com','apreak@gmail.com','daniyal.hafidz@gmail.com','danil.mrprince@gmail.com','traffandy@gmail.com','arisaldi@edunovasi.com') 
              and date(create_add) BETWEEN '".$tgl_mulai."' AND '".$tgl_selesai."' order by id_jawaban desc")->row();




        $data['total_latihan'] = $total_data_latihan;




        $data_event = $this->db->query("select * from peserta where date(create_add) BETWEEN '".$tgl_mulai."' AND '".$tgl_selesai."'  and email not in ('dymasgemilang@gmail.com','ajie.darmawan106@gmail.com','rahmandaroki@gmail.com','apreak@gmail.com','daniyal.hafidz@gmail.com','danil.mrprince@gmail.com','traffandy@gmail.com','arisaldi@edunovasi.com') group by email order by id_peserta desc ")->result();
        $data['event'] = $data_event;


         $total_data_event = $this->db->query("select count(*) as total from peserta where email not in ('dymasgemilang@gmail.com','ajie.darmawan106@gmail.com','rahmandaroki@gmail.com','apreak@gmail.com','daniyal.hafidz@gmail.com','danil.mrprince@gmail.com','traffandy@gmail.com','arisaldi@edunovasi.com') 
             and date(create_add) BETWEEN '".$tgl_mulai."' AND '".$tgl_selesai."' group by email order by id_peserta desc ")->row();

        $data['total_event'] = $total_data_event;




        
          $data['webinar'] =  $this->db->query("select *,p.create_add as waktu from pendaftar as p 
          inner join webinar as w on w.id_webinar = p.id_event  where email not in ('dymasgemilang@gmail.com','ajie.darmawan106@gmail.com','rahmandaroki@gmail.com','apreak@gmail.com','daniyal.hafidz@gmail.com','danil.mrprince@gmail.com','traffandy@gmail.com','arisaldi@edunovasi.com') and date(p.create_add)   BETWEEN '".$tgl_mulai."' AND '".$tgl_selesai."' and p.kategori = 'webinar'")->result();  


          // echo "<pre>";
          // print_r($data['webinar']);



        $data['to_nasional'] =  $this->db->query("select *,p.id_event as topik from pendaftar as p where email not in ('dymasgemilang@gmail.com','ajie.darmawan106@gmail.com','rahmandaroki@gmail.com','apreak@gmail.com','daniyal.hafidz@gmail.com','danil.mrprince@gmail.com','traffandy@gmail.com','arisaldi@edunovasi.com') and date(p.create_add) 
                    BETWEEN '".$tgl_mulai."' AND '".$tgl_selesai."' and p.kategori = 'tryout'")->result();  











        $url = "https://dev-api.edunitas.com/login_register_api_tryout";
        $ch = curl_init($url);

        $postData = array(
          "tgl_awal"=> $tgl_mulai,
          "tgl_akhir"=>$tgl_selesai,

     );

   // for sending data as json type
   $fields = json_encode($postData);


        curl_setopt(
        $ch,
        CURLOPT_HTTPHEADER,
        array(
          'Content-Type: application/json', // if the content type is json
        //  'bearer: '.$token // if you need token in header
        )
        );

          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
          curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);


          $result = curl_exec($ch);
          curl_close($ch);



          $output = json_decode($result);
          $data['register'] = $output;

          $data['tgl_awal'] = $tgl_mulai;
          $data['tgl_akhir'] = $tgl_selesai;


       


        $this->load->view('monitoring/monitoring_v',$data);
     
    }

    function print($tgl_mulai,$tgl_selesai){

      error_reporting(0);
      $data_login = $this->db->query("select * from log_login where date(last_login)  BETWEEN '".$tgl_mulai."' AND '".$tgl_selesai."' and   email not in ('dymasgemilang@gmail.com','ajie.darmawan106@gmail.com','rahmandaroki@gmail.com','apreak@gmail.com','daniyal.hafidz@gmail.com','danil.mrprince@gmail.com','traffandy@gmail.com','arisaldi@edunovasi.com') group by email order by id_login desc")->result();
      $data['login'] = $data_login;


       $total_data_login = $this->db->query("select count(*) as total from log_login where email not in ('dymasgemilang@gmail.com','ajie.darmawan106@gmail.com','rahmandaroki@gmail.com','apreak@gmail.com','daniyal.hafidz@gmail.com','danil.mrprince@gmail.com','traffandy@gmail.com','arisaldi@edunovasi.com')
           and date(last_login)  BETWEEN '".$tgl_mulai."' AND '".$tgl_selesai."'  group by email order by id_login desc")->row();
      $data['total_login'] = $total_data_login;



      $data_latihan = $this->db->query("select * from jawaban where date(create_add) BETWEEN '".$tgl_mulai."' AND '".$tgl_selesai."' and mode=2 and email not in ('dymasgemilang@gmail.com','ajie.darmawan106@gmail.com','rahmandaroki@gmail.com','apreak@gmail.com','daniyal.hafidz@gmail.com','danil.mrprince@gmail.com','traffandy@gmail.com','arisaldi@edunovasi.com')order by id_jawaban desc")->result();
      $data['latihan'] = $data_latihan;

       $total_data_latihan = $this->db->query("select count(*) as total from jawaban where mode=2 and email not in ('dymasgemilang@gmail.com','ajie.darmawan106@gmail.com','rahmandaroki@gmail.com','apreak@gmail.com','daniyal.hafidz@gmail.com','danil.mrprince@gmail.com','traffandy@gmail.com','arisaldi@edunovasi.com') 
            and date(create_add) BETWEEN '".$tgl_mulai."' AND '".$tgl_selesai."' order by id_jawaban desc")->row();




      $data['total_latihan'] = $total_data_latihan;




      $data_event = $this->db->query("select * from peserta where date(create_add) BETWEEN '".$tgl_mulai."' AND '".$tgl_selesai."'  and email not in ('dymasgemilang@gmail.com','ajie.darmawan106@gmail.com','rahmandaroki@gmail.com','apreak@gmail.com','daniyal.hafidz@gmail.com','danil.mrprince@gmail.com','traffandy@gmail.com','arisaldi@edunovasi.com') group by email order by id_peserta desc")->result();
      $data['event'] = $data_event;


       $total_data_event = $this->db->query("select count(*) as total from peserta where email not in ('dymasgemilang@gmail.com','ajie.darmawan106@gmail.com','rahmandaroki@gmail.com','apreak@gmail.com','daniyal.hafidz@gmail.com','danil.mrprince@gmail.com','traffandy@gmail.com','arisaldi@edunovasi.com') 
           and date(create_add) BETWEEN '".$tgl_mulai."' AND '".$tgl_selesai."' group by email order by id_peserta desc")->row();

      $data['total_event'] = $total_data_event;



      $url = "https://dev-api.edunitas.com/login_register_api_tryout";
      $ch = curl_init($url);

      $postData = array(
        "tgl_awal"=> $tgl_mulai,
        "tgl_akhir"=>$tgl_selesai,

   );

 // for sending data as json type
 $fields = json_encode($postData);


      curl_setopt(
      $ch,
      CURLOPT_HTTPHEADER,
      array(
        'Content-Type: application/json', // if the content type is json
      //  'bearer: '.$token // if you need token in header
      )
      );

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);


        $result = curl_exec($ch);
        curl_close($ch);



        $output = json_decode($result);
        $data_register = $output;



    $webinar =  $this->db->query("select * from pendaftar as p 
                  inner join webinar as w on w.id_webinar = p.id_event  where  date(p.create_add)   BETWEEN '".$tgl_mulai."' AND '".$tgl_selesai."' and p.kategori = 'webinar' and email not in ('dymasgemilang@gmail.com','ajie.darmawan106@gmail.com','rahmandaroki@gmail.com','apreak@gmail.com','daniyal.hafidz@gmail.com','danil.mrprince@gmail.com','traffandy@gmail.com','arisaldi@edunovasi.com') ")->result();  

  

    $to_nasional =  $this->db->query("select *,p.id_event as topik from pendaftar as p where date(p.create_add) 
                    BETWEEN '".$tgl_mulai."' AND '".$tgl_selesai."' and p.kategori = 'tryout' and email not in ('dymasgemilang@gmail.com','ajie.darmawan106@gmail.com','rahmandaroki@gmail.com','apreak@gmail.com','daniyal.hafidz@gmail.com','danil.mrprince@gmail.com','traffandy@gmail.com','arisaldi@edunovasi.com')")->result();   




    include APPPATH.'third_party/PHPExcel/PHPExcel.php';
    
     
    $objPHPExcel = new PHPExcel();

     
     $i=0;
    //  while ($i < 10) {
 
       // Add new sheet

       

       $objWorkSheet = $objPHPExcel->createSheet(0); //Setting index when creating

      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', "NO"); // Set kolom A3 dengan tulisan "NO"
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B3', "EMAIL"); // Set kolom B3 dengan tulisan "NIS"
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C3', "NAMA"); // Set kolom C3 dengan tulisan "NAMA"
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D3', "Waktu Login"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
      
 
     
     $no = 1; // Untuk penomoran tabel, di awal set dengan 1
    $numrow = 4; // Set baris pertama untuk isi tabel adalah baris ke 4
    foreach($data_login as $l){ // Lakukan looping pada variabel siswa
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $l->email);
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $l->nama);
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $l->last_login);
   
      
 
      
      $no++; // Tambah 1 setiap kali looping
      $numrow++; // Tambah 1 setiap kali looping
    }
      
 
       // Rename sheet
       $objWorkSheet->setTitle("Login");





       $objWorkSheet = $objPHPExcel->createSheet(1); //Setting index when creating

       $objPHPExcel->setActiveSheetIndex(1)->setCellValue('A3', "NO"); // Set kolom A3 dengan tulisan "NO"
       $objPHPExcel->setActiveSheetIndex(1)->setCellValue('B3', "Event"); // Set kolom B3 dengan tulisan "NIS"
       $objPHPExcel->setActiveSheetIndex(1)->setCellValue('C3', "Materi"); // Set kolom C3 dengan tulisan "NAMA"
       $objPHPExcel->setActiveSheetIndex(1)->setCellValue('D3', "Nama"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
       $objPHPExcel->setActiveSheetIndex(1)->setCellValue('E3', "Email"); 
       $objPHPExcel->setActiveSheetIndex(1)->setCellValue('F3', "Waktu"); 
 
    
      $no_latihan = 1;
      $numrow_latihan = 6;
      foreach($data_latihan as $l){
        
        
        $nama = $this->db->query('select * from log_login where email="'.$l->email.'"')->row();

        $materi = $this->db->query('select * from materi where materi_id="'.$l->materi_id.'"')->row();

        $event = $this->db->query('select * from event where id_event="'.$l->id_event.'"')->row();
        
        
        // Lakukan looping pada variabel siswa
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('A'.$numrow_latihan, $no_latihan);
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('B'.$numrow_latihan, $event->judul);
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('C'.$numrow_latihan, $materi->materi_nama);
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('D'.$numrow_latihan, $nama->nama);
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('E'.$numrow_latihan, $l->email);
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('F'.$numrow_latihan, TanggalIndo($l->create_add). ' ' .date('H:i:s',strtotime($l->create_add)));
        
        
        
        $no_latihan++; // Tambah 1 setiap kali looping
        $numrow_latihan++; // Tambah 1 setiap kali looping
      }
 
       // Rename sheet
       $objWorkSheet->setTitle("Materi");






       $objWorkSheet = $objPHPExcel->createSheet(2); //Setting index when creating

       $objPHPExcel->setActiveSheetIndex(2)->setCellValue('A3', "NO"); // Set kolom A3 dengan tulisan "NO"
       $objPHPExcel->setActiveSheetIndex(2)->setCellValue('B3', "Kategori"); // Set kolom B3 dengan tulisan "NIS"
       $objPHPExcel->setActiveSheetIndex(2)->setCellValue('C3', "Event"); // Set kolom C3 dengan tulisan "NAMA"
       $objPHPExcel->setActiveSheetIndex(2)->setCellValue('D3', "Nama"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
       $objPHPExcel->setActiveSheetIndex(2)->setCellValue('E3', "Email"); 
       $objPHPExcel->setActiveSheetIndex(2)->setCellValue('F3', "Wilayah"); 
       $objPHPExcel->setActiveSheetIndex(2)->setCellValue('G3', "Kampus Impian"); 
       $objPHPExcel->setActiveSheetIndex(2)->setCellValue('H3', "Asal Sekolah"); 
       $objPHPExcel->setActiveSheetIndex(2)->setCellValue('I3', "Waktu Login"); 
       $objPHPExcel->setActiveSheetIndex(2)->setCellValue('J3', "Usia");
       $objPHPExcel->setActiveSheetIndex(2)->setCellValue('K3', "Kelas"); 
         $objPHPExcel->setActiveSheetIndex(2)->setCellValue('L3', "No Wa");

            $objPHPExcel->setActiveSheetIndex(2)->setCellValue('M3', "Jenis Kelamin");
               $objPHPExcel->setActiveSheetIndex(2)->setCellValue('N3', "Sumber Informasi");
                  $objPHPExcel->setActiveSheetIndex(2)->setCellValue('O3', "Kab / Kota"); 
                   $objPHPExcel->setActiveSheetIndex(2)->setCellValue('P3', "Provinsi"); 
                    $objPHPExcel->setActiveSheetIndex(2)->setCellValue('Q3', "Kampus Favorit Edunitas"); 

        // $objPHPExcel->setActiveSheetIndex(2)->setCellValue('M3', "Jurusan diinginkan"); 

 

       $no_event = 1;
       $numrow_event = 8;
      foreach($data_event as $l){ // Lakukan looping pada variabel siswa

        $event = $this->db->query('select * from event where id_event="'.$l->id_event.'"')->row();

         $kategori = $this->db->query('select * from kategori where id_kategori="'.$event->id_kategori.'"')->row();

          $pendaftar = $this->db->query('select * from pendaftar where email="'.$l->email.'" and kategori="tryout"')->row();

          $peserta = $this->db->query('select * from peserta where email="'.$l->email.'" ')->row();

          if($pendaftar->usia){
            $usia2 = $pendaftar->usia;
          }else{
            $usia2 = 'kosong';
          }

          if($pendaftar->tingkatan){
            $kelas2 = $pendaftar->tingkatan;
          }else{
            $kelas2 = 'kosong';
          }

          if($pendaftar->jenis_kelamin){
            $jenis_kelamin2 = $pendaftar->jenis_kelamin;
          }else{
            $jenis_kelamin2 = 'kosong';
          }


          if($pendaftar->sumber_informasi){
            $sumber_informasi2 = $pendaftar->sumber_informasi;
          }else{
            $sumber_informasi2 = 'kosong';
          }

          if($pendaftar->provinsi){
            $provinsi2 = $pendaftar->provinsi;
          }else{
            $provinsi2 = 'kosong';
          }





          if($peserta->no_wa){
            $no_wa2 = $peserta->no_wa;
          }else{
            $no_wa2 = 'kosong';
          }

          if($peserta->jurusan_diinginkan){
            $jurusan_diinginkan2 = $peserta->jurusan_diinginkan;
          }else{
            $jurusan_diinginkan2 = 'kosong';
          }


         


        $objPHPExcel->setActiveSheetIndex(2)->setCellValue('A'.$numrow_event, $no_event);
        $objPHPExcel->setActiveSheetIndex(2)->setCellValue('B'.$numrow_event, $kategori->kategori_nama);
        $objPHPExcel->setActiveSheetIndex(2)->setCellValue('C'.$numrow_event, $event->judul);
        $objPHPExcel->setActiveSheetIndex(2)->setCellValue('D'.$numrow_event, $l->nama);
        $objPHPExcel->setActiveSheetIndex(2)->setCellValue('E'.$numrow_event, $l->email);
        $objPHPExcel->setActiveSheetIndex(2)->setCellValue('F'.$numrow_event, $l->wilayah);
        $objPHPExcel->setActiveSheetIndex(2)->setCellValue('G'.$numrow_event, $l->kampus_impian);
        $objPHPExcel->setActiveSheetIndex(2)->setCellValue('H'.$numrow_event, $l->asal_sekolah);
        $objPHPExcel->setActiveSheetIndex(2)->setCellValue('I'.$numrow_event, TanggalIndo($l->create_add). ' ' .date('H:i:s',strtotime($l->create_add)));
         $objPHPExcel->setActiveSheetIndex(2)->setCellValue('J'.$numrow_event, $usia2);
         $objPHPExcel->setActiveSheetIndex(2)->setCellValue('K'.$numrow_event, $kelas2);

         $objPHPExcel->setActiveSheetIndex(2)->setCellValue('L'.$numrow_event, $no_wa2);

          $objPHPExcel->setActiveSheetIndex(2)->setCellValue('M'.$numrow_event, $jenis_kelamin2);

      $objPHPExcel->setActiveSheetIndex(2)->setCellValue('N'.$numrow_event, $sumber_informasi2);
       $objPHPExcel->setActiveSheetIndex(2)->setCellValue('O'.$numrow_event, $peserta->wilayah);
       $objPHPExcel->setActiveSheetIndex(2)->setCellValue('P'.$numrow_event, $peserta->provinsi);
       $objPHPExcel->setActiveSheetIndex(2)->setCellValue('Q'.$numrow_event, $peserta->kampus_favorit);

       



        //  $objPHPExcel->setActiveSheetIndex(2)->setCellValue('M'.$numrow_event, $jurusan_diinginkan2);
          
        
        $no_event++; // Tambah 1 setiap kali looping
        $numrow_event++; // Tambah 1 setiap kali looping
      }
 
       // Rename sheet
       $objWorkSheet->setTitle("Event");
 
    //    $i++;
    //  }



     $objPHPExcel->setActiveSheetIndex(3);
   // $objWorkSheet = $objPHPExcel->createSheet(3); 
    $table_columns = array("Email", "Nama Lengkap", "No TLPN", "NO Wa", "Pendidikan");
    $column = 0;
    foreach($table_columns as $field)
    {
     $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
     $column++;
    }
    
    $excel_row = 2;
    foreach($data_register as $row)
    {
     $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row->email);
     $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row->namalengkap);
     $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row->notlp);
     $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $row->nowa);
     $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $row->leveledu);
 
     $excel_row++;
    }






    $objWorkSheet = $objPHPExcel->createSheet(4); //Setting index when creating

    $objPHPExcel->setActiveSheetIndex(4)->setCellValue('A3', "NO"); // Set kolom A3 dengan tulisan "NO"
    $objPHPExcel->setActiveSheetIndex(4)->setCellValue('B3', "Topik"); // Set kolom B3 dengan tulisan "NIS"
    $objPHPExcel->setActiveSheetIndex(4)->setCellValue('C3', "Email"); // Set kolom C3 dengan tulisan "NAMA"
    $objPHPExcel->setActiveSheetIndex(4)->setCellValue('D3', "Nama"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
    $objPHPExcel->setActiveSheetIndex(4)->setCellValue('E3', "Wilayah"); 
    $objPHPExcel->setActiveSheetIndex(4)->setCellValue('F3', "No Wa"); 
    $objPHPExcel->setActiveSheetIndex(4)->setCellValue('G3', "kampus_impian"); 
    $objPHPExcel->setActiveSheetIndex(4)->setCellValue('H3', "jurusan_diinginkan"); 

    $objPHPExcel->setActiveSheetIndex(4)->setCellValue('I3', "asal_sekolah"); 
    $objPHPExcel->setActiveSheetIndex(4)->setCellValue('J3', "Provinsi"); 
    $objPHPExcel->setActiveSheetIndex(4)->setCellValue('K3', "Sumber Informasi"); 
    $objPHPExcel->setActiveSheetIndex(4)->setCellValue('L3', "Tingkatan"); 
     $objPHPExcel->setActiveSheetIndex(4)->setCellValue('M3', "Usia"); 
    $objPHPExcel->setActiveSheetIndex(4)->setCellValue('N3', "Waktu Daftar"); 





    $no_webinar = 1;
    $numrow_webinar = 8;
   foreach($webinar as $l){ // Lakukan looping pada variabel siswa


     

     $objPHPExcel->setActiveSheetIndex(4)->setCellValue('A'.$numrow_webinar, $no_webinar);
     $objPHPExcel->setActiveSheetIndex(4)->setCellValue('B'.$numrow_webinar, $l->topik);
     $objPHPExcel->setActiveSheetIndex(4)->setCellValue('C'.$numrow_webinar, $l->email);
     $objPHPExcel->setActiveSheetIndex(4)->setCellValue('D'.$numrow_webinar, $l->nama);
     $objPHPExcel->setActiveSheetIndex(4)->setCellValue('E'.$numrow_webinar, $l->wilayah);
     $objPHPExcel->setActiveSheetIndex(4)->setCellValue('F'.$numrow_webinar, $l->no_wa);
     $objPHPExcel->setActiveSheetIndex(4)->setCellValue('G'.$numrow_webinar, $l->kampus_impian);

     $objPHPExcel->setActiveSheetIndex(4)->setCellValue('H'.$numrow_webinar, $l->jurusan_diinginkan);
     $objPHPExcel->setActiveSheetIndex(4)->setCellValue('I'.$numrow_webinar, $l->asal_sekolah);
     $objPHPExcel->setActiveSheetIndex(4)->setCellValue('J'.$numrow_webinar, $l->provinsi);
     $objPHPExcel->setActiveSheetIndex(4)->setCellValue('K'.$numrow_webinar, $l->sumber_informasi);
     $objPHPExcel->setActiveSheetIndex(4)->setCellValue('L'.$numrow_webinar, $l->tingkatan);
       $objPHPExcel->setActiveSheetIndex(4)->setCellValue('M'.$numrow_webinar, $l->usia);
     $objPHPExcel->setActiveSheetIndex(4)->setCellValue('N'.$numrow_webinar, TanggalIndo($l->create_add). ' ' .date('H:i:s',strtotime($l->create_add)));
     
   
     
     $no_webinar++; // Tambah 1 setiap kali looping
     $numrow_webinar++; // Tambah 1 setiap kali looping
   }

  
    $objWorkSheet->setTitle("Webinar");







    $objWorkSheet = $objPHPExcel->createSheet(5); //Setting index when creating

    $objPHPExcel->setActiveSheetIndex(5)->setCellValue('A3', "NO"); // Set kolom A3 dengan tulisan "NO"
    $objPHPExcel->setActiveSheetIndex(5)->setCellValue('B3', "Topik"); // Set kolom B3 dengan tulisan "NIS"
    $objPHPExcel->setActiveSheetIndex(5)->setCellValue('C3', "Email"); // Set kolom C3 dengan tulisan "NAMA"
    $objPHPExcel->setActiveSheetIndex(5)->setCellValue('D3', "Nama"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
    $objPHPExcel->setActiveSheetIndex(5)->setCellValue('E3', "Wilayah"); 
    $objPHPExcel->setActiveSheetIndex(5)->setCellValue('F3', "No Wa"); 
    $objPHPExcel->setActiveSheetIndex(5)->setCellValue('G3', "kampus_impian"); 
    $objPHPExcel->setActiveSheetIndex(5)->setCellValue('H3', "jurusan_diinginkan"); 

    $objPHPExcel->setActiveSheetIndex(5)->setCellValue('I3', "asal_sekolah"); 
    $objPHPExcel->setActiveSheetIndex(5)->setCellValue('J3', "Provinsi"); 
    $objPHPExcel->setActiveSheetIndex(5)->setCellValue('K3', "Sumber Informasi"); 
    $objPHPExcel->setActiveSheetIndex(5)->setCellValue('L3', "Tingkatan"); 
    $objPHPExcel->setActiveSheetIndex(5)->setCellValue('M3', "Usia");
    $objPHPExcel->setActiveSheetIndex(5)->setCellValue('N3', "Waktu Daftar"); 
     $objPHPExcel->setActiveSheetIndex(5)->setCellValue('O3', "Jenis Kelamin"); 
      $objPHPExcel->setActiveSheetIndex(5)->setCellValue('P3', "Informasi TO"); 
       $objPHPExcel->setActiveSheetIndex(5)->setCellValue('Q3', "Kab/kota"); 




    $no_to_nasional = 1;
    $numrow_to_nasional = 8;
   foreach($to_nasional as $l){ // Lakukan looping pada variabel siswa


    if($l->topik==999){
      $judul = "SOSHUM";
  }elseif($e->topik==998){
      $judul = "SAINTEK";
  }else{
      $judul = "SAINTEK";
  }
     

     $objPHPExcel->setActiveSheetIndex(5)->setCellValue('A'.$numrow_to_nasional, $no_to_nasional);
     $objPHPExcel->setActiveSheetIndex(5)->setCellValue('B'.$numrow_to_nasional, $judul);
     $objPHPExcel->setActiveSheetIndex(5)->setCellValue('C'.$numrow_to_nasional, $l->email);
     $objPHPExcel->setActiveSheetIndex(5)->setCellValue('D'.$numrow_to_nasional, $l->nama);
     $objPHPExcel->setActiveSheetIndex(5)->setCellValue('E'.$numrow_to_nasional, $l->wilayah);
     $objPHPExcel->setActiveSheetIndex(5)->setCellValue('F'.$numrow_to_nasional, $l->no_wa);
     $objPHPExcel->setActiveSheetIndex(5)->setCellValue('G'.$numrow_to_nasional, $l->kampus_impian);

     $objPHPExcel->setActiveSheetIndex(5)->setCellValue('H'.$numrow_to_nasional, $l->jurusan_diinginkan);
     $objPHPExcel->setActiveSheetIndex(5)->setCellValue('I'.$numrow_to_nasional, $l->asal_sekolah);
     $objPHPExcel->setActiveSheetIndex(5)->setCellValue('J'.$numrow_to_nasional, $l->provinsi);
     $objPHPExcel->setActiveSheetIndex(5)->setCellValue('K'.$numrow_to_nasional, $l->sumber_informasi);
     $objPHPExcel->setActiveSheetIndex(5)->setCellValue('L'.$numrow_to_nasional, $l->tingkatan);
      $objPHPExcel->setActiveSheetIndex(5)->setCellValue('M'.$numrow_to_nasional, $l->usia);
     $objPHPExcel->setActiveSheetIndex(5)->setCellValue('N'.$numrow_to_nasional, TanggalIndo($l->create_add). ' ' .date('H:i:s',strtotime($l->create_add)));
     $objPHPExcel->setActiveSheetIndex(5)->setCellValue('O'.$numrow_to_nasional, $l->jenis_kelamin);

      $objPHPExcel->setActiveSheetIndex(5)->setCellValue('P'.$numrow_to_nasional, $l->sumber_informasi);
       $objPHPExcel->setActiveSheetIndex(5)->setCellValue('Q'.$numrow_to_nasional, $l->wilayah);
     
   
     
     $no_to_nasional++; // Tambah 1 setiap kali looping
     $numrow_to_nasional++; // Tambah 1 setiap kali looping
   }

  
    $objWorkSheet->setTitle("TO nasional");
















   //$objWorkSheet->setTitle("Register");
     
     $filename='file-name'.'.xls'; //save our workbook as this file name
     header('Content-Type: application/vnd.ms-excel'); //mime type
     header('Content-Disposition: attachment;filename="Data Report".xlsx'); //tell browser what's the file name
     header('Cache-Control: max-age=0'); //no cach
     
     // $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

      $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
     $objWriter->save('php://output');

   }

 }


       
      
     
    


  


  
   


