<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Sj extends CI_Controller {
    
    public $table       = 'xsuratjalan';
    public $foldername  = 'sj';
    public $indexpage   = 'sj/v_sj';
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
                xsuratjalan.id,
                xsuratjalan.kode,
                xsuratjalan.tgl,
                xsuratjalan.tglkirim,
                xsuratjalan.kirim,
                xsuratjalan.biayakirim,
                xsuratjalan.ref_cust,
                xsuratjalan.ket,
                mcustomer.nama mcustomer_nama
            FROM
                xsuratjalan
            LEFT JOIN mcustomer ON mcustomer.kode = xsuratjalan.ref_cust
            WHERE xsuratjalan.void IS NOT TRUE";
        $result     = $this->db->query($q)->result();
        $list       = [];
        foreach ($result as $i => $r) {
            $row['no']              = $i + 1;
            $row['id']              = $r->id;
            $row['kode']            = $r->kode;
            $row['tgl']             = $r->tgl;
            $row['tglkirim']        = $r->tglkirim;
            $row['biayakirim']      = $r->biayakirim;
            $row['mcustomer_nama']  = $r->mcustomer_nama;
            $row['ket']             = $r->ket;

            $list[] = $row;
        }   
        echo json_encode(array('data' => $list));
    }

    public function getproc(){
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

    public function getdetail()
    {
        $kodesj = $this->input->post('kodesj');
        $q = "SELECT
                mbarang.id,
                mbarang.kode,
                mbarang.nama,
                mbarang.ket,
                msatbrg.id idsatbarang,
                msatbrg.konv,
                msatbrg.ket ketsat,
                msatbrg.harga,
                msatbrg.ref_brg,
                msatbrg.ref_sat,
                msatuan.nama satuan,
                mgudang.nama gudang,
                xsuratjaland.jumlah xsuratjaland_jumlah
            FROM
                xsuratjaland
            LEFT JOIN mbarang ON mbarang.kode = xsuratjaland.ref_brg
            LEFT JOIN msatbrg ON msatbrg.kode = xsuratjaland.ref_satbrg
            LEFT JOIN msatuan ON msatuan.kode = msatbrg.ref_sat
            LEFT JOIN mgudang ON mgudang.kode = msatbrg.ref_gud
            WHERE xsuratjaland.ref_xsuratjaland = '$kodesj'";
        $result     = $this->db->query($q)->result();
        $str        = '<table class="table">
                        <tr>
                            <th>Produk</th>
                            <th>Jumlah</th>
                            <th>Satuan</th>
                            <th>Harga</th>
                        </tr>';
        foreach ($result as $r) {
            $str    .= '<tr>
                            <td>'.$r->nama.'</td>
                            <td>'.$r->xsuratjaland_jumlah.'</td>
                            <td>'.$r->namasatuan.'</td>
                            <td>'.$r->harga.'</td>
                        </tr>';
        }

        $str        .= '</table>';
        echo $str;
    }

    public function savedata()
    {   
        $this->db->trans_begin();
        $a['useri']     = $this->session->userdata('username');
        $a['ref_cust']  = $this->input->post('ref_cust');
        $a['tgl']       = date('Y-m-d', strtotime($this->input->post('tgl')));
        $a['ref_cust']  = $this->input->post('ref_cust');
        $a['kirim']     = $this->input->post('kirim');
        $a['tglkirim']  = $this->input->post('tglkirim');
        $a['ket']       = $this->input->post('ket');
        $a['biayakirim']= $this->input->post('biayakirim');
        $a['pic']       = $this->input->post('pic');

        $this->db->insert('xsuratjalan',$d);
        $kodeorder = $this->input->post('ref_order');
        $idsj = $this->db->insert_id();
        $kodesj = $this->db->get_where('xsuratjalan',array('id' => $idOrder))->row()->kode;
        $dataOrderd = $this->db->get_where('xorderd',array('ref_order' => $kodeorder))->result();
        foreach ($dataOrderd as $r) {
            $row    = array(
                "useri"     => $this->session->userdata('username'),
                "ref_suratjalan" => $kodesj,
                "ref_brg"   => $r->ref_brg,
                "jumlah"    => $r->jumlah,
                "ref_satbrg"=> $r->ref_satbrg,
            );
            $b[] = $row;
        }
        $this->db->insert_batch('xsuratjaland',$b);
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