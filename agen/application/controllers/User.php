<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User extends CI_Controller {
    
    public $table       = 't_user';
    public $judul       = 'User';
    public $aktifgrup   = 'user';
    public $aktifmenu   = 'user';
    public $foldername  = 'user';
    public $indexpage   = 'user/v_user';
    function __construct() {
        parent::__construct();
        include(APPPATH.'libraries/sessionakses.php');
        $title      = $this->judul;
    }
    public function index(){
        $data['title']      = $this->judul;
        $data['aktifgrup']  = $this->aktifgrup;
        $data['aktifmenu']  = $this->aktifmenu;
        $title      = $this->judul;
        $this->load->view($this->indexpage, $data);  
    }

    public function setView(){
        $result     = $this->Unimodel->getdata($this->table);
        $list       = array();
        $no         = 1;
        foreach ($result as $r) {
            if ($r->image == NULL ){
                $gambar = "(Noimage)";
            } else {
                $gambar = "<img style='max-width : 30px;' src='.".$r->image."'>";
            }
            $row    = array(
                        "no"        => $no,
                        "username"  => $r->username,
                        "password"  => $r->password,
                        "nama"      => $r->nama,
                        "alamat"    => $r->alamat,
                        "aktif"      => aktif($r->aktif),
                        "action"    => btnuda($r->id)
                        
            );
            $list[] = $row;
            $no++;
        }   
        echo json_encode(array('data' => $list));
    }

    public function tambah()
    {
        $d['useri']     = $this->session->userdata('username');
        $d['username']  = $this->input->post('username');
        $d['password']  = $this->input->post('password');
        $d['nama']      = $this->input->post('nama');
        $d['alamat']    = $this->input->post('alamat');

        $insert = $this->Unimodel->save($this->table,$d);

        $r['sukses'] = ($insert > 0) ? 'success' : 'fail' ;
        echo json_encode($r);
    }

    public function edit()
    {
        $w['id'] = $this->input->post('id');
        $data = $this->Unimodel->edit($this->table,$w);
        echo json_encode($data);
    }
    public function update()
    {
        $d['useri']     = $this->session->userdata('username');
        $d['username']  = $this->input->post('username');
        $d['password']  = $this->input->post('password');
        $d['nama']      = $this->input->post('nama');
        $d['alamat']    = $this->input->post('alamat');

        $w['id'] = $this->input->post('id');

        $update = $this->Unimodel->update($this->table,$d,$w);
        $r['sukses'] = ($update > 0) ? 'success' : 'fail' ;
        echo json_encode($r);
    }

    public function hapus()
    {   
        $w['id'] = $this->input->post('id');
        $delete = $this->Unimodel->delete($this->table,$w);
        $r['sukses'] = ($delete > 0) ? 'success' : 'fail' ;
        echo json_encode($r);
    }

    public function aktif()
    {
        $sql = "SELECT aktif FROM {$this->table} WHERE id = {$this->input->post('id')}";
        $s = $this->db->query($sql)->row()->aktif;

        $s == 1 ? $status = 0 : $status =1;

        $d['aktif'] = $status;
        $w['id'] = $this->input->post('id');   
        $update = $this->Unimodel->update($this->table,$d,$w);
        $r['sukses'] = ($update > 0) ? 'success' : 'fail' ;
        echo json_encode($r);
    }
    
}