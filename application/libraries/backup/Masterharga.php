<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Masterharga extends CI_Controller {
    
    public $table       = 'msatbrg';
    public $foldername  = 'msatbrg';
    public $indexpage   = 'masterharga/v_masterharga';
    function __construct() {
        parent::__construct();
        include(APPPATH.'libraries/sessionakses.php');
    }
    function index(){
        $data['satuan'] = $this->db->get('msatuan')->result();
        $data['gudang'] = $this->db->get('mgudang')->result();
        $this->load->view($this->indexpage,$data);  
    }

    public function getall(){
        $q = "SELECT
                mbarang.id,
                mbarang.kode,
                mbarang.nama,
                mbarang.ket
            FROM
                mbarang";
        $result     = $this->db->query($q)->result();
        $list       = [];
        foreach ($result as $i => $r) {
            $row['id']          = $r->id;
            $row['no']          = $i + 1;
            $row['nama']        = $r->nama;
            $row['kode']        = $r->kode;
            $row['ket']         = $r->ket;

            $list[] = $row;
        }   
        echo json_encode(array('data' => $list));
    }

    public function getdetail()
    {
        $kodebarang = $this->input->post('kodebarang');
        $q = "SELECT
                msatbrg.id idsatbarang,
                msatbrg.konv,
                msatbrg.ket,
                msatbrg.harga,
                msatbrg.ref_brg,
                msatbrg.ref_sat,
                msatbrg.ref_gud,
                msatuan.nama namasatuan,
                mgudang.nama namagudang
            FROM
                msatbrg
            LEFT JOIN msatuan ON msatuan.kode = msatbrg.ref_sat
            LEFT JOIN mgudang ON mgudang.kode = msatbrg.ref_gud
            WHERE msatbrg.ref_brg = '$kodebarang'";
        $result     = $this->db->query($q)->result();
        $str        = '<table class="table">
                        <tr>
                            <th>Konv</th>
                            <th>Satuan</th>
                            <th>Harga</th>
                            <th>Gudang</th>
                            <th>Keterangan</th>
                        </tr>';
        foreach ($result as $r) {
            $str    .= '<tr>
                            <td>'.$r->konv.'</td>
                            <td>'.$r->namasatuan.'</td>
                            <td>'.$r->harga.'</td>
                            <td>'.$r->namagudang.'</td>
                            <td>'.$r->ket.'</td>
                        </tr>';
        }

        $str        .= '</table>';
        echo $str;
    }

    public function savedata()
    {   
        $a['useri']     = $this->session->userdata('username');
        $a['nama']      = $this->input->post('nama');
        $a['ket']       = $this->input->post('ket');
        $this->db->insert('mbarang',$a);
        $idBrg = $this->db->insert_id();
        $kodeBrg = $this->db->get_where('mbarang',array('id' => $idBrg))->row()->kode;
        $arrHarga = json_decode($this->input->post('arrHarga'));
        foreach ($arrHarga as $r) {
            $row    = array(
                "useri"     => $this->session->userdata('username'),
                "ref_brg"   => $kodeBrg,
                "ref_sat"   => $r->ref_sat,
                "konv"      => $r->konv,
                "harga"     => $r->harga,
                "ket"       => $r->ketsatuan,
                "ref_gud"   => 'GX0001',
            );
            $b[] = $row;
        }
        $result = $this->db->insert_batch('msatbrg',$b);
        echo json_encode(array('sukses' => $result ? 'success' : 'fail'));
    }

    public function edit()
    {
        $barang ="SELECT
                mbarang.id,
                mbarang.kode,
                mbarang.nama,
                mbarang.ket
            FROM
                mbarang
            WHERE mbarang.kode = '{$this->input->post('kode')}'";

        $harga ="SELECT
                msatbrg.id idsatbarang,
                msatbrg.konv,
                msatbrg.ket ketsatuan,
                msatbrg.harga,
                msatbrg.ref_brg,
                msatbrg.ref_sat,
                msatbrg.ref_gud,
                msatuan.nama satuan,
                mgudang.nama namagudang
            FROM
                msatbrg
            LEFT JOIN msatuan ON msatuan.kode = msatbrg.ref_sat
            LEFT JOIN mgudang ON mgudang.kode = msatbrg.ref_gud
            WHERE msatbrg.ref_brg = '{$this->input->post('kode')}'";

        $data['barang'] = $this->db->query($barang)->row();
        $data['harga']  = $this->db->query($harga)->result();
        echo json_encode($data);
    }

    function updatedata(){
        $a['useru']     = $this->session->userdata('username');
        $a['dateu']     = 'now()';
        $a['nama']      = $this->input->post('nama');
        $a['ket']       = $this->input->post('ket');
        $kodeBrg        = $this->input->post('kode');
        $this->db->update('mbarang',$a,array('kode' => $kodeBrg ));
        $this->db->delete('msatbrg',array('ref_brg' => $kodeBrg ));
        $arrHarga = json_decode($this->input->post('arrHarga'));
        foreach ($arrHarga as $r) {
            $row    = array(
                "useru"     => $this->session->userdata('username'),
                "dateu"     => 'now()',
                "ref_brg"   => $kodeBrg,
                "ref_sat"   => $r->ref_sat,
                "konv"      => $r->konv,
                "harga"     => $r->harga,
                "ket"       => $r->ketsatuan,
                "ref_gud"   => 'GX0001',
            );
            $b[] = $row;
        }
        $result = $this->db->insert_batch('msatbrg',$b);
        echo json_encode(array('sukses' => $result ? 'success' : 'fail'));
    }

    public function deletedata()
    {
        $w['id']    = $this->input->post('id');
        $result     = $this->db->delete('mbarang',$w);
        $r['sukses'] = $result ? 'success' : 'fail' ;
        echo json_encode($r);
    }
}