<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Po extends CI_Controller {
    
    public $table       = 'xorder';
    public $foldername  = './uploads/po';
    public $indexpage   = 'po/v_po';

    function __construct() {
        parent::__construct();
        include(APPPATH.'libraries/sessionakses.php');
    }
    function index(){
        $this->load->view($this->indexpage);  
    }

    public function getall(){
        $result     = $this->db->get($this->table)->result();
        $no         = 1;
        $list       = [];
        foreach ($result as $r) {
            $row['id']      = $r->id;
            $list[] = $row;
            $no++;
        }   
        echo json_encode(array('data' => $list));
    }

    public function savedata()
    {   
        $this->db->trans_begin();
        $upcorel    = $this->libre->goUpload('corel','corel-'.time(),$this->foldername);
        $upimage    = $this->libre->goUpload('image','img-'.time(),$this->foldername);
        $a['ref_cust']  = $this->input->post('ref_cust');
        $a['tanggal']   = date('Y-m-d', strtotime($this->input->post('tanggal')));
        $a['ref_gud']   = $this->input->post('ref_gud');
        $a['ket']       = $this->input->post('ket');
        $a['lokasidari']= $this->input->post('lokasidari');
        $a['lokasike']  = $this->input->post('lokasike');
        $a['bykirim']   = $this->input->post('bykirim');
        $a['kgkirim']   = $this->input->post('kgkirim');
        $a['pathcorel'] = $upcorel;
        $a['pathimage'] = $upimage;
        $this->db->insert('xorder',$a);
        $idOrder = $this->db->insert_id();
        $kodeOrder = $this->db->get_where('xorder',array('id' => $idOrder))->row()->kode;
        $b['ref_order'] = $kodeOrder;
        $b['ref_satbrg']= $this->input->post('ref_satbrg');
        $b['jumlah']    = $this->input->post('jumlah');

        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
        }
        else
        {
            $this->db->trans_commit();
        }
        echo json_encode($r);
    }

    public function edit()
    {
        $w['id']= $this->input->post('id');
        $data   = $this->db->get_where($this->table,$w)->row();
        echo json_encode($data);
    }

    public function getselects()
    {
        $data   = $this->db->get($this->table)->result();
        echo json_encode($data);
    }

    function updatedata(){
        $d['useru']     = $this->session->userdata('username');
        $d['dateu']     = 'now()';
        $d['nama']      = $this->input->post('nama');
        $d['colorc']    = $this->input->post('kodewarna');
        $d['ket']       = $this->input->post('ket');
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

    function cetak(){
      $useGroupBy = 1;
      $header = ['No','Kode','Nama','Kode Warna','Keterangan'];
      $q      = "SELECT * FROM mwarna";
      $body   = $this->db->query($q)->result();
      $data['title']    = 'Laporan Warna';
      $data['periodestart'] = '@tanggal';
      $data['periodeend']   = '@tanggal';
      $data['header'] = $header;
      $data['body']   = $body;
      $this->load->view($this->printpage,$data); 
    }
    
}