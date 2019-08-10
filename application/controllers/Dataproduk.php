<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Dataproduk extends CI_Controller {
    
    public $table       = '';
    public $foldername  = '';
    public $indexpage   = 'dataproduk/v_dataproduk';
    function __construct() {
        parent::__construct();
        include(APPPATH.'libraries/sessionakses.php');
    }
    function index(){
        $data['design'] = $this->db->get('mmodesign')->result();
        $data['warna'] = $this->db->get('mwarna')->result();
        $this->load->view($this->indexpage,$data);  
    }

    public function getall(){
        $q = "SELECT
                msatbrg.id,
                msatbrg.konv,
                msatbrg.ket,
                msatbrg.harga,
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
        $result     = $this->db->query($q)->result();
        $list       = [];
        foreach ($result as $i => $r) {
            $row['id']          = $r->id;
            $row['idbarang']    = $r->idbarang;
            $row['kodebarang']  = $r->kodebarang;
            $row['no']          = $i + 1;
            $row['konv']        = $r->konv;
            $row['harga']       = number_format($r->harga);
            $row['namabarang']  = $r->namabarang;
            $row['namasatuan']  = $r->namasatuan;
            $row['namagudang']  = $r->namagudang;

            $list[] = $row;
        }   
        echo json_encode(array('data' => $list));
    }

    function getSpek(){
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
        $list       = [];
        foreach ($result as $i => $r) {
            $row['no']          = $i + 1;
            $row['id']          = $r->id;
            $row['sn']          = $r->sn;
            $row['ket']         = $r->ket;
            $row['ref_brg']     = $r->ref_brg;
            $row['namabarang']  = $r->namabarang;
            $row['tipe']        = $r->tipe;
            $row['gambardesign']= showimage($r->gambardesign);
            $row['namadesign']  = $r->namadesign;
            $row['kodewarna']   = "<div style='witdh:10px; height:20px; background-color:".$r->kodewarna."' ></div>";
            $row['opsi']    = btnd($r->id);
            

            $list[] = $row;
        }   
        echo json_encode(array('data' => $list));
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
        $str        = '<table class="table">
                        <tr>
                            <th>No. Seri</th>
                            <th>Produk</th>
                            <th>Ket</th>
                            <th>Design</th>
                            <th>Gambar</th>
                            <th>Warna</th>
                        </tr>';
        foreach ($result as $r) {
            $str    .= '<tr>
                            <td>'.$r->sn.'</td>
                            <td>'.$r->namabarang.'</td>
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
        $d['useri']     = $this->session->userdata('username');
        $d['sn']        = $this->input->post('sn');
        $d['model']     = $this->input->post('model');
        $d['warna']     = $this->input->post('warna');
        $d['ket']       = $this->input->post('ket');
        $d['ref_brg']   = $this->input->post('ref_brg');

        $result = $this->db->insert('mbarangs',$d);
        $r['sukses'] = $result ? 'success' : 'fail' ;
        echo json_encode($r);
    }

    public function deletespek()
    {
        $w['id']    = $this->input->post('id');
        $result     = $this->db->delete('mbarangs',$w);
        $r['sukses'] = $result ? 'success' : 'fail' ;
        echo json_encode($r);
    }
    
}