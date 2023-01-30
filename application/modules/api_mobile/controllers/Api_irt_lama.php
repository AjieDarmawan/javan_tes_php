<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Api_irt extends CI_Controller
{


    function __construct()
    {
        parent::__construct();
        $sess = $this->session->userdata();

       ini_set('memory_limit', '-1');
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



    function hitung_irt_testing($materi_id)
    {

        //$materi_id = 217;

        $soal = $this->db->query('select * from soalonline where materi_id = ' . $materi_id)->result();
      //  $jawaban = $this->db->query('select * from jawaban where mode="1" and materi_id = ' . $materi_id)->result();

           $jawaban = $this->db->query('select * from jawaban where mode="1" and materi_id = "'.$materi_id.'" ')->result();




        foreach ($jawaban as $j) {


            //error_reporting(0);

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







                        //  echo "salah";
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
                'salah' => $j->salah,
                'kosong' => $j->kosong,
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

        echo json_encode($data);

        //return $data;

    }




    function hitung_irt($materi_id)
    {

        //$materi_id = 217;

        $soal = $this->db->query('select * from soalonline where materi_id = ' . $materi_id)->result();
        $jawaban = $this->db->query('select * from jawaban where mode="1" and materi_id = ' . $materi_id)->result();



        foreach ($jawaban as $j) {


            //error_reporting(0);

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
                        //ga di isi 
                        $data_array_jawaban[$key->id] = array(
                            'soal_id' => $key->id,
                            'hasil_pilihan' => 0,
                        );
                        //  echo "ga disi";
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




    public function irt($materi_id)
    {


        // Function to calculate square of value - mean
        // function sd_square($x, $mean) { return pow($x - $mean,2); }
        // // Function to calculate standard deviation (uses sd_square)    
        // function sd($array) {

        //     // echo "<pre>";
        //     // print_r($array);
        //     // die;
        //     // square root of sum of squares devided by N-1
        //     return sqrt(array_sum(array_map("sd_square", $array, array_fill(0,count($array), (array_sum($array) / count($array)) ) ) ) / (count($array)-1) );
        // }

        // echo "tes";
        // die;

        //  $materi_id = 217;

        $materi = $this->db->query('select * from materi where materi_id=' . $materi_id)->row();


        $irt_hasil =  $this->hitung_irt($materi_id);



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



        foreach ($irt->data_array_rata_rata as $d) {


            $data_array_bobot[$d->soal_id] = array(
                'soal_id' => $d->soal_id,
                'bobot' => (1 - ($d->jumlah / $irt->jumlah_peserta)) * 100,
            );
        }



        $rata_rata = 0;
        foreach ($irt->data_ as $d) {



            foreach ($d->data_array_jawaban as $j) {

                $j->hasil_pilihan;
            }

            $d->benar;



            $hitung_skor_kali = 0;
            foreach ($d->data_array_jawaban as $j) {

                if ($data_array_bobot[$j->soal_id]['soal_id'] == $j->soal_id) {

                    if ($j->hasil_pilihan == 1) {


                        $hitung_skor_kali += $data_array_bobot[$j->soal_id]['bobot'] * 1;
                    }
                }
            }

            $rata_rata += $hitung_skor_kali;
            $hitung_skor_kali;
            $arr[] = $hitung_skor_kali;
        }


        foreach ($irt->data_array_rata_rata as $d) {


            $d->jumlah;
        }


        foreach ($irt->data_array_rata_rata as $d) {


            1 - ($d->jumlah / $irt->jumlah_peserta);
        }



        foreach ($irt->data_array_rata_rata as $d) {

            (1 - ($d->jumlah / $irt->jumlah_peserta)) * 100;
        }


        $rata_rata / $irt->jumlah_peserta;
        sd($arr);

        foreach ($arr as $key => $a) {
            $z_score = ($a - ($rata_rata / $irt->jumlah_peserta)) / sd($arr);


            $z_score;
            500 + (100 * $z_score);;
            $z_score_hasil[$irt->data_->{$key}->email] =  500 + (100 * $z_score);
        }



        $datajson = array(
            'materi_id' => $materi_id,
            'materi_nama' => $materi_nama,
            'data' => $z_score_hasil,
        );
        // echo json_encode($data_json);


        return $datajson;
        // echo "<pre>";
        // print_r($z_score_hasil);





    }


    function irt_event()
    {

        //$id_event = 29;

         $id_event = 46;

        $event = $this->db->query('select * from materi where id_event=' . $id_event)->result();

        //   echo "<pre>";
        //   print_r($event);  
        // die;

        foreach ($event as $e) {
            $data_json[] = $this->irt($e->materi_id);
        }


        // echo "<pre>";
        // print_r($data_json[0]['data']['arisaldi@edunovasi.com']);

        $users = $data_json[0]['data'];



        foreach ($users as $key => $u) {
            // echo "<pre>";
            // print_r($key);

            $skor = 0;
            foreach ($data_json as $key2 => $j) {

                // echo "<pre>";
                // print_r($j['data'][$key]);

                $data_akhir[$key] =  $skor += $j['data'][$key];
            }
        }


        //skor per email


        echo "<pre>";
        print_r($data_akhir['ahmadreki31@gmail.com']);

        //echo json_encode($data_akhir);   




         //skor per materi
        // echo json_encode($data_json);
    }
}
