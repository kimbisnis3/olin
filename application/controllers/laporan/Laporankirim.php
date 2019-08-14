<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Laporankirim extends CI_Controller {
    
    public $table       = 'laporanagen';
    public $indexpage   = 'laporan/prevreports';
    public $printpage   = 'laporan/mainreports';
    public $titlepage   = 'Laporan Pengiriman';
    function __construct() {
        parent::__construct();
        include(APPPATH.'libraries/sessionakses.php');
    }

    function index()
    {
        $setGb ='[
            {"val":"mcustomer_nama","label":"Agen"},
            {"val":"mbarang_nama","label":"Produk"},
            {"val":"tgl","label":"Tanggal"}
        ]';
        $data['gb']             = json_decode($setGb); 
        $data['filter_date']    = 1; 
        $data['title']  = $this->titlepage;
        $this->load->view($this->indexpage,$data);
    }

    function cetak()
    {
        $st   = date('Y-m-d', strtotime($this->input->post('awal')));
        $en   = date('Y-m-d', strtotime($this->input->post('akhir')));
        $q     = "SELECT
                xsuratjalan.id,
                xsuratjalan.kode,
                to_char(xsuratjalan.tgl, 'DD Mon YYYY') tgl,
                to_char(xsuratjalan.tglkirim, 'DD Mon YYYY') tglkirim,
                xsuratjalan.kirim,
                xsuratjalan.biayakirim,
                xsuratjalan.ref_cust,
                xsuratjalan.ket,
                xsuratjalan.posted,
                mcustomer.nama mcustomer_nama,
                mbarang.nama mbarang_nama,
                mbarang.ket mbarang_ket,
                msatbrg.harga msatbrg_harga,
                msatbrg.ref_brg msatbrg_ref_brg,
                msatbrg.ref_sat msatbrg_ref_sat,
                msatuan.nama satuan
            FROM
                xsuratjalan
            LEFT JOIN mcustomer ON mcustomer.kode = xsuratjalan.ref_cust
            LEFT JOIN xsuratjaland ON xsuratjaland.ref_suratjalan = xsuratjalan.kode
            LEFT JOIN mbarang ON mbarang.kode = xsuratjaland.ref_brg
            LEFT JOIN msatbrg ON msatbrg.kode = xsuratjaland.ref_satbrg
            LEFT JOIN msatuan ON msatuan.kode = msatbrg.ref_sat
            WHERE xsuratjalan.void IS NOT TRUE";
        if ($st || $en) {
            $q  .=" AND
                    xsuratjalan.tgl 
                BETWEEN '$st' AND '$en'";
        }
        $data['result'] = $this->db->query($q)->result_array();
        $data['periodestart'] = $this->input->post('awal');
        $data['periodeend']   = $this->input->post('akhir');
        $data['header'] = ['Tanggal','Kirim','Tanggal Kirim','Agen','Produk','Harga','Satuan'];
        $data['body']   = ['tgl','kirim','tglkirim','mcustomer_nama','mbarang_nama','msatbrg_harga','satuan'];
        $data['title']  = $this->titlepage;;
        $data['gb']     = $this->input->post('gb');
        $this->load->view($this->printpage,$data);
    }
    
}