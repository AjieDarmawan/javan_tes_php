<?php

defined('BASEPATH') or exit('No direct script access allowed');

Header('Access-Control-Allow-Origin: *'); //for allow any domain, insecure
Header('Access-Control-Allow-Headers: *'); //for allow any headers, insecure
Header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');

class Api extends CI_Controller
{


    function __construct(){
        parent::__construct();
        // if(!$this->session->userdata(['pegawai']['kar_pvl']=='U')){
        //  redirect('auth');
        // }
      // $this->load->model(array('auth/auth_model'));

        header('Access-Control-Allow-Origin: *'); 
    header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
        
    }

    function soal_latihan(){
      


        $data_api = array(
            'kode' => 001,
            'message' => "sukses",
            'listdata' => Array
        (
            'dari' => 1,
            'hingga' => 3,
            'totaldata' => 3,
            'totalhalaman' => 1,
            'datanya' => Array
                (
                    '0' => Array
                        (
                            'no' => 1,
                            'ccid' => "Nnc9PQb93bbfb93bbf",
                            'pertanyaan' => "Logika  fuzzy  dengan  cepat  telah  menjadi salah  satu  yang  paling  sukses  dari  teknologi  saat  ini untuk mengembangkan sistem kontrol yang canggih. Alasan yang tepat adalah",
                            'img' => 'https://api.edulearning.me/dokumen/soal?ccid=emc9PQb93bbfb93bbf&cid=ajhyTjJXSkxDZUE9"',
                            'pilihan' => Array
                                (
                                    '0' => Array
                                        (
                                            'code' => 633,
                                            'name' => "Logika fuzzy memungkinkan kemampuan untuk menghasilkan solusi atau perkiraan."
                                        ),

                                    '1' => Array
                                        (
                                            'code' => 631,
                                            'name' => "Logika fuzzy memungkinkan kemampuan untuk menghasilkan solusi yang agak tepat dari informasi tertentu atau perkiraan." 
                                        ),

                                    '2' => Array
                                        (
                                            'code' => 632,
                                            'name' => "Logika fuzzy memungkinkan kemampuan untuk menghasilkan solusi yang  tepat dari informasi tertentu atau perkiraan." 
                                        ),

                                    '3' => Array
                                        (
                                            'code' => 634,
                                            'name' => "Logika fuzzy memungkinkan kemampuan untuk menghasilkan  perkiraan." 
                                        ),

                                    ),

                        ),


                        '1' => Array
                        (
                            'no' => 2,
                            'ccid' => "Nnc9PQb93bbfb93bbf",
                            'pertanyaan' => "Logika  fuzzy  dengan  cepat  telah  menjadi salah  satu  yang  paling  sukses  dari  teknologi  saat  ini untuk mengembangkan sistem kontrol yang canggih. Alasan yang tepat adalah",
                            'img' => 'https://api.edulearning.me/dokumen/soal?ccid=emc9PQb93bbfb93bbf&cid=ajhyTjJXSkxDZUE9"',
                            'pilihan' => Array
                                (
                                    '0' => Array
                                        (
                                            'code' => 633,
                                            'name' => "Logika fuzzy memungkinkan kemampuan untuk menghasilkan solusi atau perkiraan."
                                        ),

                                    '1' => Array
                                        (
                                            'code' => 631,
                                            'name' => "Logika fuzzy memungkinkan kemampuan untuk menghasilkan solusi yang agak tepat dari informasi tertentu atau perkiraan." 
                                        ),

                                    '2' => Array
                                        (
                                            'code' => 632,
                                            'name' => "Logika fuzzy memungkinkan kemampuan untuk menghasilkan solusi yang  tepat dari informasi tertentu atau perkiraan." 
                                        ),

                                    '3' => Array
                                        (
                                            'code' => 634,
                                            'name' => "Logika fuzzy memungkinkan kemampuan untuk menghasilkan  perkiraan." 
                                        ),

                                    ),

                        ),

                  

                   

                ),

            'waktunya' => 15
        )
        );

        echo json_encode($data_api);

       
    }


