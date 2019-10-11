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
            {"val":"agen","label":"Agen"}
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
                    mcustomer.nama agen,
                    to_char(xsuratjalan.tglkirim, 'DD Mon YYYY') tglkirim,
                    xsuratjaland.ref_brg,
                    mbarang.nama namabar,
                    xsuratjaland.jumlah,
                    msatbrg.ref_sat satuan,
                    xorder.alamat alamatkirim,
                    xorder.kurir,
                    xorder.bykirim,
                    xorder.kirimke penerima,
                    xsuratjalan.pic pengirim
                FROM
                    xsuratjalan
                JOIN xsuratjaland ON xsuratjaland.ref_suratjalan = xsuratjalan.kode
                JOIN msatbrg ON msatbrg.kode = xsuratjaland.ref_satbrg
                JOIN mbarang ON mbarang.kode = xsuratjaland.ref_brg
                JOIN xorder ON xorder.kode = xsuratjalan.ref_order
                JOIN mcustomer ON mcustomer.kode = xsuratjalan.ref_cust
                WHERE
                    xsuratjalan.posted IS TRUE
                AND xsuratjalan.void IS NOT TRUE";
        if ($st || $en) {
            $q  .=" AND
                    xsuratjalan.tgl 
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
        $data['header'] = ['Agen','Tanggal Kirim','Kode Produk','Produk','Jumlah','Satuan','Alamat Kirim','Kurir','Biaya Kirim','Penerima','Pengirim'];
        $data['body']   = ['agen','tglkirim','ref_brg','namabar','jumlah','satuan','alamatkirim','kurir','bykirim','penerima','pengirim'];
        $data['maskgb'] = $this->input->post('mask-gb');
        $data['title']  = $this->titlepage;
        $data['gb']     = $this->input->post('gb');
        $this->load->view($this->printpage,$data);
    }
    
}