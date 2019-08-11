<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Qc extends CI_Controller {
    
    public $table       = 'xprocorder';
    public $foldername  = 'spk';
    public $indexpage   = 'qc/v_qc';
    function __construct() {
        parent::__construct();
        include(APPPATH.'libraries/sessionakses.php');
    }
    function index(){
        $data['jenisbayar'] = $this->db->get('mjenbayar')->result();
        $this->load->view($this->indexpage,$data);  
    }

    public function getall(){
        $q = "SELECT 
                xprocorder.id,
                xprocorder.kode,
                xprocorder.tgl,
                xprocorder.ref_brg,
                xprocorder.ref_order,
                xprocorder.status,
                mbarang.nama mbarang_nama
            FROM 
                xprocorder
            LEFT JOIN mbarang ON mbarang.kode = xprocorder.ref_brg
            LEFT JOIN xorder ON xorder.kode = xprocorder.ref_order";
        $result     = $this->db->query($q)->result();
        $list       = [];
        foreach ($result as $i => $r) {
            $row['no']              = $i + 1;
            $row['id']              = $r->id;
            $row['kode']            = $r->kode;
            $row['tgl']             = $r->tgl;
            $row['mbarang_nama']    = $r->mbarang_nama;
            $row['status']          = $r->status;

            $list[] = $row;
        }   
        echo json_encode(array('data' => $list));
    }

    public function getorder(){
        $q = "SELECT
                xorder.id,
                xorder.kode,
                xorder.tgl,
                xorder.ket,
                xorder.pic,
                xorder.kgkirim,
                xorder.bykirim,
                xorder.ref_cust,
                mcustomer.nama mcustomer_nama,
                (
                    SELECT
                        SUM (
                            xorderd.harga * xorderd.jumlah
                        )
                    FROM
                        xorderd
                    WHERE
                        xorderd.ref_order = xorder.kode
                ) + xorder.bykirim total
            FROM
                xorder
            LEFT JOIN mcustomer ON mcustomer.kode = xorder.ref_cust";
        $result     = $this->db->query($q)->result();
        $list       = [];
        foreach ($result as $i => $r) {
            $row['no']              = $i + 1;
            $row['id']              = $r->id;
            $row['kode']            = $r->kode;
            $row['tgl']             = $r->tgl;
            $row['mcustomer_nama']  = $r->mcustomer_nama;
            $row['total']           = $r->total;
            $row['ket']             = $r->ket;

            $list[] = $row;
        }   
        echo json_encode(array('data' => $list));
    }

    public function savedata()
    {   
        $this->db->trans_begin();
        $d['useri']     = $this->session->userdata('username');
        $d['ref_cust']  = $this->input->post('ref_cust');
        $d['tgl']       = date('Y-m-d', strtotime($this->input->post('tgl')));
        $d['ref_order'] = $this->input->post('ref_order');
        $d['ref_brg']   = $this->input->post('ref_brg');

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
        $w['id']= $this->input->post('id');
        $data   = $this->db->get_where($this->table,$w)->row();
        echo json_encode($data);
    }

    function updatedata()
    {
        $this->db->trans_begin();
        $d['useru']     = $this->session->userdata('username');
        $d['dateu']     = 'now()';
        $d['useri']     = $this->session->userdata('username');
        $d['ref_cust']  = $this->input->post('ref_cust');
        $d['tgl']       = date('Y-m-d', strtotime($this->input->post('tgl')));
        $d['ref_order'] = $this->input->post('ref_order');
        $d['ref_brg']   = $this->input->post('ref_brg');
        $w['id'] = $this->input->post('id');
        $result = $this->db->update('xprocorder',$d,$w);
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