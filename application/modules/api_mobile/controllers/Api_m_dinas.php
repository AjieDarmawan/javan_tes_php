<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Api_m_dinas extends CI_Controller
{


    function __construct(){
		parent::__construct();
        $sess = $this->session->userdata();
        
		
    }


    // untuk merubah tag lebih kecil dan besar jadi fontawesome antisipasi error di pilihan
function ubahtag($str)
{
    $str = str_replace("<", "<i class='fas fa-chevron-left mx-2'></i>", $str);
    $str = str_replace(">", "<i class='fas fa-chevron-right mx-2'></i>", $str);
    return $str;
}


// untuk merubah tag lebih kecil dan besar jadi kode html, terutama untuk pdf, gunakan sblm ubahkotak
function ubahkecilgede($str)
{
    $str = str_replace("<br>", "ngenter", $str);
    $str = str_replace("<", "&lt;", $str);
    $str = str_replace(">", "&gt;", $str);
    $str = str_replace("ngenter", "<br>", $str);
    return $str;
}


// untuk merubah tag kotak cutom jadi tag html, gunakan setelah ubahkecilgede
function ubahkotak($str)
{   




    $str = str_replace("[b]", "<b>", $str);
    $str = str_replace("[/b]", "</b>", $str);
    $str = str_replace("[i]", "<i>", $str);
    $str = str_replace("[/i]", "</i>", $str);
    $str = str_replace("[u]", "<u>", $str);
    $str = str_replace("[/u]", "</u>", $str);
    $str = str_replace("[sup]", "<sup>", $str);
    $str = str_replace("[/sup]", "</sup>", $str);
    $str = str_replace("[sub]", "<sub>", $str);
    $str = str_replace("[/sub]", "</sub>", $str);

    return $str;

    //die;


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


    // function login()
    // {
    //     error_reporting(0);
    //     $email   = $this->input->post('email');
    //     $mypassword = $this->input->post('password');
    //     $users = $this->db->query('select * from edu_apps.app_userdata where email  = "' . $email . '"')->row();

    //     $info = $this->db->query('select * from edu_apps.edu_userinfo where email  = "' . $email . '"')->row();


    //     // echo "<pre>";
    //     // print_r($info);
    //     // die;




    //     if ($users) {

    //         $dbpassword = $users->password;

    //         $password = sha1(md5($mypassword));


    //         if ($dbpassword == $password) {
    //             if ($users->userstatus == 1) {
    //                 $data['status'] = 200;
    //                 $data['message'] = "success";
    //                 $data['key'] = $users->keycode;
    //                 $data['email'] = $users->email;
    //                 $data['nama'] = $info->namalengkap;
    //                 $data['no_wa'] = $info->nowa;
    //                 $data['no_tlp'] = $info->notlp;
    //             } else if ($users->userstatus == 2) {
    //                 $data['status'] = 300;
    //                 $data['message'] = "Anda Belum Reset Password";
    //                 $data['key'] = $users->keycode;
    //                 $data['email'] = $users->email;
    //             } else if ($users->userstatus == 0) {
    //                 $data['status'] = 205;
    //                 $data['message'] = "Akun Anda Belum verifikasi";
    //                 $data['key'] = $users->keycode;
    //                 $data['email'] = $users->email;
    //             }
    //         } else {
    //             $data['status'] = 405;
    //             $data['message'] = "email/password anda salah";
    //             $data['key'] = "`12345";
    //             $data['email'] = "12345";
    //         }
    //     } else {
    //         $data['status'] = 405;
    //         $data['message'] = "Akun Anda Belum Aktif";
    //         $data['key'] = "`12345";
    //         $data['email'] = "12345";
    //     }

    //     echo json_encode($data);
    // }

     function login(){

        $email = $this->input->post('email');
        $password = $this->input->post('password');
           $url = "https://dev-api.edunitas.com/login_api";




                  $postData = array(
                     "email"=>$email,
                    "password"=>$password,
                  

                 );


                  // echo "<pre>";
                  // print_r($postData);

            // for sending data as json type
            $fields = json_encode($postData);


            

    $ch = curl_init($url);
    curl_setopt(
        $ch,
        CURLOPT_HTTPHEADER,
        array(
            'Content-Type: application/json', // if the content type is json
          //  'bearer: '.$token // if you need token in header
        )
    );

          //  curl_setopt($ch, CURLOPT_HEADER, false);
           // curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

            $result = curl_exec($ch);
            curl_close($ch);

          //   return $result;

            $output = json_decode($result);

            // echo "<pre>";
            // print_r($output);
            // die;

            echo json_encode($output);
    }


     function event_akan_datang()
    {

        error_reporting(0);
        header('Access-Control-Allow-Origin: *');
        // header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
        header('Content-Type: application/json');

        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Cache-Control, Pragma, Authorization, Accept, Accept-Encoding");




        $sql = $this->db->query("select e.*,j.kategori_nama,j.id_kategori from event as e 
        inner JOIN kategori as j on e.id_kategori=j.id_kategori
                where  e.mode='event'")->result();


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



            if ($hariini < $s->tgl_mulai) {

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
                        );
                    }
                }
            }
        }

        if ($data_api) {

            $data_api_sukses = array(
                'status' => 200,
                'message' => "sukses",
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
            "jumlah_soal"=> 139
);
            $data_api_error = array(
                'status' => 400,
                'message' => "data kosong",
                'datanya' => $data_error,
            );
            echo json_encode($data_api_error);
        }
    }




    function event()
    {

        error_reporting(0);
        header('Access-Control-Allow-Origin: *');
        // header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
        header('Content-Type: application/json');

        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Cache-Control, Pragma, Authorization, Accept, Accept-Encoding");




        $sql = $this->db->query("select e.*,j.kategori_nama,j.id_kategori from event as e 
        inner JOIN kategori as j on e.id_kategori=j.id_kategori
                where  e.mode='event' and e.kedinasan = 1")->result();


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



            if ($hariini >= $s->tgl_mulai) {

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
                        );
                    }
                }
            }
        }

        if ($data_api) {

            $data_api_sukses = array(
                'status' => 200,
                'message' => "sukses",
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
            "jumlah_soal"=> 139
);
            $data_api_error = array(
                'status' => 400,
                'message' => "data kosong",
                'datanya' => $data_error,
            );
            echo json_encode($data_api_error);
        }
    }


    function latihan()


    {

        error_reporting(0);
        $sql = $this->db->query("select e.*,j.kategori_nama,j.id_kategori from event as e 
        inner JOIN kategori as j on e.id_kategori=j.id_kategori
                where  e.mode='latihan' group by e.judul,e.tgl_mulai,e.tgl_selesai")->result();

        // echo "<pre>";
        // print_r($sql);
        // die;

        foreach ($sql as $s) {




            $hariini = date('Y-m-d');

            //$hariini = '2022-03-06';


            if ($hariini >= $s->tgl_mulai) {

                //jika hari ini kurang dari tgl selesai
                if ($s->tgl_selesai >= $hariini) {
                    $data_api[] = array(
                        "id_event" => base64_encode($s->id_event),
                        "judul" => $s->judul,
                        "tgl_mulai" => TanggalIndo($s->tgl_mulai),
                        "tgl_selesai" => TanggalIndo($s->tgl_selesai),
                        "desc" => $s->desc,
                        "img" => $s->img,
                        "status" => $s->status,
                        "mode" => $s->mode,

                    );
                }
            }
        }

        if ($data_api) {

            $data_api_sukses = array(
                'status' => 200,
                'message' => "sukses",
                'datanya' => $data_api
            );
            echo json_encode($data_api_sukses);

            // echo json_encode($data_api);
        } else {
            $data_api_error = array(
                'status' => 400,
                'message' => "data kosong",
            );
            echo json_encode($data_api_error);
        }
    }



    function detail($id_event){

        $id_event2 = base64_decode($id_event);
        $sql = $this->db->query("select e.*,m.tgl_mulai as tgl_mulai_materi,m.tgl_selesai as tgl_selesai_materi,m.materi_id,m.materi_nama,m.id_jurusan,m.waktu from event as e
        inner join materi as m on m.id_event = e.id_event where m.publish = 1 and e.id_event = '" . $id_event2 . "' order by m.no_urut asc")->result();


        foreach ($sql as $s) {

            $jurusan = $this->db->query("select * from jurusan where id_jurusan = " . $s->id_jurusan)->row();


            $jenis = $this->db->query("select * from jenis where id_jenis = " . $jurusan->id_jenis)->row();

            $kategori = $this->db->query("select * from kategori where id_kategori = " . $s->id_kategori)->row();

            $soal = $this->db->query("select * from soalonline where materi_id = " . $s->materi_id)->result();




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



    




        $data_api_api = array(

            "id_event" => $sql[0]->id_event,
            "judul" => $sql[0]->judul,
            // "tgl_mulai"=> $sql[0]->tgl_mulai,
            // "tgl_selesai"=> $sql[0]->tgl_selesai,

            "tgl_mulai" => TanggalIndo($sql[0]->tgl_mulai_materi),
            "tgl_selesai" => TanggalIndo($sql[0]->tgl_selesai_materi),
            'kategori' => $kategori->kategori_nama,


            "desc" => $sql[0]->desc,
            "img" => $sql[0]->img,
            "status" => $sql[0]->status,
            "mode" => $sql[0]->mode,
            "jumlah_soal" => $jumlah_soal,
            "jumlah_waktu" => $jumlah_waktu,
            "data" => $data_api,
        );

        echo json_encode($data_api_api);
    }



    function detail2($id_event)
    {

        $id_event2 = base64_decode($id_event);
        $sql = $this->db->query("select e.*,m.tgl_mulai as tgl_mulai_materi,m.tgl_selesai as tgl_selesai_materi,m.materi_id,m.materi_nama,m.id_jurusan,m.waktu from event as e
        inner join materi as m on m.id_event = e.id_event where m.publish = 1 and e.id_event = '" . $id_event2 . "' order by m.no_urut asc")->result();


        foreach ($sql as $s) {

            $jurusan = $this->db->query("select * from jurusan where id_jurusan = " . $s->id_jurusan)->row();


            $jenis = $this->db->query("select * from jenis where id_jenis = " . $jurusan->id_jenis)->row();

            $kategori = $this->db->query("select * from kategori where id_kategori = " . $s->id_kategori)->row();

            $soal = $this->db->query("select * from soalonline where materi_id = " . $s->materi_id)->result();




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


        // echo "<pre>";
        // print_r($data_api);
        // die;


        $jumlah_soal = 0;
        $jumlah_waktu = 0;
        foreach ($data_api as $d) {
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

   // print_r($result);




        $data_api_api = array(

            "id_event" => $sql[0]->id_event,
            "judul" => $sql[0]->judul,
            // "tgl_mulai"=> $sql[0]->tgl_mulai,
            // "tgl_selesai"=> $sql[0]->tgl_selesai,

            "tgl_mulai" => TanggalIndo($sql[0]->tgl_mulai_materi),
            "tgl_selesai" => TanggalIndo($sql[0]->tgl_selesai_materi),
            'kategori' => $kategori->kategori_nama,


            "desc" => $sql[0]->desc,
            "img" => $sql[0]->img,
            "status" => $sql[0]->status,
            "mode" => $sql[0]->mode,
            "jumlah_soal" => $jumlah_soal,
            "jumlah_waktu" => $jumlah_waktu,
            "data" => $result
        );

        echo json_encode($data_api_api);
    }



    function datadiri()
    {

        $email = $this->input->post('email');
        $nama = $this->input->post('nama');
        $no_wa = $this->input->post('no_wa');
        $wilayah = $this->input->post('wilayah');
        $kampus_impian = $this->input->post('kampus_impian');
        $jurusan_diinginkan = $this->input->post('jurusan_diinginkan');
        $asal_sekolah = $this->input->post('asal_sekolah');

        $kampus_favorit = $this->input->post('kampus_favorit');
        $id_event = $this->input->post('id_event');

        $provinsi = $this->input->post('provinsi');

        // $email = "tes";
        // $nama = "tes";
        // $no_wa = "tes";
        // $wilayah = "tes";
        // $kampus_impian = "tes";
        // $jurusan_diinginkan = "tes";
        // $asal_sekolah = "1";


        $data_insert = array(
            'email' => $email,
            'nama' => $nama,
            'no_wa' => $no_wa,
            'wilayah' => $wilayah,
            'kampus_impian' => $kampus_impian,
          //  'jurusan_diinginkan' => $jurusan_diinginkan,
            'asal_sekolah' => $asal_sekolah,
            'create_add' => date('Y-m-d H:i:s'),
            'id_event' => base64_decode($id_event),
            'kampus_favorit'=>$kampus_favorit,
            'kedinasan'=>1,
            'provinsi'=>$provinsi,
        );

        // echo "<pre>";
        // print_r($data_insert);
        // die;

        $simpan = $this->db->insert('peserta', $data_insert);
        $id_peserta_h = $this->db->insert_id();

        if ($simpan) {
            $data['status'] = 200;
            $data['message'] = "sukses";
            $data['id_peserta'] = $id_peserta_h;
        } else {
            $data['status'] = 404;
            $data['message'] = "gagal";
            $data['id_peserta'] = 0;
        }
        echo json_encode($data);
    }

    function soal($materi_id2)
    {

        //$materi_id2 = base64_decode($materi_id);


        $materi_ = $this->db->query('select * from materi where publish = 1 and materi_id = "' . $materi_id2 . '"')->row();

        $soal = $this->db->query('select * from soalonline where materi_id = "' . $materi_id2 . '"')->result_array();


        // echo "<pre>";
        // print_r($soal);

        // die;

        foreach ($soal as $s) {




            $pilihan = json_decode($s['pilihan']);



            foreach ($pilihan as $pi) {

                if ($pi->code == '1') {
                    $folder_jawaban = 'jawaban_a';
                    $nama_file_jawaban = $pi->name;
                } elseif ($pi->code == '2') {
                    $folder_jawaban = 'jawaban_b';
                    $nama_file_jawaban = $pi->name;
                } elseif ($pi->code == '3') {
                    $folder_jawaban = 'jawaban_c';
                    $nama_file_jawaban = $pi->name;
                } elseif ($pi->code == '4') {
                    $folder_jawaban = 'jawaban_d';
                    $nama_file_jawaban = $pi->name;
                } elseif ($pi->code == '5') {
                    $folder_jawaban = 'jawaban_e';
                    $nama_file_jawaban = $pi->name;
                }

                $Path_img_jawaban = base_url("assets/file_upload/soalonline/" . $folder_jawaban . "/" . $nama_file_jawaban);
                $Path_jawaban = FCPATH . 'assets/file_upload/soalonline/' . $folder_jawaban . "/" . $nama_file_jawaban;


                if (file_exists($Path_jawaban)) {
                    $Path2_jawaban = $Path_img_jawaban;
                    $type = 'gambar';
                } else {
                    $Path2_jawaban =  $pi->name;
                    $type = 'text';
                }




                $pil[$s['id']][] = array(
                    'code' => (string)$pi->code,
                    'name' => (string)$Path2_jawaban,
                    'type' => (string)$type,
                );
            }

            $Path_img = base_url("assets/file_upload/soalonline/soal/" . $s['img']);

            $Path = FCPATH . 'assets/file_upload/soalonline/soal/' . $s['img'];

            if (file_exists($Path)) {
                $Path1 = $s['img'];
                if ($Path1) {
                    $Path2 = $Path_img;
                } else {
                    $Path2 = "";
                }
            } else {
                $Path2 = "";
            }


            $data_soal[] = array(
                'no' => $s['id'],
                'ccid' => "Nnc9PQb93bbfb93bbf",
                'pertanyaan' => $this->ubahkotak($s['pertanyaan']),
                'img' => $Path2,
                'pilihan' => $pil[$s['id']],
                'pembahasan' => $s['pembahasan'],

            );
        }


        $data_api = array(
            'kode' => 1,
            'message' => 'sukses',
            'listdata' => array(
                "dari" => 1,
                "hingga" => count($data_soal),
                "totaldata" => count($data_soal),
                "totalhalaman" => 1,

                'materi_nama' => $materi_->materi_nama,
                "datanya" => $data_soal,
                'waktu' => $materi_->waktu,
            )
        );

        echo json_encode($data_api);
    }

       function soal_event($id_event)
    {

        $id_event2 = base64_decode($id_event);



        $materi = $this->db->query('select materi_id,materi_nama,waktu from  materi where id_event = "' . $id_event2 . '" order by no_urut asc')->result_array();

   


        foreach ($materi as $m) {
            $soal = $this->db->query('select * from soalonline where materi_id = "' . $m['materi_id'] . '"')->result_array();



            foreach ($soal as $s) {
                $pilihan = json_decode($s['pilihan']);



                foreach ($pilihan as $pi) {

                    if ($pi->code == '1') {
                        $folder_jawaban = 'jawaban_a';
                        $nama_file_jawaban = $pi->name;
                    } elseif ($pi->code == '2') {
                        $folder_jawaban = 'jawaban_b';
                        $nama_file_jawaban = $pi->name;
                    } elseif ($pi->code == '3') {
                        $folder_jawaban = 'jawaban_c';
                        $nama_file_jawaban = $pi->name;
                    } elseif ($pi->code == '4') {
                        $folder_jawaban = 'jawaban_d';
                        $nama_file_jawaban = $pi->name;
                    } elseif ($pi->code == '5') {
                        $folder_jawaban = 'jawaban_e';
                        $nama_file_jawaban = $pi->name;
                    }

                    $Path_img_jawaban = base_url("assets/file_upload/soalonline/" . $folder_jawaban . "/" . $nama_file_jawaban);
                    $Path_jawaban = FCPATH . 'assets/file_upload/soalonline/' . $folder_jawaban . "/" . $nama_file_jawaban;

                    if ($nama_file_jawaban) {
                        if (file_exists($Path_jawaban)) {
                            $Path2_jawaban = $Path_img_jawaban;
                            $type = 'gambar';
                        } else {
                            $Path2_jawaban =  $pi->name;
                            $type = 'text';
                        }
                    } else {
                        $Path2_jawaban =  $pi->name;
                        $type = 'text';
                    }



                    $pil[$s['id']][] = array(
                        'code' => (string)$pi->code,
                        'name' => (string)$Path2_jawaban,
                        'type' => (string)$type,
                    );
                }


                //  $Path = './assets/file_upload/soalonline/'.$s['img'];
                $Path_img = base_url("assets/file_upload/soalonline/soal/" . $s['img']);

                $Path = FCPATH . 'assets/file_upload/soalonline/soal/' . $s['img'];


                if (file_exists($Path)) {
                    $Path1 = $s['img'];
                    if ($Path1) {
                        $Path2 = $Path_img;
                    } else {
                        $Path2 = "";
                    }
                } else {
                    $Path2 = "";
                }

                $data_soal[] =
                    array(
                        'no' => $s['id'],
                        'materi_nama' => (string)$m['materi_nama'],
                          'materi_id' => (string)base64_encode($m['materi_id']),
                        'pertanyaan' => (string)$s['pertanyaan'],
                        // 'img' => base_url('assets/file_upload/soalonline/' . $s['img']),
                        'img' => $Path2,
                        'pilihan' => $pil[$s['id']],
                    );
            }

            // $j_materi_id[] = array(
            //     'materi_id' => base64_encode($m['materi_id']),
            //     'materi_nama' => $m['materi_nama'],
            //     'datanya' => $data_soal[$m['materi_id']],
            //     "totalhalaman" => 1,
            //     "hingga" => count($soal),
            //     "totaldata" => count($soal),
            //     'waktu' => $m['waktu'],
            //     // 'waktu' => 1,
            // );
        }

        $data_api = array(
            'kode' => 1,
            'message' => 'sukses',
            'listdata' => array(
                "dari" => 1,
                "waktu"=>100,
                "totaldata" => count($data_soal),
                "datanya" => $data_soal,

            )
        );

        echo json_encode($data_api);
    }
     function detail_latihan($judul)
    {
        // echo "tes";
        // die;
        error_reporting(0);
        //$judul = "Pekan-I---Latihan-Soal";


        $event_latihan = $this->db->query("select e.*,j.kategori_nama,j.id_kategori from event as e 
        inner JOIN kategori as j on e.id_kategori=j.id_kategori
                where  e.mode='latihan' and REPLACE(judul, ' ', '-' ) = '" . $judul . "'")->result();

        // echo "<pre>";
        // print_r($event_latihan);

        // die;

        foreach ($event_latihan as $s) {

            $materi[$s->id_event] = $this->db->query("select * from materi where publish = 1 and id_event = " . $s->id_event)->result();


            // echo "<pre>";
            // print_r($materi);

            // die;

            foreach ($materi[$s->id_event] as $e) {

                //$jenis = $this->db->query("select * from jenis where id_kategori = ".$s->id_kategori)->row();

                $soal = $this->db->query("select * from soalonline where materi_id = " . $e->materi_id)->result();

                $jurusan = $this->db->query("select * from jurusan where id_jurusan = " . $e->id_jurusan)->row();

                $jenis = $this->db->query("select * from jenis where id_jenis = " . $jurusan->id_jenis)->row();



                $data[$s->kategori_nama][]  = array(
                    'materi_nama' => $e->materi_nama,
                    'materi_id' => $e->materi_id,
                    'jenis' => $jenis->jenis_nama,
                    'jenis_label' => $jenis->label,
                    'waktu' => $e->waktu,
                    'soal' => count($soal),
                    'jurusan' => $jurusan->jurusan_nama,
                    'kategori'=>$s->kategori_nama


                );


                 $data_api2[]  = array(
                    'materi_nama' => $e->materi_nama,
                    'materi_id' => $e->materi_id,
                    'jenis' => $jenis->jenis_nama,
                    'jenis_label' => $jenis->label,
                    'waktu' => $e->waktu,
                    'soal' => count($soal),
                    'jurusan' => $jurusan->jurusan_nama,
                    'kategori'=>$s->kategori_nama


                );
            }


           
        }



        $result = array();
    foreach ($data_api2 as $key => $record) {
        if (!isset($result[$record['materi_id']])) {


            $result[$record['kategori']] = array(
                // 'jenis' => $record['jenis'],
                // 'jenis_label' => $record['jenis_label'],
                'list' => array(
                        //"datanya" => array_search("TPS",$data_api[0],true),
                          "datanya" => $data[$record['kategori']],
                ),
            );
            
        }
        else {
            $result[$record['materi_id']]['materi_nama'][] = array($record['materi_id'],$record['materi_nama']);
        }
    }
    $result = array_values($result);

        $data_api = array(
            'status' => 200,
            //'kategori' => $kategori->kategori_nama,
            'tanggal' => TanggalIndo($event_latihan[0]->tgl_mulai) . '-' . TanggalIndo($event_latihan[0]->tgl_selesai),
            'event' => $event_latihan[0]->judul,
            'datanya' => $result,

        );

        echo json_encode($data_api);
    }


    function wilayah(){

    

                  $url = "https://api.edunitas.com/mod/edun-load-g";

                  $postData = array(
                     "format"=> "json",
                    "formdata_groupjkt"=> 1,
                    "formdata_listmod"=> "Kabupaten-Kota",
                    "formdata_origin"=> "pt",
                    "formdata_type"=> "1",
                    "setdata_mod"=> "list-wilayah",
                    "formdata_groupjkt"=>1,
                    "formdata_replace"=>"0",

                );




            // for sending data as json type
            $fields = json_encode($postData);

             

              $headers = array (
            

            'Content-Type: application/json'  );

    $ch = curl_init($url);
    curl_setopt(
        $ch,
        CURLOPT_HTTPHEADER,
        array(
            'Content-Type: application/json', // if the content type is json
          //  'bearer: '.$token // if you need token in header
        )
    );

          //  curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

            $result = curl_exec($ch);
            curl_close($ch);

          //   return $result;

            $output = json_decode($result);

            echo json_encode($output);

      

    }




     function news(){

                  // $url = "https://api.edulearning.me/me-forum/kirim?cid=ajhyTjJXSkxDZUE9";

                       $url = "https://dev-api.edunitas.com/edu_tryout";




                  


              $headers = array (
            

            'Content-Type: application/json'  );

    $ch = curl_init($url);
    curl_setopt(
        $ch,
        CURLOPT_HTTPHEADER,
        array(
            'Content-Type: application/json', // if the content type is json
          //  'bearer: '.$token // if you need token in header
        )
    );

          //  curl_setopt($ch, CURLOPT_HEADER, false);
           // curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
          //  curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

            $result = curl_exec($ch);
            curl_close($ch);

          //   return $result;

            $output = json_decode($result);

            echo json_encode($output);

    }


     function jawaban_event()
    {

      



        $email = $this->input->post('email');
        $data_array2 = $this->input->post('res');
        $tgl_mulai = $this->input->post('tgl_mulai');
        $id_peserta = $this->input->post('id_peserta');




       


       
        $data_array = $this->objToArray(json_decode($data_array2, true));



        //  echo "<pre>";
        // print_r($data_array['event']);
        // die;



        //     echo "<pre>";
        //     print_r($data_array['datanya']);

        // echo json_encode($data_array['datanya']);
        //     die;

         

       
         $total_nilai_perevent = 0;
        foreach ($data_array['datanya'] as  $a) {

            //  echo "<pre>";
            // print_r($a);
            // die;

           

            $cek_tkp = $this->db->query('select id_jenis from materi where materi_id ='.base64_decode($a['materi_id']))->row();

             // echo "<pre>";
             //      print_r($cek_tkp);
             //     die;

              $total_nilai = 0;

            $benar = 0;
            $salah = 0;
            $kosong = 0;
            $jawaban_tkp = 0;

            if($cek_tkp->id_jenis == '11'){

               // echo "tes";


                 $sql_soal = $this->db->query('select * from soalonline where materi_id = ' . base64_decode($a['materi_id']))->result();


            // echo "<pre>";
            //       print_r($sql_soal);
            //      die;


          
            foreach ($sql_soal as $s => $key) {



                if ($key->id == $a['ans_' . $key->id]['soal']) {


                    if($a['ans_' . $key->id]['jawaban']=='1'){

                        $jawaban_tkp = $key->bobot_a; 

                    }elseif($a['ans_' . $key->id]['jawaban']=='2'){
                        $jawaban_tkp = $key->bobot_b;
                        
                    }elseif($a['ans_' . $key->id]['jawaban']=='3'){

                        $jawaban_tkp = $key->bobot_c;
                        
                    }elseif($a['ans_' . $key->id]['jawaban']=='4'){
                        $jawaban_tkp = $key->bobot_d;
                    }elseif($a['ans_' . $key->id]['jawaban']=='5'){
                        $jawaban_tkp = $key->bobot_e;
                        
                    }

                

                       if($a['ans_' . $key->id]['jawaban']=='0'){
                        //$jawaban_tkp = $key->bobot_e;

                       // $jumlah_tkp_kosong +=  1;

                         $kosong += 1;
                        
                    }

                      elseif($a['ans_' . $key->id]['jawaban']!='0'){
                       // $jawaban_tkp = $key->bobot_e;

                        //$jumlah_tkp +=  1;

                         $benar += 1;

                         $total_nilai +=  $jawaban_tkp;
                        
                    }

                }

                $cari_user = $this->db->query('select * from jawaban where email="' . $email . '" and materi_id="' . $key->materi_id . '"')->row();

                if ($cari_user) {
                    $mode = 3;
                } else {
                    $mode = 1;
                }

            }



                 $data_jawaban = array(
                'materi_id' => base64_decode($a['materi_id']),
                'jawaban' => json_encode($a),
                
                'skor' => $total_nilai,
                'create_add' => date('Y-m-d H:i:s'),
                'email' => $email,
                'id_event' => base64_decode($data_array['event']),
                'tgl_mulai' => $tgl_mulai,
                'mode' => $mode,
                'benar' => $benar,
                'kosong' => $kosong,
                'salah' => $salah,
                'id_peserta' => $id_peserta,
            );

           $q = $this->db->insert('jawaban', $data_jawaban);




            }else{

                // echo "<pre>";
                // print_r($a);

                // die;

                 $sql_soal = $this->db->query('select * from soalonline where materi_id = ' . base64_decode($a['materi_id']))->result();


            // echo "<pre>";
            //       print_r($sql_soal);
            //       die;


          
            foreach ($sql_soal as $s => $key) {



                if ($key->id == $a['ans_' . $key->id]['soal']) {

                    //hitung benar

                    if ($key->jawaban == $a['ans_' . $key->id]['jawaban']) {
                        $total_nilai +=  5;
                        $benar += 1;

                        //  echo "benar";
                    } elseif ($a['ans_' . $key->id]['jawaban'] == 0) {
                        //ga di isi 
                        $total_nilai +=  0;
                        $kosong += 1;
                        //  echo "ga disi";
                    } else {

                        // echo "salah";

                        //salah
                        $total_nilai +=   0;
                        $salah += 1;
                    }
                }

                $cari_user = $this->db->query('select * from jawaban where email="' . $email . '" and materi_id="' . $key->materi_id . '"')->row();

                if ($cari_user) {
                    $mode = 3;
                } else {
                    $mode = 1;
                }


                
            }

             $data_jawaban = array(
                'materi_id' => base64_decode($a['materi_id']),
                'jawaban' => json_encode($a),
                
                'skor' => $total_nilai,
                'create_add' => date('Y-m-d H:i:s'),
                'email' => $email,
                'id_event' => base64_decode($data_array['event']),
                'tgl_mulai' => $tgl_mulai,
                'mode' => $mode,
                'benar' => $benar,
                'kosong' => $kosong,
                'salah' => $salah,
                'id_peserta' => $id_peserta,
            );

                 // echo count($data_jawaban);
                 // die;



               $q = $this->db->insert('jawaban', $data_jawaban);

            // echo "<pre>";
            //      print_r($data_jawaban);
            //      die;

            }

           

        

           

            $total_nilai_perevent += $total_nilai;
        }

        // echo "<pre>";
        // print_r($data_jawaban);
        //die;


        if ($q) {
            $data_api = array(
                'status' => 200,
                'message' => 'suksess',
                'skor' => $total_nilai_perevent,
            );

            echo json_encode($data_api);
        }
    }



    function jawaban()
    {
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
        $tgl_mulai = $this->input->post('tgl_mulai');
        $data_array2 = $this->input->post('res');

        $id_peserta = $this->input->post('id_peserta');


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

        //echo json_encode($data_array);
        // echo "<pre>";
        // print_r($data_array);
        // die;


        $sql_soal = $this->db->query('select * from soalonline where materi_id = ' . $data_array['materi_id'])->result();

        $event = $this->db->query('select id_event from materi where publish = 1 and materi_id = ' . $data_array['materi_id'])->row();



        //    echo "<pre>";
        //    print_r($event);

        //    die;


        $total_nilai = 0;
        $benar = 0;
        $salah = 0;
        $kosong = 0;
        foreach ($sql_soal as $s => $key) {





            if ($key->id == $data_array['ans_' . $key->id]->soal) {

                //hitung benar

                if ($key->jawaban == $data_array['ans_' . $key->id]->jawaban) {
                    $total_nilai +=  4;
                    $benar += 1;

                    //  echo "benar";
                } elseif ($data_array['ans_' . $key->id]->jawaban == 0) {
                    //ga di isi 
                    $total_nilai +=  0;
                    $kosong += 1;
                    //  echo "ga disi";
                } else {

                    // echo "salah";

                    //salah
                    $total_nilai +=   -1;
                    $salah += 1;
                }
            }
        }


        // if($total_nilai<=0){
        //       $total_nilai2 = 0;
        //   }else{
        //       $total_nilai2 = $total_nilai;
        //   }
        $data_jawaban = array(
            'materi_id' => $data_array['materi_id'],
            'jawaban' => json_encode($data_array),
            //'jawaban'=>$data_array,
            'skor' => $total_nilai,
            'create_add' => date('Y-m-d H:i:s'),
            'email' => $email,
            'id_event' => $event->id_event,
            'tgl_mulai' => $tgl_mulai,
            'mode' => 2,
            'benar' => $benar,
            'salah' => $salah,
            'kosong' => $kosong,
            // 'id_peserta'=>$id_peserta,
        );

        $q = $this->db->insert('jawaban', $data_jawaban);

        $id_jawaban_h = $this->db->insert_id();


        if ($q) {
            $data_api = array(
                'status' => 200,
                'message' => 'suksess',
                'skor' => $total_nilai,
                'id_jawaban' => $id_jawaban_h,
            );
        }

        echo json_encode($data_api);
    }


   function cari_nilai()
    {


        $id_event2 = $this->input->post('id_event');

        $id_peserta = $this->input->post('id_peserta');

        $id_event = base64_decode($id_event2);
        $email = $this->input->post('email');

        $event =  $this->db->query('select * from event where id_event =  "' . $id_event . '"')->row();

        $materi =  $this->db->query('select * from materi where publish = 1 and id_event =  "' . $id_event . '"')->result();


        foreach ($materi as $m) {

            // print_r($m->materi_id);
            $jawaban[] =  $this->db->query('select * from jawaban where id_peserta = "' . $id_peserta . '" and materi_id =  "' . $m->materi_id . '"  and email="' . $email . '" order by materi_id desc')->row();

            $soal[$m->materi_id] =  $this->db->query('select * from soalonline where materi_id =  "' . $m->materi_id . '" order by materi_id desc')->result();


            $jawaban_skor[$m->materi_id] =  $this->db->query('select * from jawaban where id_peserta = "' . $id_peserta . '" and  materi_id =  "' . $m->materi_id . '"  and email="' . $email . '" order by materi_id desc')->row();





            // echo "<pre>";
            // print_r($soal);

            foreach ($soal[$m->materi_id] as  $key) {
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

        foreach ($key1 as $key) {
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
                    }elseif($a['ans_' . $key->id]['jawaban']=='5'){
                        $jawaban_tkp = $key->bobot_e;
                        
                    }

                   // $total_nilai +=  $jawaban_tkp;

                      if($a['ans_' . $key->id]['jawaban']=='0'){
                        //$jawaban_tkp = $key->bobot_e;

                        $jumlah_tkp_kosong +=  1;
                        
                    }

                      elseif($a['ans_' . $key->id]['jawaban']!='0'){
                       // $jawaban_tkp = $key->bobot_e;

                        $jumlah_tkp +=  1;

                         $skor_jawaban_tkp += $jawaban_tkp; 

                        
                    }

                   
                   
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

        if ($hasil_hasil_nilai <= 0) {
            $hasil_hasil_nilai2 = 0;
        } else {
            $hasil_hasil_nilai2 = $hasil_hasil_nilai;
        }

        $data_api = array(
            'tgl_mulai' => $event->tgl_mulai,
            'tgl_selesai' => $event->tgl_selesai,
            'skor' => $hasil_hasil_nilai,

            'skor_benar' => $skor_benar,
            'skor_gadisi' => $skor_gadisi,
            'skor_salah' => $skor_salah,
            'skor_jawaban_tkp'=>$skor_jawaban_tkp,
            'jumlah_tkp'=>$jumlah_tkp,


            'benar' => $benar + $jumlah_tkp,
            'kosong' => $kosong+$jumlah_tkp_kosong,
            'salah' => $salah,

            'totalsoal' => count($key1),
        );

        echo json_encode($data_api);
    }


    function pembahasan()
    {

        error_reporting(0);
        $id_event2 = $this->input->post('id_event');
        $id_peserta = $this->input->post('id_peserta');

        $id_event = base64_decode($id_event2);
        $email = $this->input->post('email');



        $materi =  $this->db->query('select * from materi where publish = 1 and id_event =  "' . $id_event . '"')->result();

        // echo "<pre>";
        // print_r($materi);
        foreach ($materi as $m) {
            $jawaban[] =  $this->db->query('select * from jawaban where id_peserta = "' . $id_peserta . '" and  materi_id =  "' . $m->materi_id . '"  and email="' . $email . '" order by materi_id desc')->row();

            $soal[$m->materi_id] =  $this->db->query('select * from soalonline where materi_id =  "' . $m->materi_id . '" order by materi_id desc')->result();
            $jawaban_skor[$m->materi_id] =  $this->db->query('select * from jawaban where id_peserta = "' . $id_peserta . '" and  materi_id =  "' . $m->materi_id . '"  and email="' . $email . '" order by materi_id desc')->row();


            foreach ($soal[$m->materi_id] as $k => $key) {

                $pilihan = json_decode($key->pilihan);

                $a = $this->objToArray(json_decode($jawaban_skor[$key->materi_id]->jawaban, true));

                foreach ($pilihan as $pi) {

                    if ($pi->code == '1') {
                        $folder_jawaban = 'jawaban_a';
                        $nama_file_jawaban = $pi->name;
                    } elseif ($pi->code == '2') {
                        $folder_jawaban = 'jawaban_b';
                        $nama_file_jawaban = $pi->name;
                    } elseif ($pi->code == '3') {
                        $folder_jawaban = 'jawaban_c';
                        $nama_file_jawaban = $pi->name;
                    } elseif ($pi->code == '4') {
                        $folder_jawaban = 'jawaban_d';
                        $nama_file_jawaban = $pi->name;
                    } elseif ($pi->code == '5') {
                        $folder_jawaban = 'jawaban_e';
                        $nama_file_jawaban = $pi->name;
                    }

                    $Path_img_jawaban = base_url("assets/file_upload/soalonline/" . $folder_jawaban . "/" . $nama_file_jawaban);
                    $Path_jawaban = FCPATH . 'assets/file_upload/soalonline/' . $folder_jawaban . "/" . $nama_file_jawaban;

                    if ($nama_file_jawaban) {
                        if (file_exists($Path_jawaban)) {
                            $Path2_jawaban = $Path_img_jawaban;
                            $type = 'gambar';
                        } else {
                            $Path2_jawaban =  $pi->name;
                            $type = 'text';
                        }
                    } else {
                        $Path2_jawaban =  $pi->name;
                        $type = 'text';
                    }



                    $pil[$key->id][] = array(
                        'code' => (string)$pi->code,
                        'name' => (string)$Path2_jawaban,
                        'type' => (string)$type,
                    );
                }


               if ($key->id == $a['ans_' . $key->id]['soal']) {

                  



                    //  $Path = './assets/file_upload/soalonline/'.$s['img'];
                    $Path_img = base_url("assets/file_upload/soalonline/soal/" . $key->img);

                    $Path = FCPATH . 'assets/file_upload/soalonline/soal/' . $key->img;

                    if (file_exists($Path)) {
                        $Path1 = $key->img;
                        if ($Path1) {
                            $Path2 = $Path_img;
                        } else {
                            $Path2 = "";
                        }
                    } else {
                        $Path2 = "";
                    }


                    // pembahasan
                    $Path_pembahasan_img = base_url("assets/file_upload/soalonline/pembahasan/" . $key->pembahasan_img);

                    $Path = FCPATH . 'assets/file_upload/soalonline/pembahasan/' . $key->pembahasan_img;

                    if (file_exists($Path)) {
                        $Path1_pembahasan_img = $key->pembahasan_img;
                        if ($Path1_pembahasan_img) {
                            $Path2_pembahasan_img = $Path_pembahasan_img;
                        } else {
                            $Path2_pembahasan_img = "";
                        }
                    } else {
                        $Path2_pembahasan_img = "";
                    }



                    $data_data[$key->materi_id][] = array(
                        'id' => $key->id,
                        'materi_id' => $key->materi_id,
                        'materi_nama' => $m->materi_nama,

                        'pertanyaan' => $this->ubahkotak($key->pertanyaan),
                        'img' => $Path2,

                        'jawaban' => $key->jawaban,
                        'pilihan' => $pil[$key->id],
                        'pertanyaan_img' => $key->pertanyaan_img,
                        'pembahasan' => $key->pembahasan,
                        'pembahasan_img' => $Path2_pembahasan_img,
                        'jawaban_anda' => $a['ans_' . $key->id]['jawaban'],
                    );
                }
            }


            $data_api[$m->materi_id] = array(
                $m->materi_id => $data_data[$m->materi_id],

            );
        }


        foreach($data_api as $key => $d){
            $data_akhir[] = array(
                'materi_nama'=>$d[$key][0]['materi_nama'],
                'materi_id'=>$key,
                'data'=>$d[$key]

            );
        }

        echo json_encode($data_akhir);
    }



     function pembahasan_materi()
    {

        // $email = base64_decode($email2);
        // $id_jawaban = base64_decode($id_jawaban2);

        $email = $this->input->post('email');

        $id_jawaban = $this->input->post('id_jawaban');



        $id_jawaban_s =  $this->db->query('select * from jawaban where id_jawaban =  "' . $id_jawaban . '"')->row();

        $materi =  $this->db->query('select * from materi where publish = 1 and materi_id =  "' . $id_jawaban_s->materi_id . '"')->result();

        // echo "<pre>";
        // print_r($materi);

        // die;
        foreach ($materi as $m) {
            $jawaban[] =  $this->db->query('select * from jawaban where materi_id =  "' . $m->materi_id . '"  and email="' . $email . '" order by materi_id desc')->row();

            $soal[$m->materi_id] =  $this->db->query('select * from soalonline where materi_id =  "' . $m->materi_id . '" order by materi_id desc')->result();
            $jawaban_skor[$m->materi_id] =  $this->db->query('select * from jawaban where id_jawaban = "' . $id_jawaban . '" and materi_id =  "' . $m->materi_id . '"  and email="' . $email . '" order by materi_id desc')->row();


            foreach ($soal[$m->materi_id] as $k => $key) {

                $pilihan = json_decode($key->pilihan);
                $a = $this->objToArray(json_decode($jawaban_skor[$key->materi_id]->jawaban, true));


                foreach ($pilihan as $pi) {

                    if ($pi->code == '1') {
                        $folder_jawaban = 'jawaban_a';
                        $nama_file_jawaban = $pi->name;
                    } elseif ($pi->code == '2') {
                        $folder_jawaban = 'jawaban_b';
                        $nama_file_jawaban = $pi->name;
                    } elseif ($pi->code == '3') {
                        $folder_jawaban = 'jawaban_c';
                        $nama_file_jawaban = $pi->name;
                    } elseif ($pi->code == '4') {
                        $folder_jawaban = 'jawaban_d';
                        $nama_file_jawaban = $pi->name;
                    } elseif ($pi->code == '5') {
                        $folder_jawaban = 'jawaban_e';
                        $nama_file_jawaban = $pi->name;
                    }

                    $Path_img_jawaban = base_url("assets/file_upload/soalonline/" . $folder_jawaban . "/" . $nama_file_jawaban);
                    $Path_jawaban = FCPATH . 'assets/file_upload/soalonline/' . $folder_jawaban . "/" . $nama_file_jawaban;

                    if ($nama_file_jawaban) {
                        if (file_exists($Path_jawaban)) {
                            $Path2_jawaban = $Path_img_jawaban;
                            $type = 'gambar';
                        } else {
                            $Path2_jawaban =  $pi->name;
                            $type = 'text';
                        }
                    } else {
                        $Path2_jawaban =  $pi->name;
                        $type = 'text';
                    }



                    $pil[$key->id][] = array(
                        'code' => (string)$pi->code,
                        'name' => (string)$Path2_jawaban,
                        'type' => (string)$type,
                    );
                }


                if ($key->id == $a['ans_' . $key->id]['soal']) {



                    //  $Path = './assets/file_upload/soalonline/'.$s['img'];
                    $Path_img = base_url("assets/file_upload/soalonline/soal/" . $key->img);

                    $Path = FCPATH . 'assets/file_upload/soalonline/soal/' . $key->img;

                    if (file_exists($Path)) {
                        $Path1 = $key->img;
                        if ($Path1) {
                            $Path2 = $Path_img;
                        } else {
                            $Path2 = "";
                        }
                    } else {
                        $Path2 = "";
                    }


                    // pembahasan
                    $Path_pembahasan_img = base_url("assets/file_upload/soalonline/pembahasan/" . $key->pembahasan_img);

                    $Path = FCPATH . 'assets/file_upload/soalonline/pembahasan/' . $key->pembahasan_img;

                    if (file_exists($Path)) {
                        $Path1_pembahasan_img = $key->pembahasan_img;
                        if ($Path1_pembahasan_img) {
                            $Path2_pembahasan_img = $Path_pembahasan_img;
                        } else {
                            $Path2_pembahasan_img = "";
                        }
                    } else {
                        $Path2_pembahasan_img = "";
                    }



                    $data_data[] = array(
                        'id' => $key->id,
                        'materi_id' => $key->materi_id,
                        'materi_nama' => $m->materi_nama,

                        'pertanyaan' => $key->pertanyaan,
                        'img' => $Path2,

                        'jawaban' => $key->jawaban,
                        'pilihan' => $pil[$key->id],
                        'pertanyaan_img' => $key->pertanyaan_img,
                        'pembahasan' => $key->pembahasan,
                        'pembahasan_img' => $Path2_pembahasan_img,
                        'jawaban_anda' => $a['ans_' . $key->id]['jawaban'],
                    );
                }
            }


            // $data_api[] = array(
            //     $m->materi_id => $data_data[$m->materi_id],

            // );
        }

        echo json_encode($data_data);
    }



      function cari_nilai_materi()
    {



        $email = $this->input->post('email');
        $id_jawaban = $this->input->post('id_jawaban');

        $id_jawaban_s =  $this->db->query('select * from jawaban where id_jawaban =  "' . $id_jawaban . '"')->row();
        $materi =  $this->db->query('select * from materi where publish = 1 and materi_id =  "' . $id_jawaban_s->materi_id . '"')->result();



        foreach ($materi as $m) {

            // print_r($m->materi_id);
            $jawaban[] =  $this->db->query('select * from jawaban where materi_id =  "' . $m->materi_id . '"  and email="' . $email . '" order by materi_id desc')->row();

            $soal[$m->materi_id] =  $this->db->query('select * from soalonline where  materi_id =  "' . $m->materi_id . '" order by materi_id desc')->result();


            $jawaban_skor[$m->materi_id] =  $this->db->query('select * from jawaban where  id_jawaban = "' . $id_jawaban . '" and materi_id =  "' . $m->materi_id . '"  and email="' . $email . '" order by materi_id desc')->row();

            // echo "<pre>";
            // print_r($soal);

            foreach ($soal[$m->materi_id] as  $key) {
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

        foreach ($key1 as $key) {
            $a = $this->objToArray(json_decode($jawaban_skor[$key->materi_id]->jawaban, true));


            if ($key->id == $a['ans_' . $key->id]['soal']) {

                //hitung benar

                // echo $key->id;
                // die;

                if ($key->jawaban == $a['ans_' . $key->id]['jawaban']) {
                    $benar +=  1;
                    $skor_benar += 4;


                    //  echo "benar";
                } elseif ($a['ans_' . $key->id]['jawaban'] == 0) {
                    //ga di isi 
                    $kosong +=  1;
                    $skor_gadisi += 0;

                    //  echo "ga disi";
                } else {

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

        $hasil_hasil_nilai = $skor_benar + $skor_gadisi + $skor_salah;

        if ($hasil_hasil_nilai <= 0) {
            $hasil_hasil_nilai2 = 0;
        } else {
            $hasil_hasil_nilai2 = $hasil_hasil_nilai;
        }

        $data_api = array(
            'skor' => $hasil_hasil_nilai,

            'skor_benar' => $skor_benar,
            'skor_gadisi' => $skor_gadisi,
            'skor_salah' => $skor_salah,


            'benar' => $benar,
            'kosong' => $kosong,
            'salah' => $salah,

            'totalsoal' => count($key1),
        );

        echo json_encode($data_api);
    }






    function cek_mail($email,$nama,$no_tlp,$no_wa){

        $url = "https://api.edunitas.com/mod/edun-regist-g";


       
    
          $postData = array(
                "format"=> "json",
                    "setdata_mod"=> "chekmail",
                    "formdata_email"=> $email,
         );


  // echo "<pre>";
  // print_r($postData);

// for sending data as json type
      $fields = json_encode($postData);




      $ch = curl_init($url);
      curl_setopt(
      $ch,
      CURLOPT_HTTPHEADER,
      array(
      'Content-Type: application/json', // if the content type is json
      //  'bearer: '.$token // if you need token in header
      )
      );

      //  curl_setopt($ch, CURLOPT_HEADER, false);
      // curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

      $result = curl_exec($ch);
      curl_close($ch);

      //   return $result;

      $output = json_decode($result);


      // echo "<pre>";
      // print_r($output);

      if($output->statuscode=="001"){
         $this->register_latihan($email,$nama,$no_tlp,$no_wa);
      }else{
        $data['status']="202";
        $data['message']="sukses";

        echo json_encode($data);
      }

      

    }


    function register_latihan($email,$nama,$no_tlp,$no_wa){
        $url = "https://api.edunitas.com/mod/edun-regist-g";


        // $email = $this->input->post('email');
        // $nama = $this->input->post('nama');
        // $no_tlp = $this->input->post('no_tlp');
        // $no_wa = $this->input->post('no_wa');
        



            $postData = array(
                "format"=> "json",
                "setdata_mod"=> "regist",
                "formdata_email"=> $email,
                "formdata_nama"=> $nama,
                "formdata_notlp"=> $no_tlp,
                "formdata_nowa"=> $no_wa,
               
                "formdata_lulusan"=> "SMA",
                "formdata_alias"=> "tryout-p"
            );


  // echo "<pre>";
  // print_r($postData);

// for sending data as json type
      $fields = json_encode($postData);




      $ch = curl_init($url);
      curl_setopt(
      $ch,
      CURLOPT_HTTPHEADER,
      array(
      'Content-Type: application/json', // if the content type is json
      //  'bearer: '.$token // if you need token in header
      )
      );

      //  curl_setopt($ch, CURLOPT_HEADER, false);
      // curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

      $result = curl_exec($ch);
      curl_close($ch);

      //   return $result;

      $output = json_decode($result);

      if($output->statuscode=="009"){
        $data['status']="200";
        $data['message']=$output->message;
      }else{
        $data['status']="gagal";
        $data['message']=$output->message;
      }

      echo json_encode($data);
    }

     function log_login()
    {

        $email = $this->input->post('email');
        $nama = $this->input->post('nama');
        $nama_sekolah = $this->input->post('nama_sekolah');
        $leveledu = $this->input->post('leveledu');
        $no_tlp = $this->input->post('no_tlp');
        $no_wa = $this->input->post('no_wa');


       $a = $this->cek_mail($email,$nama,$no_tlp,$no_wa);

        


        $data_log_login = array(
            'email' => $email,
            'last_login' => date('Y-m-d H:i:s'),
            'device_id' => '',
            'nama' => $nama,
            'sekolah' => $nama_sekolah,
            'leveledu' => $leveledu,
            'log' => 2,
        );
        $q =    $this->db->insert('log_login', $data_log_login);

        // if ($q) {
        //     $data['sukses'] = 200;
        //     $data['message'] = 'Sukses';
        // } else {
        //     $data['sukses'] = 400;
        //     $data['message'] = 'gagal';
        // }

       // echo json_encode($data);
    }



    function webinar($paging=null)
    {

        error_reporting(0);
        $limit = 10;
            $total = $this->db->query("select * from webinar where publish = 1  order by id_webinar desc ")->result();


        if($paging){
          //  echo "1";
            $offset = $paging;
            $halaman = $paging;
        }else{
          // echo "2";
            $offset = 0;
            $halaman = count($total);
        }


        
        if($total){
             $w = $this->db->query("select * from webinar where publish = 1 order by id_webinar desc LIMIT ".$limit."  OFFSET ".$offset."")->result();



        }

       
    

         


        if ($w) {

            foreach ($w as $k) {

                  $hari_ini = date('Y-m-d');

                    $wak = explode("-",$k->waktu);
                     $wak_selesai = $wak[1];
                     $jam = date('H:i');



        if($k->tanggal==$hari_ini){
          //   $template_mail = 'webinar-zoom';
              if(strtotime($wak_selesai)>=strtotime($jam)){
                $pulish_zoom = 1;
            }elseif(strtotime($wak_selesai)<=strtotime($jam)){
                $pulish_zoom = 2;
            }

        }else if($k->tanggal<$hari_ini){
          //   $template_mail = 'webinar-zoom';
             $pulish_zoom = 2;

        }



        else{
           
             //$template_mail = 'webinar-wa';
              $pulish_zoom = 0;

        }

                $gambar = base_url("assets/file_upload/webinar/" . $k->img_mobile);
                $data[] = array(
                    'id_webinar' => base64_encode($k->id_webinar),
                    'topik' => $k->topik,
                    'waktu' => $k->waktu,
                    'tanggal' => TanggalIndo($k->tanggal),
                    'foto' => $gambar,
                    'pembicara' => $k->pembicara,
                    'jabatan_pembicara' => $k->jabatan_pembicara,
                    'moderator' => $k->moderator,
                    'jabatan_moderator' => $k->jabatan_moderator,
                  'desc'=>$k->desc,
                      'share_link'=>$k->share_link,
                      'link'=>$k->link,
                      'publish_zoom'=>$pulish_zoom,
                );
            }

            $data_data = array(
                'totaldata'=>count($total),
                'halaman'=>count($total)/$halaman,
                'totalhalaman'=>count($total)/$limit,
                'status' => 200,
                'message' => 'sukses',
                'data' => $data,
            );

            echo json_encode($data_data);
        } else {

            $data[] = array(

                'id_webinar' => 1,
                'topik' => "tes",
                'waktu' => "tes",
                'tanggal' => "tes",
                'foto' => "tes",
                'pembicara' => "tes",
                'jabatan_pembicara' => "tes",
                'moderator' => "tes",
                'jabatan_moderator' => "tes",
                'desc'=>'tes',
            );

            $data_data = array(
                'status' => 400,
                'message' => 'gagal',
                'data' => $data,
            );

            echo json_encode($data_data);
        }
    }



    function get_pendaftar()
    {
        $email = $this->input->post('email');
        $id_event2 = $this->input->post('id_webinar');

        $id_event = base64_decode($id_event2);

        $cek = $this->db->query('select * from pendaftar where  email="' . $email . '" and id_event =' . $id_event)->row();

        if ($cek) {

            $data['status'] = 200;
            $data['message'] = "sukses";
            $data['datanya'] = $cek;
        } else {

            $data['status'] = 404;
            $data['message'] = "data tidak ditemukan";
            $data['datanya'] = array(

                "id_pendaftar"=> "",
                "id_event"=> "",
                "nama"=> "",
                "email"=> "",
                "wilayah"=> "",
                "no_tlp"=> "",
                "no_wa"=> "",
                "jenis_kelamin"=> "",
                "usia"=> "",
                "provinsi"=> "",
                "asal_sekolah"=> "",
                "tingkatan"=> "",
                "kampus_impian"=> "",
                "jurusan_diinginkan"=> "",
                "sumber_informasi"=> "1",
                "create_add"=> "2022-04-21 15:33:39",
                "kategori"=> "",
                "kampus_favorit"=> "",
                "rating"=> "",

            );
        }

        echo json_encode($data);
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
        // echo "<pre>";
        // print_r($query);
        // die;

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







   
    

   

    
    
}
