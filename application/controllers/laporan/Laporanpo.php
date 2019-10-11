<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Laporanpo extends CI_Controller {
    
    public $table       = 'laporanpo';
    public $indexpage   = 'laporan/prevreports';
    public $printpage   = 'laporan/mainreports';
    public $titlepage   = 'Laporan Purchase Order';
    function __construct() {
        parent::__construct();
        include(APPPATH.'libraries/sessionakses.php');
    }

    function index()
    {
        $setGb ='[
            {"val":"agen","label":"Agen"},
            {"val":"layanan","label":"Layanan"},
            {"val":"status_nama","label":"Status"}
        ]';
        $data['gb']             = json_decode($setGb); 
        $data['filter_date']    = 1; 
        $data['title']  = $this->titlepage;
        $this->load->view($this->indexpage,$data);
    }

    function cetak()
    {
        $st         = date('Y-m-d', strtotime($this->input->post('awal')));
        $en         = date('Y-m-d', strtotime($this->input->post('akhir')));
        $ref_cust   = $this->input->post('ref_cust');
        $q     = "SELECT
                    xorder.kode,
                    to_char(xorder.tgl, 'DD Mon YYYY') tgl,
                    xorder.ref_cust,
                    mcustomer.nama agen,
                    xorder.ref_layanan,
                    mlayanan.nama layanan,
                    xorder.total,
                    xorder.status,
                    CASE xorder.status
                WHEN 0 THEN
                    'Pending'
                WHEN 1 THEN
                    'Proses Produksi'
                WHEN 2 THEN
                    'Proses Produksi'
                WHEN 3 THEN
                    'Proses Produksi'
                WHEN 4 THEN
                    'Ready'
                WHEN 5 THEN
                    'Sudah Dikirim'
                END AS status_nama,
                 xorder.ket
                FROM
                    xorder
                LEFT OUTER JOIN mcustomer ON mcustomer.kode = xorder.ref_cust
                LEFT OUTER JOIN mlayanan ON mlayanan.kode = xorder.ref_layanan
                WHERE
                    xorder.void IS NOT TRUE";
        if ($st || $en) {
            $q  .=" AND
                    xorder.tgl 
                BETWEEN '$st' AND '$en'";
        }
        if ($ref_cust) {
            $q  .=" AND xorder.ref_cust = '$ref_cust'";
        }
        if ($this->input->post('gb')) {
            $q .=" ORDER BY {$this->input->post('gb')}";
        }
        $data['result'] = $this->db->query($q)->result_array();
        $data['periodestart'] = $this->input->post('awal');
        $data['periodeend']   = $this->input->post('akhir');
        $data['header'] = ['Kode','Tanggal','Agen','Layanan','Total','Status','Keterangan'];
        $data['body']   = ['kode','tgl','agen','layanan','total','status_nama','ket'];
        $data['maskgb'] = $this->input->post('mask-gb');
        $data['title']  = $this->titlepage;;
        $data['gb']     = $this->input->post('gb');
        $this->load->view($this->printpage,$data);
    }
    
}