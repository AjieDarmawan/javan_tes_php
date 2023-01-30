<?php

defined('BASEPATH') or exit('No direct script access allowed');


Header('Access-Control-Allow-Origin: *'); //for allow any domain, insecure
Header('Access-Control-Allow-Headers: *'); //for allow any headers, insecure
Header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');


class Api_m_sekolah extends CI_Controller
{
  
    function convertToObject($array)
    {
        $object = new stdClass();
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $value = $this->convertToObject($value);
            }
            $object->$key = $value;
        }
        return $object;
    }

    protected function objToArray($obj)
    {
        // Not an object or array
        if (!is_object($obj) && !is_array($obj)) {
            return $obj;
        }

        // Parse array
        foreach ($obj as $key => $value) {
            $arr[$key] = $this->objToArray($value);
        }

        // Return parsed array
        return $arr;
    }

    function sortAssociativeArrayByKey($array, $key, $direction)
    {

        switch ($direction) {
            case "ASC":
                usort($array, function ($first, $second) use ($key) {
                    return $first[$key] <=> $second[$key];
                });
                break;
            case "DESC":
                usort($array, function ($first, $second) use ($key) {
                    return $second[$key] <=> $first[$key];
                });
                break;
            default:
                break;
        }

        return $array;
    }

    function event($id_sekolah)
    {
        

        error_reporting(0);
        header('Access-Control-Allow-Origin: *');
        // header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
        header('Content-Type: application/json');

        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Cache-Control, Pragma, Authorization, Accept, Accept-Encoding");




        $sql = $this->db->query("select es.tgl_mulai_sekolah as tgl_mulai_event_sekolah, es.tgl_selesai_sekolah as tgl_selesai_event_sekolah, se.photo,se.nama_sekolah,es.id_sekolah,e.*,j.kategori_nama,j.id_kategori from event as e 
        inner JOIN kategori as j on e.id_kategori=j.id_kategori
        inner join event_sekolah as es on es.id_event = e.id_event
        inner join m_sekolah as se on se.id_m_sekolah = es.id_sekolah
                where  e.mode='event' and kedinasan = 3 and es.publish_sekolah = 1 and es.id_sekolah='".$id_sekolah."' and CURRENT_DATE() >= e.tgl_mulai and CURRENT_DATE() <= e.tgl_selesai ")->result();


        $hariini = date('Y-m-d');

        //$hariini = '2022-03-06';

        foreach ($sql as $key => $s) {





            // $waktu = $this->db->query("select waktu,materi_id from materi where publish = 1 and id_event = ".$s->id_event)->result();
            // $kategori = $this->db->query("select kategori_nama from kategori where id_kategori = ".$s->id_kategori)->row();




            // $wak = 0;
            // foreach($waktu as $w){

            //     $soal[] = $this->db->query("select * from soalonline where materi_id = ".$w->materi_id)->result();
            //     // $jumlah_soal = 0;
            //     // foreach($soal as $so){
            //     //     $jumlah_soal += count($soal);
            //     // }

            //     $wak += $w->waktu;
            // }

            // $j_soal = 0;
            // foreach($soal as $k){
            //     $j_soal += count($k);
            // }



            if ($hariini >= $s->tgl_mulai_event_sekolah) {

                //jika hari ini kurang dari tgl selesai
                if ($s->tgl_selesai >= $hariini) {

                    $waktu = $this->db->query("select waktu,materi_id from materi where publish = 1 and id_event = " . $s->id_event)->result();
                    $kategori = $this->db->query("select kategori_nama from kategori where id_kategori = " . $s->id_kategori)->row();



                    // $soal = $this->db->query("select * from soalonline where materi_id = ".$s->materi_id)->result();




                    $wak = 0;
                    foreach ($waktu as $w) {

                        $soal[$s->id_event][] = $this->db->query("select * from soalonline where materi_id = " . $w->materi_id)->result();


                        $wak += $w->waktu;
                    }

                    $jumlah_soal = 0;
                    foreach ($soal[$s->id_event] as $so) {

                        // echo "<pre>";
                        //     print_r($so);

                        foreach ($so as $sk) {
                            $jumlah_soal += 1;
                        }
                    }

                    if ($jumlah_soal != 0) {
                        $data_api[] = array(
                            "id_event" => base64_encode($s->id_event),
                            "judul" => $s->judul,
                            "tgl_mulai" => TanggalIndo($s->tgl_mulai),
                            "tgl_selesai" => TanggalIndo($s->tgl_selesai),
                            "desc" => $s->desc,
                            "img" => $s->img,
                            "status" => $s->status,
                            "mode" => $s->mode,
                            // "materi_id" => $s->materi_id,
                            // "materi_nama"=> $s->materi_nama,
                            // "id_jurusan"=> $s->id_jurusan,
                            "waktu" => $wak,
                            //"jurusan"=>$jurusan->jurusan_nama,
                            'jenis' => $s->jenis_nama,
                            'kategori' => $kategori->kategori_nama,
                            'jumlah_soal' => $jumlah_soal,
                             'kedinasan' => $s->kedinasan,
                             
                        );
                    }
                }
            }
        }

        if($sql[0]->photo){
            $photo = base_url('assets/file_upload/sekolah/'.$sql[0]->photo);
        }else{
            $photo = base_url('assets/file_upload/sekolah/UN-Online.jpg');
        }

        

        if ($data_api) {
            error_reporting(0);
            $data_api_sukses = array(
                'status' => 200,
                'message' => "sukses",
                'id_sekolah'=>$sql[0]->id_sekolah,
                'nama_sekolah'=>$sql[0]->nama_sekolah,
                'photo'=>$photo,
                'datanya' => $data_api
            );
            echo json_encode($data_api_sukses);

            // echo json_encode($data_api);
        } else {

            $data_error[] = array(
            "id_event"=> "MzA=",
            "judul"=> "Pekan I - Try Out",
            "tgl_mulai"=> "09 April 2022",
            "tgl_selesai"=> "10 April 2022",
            "desc"=> "Soal Soshum Final",
            "img"=> null,
            "status"=> null,
            "mode"=> "event",
            "waktu"=> 197,
            "jenis"=> null,
            "kategori"=> "SOSHUM",
            "jumlah_soal"=> 139,
            
);
            $data_api_error = array(
                'status' => 400,
                'id_sekolah'=>1,
                'nama_sekolah'=>'tes',
                'photo'=>'tes',
                'message' => "data kosong",
                'datanya' => $data_error,
            );
            echo json_encode($data_api_error);
        }
    }

    public function simpan(){

         error_reporting(0);
        header('Access-Control-Allow-Origin: *');
        // header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
        header('Content-Type: application/json');

        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Cache-Control, Pragma, Authorization, Accept, Accept-Encoding");


        // echo "<pre>";
        // print_r($_POST);
        // die;

        $nama_sekolah   = $this->input->post('nama_sekolah');

       
        $alamat_sekolah = $this->input->post('alamat_sekolah');
        $nama_pendaftar = $this->input->post('nama_pendaftar');
        $provinsi       = $this->input->post('provinsi');
        $kota           = $this->input->post('kota');

        $email          = $this->input->post('email');
        $jumlah_siswa   = $this->input->post('jumlah_siswa');
        $no_wa   = $this->input->post('no_wa');

         $kecamatan   = $this->input->post('kecamatan');
           $status_pendaftar   = $this->input->post('status_pendaftar');



         $cek_data = $this->db->query('select email from m_sekolah where email="'.$email.'"')->row();

        if($cek_data->email==$email){
            $data_json['status'] = 402;
            $data_json['message'] = "Email Anda Sudah Pernah Terdaftar";
        }else{

            
            $this->load->library('upload');
            $config_img['upload_path']          = './assets/file_upload/sekolah/';
            $config_img['allowed_types']        = 'gif|jpg|png|jpeg';
            $img_gambar                         = "sekolah".date('Ymd').mt_rand(1000, 9999);
            $config_img['file_name']            = $img_gambar;
         
      
            $this->upload->initialize($config_img);
      
            if ($this->upload->do_upload('img')){
      
              $data = array('upload_data' => $this->upload->data());
        
                  $filename= $data['upload_data']['file_name'];
    
                  $data_simpan = array(
                    'nama_sekolah'=>$nama_sekolah,
                    'nama_pendaftar'=>$nama_pendaftar,
                    'provinsi'=>$provinsi,
                    'email'=>$email,
                    'jumlah_siswa'=>$jumlah_siswa,
                    'kota'=>$kota,
                    'alamat_sekolah'=>$alamat_sekolah,
                    'no_wa'=>$no_wa,
                    'photo'=>$filename,
                    'kecamatan'=>$kecamatan,
                    'status_pendaftar'=>$status_pendaftar,
        
                );
      
              
            }else{
              $error = array('error' => $this->upload->display_errors());
              $data_simpan = array(
                'nama_sekolah'=>$nama_sekolah,
                'nama_pendaftar'=>$nama_pendaftar,
                'provinsi'=>$provinsi,
                'email'=>$email,
                'jumlah_siswa'=>$jumlah_siswa,
                'kota'=>$kota,
                'alamat_sekolah'=>$alamat_sekolah,
                'no_wa'=>$no_wa,
                 'kecamatan'=>$kecamatan,
                 'status_pendaftar'=>$status_pendaftar,
    
            );
            }



            
    
            $q = $this->db->insert('m_sekolah',$data_simpan);
    
            if($q){
                $data_json['status'] = 200;
                $data_json['message'] = "success";
    
            }else{
                 $data_json['status'] = 400;
                $data_json['message'] = "gagal";
            }
        }

        

        echo json_encode($data_json);
    }

    function sinkron(){

         error_reporting(0);
        header('Access-Control-Allow-Origin: *');
        // header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
        header('Content-Type: application/json');

        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Cache-Control, Pragma, Authorization, Accept, Accept-Encoding");



        $email = $this->input->post('email');
        $kode_sekolah = $this->input->post('kode_sekolah');

        $sinkron = $this->db->query('select id_m_sekolah from m_sinkron_sekolah where email = "'.$email.'"')->row();


       

        if($sinkron){
            $data_json['status'] = 400;
            $data_json['message'] = "Anda Sudah Singkron";

        }else{

             $cari_sekolah = $this->db->query('select id_m_sekolah from m_sekolah where kode_sekolah = "'.$kode_sekolah.'"')->row();

             if($cari_sekolah){
                     $data_simpan = array(
                    'email'=>$email,
                    'id_m_sekolah'=>$cari_sekolah->id_m_sekolah,
                    'crdt'=>date('Y-m-d H:i:s'),
                    
                 );
                $this->db->insert('m_sinkron_sekolah',$data_simpan);
                $data_json['status'] = 200;
                $data_json['message'] = "Sukses";
                 $data_json['id_sekolah'] = $cari_sekolah->id_m_sekolah;
             }else{
                 $data_json['status'] = 404;
                 $data_json['message'] = "Kode Sekolah Tidak Ditemukan";
                 $data_json['id_sekolah'] = 0;
             }
           
        }

        echo json_encode($data_json);
    

    }


       function detail($id_event,$id_sekolah2,$email2)
    {

        $id_event2 = base64_decode($id_event);
        $id_sekolah = base64_decode($id_sekolah2);
         $email = base64_decode($email2);


        


        $sql = $this->db->query("select e.*,es.tgl_mulai_sekolah as tgl_mulai_event_sekolah,es.tgl_selesai_sekolah as tgl_selesai_event_sekolah,m.materi_id,m.materi_nama,m.id_jurusan,m.waktu 
            from event as e
        inner join materi as m on m.id_event = e.id_event
        inner join event_sekolah as es on es.id_event = e.id_event 

        where m.publish = 1 and e.id_event = '" . $id_event2 . "' and es.id_sekolah = '".$id_sekolah."' order by m.no_urut asc")->result();


        foreach ($sql as $s) {

            $jurusan = $this->db->query("select id_jenis,jurusan_nama from jurusan where id_jurusan = " . $s->id_jurusan)->row();
            $jenis = $this->db->query("select jenis_nama,label from jenis where id_jenis = " . $jurusan->id_jenis)->row();
            $kategori = $this->db->query("select kategori_nama from kategori where id_kategori = " . $s->id_kategori)->row();
            $soal = $this->db->query("select materi_id from soalonline where materi_id = " . $s->materi_id)->result();
            $e = $this->db->query("select id_sekolah from event_sekolah where id_event = " . $s->id_event)->row();
            $sekolah = $this->db->query("select nama_sekolah,id_m_sekolah from m_sekolah where id_m_sekolah = " . $id_sekolah)->row();
            $sekolah_sinkron = $this->db->query("select email from m_sinkron_sekolah where id_m_sekolah = '".$id_sekolah."' and email = '".$email."'")->row();


            if($sekolah_sinkron->email){
                $izin_akses = "dizinkan";
            }else{
                 $izin_akses = "tidak_diizinkan";
            }

            




            $data_api[] = array(

                "materi_id" => base64_encode($s->materi_id),
                "materi_nama" => $s->materi_nama,
                "id_jurusan" => $s->id_jurusan,
                "waktu" => $s->waktu,
                "jurusan" => $jurusan->jurusan_nama,
                'jenis' => $jenis->jenis_nama,
                'jenis_label' => $jenis->label,

                'jumlah_soal' => count($soal),


            );
        }


        $jumlah_soal = 0;
        $jumlah_waktu = 0;
        foreach ($data_api as $d) {
            $jumlah_soal += $d['jumlah_soal'];
            $jumlah_waktu += $d['waktu'];
        }


         $hari_ini = date('Y-m-d');

      //  $hari_ini = '2022-06-21';

         if($sql[0]->tgl_mulai > $hari_ini){
            $data_lewat = 'belum';
           

        }

        elseif($sql[0]->tgl_selesai < $hari_ini){
             $data_lewat = 'lewat';
          

        }else{
            $data_lewat = "buka";
        }



        $data_api_api = array(
            'nama_sekolah'=>$sekolah->nama_sekolah,
            'id_sekolah'=>$sekolah->id_m_sekolah,
            "id_event" => $sql[0]->id_event,
            "judul" => $sql[0]->judul,
            "tgl_mulai"=> TanggalIndo($sql[0]->tgl_mulai_event_sekolah),
            "tgl_selesai"=> TanggalIndo($sql[0]->tgl_selesai_event_sekolah),

            // "tgl_mulai" => TanggalIndo($sql[0]->tgl_mulai_materi),
            // "tgl_selesai" => TanggalIndo($sql[0]->tgl_selesai_materi),
            'kategori' => $kategori->kategori_nama,


            "desc" => $sql[0]->desc,
            "img" => $sql[0]->img,
            "status" => $sql[0]->status,
            "mode" => $sql[0]->mode,
             'kedinasan' => $s->kedinasan,
            "jumlah_soal" => $jumlah_soal,
            "jumlah_waktu" => $jumlah_waktu,
            "data" => $data_api,
           'data_lewat'=>$data_lewat,
           'izin_akses'=>$izin_akses,
        );


        echo json_encode($data_api_api);

        

       

        
    }


    

    /// DASHBOARD
    function event_ranking_sekolah(){

        $email = $this->input->post('email');

        //$email = "ajie";
        $sql = $this->db->query("select p.id_peserta,p.create_add as waktu_mengerjakan,  e.*,j.kategori_nama,j.id_kategori from event as e 
        inner JOIN kategori as j on e.id_kategori=j.id_kategori
        inner join peserta as p on e.id_event = p.id_event 
        inner join jawaban as ja on ja.id_peserta = p.id_peserta  where  e.mode='event' and  e.kedinasan  = 3 and p.email='".$email."' group by e.id_event order by e.id_kategori asc,p.id_peserta desc")->result();

        //  $sql = $this->db->query("select p.id_peserta,p.create_add as waktu_mengerjakan,  e.*,j.kategori_nama,j.id_kategori from event as e 
        // inner JOIN kategori as j on e.id_kategori=j.id_kategori
        // inner join peserta as p on e.id_event = p.id_event where  e.mode='event' and e.kedinasan  = 2 and p.email='".$email."'")->result();

                foreach($sql as $s){


                    $waktu = $this->db->query("select waktu,materi_id from materi where publish = 1 and id_event = ".$s->id_event)->result();
                    $kategori = $this->db->query("select kategori_nama from kategori where id_kategori = ".$s->id_kategori)->row();
                    
                    $wak = 0;
                    foreach($waktu as $w){
        
                        $soal[$s->id_event][] = $this->db->query("select * from soalonline where materi_id = ".$w->materi_id)->result();
                        
                        
                        $wak += $w->waktu;
                    }

                    $jumlah_soal = 0;
                    foreach($soal[$s->id_event] as $so){

                        // echo "<pre>";
                        //     print_r($so);

                        foreach($so as $sk){
                            $jumlah_soal += 1;
                        }
                    }
                   $abc = str_replace(" ", "_", $s->kategori_nama);
                    $data_data[$abc][] = array(
                        "id_peserta"=>$s->id_peserta,
                        "id_event" => base64_encode($s->id_event),
                        "id_event2" => $s->id_event,
                        'judul'=>$s->judul,
                        'tgl_mulai'=>TanggalIndo($s->tgl_mulai),
                        "tgl_selesai"=>TanggalIndo($s->tgl_selesai),
                        'tgl_selesai2'=>date('Ymd',strtotime($s->tgl_selesai)),
                        "waktu"=> $wak,
                        'jumlah_soal'=> $jumlah_soal,
                         'waktu_mengerjakan'=>TanggalIndo($s->waktu_mengerjakan).' '. date("H:i:s",strtotime($s->waktu_mengerjakan)),


                    );

                }

                if($data_data){
                    $data2 = array(
                        'status'=>200,
                        'message'=>'sukses',
                        'data'=>$data_data,
                    );
                }else{
                    $data2 = array(
                        'status'=>404,
                        'message'=>'gagal',
                        'data'=>"",
                    );
                }
                echo json_encode($data2);

    } 

    function check_posisi_rangking_sekolah(){
        error_reporting(0);
       // $email = $this->input->post('email');
       // $id_event = base64_decode($this->input->post('id_event'));


        $post = $this->input->post();
       $post2 = json_decode($post['data']);

      // // echo "<pre>";
      // // print_r($post2);

      // // die;

      //  error_reporting(0);

      
      $id_event = base64_decode($post2->id_event);
      $email = $post2->email;







       $sql = $this->db->query("select *,sum(skor) as skor2  from jawaban where  id_event = '".$id_event."' and mode = '1' and email != '' group by email  order by skor2 desc")->result();


      //   echo "<pre>";
      // print_r($sql);
      // die;


      $count_materi = $this->db->query("select * from materi where id_event = '".$id_event."'" )->result();

      $count_peserta = $this->db->query("select email from jawaban where id_event = '".$id_event."' and email != '' and mode = 1  group by email" )->result();

      
      // $no_ranking2 = 0;
       foreach ($sql  as $key => $s) {





            if($s->email==$email){
               $posisi_rangking = array(
                   'posisi'=>$key+1,
                  //  'skor'=>round($s->skor2/count($count_materi),2),
                   'skor'=>round($s->skor2,2),
                   //'totalpeserta'=> count($count_peserta)
                   'totalpeserta'=> count($count_peserta),
               );
           }

          

          
       }




      if($posisi_rangking){
             echo json_encode($posisi_rangking);
         }else{
           $data_error = array(

               'status'=>400,
               'message'=>"tidak ditemukan",

           );

           echo json_encode($data_error);

        }

       
   }

   function list_hasil_sekolah(){
    error_reporting(0);
 //  $email = $this->input->post('email');
  // $id_event = $this->input->post('id_event');

    $post = $this->input->post();
   $post2 = json_decode($post['data']);

  // echo "<pre>";
  // print_r($post2);

  // die;

   error_reporting(0);

  
  $id_event = $post2->id_event;
 









    //$sql = $this->db->query("select * from irt where  id_event = '" . $id_event . "' and email != '' group by email")->result();

    $sql = $this->db->query("select *,sum(skor) as skor2  from irt where  id_event = '" . $id_event . "' and email != '' group by email  order by skor2 desc limit 30")->result();


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

        $jawaban = $this->db->query("select * from jawaban where email = '".$s->email."' and id_event = '".$id_event."'" )->row();

         $count_materi = $this->db->query("select * from materi where id_event = '".$id_event."'" )->result();


          $waktu_awal        = strtotime($jawaban->tgl_mulai);
         $waktu_akhir    = strtotime($jawaban->create_add); // bisa juga waktu sekarang now()

       //menghitung selisih dengan hasil detik
       $diff    = $waktu_akhir - $waktu_awal;


       //  $skor = 0;
       // foreach($irt as $i){
       //      $skor += round($i->skor,2);
       // }

       // echo "<pre>";
       // print_r($skor);
       // die;

      

       $data_api[] = array(

          
           //'no'=>$no_ranking2++,
           'nama'=>$peserta->nama,
           'email'=>$s->email,
           'skor'=>round($s->skor2/count($count_materi),2),
            'skor2'=>$s->skor2,
           'id_peserta'=>$peserta->id_peserta,
           'asal_sekolah'=>$peserta->asal_sekolah,
           'waktu' => floor($diff / 60),
            'waktu_pengerjaan' => TanggalIndo(date('Y-m-d', strtotime($jawaban->tgl_mulai))) . ' ' . date('H:i:s', strtotime($jawaban->tgl_mulai)),

            // 'waktu_pengerjaan' => $jawaban->tgl_mulai,

            // 'waktu_pengerjaan' => TanggalIndo(date('Y-m-d', strtotime($peserta->create_add))) . ' ' . date('H:i:s', strtotime($peserta->create_add)),
           

       );
   }


  // $data_hasil =  sortAssociativeArrayByKey($data_api, 'skor', 'DESC');

  //  $hasil_akhir = array_splice($data_hasil, 30);

    if($data_api){
         echo json_encode($data_api);
     }else{
       $data_error = array(

           'status'=>400,
           'message'=>"tidak ditemukan",

       );

       echo json_encode($data_error);

    }


}




function cari_nilai(){

    $post = $this->input->post();
   $post2 = json_decode($post['data']);

   // echo "<pre>";
   // print_r($post2);

   // die;

    error_reporting(0);

    $id_event2 = $post2->id_event;
   $id_peserta = $post2->id_peserta;
   $email = $post2->email;
    
     
    // $id_event2 = $this->input->post('id_event');

    //  $id_peserta = $this->input->post('id_peserta');

    
    //  $email = $this->input->post('email');


     $id_event = base64_decode($id_event2);

    $materi =  $this->db->query('select * from materi where publish = 1 and id_event =  "'.$id_event.'"')->result();

     $event =  $this->db->query('select * from event where id_event =  "' . $id_event . '"')->row();


    
    foreach($materi as $m){

      // print_r($m->materi_id);
        $jawaban[] =  $this->db->query('select * from jawaban where id_peserta = "'.$id_peserta.'" and materi_id =  "'.$m->materi_id.'"  and email="'.$email.'" order by materi_id desc')->row();

        $soal[$m->materi_id] =  $this->db->query('select * from soalonline where materi_id =  "'.$m->materi_id.'" order by materi_id desc')->result();


        $jawaban_skor[$m->materi_id] =  $this->db->query('select * from jawaban where id_peserta = "'.$id_peserta.'" and  materi_id =  "'.$m->materi_id.'"  and email="'.$email.'" order by materi_id desc')->row();



       

    // echo "<pre>";
    // print_r($soal);
   
    foreach($soal[$m->materi_id] as  $key){
         $key1[] = $key;
    }

        
    }


    


    // echo "<pre>";
    // print_r($key1);

    // die;

      $benar = 0;
    $salah = 0;
    $kosong = 0;
    $skor_benar = 0;
    $skor_salah = 0;
    $skor_gadisi = 0;
  
    foreach($key1 as $key){
         $a = $this->objToArray(json_decode($jawaban_skor[$key->materi_id]->jawaban, true));


        if($key->id==$a['ans_'.$key->id]['soal']){
        
            //hitung benar

            // echo $key->id;
            // die;

            if($key->jawaban==$a['ans_'.$key->id]['jawaban']){
               $benar +=  1;
                $skor_benar += 4;
            

                //  echo "benar";
            }elseif($a['ans_'.$key->id]['jawaban']==0){
                    //ga di isi 
                    $kosong +=  1;
                    $skor_gadisi += 0;
                 
                //  echo "ga disi";
            }else{

                // echo "salah";

                //salah
                $skor_salah +=   -1;
                 $salah +=  1;
               
            }


        }
    }


    //die;

    //error_reporting(0);

   

    //  echo "<pre>";
    // print_r($soal);

    // // echo "<pre>";
    // // print_r($a);
   // die;

    // $skor = 0;
    // foreach($jawaban as $j){
    //     $skor += $j->skor;
    // }

    $hasil_hasil_nilai = $skor_benar+$skor_gadisi+$skor_salah;

    if($hasil_hasil_nilai <= 0){
        $hasil_hasil_nilai2 = 0;
    }else{
          $hasil_hasil_nilai2 = $hasil_hasil_nilai;
    }

    $data_api = array(
          'tgl_mulai'=>$event->tgl_mulai,
        'tgl_selesai'=>$event->tgl_selesai,
        'tgl_selesai2'=>date('Ymd',strtotime($event->tgl_selesai)),
        'skor'=>$hasil_hasil_nilai,

        'skor_benar'=>$skor_benar,
        'skor_gadisi'=>$skor_gadisi,
        'skor_salah'=>$skor_salah,


        'benar'=>$benar,
         'kosong'=>$kosong,
        'salah'=>$salah,
       
        'totalsoal'=>count($key1),
        'kedinasan'=>$event->kedinasan,
    );

    echo json_encode($data_api);



 }


 function pembahasan(){

    $post = $this->input->post();
    $post2 = json_decode($post['data']);

    // echo "<pre>";
    // print_r($post2);

    // die;

     error_reporting(0);

     $id_event2 = $post2->id_event;
    $id_peserta = $post2->id_peserta;
    $email = $post2->email;



    // $id_event2 = $this->input->post('id_event');
    // $id_peserta = $this->input->post('id_peserta');
    // $email = $this->input->post('email');


     $id_event = base64_decode($id_event2);
      

    $materi =  $this->db->query('select * from materi where publish = 1 and id_event =  "'.$id_event.'" order by no_urut asc')->result();

    // echo "<pre>";
    // print_r($materi);
    foreach($materi as $m){
        $jawaban[] =  $this->db->query('select * from jawaban where id_peserta = "'.$id_peserta.'" and  materi_id =  "'.$m->materi_id.'"  and email="'.$email.'" order by materi_id desc')->row();

        $soal[$m->materi_id] =  $this->db->query('select * from soalonline where materi_id =  "'.$m->materi_id.'" order by materi_id desc')->result();
        $jawaban_skor[$m->materi_id] =  $this->db->query('select * from jawaban where id_peserta = "'.$id_peserta.'" and  materi_id =  "'.$m->materi_id.'"  and email="'.$email.'" order by materi_id desc')->row();

       
        foreach($soal[$m->materi_id] as $k =>$key){

         $pilihan = json_decode($key->pilihan);

             $a = $this->objToArray(json_decode($jawaban_skor[$key->materi_id]->jawaban, true));

             foreach($pilihan as $pi){

                 if($pi->code=='1'){
                     $folder_jawaban = 'jawaban_a';
                     $nama_file_jawaban = $pi->name;
                 }elseif($pi->code=='2'){
                     $folder_jawaban = 'jawaban_b';
                     $nama_file_jawaban = $pi->name;
                 }elseif($pi->code=='3'){
                     $folder_jawaban = 'jawaban_c'; 
                     $nama_file_jawaban = $pi->name;   
                 }elseif($pi->code=='4'){
                     $folder_jawaban = 'jawaban_d';
                     $nama_file_jawaban = $pi->name;
                 }elseif($pi->code=='5'){
                     $folder_jawaban = 'jawaban_e';
                     $nama_file_jawaban = $pi->name;
                 }

                 $Path_img_jawaban = base_url("assets/file_upload/soalonline/".$folder_jawaban."/".$nama_file_jawaban);
                 $Path_jawaban = FCPATH.'assets/file_upload/soalonline/'.$folder_jawaban."/".$nama_file_jawaban;
              
             if($nama_file_jawaban){
                  if (file_exists($Path_jawaban) ){
                     $Path2_jawaban = $Path_img_jawaban;   
                     $type = 'gambar';
                 }else{
                     $Path2_jawaban =  $pi->name;
                     $type = 'text';
                 }
             }else{
                     $Path2_jawaban =  $pi->name;
                     $type = 'text';
             }
                


                 $pil[$key->id][] = array(
                     'code'=>$pi->code,
                     'name'=>$Path2_jawaban,
                     'type'=>$type,
                 );
             }


          if($key->id==$a['ans_'.$key->id]['soal']){



              //  $Path = './assets/file_upload/soalonline/'.$s['img'];
            $Path_img = base_url("assets/file_upload/soalonline/soal/".$key->img);

            $Path = FCPATH.'assets/file_upload/soalonline/soal/'.$key->img;

             if (file_exists($Path) ){
                 $Path1 = $key->img;   
                     if($Path1){
                         $Path2 = $Path_img;
                     }else{
                         $Path2 = "";
                     }
             }else{
                 $Path2 = "";
             }


             // pembahasan
             $Path_pembahasan_img = base_url("assets/file_upload/soalonline/pembahasan/".$key->pembahasan_img);

            $Path = FCPATH.'assets/file_upload/soalonline/pembahasan/'.$key->pembahasan_img;

             if (file_exists($Path) ){
                 $Path1_pembahasan_img = $key->pembahasan_img;   
                     if($Path1_pembahasan_img){
                         $Path2_pembahasan_img = $Path_pembahasan_img;
                     }else{
                         $Path2_pembahasan_img = "";
                     }
             }else{
                 $Path2_pembahasan_img = "";
             }


         
             $data_data[$key->materi_id][] = array(
                 'id' => $key->id,
                 'materi_id' => $key->materi_id,
                  'materi_nama' => $m->materi_nama,
                 
                 'pertanyaan' => $key->pertanyaan,
                  'img' => $Path2,

                 'jawaban' => $key->jawaban,
                 'pilihan' => $pil[$key->id],
                 'pertanyaan_img' => $key->pertanyaan_img,
                  'pembahasan' => $key->pembahasan,
                 'pembahasan_img'=>$Path2_pembahasan_img,
                 'jawaban_anda'=>$a['ans_'.$key->id]['jawaban'],
           );
             
             
 
         }

           
        }


        $data_api[] = array(
         $m->materi_id=>$data_data[$m->materi_id],
            
        );
    }

    echo json_encode($data_api);


  }

  function hitung_irt_cari_nilai_bener_salah($materi_id,$email)
  {

      //$materi_id = 217;

      error_reporting(0);

     

      $soal = $this->db->query('select * from soalonline where materi_id = ' . $materi_id)->result();
     $jawaban = $this->db->query('select * from jawaban where mode="1"   and materi_id = "'.$materi_id.'"   and email  = "'.$email.'"')->result();

   

      // $jawaban = $this->db->query('select * from jawaban where mode="1" and materi_id = ' . $materi_id)->result();




      foreach ($jawaban as $j) {


        

          $a = $this->objToArray(json_decode($j->jawaban));

          // echo "<pre>";
          // print_r($a);
          // die;


          foreach ($a as $key => $hasil_jawaban) {

              $soal_materi = $this->db->query('select * from soalonline where materi_id = ' . $materi_id)->result();



              foreach ($soal_materi as  $key) {
                  $key1[] = $key;
              }
          }

          // echo "<pre>";
          // print_r($soal_materi);


          foreach ($key1 as $key) {


              if ($key->id == $a['ans_' . $key->id]['soal']) {

                  //hitung benar
                  if ($key->jawaban == $a['ans_' . $key->id]['jawaban']) {
                      $data_array_jawaban[$key->id] = array(
                          'soal_id' => $key->id,
                          'hasil_pilihan' => 1,
                      );







                      //  echo "benar";
                    } elseif ($a['ans_' . $key->id]['jawaban'] != $key->jawaban) {
                          

                          if($a['ans_' . $key->id]['jawaban'] ==0){

                              $data_array_jawaban[$key->id] = array(
                                  'soal_id' => $key->id,
                                  'hasil_pilihan' => 0,
                              );

                          }else{
                              $data_array_jawaban[$key->id] = array(
                                  'soal_id' => $key->id,
                                  'hasil_pilihan' => 2,
                              );
                          }

                  }
              } else {
                  echo "gagal";
              }
          }



          $data_jawaban[] = array(
              'email' => $j->email,
              'skor' => $j->skor,
              'benar' => $j->benar,
              'id_jawaban' => $j->id_jawaban,
              //'jawaban'=>$a,
              'data_array_jawaban' => $data_array_jawaban,
               'waktu'=>$j->create_add,
          );
      }

      //  echo "<pre>";
      // print_r($data_jawaban);
      // die;



      // mencari rata" persoal




      $soal_materi2 = $this->db->query('select * from soalonline where materi_id = ' . $materi_id)->result();

      foreach ($soal_materi2 as  $key) {
          $key12[] = $key;
      }








      foreach ($key12 as $k) {

           // echo "<pre>";
           //    print_r($data_jawaban);
           //    die;


          $hitung = 0;
          foreach ($data_jawaban as $j) {

              // echo "<pre>";
              // print_r($j['data_array_jawaban'][$k->id]);


              // echo "<pre>";
              // print_r($k->id);
              // die;
              if ($j['data_array_jawaban'][$k->id]['soal_id'] == $k->id) {




                  $hitung +=  $j['data_array_jawaban'][$k->id]['hasil_pilihan'];

                  $data_array_rata_rata[$k->id] = array(
                      'soal_id' => $k->id,
                      'jumlah' => $hitung,
                  );
              }

              // echo "<pre>";
              // print_r($j['data_array_jawaban']['3078']);
          }
      }



      $data = array(
          'jumlah_soal' => count($soal),
          'jumlah_peserta' => count($jawaban),
          'data_array_rata_rata' => $data_array_rata_rata,
          'data_' => $data_jawaban,
      );

      //echo json_encode($data);

      return $data;
  }


  function cari_nilai_benar_salah($materi_id,$email){

    // $materi_id = $this->input->post('materi_id');
    // $email = = $this->input->post('email');


    $materi = $this->db->query('select * from materi where materi_id= '.$materi_id)->row();


    $irt_hasil =  $this->hitung_irt_cari_nilai_bener_salah($materi_id,$email);



    // $data['irt'] = $this->convertToObject($irt_hasil);

    // $data['materi_id'] = $materi_id;
    // $data['materi_nama'] = $materi->materi_nama;
    // $this->load->view('hasil_irt/irt',$data);







    // echo "<pre>";
    // print_r($irt->data_->{0});
    // die;



    $irt = $this->convertToObject($irt_hasil);

    $materi_id = $materi_id;
    $materi_nama = $materi->materi_nama;





      foreach ($irt->data_ as $d) {

            foreach ($d->data_array_jawaban as $j) {


                //    echo "<pre>";
                //    print_r($j);

                    if ($j->hasil_pilihan == 1) {
                       
                        $hasil_benar[$d->email][]  = $j->hasil_pilihan;
                    }

                    else if ($j->hasil_pilihan == 2) {
                       
                        $hasil_salah[$d->email][]  = $j->hasil_pilihan;
                    }
                    
                    
                    else if ($j->hasil_pilihan == 0) {
                      
                        $hasil_kosong[$d->email][]  = $j->hasil_pilihan;
                    }
                ?>


              

                <?php
                }
        ?>

           

        <?php
                 error_reporting(0);
                    $data_desc = array(
                        'email'=>$d->email,
                        'waktu'=>$d->waktu,
                        'skor_benar'=>     count($hasil_benar[$d->email]),
                        'skor_salah'=>   count($hasil_salah[$d->email]),
                        'skor_kosong'=>    count($hasil_kosong[$d->email]),
                       //'jawaban'=> $d->data_array_jawaban,
                        
                    );

 
                  
        }



      //echo json_encode($data_desc);

       return $data_desc;
}





 function hasil_skor_irt(){
   error_reporting(0);
    // $email = $this->input->post('email');
    // $id_event = $this->input->post('id_event');

  
   

    $post = $this->input->post();
    $post2 = json_decode($post['data']);

   // echo "<pre>";
   // print_r($post2);

   // die;

    error_reporting(0);

   
   $id_event = base64_decode($post2->id_event);
   $email = $post2->email;





    $sql = $this->db->query("select e.id_kategori,e.judul,i.*,m.tgl_mulai as tgl_mulai_materi,m.tgl_selesai as tgl_selesai_materi,m.materi_id,m.materi_nama,m.id_jurusan,m.waktu from event as e
    
    inner join irt as i on i.id_event = e.id_event 
    
    inner join materi as m on i.materi_id = m.materi_id 

    where i.email = '".$email."' and m.publish = 1 and i.id_event = '" . $id_event . "' order by m.no_urut asc")->result();


    // echo "<pre>";
    // print_r($sql);
    // die;



    foreach ($sql as $s) {



        $jurusan = $this->db->query("select * from jurusan where id_jurusan = " . $s->id_jurusan)->row();


        $jenis = $this->db->query("select * from jenis where id_jenis = " . $jurusan->id_jenis)->row();

        $kategori = $this->db->query("select * from kategori where id_kategori = " . $s->id_kategori)->row();

        $soal = $this->db->query("select * from soalonline where materi_id = " . $s->materi_id)->result();


      //  $irt = $this->db->query("select * from irt where id_event = '".$s->id_event."' and email = '".$email."'")->row();

        //  $irt_hasil =  $this->hitung_irt_cari_nilai_bener_salah($s->materi_id,$email);

          $data_skor = $this->cari_nilai_benar_salah($s->materi_id,$email);


          // echo "<pre>";
          // print_r($data_skor);
          // die;

    $materi_id = $s->materi_id;
    //$materi_nama = $materi->materi_nama;





     


        





        $data_api[$jenis->jenis_nama][] = array(

            "materi_id" => base64_encode($s->materi_id),
             "materi_id2" => $s->materi_id,
            "materi_nama" => $s->materi_nama,
            "id_jurusan" => $s->id_jurusan,
            "waktu" => $s->waktu,
            "jurusan" => $jurusan->jurusan_nama,
            'jenis' => $jenis->jenis_nama,
            'jenis_label' => $jenis->label,

            'jumlah_soal' => count($soal),
            'skor'=>round($s->skor,2),
            'email'=>$s->email,
           'data_skor'=>$data_skor,


        );
    }


    $jumlah_soal = 0;
    $jumlah_waktu = 0;
    foreach ($data_api as $d) {
        $jumlah_soal += $d['jumlah_soal'];
        $jumlah_waktu += $d['waktu'];
    }




    $data_api_api = array(

        "id_event" => $sql[0]->id_event,
        "judul" => $sql[0]->judul,
         'kategori'=>$kategori->kategori_nama,
       


      
        "data" => $data_api
    );

    echo json_encode($data_api_api);




}

function login_sekolah(){
    $email = $this->input->post('email');
    $password = $this->input->post('password');

   $login = $this->db->query('select email,password,id_m_sekolah,nama_sekolah from m_sekolah  where email="'.$email.'" and password="'.$password.'"')->row();

   if($login){
        $data_json['status'] = 200;
        $data_json['message'] = "sukses";
        $data_json['id_sekolah'] = $login->id_m_sekolah;
        $data_json['nama_sekolah'] = $login->nama_sekolah;
           $data_json['email'] = $login->email;
   }else{
        $data_json['status'] = 400;
        $data_json['message'] = "gagal";
        $data_json['id_sekolah'] = 0;
        $data_json['nama_sekolah'] = 0;
        $data_json['email'] = "";

   }
   echo json_encode($data_json);
}


function list_sekolah(){
    $sekolah = $this->db->query('select * from m_sekolah where status = 1 order by id_m_sekolah desc')->result();

    foreach($sekolah as $s){

         if($s->photo){
            $photo = base_url('assets/file_upload/sekolah/'.$s->photo);
        }else{
            $photo = base_url('assets/file_upload/sekolah/UN-Online.jpg');
        }


        $data[] = array(
            'nama_sekolah'=>$s->nama_sekolah,
            'alamat'=>$s->alamat_sekolah,
            'alamat_lengkap'=>$s->kecamatan. ' ' .$s->kota. ' ' .$s->provinsi,
            'jumlah_siswa'=>$s->jumlah_siswa,
            'photo'=>$photo,
        );
    }

    echo json_encode($data);
}


function logout_connect_to_school(){
    $email = $this->input->post('email');

    $this->db->where('email',$email);
    $this->db->delete('m_sinkron_sekolah');

    $data_json['status'] = 200;
    $data_json['message'] = "success";

    echo json_encode($data_json);


}





    
    
}
