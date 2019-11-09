<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Masterbank extends CI_Controller {
    
    public $table       = 'mbank';
    public $foldername  = 'mbank';
    public $indexpage   = 'mbank/v_mbank';

    function __construct() {
        parent::__construct();
        include(APPPATH.'libraries/sessionakses.php');
        include(APPPATH.'libraries/dbinclude.php');  
    }
    function index()
    {
        $this->load->view($this->indexpage,$data);  
    }

    public function getall()
    {
        $result = $this->dbtwo->get('mbank')->result();
        echo json_encode(array('data' => $result));
    }

    public function savedata()
    {
        $d['useri'] = $this->session->userdata('username');
        $d['nama']  = $this->input->post('nama');
        $d['ket']   = $this->input->post('ket');
        $d['norek'] = $this->input->post('norek');
        $result     = $this->dbtwo->insert($this->table,$d);
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
        $d['useru'] = $this->session->userdata('username');
        $d['nama']  = $this->input->post('nama');
        $d['ket']   = $this->input->post('ket');
        $d['norek'] = $this->input->post('norek');
        $w['id']    = $this->input->post('id');

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