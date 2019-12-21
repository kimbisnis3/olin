<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Sj extends CI_Controller {

    public $table       = 'xsuratjalan';
    public $foldername  = 'sj';
    public $indexpage   = 'sj/v_sj';
    public $printpage   = 'sj/p_sj';

    function __construct() {
        parent::__construct();
        include(APPPATH . 'libraries/dbinclude.php');
        include(APPPATH.'libraries/sessionakses.php');
    }
    function index(){
        $data['jenisbayar'] = $this->dbtwo->get('mjenbayar')->result();
        $this->load->view($this->indexpage,$data);
    }

    public function getall(){
        $filterawal = date('Y-m-d', strtotime($this->input->post('filterawal')));
        $filterakhir = date('Y-m-d', strtotime($this->input->post('filterakhir')));
        $q = "SELECT
                xsuratjalan.id,
                xsuratjalan.kode,
                to_char(xsuratjalan.tgl, 'DD Mon YYYY') tgl,
                to_char(xsuratjalan.tglkirim, 'DD Mon YYYY') tglkirim,
                xsuratjalan.kirim,
                xsuratjalan.biayakirim,
                xsuratjalan.ref_cust,
                xsuratjalan.ket,
                xsuratjalan.posted,
                mcustomer.nama mcustomer_nama,
                xorder.kgkirim,
                xorder.kirimke,
                xorder.bykirim,
                xorder.ref_layanan,
                xorder.kurir,
                xorder.kodekurir,
                xorder.lokasidari,
                xorder.lokasike,
                xorder.telp
            FROM
                xsuratjalan
            LEFT JOIN mcustomer ON mcustomer.kode = xsuratjalan.ref_cust
            LEFT JOIN xorder ON xorder.kode = xsuratjalan.ref_order
            WHERE xsuratjalan.void IS NOT TRUE
            AND xsuratjalan.tgl BETWEEN '$filterawal' AND '$filterakhir'";
        $result     = $this->dbtwo->query($q)->result();
        echo json_encode(array('data' => $result));
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
            WHERE xsuratjaland.ref_suratjalan = '$kodesj'";
        $result     = $this->dbtwo->query($q)->result();
        $str        = '<table class="table fadeIn animated">
                        <tr>
                            <th>No.</th>
                            <th>Produk</th>
                            <th>Jumlah</th>
                            <th>Satuan</th>
                            <th>Harga</th>
                        </tr>';
        foreach ($result as $i => $r) {
            $str    .= '<tr>
                            <td>'.($i + 1).'.</td>
                            <td>'.$r->nama.'</td>
                            <td>'.$r->xsuratjaland_jumlah.'</td>
                            <td>'.$r->satuan.'</td>
                            <td>'.number_format($r->harga).'</td>
                        </tr>';
        }

        $str        .= '</table>';
        echo $str;
    }

    public function getproc(){
        $q = "SELECT
                xorder.*,
                mcustomer.nama mcustomer_nama
            FROM
                xorder
            LEFT JOIN mcustomer ON mcustomer.kode = xorder.ref_cust
            WHERE xorder.status >= '2'";
        $result     = $this->dbtwo->query($q)->result();
        echo json_encode(array('data' => $result));
    }

    public function savedata()
    {
        $this->dbtwo->trans_begin();
        $a['useri']     = $this->session->userdata('username');
        $a['ref_cust']  = $this->input->post('ref_cust');
        $a['tgl']       = date('Y-m-d', strtotime($this->input->post('tgl')));
        $a['kirim']     = $this->input->post('kirim');
        $a['tglkirim']  = date('Y-m-d', strtotime($this->input->post('tglkirim')));
        $a['ket']       = $this->input->post('ket');
        $a['biayakirim']= $this->input->post('biayakirim');
        $a['pic']       = $this->input->post('pic');
        $a['ref_order'] = $this->input->post('ref_order');
        $a['noresi']    = $this->input->post('noresi');
        $a['ref_gud']   = $this->libre->gud_def();

        $this->dbtwo->insert('xsuratjalan',$a);
        $kodeorder = $this->input->post('ref_order');
        // $idsj   = $this->dbtwo->insert_id();
        $idsj   = $this->dbtwo->insert_id('public."xsuratjalan_id_seq"');
        $kodesj = $this->dbtwo->get_where('xsuratjalan',array('id' => $idsj))->row()->kode;
        $dataOrderd = $this->dbtwo->get_where('xorderd',array('ref_order' => $kodeorder))->result();
        foreach ($dataOrderd as $r) {
            $row    = array(
                "useri"     => $this->session->userdata('username'),
                "ref_suratjalan" => $kodesj,
                "ref_brg"       => $r->ref_brg,
                "jumlah"        => $r->jumlah,
                "ref_satbrg"    => $r->ref_satbrg,
                "ref_gud"    => $this->libre->gud_def(),
            );
            $b[] = $row;
        }
        $this->dbtwo->insert_batch('xsuratjaland',$b);
        if ($this->dbtwo->trans_status() === FALSE)
        {
            $this->dbtwo->trans_rollback();
            $r = array(
                'sukses' => 'fail',
            );
        }
        else
        {
            $this->dbtwo->trans_commit();
            $r = array(
                'sukses' => 'success'
                );
        }
        echo json_encode($r);
    }

    public function edit()
    {
        $kode= $this->input->post('kode');
        $q ="SELECT
                xsuratjalan.id,
                xsuratjalan.kode,
                to_char(xsuratjalan.tgl, 'DD Mon YYYY') tgl,
                to_char(xsuratjalan.tglkirim, 'DD Mon YYYY') tglkirim,
                xsuratjalan.kirim,
                xsuratjalan.biayakirim,
                xsuratjalan.ref_cust,
                xsuratjalan.ket,
                xsuratjalan.posted,
                xsuratjalan.pic,
                xsuratjalan.ref_order,
                xsuratjalan.noresi,
                mcustomer.nama mcustomer_nama
            FROM
                xsuratjalan
            LEFT JOIN mcustomer ON mcustomer.kode = xsuratjalan.ref_cust
            WHERE xsuratjalan.kode = '$kode'";
        $data   = $this->dbtwo->query($q)->row();
        echo json_encode($data);
    }

    function updatedata()
    {
        $this->dbtwo->trans_begin();
        $a['useru']     = $this->session->userdata('username');
        $a['dateu']     = 'now()';
        $a['ref_cust']  = $this->input->post('ref_cust');
        $a['tgl']       = date('Y-m-d', strtotime($this->input->post('tgl')));
        $a['kirim']     = $this->input->post('kirim');
        $a['tglkirim']  = date('Y-m-d', strtotime($this->input->post('tglkirim')));
        $a['ket']       = $this->input->post('ket');
        $a['biayakirim']= $this->input->post('biayakirim');
        $a['pic']       = $this->input->post('pic');
        $a['ref_order'] = $this->input->post('ref_order');
        $a['noresi']    = $this->input->post('noresi');
        $a['ref_gud']   = $this->libre->gud_def();
        $kodesj         = $this->input->post('kode');
        $w['kode']      = $kodesj;
        $result = $this->dbtwo->update('xsuratjalan',$a,$w);
        $this->dbtwo->delete('xsuratjaland',array('ref_suratjalan' =>  $kodesj));
        $kodeorder = $this->input->post('ref_order');
        $dataOrderd = $this->dbtwo->get_where('xorderd',array('ref_order' => $kodeorder))->result();
        foreach ($dataOrderd as $r) {
            $row    = array(
                "useri"     => $this->session->userdata('username'),
                "ref_suratjalan" => $kodesj,
                "ref_brg"   => $r->ref_brg,
                "jumlah"    => $r->jumlah,
                "ref_satbrg"=> $r->ref_satbrg,
                "ref_gud"   => $this->libre->gud_def(),
            );
            $b[] = $row;
        }
        $this->dbtwo->insert_batch('xsuratjaland',$b);
        if ($this->dbtwo->trans_status() === FALSE)
        {
            $this->dbtwo->trans_rollback();
            $r = array(
                'sukses' => 'fail',
            );
        }
        else
        {
            $this->dbtwo->trans_commit();
            $r = array(
                'sukses' => 'success'
                );
        }
        echo json_encode($r);
    }

    function ceklunas() {
        $kode = $this->input->post('kode');
        $q = "SELECT
                COALESCE(xpelunasan.total,0) total,
                COALESCE(SUM (xpelunasan.bayar),0) bayar,
                xsuratjalan.ref_order
            FROM
                xsuratjalan
            LEFT JOIN xpelunasan ON xpelunasan.ref_jual = xsuratjalan.ref_order
            WHERE
                xsuratjalan.kode = '$kode'
            GROUP BY
                total,
                xsuratjalan.ref_order";
        $s = $this->dbtwo->query($q)->row();
        $total  = $s->total;
        $bayar  = $s->bayar;
        $kurang = $total - $bayar;
        $res;
        if ($kurang <= 0) {
            $res = 'L';
        } else {
            $res = 'TL';
        }
        echo json_encode(array(
            'lunas' => $res,
            'total' => $total,
            'bayar' => $bayar,
            'kurang' => $kurang,
        ));


    }

    function validdata() {
        $sql = "SELECT posted FROM {$this->table} WHERE kode = '{$this->input->post('kode')}'";
        $s = $this->dbtwo->query($sql)->row()->posted;
        (($s == 'f') || ($s == '') || ($s == null)) ? $status = 't' : $status = 'f';
        $d['posted'] = $status;
        $w['kode'] = $this->input->post('kode');
        $result = $this->dbtwo->update($this->table,$d,$w);
        $r['sukses'] = $result > 0 ? 'success' : 'fail' ;
        echo json_encode($r);

    }

    function voiddata()
    {
        $d['void'] = 't';
        $d['tglvoid'] = 'now()';
        $w['id'] = $this->input->post('id');
        $result = $this->dbtwo->update($this->table,$d,$w);
        $r['sukses'] = $result ? 'success' : 'fail' ;
        echo json_encode($r);

    }

    public function deletedata()
    {
        $w['id'] = $this->input->post('id');
        $result = $this->dbtwo->delete($this->table,$w);
        $r['sukses'] = $result ? 'success' : 'fail' ;
        echo json_encode($r);
    }

    function cetak() {
        $kode = $this->input->get('kode');

        $sj  = "SELECT
                xsuratjalan.id,
                xsuratjalan.kode,
                to_char(xsuratjalan.tgl, 'DD Mon YYYY') tgl,
                to_char(xsuratjalan.tglkirim, 'DD Mon YYYY') tglkirim,
                xsuratjalan.kirim,
                xsuratjalan.biayakirim,
                xsuratjalan.ref_cust,
                xsuratjalan.ket,
                xsuratjalan.posted,
                mcustomer.nama mcustomer_nama,
                xorder.ket,
                xorder.pic,
                xorder.kgkirim,
                xorder.kirimke,
                xorder.bykirim,
                xorder.ref_layanan,
                xorder.ref_kirim,
                xorder.kurir,
                xorder.kodekurir,
                xorder.lokasidari,
                xorder.lokasike,
                xorder.alamat,
                xorder.telp,
                xorderd.jumlah,
                mbarang.kode mbarang_kode,
                mbarang.nama mbarang_nama
            FROM
                xsuratjalan
            LEFT JOIN mcustomer ON mcustomer.kode = xsuratjalan.ref_cust
            LEFT JOIN xorder ON xorder.kode = xsuratjalan.ref_order
            LEFT JOIN xorderd ON xorderd.ref_order = xorder.kode
            LEFT JOIN mbarang ON mbarang.kode = xorderd.ref_brg
            WHERE xsuratjalan.kode = '$kode'";

        $barang = "SELECT
                mbarang. ID,
                mbarang.kode,
                mbarang.nama,
                mbarang.ket,
                msatbrg. ID idsatbarang,
                msatbrg.konv,
                msatbrg.ket ketsat,
                msatbrg.harga,
                msatbrg.ref_brg,
                msatbrg.ref_sat,
                msatuan.nama satuan,
                mgudang.nama gudang,
                xorderd.jumlah,
                xorderd.jumlah * xorderd.harga subtotal,
                mbarangs.sn,
                xorderds. ID,
                xorderds.ket,
                mbarang.nama,
                mmodesign.kode mmodesign_kode,
                mmodesign.nama mmodesign_nama,
                mmodesign.gambar mmodesign_gambar,
                mwarna.nama mwarna_nama,
                mwarna.colorc mwarna_colorc
            FROM
                xsuratjalan
            LEFT JOIN xorder ON xorder.kode = xsuratjalan.ref_order
            LEFT JOIN xorderd ON xorderd.ref_order = xorder.kode
            LEFT JOIN mbarang ON mbarang.kode = xorderd.ref_brg
            LEFT JOIN mbarangs ON mbarang.kode = mbarangs.ref_brg
            LEFT JOIN msatbrg ON msatbrg.kode = xorderd.ref_satbrg
            LEFT JOIN msatuan ON msatuan.kode = msatbrg.ref_sat
            LEFT JOIN mgudang ON mgudang.kode = msatbrg.ref_gud
            LEFT JOIN xorderds ON xorderds.ref_orderd = xorderd. ID
            LEFT JOIN mmodesign ON mmodesign.kode = xorderds.ref_modesign
            LEFT JOIN mwarna ON mwarna.kode = xorderds.ref_warna
            WHERE xsuratjalan.kode = '$kode'";

        $res_sj   = $this->dbtwo->query($sj)->row();
        $res_brg  = $this->dbtwo->query($barang)->result();


        $data['title']  = "Surat Jalan";
        $data['sj']     = $res_sj;
        $data['barang'] = $res_brg;
        $this->load->view($this->printpage,$data);
    }

}
