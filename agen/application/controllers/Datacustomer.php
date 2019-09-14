<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Datacustomer extends CI_Controller {
    
    public $table       = 'mcustomer';
    public $foldername  = 'mcustomer';
    public $indexpage   = 'datacustomer/v_datacustomer';
    function __construct() {
        parent::__construct();
        include(APPPATH.'libraries/sessionakses.php');
        include(APPPATH.'libraries/dbinclude.php');  
    }
    function index(){
        $data['jenc'] = $this->dbtwo->get('mjencust')->result();
        $this->load->view($this->indexpage,$data);  
    }

    public function getall(){
        $q = "SELECT 
                mcustomer.*,
                mjencust.nama AS jencust
            FROM 
                mcustomer
            LEFT JOIN mjencust ON mjencust.kode = mcustomer.ref_jenc";
        $result     = $this->dbtwo->query($q)->result();
        $list       = [];
        foreach ($result as $i => $r) {
            $row['id']      = $r->id;
            $row['no']      = $i + 1;
            $row['nama']    = $r->nama;
            $row['alamat']  = $r->alamat;
            $row['telp']    = $r->telp;
            $row['email']   = $r->email;
            $row['pic']     = $r->pic;
            $row['ket']     = $r->ket;
            $row['jencust'] = $r->jencust;
            $row['aktif']   = $r->aktif;
            $row['user']    = $r->user;
            $row['pass']    = '****';

            $list[] = $row;
        }   
        echo json_encode(array('data' => $list));
    }

    public function savedata()
    {   
        $d['useri']     = $this->session->userdata('username');
        $d['nama']      = $this->input->post('nama');
        $d['alamat']    = $this->input->post('alamat');
        $d['telp']      = $this->input->post('telp');
        $d['email']     = $this->input->post('email');
        $d['pic']       = $this->input->post('pic');
        $d['ket']       = $this->input->post('ket');
        $d['ref_jenc']  = $this->input->post('ref_jenc');
        $d['user']      = $this->input->post('user');
        $d['pass']      = md5($this->input->post('pass'));
        $d['aktif']     = 't';

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

    public function getselects()
    {
        $data   = $this->dbtwo->get($this->table)->result();
        echo json_encode($data);
    }

    function updatedata(){
        $d['useru']     = $this->session->userdata('username');
        $d['dateu']     = 'now()';
        $d['nama']      = $this->input->post('nama');
        $d['alamat']    = $this->input->post('alamat');
        $d['telp']      = $this->input->post('telp');
        $d['email']     = $this->input->post('email');
        $d['pic']       = $this->input->post('pic');
        $d['ket']       = $this->input->post('ket');
        $d['ref_jenc']  = $this->input->post('ref_jenc');
        $d['user']      = $this->input->post('user');
        $d['pass']      = md5($this->input->post('pass'));
        $w['id'] = $this->input->post('id');
        $result = $this->dbtwo->update($this->table,$d,$w);
        $r['sukses'] = $result ? 'success' : 'fail' ;
        echo json_encode($r);
    }

    function aktifdata() {
        $sql = "SELECT aktif FROM {$this->table} WHERE id = {$this->input->post('id')}";
        $s = $this->dbtwo->query($sql)->row()->aktif;
        $s == 't' ? $status = 'f' : $status = 't';
        $d['aktif'] = $status;
        $w['id'] = $this->input->post('id');   
        $result = $this->dbtwo->update($this->table,$d,$w);
        $r['sukses'] = $result > 0 ? 'success' : 'fail' ;
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