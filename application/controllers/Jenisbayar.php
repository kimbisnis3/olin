<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Jenisbayar extends CI_Controller {
    
    public $table       = 'mjenbayar';
    public $foldername  = 'mjenbayar';
    public $indexpage   = 'jenisbayar/v_jenisbayar';
    function __construct() {
        parent::__construct();
        include(APPPATH.'libraries/sessionakses.php');
    }
    function index(){
        $this->load->view($this->indexpage);  
    }

    public function getall(){
        $result     = $this->db->get($this->table)->result();
        $no         = 1;
        $list       = [];
        foreach ($result as $r) {
            $row['id']      = $r->id;
            $row['no']      = $no;
            $row['nama']    = $r->nama;
            $row['ket']     = $r->ket;

            $list[] = $row;
            $no++;
        }   
        echo json_encode(array('data' => $list));
    }

    public function savedata()
    {   
        $d['useri']     = $this->session->userdata('username');
        $d['nama']      = $this->input->post('nama');
        $d['ket']       = $this->input->post('ket');

        $result = $this->db->insert($this->table,$d);
        $r['sukses'] = $result ? 'success' : 'fail' ;
        echo json_encode($r);
    }

    public function edit()
    {
        $w['id']= $this->input->post('id');
        $data   = $this->db->get_where($this->table,$w)->row();
        echo json_encode($data);
    }

    public function getselects()
    {
        $data   = $this->db->get($this->table)->result();
        echo json_encode($data);
    }

    function updatedata(){
        $d['useru']     = $this->session->userdata('username');
        $d['dateu']     = 'now()';
        $d['nama']      = $this->input->post('nama');
        $d['ket']       = $this->input->post('ket');
        $w['id'] = $this->input->post('id');
        $result = $this->db->update($this->table,$d,$w);
        $r['sukses'] = $result ? 'success' : 'fail' ;
        echo json_encode($r);
    }

    public function deletedata()
    {
        $w['id'] = $this->input->post('id');
        $result = $this->db->delete($this->table,$w);
        $r['sukses'] = $result ? 'success' : 'fail' ;
        echo json_encode($r);
    }
    
}