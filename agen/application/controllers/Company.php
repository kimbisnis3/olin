<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Company extends CI_Controller {
    
    public $table       = 'tcompany';
    public $foldername  = 'company';
    public $indexpage   = 'company/v_company';

    function __construct() {
        parent::__construct();
        include(APPPATH.'libraries/sessionakses.php');
        include(APPPATH.'libraries/dbinclude.php');  
    }
    function index(){
        $this->load->view(view_front().$this->indexpage);  
    }

    public function getall(){
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
        // if (!empty($_FILES['image']['name'])) {
        //     $path = $this->libre->goUpload('image','img-'.time(),$this->foldername);
        //     $d['image'] = $path;
        //     $oldpath = $this->input->post('path');
        //     @unlink(".".$oldpath);
        // } else {
        //     $d['image'] = $this->input->post('path');
        // }

        $d['nama']  = $this->input->post('nama');
        $d['alamat']= $this->input->post('alamat');
        $d['telp']  = $this->input->post('telp');
        $d['hp']    = $this->input->post('hp');
        $d['kota']  = $this->input->post('kota');
        $d['prop']  = $this->input->post('prop');
        $d['ket']   = $this->input->post('ket');
        $w['email'] = $this->input->post('email');
        $w['website']= $this->input->post('website');

        $result = $this->dbtwo->update($this->table,$d,$w);
        $r['sukses']    = $result ? 'success' : 'fail' ;
        echo json_encode($r);
    }

}