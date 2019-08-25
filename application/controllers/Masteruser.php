<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Masteruser extends CI_Controller {
    
    public $table       = 'tuser';
    public $foldername  = 'masteruser';
    public $indexpage   = 'masteruser/v_masteruser';
    function __construct() {
        parent::__construct();
        include(APPPATH.'libraries/sessionakses.php');
    }
    function index(){
        $this->load->view($this->indexpage);  
    }

    public function getall(){
        $q          = " SELECT * FROM tuser WHERE id_user != 1";
        $result     = $this->db->query($q)->result();
        $no         = 1;
        $list       = [];
        foreach ($result as $r) {
            $row['id']          = $r->id_user;
            $row['no']          = $no;
            $row['nama_user']   = $r->nama_user;
            $row['pass']        = "*******";

            $list[] = $row;
            $no++;
        }   
        echo json_encode(array('data' => $list));
    }

    public function savedata()
    {   
        $d['useri']         = $this->session->userdata('username');
        $d['nama_user']     = $this->input->post('nama_user');
        $d['pass']          = md5($this->input->post('pass'));
        $d['ref_access_user']= '6';

        $result = $this->db->insert($this->table,$d);
        $r['sukses'] = $result ? 'success' : 'fail' ;
        echo json_encode($r);
    }

    public function edit()
    {
        $w['id_user']= $this->input->post('id');
        $data   = $this->db->get_where($this->table,$w)->row();
        echo json_encode($data);
    }

    function updatedata(){
        $d['useru']         = $this->session->userdata('username');
        $d['dateu']         = 'now()';
        $d['nama_user']     = $this->input->post('nama_user');
        $d['pass']          = md5($this->input->post('pass'));
        
        $w['id_user'] = $this->input->post('id');
        $result = $this->db->update($this->table,$d,$w);
        $r['sukses'] = $result ? 'success' : 'fail' ;
        echo json_encode($r);
    }

    public function deletedata()
    {
        $w['id_user'] = $this->input->post('id');
        $result = $this->db->delete($this->table,$w);
        $r['sukses'] = $result ? 'success' : 'fail' ;
        echo json_encode($r);
    }
    
}