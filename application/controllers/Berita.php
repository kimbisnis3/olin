<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Berita extends CI_Controller {
    
    public $table       = 'm_berita';
    public $foldername  = 'berita';
    public $indexpage   = 'berita/v_berita';
    function __construct() {
        parent::__construct();
        include(APPPATH.'libraries/sessionakses.php');
    }
    function index(){
        
        $this->load->view($this->indexpage);  
    }

    public function getall(){
        $this->db->order_by('id','desc');
        $result     = $this->db->get($this->table)->result();
        $no         = 1;
        foreach ($result as $r) {
            if ($r->image == NULL ){
                $gambar = "(Noimage)";
            } else {
                $img = base_url().''.$r->image;
                $gambar = "<img style='max-width : 30px;' src='".$img."'>";
            }
            $row    = array(
                        "no"        => $no,
                        "judul"     => $r->judul,
                        "artikel"   => $r->artikel,
                        "image"     => $gambar,
                        "ket"       => $r->ket,
                        "aktif"     => aktif($r->aktif),
                        "action"    => btnuda($r->id)
                        
            );
            $list[] = $row;
            $no++;
        }   
        echo json_encode(array('data' => $list));
    }

    public function savedata()
    {   
        $config['upload_path'] = './uploads/'.$this->foldername;
        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, TRUE);
        }
        $config['allowed_types'] = '*';
        $config['file_name'] = slug($this->input->post('judul'));
        $path = substr($config['upload_path'],1);
        $this->upload->initialize($config);
        
        if ( ! $this->upload->do_upload('image')){
            $d['useri']     = $this->session->userdata('nama_user');
            $d['judul']     = $this->input->post('judul');
            $d['artikel']   = $this->input->post('artikel');
            $d['ket']       = $this->input->post('ket');
            $d['slug']      = slug($this->input->post('slug'));
            $result = $this->db->insert($this->table,$d);
        }else{
            $d['useri']     = $this->session->userdata('nama_user');
            $d['judul']     = $this->input->post('judul');
            $d['artikel']   = $this->input->post('artikel');
            $d['ket']       = $this->input->post('ket');
            $d['slug']      = slug($this->input->post('slug'));
            $d['image']     = $path.'/'.$this->upload->data('file_name');

            $result = $this->db->insert($this->table,$d);
        }
        $r['sukses'] = $result ? 'success' : 'fail' ;
        echo json_encode($r);
    }

    public function edit()
    {
        $w['id']= $this->input->post('id');
        $data   = $this->db->get_where($this->table,$w)->row();
        echo json_encode($data);
    }

    function updatedata(){
        $config['upload_path'] = './uploads/'.$this->foldername;
        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, TRUE);
        }
        $config['allowed_types'] = '*';
        $config['file_name'] = slug($this->input->post('judul'));
        $path =  substr($config['upload_path'],1);
        $this->upload->initialize($config);
        $pathfile   = $this->input->post('path');
        $ext        = substr($pathfile, -3);
        if ( ! $this->upload->do_upload('image')){
        
                @rename("$pathfile",'.'.$path.'/'.$this->upload->data('file_name').'.'.$ext);
                
                $d['useru']     = $this->session->userdata('nama_user');
                $d['dateu']     = 'now()';
                $d['judul']     = $this->input->post('judul');
                $d['artikel']   = $this->input->post('artikel');
                $d['ket']       = $this->input->post('ket');
                $d['slug']      = slug($this->input->post('judul'));
                $d['image']     = $path.'/'.$this->upload->data('file_name').'.'.$ext ;

                $w['id'] = $this->input->post('id');
                $result = $this->db->update($this->table,$d,$w);
        }else{
                @unlink("$pathfile");
                $d['useru']     = $this->session->userdata('nama_user');
                $d['dateu']     = 'now()';
                $d['judul']     = $this->input->post('judul');
                $d['artikel']   = $this->input->post('artikel');
                $d['ket']       = $this->input->post('ket');
                $d['slug']      = slug($this->input->post('judul'));
                $d['image']     = $path.'/'.$this->upload->data('file_name');

                $w['id'] = $this->input->post('id');
                $result = $this->db->update($this->table,$d,$w);
        }
        $r['sukses'] = $result ? 'success' : 'fail' ;
        echo json_encode($r);
    }

    function aktifdata() {
        $sql = "SELECT aktif FROM {$this->table} WHERE id = {$this->input->post('id')}";
        $s = $this->db->query($sql)->row()->aktif;
        $s == 1 ? $status = 0 : $status =1;
        $d['aktif'] = $status;
        $w['id'] = $this->input->post('id');   
        $result = $this->db->update($this->table,$d,$w);
        $r['sukses'] = $result > 0 ? 'success' : 'fail' ;
        echo json_encode($r);

    }

    public function deletedata()
    {
        $w['id'] = $this->input->post('id');
        $sql = "SELECT image FROM {$this->table} WHERE id = {$this->input->post('id')}";
        $path = $this->db->query($sql)->row()->image;
        
        @unlink('.'.$path);
        
        $w['id'] = $this->input->post('id');
        $result = $this->db->delete($this->table,$w);
        $r['sukses'] = $result ? 'success' : 'fail' ;
        echo json_encode($r);
    }
    
}