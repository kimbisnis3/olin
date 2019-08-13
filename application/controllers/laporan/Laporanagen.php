<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Laporanagen extends CI_Controller {
    
    public $table       = 'laporanagen';
    public $indexpage   = 'laporan/laporanagen/v_laporanagen';
    public $printpage   = 'laporan/mainreports';
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
        $data['gb']     = json_decode($setGb); 
        $data['title']  = 'Laporan Data Agen';
        $this->load->view($this->indexpage,$data);
          
    }

    function cetak()
    {
        $st   = date('Y-m-d', strtotime($this->input->post('awal')));
        $en   = date('Y-m-d', strtotime($this->input->post('akhir')));
        $gb = $this->input->post('gb');
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
        $res   = $this->db->query($q)->result_array();
        // $data['periodestart'] = '@tanggal';
        // $data['periodeend']   = '@tanggal';
        $data['header'] = ['Nama','Alamat','Telp','Email','Alamat'];
        $data['body']   = ['nama','alamat','telp','email','ket'];
        $data['title']  = 'Laporan Data Agen';
        $data['gb']     = $this->input->post('gb');
        $data['result'] = $res;
        $this->load->view($this->printpage,$data);
    }
    
}