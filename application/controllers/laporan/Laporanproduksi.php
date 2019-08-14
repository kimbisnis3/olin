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
                WHERE xprocorder.void IS NOT TRUE";
        if ($st || $en) {
            $q  .=" AND
                    xprocorder.tgl 
                BETWEEN '$st' AND '$en'";
        }
        $data['result']   = $this->db->query($q)->result_array();
        $data['periodestart'] = $this->input->post('awal');
        $data['periodeend']   = $this->input->post('akhir');
        $data['header'] = ['Tanggal','Produk','Kode PO','Status','Keterangan'];
        $data['body']   = ['tgl','mbarang_nama','ref_order','status','ket'];
        $data['title']  = $this->titlepage;
        $data['gb']     = $this->input->post('gb');
        $this->load->view($this->printpage,$data);
    }
    
}