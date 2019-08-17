<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Sandbox extends CI_Controller {
    
    public $table       = 'xprocorder';
    public $foldername  = 'spk';
    public $indexpage   = 'sandbox/v_sandbox';
    function __construct() {
        parent::__construct();
        include(APPPATH.'libraries/sessionakses.php');
    }
    function index(){
        $data['jenisbayar'] = $this->db->get('mjenbayar')->result();
        $this->load->view($this->indexpage,$data);
    }

    function tes() {
        $res = $this->db->get('mwarna')->result();
        echo json_encode($res);
    }

    function request_province() {
        $response = $this->libre->get_province_ro();
        $raw = json_decode($response, true); 
        $data = $raw['rajaongkir']['results'];
        echo json_encode($data);

    }

    function request_city() {
        $provincecode = $this->input->get('province');
        $response = $this->libre->get_city_ro($provincecode);
        echo $response ;

    }

    function request_ongkir() {
        $origin         = $this->input->get('origin'); 
        $destination    = $this->input->get('destination'); 
        $weight         = $this->input->get('weight') * 1000;
        $courier        = $this->input->get('courier');
        $response = $this->libre->get_ongkir_ro($origin,$destination,$destination,$courier);
        echo $response ;
        
    }
    
}