    function soal($materi_id){

         $materi_id2 = base64_decode($materi_id);

       

       $soal = $this->db->query('select * from soalonline where materi_id = "'.$materi_id2.'"')->result_array();


        // echo "<pre>";
        // print_r($soal);

        // die;

        foreach($soal as $s){

            $pilihan = json_decode($s['pilihan']);


            // echo "<pre>";
            // print_r($pilihan);
            // die;
            // foreach($pilihan as $p){
            //     $data_pilihan[] = array(
            //         'code'=>$p->code,
            //         'name'=>$p->name,
            //     );
            // }
          
            $data_soal[] = array(
                'no' => $s['id'],
                'ccid' => "Nnc9PQb93bbfb93bbf",
                'pertanyaan' => $s['pertanyaan'],
                'img' => base_url('assets/file_upload/soalonline/'.$s['img']),
                'pilihan'=>$pilihan, 
            );
        }


        $data_api = array(
            'kode'=>1,
            'message'=>'sukses',
            'listdata'=>array(
                "dari"=> 1,
                "hingga"=> count($data_soal),
                "totaldata"=> count($data_soal),
                "totalhalaman"=> 1,
                "datanya"=>$data_soal,
                'waktu'=>40,
            )
        );

        echo json_encode($data_api);


       
    }


