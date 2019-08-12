<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Laporanagen extends CI_Controller {
    
    public $table       = 'laporanagen';
    public $foldername  = 'warna';
    public $indexpage   = 'laporan/laporanagen/v_laporanagen';
    public $printpage   = 'laporan/laporanagen/p_laporanagen';
    function __construct() {
        parent::__construct();
        include(APPPATH.'libraries/sessionakses.php');
    }
    function index(){
        $this->load->view($this->indexpage);  
    }

    function cetak(){
      $useGroupBy = 1;
      $header = ['No','Nama','Alamat','Telp','Email','PIC','Nama Agen'];
      $q      = "SELECT
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
      $body   = $this->db->query($q)->result();
      $data['title']    = 'Laporan Data Agen';
      $data['periodestart'] = '@tanggal';
      $data['periodeend']   = '@tanggal';
      $data['header'] = $header;
      $data['body']   = $body;
      $this->load->view($this->printpage,$data); 
    }
    
}