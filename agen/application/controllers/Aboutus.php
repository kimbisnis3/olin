<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Aboutus extends CI_Controller {
    
    public $table       = 'tconfigimage';
    public $foldername  = 'aboutus';
    public $indexpage   = 'aboutus/v_aboutus';

    function __construct() {
        parent::__construct();
        include(APPPATH.'libraries/sessionakses.php');
        include(APPPATH.'libraries/dbinclude.php');  
    }
    function index(){
        $this->load->view(view_front().$this->indexpage);  
    }

    public function getall(){
        $this->dbtwo->where('tipe','aboutus');
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
        if (!empty($_FILES['image']['name'])) {
            $path = $this->libre->goUpload('image','img-'.time(),$this->foldername);
            $d['image'] = $path;
            $oldpath = $this->input->post('path');
            @unlink(".".$oldpath);
        } else {
            $d['image'] = $this->input->post('path');
        }

        $d['judul']     = $this->input->post('judul');
        $d['ket']       = $this->input->post('ket');
        $w['id'] = $this->input->post('id');

        $result = $this->dbtwo->update($this->table,$d,$w);
        $r['sukses']    = $result ? 'success' : 'fail' ;
        echo json_encode($r);
    }

}