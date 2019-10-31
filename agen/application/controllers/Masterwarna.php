<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Masterwarna extends CI_Controller {
    
    public $table       = 'mwarna';
    public $foldername  = 'warna';
    public $indexpage   = 'masterwarna/v_masterwarna';
    public $printpage   = 'masterwarna/p_masterwarna';
    function __construct() {
        parent::__construct();
        include(APPPATH.'libraries/sessionakses.php');
        include(APPPATH.'libraries/dbinclude.php');  
    }
    function index(){
        $this->load->view($this->indexpage);  
    }

    public function getall(){
        $result     = $this->dbtwo->get($this->table)->result();
        $no         = 1;
        $list       = [];
        foreach ($result as $r) {
            $row['id']      = $r->id;
            $row['no']      = $no;
            $row['nama']    = $r->nama;
            $row['colorc']  = "<div style='witdh:10px; height:20px; background-color:".$r->colorc."' ></div>";
            $row['ket']     = $r->ket;

            $list[] = $row;
            $no++;
        }   
        echo json_encode(array('data' => $list));
    }

    public function savedata()
    {   
        $d['useri']     = $this->session->userdata('username');
        $d['nama']      = $this->input->post('nama');
        $d['colorc']    = $this->input->post('kodewarna');
        $d['ket']       = $this->input->post('ket');

        $result = $this->dbtwo->insert($this->table,$d);
        $r['sukses'] = $result ? 'success' : 'fail' ;
        echo json_encode($r);
    }

    public function edit()
    {
        $w['id']= $this->input->post('id');
        $data   = $this->dbtwo->get_where($this->table,$w)->row();
        echo json_encode($data);
    }

    public function getselects()
    {
        $data   = $this->dbtwo->get($this->table)->result();
        echo json_encode($data);
    }

    function updatedata(){
        $d['useru']     = $this->session->userdata('username');
        $d['dateu']     = 'now()';
        $d['nama']      = $this->input->post('nama');
        $d['colorc']    = $this->input->post('kodewarna');
        $d['ket']       = $this->input->post('ket');
        $w['id'] = $this->input->post('id');
        $result = $this->dbtwo->update($this->table,$d,$w);
        $r['sukses'] = $result ? 'success' : 'fail' ;
        echo json_encode($r);
    }

    public function deletedata()
    {
        $w['id'] = $this->input->post('id');
        $result = $this->dbtwo->delete($this->table,$w);
        $r['sukses'] = $result ? 'success' : 'fail' ;
        echo json_encode($r);
    }

    function cetak(){
      $useGroupBy = 1;
      $header = ['No','Kode','Nama','Kode Warna','Keterangan'];
      $q      = "SELECT * FROM mwarna";
      $body   = $this->dbtwo->query($q)->result_array();
      $data['title']    = 'Laporan Warna';
      $data['periodestart'] = '@tanggal';
      $data['periodeend']   = '@tanggal';
      $data['header'] = $header;
      $data['body']   = $body;
      $this->load->view($this->printpage,$data); 
    }
    
}