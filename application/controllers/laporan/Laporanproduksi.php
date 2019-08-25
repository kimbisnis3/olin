<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Laporanproduksi extends CI_Controller {
    
    public $table       = 'laporanproduksi';
    public $indexpage   = 'laporan/prevreports';
    public $printpage   = 'laporan/mainreports';
    public $titlepage   = 'Laporan Produksi';
    function __construct() {
        parent::__construct();
        include(APPPATH.'libraries/sessionakses.php');
    }

    function index()
    {
        $setGb ='[
            {"val":"status","label":"Status"}
        ]';
        // $data['gb']             = json_decode($setGb); 
        $data['filter_date']    = 1; 
        $data['title']  = $this->titlepage;
        $this->load->view($this->indexpage,$data);
    }

    function cetak()
    {
        $st   = date('Y-m-d', strtotime($this->input->post('awal')));
        $en   = date('Y-m-d', strtotime($this->input->post('akhir')));
        $q     = "SELECT
                    mbarangs.sn kodepdx,
                    xorderd.ref_brg,
                    mbarang.nama namabar,
                    SUM (xorderd.jumlah) jumlah,
                    xorder.total,
                    msatbrg.ref_sat satuan,
                    CASE xprocorder.status
                WHEN 1 THEN
                    'Sudah Print'
                WHEN 2 THEN
                    'Sudah Cutting'
                WHEN 3 THEN
                    'Sudah Jahit'
                WHEN 4 THEN
                    'Selesai'
                END AS status
                FROM
                    xorderd
                JOIN xorder ON xorder.kode = xorderd.ref_order
                JOIN xprocorder ON xprocorder.ref_order = xorder.kode
                LEFT OUTER JOIN msatbrg ON msatbrg.kode = xorderd.ref_satbrg
                LEFT OUTER JOIN mbarang ON mbarang.kode = xorderd.ref_brg
                LEFT OUTER JOIN mbarangs ON mbarangs.ref_brg = mbarang.kode
                WHERE xprocorder.void IS NOT TRUE";
        if ($st || $en) {
            $q  .=" AND
                    xprocorder.tgl 
                BETWEEN '$st' AND '$en'";
        }
        $q .= " GROUP BY
                    mbarangs.sn,
                    xorderd.ref_brg,
                    mbarang.nama,
                    msatbrg.ref_sat,
                    xorder.total,
                    xprocorder.status";
        $q .=" ORDER BY ";
        if ($this->input->post('gb')) {
            $q .=" {$this->input->post('gb')}, ";
        }
        $q .="  mbarangs.sn,
                xprocorder.status ASC";
        $data['result']   = $this->db->query($q)->result_array();
        $data['periodestart'] = $this->input->post('awal');
        $data['periodeend']   = $this->input->post('akhir');
        $data['header'] = ['Kode Produksi','Kode Produk','Nama Produk','Jumlah','Satuan','Status'];
        $data['body']   = ['kodepdx','ref_brg','namabar','jumlah','satuan','status'];
        $data['maskgb'] = $this->input->post('mask-gb');
        $data['title']  = $this->titlepage;
        $data['gb']     = $this->input->post('gb');
        $data['usetotal']  = 1;
        $this->load->view($this->printpage,$data);
    }
    
}