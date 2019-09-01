<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Stokproduk extends CI_Controller {
    
    public $table       = '';
    public $foldername  = '';
    public $indexpage   = 'stokproduk/v_stokproduk';
    function __construct() {
        parent::__construct();
        include(APPPATH.'libraries/sessionakses.php');
    }
    function index(){
        $data['gudang'] = $this->db->get('mgudang')->result();
        $this->load->view($this->indexpage,$data);  
    }

    public function getall(){
        $q = "SELECT
                dinventot. ID,
                dinventot.ref_brg,
                mbarang.nama,
                mbarang.kode,
                dinventot.jumlah,
                msatuan.nama msatuan_nama
            FROM
                dinventot
            LEFT JOIN mbarang ON mbarang.kode = dinventot.ref_brg
            LEFT JOIN mbarangs ON mbarangs.ref_brg = mbarang.kode
            LEFT JOIN msatbrg ON msatbrg.ref_brg = mbarang.kode
            LEFT JOIN msatuan ON msatuan.kode = msatbrg.ref_sat
            WHERE
                msatbrg.def = 't'";
        $result     = $this->db->query($q)->result();
        echo json_encode(array('data' => $result));
    }

    function getbrg() {
        $q = "SELECT
                mbarang. ID,
                mbarang.kode,
                mbarang.nama,
                mbarang.ket,
                msatbrg. ID idsatbarang,
                msatbrg.konv,
                msatbrg.kode ref_satbrg,
                msatbrg.ket,
                msatbrg.harga,
                msatbrg.ref_brg,
                msatbrg.ref_sat,
                msatbrg.ref_gud,
                msatuan.nama namasatuan,
                mgudang.nama namagudang,
                (
                    SELECT
                        COUNT (mbarangs. ID)
                    FROM
                        mbarangs
                    WHERE
                        mbarangs.ref_brg = mbarang.kode
                ) jumlahspek
            FROM
                mbarang
            LEFT JOIN msatbrg ON msatbrg.ref_brg = mbarang.kode
            LEFT JOIN msatuan ON msatuan.kode = msatbrg.ref_sat
            LEFT JOIN mgudang ON mgudang.kode = msatbrg.ref_gud
            WHERE
                msatbrg.def = 't'";
        $result     = $this->db->query($q)->result();
        $list       = [];
        foreach ($result as $i => $r) {
            $row['id']          = $r->id;
            $row['no']          = $i + 1;
            $row['nama']        = $r->nama;
            $row['kode']        = $r->kode;
            $row['ket']         = $r->ket;
            $row['namasatuan']  = $r->namasatuan;
            $row['konv']        = $r->konv;
            $row['harga']       = $r->harga;
            $row['ref_brg']     = $r->ref_brg;
            $row['ref_satbrg']  = $r->ref_satbrg;

            $list[] = $row;
        }   
        echo json_encode(array('data' => $list));
    }

    public function savedata_in()
    {   
        $this->db->trans_begin();
        $a['useri']     = $this->session->userdata('username');
        // $a['ref_gud']   = $this->input->post('ref_gud');
        $a['ref_gud']   = $this->libre->gud_def();
        $a['tgl']       = date('Y-m-d', strtotime($this->input->post('tgl')));
        $a['ket']       = $this->input->post('ket');
        $this->db->insert('xgudangin',$a);
        $id     = $this->db->insert_id();
        $kode   = $this->db->get_where('xgudangin',array('id' => $id))->row()->kode;
        $b['ref_gudin'] = $kode;
        $b['ref_brg']   = $this->input->post('ref_brg');
        $b['ref_satbrg']= $this->input->post('ref_satbrg');
        $b['jumlah']    = $this->input->post('jumlah');
        $result = $this->db->insert('xgudangind',$b);
        $c['posted']    = 't';
        $result = $this->db->update('xgudangin',$c,array('id' => $id));
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $r = array(
                'sukses' => 'fail', 
            );
        }
        else {
            $this->db->trans_commit();
            $r = array(
                'sukses' => 'success'
                );
        }
        echo json_encode($r);
    }

    public function savedata_out()
    {   
        $this->db->trans_begin();
        $a['useri']     = $this->session->userdata('username');
        // $a['ref_gud']   = $this->input->post('ref_gud');
        $a['ref_gud']   = $this->libre->gud_def();
        $a['tgl']       = date('Y-m-d', strtotime($this->input->post('tgl')));
        $a['ket']       = $this->input->post('ket');
        $this->db->insert('xgudangout',$a);
        $id     = $this->db->insert_id();
        $kode   = $this->db->get_where('xgudangout',array('id' => $id))->row()->kode;
        $b['ref_gudout'] = $kode;
        $b['ref_brg']   = $this->input->post('ref_brg');
        $b['ref_satbrg']= $this->input->post('ref_satbrg');
        $b['jumlah']    = $this->input->post('jumlah');
        $result = $this->db->insert('xgudangoutd',$b);
        $c['posted']    = 't';
        $result = $this->db->update('xgudangout',$c,array('id' => $id));
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $r = array(
                'sukses' => 'fail', 
            );
        }
        else {
            $this->db->trans_commit();
            $r = array(
                'sukses' => 'success'
                );
        }
        echo json_encode($r);
    }
    
}