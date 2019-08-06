<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Pagecoba extends CI_Controller {
    
    // public $table       = 'm_artikel';
    public $judul       = 'Pagecoba';
    public $aktifgrup   = 'pagecoba';
    public $aktifmenu   = 'pagecoba';
    public $foldername  = 'pagecoba';
    public $indexpage   = 'pagecoba/v_pagecoba';
    function __construct() {
        parent::__construct();
        // include(APPPATH.'libraries/sessionakses.php');
        $title      = $this->judul;
    }
    public function index(){
        $data['title']      = $this->judul;
        $data['aktifgrup']  = $this->aktifgrup;
        $data['aktifmenu']  = $this->aktifmenu;
        $title      = $this->judul;
        $this->load->view($this->indexpage, $data);  
    }

    public function setView(){
        $result     = $this->Unimodel->getdata('m_artikel');
        $list       = array();
        $no         = 1;
        // foreach ($result as $r) {
        //     if ($r->artikel_image == NULL ){
        //         $gambar = "(Noimage)";
        //     } else {
        //         $gambar = "<img style='max-width : 30px;' src='.".$r->artikel_image."'>";
        //     }
        //     $row    = array(
        //                 "no"                => $no,
        //                 "artikel_kode"      => $r->artikel_kode,
        //                 "artikel_judul"     => $r->artikel_judul,
        //                 "artikel_subjudul"  => $r->artikel_subjudul,
        //                 "artikel_artikel"   => $r->artikel_artikel,
        //                 "artikel_image"     => $gambar,
        //                 "artikel_ket"       => $r->artikel_ket,
        //                 "action"            => btnud($r->artikel_id)
                        
        //     );
        //     $list[] = $row;
        //     $no++;
        // }   
        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($result));
        // echo json_encode(array('data' => $result));
    }

    public function add() {
        $data = $this->input->post('array');


        $this->db->insert_batch('m_artikel', $data); 
    }
    
}