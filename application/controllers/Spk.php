<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Spk extends CI_Controller {
    
    public $table       = 'xprocorder';
    public $foldername  = 'spk';
    public $indexpage   = 'spk/v_spk';
    function __construct() {
        parent::__construct();
        include(APPPATH.'libraries/sessionakses.php');
    }
    function index(){
        $data['jenisbayar'] = $this->db->get('mjenbayar')->result();
        $this->load->view($this->indexpage,$data);  
    }

    public function getall()
    {
        $filterawal = date('Y-m-d', strtotime($this->input->post('filterawal')));
        $filterakhir = date('Y-m-d', strtotime($this->input->post('filterakhir')));
        $q = "SELECT 
                xprocorder.id,
                xprocorder.kode,
                to_char(xprocorder.tgl, 'DD Mon YYYY') tgl,
                xprocorder.ref_brg,
                xprocorder.ref_order,
                xprocorder.status,
                xprocorder.ket,
                mbarang.nama mbarang_nama
            FROM 
                xprocorder
            LEFT JOIN mbarang ON mbarang.kode = xprocorder.ref_brg
            LEFT JOIN xorder ON xorder.kode = xprocorder.ref_order
            WHERE xprocorder.void IS NOT TRUE
            AND
                xprocorder.tgl 
            BETWEEN '$filterawal' AND '$filterakhir'";
        $result     = $this->db->query($q)->result();
        $list       = [];
        foreach ($result as $i => $r) {
            $row['no']              = $i + 1;
            $row['id']              = $r->id;
            $row['kode']            = $r->kode;
            $row['ref_order']       = $r->ref_order;
            $row['tgl']             = $r->tgl;
            $row['mbarang_nama']    = $r->mbarang_nama;
            $row['status']          = $r->status;
            $row['ket']             = $r->ket;

            $list[] = $row;
        }   
        echo json_encode(array('data' => $list));
    }

    public function getorder(){
        $q = "SELECT
                xorder. ID,
                to_char(xorder.tgl, 'DD Mon YYYY') xorder_tgl,
                xorderd.ref_order,
                xorderd.ref_brg,
                xorderd.ref_satbrg,
                xorderd.jumlah,
                mcustomer.nama mcustomer_nama,
                xpelunasan.kode xpelunasan_kode,
                xpelunasan.bayar xpelunasan_bayar,
                mbarang.nama mbarang_nama
            FROM
                xorderd
            LEFT JOIN xorder ON xorder.kode = xorderd.ref_order
            LEFT JOIN mbarang ON xorderd.ref_brg = mbarang.kode
            INNER JOIN mcustomer ON mcustomer.kode = xorder.ref_cust
            INNER JOIN xpelunasan ON xpelunasan.ref_jual = xorder.kode
            WHERE
                xorder.void IS NOT TRUE
            AND xorder.kode NOT IN (
                SELECT
                    ref_order
                FROM
                    xprocorder
            )";
        $result     = $this->db->query($q)->result();
        $list       = [];
        foreach ($result as $i => $r) {
            $row['no']              = $i + 1;
            $row['id']              = $r->id;
            $row['id']              = $r->id;
            $row['ref_order']       = $r->ref_order;
            $row['ref_brg']         = $r->ref_brg;
            $row['ref_satbrg']      = $r->ref_satbrg;
            $row['xorder_tgl']      = $r->xorder_tgl;
            $row['mcustomer_nama']  = $r->mcustomer_nama;
            $row['xpelunasan_bayar']= $r->xpelunasan_bayar;
            $row['mbarang_nama']    = $r->mbarang_nama;
            $row['jumlah']          = $r->jumlah;

            $list[] = $row;
        }   
        echo json_encode(array('data' => $list));
    }

    public function savedata()
    {   
        $this->db->trans_begin();
        $d['useri']     = $this->session->userdata('username');
        $d['ref_brg']   = $this->input->post('ref_brg');
        $d['ref_order'] = $this->input->post('ref_order');
        $d['ref_satbrg']= $this->input->post('ref_satbrg');
        $d['tgl']       = date('Y-m-d', strtotime($this->input->post('tgl')));
        $d['jumlah']    = $this->input->post('jumlah');
        $d['ket']       = $this->input->post('ket');
        $d['status']    = '0';

        $result = $this->db->insert('xprocorder',$d);
        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            $r = array(
                'sukses' => 'fail', 
            );
        }
        else
        {
            $this->db->trans_commit();
            $r = array(
                'sukses' => 'success'
                );
        }
        echo json_encode($r);
    }

    public function edit()
    {
        $q = "SELECT 
                xprocorder.id,
                xprocorder.kode,
                to_char(xprocorder.tgl, 'DD Mon YYYY') tgl,
                xprocorder.ref_brg,
                xprocorder.ref_order,
                xprocorder.status,
                xprocorder.ket,
                mbarang.nama mbarang_nama,
                xorderd.jumlah
            FROM 
                xprocorder
            LEFT JOIN mbarang ON mbarang.kode = xprocorder.ref_brg
            LEFT JOIN xorder ON xorder.kode = xprocorder.ref_order
            LEFT JOIN xorderd ON xorderd.ref_order = xorder.kode
            WHERE xprocorder.void IS NOT TRUE
            AND xprocorder.kode = '{$this->input->post('kode')}'";
        $data   = $this->db->query($q)->row();
        echo json_encode($data);
    }

    function updatedata()
    {
        $this->db->trans_begin();
        $d['useru']     = $this->session->userdata('username');
        $d['dateu']     = 'now()';
        $d['ref_brg']   = $this->input->post('ref_brg');
        $d['ref_order'] = $this->input->post('ref_order');
        $d['ref_satbrg']= $this->input->post('ref_satbrg');
        $d['tgl']       = date('Y-m-d', strtotime($this->input->post('tgl')));
        $d['jumlah']    = $this->input->post('jumlah');
        $d['ket']       = $this->input->post('ket');
        $d['status']    = '0';
        $w['kode']      = $this->input->post('kode');
        $result         = $this->db->update('xprocorder',$d,$w);
        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            $r = array(
                'sukses' => 'fail', 
            );
        }
        else
        {
            $this->db->trans_commit();
            $r = array(
                'sukses' => 'success'
                );
        }
        echo json_encode($r);
    }

    function validdata() {
        $sql = "SELECT posted FROM xpelunasan WHERE id = {$this->input->post('id')}";
        $s = $this->db->query($sql)->row()->posted;
        (($s == 'f') || ($s == '') || ($s == null)) ? $status = 't' : $status = 'f';
        $d['posted'] = $status;
        $w['id'] = $this->input->post('id');   
        $result = $this->db->update($this->table,$d,$w);
        $r['sukses'] = $result > 0 ? 'success' : 'fail' ;
        echo json_encode($r);
    }

    function voiddata() 
    {
        $d['void'] = 't';
        $w['id'] = $this->input->post('id');   
        $result = $this->db->update($this->table,$d,$w);
        $r['sukses'] = $result ? 'success' : 'fail' ;
        echo json_encode($r);

    }

    public function deletedata()
    {
        $w['id'] = $this->input->post('id');
        $result = $this->db->delete($this->table,$w);
        $r['sukses'] = $result ? 'success' : 'fail' ;
        echo json_encode($r);
    }
    
}