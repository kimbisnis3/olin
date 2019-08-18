<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mastergambar extends CI_Controller {
    
    public $table       = 'mgambar';
    public $foldername  = 'mgambar';
    public $indexpage   = 'mastergambar/v_mastergambar';
    function __construct() {
        parent::__construct();
        include(APPPATH.'libraries/sessionakses.php');
    }
    function index(){
        $data['modesign'] = $this->db->get('mmodesign')->result();
        $this->load->view($this->indexpage,$data);  
    }

    public function getall(){
        $q = "SELECT 
            mgambar.id,
            mgambar.kode,
            mgambar.nama,
            mgambar.ket,
            mgambar.path,
            mmodesign.nama namadesign,
            mmodesign.gambar gambardesign
        FROM 
            mgambar 
        LEFT JOIN mmodesign ON mgambar.ref_model = mmodesign.kode";

        $result     = $this->db->query($q)->result();
        $list       = [];
        foreach ($result as $i => $r) {
            $row['id']      = $r->id;
            $row['no']      = $i + 1;
            $row['nama']    = $r->nama;
            $row['image']   = showimage($r->path);
            $row['ket']     = $r->ket;
            $row['namadesign']      = $r->namadesign;
            $row['gambardesign']    = showimage($r->gambardesign);

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
        $config['upload_path'] = $this->libre->pathupload().$this->foldername;
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
            $d['ref_model'] = $this->input->post('ref_model');
            $result = $this->db->insert($this->table,$d);
        }else{
            $d['useri']     = $this->session->userdata('username');
            $d['nama']      = $this->input->post('nama');
            $d['ket']       = $this->input->post('ket');
            $d['ref_model'] = $this->input->post('ref_model');
            $d['path']      = $path.'/'.$this->upload->data('file_name');

            $result = $this->db->insert($this->table,$d);
        }
        $r['sukses'] = $result ? 'success' : 'fail' ;
        echo json_encode($r);
    }

    function updatedata(){
        $config['upload_path'] = $this->libre->pathupload().$this->foldername;
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
                $d['ref_model'] = $this->input->post('ref_model');
                $d['path']      = $path.'/'.$this->upload->data('file_name').'.'.$ext ;

                $w['id'] = $this->input->post('id');
                $result = $this->db->update($this->table,$d,$w);
        }else{
                @unlink("$pathfile");
                $d['useru']     = $this->session->userdata('username');
                $d['dateu']     = 'now()';
                $d['nama']      = $this->input->post('nama');
                $d['ket']       = $this->input->post('ket');
                $d['ref_model'] = $this->input->post('ref_model');
                $d['path']      = $path.'/'.$this->upload->data('file_name');

                $w['id'] = $this->input->post('id');
                $result = $this->db->update($this->table,$d,$w);
        }
        $r['sukses'] = $result ? 'success' : 'fail' ;
        echo json_encode($r);
    }



    public function deletedata()
    {
        $w['id'] = $this->input->post('id');
        $sql = "SELECT path FROM {$this->table} WHERE id = {$this->input->post('id')}";
        $path = $this->db->query($sql)->row()->path;
        
        @unlink('.'.$path);
        
        $w['id'] = $this->input->post('id');
        $result = $this->db->delete($this->table,$w);
        $r['sukses'] = $result ? 'success' : 'fail' ;
        echo json_encode($r);
    }
}