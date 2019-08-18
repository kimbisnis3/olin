<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Element extends CI_Controller {

    function __construct() {
        parent::__construct();
        $session = $this->session->userdata('in');
        if ($session != TRUE)
        {
            $this->session->set_flashdata('message', '<div style="color : red;">Login Terlebih Dahulu</div>');
            redirect('auth');
        }

        $this->load->model('M_element');
    }

    public function index(){
        $data['title']      = 'Element Web';
        $data['aktifgrup']  = '';
        $data['aktifmenu']  = 'element';

        $this->load->view('element/v_element', $data); 
    }

    public function setView(){

        $result     = $this->M_element->getSemua();
        $list       = array();
        $no         = 1;

        foreach ($result as $r) {
            $row    = array(
                        "no"        => $no,
                        "kode"      => $r->kode,
                        "nama"      => $r->nama,
                        "warna"     => $r->warna,
                        "teks"      => $r->teks,
                        "icon"      => $r->icon,
                        "ket"       => $r->ket,
                        "action"    => "
                        <a href='javascript:void(0)' class='btn btn-sm btn-warning' data-toggle='tooltip' data-placement='top' title='Edit' onclick='edit_data(".$r->id.")'><i class='glyphicon glyphicon-pencil'></i></a>
                        <a href='javascript:void(0)' class='btn btn-sm btn-danger' data-toggle='tooltip' data-placement='top' title='Hapus' onclick='hapus(".$r->id.")'><i class='glyphicon glyphicon-trash'></i></a> "
                        
            );

            $list[] = $row;
            $no++;
        }   
        echo json_encode(array('data' => $list));
    }

    public function setlogo()
    {
        $result     = $this->M_element->getlogo();
        echo json_encode($result);
    }

    public function setgambarheader()
    {
        $result     = $this->M_element->getgambarheader();
        echo json_encode($result);
    }

    public function tambah()
    {   
        $nmfile = $this->input->post('nama');
        $config['upload_path'] = '/uploads/element';
        $config['allowed_types'] = '*';
        $config['file_name'] = slug($nmfile);
        $path =  $config['upload_path'];
        $this->upload->initialize($config);
        //if upload failed
        if ( ! $this->upload->do_upload('berkas')){
            $data = array(
                    'useri' => $this->session->userdata('nama'),
                    'nama' => $this->input->post('nama'),
                    'ref_mdivisi' => '006.08',
                    'keterangan' => $this->input->post('ket'),
                    );
            //query to insert into myupload table
            $insert = $this->M_element->save($data);
        }else{
            $data = array(
                    'useri' => $this->session->userdata('nama'),
                    'keterangan' => $this->input->post('ket'),
                    'nama' => $this->input->post('nama'),
                    'path' => $path.'/'.$this->upload->data('file_name') ,
                    );
            //query to insert into myupload table
            $insert = $this->M_element->save($data);
        }
        echo json_encode(array("sukses" => TRUE));
    }

    public function edit($id)
    {
        $data = $this->M_element->edit($id);
        echo json_encode($data);
    }

    function updatelogo(){
        $nmfile = 'ss'.time();
        $config['upload_path'] = '/uploads/element';
        $config['allowed_types'] = '*';
        $config['file_name'] = slug($nmfile);
        $path =  $config['upload_path'];
        $this->upload->initialize($config);
        //if upload failed
        $pathfile   = $this->input->post('path');
        $ext        = substr($pathfile, -3);
        $slug = slug($this->input->post('title'));

        if ( ! $this->upload->do_upload('image')){
        //if upload success
                @rename("$pathfile",$path.'/'.$this->upload->data('file_name').'.'.$ext);
                $data = array(
                    'useru' => $this->session->userdata('nama_user'),
                    'dateu' => 'now()',
                    'image' => $path.'/'.$this->upload->data('file_name').'.'.$ext ,
                    );

                $where = array(
                    'kode' => 'logo',
            );
                $this->M_element->update($where,$data);
        }else{
                @unlink("$pathfile");
                $data = array(
                    'useru' => $this->session->userdata('nama_user'),
                    'dateu' => 'now()',
                    'image' => $path.'/'.$this->upload->data('file_name') ,
                    );

                $where = array(
                    'kode' => 'logo'
            );
                $this->M_element->update($where,$data);
        }
        echo json_encode(array("sukses" => TRUE));
    }

    function updategambarheader(){
        $nmfile = $this->input->post('namagambarheader');
        $config['upload_path'] = '/uploads/element';
        $config['allowed_types'] = '*';
        $config['file_name'] = slug($nmfile);
        $path =  $config['upload_path'];
        $this->upload->initialize($config);
        //if upload failed
        $pathfile   = $this->input->post('path');
        $ext        = substr($pathfile, -3);
        $slug = slug($this->input->post('title'));

        if ( ! $this->upload->do_upload('image')){
        //if upload success
                @rename("$pathfile",$path.'/'.$this->upload->data('file_name').'.'.$ext);
                $data = array(
                    'useru' => $this->session->userdata('nama_user'),
                    'dateu' => 'now()',
                    'image' => $path.'/'.$this->upload->data('file_name').'.'.$ext ,
                    );

                $where = array(
                    'kode' => 'gambarheader',
            );
                $this->M_element->update($where,$data);
        }else{
                @unlink("$pathfile");
                $data = array(
                    'useru' => $this->session->userdata('nama_user'),
                    'dateu' => 'now()',
                    'image' => $path.'/'.$this->upload->data('file_name') ,
                    );

                $where = array(
                    'kode' => 'gambarheader'
            );
                $this->M_element->update($where,$data);
        }
        echo json_encode(array("sukses" => TRUE));
    }

    public function hapus($id)
    {   
        $path = $this->M_element->getpath($id);
        unlink("$path->path");
        $this->M_element->delete($id);
        echo json_encode(array("sukses" => TRUE));
    }

    public function unduh($id)
    {   
        $path = $this->M_element->getpath($id);
        $download = "$path->path";
        if ($download != NULL) {
            echo json_encode(array(
                "unduh" => $download,
                "sukses" => TRUE 
                ));
        }else{
            echo json_encode(array("unduh" => 'kosong'));
        }
        
    }
    

}
