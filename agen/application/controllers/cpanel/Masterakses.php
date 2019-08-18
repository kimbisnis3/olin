<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Masterakses extends CI_Controller {
    
    public $table       = 'taccess';
    public $foldername  = 'barang';
    public $indexpage   = 'cpanel/masterakses/v_masterakses';
    function __construct() {
        parent::__construct();
        include(APPPATH.'libraries/sessionsuper.php');
    }
    function index(){
        $this->load->view($this->indexpage);  
    }

    public function getall(){
        $result     = $this->db->get($this->table)->result();
        $no         = 1;
        $list       = [];
        foreach ($result as $r) {
            $row['id_access']       = $r->id_access;
            $row['no']              = $no;
            $row['nama_access']     = $r->nama_access;
            $row['issuper_access']  = 0;

            $list[] = $row;
            $no++;
        }   
        echo json_encode(array('data' => $list));
    }

    public function savedata()
    {   
        $d['useri']         = $this->session->userdata('username');
        $d['nama_access']   = $this->input->post('nama_access');
        $d['entity_access'] = 'gts';

        $result = $this->db->insert($this->table,$d);
        $r['sukses'] = $result ? 'success' : 'fail' ;
        echo json_encode($r);
    }

    public function edit()
    {
        $w['id_access']= $this->input->post('id');
        $data   = $this->db->get_where($this->table,$w)->row();
        echo json_encode($data);
    }

    function updatedata(){
        $d['useru']     = $this->session->userdata('username');
        $d['dateu']     = 'now()';
        $d['nama_access']   = $this->input->post('nama_access');
        $d['issuper_access']= $this->input->post('issuper_access');

        $w['id_access'] = $this->input->post('id_access');
        $result = $this->db->update($this->table,$d,$w);
        $r['sukses'] = $result ? 'success' : 'fail' ;
        echo json_encode($r);
    }

    public function deletedata()
    {
        $w['id_access'] = $this->input->post('id_access');
        $result = $this->db->delete($this->table,$w);
        $r['sukses'] = $result ? 'success' : 'fail' ;
        echo json_encode($r);
    }
    
}