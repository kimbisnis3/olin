<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Elteks extends CI_Controller {
    
    public $table       = 'tconfigtext';
    public $foldername  = 'elteks';
    public $indexpage   = 'elteks/v_elteks';

    function __construct() {
        parent::__construct();
        include(APPPATH.'libraries/sessionakses.php');
        include(APPPATH.'libraries/dbinclude.php');  
    }
    function index(){
        $this->load->view(view_front().$this->indexpage);  
    }

    public function getall(){
        // $this->dbtwo->where('kode','elteks');
        $this->dbtwo->order_by('id','asc');
        $result = $this->dbtwo->get($this->table)->result();
        echo json_encode(array('data' => $result));
    }

    public function edit()
    {
        $w['id']= $this->input->post('id');
        $data   = $this->dbtwo->get_where($this->table,$w)->row();
        echo json_encode($data);
    }

    function updatedata()
    {
        $d['teks']  = $this->input->post('teks');
        $d['ket']   = $this->input->post('ket');
        $w['id']    = $this->input->post('id');
        $result = $this->dbtwo->update($this->table,$d,$w);
        $r['sukses']    = $result ? 'success' : 'fail' ;
        echo json_encode($r);
    }
}