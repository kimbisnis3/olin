<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Contactus extends CI_Controller {
    
    public $table       = 'tcontactus';
    public $foldername  = 'contactus';
    public $indexpage   = 'contactus/v_contactus';

    function __construct() {
        parent::__construct();
        include(APPPATH.'libraries/sessionakses.php');
        include(APPPATH.'libraries/dbinclude.php');  
    }
    function index(){
        $this->load->view(view_front().$this->indexpage);  
    }

    public function getall(){
        // $this->dbtwo->where('tipe','ss');
        $result = $this->dbtwo->get($this->table)->result();
        echo json_encode(array('data' => $result));
    }

    public function edit()
    {
        $w['id']= $this->input->post('id');
        $data   = $this->dbtwo->get_where($this->table,$w)->row();
        echo json_encode($data);
    }

    public function savedata()
    {
        $d['nama']      = $this->input->post('nama');
        $d['email']     = $this->input->post('email');
        $d['alamat']    = $this->input->post('alamat');
        $d['hp']        = $this->input->post('hp');
        $d['pesan']     = $this->input->post('pesan');
        // $d['status']    = $this->input->post('status');

        $result = $this->dbtwo->insert($this->table,$d);
        $r['sukses'] = $result ? 'success' : 'fail' ;
        echo json_encode($r);
    }

    function updatedata()
    {
        $d['nama']      = $this->input->post('nama');
        $d['email']     = $this->input->post('email');
        $d['alamat']    = $this->input->post('alamat');
        $d['hp']        = $this->input->post('hp');
        $d['pesan']     = $this->input->post('pesan');
        // $d['status']    = $this->input->post('status');
        $w['id'] = $this->input->post('id');

        $result = $this->dbtwo->update($this->table,$d,$w);
        $r['sukses']    = $result ? 'success' : 'fail' ;
        echo json_encode($r);
    }



    public function deletedata()
    {
        $w['id']    = $this->input->post('id');
        $result     = $this->dbtwo->delete($this->table,$w);
        $r['sukses']= $result ? 'success' : 'fail' ;
        echo json_encode($r);
    }
}