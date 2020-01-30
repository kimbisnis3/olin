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
            {"val":"customer_nama","label":"Agen"},
            {"val":"layanan_nama","label":"Layanan"},
            {"val":"ketlunas","label":"Status"}
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
                    xorder.tgl tgl,
                    mcustomer.nama customer_nama,
                    mbarang.nama barang_nama,
                    mlayanan.nama layanan_nama,
                    xorder.tgl + INTEGER '15'  dateline,
                    xorderd.jumlah,
                    xorderd.harga,
                    xorder.bykirim,
                    xorder.total,
                    xorder.ket,
                CASE xpelunasan.ref_jenbayar
                WHEN 'GX0003' THEN
                    xpelunasan.bayar
                ELSE
                    '0'
                END AS dp,
                 CASE xpelunasan.ref_jenbayar
                WHEN 'GX0003' THEN
                    xpelunasan.tgl
                ELSE
                    NULL
                END AS tgldp,
                 CASE xpelunasan.ref_jenbayar
                WHEN 'GX0001' THEN
                    xpelunasan.bayar
                ELSE
                    '0'
                END AS lunas,
                CASE xpelunasan.ref_jenbayar
                WHEN 'GX0001' THEN
                    xpelunasan.tgl
                ELSE
                    null
                END AS tgllunas,
                CASE xpelunasan.ref_jenbayar
                WHEN 'GX0001' THEN
                    'LUNAS'
                ELSE
                    'BELUM LUNAS'
                END AS ketlunas
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
                LEFT JOIN mlayanan ON mlayanan.kode = xorder.ref_layanan
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
        $data['header'] = ['KODE','TANGGAL','AGEN','JENIS ORDER','LAYANAN','DATELINE','QTY','HARGA','ONGKIR','GRAND TOTAL','DP','TGL DP','PELUNASAN','TGL PELUNASAN','KET LUNAS', 'KET'];
        $data['body']   = ['kode','tgl','customer_nama','barang_nama','layanan_nama','dateline','jumlah','harga','bykirim','total','dp','tgldp','lunas','tgllunas','ketlunas','ket'];
        $data['maskgb'] = $this->input->post('mask-gb');
        $data['title']  = $this->titlepage;;
        $data['gb']     = $this->input->post('gb');
        $this->load->view($this->printpage,$data);
    }

    // function cetak()
    // {
    //     $st         = date('Y-m-d', strtotime($this->input->post('awal')));
    //     $en         = date('Y-m-d', strtotime($this->input->post('akhir')));
    //     $ref_cust   = $this->input->post('ref_cust');
    //     $q     = "SELECT
    //                 xorder.kode,
    //                 to_char(xorder.tgl, 'DD Mon YYYY') tgl,
    //                 xorder.ref_cust,
    //                 mcustomer.nama agen,
    //                 xorder.ref_layanan,
    //                 mlayanan.nama layanan,
    //                 xorder.total,
    //                 xorder.status,
    //                 CASE xorder.status
    //             WHEN 0 THEN
    //                 'Pending'
    //             WHEN 1 THEN
    //                 'Proses Produksi'
    //             WHEN 2 THEN
    //                 'Proses Produksi'
    //             WHEN 3 THEN
    //                 'Proses Produksi'
    //             WHEN 4 THEN
    //                 'Ready'
    //             WHEN 5 THEN
    //                 'Sudah Dikirim'
    //             END AS status_nama,
    //              xorder.ket
    //             FROM
    //                 xorder
    //             LEFT OUTER JOIN mcustomer ON mcustomer.kode = xorder.ref_cust
    //             LEFT OUTER JOIN mlayanan ON mlayanan.kode = xorder.ref_layanan
    //             WHERE
    //                 xorder.void IS NOT TRUE";
    //     if ($st || $en) {
    //         $q  .=" AND
    //                 xorder.tgl
    //             BETWEEN '$st' AND '$en'";
    //     }
    //     if ($ref_cust) {
    //         $q  .=" AND xorder.ref_cust = '$ref_cust'";
    //     }
    //     if ($this->input->post('gb')) {
    //         $q .=" ORDER BY {$this->input->post('gb')}";
    //     }
    //     $data['result'] = $this->db->query($q)->result_array();
    //     $data['periodestart'] = $this->input->post('awal');
    //     $data['periodeend']   = $this->input->post('akhir');
    //     $data['header'] = ['Kode','Tanggal','Agen','Layanan','Total','Status','Keterangan'];
    //     $data['body']   = ['kode','tgl','agen','layanan','total','status_nama','ket'];
    //     $data['maskgb'] = $this->input->post('mask-gb');
    //     $data['title']  = $this->titlepage;;
    //     $data['gb']     = $this->input->post('gb');
    //     $this->load->view($this->printpage,$data);
    // }

}
