<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Paket_M extends CI_Model
{


    //set nama tabel yang akan kita tampilkan datanya
    var $table = 'paket_sekolah';
    var $table_event_sekolah = 'event_sekolah';
    //set kolom order, kolom pertama saya null untuk kolom edit dan hapus
    var $column_order = array(null, 'nama_paket');

    var $column_search = array('nama_paket');
    // default order 
    var $order = array('id_paket' => 'asc');


    public $id_paket;
    public $nama_paket;
    




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
        return $this->db->get_where($this->table, ["id_paket" => $id])->row();
    }

    public function save($divisi)
    {
        // $post = $this->input->post();
        // $this->id_paket = uniqid();
        // $this->nama_paket = $divisi;
        $data = array(
            'nama_paket'=>$divisi,
        );
        return $this->db->insert('paket', $data);
    }

    public function update($id_paket,$nama_paket)
    {
        // $post = $this->input->post();
        // $this->id_paket = $id_paket;
        // $this->nama_paket = $nama_paket;

        $data = array(
            'nama_paket'=>$nama_paket,
        );

       
        return $this->db->update('paket', $data, array('id_paket' => $id_paket));
    }

    public function delete($id)
    {
        return $this->db->delete($this->table, array("id_paket" => $id));
    }




    private function _get_datatables_query_get_id($id_paket)
    {
        

        

        $this->db->select('event_sekolah.*,paket_sekolah.nama_paket,event.judul,m_sekolah.nama_sekolah');
        $this->db->join('event_sekolah', 'event_sekolah.id_paket = paket_sekolah.id_paket', 'inner');
        $this->db->join('event', 'event.id_event = event_sekolah.id_event', 'inner');
        $this->db->join('m_sekolah', 'm_sekolah.id_m_sekolah = event_sekolah.id_sekolah', 'inner');


        $this->db->from($this->table);
        $this->db->where('event_sekolah.id_paket',$id_paket);
         $this->db->order_by('event_sekolah.no_urut_paket','asc');


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

    function get_datatables_get_id($id_paket)
    {
        $this->_get_datatables_query_get_id($id_paket);
        if ($this->input->post('length') != -1)
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_get_id($id_paket)
    {
        $this->_get_datatables_query_get_id($id_paket);
        $query = $this->db->get();
        return $query->num_rows();
    }

    // SEKOLAH

    private function _get_datatables_query_get_id_sekolah($id_sekolah)
{
    

    

    $this->db->select('event_sekolah.*,paket_sekolah.nama_paket,event.judul,m_sekolah.nama_sekolah');
    $this->db->join('event_sekolah', 'event_sekolah.id_paket = paket_sekolah.id_paket', 'inner');
    $this->db->join('event', 'event.id_event = event_sekolah.id_event', 'inner');
    $this->db->join('m_sekolah', 'm_sekolah.id_m_sekolah = event_sekolah.id_sekolah', 'inner');


    $this->db->from($this->table);
    //$this->db->where('event_sekolah.id_paket',$id_paket);
    $this->db->where('event_sekolah.id_sekolah',$id_sekolah);

    
     $this->db->order_by('event_sekolah.no_urut_paket','asc');


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

function get_datatables_get_id_sekolah($id_sekolah)
{
    $this->_get_datatables_query_get_id_sekolah($id_sekolah);
    if ($this->input->post('length') != -1)
        $this->db->limit($this->input->post('length'), $this->input->post('start'));
    $query = $this->db->get();
    return $query->result();
}

function count_filtered_get_id_sekolah($id_sekolah)
{
    $this->_get_datatables_query_get_id_sekolah($id_sekolah);
    $query = $this->db->get();
    return $query->num_rows();
}




// EVENT PAKET

private function _get_datatables_query_get_id_event($id_paket)
    {
        

        

        $this->db->select('event.id_paket,event.judul,no_urut_paket,
        paket_sekolah.nama_paket,paket_sekolah.tgl_mulai,paket_sekolah.tgl_selesai');

      // $this->db->select('event.*');
        
      $this->db->join('event', 'event.id_paket = paket_sekolah.id_paket', 'inner');
      $this->db->from($this->table);
        $this->db->where('event.id_paket',$id_paket);
        $this->db->order_by('event.no_urut_paket','asc');


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

    function get_datatables_get_id_event($id_paket)
    {
        $this->_get_datatables_query_get_id_event($id_paket);
        if ($this->input->post('length') != -1)
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_get_id_event($id_paket)
    {

        error_reporting(0);
        $this->get_datatables_get_id_event($id_paket);
        // $query = $this->db->get();
        // return $query->num_rows();
    }
}