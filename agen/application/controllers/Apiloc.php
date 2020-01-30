<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Apiloc extends CI_Controller
{
    public $table       = '';
    public $foldername  = '';

    function __construct()
    {
        parent::__construct();
        include(APPPATH . 'libraries/dbinclude.php');
    }

    function getprov()
    {
        $response = db_get('mprov')->result_array();
        echo json_encode(
          array(
            'data'    => $response,
            'status'  => 'success'
        ));
    }

    function getcity()
    {
        $kodeprov   = eget('kodeprov');
        $response   = db_get_where('mkabkota', array('ref_mprov' => $kodeprov))->result_array();
        echo json_encode(
          array(
            'data'    => $response,
            'status'  => 'success'
        ));
    }

    function getkec()
    {
        $kodecity   = eget('kodecity');
        $response   = db_get_where('mkec', array('ref_mkabkota' => $kodecity))->result_array();
        echo json_encode(
          array(
            'data'    => $response,
            'status'  => 'success'
        ));
    }

    function getkel()
    {
        $kodekec    = eget('kodekec');
        $response = db_get_where('mkel', array('ref_mkec' => $kodekec))->result_array();
        echo json_encode(
          array(
            'data'    => $response,
            'status'  => 'success'
        ));
    }
}
