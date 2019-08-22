<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Dataproduk extends CI_Controller {
    
    public $table       = 'msatbrg';
    public $foldername  = 'msatbrg';
    public $indexpage   = 'dataproduk/v_dataproduk';
    function __construct() {
        parent::__construct();
        include(APPPATH.'libraries/sessionakses.php');
    }
    function index(){
        $data['satuan'] = $this->db->get('msatuan')->result();
        $data['design'] = $this->db->get('mmodesign')->result();
        $data['warna']  = $this->db->get('mwarna')->result();
        $this->load->view($this->indexpage,$data);  
    }

    public function getall(){
        $q = "SELECT
                msatbrg.id,
                msatbrg.konv,
                msatbrg.ket,
                msatbrg.harga,
                msatbrg.def,
                mbarang.id idbarang,
                mbarang.kode kodebarang,
                mbarang.nama namabarang,
                msatuan.nama namasatuan,
                mgudang.nama namagudang
            FROM
                msatbrg
            LEFT JOIN mbarang ON mbarang.kode = msatbrg.ref_brg
            LEFT JOIN msatuan ON msatuan.kode = msatbrg.ref_sat
            LEFT JOIN mgudang ON mgudang.kode = msatbrg.ref_gud";
        $q  .= " ORDER BY msatbrg.id DESC";
        $result     = $this->db->query($q)->result();
        $list       = [];
        foreach ($result as $i => $r) {
            $row['no']          = $i + 1;
            $row['id']          = $r->id;
            $row['idbarang']    = $r->idbarang;
            $row['kode']        = $r->kodebarang;
            $row['konv']        = $r->konv;
            $row['harga']       = number_format($r->harga);
            $row['namabarang']  = $r->namabarang;
            $row['namasatuan']  = $r->namasatuan;
            $row['namagudang']  = $r->namagudang;
            $row['def']         = truefalse($r->def,'Default','');
            $list[] = $row;
        }   
        echo json_encode(array('data' => $list));
    }

    public function getdetailx()
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

    public function getdetail()
    {
        $kodebarang = $this->input->post('kodebarang');
        $q = "SELECT
                mbarangs.id,
                mbarangs.sn,
                mbarangs.ket,
                mbarangs.ref_brg,
                mbarang.nama namabarang,
                mbarangs.tipe,
                mmodesign.gambar gambardesign,
                mmodesign.nama namadesign,
                mwarna.colorc kodewarna
            FROM
                mbarangs
            LEFT JOIN mbarang ON mbarang.kode = mbarangs.ref_brg
            LEFT JOIN mmodesign ON mmodesign.kode = mbarangs.model
            LEFT JOIN mwarna ON mwarna.kode = mbarangs.warna
            WHERE mbarangs.ref_brg = '$kodebarang'";
        $result     = $this->db->query($q)->result();
        $str        = '<table class="table fadeIn animated">
                        <tr>
                            <th>No. Seri</th>
                            <th>Keterangan</th>
                            <th>Design</th>
                            <th>Gambar</th>
                            <th>Warna</th>
                        </tr>';
        foreach ($result as $r) {
            $str    .= '<tr>
                            <td>'.$r->sn.'</td>
                            <td>'.$r->ket.'</td>
                            <td>'.$r->namadesign.'</td>
                            <td>'.showimage($r->gambardesign).'</td>
                            <td><div style="witdh:10px; height:20px; background-color:'.$r->kodewarna.'" ></div></td>
                        </tr>';
        }

        $str        .= '</table>';
        echo $str;
    }


    public function savedata()
    {   
        $this->db->trans_begin();
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
                "ref_gud"   => $this->libre->gud_def(),
            );
            $b[] = $row;
        }
        $result = $this->db->insert_batch('msatbrg',$b);
        $c['ref_brg']   = $kodeBrg;
        $c['sn']        = $this->input->post('sn');
        $c['model']     = $this->input->post('model');
        $c['warna']     = $this->input->post('warna');
        $c['ket']       = $this->input->post('ketspek');
        $result = $this->db->insert('mbarangs',$c);
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
                'sukses' => 'success',
            );
        }
        echo json_encode($r);
    }

    public function edit()
    {
        $kode = $this->input->post('kode');
        $barang ="SELECT
                mbarang.id,
                mbarang.kode,
                mbarang.nama,
                mbarang.ket
            FROM
                mbarang
            WHERE mbarang.kode = '$kode'";

        $spek ="SELECT
                mbarangs.id,
                mbarangs.sn,
                mbarangs.model,
                mbarangs.warna,
                mbarangs.ket
            FROM
                mbarangs
            WHERE mbarangs.ref_brg = '$kode'";

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
            WHERE msatbrg.ref_brg = '$kode'";

        $data['barang'] = $this->db->query($barang)->row();
        $data['spek']   = $this->db->query($spek)->row();
        $data['harga']  = $this->db->query($harga)->result();
        echo json_encode($data);
    }

    function updatedata(){
        $this->db->trans_begin();
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
                "ref_gud"   => $this->libre->gud_def(),
            );
            $b[] = $row;
        }
        $result = $this->db->insert_batch('msatbrg',$b);
        $c['ref_brg']   = $kodeBrg;
        $c['sn']        = $this->input->post('sn');
        $c['model']     = $this->input->post('model');
        $c['warna']     = $this->input->post('warna');
        $c['ket']       = $this->input->post('ketspek');
        $result = $this->db->update('mbarangs',$c,array('ref_brg' => $kodeBrg ));
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
                'sukses' => 'success',
            );
        }
        echo json_encode($r);
    }

    public function deletedata()
    {
        $w['id']    = $this->input->post('id');
        $result     = $this->db->delete('mbarang',$w);
        $r['sukses'] = $result ? 'success' : 'fail' ;
        echo json_encode($r);
    }

    public function default_data() 
    {
        $w['id']    = $this->input->post('id');
        $result     = $this->db->update('msatbrg',array('def' => 't' ),$w);
        $r['sukses'] = $result ? 'success' : 'fail' ;
        echo json_encode($r);
    }
}