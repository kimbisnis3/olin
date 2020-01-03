<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Laporanorder extends CI_Controller {

    public $table       = 'laporanorder';
    public $indexpage   = 'laporan/prevreports';
    public $printpage   = 'laporan/mainreports';
    public $titlepage   = 'Laporan Pesanan Agen';
    public $titlereport = 'Laporan Pesanan Agen';
    function __construct() {
        parent::__construct();
        include(APPPATH.'libraries/sessionakses.php');
        include(APPPATH.'libraries/dbinclude.php');  
    }

    function index()
    {
        $data['filter_date']    = 1;
        $data['title']  = $this->titlepage;
        $this->load->view($this->indexpage,$data);
    }

    function cetak()
    {
        $st   = date('Y-m-d', strtotime($this->input->post('awal')));
        $en   = date('Y-m-d', strtotime($this->input->post('akhir')));
        $q     = "SELECT
                    to_char(xorder.tgl, 'DD Mon YYYY') tgl,
                    xorder.kode,
                    mcustomer.nama customer_nama,
                    mbarang.nama barang_nama,
	                mwarna.nama warna_nama,
                    mlayanan.nama layanan_nama,
                    xorderd.jumlah,
                    xorderd.harga,
                    xorder.bykirim,
                    xorder.total,
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
                mjenbayar.nama jenbayar_nama,
                CASE xpelunasan.ref_jenbayar
                WHEN 'GX0003' THEN
                    xpelunasan.bayar
                ELSE
                    '0'
                END AS dp,
                CASE xpelunasan.ref_jenbayar
                WHEN 'GX0001' THEN
                    xpelunasan.bayar
                ELSE
                    '0'
                END AS lunas,
                xorder.ket
                FROM
                    xorder
                LEFT JOIN xpelunasan ON xpelunasan.ref_jual = xorder.kode
                LEFT JOIN mjenbayar ON mjenbayar.kode = xpelunasan.ref_jenbayar
                LEFT JOIN xorderd ON xorderd.ref_order = xorder.kode
                LEFT JOIN msatbrg ON msatbrg.kode = xorderd.ref_satbrg
                LEFT JOIN mbarang ON mbarang.kode = msatbrg.ref_brg
                LEFT JOIN mbarangs ON mbarang.kode = mbarangs.ref_brg
                LEFT JOIN mwarna ON mwarna.kode = mbarangs.warna
                LEFT JOIN mmodesign ON mmodesign.kode = mbarangs.model
                LEFT JOIN mcustomer ON mcustomer.kode = xorder.ref_cust
                LEFT JOIN mlayanan ON mlayanan.kode = xorder.ref_layanan";
        if ($st || $en) {
            $q  .=" AND
                    xorder.tgl
                BETWEEN '$st' AND '$en'";
        }
        $q  .=" AND xorder.ref_cust = '{$this->session->userdata('kodecust')}'";
        if ($this->input->post('gb')) {
            $q .=" ORDER BY {$this->input->post('gb')}";
        }
        $data['result']       = $this->dbtwo->query($q)->result_array();
        $data['periodestart'] = $this->input->post('awal');
        $data['periodeend']   = $this->input->post('akhir');
        $data['header'] = ['Tanggal','Kode','Agen','Jenis Order','Warna','Layanan','QTY','Harga','Ongkos Kirim','Grand Total','Status','DP','Pelunasan','Keterangan'];
        $data['body']   = ['tgl','kode','customer_nama','barang_nama','warna_nama','layanan_nama','jumlah','harga','bykirim','total','status_nama','dp','lunas','ket'];
        $data['maskgb'] = $this->input->post('mask-gb');
        $data['title']  = $this->titlereport;
        $data['gb']     = $this->input->post('gb');
        $this->load->view($this->printpage,$data);
    }
}
