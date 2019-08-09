<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Masterharga extends CI_Controller {
    
    public $table       = 'msatbrg';
    public $foldername  = 'msatbrg';
    public $indexpage   = 'masterharga/v_masterharga';
    function __construct() {
        parent::__construct();
        include(APPPATH.'libraries/sessionakses.php');
    }
    function index(){
        $data['satuan'] = $this->db->get('msatuan')->result();
        $data['gudang'] = $this->db->get('mgudang')->result();
        $this->load->view($this->indexpage,$data);  
    }

    public function getall(){
        $q = "SELECT
                msatbrg.id,
                msatbrg.konv,
                msatbrg.ket,
                msatbrg.harga,
                mbarang.nama namabarang,
                msatuan.nama namasatuan,
                mgudang.nama namagudang
            FROM
                msatbrg
            LEFT JOIN mbarang ON mbarang.kode = msatbrg.ref_brg
            LEFT JOIN msatuan ON msatuan.kode = msatbrg.ref_sat
            LEFT JOIN mgudang ON mgudang.kode = msatbrg.ref_gud";
        $result     = $this->db->query($q)->result();
        $list       = [];
        foreach ($result as $i => $r) {
            $row['id']          = $r->id;
            $row['no']          = $i + 1;
            $row['konv']        = $r->konv;
            $row['harga']       = number_format($r->harga);
            $row['namabarang']  = $r->namabarang;
            $row['namasatuan']  = $r->namasatuan;
            $row['namagudang']  = $r->namagudang;

            $list[] = $row;
        }   
        echo json_encode(array('data' => $list));
    }

    public function savedata()
    {   
        $this->db->trans_start();
        $a['useri']     = $this->session->userdata('username');
        $a['nama']      = $this->input->post('nama');
        $a['ket']       = $this->input->post('ketBrg');
        $this->db->insert('mbarang',$a);
        $idBrg = $this->db->insert_id();
        $kodeBrg = $this->db->get_where('mbarang',array('id' => $idBrg))->row()->kode;
        $b['ref_brg']   = $kodeBrg;
        $b['ref_sat']   = $this->input->post('ref_sat');
        $b['konv']      = $this->input->post('konv');
        $b['harga']     = $this->input->post('harga');
        $b['ket']       = $this->input->post('ketHarga');
        $b['ref_gud']   = $this->input->post('ref_gud');
        $result = $this->db->insert('msatbrg',$b);
        $this->db->trans_complete();
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
        $result = $this->db->update($this->table,$d,$w);
        $r['sukses'] = $result ? 'success' : 'fail' ;
        echo json_encode($r);
    }

    function aktifdata() {
        $sql = "SELECT aktif FROM {$this->table} WHERE id = {$this->input->post('id')}";
        $s = $this->db->query($sql)->row()->aktif;
        $s == 't' ? $status = 'f' : $status = 't';
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