<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Sekolah_M extends CI_Model
{


    //set nama tabel yang akan kita tampilkan datanya
    var $table = 'm_sekolah';
    //set kolom order, kolom pertama saya null untuk kolom edit dan hapus
    var $column_order = array(null, 'nama_sekolah');

    var $column_search = array('nama_sekolah');
    // default order 
    var $order = array('id_m_sekolah' => 'desc');


    public $id_m_sekolah;
    public $nama_sekolah;
    



    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query()
    {
  //       $this->db->select('sekolah.*,kategori.kategori_nama');
		// $this->db->join('kategori', 'kategori.id_kategori = sekolah.id_kategori', 'inner');
         $this->db->from($this->table);
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

    function get_datatables()
    {
        $this->_get_datatables_query();
        if ($this->input->post('length') != -1)
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }



    // private $_table = "sekolah";

  

    public function getAll()
    {
        return $this->db->get($this->table)->result();
    }
    
    public function getById($id)
    {
        return $this->db->get_where($this->table, ["id_m_sekolah" => $id])->row();
    }

    public function save($divisi,$id_kategori)
    {
        // $post = $this->input->post();
        // $this->id_m_sekolah = uniqid();
        // $this->sekolah_nama = $divisi;
        $data = array(
            'sekolah_nama'=>$divisi,
            'id_kategori'=>$id_kategori,
        );
        return $this->db->insert('sekolah', $data);
    }

    public function update($id_m_sekolah,$sekolah_nama,$id_kategori)
    {
        // $post = $this->input->post();
        // $this->id_m_sekolah = $id_m_sekolah;
        // $this->sekolah_nama = $sekolah_nama;

        $data = array(
            'sekolah_nama'=>$sekolah_nama,
            'id_kategori'=>$id_kategori,
        );

       
        return $this->db->update('sekolah', $data, array('id_m_sekolah' => $id_m_sekolah));
    }

    public function delete($id)
    {
        return $this->db->delete($this->table, array("id_m_sekolah" => $id));
    }

    function getByKategori($id){
        return $this->db->get_where($this->table, ["id_kategori" => $id])->result();
    }
}