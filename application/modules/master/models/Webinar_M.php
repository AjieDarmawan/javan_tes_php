<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Webinar_M extends CI_Model
{


     //set nama tabel yang akan kita tampilkan datanya
     var $table = 'webinar';
     //set kolom order, kolom pertama saya null untuk kolom edit dan hapus
     var $column_order = array(null, 'id_webinar');
 
     var $column_search = array('event_judul');
     // default order 
     var $order = array('id_webinar' => 'desc');



    private $_table = "webinar";

    public $id_webinar;
    public $jbt_nama;
    public $div_id_webinar;





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

        $this->_get_datatables_query();
        //$this->db->from($this->table);
        return $this->db->count_all_results();
    }



  

    public function rules()
    {
        return [
            ['field' => 'name',
            'label' => 'Name',
            'rules' => 'required'],

            ['field' => 'div_id',
            'label' => 'div_id',
            'rules' => 'numeric'],
            
            ['field' => 'description',
            'label' => 'Description',
            'rules' => 'required']
        ];
    }

    public function getAll()
    {
        return $this->db->get($this->_table)->result();
    }
    
    public function getById($id)
    {
        return $this->db->get_where($this->_table, ["id_webinar" => $id])->row();
    }

    public function save($jabatan,$div_id)
    {
        // $post = $this->input->post();
        // $this->id = uniqid();
        // $this->jbt_nama = $post["jbt_nama"];
        // $this->div_id = $post["div_id"];
       
        // return $this->db->insert($this->_table, $this);

        $data = array(
            'jabatan_nama'=>$jabatan,
            'div_id'=>$div_id,
        );

        // print_r($data);
        // die;
        return $this->db->insert('webinar', $data);
    }

    public function update($id,$jabatan_nama,$div_id)
    {
        // $post = $this->input->post();
        // $this->id = $post["id"];
        // $this->jbt_nama = $post["jbt_nama"];
        // $this->div_id = $post["div_id"];
       
        // return $this->db->update($this->_table, $this, array('id' => $post['id']));

        $data = array(
         //   'div_id'=>$div_id,
            'jabatan_nama'=>$jabatan_nama,
            'div_id'=>$div_id,
        );

       
        return $this->db->update('webinar', $data, array('id' => $id));
    }

    public function delete($id)
    {
        return $this->db->delete($this->_table, array("id" => $id));
    }
}