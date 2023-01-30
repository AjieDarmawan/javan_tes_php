<?php

defined('BASEPATH') or exit('No direct script access allowed');


Header('Access-Control-Allow-Origin: *'); //for allow any domain, insecure
Header('Access-Control-Allow-Headers: *'); //for allow any headers, insecure
Header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');

class Api_m_dinas_dashboard extends CI_Controller
{


    function __construct(){
		parent::__construct();
        $sess = $this->session->userdata();
        
		
    }

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


     function sortAssociativeArrayByKey($array, $key, $direction){

        switch ($direction){
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


    function event(){

        error_reporting(0);

        $email = $this->input->post('email');

        //$email = "ajie";
        // $sql = $this->db->query("select p.id_peserta,p.create_add as waktu_mengerjakan,  e.*,j.kategori_nama,j.id_kategori from event as e 
        // inner JOIN kategori as j on e.id_kategori=j.id_kategori
        // inner join peserta as p on e.id_event = p.id_event where  e.mode='event' and p.email='".$email."'")->result();

        $sql = $this->db->query("select p.id_peserta,p.create_add as waktu_mengerjakan,  e.*,j.kategori_nama,j.id_kategori from event as e 
        inner JOIN kategori as j on e.id_kategori=j.id_kategori
        inner join peserta as p on e.id_event = p.id_event where  e.mode='event' and p.email='".$email."' and e.kedinasan=1 order by p.id_peserta desc")->result();

                

                foreach($sql as $s){

                    $peserta = $this->db->query("select * from jawaban where id_peserta = ".$s->id_peserta)->row();
                    


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

                    if($peserta){
                         $data_data[] = array(
                            'jenis'=>$s->kategori_nama,
                        "id_peserta"=>$s->id_peserta,
                        "id_event" => base64_encode($s->id_event),
                        "id_event2" => $s->id_event,
                        'judul'=>$s->judul,
                        'tgl_mulai'=>TanggalIndo($s->tgl_mulai),
                        "tgl_selesai"=>TanggalIndo($s->tgl_selesai),
                          "tgl_selesai2"=>$s->tgl_selesai,
                        "waktu"=> $wak,
                        'jumlah_soal'=> $jumlah_soal,
                         'waktu_mengerjakan'=>TanggalIndo($s->waktu_mengerjakan).' '. date("H:i:s",strtotime($s->waktu_mengerjakan)),


                    );
                    }
                    
                   

                }

                if($data_data){
                    $data2 = array(
                        'status'=>200,
                        'message'=>'sukses',
                        'data'=>$data_data,
                    );
                }else{

                    $data_errror[] = array(

                        "jenis" => "SAINTEK",
                         "id_peserta" => "190",
                        "id_event" => "Mjk=",
                        "id_event2" => "29",
                        "judul" => "Pekan I - Try Out",
                        "tgl_mulai" => "09 April 2022",
                        "tgl_selesai" => "15 April 2022",
                        "waktu" => 195,
                        "jumlah_soal" => 137,
                        "waktu_mengerjakan" => "04 April 2022 14:23:35"


                    );
                    $data2 = array(
                        'status'=>404,
                        'message'=>'gagal',
                        'data'=>$data_errror,
                    );
                }
                echo json_encode($data2);

    }      


    function detail($id_event){

        

        $id_event2 = base64_decode($id_event); 
        
        //$id_event2 = 11;

        
        $sql = $this->db->query("select e.*,m.tgl_mulai as tgl_mulai_materi,m.tgl_selesai as tgl_selesai_materi,m.materi_id,m.materi_nama,m.id_jurusan,m.waktu from event as e
        inner join materi as m on m.id_event = e.id_event where m.publish=1 and e.id_event = '".$id_event2."'")->result();

        // echo $id_event2;

        // echo "<pre>";
        // print_r($sql);
        // die;


        foreach($sql as $s){

            $jurusan = $this->db->query("select * from jurusan where id_jurusan = ".$s->id_jurusan)->row();
            $jenis = $this->db->query("select * from jenis where id_jenis = ".$jurusan->id_jenis)->row();

            $soal = $this->db->query("select * from soalonline where materi_id = ".$s->materi_id)->result();

           


            $data_api[] = array(
                
                "materi_id" => base64_encode($s->materi_id),
                "materi_nama"=> $s->materi_nama,
                "id_jurusan"=> $s->id_jurusan,
                "waktu"=> $s->waktu,
               "jurusan"=>$jurusan->jurusan_nama,
                'jenis' => $jenis->jenis_nama,
                'jenis_label' => $jenis->label,
               'jumlah_soal'=>count($soal),
               
            );

             $data_api_jenis[$jenis->jenis_nama][] = array(

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
        foreach($data_api as $d){
            $jumlah_soal += $d['jumlah_soal'];
            $jumlah_waktu += $d['waktu'];
        }





          $result = array();
    foreach ($data_api as $key => $record) {
        if (!isset($result[$record['materi_id']])) {

           
               
            

            $result[$record['jenis']] = array(
                'jenis' => $record['jenis'],
                'jenis_label' => $record['jenis_label'],
               


                'list' => array(
                   
                        //"datanya" => array_search("TPS",$data_api[0],true),

                          "datanya" => $data_api_jenis[$record['jenis']],
                      
                        
                    
                ),
            );
            
        }
        else {
            $result[$record['materi_id']]['materi_nama'][] = array($record['materi_id'],$record['materi_nama']);
        }
    }
    $result = array_values($result);







        $data_api_api = array(
            "id_event"=> $sql[0]->id_event,
            "judul"=> $sql[0]->judul,
            // "tgl_mulai"=> $sql[0]->tgl_mulai,
            // "tgl_selesai"=> $sql[0]->tgl_selesai,

            "tgl_mulai"=> $sql[0]->tgl_mulai_materi,
            "tgl_selesai"=> $sql[0]->tgl_selesai_materi,


            "desc"=> $sql[0]->desc,
            "img"=> $sql[0]->img,
            "status"=> $sql[0]->status,
            "mode"=> $sql[0]->mode,
            "jumlah_soal"=>$jumlah_soal,
            "jumlah_waktu"=>$jumlah_waktu,
            "data"=>$result
        );

        echo json_encode($data_api_api);



    }


    
     function cari_nilai(){

       //  $post = $this->input->post();
       // $post2 = json_decode($post['data']);

       // // echo "<pre>";
       // // print_r($post2);

       // // die;

       //  error_reporting(0);

       //  $id_event2 = $post2->id_event;
       // $id_peserta = $post2->id_peserta;
       // $email = $post2->email;
        
         
        $id_event2 = $this->input->post('id_event');

         $id_peserta = $this->input->post('id_peserta');

        
         $email = $this->input->post('email');


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
        $jawaban_tkp = 0;
        $skor_jawaban_tkp = 0;
        $jumlah_tkp = 0;
        $jumlah_tkp_kosong = 0;
      
        foreach($key1 as $key){
             $a = $this->objToArray(json_decode($jawaban_skor[$key->materi_id]->jawaban, true));


             $cek_tkp = $this->db->query('select id_jenis from materi where materi_id ='.$key->materi_id)->row();


                if($cek_tkp->id_jenis == '11'){


                    if ($key->id == $a['ans_' . $key->id]['soal']) {


                    if($a['ans_' . $key->id]['jawaban']=='1'){

                        $jawaban_tkp = $key->bobot_a; 

                    }elseif($a['ans_' . $key->id]['jawaban']=='2'){
                        $jawaban_tkp = $key->bobot_b;
                        
                    }elseif($a['ans_' . $key->id]['jawaban']=='3'){

                        $jawaban_tkp = $key->bobot_c;
                        
                    }elseif($a['ans_' . $key->id]['jawaban']=='4'){
                        $jawaban_tkp = $key->bobot_d;
                    }

                    elseif($a['ans_' . $key->id]['jawaban']=='5'){
                        $jawaban_tkp = $key->bobot_e;
                        
                    }

                  

                    if($a['ans_' . $key->id]['jawaban']=='0'){
                        //$jawaban_tkp = $key->bobot_e;

                        $jumlah_tkp_kosong +=  1;
                        
                    }

                      elseif($a['ans_' . $key->id]['jawaban']!='0'){
                       // $jawaban_tkp = $key->bobot_e;

                        $jumlah_tkp +=  1;
                         $skor_jawaban_tkp += $jawaban_tkp; 
                    }




                 //   $jumlah_tkp +=  1;


                   // $total_nilai +=  $jawaban_tkp;

                      

                   

                   
                }






                }else{


                             if ($key->id == $a['ans_' . $key->id]['soal']) {

                        //hitung benar

                        // echo $key->id;
                        // die;

                        if ($key->jawaban == $a['ans_' . $key->id]['jawaban']) {
                            $benar +=  1;
                            $skor_benar += 5;


                            //  echo "benar";
                        } elseif ($a['ans_' . $key->id]['jawaban'] == 0) {
                            //ga di isi 
                            $kosong +=  1;
                            $skor_gadisi += 0;

                            //  echo "ga disi";
                        } else {

                            // echo "salah";

                            //salah
                            $skor_salah +=   0;
                            $salah +=  1;
                        }
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

         $hasil_hasil_nilai = $skor_benar + $skor_gadisi + $skor_salah + $skor_jawaban_tkp;

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
              'skor_jawaban_tkp'=>$skor_jawaban_tkp,
            'jumlah_tkp'=>$jumlah_tkp,
            'jumlah_tkp_kosong'=>$jumlah_tkp_kosong,


            'benar' => $benar + $jumlah_tkp,


           
             'kosong'=>$kosong+$jumlah_tkp_kosong,
            'salah'=>$salah,
           
            'totalsoal'=>count($key1),
        );

        echo json_encode($data_api);



     }



      function pembahasan(){

       // $post = $this->input->post();
       // $post2 = json_decode($post['data']);

       // // echo "<pre>";
       // // print_r($post2);

       // // die;

       //  error_reporting(0);

       //  $id_event2 = $post2->id_event;
       // $id_peserta = $post2->id_peserta;
       // $email = $post2->email;



       $id_event2 = $this->input->post('id_event');
       $id_peserta = $this->input->post('id_peserta');
       $email = $this->input->post('email');


        $id_event = base64_decode($id_event2);
         

       $materi =  $this->db->query('select * from materi where publish = 1 and id_event =  "'.$id_event.'"')->result();

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

    // ntr dulu ya
    function event2(){
        $sql = $this->db->query("select e.*,j.kategori_nama,j.id_kategori from event as e 
        inner JOIN kategori as j on e.id_kategori=j.id_kategori
                where  e.mode='event'")->result();

         echo "<pre>";
         print_r($sql);
         die;       

        foreach($sql as $s){
               
            
            $materi[$s->id_event] = $this->db->query("select * from materi where publish = 1 and id_event = ".$s->id_event)->result();
          
           
            // echo "<pre>";
            // print_r($materi);
            
            // die;

            foreach($materi[$s->id_event] as $e){

                 $jenis = $this->db->query("select * from jenis where id_kategori = ".$s->id_kategori)->row();

            $soal = $this->db->query("select * from soalonline where materi_id = ".$e->materi_id)->result();

             $jurusan = $this->db->query("select * from jurusan where id_jurusan = ".$e->id_jurusan)->row();

             $data[$s->kategori_nama][]  = array(
                    'materi_nama'=>$e->materi_nama,
                     'materi_id'=>$e->materi_id,
                'jenis'=>$jenis->jenis_nama,
                'waktu'=>$e->waktu,
                'soal'=>count($soal),
                'jurusan'=>$jurusan->jurusan_nama,
                
                
                );
            }



         
        }

        $data_api = array(
            'status'=>200,
            'tanggal'=> TanggalIndo($sql[0]->tgl_mulai) .'-'. TanggalIndo($sql[0]->tgl_selesai),
            'event'=>$sql[0]->judul,
            'datanya'=>$data,

        );

        echo json_encode($data_api);
    }


    function latihan(){

        $email = $this->input->post('email');
        $sql = $this->db->query("select m.*,j.id_jawaban,j.mode,j.create_add from materi as m 
        inner join jawaban as j on j.materi_id = m.materi_id where email = '".$email."' and j.mode=2")->result();

         foreach($sql as $s){

            $event = $this->db->query("select * from event where id_event = ".$s->id_event)->row();
            $jurusan = $this->db->query("select * from jurusan where id_jurusan = ".$s->id_jurusan)->row();
            $jenis = $this->db->query("select * from jenis where id_jenis = ".$jurusan->id_jenis)->row();
             $kategori = $this->db->query("select * from kategori where id_kategori = ".$jenis->id_kategori)->row();

            $soal = $this->db->query("select * from soalonline where materi_id = ".$s->materi_id)->result();


              $data_api[] = array(
                'kategori'=>$kategori->kategori_nama,
                'judul'=>$event->judul,
                "materi_id" => base64_encode($s->materi_id),
                "materi_nama" => $s->materi_nama,
                "jurusan"=>$jurusan->jurusan_nama,
                'jenis'=>$jenis->jenis_nama,
                "waktu" => $s->waktu,
                "jumlah_soal" => $s->tgl_selesai,
                'jumlah_soal'=>count($soal),
                'id_jawaban'=>$s->id_jawaban,
                'waktu_pengerjaan'=>TanggalIndo($s->create_add).' '. date('H:i:s',strtotime($s->create_add))
               
            );
        }


        $data_api2 = array(
            'status'=>200,
            'message'=>'sukses',
            'datanya'=>$data_api,
        );

        echo json_encode($data_api2);
     }



      function cari_nilai_materi(){

         $post = $this->input->post();
        $post2 = json_decode($post['data']);

       // echo "<pre>";
       // print_r($post2);

       // die;

        error_reporting(0);

       
       $id_jawaban = $post2->id_jawaban;
       $email = $post2->email;
        

       
        // $email = $this->input->post('email');
        // $id_jawaban = $this->input->post('id_jawaban');
 
        $id_jawaban_s =  $this->db->query('select * from jawaban where id_jawaban =  "'.$id_jawaban.'"')->row();
        $materi =  $this->db->query('select * from materi where publish = 1 and materi_id =  "'.$id_jawaban_s->materi_id.'"')->result();
         
 
         
         foreach($materi as $m){
 
           // print_r($m->materi_id);
             $jawaban[] =  $this->db->query('select * from jawaban where materi_id =  "'.$m->materi_id.'"  and email="'.$email.'" order by materi_id desc')->row();
 
             $soal[$m->materi_id] =  $this->db->query('select * from soalonline where  materi_id =  "'.$m->materi_id.'" order by materi_id desc')->result();
 
 
             $jawaban_skor[$m->materi_id] =  $this->db->query('select * from jawaban where  id_jawaban = "'.$id_jawaban.'" and materi_id =  "'.$m->materi_id.'"  and email="'.$email.'" order by materi_id desc')->row();
 
         // echo "<pre>";
         // print_r($soal);
        
         foreach($soal[$m->materi_id] as  $key){
              $key1[] = $key;
         }
 
             
         }
 
 
 
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
             'skor'=>$hasil_hasil_nilai,
 
             'skor_benar'=>$skor_benar,
             'skor_gadisi'=>$skor_gadisi,
             'skor_salah'=>$skor_salah,
 
 
             'benar'=>$benar,
              'kosong'=>$kosong,
             'salah'=>$salah,
            
             'totalsoal'=>count($key1),
         );
 
         echo json_encode($data_api);
 
 
 
      }



      function pembahasan_materi(){

         $post = $this->input->post();
        $post2 = json_decode($post['data']);

       // echo "<pre>";
       // print_r($post2);

       // die;

        error_reporting(0);

       
       $id_jawaban = $post2->id_jawaban;
       $email = $post2->email;

        // $email = $this->input->post('email');
        // $id_jawaban = $this->input->post('id_jawaban');
     
        //$email = $this->input->post('email');

        $id_jawaban_s =  $this->db->query('select * from jawaban where id_jawaban =  "'.$id_jawaban.'"')->row();
 
        $materi =  $this->db->query('select * from materi where publish = 1 and materi_id =  "'.$id_jawaban_s->materi_id.'"')->result();
 
        // echo "<pre>";
        // print_r($materi);

        // die;
        foreach($materi as $m){
            $jawaban[] =  $this->db->query('select * from jawaban where materi_id =  "'.$m->materi_id.'"  and email="'.$email.'" order by materi_id desc')->row();
 
            $soal[$m->materi_id] =  $this->db->query('select * from soalonline where materi_id =  "'.$m->materi_id.'" order by materi_id desc')->result();
            $jawaban_skor[$m->materi_id] =  $this->db->query('select * from jawaban where id_jawaban = "'.$id_jawaban.'" and materi_id =  "'.$m->materi_id.'"  and email="'.$email.'" order by materi_id desc')->row();
 
           
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






       // total gabungan
     function list_skor(){

        //cari nama 


        // $post = $this->input->post();
        // $post2 = json_decode($post['data']);

       // echo "<pre>";
       // print_r($post2);

       // die;

        error_reporting(0);

       
       // $id_event2 = $post2->id_event;
       // $email = $post2->email;

       

       

       $id_event2 = $this->input->post('id_event');

         $id_event = base64_decode($id_event2);
       
        $email = $this->input->post('email');


         $user = $this->db->query('select id_peserta,email,id_event,materi_id from jawaban where id_event = "'.$id_event.'"  and mode = 1 group by email')->result();


        // echo "<pre>";
        // print_r($user);
        // die;

        //looping cari nama
        foreach($user as $u){
                     
                    //cari materi nya apa aja
                    $event_materi = $this->db->query('select * from event as e inner join materi as m on e.id_event = m.id_event where  m.publish=1 and m.id_event = "'.$id_event.'"' )->result();

                    // echo "<pre>";
                    // print_r($event_materi);

                    // die;

                    //dillooping materinya cari skor
                    
                    foreach($event_materi as $e)
                    {
                        $jawaban[$u->email][] = $this->db->query('select * from jawaban where materi_id = "'.$e->materi_id.'" and mode = 1  and email = "'.$u->email.'" order by id_jawaban asc')->row();
                        

                       
                    
                    }


                  
                     $skor = 0;
                      foreach($jawaban[$u->email] as $j){
                        $skor += $j->skor;
                      }

                 $sekolah[$u->email] = $this->db->query('select asal_sekolah,nama from peserta where id_peserta="'.$u->id_peserta.'"')->row();     
                 $event = $this->db->query('select judul from event where id_event='.$u->id_event)->row();     


                 $waktu_awal        =strtotime($jawaban[$u->email][0]->tgl_mulai);
                 $waktu_akhir    =strtotime($jawaban[$u->email][0]->create_add); // bisa juga waktu sekarang now()
                 
                 //menghitung selisih dengan hasil detik
                 $diff    =$waktu_akhir - $waktu_awal;

                 $data_api[] = array(
                     'email'=>$u->email,
                     'event'=>$event->judul,
                     'skor'=>$skor,
                     'waktu'=>floor($diff/60),
                     //'asal_sekolah'=>$sekolah[$u->email],
                   // 'jawaban'=>$jawaban[$u->email],
                    'waktu_pengerjaan'=> TanggalIndo(date('Y-m-d',strtotime($jawaban[$u->email][0]->tgl_mulai))) .' '.date('H:i:s',strtotime($jawaban[$u->email][0]->tgl_mulai)),
                    
                 );

                 
        }


        foreach($data_api as $a){

            // if($a['skor']==$a['skor']){
                
            // }else{

            // }
            $data_api_api[] = array(
                'email'=>$a['email'],
                'nama'=>$sekolah[$a['email']]->nama,
                'event'=>$a['event'],
                'skor'=>$a['skor'],
                'waktu'=>$a['waktu'],
                'asal_sekolah'=>$sekolah[$a['email']]->asal_sekolah,
                 'waktu_pengerjaan'=>$a['waktu_pengerjaan'],
            );
        }

        $sort_by_skor = $this->sortAssociativeArrayByKey($data_api_api,'skor','DESC');


        

        echo json_encode($sort_by_skor);
       
        // foreach($sort_by_skor as $s){
        //     $data_api_api_skor[] = array(
        //         'email'=>$s['email'],
        //         'event'=>$s['event'],
        //         'skor'=>$s['skor'],
        //         'waktu'=>$s['waktu'],
        //     );
        // }

        // $sort_by_skor_and_waktu = $this->sortAssociativeArrayByKey($data_api_api_skor,'waktu','ASC');

        // echo json_encode($sort_by_skor);
        // die;
        

        // echo json_encode($data_api_api);

 
     }


      function event_ranking(){

        $email = $this->input->post('email');

        //$email = "ajie";
        $sql = $this->db->query("select p.id_peserta,p.create_add as waktu_mengerjakan,  e.*,j.kategori_nama,j.id_kategori from event as e 
        inner JOIN kategori as j on e.id_kategori=j.id_kategori
        inner join peserta as p on e.id_event = p.id_event 
        inner join jawaban as ja on ja.id_peserta = p.id_peserta  where  e.mode='event' and p.email='".$email."' and e.kedinasan = 1 group by e.id_event")->result();


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
                    
                    $abc = str_replace(" ","_",$s->kategori_nama);
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
       // error_reporting(0);
        $email = $this->input->post('email');
        $id_event = base64_decode($this->input->post('id_event'));

      
       

       //  $post = $this->input->post();
       //  $post2 = json_decode($post['data']);

       // // echo "<pre>";
       // // print_r($post2);

       // // die;

       //  error_reporting(0);

       
       // $id_event = base64_decode($post2->id_event);
       // $email = $post2->email;





        $sql = $this->db->query("select e.id_kategori,e.judul,i.*,m.tgl_mulai as tgl_mulai_materi,m.tgl_selesai as tgl_selesai_materi,m.materi_id,m.materi_nama,m.id_jurusan,m.waktu from event as e
        
        inner join irt as i on i.id_event = e.id_event 
        
        inner join materi as m on i.materi_id = m.materi_id 

        where i.email = '".$email."' and m.publish = 1 and i.id_event = '" . $id_event . "' order by m.no_urut asc")->result();



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

        $materi_id = $materi_id;
        $materi_nama = $materi->materi_nama;





         


            





            $data_api[] = array(

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

    function list_hasil_rangking(){
         error_reporting(0);
      // $email = $this->input->post('email');
       $id_event = base64_decode($this->input->post('id_event'));

       //   $post = $this->input->post();
       //  $post2 = json_decode($post['data']);

       // // echo "<pre>";
       // // print_r($post2);

       // // die;

       //  error_reporting(0);

       
       // $id_event = $post2->id_event;
      









         //$sql = $this->db->query("select * from irt where  id_event = '" . $id_event . "' and email != '' group by email")->result();

         $sql = $this->db->query("select *,sum(skor) as skor2  from jawaban where  id_event = '" . $id_event . "' and mode = '1' and email != '' group by email  order by skor2 desc limit 30")->result();


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
        $email = $this->input->post('email');
        $id_event = base64_decode($this->input->post('id_event'));


       //   $post = $this->input->post();
       //  $post2 = json_decode($post['data']);

       // // echo "<pre>";
       // // print_r($post2);

       // // die;

       //  error_reporting(0);

       
       // $id_event = base64_decode($post2->id_event);
       // $email = $post2->email;







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



     function history_jawaban(){

        error_reporting(0);
        //   $post = $this->input->post();
        // $post2 = json_decode($post['data']);

        // // echo "<pre>";
        // // print_r($post2);

        // // die;

        // $email = $post2->email;
        // $id_event = base64_decode($post2->id_event);
        // $id_peserta = $post2->id_peserta;

        $email = $this->input->post('email');
         $id_event = base64_decode($this->input->post('id_event'));
         $id_peserta = $this->input->post('id_peserta');




        $query = $this->db->query('select * from jawaban where id_event = "'.$id_event.'" and email ="'.$email.'" and id_peserta = "'.$id_peserta.'"  ')->result();

        foreach($query as $q){

            $mat = $this->db->query('select materi_nama,id_jenis from materi where materi_id="'.$q->materi_id.'"')->row();
            

            if($mat->id_jenis=='11'){
                $kkm = '156';

                if($q->skor>=$kkm){
                    $hasil_status = "TERCAPAI";
                }else{
                    $hasil_status = "TIDAK TERCAPAI";
                }
            }elseif($mat->id_jenis=='9'){
                $kkm = '65';

                if($q->skor>=$kkm){
                    $hasil_status = "TERCAPAI";
                }else{
                    $hasil_status = "TIDAK TERCAPAI";
                }

            }elseif ($mat->id_jenis='10') {
                $kkm = '80';
                if($q->skor>=$kkm){
                    $hasil_status = "TERCAPAI";
                }else{
                    $hasil_status = "TIDAK TERCAPAI";
                }
            }

            $data_data[] = array(
                'materi_id' => $q->materi_id,
                 'materi_nama' => $mat->materi_nama,
                'skor' => $q->skor,
                'benar' => $q->benar,
                 'salah' => $q->salah,
                  'kosong' => $q->kosong,
                  'kkm' => $kkm,
                  'hasil_status'=>$hasil_status,
            );
        }

        echo json_encode($data_data);
    }


     function event_ranking_mandiri(){

        $email = $this->input->post('email');

        //$email = "ajie";
        $sql = $this->db->query("select p.id_peserta,p.create_add as waktu_mengerjakan,  e.*,j.kategori_nama,j.id_kategori from event as e 
        inner JOIN kategori as j on e.id_kategori=j.id_kategori
        inner join peserta as p on e.id_event = p.id_event 
        inner join jawaban as ja on ja.id_peserta = p.id_peserta  where  e.mode='event' and  e.kedinasan  = 2 and p.email='".$email."' group by e.id_event")->result();

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






    function event_mandiri(){

        $email = $this->input->post('email');

        //$email = "ajie";
        // $sql = $this->db->query("select p.id_peserta,p.create_add as waktu_mengerjakan,  e.*,j.kategori_nama,j.id_kategori from event as e 
        // inner JOIN kategori as j on e.id_kategori=j.id_kategori
        // inner join peserta as p on e.id_event = p.id_event 
        // inner join jawaban as ja on ja.id_peserta = p.id_peserta  where  e.mode='event' and  e.kedinasan  = 2 and p.email='".$email."' group by e.id_event")->result();

         $sql = $this->db->query("select p.id_peserta,p.create_add as waktu_mengerjakan,  e.*,j.kategori_nama,j.id_kategori from event as e 
        inner JOIN kategori as j on e.id_kategori=j.id_kategori
        inner join peserta as p on e.id_event = p.id_event where  e.mode='event' and e.kedinasan  = 2 and p.email='".$email."'")->result();

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






     

 


    

   

    
    
}
