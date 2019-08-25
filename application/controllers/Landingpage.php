<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Landingpage extends CI_Controller {
    
    public $table       = '';
    public $judul       = 'Dashboard';
    public $aktifgrup   = '';
    public $aktifmenu   = '';
    public $foldername  = '';
    public $indexpage   = 'v_landingpage.php';

    function __construct() {
        parent::__construct();
        include(APPPATH.'libraries/sessionakses.php');
        $title      = $this->judul;
    }

    public function index(){
        $data['title']      = $this->judul;
        $data['aktifgrup']  = $this->aktifgrup;
        $data['aktifmenu']  = $this->aktifmenu;
        $title      = $this->judul;
        $q_po_pending   = "SELECT
                            COUNT (*)
                        FROM
                            xorder
                        WHERE
                            void IS NOT TRUE
                        AND status = 0";
        $q_po_proses    = "SELECT
                            COUNT (*)
                        FROM
                            xorder
                        WHERE
                            void IS NOT TRUE
                        AND status > 0
                        AND status < 4";
        $q_po_ready     = "SELECT
                            COUNT (*)
                        FROM
                            xorder
                        WHERE
                            void IS NOT TRUE
                        AND status = 4";

        $data['po_pending'] =  $this->db->query($q_po_pending)->row();
        $data['po_proses']  =  $this->db->query($q_po_proses)->row();
        $data['po_ready']   =  $this->db->query($q_po_ready)->row();
        
        $this->load->view($this->indexpage, $data);  
    }

    

}
