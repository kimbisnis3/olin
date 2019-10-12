<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Company extends CI_Controller {
    
    public $table       = 'tcompany';
    public $foldername  = 'company';
    public $indexpage   = 'company/v_company';

    function __construct() {
        parent::__construct();
        include(APPPATH.'libraries/sessionakses.php');
    }

    function index()
    {
        $this->load->view($this->indexpage);  
    }

    public function getall()
    {
        $result = $this->db->get($this->table)->result();
        echo json_encode(array('data' => $result));
    }

    public function edit()
    {
        $w['id']= $this->input->post('id');
        $data   = $this->db->get_where($this->table,$w)->row();
        echo json_encode($data);
    }

    function updatedata()
    {
        $d['nama']  = $this->input->post('nama');
        $d['alamat']= $this->input->post('alamat');
        $d['telp']  = $this->input->post('telp');
        $d['hp']    = $this->input->post('hp');
        $d['kota']  = $this->input->post('kota');
        $d['prop']  = $this->input->post('prop');
        $d['ket']   = $this->input->post('ket');
        $d['email'] = $this->input->post('email');

        $w['id']    = $this->input->post('id');
        $result = $this->db->update($this->table,$d,$w);
        $r['sukses']    = $result ? 'success' : 'fail' ;
        echo json_encode($r);
    }

}