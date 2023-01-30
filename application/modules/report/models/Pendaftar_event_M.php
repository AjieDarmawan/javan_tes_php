<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Pendaftar_event_M extends CI_Model
{


    //set nama tabel yang akan kita tampilkan datanya
    var $table = 'pendaftar';
    //set kolom order, kolom pertama saya null untuk kolom edit dan hapus
    var $column_order = array(null, 'email','nama','wilayah','no_wa','kampus_impian','jurusan_diinginkan','asal_sekolah','provinsi','sumber_informasi','tingkatan');

    var $column_search = array( 'email','nama','wilayah','no_wa','kampus_impian','jurusan_diinginkan','asal_sekolah','provinsi','sumber_informasi','tingkatan');
    // default order 
    var $order = array('create_add' => 'asc');


    public $id_login;
    public $email;
    



    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query($tanggal_awal,$tanggal_akhir)
    {  


        //$this->db->select('pendaftar.*,webinar.topik');

         $this->db->select('pendaftar.*,pendaftar.id_event as topik');
		//$this->db->join('webinar', 'pendaftar.id_event = webinar.id_webinar', 'inner');
        $this->db->where('pendaftar.kategori','tryout');

        $this->db->where('date(pendaftar.create_add) >=', $tanggal_awal);
        $this->db->where('date(pendaftar.create_add) <=', $tanggal_akhir);




       
       // $this->db->group_by('event.email');
        $this->db->from($this->table);
        $this->db->order_by('create_add','desc');
        $i = 0;
        foreach ($this->column_search as $item) // loop kolom 
        {
            if ($this->input->post('search')['value']) // jika datatable mengirim POST untuk search
            {
                if ($i === 0) // looping pertama
                {
                    $this->db->group_start();
                    $this->db->like($item, $this->input->post('search')['value']);
                } else {
                    $this->db->or_like($item, $this->input->post('search')['value']);
                }
                if (count($this->column_search) - 1 == $i) //looping terakhir
                    $this->db->group_end();
            }
            $i++;
        }

        // jika datatable mengirim POST untuk order
        if ($this->input->post('order')) {
            $this->db->order_by($this->column_order[$this->input->post('order')['0']['column']], $this->input->post('order')['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables($tanggal_awal,$tanggal_akhir)
    {
        $this->_get_datatables_query($tanggal_awal,$tanggal_akhir);
        if ($this->input->post('length') != -1)
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered($tanggal_awal,$tanggal_akhir)
    {
        $this->_get_datatables_query($tanggal_awal,$tanggal_akhir);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }



    // private $_table = "event";

  

    public function getAll($tanggal_awal,$tanggal_akhir)
    {

  //       $this->db->select('pendaftar.*,webinar.topik');
		// $this->db->join('webinar', 'pendaftar.id_event = webinar.id_webinar', 'inner');
  //       $this->db->where('pendaftar.kategori','tryout');

  //       $this->db->where('date(pendaftar.create_add) >=', $tanggal_awal);
  //       $this->db->where('date(pendaftar.create_add) <=', $tanggal_akhir);



        $this->db->select('pendaftar.*,pendaftar.id_event as topik');
        //$this->db->join('webinar', 'pendaftar.id_event = webinar.id_webinar', 'inner');
        $this->db->where('pendaftar.kategori','tryout');

        $this->db->where('date(pendaftar.create_add) >=', $tanggal_awal);
        $this->db->where('date(pendaftar.create_add) <=', $tanggal_akhir);
        return $this->db->get($this->table)->result();
    }
    
    public function getById($id)
    {
        return $this->db->get_where($this->table, ["id_login" => $id])->row();
    }

    public function save($divisi)
    {
        // $post = $this->input->post();
        // $this->id_login = uniqid();
        // $this->email = $divisi;
        $data = array(
            'email'=>$divisi,
        );
        return $this->db->insert('event', $data);
    }

    public function update($id_login,$email)
    {
        // $post = $this->input->post();
        // $this->id_login = $id_login;
        // $this->email = $email;

        $data = array(
            'email'=>$email,
        );

       
        return $this->db->update('event', $data, array('id_login' => $id_login));
    }

    public function delete($id)
    {
        return $this->db->delete($this->table, array("id_login" => $id));
    }
}