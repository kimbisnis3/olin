<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Agen extends CI_Controller {
    
    public $table       = 'm_barang';
    public $foldername  = 'barang';
    public $indexpage   = 'agen/v_agen';
    function __construct() {
        parent::__construct();
        // include(APPPATH.'libraries/sessionakses.php');
    }
    function index(){
        $this->load->view($this->indexpage);  
    }

    public function getall(){
        $this->db->order_by('id','desc');
        $result     = $this->db->get($this->table)->result();
        $no         = 1;
        $list       = [];
        foreach ($result as $r) {
            $row['id']      = $r->id;
            $row['no']      = $no;
            $row['judul']   = $r->judul;
            $row['artikel'] = $r->artikel;
            $row['ket']     = $r->ket;

            $list[] = $row;
            $no++;
        }   
        echo json_encode(array('data' => $list));
    }

    public function savedata()
    {   
        $d['useri']     = $this->session->userdata('nama_user');
        $d['judul']     = $this->input->post('judul');
        $d['artikel']   = $this->input->post('artikel');
        $d['ket']       = $this->input->post('ket');
        $d['slug']      = slug($this->input->post('slug'));

        $result = $this->db->insert($this->table,$d);
        $r['sukses'] = $result ? 'success' : 'fail' ;
        echo json_encode($r);
    }

    public function edit()
    {
        $w['id']= $this->input->post('id');
        $data   = $this->db->get_where($this->table,$w)->row();
        echo json_encode($data);
    }

    public function getselects()
    {
        $data   = $this->db->get($this->table)->result();
        echo json_encode($data);
    }

    function updatedata(){
        $d['useru']     = $this->session->userdata('nama_user');
        $d['dateu']     = 'now()';
        $d['judul']     = $this->input->post('judul');
        $d['artikel']   = $this->input->post('artikel');
        $d['ket']       = $this->input->post('ket');
        $d['slug']      = slug($this->input->post('judul'));
        $w['id'] = $this->input->post('id');
        $result = $this->db->update($this->table,$d,$w);
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
        $result = $this->db->delete($this->table,$w);
        $r['sukses'] = $result ? 'success' : 'fail' ;
        echo json_encode($r);
    }
    
}