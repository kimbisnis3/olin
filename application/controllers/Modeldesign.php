<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Modeldesign extends CI_Controller {
    
    public $table       = 'mmodesign';
    public $foldername  = 'mmodesign';
    public $indexpage   = 'modeldesign/v_modeldesign';
    function __construct() {
        parent::__construct();
        include(APPPATH.'libraries/sessionakses.php');
    }
    function index(){
        $this->load->view($this->indexpage);  
    }

    public function getall(){
        $result     = $this->db->get($this->table)->result();
        $list       = [];
        foreach ($result as $i => $r) {
            $row['id']      = $r->id;
            $row['no']      = $i + 1;
            $row['nama']    = $r->nama;
            $row['image']   = showimage($r->gambar);
            $row['ket']     = $r->ket;

            $list[] = $row;
        }   
        echo json_encode(array('data' => $list));
    }

    public function edit()
    {
        $w['id']= $this->input->post('id');
        $data   = $this->db->get_where($this->table,$w)->row();
        echo json_encode($data);
    }

    public function savedata()
    {   
        $config['upload_path'] = './uploads/'.$this->foldername;
        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, TRUE);
        }
        $config['allowed_types'] = '*';
        $config['file_name'] = slug($this->input->post('nama'));
        $path = substr($config['upload_path'],1);
        $this->upload->initialize($config);
        
        if ( ! $this->upload->do_upload('image')){
            $d['useri']     = $this->session->userdata('username');
            $d['nama']      = $this->input->post('nama');
            $d['ket']       = $this->input->post('ket');
            $result = $this->db->insert($this->table,$d);
        }else{
            $d['useri']     = $this->session->userdata('username');
            $d['nama']      = $this->input->post('nama');
            $d['ket']       = $this->input->post('ket');
            $d['gambar']     = $path.'/'.$this->upload->data('file_name');

            $result = $this->db->insert($this->table,$d);
        }
        $r['sukses'] = $result ? 'success' : 'fail' ;
        echo json_encode($r);
    }

    function updatedata(){
        $config['upload_path'] = './uploads/'.$this->foldername;
        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, TRUE);
        }
        $config['allowed_types'] = '*';
        $config['file_name'] = slug($this->input->post('nama'));
        $path =  substr($config['upload_path'],1);
        $this->upload->initialize($config);
        $pathfile   = $this->input->post('path');
        $ext        = substr($pathfile, -3);
        if ( ! $this->upload->do_upload('image')){
        
                @rename("$pathfile",'.'.$path.'/'.$this->upload->data('file_name').'.'.$ext);
                
                $d['useru']     = $this->session->userdata('username');
                $d['dateu']     = 'now()';
                $d['nama']      = $this->input->post('nama');
                $d['ket']       = $this->input->post('ket');
                $d['gambar']    = $path.'/'.$this->upload->data('file_name').'.'.$ext ;

                $w['id'] = $this->input->post('id');
                $result = $this->db->update($this->table,$d,$w);
        }else{
                @unlink("$pathfile");
                $d['useru']     = $this->session->userdata('username');
                $d['dateu']     = 'now()';
                $d['nama']      = $this->input->post('nama');
                $d['ket']       = $this->input->post('ket');
                $d['gambar']    = $path.'/'.$this->upload->data('file_name');

                $w['id'] = $this->input->post('id');
                $result = $this->db->update($this->table,$d,$w);
        }
        $r['sukses'] = $result ? 'success' : 'fail' ;
        echo json_encode($r);
    }



    public function deletedata()
    {
        $w['id'] = $this->input->post('id');
        $sql = "SELECT gambar FROM {$this->table} WHERE id = {$this->input->post('id')}";
        $path = $this->db->query($sql)->row()->gambar;
        
        @unlink('.'.$path);
        
        $w['id'] = $this->input->post('id');
        $result = $this->db->delete($this->table,$w);
        $r['sukses'] = $result ? 'success' : 'fail' ;
        echo json_encode($r);
    }

    // public function savedata()
    // {   
    //     $d['useri']     = $this->session->userdata('username');
    //     $d['nama']      = $this->input->post('nama');
    //     $d['colorc']    = $this->input->post('kodewarna');
    //     $d['ket']       = $this->input->post('ket');

    //     $result = $this->db->insert($this->table,$d);
    //     $r['sukses'] = $result ? 'success' : 'fail' ;
    //     echo json_encode($r);
    // }
    
    // function updatedata(){
    //     $d['useru']     = $this->session->userdata('username');
    //     $d['dateu']     = 'now()';
    //     $d['nama']      = $this->input->post('nama');
    //     $d['colorc']    = $this->input->post('kodewarna');
    //     $d['ket']       = $this->input->post('ket');
    //     $w['id'] = $this->input->post('id');
    //     $result = $this->db->update($this->table,$d,$w);
    //     $r['sukses'] = $result ? 'success' : 'fail' ;
    //     echo json_encode($r);
    // }
}