<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Laporanbayar extends CI_Controller {
    
    public $table       = 'laporanbayar';
    public $indexpage   = 'laporan/prevreports';
    public $printpage   = 'laporan/mainreports';
    public $titlepage   = 'Laporan Pembayaran';
    function __construct() {
        parent::__construct();
        include(APPPATH.'libraries/sessionakses.php');
    }

    function index()
    {
        $setGb ='[
            {"val":"tgl","label":"Tanggal"},
            {"val":"mjenbayar_nama","label":"Jenis Bayar"}
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
                    xpelunasan.id,
                    xpelunasan.kode,
                    xpelunasan.tgl tgl_real,
                    to_char(xpelunasan.tgl, 'DD Mon YYYY') tgl,
                    xpelunasan.total,
                    xpelunasan.bayar,
                    xpelunasan.posted,
                    xpelunasan.ket,
                    xpelunasan.ref_jual,
                    mcustomer.nama mcustomer_nama,
                    mgudang.nama mgudang_nama,
                    mjenbayar.nama mjenbayar_nama
                FROM 
                    xpelunasan
                LEFT JOIN mcustomer ON mcustomer.kode = xpelunasan.ref_cust
                LEFT JOIN mgudang ON mgudang.kode = xpelunasan.ref_gud
                LEFT JOIN mjenbayar ON mjenbayar.kode = xpelunasan.ref_jenbayar
                WHERE xpelunasan.void IS NOT TRUE";
        if ($st || $en) {
            $q  .=" AND
                    xpelunasan.tgl 
                BETWEEN '$st' AND '$en'";
        }
        
        $data['result'] = $this->db->query($q)->result_array();
        $data['periodestart'] = $this->input->post('awal');
        $data['periodeend']   = $this->input->post('akhir');
        $data['header'] = ['Tanggal','Agen','Bayar','Total','Jenis Bayar'];
        $data['body']   = ['tgl','mcustomer_nama','bayar','total','mjenbayar_nama'];
        $data['maskgb'] = $this->input->post('mask-gb');
        $data['title']  = $this->titlepage;;
        $data['gb']     = $this->input->post('gb');
        $this->load->view($this->printpage,$data);
    }
    
}