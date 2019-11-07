<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mpromodiskon extends CI_Controller {
    
    public $table       = 'mpromodiskon';
    public $foldername  = 'mpromodiskon';
    public $indexpage   = 'mpromodiskon/v_mpromodiskon';

    function __construct() {
        parent::__construct();
        include(APPPATH.'libraries/sessionakses.php');
        include(APPPATH.'libraries/dbinclude.php');  
    }
    function index()
    {
        $data['customer']   = $this->dbtwo->query("SELECT * FROM mcustomer WHERE ref_jenc != '2019000001' AND ref_jenc != '2019000002'")->result();
        $data['barang']     = $this->dbtwo->get_where('mbarang',array('is_design' => 't'))->result();
        $this->load->view($this->indexpage,$data);  
    }

    public function getall()
    {
        $q = "SELECT 
                mpromodiskon.* ,
                mcustomer.nama customer_nama,
                mbarang.nama barang_nama
            FROM mpromodiskon 
            LEFT JOIN mcustomer ON mcustomer.kode = mpromodiskon.ref_cust
            LEFT JOIN mbarang ON mbarang.kode = mpromodiskon.ref_brg
        ";
        $result = $this->dbtwo->query($q)->result();
        echo json_encode(array('data' => $result));
    }

    public function savedata()
    {
        $d['kode']      = $this->input->post('kode');
        $d['ref_cust']  = $this->input->post('ref_cust');
        $d['ref_brg']   = $this->input->post('ref_brg');
        $d['nominal']   = $this->input->post('nominal');
        $d['minorder']  = $this->input->post('minorder');
        $d['ket']       = $this->input->post('ket');
        $result = $this->dbtwo->insert($this->table,$d);
        $r['sukses'] = $result ? 'success' : 'fail' ;
        echo json_encode($r);
    }

    public function edit()
    {
        $w['id']= $this->input->post('id');
        $data   = $this->dbtwo->get_where($this->table,$w)->row();
        echo json_encode($data);
    }

    function updatedata()
    {
        $d['kode']      = $this->input->post('kode');
        $d['ref_cust']  = $this->input->post('ref_cust');
        $d['ref_brg']   = $this->input->post('ref_brg');
        $d['nominal']   = $this->input->post('nominal');
        $d['minorder']  = $this->input->post('minorder');
        $d['ket']       = $this->input->post('ket');
        $w['id'] = $this->input->post('id');

        $result = $this->dbtwo->update($this->table,$d,$w);
        $r['sukses']    = $result ? 'success' : 'fail' ;
        echo json_encode($r);
    }

    public function deletedata()
    {
        $w['id'] = $this->input->post('id');
        $result = $this->dbtwo->delete($this->table,$w);
        $r['sukses'] = $result ? 'success' : 'fail' ;
        echo json_encode($r);
    }
}