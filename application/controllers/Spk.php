<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Spk extends CI_Controller {
    
    public $table       = 'xprocorder';
    public $foldername  = 'spk';
    public $indexpage   = 'spk/v_spk';
    public $printpage   = 'spk/p_spk';

    function __construct() {
        parent::__construct();
        include(APPPATH.'libraries/sessionakses.php');
    }
    function index(){
        $data['jenisbayar'] = $this->db->get('mjenbayar')->result();
        $this->load->view($this->indexpage,$data);  
    }

    public function getall()
    {
        $filterawal = date('Y-m-d', strtotime($this->input->post('filterawal')));
        $filterakhir = date('Y-m-d', strtotime($this->input->post('filterakhir')));
        $filteragen = $this->input->post('filteragen');
        $q = "SELECT 
                xprocorder.id,
                xprocorder.kode,
                to_char(xprocorder.tgl, 'DD Mon YYYY') tgl,
                xprocorder.ref_brg,
                xprocorder.ref_order,
                xprocorder.status,
                xprocorder.ket,
                mbarang.nama mbarang_nama
            FROM 
                xprocorder
            LEFT JOIN mbarang ON mbarang.kode = xprocorder.ref_brg
            LEFT JOIN xorder ON xorder.kode = xprocorder.ref_order
            WHERE xprocorder.void IS NOT TRUE
            AND
                xprocorder.tgl 
            BETWEEN '$filterawal' AND '$filterakhir'";
        if ($filteragen) {
            $q .= " AND xorder.ref_cust = '$filteragen'";
        }
        $result     = $this->db->query($q)->result();
        echo json_encode(array('data' => $result));
    }

    public function getorder(){
        $q = "SELECT
                xorder. ID,
                to_char(xorder.tgl, 'DD Mon YYYY') xorder_tgl,
                xorderd.ref_order,
                xorderd.ref_brg,
                xorderd.ref_satbrg,
                xorderd.jumlah,
                mcustomer.nama mcustomer_nama,
                xpelunasan.kode xpelunasan_kode,
                xpelunasan.bayar xpelunasan_bayar,
                mbarang.nama mbarang_nama
            FROM
                xorderd
            LEFT JOIN xorder ON xorder.kode = xorderd.ref_order
            LEFT JOIN mbarang ON xorderd.ref_brg = mbarang.kode
            INNER JOIN mcustomer ON mcustomer.kode = xorder.ref_cust
            INNER JOIN xpelunasan ON xpelunasan.ref_jual = xorder.kode
            WHERE
                xorder.void IS NOT TRUE
            AND 
                xpelunasan.posted IS TRUE
            ";
        // $q .= " AND xorder.kode NOT IN (
        //         SELECT
        //             ref_order
        //         FROM
        //             xprocorder
        //         WHERE xprocorder.void IS NOT TRUE
        //     )";
        $result     = $this->db->query($q)->result();
        echo json_encode(array('data' => $result));
    }

    public function savedata()
    {   
        $this->db->trans_begin();
        $d['useri']     = $this->session->userdata('username');
        $d['ref_brg']   = $this->input->post('ref_brg');
        $d['ref_order'] = $this->input->post('ref_order');
        $d['ref_satbrg']= $this->input->post('ref_satbrg');
        $d['tgl']       = date('Y-m-d', strtotime($this->input->post('tgl')));
        $d['jumlah']    = $this->input->post('jumlah');
        $d['ket']       = $this->input->post('ket');
        $d['ref_gud']   = $this->libre->gud_def();
        $d['status']    = '0';

        $result = $this->db->insert('xprocorder',$d);
        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            $r = array(
                'sukses' => 'fail', 
            );
        }
        else
        {
            $this->db->trans_commit();
            $r = array(
                'sukses' => 'success'
                );
        }
        echo json_encode($r);
    }

    public function edit()
    {
        $q = "SELECT 
                xprocorder.id,
                xprocorder.kode,
                to_char(xprocorder.tgl, 'DD Mon YYYY') tgl,
                xprocorder.ref_brg,
                xprocorder.ref_order,
                xprocorder.status,
                xprocorder.ket,
                mbarang.nama mbarang_nama,
                xorderd.jumlah
            FROM 
                xprocorder
            LEFT JOIN mbarang ON mbarang.kode = xprocorder.ref_brg
            LEFT JOIN xorder ON xorder.kode = xprocorder.ref_order
            LEFT JOIN xorderd ON xorderd.ref_order = xorder.kode
            WHERE xprocorder.void IS NOT TRUE
            AND xprocorder.kode = '{$this->input->post('kode')}'";
        $data   = $this->db->query($q)->row();
        echo json_encode($data);
    }

    function updatedata()
    {
        $this->db->trans_begin();
        $d['useru']     = $this->session->userdata('username');
        $d['dateu']     = 'now()';
        $d['ref_brg']   = $this->input->post('ref_brg');
        $d['ref_order'] = $this->input->post('ref_order');
        $d['ref_satbrg']= $this->input->post('ref_satbrg');
        $d['tgl']       = date('Y-m-d', strtotime($this->input->post('tgl')));
        $d['jumlah']    = $this->input->post('jumlah');
        $d['ket']       = $this->input->post('ket');
        $d['status']    = '0';
        $w['kode']      = $this->input->post('kode');
        $result         = $this->db->update('xprocorder',$d,$w);
        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            $r = array(
                'sukses' => 'fail', 
            );
        }
        else
        {
            $this->db->trans_commit();
            $r = array(
                'sukses' => 'success'
                );
        }
        echo json_encode($r);
    }

    function validdata() {
        $sql = "SELECT posted FROM xpelunasan WHERE id = {$this->input->post('id')}";
        $s = $this->db->query($sql)->row()->posted;
        (($s == 'f') || ($s == '') || ($s == null)) ? $status = 't' : $status = 'f';
        $d['posted'] = $status;
        $w['id'] = $this->input->post('id');   
        $result = $this->db->update($this->table,$d,$w);
        $r['sukses'] = $result > 0 ? 'success' : 'fail' ;
        echo json_encode($r);
    }

    function voiddata() 
    {
        $d['void'] = 't';
        $d['tglvoid'] = 'now()';
        $w['id'] = $this->input->post('id');   
        $result = $this->db->update($this->table,$d,$w);
        $r['sukses'] = $result ? 'success' : 'fail' ;
        echo json_encode($r);

    }

    public function deletedata()
    {
        $w['id'] = $this->input->post('id');
        $result = $this->db->delete($this->table,$w);
        $r['sukses'] = $result ? 'success' : 'fail' ;
        echo json_encode($r);
    }

    function cetak() {
        $kode = $this->input->get('kode');
        $done = "T";
        $wait = "F";

        $spk  = "SELECT 
                xprocorder.id,
                xprocorder.kode,
                xprocorder.tgl,
                xprocorder.ref_brg,
                xprocorder.ref_order,
                xprocorder.status,
                xprocorder.ket,
                mbarang.nama mbarang_nama,
                mlayanan.nama mlayanan_nama
            FROM 
                xprocorder
            LEFT JOIN mbarang ON mbarang.kode = xprocorder.ref_brg
            LEFT JOIN xorder ON xorder.kode = xprocorder.ref_order
            LEFT JOIN mlayanan ON mlayanan.kode = xorder.ref_layanan
            WHERE xprocorder.kode = '$kode'";

        $barang = "SELECT 
                xprocorder.id,
                xprocorder.kode,
                xprocorder.tgl,
                xprocorder.ref_brg,
                xprocorder.ref_order,
                xprocorder.status,
                xorder.kode xorder_kode,
                xorder.pathimage,
                xorderd.jumlah,
                mbarang.kode mbarang_kode,
                mbarang.nama mbarang_nama,
                mmodesign.kode mmodesign_kode,
                mmodesign.nama mmodesign_nama,
                mwarna.nama mwarna_nama,
                msatuan.nama satuan,
                mbarangs.sn,
                CASE WHEN xprocorder.status >= 0 THEN '$done' ELSE '$wait' END a,
                CASE WHEN xprocorder.status >= 1 THEN '$done' ELSE '$wait' END b,
                CASE WHEN xprocorder.status >= 2 THEN '$done' ELSE '$wait' END c,
                CASE WHEN xprocorder.status >= 3 THEN '$done' ELSE '$wait' END d,
                CASE WHEN xprocorder.status >= 4 THEN '$done' ELSE '$wait' END e
            FROM 
                xprocorder
            LEFT JOIN xorder ON xorder.kode = xprocorder.ref_order
            LEFT JOIN xorderd ON xorder.kode = xorderd.ref_order
            LEFT JOIN xorderds ON xorderd.ID = xorderds.ref_orderd
            LEFT JOIN mbarang ON mbarang.kode = xprocorder.ref_brg
            LEFT JOIN msatbrg ON msatbrg.kode = xorderd.ref_satbrg
            LEFT JOIN msatuan ON msatuan.kode = msatbrg.ref_sat
            LEFT JOIN mbarangs ON mbarang.kode = mbarangs.ref_brg
            LEFT JOIN mmodesign ON mmodesign.kode = xorderds.ref_modesign
            LEFT JOIN mwarna ON mwarna.kode = xorderds.ref_warna
            WHERE xprocorder.kode = '$kode'";

        $resspk     = $this->db->query($spk)->row();
        $resbarang  = $this->db->query($barang)->row();


        $data['title']  = "Surat Perintah Kerja";
        $data['spk']    = $resspk;
        $data['barang'] = $resbarang;
        $this->load->view($this->printpage,$data);
    }
    
}