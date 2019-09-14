<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Laporanbayaragen extends CI_Controller {
    
    public $table       = 'laporanbayaragen';
    public $indexpage   = 'laporan/prevreports';
    public $printpage   = 'laporan/mainreports';
    public $titlepage   = 'Laporan Pembayaran Agen';
    public $titlereport = 'Laporan Pembayaran';
    function __construct() {
        parent::__construct();
        include(APPPATH.'libraries/sessionakses.php');
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
                            xorder.ket
                        FROM
                            xpelunasan
                        JOIN xorder ON xorder.kode = xpelunasan.ref_jual
                        LEFT OUTER JOIN mcustomer ON mcustomer.kode = xpelunasan.ref_cust
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
        $q  .=" AND qr.ref_cust = '{$this->session->userdata('kodecust')}'";
        $q .=" ORDER BY ";
        if ($this->input->post('gb')) {
            $q .=" {$this->input->post('gb')}, ";
        }
        $q .=" qr.agen, qr.tgl, qr.kode";
        $data['result'] = $this->db->query($q)->result_array();
        $data['periodestart'] = $this->input->post('awal');
        $data['periodeend']   = $this->input->post('akhir');
        $data['header'] = ['Tanggal','Kode','Total','Dibayar','Keterangan','Kekurangan'];
        $data['body']   = ['tgl_char','kode','total','dibayar','ket','kekurangan'];
        $data['maskgb'] = $this->input->post('mask-gb');
        $data['title']  = $this->titlereport;
        $data['gb']     = $this->input->post('gb');
        $this->load->view($this->printpage,$data);
    }
    
}