    function event(){

        header('Access-Control-Allow-Origin: *'); 
        // header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
        header('Content-Type: application/json');

       header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Cache-Control, Pragma, Authorization, Accept, Accept-Encoding");




         $sql = $this->db->query("select e.*,j.jenis_nama from event as e 
        inner JOIN jenis as j on e.id_jenis=j.id_jenis
                where  e.mode='event'")->result();


         $hariini = date('Y-m-d');

        //$hariini = '2022-03-06';

        foreach($sql as $s){


           // $jurusan = $this->db->query("select * from jurusan where id_jurusan = ".$s->id_jurusan)->row();
           // $jenis = $this->db->query("select * from jenis where id_jenis = ".$jurusan->id_jenis)->row();



            $waktu = $this->db->query("select waktu from materi where id_event = ".$s->id_event)->result();

            $wak = 0;
            foreach($waktu as $w){
                $wak += (int)$w->waktu;
            }



            if($hariini >= $s->tgl_mulai){

                   //jika hari ini kurang dari tgl selesai
                    if($s->tgl_selesai >= $hariini){
                        $data_api[] = array(
                             "id_event"=> base64_encode($s->id_event),
                            "judul"=> $s->judul,
                            "tgl_mulai"=> $s->tgl_mulai,
                            "tgl_selesai"=> $s->tgl_selesai,
                            "desc"=> $s->desc,
                            "img"=> $s->img,
                            "status"=> $s->status,
                            "mode"=> $s->mode,
                            // "materi_id" => $s->materi_id,
                            // "materi_nama"=> $s->materi_nama,
                        // "id_jurusan"=> $s->id_jurusan,
                            "waktu"=> $wak,
                            //"jurusan"=>$jurusan->jurusan_nama,
                            'jenis'=>$s->jenis_nama,
                        );
                    }


            }
             

            
        }

        echo json_encode($data_api);

        
    }


    function latihan(){
        $sql = $this->db->query("select e.*,j.jenis_nama from event as e 
        inner JOIN jenis as j on e.id_jenis=j.id_jenis
                where tgl_mulai <= '2022-03-01'  and tgl_selesai >= '2022-03-11' and e.mode='latihan'")->result();



        foreach($sql as $s){

            $waktu = $this->db->query("select waktu from materi where id_event = ".$s->id_event)->result();

            $wak = 0;
            foreach($waktu as $w){
                $wak += $w->waktu;
            }


            $hariini = date('Y-m-d');

            //$hariini = '2022-03-06';


            if($hariini >= $s->tgl_mulai){

                //jika hari ini kurang dari tgl selesai
                 if($s->tgl_selesai >= $hariini){
                    $data_api[] = array(
                        "id_event"=> base64_encode($s->id_event),
                        "judul"=> $s->judul,
                        "tgl_mulai"=> $s->tgl_mulai,
                        "tgl_selesai"=> $s->tgl_selesai,
                        "desc"=> $s->desc,
                        "img"=> $s->img,
                        "status"=> $s->status,
                        "mode"=> $s->mode,
                        // "materi_id" => $s->materi_id,
                        // "materi_nama"=> $s->materi_nama,
                       // "id_jurusan"=> $s->id_jurusan,
                        "waktu"=> $wak,
                        //"jurusan"=>$jurusan->jurusan_nama,
                        'jenis'=>$s->jenis_nama,
                    );
                 }

            }


            
        }

        echo json_encode($data_api);

        
    }



    function detail($id_event){

        $id_event2 = base64_decode($id_event);   
        $sql = $this->db->query("select e.*,m.tgl_mulai as tgl_mulai_materi,m.tgl_selesai as tgl_selesai_materi,m.materi_id,m.materi_nama,m.id_jurusan,m.waktu from event as e
        inner join materi as m on m.id_event = e.id_event where e.id_event = '".$id_event2."'")->result();


        foreach($sql as $s){

            $jurusan = $this->db->query("select * from jurusan where id_jurusan = ".$s->id_jurusan)->row();
            $jenis = $this->db->query("select * from jenis where id_jenis = ".$jurusan->id_jenis)->row();



            $data_api[] = array(
                "id_event"=> $s->id_event,
                "judul"=> $s->judul,
                // "tgl_mulai"=> $s->tgl_mulai,
                // "tgl_selesai"=> $s->tgl_selesai,

                "tgl_mulai"=> $s->tgl_mulai_materi,
                "tgl_selesai"=> $s->tgl_selesai_materi,


                "desc"=> $s->desc,
                "img"=> $s->img,
                "status"=> $s->status,
                "mode"=> $s->mode,
                "materi_id" => base64_encode($s->materi_id),
                "materi_nama"=> $s->materi_nama,
                "id_jurusan"=> $s->id_jurusan,
                "waktu"=> $s->waktu,
               "jurusan"=>$jurusan->jurusan_nama,
               'jenis'=>$jenis->jenis_nama,
            );
        }

        echo json_encode($data_api);



    }


    function jawaban(){
        header('Content-type: application/json');
        // {
        //     "ccid":"N0E9PQb93bbfb93bbf",
        //     "ans_Nnc9PQb93bbfb93bbf":{
        //         "ans":"633",
        //         "time":""
        //     },
        //     "ans_NkE9PQb93bbfb93bbf":{
        //         "ans":"4233",
        //         "time":""
        //     },
        //     "ans_NlE9PQb93bbfb93bbf":{
        //         "ans":"4254",
        //         "time":""
        //     }
        // }



        // $data_array =array(
        //     'ccid'=>"N0E9PQb93bbfb93bbf",
        //     'ans_Nnc9PQb93bbfb93bbf'=>array(
        //         "ans"=>"633",
        //         "time"=>""
        //     ),
        //     'ans_Nnc9PQb93bbfb93bbf'=>array(
        //         "ans"=>"633",
        //         "time"=>""
        //     ),
        //     'ans_Nnc9PQb93bbfb93bbf'=>array(
        //         "ans"=>"633",
        //         "time"=>""
        //     ),
        // );


       $email = $this->input->post('email'); 
      $data_array2 = $this->input->post('res');

//       $data_array2 = $_POST;

      // echo "<pre>";
      // print_r($data_array2);
      // die;

      $data_array =  (array)json_decode($data_array2);



       //  $data_array =array(
       //      'materi_id'=>"22",
       //      'jawabannya'=>array(
       //       array(
       //          'soal'=>192,
       //          'jawaban'=>'5'
       //      ),
       //      array(
       //          'soal'=>191,
       //          'jawaban'=>'2'
       //      ),
       //      array(
       //          'soal'=>190,
       //          'jawaban'=>'3'
       //      ),
       //      array(
       //          'soal'=>189,
       //          'jawaban'=>'4'
       //      ),
           
       //   )
       //  );

       // echo json_encode($data_array);
       // echo "<pre>";
       // print_r($data_array);
       // die;


       $sql_soal = $this->db->query('select * from soalonline where materi_id = '.base64_decode($data_array['materi_id']))->result();

       $event = $this->db->query('select id_event from materi where materi_id = '.base64_decode($data_array['materi_id']))->row();

       

    //    echo "<pre>";
    //    print_r($event);

    //    die;


       $total_nilai = 0;
         foreach($sql_soal as $s=>$key){

       


        
        if($key->id==$data_array['ans_'.$key->id]->soal){

            //hitung benar

            if($key->jawaban==$data_array['ans_'.$key->id]->jawaban){
                $total_nilai +=  5;

              //  echo "benar";
            }elseif($data_array['ans_'.$key->id]->jawaban==null){
                    //ga di isi 
                 $total_nilai +=  0;
               //  echo "ga disi";
            }else{

               // echo "salah";

                //salah
                $total_nilai +=   -1;
            }


        }


    }
       


       $data_jawaban = array(
           'materi_id'=>base64_decode($data_array['materi_id']),
           'jawaban'=>json_encode($data_array),
           //'jawaban'=>$data_array,
           'skor'=>$total_nilai,
           'create_add'=>date('Y-m-d H:i:s'),
           'email'=>$email,
           'id_event'=>$event->id_event,
        );

       $q = $this->db->insert('jawaban',$data_jawaban);


       if($q){
           $data_api = array(
               'status'=>200,
               'message'=>'suksess',
               'skor'=>$total_nilai,
           );
       }

       echo json_encode($data_api);
       








    }


    function login(){

       $email   = $this->input->post('email');
     $mypassword = $this->input->post('password');
       $users = $this->db->query('select * from edu_apps.app_userdata where email  = "ajie.darmawan106@gmail.com"')->row();


        // echo "<pre>";
        // print_r($$users);

        if($users){

              $dbpassword = $users->password;
              $password = sha1(md5($mypassword));

                if($users->userstatus==1){
                      $data['status'] = 200;
                      $data['message'] ="success";
                      $data['key'] = $users->keycode;
                      $data['email'] = $users->email;
                }else if($users->userstatus==2){
                         $data['status'] = 300;
                        $data['message'] ="Anda Belum Reset Password";
                        $data['key'] = $users->keycode;
                        $data['email'] = $users->email;
                }else{
                    $data['status'] = 405;
                    $data['message'] ="Akun Anda Belum Aktif";
                    $data['key'] = "`12345";
                    $data['email'] = "12345";
                }



        }else{
                    $data['status'] = 405;
                    $data['message'] ="Akun Anda Belum Aktif";
                    $data['key'] = "`12345";
                    $data['email'] = "12345";
        }

        echo json_encode($data);


    }



 //soal event

      function soal_event($id_event){

        $id_event2 = base64_decode($id_event);



        $materi = $this->db->query('select materi_id from  materi where id_event = '.$id_event2)->result_array();




        foreach($materi as $m){
            $soal = $this->db->query('select * from soalonline where materi_id = '.$m['materi_id'])->result_array();



            foreach($soal as $s){
                $pilihan = json_decode($s['pilihan']);

                $data_soal[] = 
                  array(
                    'no' => $s['id'],
                   //'materi_id' => $s['materi_id'],
                    'pertanyaan' => $s['pertanyaan'],
                    'img' => base_url('assets/file_upload/soalonline/'.$s['img']),
                    'pilihan'=>$pilihan, 
                );


            }

            $j_materi_id[] =array(
                    base64_encode($m['materi_id']) => array(
                        'materi_id'=>base64_encode($m['materi_id']),
                        'datanya'=>$data_soal,
                        "totalhalaman"=> 1,
                        "hingga"=> count($data_soal),
                        "totaldata"=> count($data_soal),
                        'waktu'=>40,
                    ),
            );

        }

        $data_api = array(
            'kode'=>1,
            'message'=>'sukses',
            'listdata'=>array(
                "dari"=> 1,
                "datanya"=>$j_materi_id,
                
            )
        );

        echo json_encode($data_api);

       
     }


      function jawaban_event(){
        header('Content-type: application/json');
        // $data_array =array(
        //    'event'=>'18',
        //    'datanya'=>  array(
        //        'mat_18'=>  array(
        //         'materi_id'=>"18",
        //          'ans_192'=>   array(
        //                 'soal'=>192,
        //                 'jawaban'=>'5'
        //             ),
        //             'ans_191'=>  array(
        //                 'soal'=>191,
        //                 'jawaban'=>'2'
        //             ),
        //             'ans_190'=>  array(
        //                 'soal'=>190,
        //                 'jawaban'=>'3'
        //             ),
        //             'ans_189'=>  array(
        //                 'soal'=>189,
        //                 'jawaban'=>'4'
        //             ),
   
        //     ),


        //     'mat_19'=>  array(
        //         'materi_id'=>"19",
                
        //          'ans_193'=>   array(
        //                 'soal'=>193,
        //                 'jawaban'=>'2'
        //             ),
        //             'ans_194'=>  array(
        //                 'soal'=>194,
        //                 'jawaban'=>'5'
        //             ),
        //             'ans_195'=>  array(
        //                 'soal'=>195,
        //                 'jawaban'=>'5'
        //             ),
        //             'ans_196'=>  array(
        //                 'soal'=>196,
        //                 'jawaban'=>'2'
        //             ),
          
                
        //     ),
            
        //     ),
    
        // );




        // echo json_encode($data_array);

        // die;

        // echo "<pre>";
        // print_r($data_array['datanya']);

        // die;

         $email = $this->input->post('email'); 
        $data_array2 = $this->input->post('res');


        $data_array =  (array)json_decode($data_array2);

        $total_nilai_perevent = 0;
        foreach($data_array['datanya'] as $a){
            // echo "<pre>";
            // print_r($a['materi_id']);
            // die;

            $sql_soal = $this->db->query('select * from soalonline where materi_id = '.base64_decode($a['materi_id']))->result();
        
        
            $total_nilai = 0;
            foreach($sql_soal as $s=>$key){
   
         
           
                    if($key->id==$a['ans_'.$key->id]['soal']){
            
                        //hitung benar
            
                        if($key->jawaban==$a['ans_'.$key->id]['jawaban']){
                            $total_nilai +=  5;
            
                            //  echo "benar";
                        }elseif($a['ans_'.$key->id]['jawaban']==null){
                                //ga di isi 
                                $total_nilai +=  0;
                            //  echo "ga disi";
                        }else{
            
                            // echo "salah";
            
                            //salah
                            $total_nilai +=   -1;
                        }
            
            
                        }
   
   
            }

           

            $data_jawaban = array(
                'materi_id'=>base64_decode($a['materi_id']),
                'jawaban'=>json_encode($a),
                //'jawaban'=>$data_array,
                'skor'=>$total_nilai,
                'create_add'=>date('Y-m-d H:i:s'),
                'email'=>'tes',
                'id_event'=>$data_array['event'],
             );
     
            $q = $this->db->insert('jawaban',$data_jawaban);

            $total_nilai_perevent += $total_nilai;
 
        }


        if($q){
            $data_api = array(
                'status'=>200,
                'message'=>'suksess',
                'skor'=>$total_nilai_perevent,
            );

            echo json_encode($data_api);
        }
     }


    


    

   

}
