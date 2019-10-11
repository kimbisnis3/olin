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
        $q = "SELECT DISTINCT
                xprocorder.id,
                xprocorder.kode,
                xprocorder.tgl,
                xprocorder.ref_brg,
                xprocorder.ref_order,
                xprocorder.status,
                xorder.kode xorder_kode,
                xorder.pathimage,
                xorderd.jumlah,
                mbarang.nama mbarang_nama,
                msatuan.nama msatuan_nama,
                CASE WHEN xprocorder.status >= 0 THEN '$done' ELSE '$wait' END a,
                CASE WHEN xprocorder.status >= 1 THEN '$done' ELSE '$wait' END b,
                CASE WHEN xprocorder.status >= 2 THEN '$done' ELSE '$wait' END c,
                CASE WHEN xprocorder.status >= 3 THEN '$done' ELSE '$wait' END d,
                CASE WHEN xprocorder.status >= 4 THEN '$done' ELSE '$wait' END e
            FROM 
                xprocorder
            LEFT JOIN mbarang ON mbarang.kode = xprocorder.ref_brg
            LEFT JOIN msatbrg ON mbarang.kode = msatbrg.ref_brg
            LEFT JOIN msatuan ON msatuan.kode = msatbrg.ref_sat
            LEFT JOIN xorder ON xorder.kode = xprocorder.ref_order
            LEFT JOIN xorderd ON xorder.kode = xorderd.ref_order
            WHERE
                xprocorder.tgl
            BETWEEN '$filterawal' AND '$filterakhir'
            AND msatbrg.def = 't'
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
            $row['ref_order']   = $r->ref_order;
            $row['jumlah']      = $r->jumlah;
            $row['status']      = $r->status;
            $row['xorder_kode'] = $r->xorder_kode;
            $row['pathimage']   = imgerr($r->pathimage);
            $row['mbarang_nama']= $r->mbarang_nama;
            $row['msatuan_nama']= $r->msatuan_nama;
            $row['a']           = $r->a;
            $row['b']           = $r->b;
            $row['c']           = $r->c;
            $row['d']           = $r->d;
            $row['e']           = $r->e;
            $list[] = $row;
        }   
        echo json_encode(array('data' => $list));
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

    function do_anti_qc() {
        $sql = "SELECT status FROM xprocorder WHERE id = {$this->input->post('id')}";
        $s = $this->db->query($sql)->row()->status;
        $d['status'] = $s - 1;
        $w['id']    = $this->input->post('id');   
        $result     = $this->db->update('xprocorder',$d,$w);
        $r['sukses'] = $result > 0 ? 'success' : 'fail' ;
        echo json_encode($r);
    }

    function cekstok($id){
        $tbstok     = "";
        $stok       = $this->db->get($tbstok)->num_rows();
        $stokaman   = $this->db->get($tbstok)->num_rows();
        if ($stok < $stokaman) {
           return 1; 
        } else {
            return 2
        }
    }

    public function emailqc()
    {
        $config = Array( 
                'protocol'  => 'smtp', 
                'smtp_host' => 'ssl://smtp.gmail.com', 
                'smtp_port' => 465, 
                'smtp_user' => 'eps.sangkrah@gmail.com', 
                'smtp_pass' => 'eps2019wkwk',
                'mailtype'  => 'html', 
                'charset'   => 'iso-8859-1', 
                'wordwrap'  => TRUE 
                ); 
        $html = 'wkwkwkwkw';
        $this->load->library('email',$config);
        $this->email->set_newline("\r\n");
        // $emailto = "";
        $this->email->from('eps.sangkrah@gmail.com', 'Dari Mr. Robot');
        $this->email->to('kimbisnis3@gmail.com');
        $this->email->subject('Jangan Buang Sampah Sembarangan');
        $this->email->message($html);
        if ($this->email->send()) {
                echo json_encode(array("sukses" => TRUE));  
        }else{
                print_r($this->email->print_debugger());
        }
    }
    
}