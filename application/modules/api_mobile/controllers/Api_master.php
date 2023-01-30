
<?php

defined('BASEPATH') or exit('No direct script access allowed');

Header('Access-Control-Allow-Origin: *'); //for allow any domain, insecure
Header('Access-Control-Allow-Headers: *'); //for allow any headers, insecure
Header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');

class Api_master extends CI_Controller
{


function list_wilayah(){

$url = "https://api.edunitas.com/mod/edun-load-g";

$postData = array(

  "format"=> "json",
  "formdata_groupjkt"=> 1,
  "formdata_listmod"=> "Provinsi",
  "formdata_origin"=> "pt",
  "formdata_type"=> "1",
  "setdata_mod"=> "list-wilayah",


);



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



$output = json_decode($result);

echo json_encode($output);

}






function list_campus(){

    $url = "https://api.edunitas.com/mod/edun-kampus-g";
    
    $postData = array(
    
        "format"=> "json",
        "formdata_filterkelas"=> "Program-Perkuliahan-Reguler",
        "formdata_filterprodi"=> "semua-prodi",
        "formdata_filterwilayah"=> "semua-wilayah",
        "formdata_getlist"=> "listcampus",
        "formdata_length"=> "300",
        "formdata_origin"=> "list",
        "formdata_page"=> "1",
        "setdata_mod"=> "get-data",
    
    
    );
    
    
    
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
    
    
    
    $output = json_decode($result);
        
    // echo "<pre>";
    // print_r();
    // die;

    foreach($output->data->listcampus->listdata as $h){
        $data_hasil[] = array(

             'label_nama' => $h->label_nama,
            'label_singkatan' => $h->label_singkatan,
        );
    }


    echo json_encode($data_hasil);
    
    }

    function kampus_impian_kedinasan(){

        $data = array(
            array(
                'name'=>"Sekolah Tinggi Intelijen Negara (STIN)",
                'label'=>'Sekolah Tinggi Intelijen Negara (STIN)',

            ),

             array(
                'name'=>"Sekolah Tinggi Meteorologi, Klimatologi, dan Geofisika (STMKG)",
                'label'=>'Sekolah Tinggi Meteorologi, Klimatologi, dan Geofisika (STMKG)',

            ),

             array(
                'name'=>"Sekolah Tinggi Ilmu Statistika (STIS)",
                'label'=>'Sekolah Tinggi Ilmu Statistika (STIS)',

            ),

             array(
                'name'=>"Politeknik Siber dan Sandi Negara (Poltek SSN)",
                'label'=>'Politeknik Siber dan Sandi Negara (Poltek SSN)',

            ),

             array(
                'name'=>"Institut Pemerintahan Dalam Negeri (IPDN)",
                'label'=>'Institut Pemerintahan Dalam Negeri (IPDN)',

            ),

             array(
                'name'=>"Politeknik Imigrasi (Poltekim)",
                'label'=>'Politeknik Imigrasi (Poltekim)',

            ),

             array(
                'name'=>"Politeknik Ilmu Permasyarakatan (Poltekip)",
                'label'=>'Politeknik Ilmu Permasyarakatan (Poltekip)',

            ),

             array(
                'name'=>"Politeknik Keuangan Negara STAN (PKN-STAN)",
                'label'=>'Politeknik Keuangan Negara STAN (PKN-STAN)',

            ),

             array(
                'name'=>"Sekolah Kedinasan Kementrian Perhubungan",
                'label'=>'Sekolah Kedinasan Kementrian Perhubungan',

            ),

             array(
                'name'=>"Lain - Lain",
                'label'=>'Lain - Lain',

            ),
        );

        echo json_encode($data);
    }

    function token(){
      error_reporting(0);
      $token = $this->input->post('fcm_token');

      $cek = $this->db->query('select * from token where token="'.$token.'"')->row();

      if($cek){

      }else{

          $data_insert = array(
         'token'=>$token,
         'datetime'=>date("Y-m-d H:i:s"),
      );

           $q = $this->db->insert('token',$data_insert);

      }


     

     

      if($q){
         $dat = array(
            'kode'=>200,
            'message'=>'sukses',
         );

         echo json_encode($dat);
      }else{
            $dat = array(
            'kode'=>200,
            'message'=>'sukses',
         );

         echo json_encode($dat);
      }
    }


    function infotambahan(){


        $post = $this->input->post();
       $post2 = json_decode($post['data']);

       // echo "<pre>";
       // print_r($post2);

       // die;

        error_reporting(0);

        $sumber_informasi = $post2->sumber_informasi;
        $email = $post2->email;

        $kelas = $post2->kelas;
        $sekolah = $post2->sekolah;

       
        // $sumber_informasi = $this->input->post('sumber_informasi');
        // $email = $this->input->post('email');

        $data_insert = array(
         'sumberinformasi'=>$sumber_informasi,
         'email'=>$email,
         'kelas'=>$kelas,
         'sekolah'=>$sekolah,

      );

         $q = $this->db->insert('info_tambahan',$data_insert);

         if($q){
         $dat = array(
            'kode'=>200,
            'message'=>'sukses',
         );

         echo json_encode($dat);
      }else{
            $dat = array(
            'kode'=>400,
            'message'=>'gagal',
         );

         echo json_encode($dat);
      }




    }




}

?>