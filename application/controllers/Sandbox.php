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
        $res = $this->db->get('mwarna')->result_array();
        $headers = $this->input->request_headers();
        echo json_encode(
          array(
            'data'    => $res, 
            'status'  => 'success',
            'header'  => $headers
        ));
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

    function contoharray() {
        $config = array(
           array( "header" => "ID", "body" => "id" ),
           array( "header" => "Kode", "body" => "kode" ),
           array( "header" => "Useri", "body" => "useri" )
        );
        $result = $this->db->get('xorder')->result_array();
        foreach ($config as $i => $v)  
        {
          echo $v['header'];
        }
        foreach ($result as $i => $t) {
          foreach ($config as $i => $v) {
            echo $t[$v['body']]."<br>";
          }
        }
    }

    function mapdir() {
      $this->load->helper('directory');
      $map = directory_map('./uploads');
      print_r($map);
    }

}