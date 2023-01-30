<?php

defined('BASEPATH') or exit('No direct script access allowed');


Header('Access-Control-Allow-Origin: *'); //for allow any domain, insecure
Header('Access-Control-Allow-Headers: *'); //for allow any headers, insecure
Header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');


class Api_m_sekolah_dashboard extends CI_Controller
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

   
    

    /// DASHBOARD
    function event_ranking_sekolah(){

       // $email = $this->input->post('email');
        $id_sekolah = $this->input->post('id_sekolah');

        //$email = "ajie";
        $sql = $this->db->query("select p.id_peserta,p.create_add as waktu_mengerjakan,  e.*,j.kategori_nama,j.id_kategori from event as e 
        inner JOIN kategori as j on e.id_kategori=j.id_kategori
        inner join peserta as p on e.id_event = p.id_event 
        inner join m_sekolah as se on se.id_m_sekolah = p.id_sekolah
        inner join jawaban as ja on ja.id_peserta = p.id_peserta  where  e.mode='event' and  e.kedinasan  = 3 and  se.id_m_sekolah = '".$id_sekolah."' group by e.id_event order by e.id_kategori asc,p.id_peserta desc")->result();

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
    

    function event_ranking_sekolah_detail(){

        $id_peserta = $this->input->post('id_peserta');
        $id_sekolah = $this->input->post('id_sekolah');

        //$email = "ajie";
        $sql = $this->db->query("select p.id_peserta,p.create_add as waktu_mengerjakan,  e.*,j.kategori_nama,j.id_kategori from event as e 
        inner JOIN kategori as j on e.id_kategori=j.id_kategori
        inner join peserta as p on e.id_event = p.id_event 
        inner join m_sekolah as se on se.id_m_sekolah = p.id_sekolah
        inner join jawaban as ja on ja.id_peserta = p.id_peserta  where  e.mode='event' and  e.kedinasan  = 3 and p.id_peserta = ".$id_peserta." and se.id_m_sekolah = '".$id_sekolah."' group by e.id_event order by e.id_kategori asc,p.id_peserta desc")->result();

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
    
    

    function list_hasil_rangking(){
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
      $id_sekolah = $post2->id_sekolah;
     









        //$sql = $this->db->query("select * from irt where  id_event = '" . $id_event . "' and email != '' group by email")->result();

        $sql = $this->db->query("select *,sum(skor) as skor2  from irt 

                        where  id_event = '".$id_event."' and email != '' and id_sekolah = '".$id_sekolah."' group by email  order by skor2 desc limit 30")->result();


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



   function check_posisi_rangking(){
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
  $id_sekolah = $post2->id_sekolah;







  $sql = $this->db->query("select *,sum(skor) as skor2  from irt 

                        where  id_event = '".$id_event."' and email != '' and id_sekolah = '".$id_sekolah."' group by email  order by skor2 desc limit 30")->result();

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
                'skor'=>round($s->skor2/count($count_materi),2),
               'skor2'=>round($s->skor2,2),
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


function event_sekolah(){
    $id_sekolah = $this->input->post('id_sekolah');
    //$id_sekolah = 11;
    $query = $this->db->query('select es.*,e.judul,(select count(id_peserta) from peserta where id_event=e.id_event and id_sekolah='.$id_sekolah.' )as total_siswa
     from event_sekolah as es inner join event as e on e.id_event = es.id_event where es.id_sekolah = "'.$id_sekolah.'" order by no_urut_paket asc')->result();

    $data['status'] = 200;
    $data['messege'] = "success";
    $data['data'] = $query;

    echo json_encode($data);
}










}