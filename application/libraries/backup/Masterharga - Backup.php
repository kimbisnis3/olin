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
                mbarang.id idbarang,
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
            $row['idbarang']    = $r->idbarang;
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
        $a['ket']       = $this->input->post('ket');
        $this->db->insert('mbarang',$a);
        $idBrg = $this->db->insert_id();
        $kodeBrg = $this->db->get_where('mbarang',array('id' => $idBrg))->row()->kode;
        $b['useri']     = $this->session->userdata('username');
        $b['ref_brg']   = $kodeBrg;
        $b['ref_sat']   = $this->input->post('ref_sat');
        $b['konv']      = ien($this->input->post('konv'));
        $b['harga']     = ien($this->input->post('harga'));
        $b['ket']       = $this->input->post('ket');
        $b['ref_gud']   = $this->input->post('ref_gud');
        $result = $this->db->insert('msatbrg',$b);
        $this->db->trans_complete();
        $r['sukses'] = $result ? 'success' : 'fail' ;
        echo json_encode($r);
    }

    public function edit()
    {
        $q ="SELECT
                msatbrg.id idsatbarang,
                msatbrg.konv,
                msatbrg.ket,
                msatbrg.harga,
                msatbrg.ref_brg,
                msatbrg.ref_sat,
                msatbrg.ref_gud,
                mbarang.id idbarang,
                mbarang.nama namabarang,
                msatuan.nama namasatuan,
                mgudang.nama namagudang
            FROM
                msatbrg
            LEFT JOIN mbarang ON mbarang.kode = msatbrg.ref_brg
            LEFT JOIN msatuan ON msatuan.kode = msatbrg.ref_sat
            LEFT JOIN mgudang ON mgudang.kode = msatbrg.ref_gud
            WHERE msatbrg.id = '{$this->input->post('id')}'";
        $data   = $this->db->query($q)->row();
        echo json_encode($data);
    }

    public function getselects()
    {
        $data   = $this->db->get($this->table)->result();
        echo json_encode($data);
    }

    function updatedata(){
        $this->db->trans_start();
        $a['useru']     = $this->session->userdata('username');
        $a['dateu']     = 'now()';
        $a['nama']      = $this->input->post('nama');
        $a['ket']       = $this->input->post('ket');
        $this->db->update('mbarang',$a,array('id' => $this->input->post('idbarang')));
        $a['useru']     = $this->session->userdata('username');
        $a['dateu']     = 'now()';
        $b['ref_sat']   = $this->input->post('ref_sat');
        $b['konv']      = ien($this->input->post('konv'));
        $b['harga']     = ien($this->input->post('harga'));
        $b['ket']       = $this->input->post('ket');
        $b['ref_gud']   = $this->input->post('ref_gud');
        $result = $this->db->update('msatbrg',$b,array('id' => $this->input->post('idsatbarang')));
        $this->db->trans_complete();
        $r['sukses'] = $result ? 'success' : 'fail' ;
        echo json_encode($r);
    }

    public function deletedata()
    {
        $w['id']    = $this->input->post('id');
        $result     = $this->db->delete('mbarang',$w);
        $r['sukses'] = $result ? 'success' : 'fail' ;
        echo json_encode($r);
    }
    
}