<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Banner_M extends CI_Model
{


    //set nama tabel yang akan kita tampilkan datanya
    var $table = 'banner';
    //set kolom order, kolom pertama saya null untuk kolom edit dan hapus
    var $column_order = array(null, 'kategori');

    var $column_search = array('kategori');
    // default order 
    var $order = array('id_banner' => 'asc');


    public $id_banner;
    public $kategori;
    




    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query()
    {
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



    // private $_table = "jenis";

  

    public function getAll()
    {
        return $this->db->get($this->table)->result();
    }
    
    public function getById($id)
    {
        return $this->db->get_where($this->table, ["id_banner" => $id])->row();
    }

    public function save($divisi)
    {
        // $post = $this->input->post();
        // $this->id_banner = uniqid();
        // $this->kategori = $divisi;
        $data = array(
            'kategori'=>$divisi,
        );
        return $this->db->insert('banner', $data);
    }

    public function update($id_banner,$kategori)
    {
        // $post = $this->input->post();
        // $this->id_banner = $id_banner;
        // $this->kategori = $kategori;

        $data = array(
            'kategori'=>$kategori,
        );

       
        return $this->db->update('banner', $data, array('id_banner' => $id_banner));
    }

    public function delete($id)
    {
        return $this->db->delete($this->table, array("id_banner" => $id));
    }
}