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
            {"val":"mcustomer_nama","label":"Agen"},
            {"val":"tgl","label":"Tanggal"},
            {"val":"mkirim_nama","label":"Metode Kirim"},
            {"val":"layanan_nama","label":"Layanan"},
            {"val":"kurir","label":"Kurir"}
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
                    xorder. ID,
                    xorder.kode,
                    to_char(xorder.tgl, 'DD Mon YYYY') tgl,
                    xorder.ket,
                    xorder.pic,
                    xorder.kgkirim,
                    xorder.bykirim,
                    xorder.ref_layanan,
                    xorder.kurir,
                    xorder.lokasidari,
                    xorder.lokasike,
                    xorder.pathcorel,
                    xorder.pathimage,
                    mcustomer.nama mcustomer_nama,
                    mkirim.nama mkirim_nama,
                    mlayanan.nama layanan_nama
                FROM
                    xorder
                LEFT JOIN mcustomer ON mcustomer.kode = xorder.ref_cust
                LEFT JOIN mkirim ON mkirim.kode = xorder.ref_kirim
                LEFT JOIN mlayanan ON mlayanan.kode = xorder.ref_layanan
                WHERE
                    xorder.void IS NOT TRUE";
        if ($st || $en) {
            $q  .=" AND
                    xorder.tgl 
                BETWEEN '$st' AND '$en'";
        }
        $data['result'] = $this->db->query($q)->result_array();
        $data['periodestart'] = $this->input->post('awal');
        $data['periodeend']   = $this->input->post('akhir');
        $data['header'] = ['Tanggal','Agen','Metode','Layanan','Kurir','Lokasi','Kg','Biaya Kirim','Keterangan'];
        $data['body']   = ['tgl','mcustomer_nama','mkirim_nama','layanan_nama','kurir','lokasike','kgkirim','bykirim','ket'];
        $data['maskgb'] = $this->input->post('mask-gb');
        $data['title']  = $this->titlepage;;
        $data['gb']     = $this->input->post('gb');
        $this->load->view($this->printpage,$data);
    }
    
}