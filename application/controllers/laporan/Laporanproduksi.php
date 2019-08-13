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
            {"val":"mjencust_nama","label":"Jenis Agen"},
            {"val":"nama","label":"Nama"},
            {"val":"alamat","label":"Alamat"}
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
                mcustomer.nama,
                mcustomer.alamat,
                mcustomer.telp,
                mcustomer.email,
                mcustomer.pic,
                mcustomer.ket,
                mjencust.nama mjencust_nama
            FROM
                mcustomer
            LEFT JOIN mjencust ON mjencust.kode = mcustomer.ref_jenc";
        $data['result']   = $this->db->query($q)->result_array();
        $data['periodestart'] = $this->input->post('awal');
        $data['periodeend']   = $this->input->post('akhir');
        $data['header'] = ['Nama','Alamat','Telp','Email','Alamat'];
        $data['body']   = ['nama','alamat','telp','email','ket'];
        $data['title']  = $this->titlepage;;
        $data['gb']     = $this->input->post('gb');
        $this->load->view($this->printpage,$data);
    }
    
}