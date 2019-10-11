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
                    qr.*, (qr.total - qr.dibayar) kekurangan
                FROM
                    (
                        SELECT
                            mcustomer.nama agen,
                            xorder.tgl,
                            to_char(xorder.tgl, 'DD Mon YYYY') tgl_char,
                            xorder.kode,
                            xorder.ref_cust,
                            COALESCE (xorder.total, 0) total,
                            COALESCE (SUM(xpelunasan.bayar), 0) dibayar,
                            xorder.ket,
                            STRING_AGG (mjenbayar.nama, ', ') jenisbayar
                        FROM
                            xpelunasan
                        JOIN xorder ON xorder.kode = xpelunasan.ref_jual
                        LEFT OUTER JOIN mcustomer ON mcustomer.kode = xpelunasan.ref_cust
                        JOIN mjenbayar ON mjenbayar.kode = xpelunasan.ref_jenbayar
                        WHERE
                            xorder.void IS NOT TRUE
                        AND xpelunasan.void IS NOT TRUE
                        GROUP BY
                            xorder.kode,
                            xorder.tgl,
                            xorder.total,
                            xorder.ref_cust,
                            mcustomer.nama,
                            xorder.ket
                    ) qr";
        if ($st || $en) {
            $q  .=" WHERE
                    qr.tgl 
                BETWEEN '$st' AND '$en'";
        }
        if ($ref_cust) {
            $q  .=" AND qr.ref_cust = '$ref_cust'";
        }
        $q .=" ORDER BY ";
        if ($this->input->post('gb')) {
            $q .=" {$this->input->post('gb')}, ";
        }
        $q .=" qr.agen, qr.tgl, qr.kode";
        $data['result'] = $this->db->query($q)->result_array();
        $data['periodestart'] = $this->input->post('awal');
        $data['periodeend']   = $this->input->post('akhir');
        $data['header'] = ['Agen','Tanggal','Kode','Total','Dibayar','Keterangan','Kekurangan','Jenis Bayar'];
        $data['body']   = ['agen','tgl_char','kode','total','dibayar','ket','kekurangan','jenisbayar'];
        $data['maskgb'] = $this->input->post('mask-gb');
        $data['title']  = $this->titlepage;;
        $data['gb']     = $this->input->post('gb');
        $this->load->view($this->printpage,$data);
    }
    
}