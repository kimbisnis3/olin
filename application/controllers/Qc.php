<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Qc extends CI_Controller {
    
    public $table       = 'xprocorder';
    public $foldername  = 'spk';
    public $indexpage   = 'qc/v_qc_jquery';
    function __construct() {
        parent::__construct();
        include(APPPATH.'libraries/sessionakses.php');
    }
    function index(){
        $data['jenisbayar'] = $this->db->get('mjenbayar')->result();
        $this->load->view($this->indexpage,$data);
    }

    public function getall(){
        $done = "T";
        $wait = "F";
        $filterawal = date('Y-m-d', strtotime($this->input->post('filterawal')));
        $filterakhir = date('Y-m-d', strtotime($this->input->post('filterakhir')));
        $filterstatus = $this->input->post('filterstatus');
        $filteragen = $this->input->post('filteragen');
        $q = "SELECT 
                xprocorder.id,
                xprocorder.kode,
                xprocorder.tgl,
                xprocorder.ref_brg,
                xprocorder.ref_order,
                xprocorder.status,
                xorder.kode xorder_kode,
                xorder.pathimage,
                mbarang.nama mbarang_nama,
                CASE WHEN xprocorder.status >= 0 THEN '$done' ELSE '$wait' END a,
                CASE WHEN xprocorder.status >= 1 THEN '$done' ELSE '$wait' END b,
                CASE WHEN xprocorder.status >= 2 THEN '$done' ELSE '$wait' END c,
                CASE WHEN xprocorder.status >= 3 THEN '$done' ELSE '$wait' END d,
                CASE WHEN xprocorder.status >= 4 THEN '$done' ELSE '$wait' END e
            FROM 
                xprocorder
            LEFT JOIN mbarang ON mbarang.kode = xprocorder.ref_brg
            LEFT JOIN xorder ON xorder.kode = xprocorder.ref_order
            WHERE
                xprocorder.tgl x
            BETWEEN '$filterawal' AND '$filterakhir'
            AND xprocorder.void IS NOT TRUE";
        if ($filterstatus) {
            $q .=" AND xprocorder.status <= '$filterstatus'";
        }
        if ($filteragen) {
            $q .= " AND xorder.ref_cust = '$filteragen'";
        }
        $q .= " ORDER BY xprocorder.id DESC";
        $result     = $this->db->query($q)->result();
        $list       = [];
        foreach ($result as $i => $r) {
            $row['id']          = $r->id;
            $row['kode']        = $r->kode;
            $row['tgl']         = $r->tgl;
            $row['ref_brg']     = $r->ref_brg;
            $row['ref_order']   = $r->ref_order);
            $row['status']      = $r->status;
            $row['xorder_kode'] = $r->xorder_kode;
            $row['pathimage']   = $r->pathimage;
            $row['a']= $r->a;
            $row['b']= $r->b;
            $row['c']= $r->c;
            $row['d']= $r->d;
            $row['e']= $r->e;
            $list[] = $row;
        }   
        echo json_encode(array('data' => $list));
        echo json_encode(array('data' => $result));
    }

    function do_qc() {
        $sql = "SELECT status FROM xprocorder WHERE id = {$this->input->post('id')}";
        $s = $this->db->query($sql)->row()->status;
        $d['status'] = $s + 1;
        $w['id']    = $this->input->post('id');   
        $result     = $this->db->update('xprocorder',$d,$w);
        $r['sukses'] = $result > 0 ? 'success' : 'fail' ;
        echo json_encode($r);
    }

    function ada() {
        $path = "./agen/uploads/po/img-1566493068.png";
        // $res = file_exists(base_url()."/agen/uploads/po/img-1566493068.png");
        // return is_file($path) && file_exists($path);

        // if (file_exists($path)) {
        //     echo 'File exist'; 
        // }

        if (file_exists($path)) {
            echo "The file exists";
        } else {
            echo "The file does not exist";
        }

    }
    
}