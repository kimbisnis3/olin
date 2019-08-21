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

    function req_province() {
        $response = $this->libre->get_province_ro();
        $raw = json_decode($response, true); 
        $data = $raw['rajaongkir']['results'];
        echo json_encode(
          array(
            'data'    => $data, 
            'status'  => 'success'
        ));
    }

    function request_city() {
        $provincecode = $this->input->get('province');
        $response = $this->libre->get_city_ro($provincecode);
        $raw = json_decode($response, true); 
        $data = $raw['rajaongkir']['results'];
        echo json_encode($data);

    }

    function request_ongkir() {
        $origin         = $this->input->get('origin'); 
        $destination    = $this->input->get('destination'); 
        $weight         = $this->input->get('weight') * 1000;
        $courier        = $this->input->get('courier');
        $response = $this->libre->get_ongkir_ro($origin,$destination,$weight,$courier);
        $raw = json_decode($response, true); 
        $data = $raw['rajaongkir']['results'][0]['costs'];
        echo json_encode($data);
        
    }

    function contoharraybanyak() {
        $companies = array(
           array( "label" => "JAVA", "value" => "1" ),
           array( "label" => "DATA IMAGE PROCESSING", "value" => "2" ),
           array( "label" => "JAVASCRIPT", "value" => "3" ),
           array( "label" => "DATA MANAGEMENT SYSTEM", "value" => "4" ),
           array( "label" => "COMPUTER PROGRAMMING", "value" => "5" ),
           array( "label" => "SOFTWARE DEVELOPMENT LIFE CYCLE", "value" => "6" ),
           array( "label" => "LEARN COMPUTER FUNDAMENTALS", "value" => "7" ),
           array( "label" => "IMAGE PROCESSING USING JAVA", "value" => "8" ),
           array( "label" => "CLOUD COMPUTING", "value" => "9" ),
           array( "label" => "DATA MINING", "value" => "10" ),
           array( "label" => "DATA WAREHOUSE", "value" => "11" ),
           array( "label" => "E-COMMERCE", "value" => "12" ),
           array( "label" => "DBMS", "value" => "13" ),
           array( "label" => "HTTP", "value" => "14" )
            
        );
    }

    function mapdir() {
      $this->load->helper('directory');
      $map = directory_map('./uploads');
      print_r($map);
    }
    
}