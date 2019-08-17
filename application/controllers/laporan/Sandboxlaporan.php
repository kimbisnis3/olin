<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Sandboxlaporan extends CI_Controller {
    
    public $table       = 'laporanagen';
    public $indexpage   = 'laporan/prevreports';
    public $printpage   = 'laporan/mainreports';
    public $titlepage   = 'Laporan Data Agen';
    function __construct() {
        parent::__construct();
        // include(APPPATH.'libraries/sessionakses.php');
    }
    function index()
    {
        $setGb ='[
            {"val":"mjencust_nama","label":"Jenis Agen"},
            {"val":"nama","label":"Nama"},
            {"val":"alamat","label":"Alamat"}
        ]';
        $data['gb']     = json_decode($setGb); 
        $data['title']  = $this->titlepage;
        $this->load->view($this->indexpage,$data);
          
    }

    function cetak()
    {
        $a = $this->input->post();
        $q = "SELECT
              xorder.*
            FROM
                xorder
            WHERE xorder.tgl BETWEEN param_start_date AND param_end_date ";

        $query = query_to_var($q,$a);

        $arr = $this->db->query($query)->result();
        $find  = array_values($arr);
        $keyfromquery = array_keys((array)$find[0]);
        //print field name from query result
        // foreach ($keyfromquery as $i => $v) {
        //     echo $v;
        // }
        echo $arr ;

        //this work when param_ replacing to some value wich extrated from query_to_var.
    }
    
}