<?php

defined('BASEPATH') or exit('No direct script access allowed');

Header('Access-Control-Allow-Origin: *'); //for allow any domain, insecure
Header('Access-Control-Allow-Headers: *'); //for allow any headers, insecure
Header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');

class Api_report extends CI_Controller
{
  function event()
  {

    error_reporting(0);

    $tgl_mulai = $this->input->get('tgl_mulai');
    $tgl_selesai = $this->input->get('tgl_selesai');

    $page = $this->input->get('page');
    $formdata_search = $this->input->get('formdata_search');
    $formdata_wilayah = $this->input->get('formdata_wilayah');
    $formdata_event = $this->input->get('formdata_event');

    // biar balikannya gak null
    $data2 = array();
    // biar balikannya gak null


    if ($formdata_event != 'semua-event') {
      $where_event = "and e.kedinasan = '" . $formdata_event . "'";
    } else {
      $where_event = "";
    }







    if ($formdata_search) {

      $where_search =  "and (p.nama like '%" . $formdata_search . "%' or e.judul like  '%" . $formdata_search . "%')";
    } else {
      $where_search = "";
    }


    if ($formdata_wilayah) {


      $where_wilayah = "and p.wilayah like '%" . $formdata_wilayah . "'";
    } else {
      $where_wilayah = "";
    }

    if ($tgl_mulai) {
      $where_tgl = "date(p.create_add)  BETWEEN '" . $tgl_mulai . "' AND '" . $tgl_selesai . "' and";
    } else {
      $where_tgl = "";
    }







    $limit = 10;
    $sql_limit = '';

    if (isset($_GET['excel']) && $_GET['excel'] == '1') {
      $limit = 1;
    } else {


      $page_jalan = 1;
      $offset_jalan = 0;

      if ($page) {
        $page_jalan = $page;

        $offset_jalan = ($page_jalan * $limit) - $limit;

        $sql_limit = " limit " . $limit . "  offset " . $offset_jalan;
      }
    }





    // echo "select e.judul,p.* from peserta as p
    //      inner join event as e on e.id_event = p.id_event 
    //      where 
    // " . $where_tgl . "
    //       p.email not in ('dymasgemilang@gmail.com','ajie.darmawan106@gmail.com','rahmandaroki@gmail.com','apreak@gmail.com','daniyal.hafidz@gmail.com','danil.mrprince@gmail.com','traffandy@gmail.com','arisaldi@edunovasi.com') 
    //        " . $where_event . "
    //         " . $where_search . "
    //        " . $where_wilayah . "

    //        group by p.email order by p.id_peserta desc limit " . $limit . "  offset " . $offset_jalan . " ";



    $data_event = $this->db->query(
      "select e.judul,p.* from peserta as p
      inner join event as e on e.id_event = p.id_event 
      where 
        " . $where_tgl . "
         p.email not in ('dymasgemilang@gmail.com','ajie.darmawan106@gmail.com','rahmandaroki@gmail.com','apreak@gmail.com','daniyal.hafidz@gmail.com','danil.mrprince@gmail.com','traffandy@gmail.com','arisaldi@edunovasi.com') 
        " . $where_event . "
         " . $where_search . "
         " . $where_wilayah . "
        
        group by p.email order by p.id_peserta desc
        " . $sql_limit . " "
    )->result();

    $tot_data2 = $this->db->query("select e.judul,p.* from peserta as p
        inner join event as e on e.id_event = p.id_event 
        where 

          " . $where_tgl . "

          p.email not in ('dymasgemilang@gmail.com','ajie.darmawan106@gmail.com','rahmandaroki@gmail.com','apreak@gmail.com','daniyal.hafidz@gmail.com','danil.mrprince@gmail.com','traffandy@gmail.com','arisaldi@edunovasi.com') 
    " . $where_event . "
     " . $where_search . "
     " . $where_wilayah . "
        group by p.email order by p.id_peserta desc  ")->result();



    $no_event = 1;
    $numrow_event = 8;
    foreach ($data_event as $l) { // Lakukan looping pada variabel siswa

      $event = $this->db->query('select * from event where id_event="' . $l->id_event . '"')->row();

      $kategori = $this->db->query('select * from kategori where id_kategori="' . $event->id_kategori . '"')->row();

      $pendaftar = $this->db->query('select * from pendaftar where email="' . $l->email . '" and kategori="tryout"')->row();

      $peserta = $this->db->query('select * from peserta where email="' . $l->email . '" ')->row();

      if ($pendaftar->usia) {
        $usia2 = $pendaftar->usia;
      } else {
        $usia2 = 'kosong';
      }

      if ($pendaftar->tingkatan) {
        $kelas2 = $pendaftar->tingkatan;
      } else {
        $kelas2 = 'kosong';
      }

      if ($pendaftar->jenis_kelamin) {
        $jenis_kelamin2 = $pendaftar->jenis_kelamin;
      } else {
        $jenis_kelamin2 = 'kosong';
      }


      if ($pendaftar->sumber_informasi) {
        $sumber_informasi2 = $pendaftar->sumber_informasi;
      } else {
        $sumber_informasi2 = 'kosong';
      }

      if ($pendaftar->provinsi) {
        $provinsi2 = $pendaftar->provinsi;
      } else {
        $provinsi2 = 'kosong';
      }





      if ($peserta->no_wa) {
        $no_wa2 = $peserta->no_wa;
      } else {
        $no_wa2 = 'kosong';
      }

      if ($peserta->jurusan_diinginkan) {
        $jurusan_diinginkan2 = $peserta->jurusan_diinginkan;
      } else {
        $jurusan_diinginkan2 = 'kosong';
      }

      $data2[] = array(
        'no_event' => $no_event++,
        'kategori_nama' => $kategori->kategori_nama,
        'judul' => $event->judul,
        'nama' => $l->nama,
        'email' => $l->email,
        'wilayah' => $l->wilayah,
        'kampus_impian' => $l->kampus_impian,
        'asal_sekolah' => $l->asal_sekolah,
        'create_add' => TanggalIndo($l->create_add) . ' ' . date('H:i:s', strtotime($l->create_add)),
        'usia' => $usia2,
        'kelas' => $kelas2,

        'no_wa' => $no_wa2,

        'jenis_kelamin' => $jenis_kelamin2,

        'sumber_informasi' => $sumber_informasi2,
        'wilayah' => $peserta->wilayah,
        'provinsi' => $peserta->provinsi,
        'kampus_favorit' => $peserta->kampus_favorit,
      );
    }







    $tot_halaman = ceil(count($tot_data2) / $limit);


    if ($page != 1) {
      $dari = ($page - 1) * $limit + 1;

      $hingga = $dari + count($data_event) - 1;
    } else {
      $dari = 1;
      $hingga = $dari + count($data_event) - 1;
    }


    $data_a = array(
      "kode" => "001",
      "message" => "sukses",
      'listdata' => array(
        "dari" => $dari,
        "hingga" => $hingga,
        "totaldata" => count($tot_data2),
        "totalhalaman" => $tot_halaman,
        'datanya' => $data2,
      ),




    );

    echo json_encode($data_a);
  }

  function registrasi()
  {
  }
}
