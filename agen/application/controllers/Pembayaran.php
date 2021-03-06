<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Pembayaran extends CI_Controller {

    public $table       = 'xpelunasan';
    public $foldername  = 'xpelunasan';
    public $indexpage   = 'pembayaran_agen/v_pembayaran_agen';
    function __construct() {
        parent::__construct();
        include(APPPATH.'libraries/sessionakses.php');
    }
    function index(){
        $data['jenisbayar'] = $this->db->get('mjenbayar')->result();
        $data['mbank']      = $this->db->get('mbank')->result();
        $this->load->view($this->indexpage,$data);
    }

    public function getall(){
        $filterawal = date('Y-m-d', strtotime($this->input->post('filterawal')));
        $filterakhir = date('Y-m-d', strtotime($this->input->post('filterakhir')));
        $kodecust = $this->session->userdata('kodecust');
        $q = "SELECT
                xpelunasan.id,
                xpelunasan.kode,
                xpelunasan.tgl tgl_real,
                to_char(xpelunasan.tgl, 'DD Mon YYYY') tgl,
                xpelunasan.total,
                xpelunasan.bayar,
                xpelunasan.total - xpelunasan.bayar kurang,
                xpelunasan.posted,
                xpelunasan.ket,
                xpelunasan.ref_jual,
                xpelunasan.kodeunik,
                xpelunasan.ref_bank,
	            mbank.nama bank_nama,
	            mbank.norek bank_norek,
                mcustomer.nama mcustomer_nama,
                mgudang.nama mgudang_nama,
                mjenbayar.nama mjenbayar_nama
            FROM
                xpelunasan
            LEFT JOIN mcustomer ON mcustomer.kode = xpelunasan.ref_cust
            LEFT JOIN mgudang ON mgudang.kode = xpelunasan.ref_gud
            LEFT JOIN mjenbayar ON mjenbayar.kode = xpelunasan.ref_jenbayar
            LEFT JOIN mbank ON mbank.kode = xpelunasan.ref_bank
            WHERE xpelunasan.void IS NOT TRUE
            AND
                xpelunasan.tgl
            BETWEEN '$filterawal' AND '$filterakhir'";
        if ($kodecust) {
            $q .= " AND ref_cust = '$kodecust'";
        }
        $result     = $this->db->query($q)->result();
        $list       = [];
        foreach ($result as $i => $r) {
            $row['no']              = $i + 1;
            $row['id']              = $r->id;
            $row['kode']            = $r->kode;
            $row['tgl']             = $r->tgl;
            $row['mcustomer_nama']  = $r->mcustomer_nama;
            $row['mgudang_nama']    = $r->mgudang_nama;
            $row['mjenbayar_nama']  = $r->mjenbayar_nama;
            $row['total']           = number_format($r->total);
            $row['bayar']           = number_format($r->bayar);
            $row['kurang']          = number_format($r->kurang);
            $row['ket']             = $r->ket;
            $row['posted']          = $r->posted;
            $row['ref_jual']        = $r->ref_jual;
            $row['kodeunik']        = $r->kodeunik;
            $row['bank_norek']      = $r->bank_norek;

            $list[] = $row;
        }
        echo json_encode(array('data' => $list));
    }

    public function getdetail()
    {
        $kodepelunasan = $this->input->post('kodepelunasan');
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
                msatuan.nama satuan_nama
            FROM
                xpelunasand
            LEFT JOIN mbarang ON mbarang.kode = xpelunasand.ref_brg
            LEFT JOIN msatbrg ON msatbrg.kode = xpelunasand.ref_satbrg
            LEFT JOIN msatuan ON msatuan.kode = msatbrg.ref_sat
            WHERE xpelunasand.ref_pelun = '$kodepelunasan'";
        $result     = $this->db->query($q)->result();
        $str        = '<table class="table fadeIn animated">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Konv</th>
                            <th>Satuan</th>
                            <th>Harga</th>
                            <th>Keterangan</th>
                        </tr>';
        foreach ($result as $i => $r) {
            $str    .= '<tr>
                            <td>'.($i + 1).'.</td>
                            <td>'.$r->nama.'</td>
                            <td>'.$r->konv.'</td>
                            <td>'.$r->satuan_nama.'</td>
                            <td>'.$r->harga.'</td>
                            <td>'.$r->ket.'</td>
                        </tr>';
        }

        $str        .= '</table>';
        echo $str;
    }

    public function getorder(){
        $kodecust = $this->session->userdata('kodecust');
        $q = "select qr.*, (qr.total)- (qr.dibayar) kurang from (
            select
            xorder.id,
            xorder.kode,
            xorder.tgl,
            xorder.ket,
            xorder.pic,
            xorder.kgkirim,
            xorder.bykirim,
            xorder.ref_cust,
            xorder.ref_kirim,
            mcustomer.nama mcustomer_nama,
            case xorder.ref_kirim
            when 'GX0002' then coalesce(xorder.total,0)
            when 'GX0001' then (coalesce(xorder.total,0) - coalesce(xorder.bykirim,0))
            end as total,
            (select coalesce(sum(xpelunasan.bayar),0) from xpelunasan
            where xpelunasan.void is not true
            and xpelunasan.ref_jual = xorder.kode) dibayar
            from xorder
            join mcustomer on mcustomer.kode = xorder.ref_cust
            order by xorder.datei desc
            ) qr
            where (qr.total)- (qr.dibayar) > 0
            AND qr.ref_cust ='$kodecust'";

        $result     = $this->db->query($q)->result();
        $list       = [];
        foreach ($result as $i => $r) {
            $row['no']              = $i + 1;
            $row['id']              = $r->id;
            $row['kode']            = $r->kode;
            $row['ref_cust']        = $r->ref_cust;
            $row['mcustomer_nama']  = $r->mcustomer_nama;
            $row['tgl']             = normal_date($r->tgl);
            $row['total']           = $r->total;
            $row['dibayar']         = $r->dibayar;
            $row['kurang']          = $r->kurang;
            $row['ket']             = $r->ket;

            $list[] = $row;
        }
        echo json_encode(array('data' => $list));
    }

    public function savedata()
    {
        $this->db->trans_begin();
        $a['useri']     = $this->session->userdata('username');
        $a['ref_cust']  = $this->session->userdata('kodecust');
        $a['tgl']       = date('Y-m-d', strtotime($this->input->post('tgl')));
        $a['total']     = $this->input->post('total');
        $a['bayar']     = $this->input->post('bayar');
        $a['ket']       = $this->input->post('ket');
        $a['ref_jual']  = $this->input->post('ref_order');
        $a['ref_jenbayar']  = $this->input->post('ref_jenbayar');
        $a['ref_bank']  = ien($this->input->post('ref_bank'));
        $a['ref_gud']   = $this->libre->gud_def();
        $a['posted']    = 'f';

        $result = $this->db->insert('xpelunasan',$a);
        // $idpelun    = $this->db->insert_id();
        $idpelun    = insert_id('xpelunasan');
        $kodepelun = $this->db->get_where('xpelunasan',array('id' => $idpelun))->row()->kode;
        $kodeunik = $this->db->get_where('xpelunasan',array('id' => $idpelun))->row()->kodeunik;
        $dataOrderd = $this->db->get_where('xorderd',array('ref_order' => $this->input->post('ref_order')))->result();
        foreach ($dataOrderd as $r) {
            $row    = array(
                "useri"     => $this->session->userdata('username'),
                "ref_pelun" => $kodepelun,
                "ref_brg"   => $r->ref_brg,
                "jumlah"    => $r->jumlah,
                "ref_satbrg"=> ien($r->ref_satbrg),
                "ket"       => $r->ket,
                "harga"     => $r->harga,
            );
            $b[] = $row;
        }
        $result = $this->db->insert_batch('xpelunasand',$b);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $r = array(
                'sukses' => 'fail'
            );
        }
        else {
            $this->db->trans_commit();
            $r = array(
                'sukses' => 'success',
                'kodeunik' => $kodeunik
                );
        }
        echo json_encode($r);
    }

    public function edit()
    {
        $this->input->post('kode');
        $q = "SELECT
                xpelunasan.id,
                xpelunasan.kode,
                xpelunasan.tgl tgl_real,
                to_char(xpelunasan.tgl, 'DD Mon YYYY') tgl,
                xpelunasan.total,
                xpelunasan.bayar,
                xpelunasan.posted,
                xpelunasan.ket,
                xpelunasan.ref_jual,
                xpelunasan.ref_jenbayar,
                xpelunasan.ref_cust,
                xpelunasan.ref_bank,
                mcustomer.nama mcustomer_nama,
                mgudang.nama mgudang_nama,
                mjenbayar.nama mjenbayar_nama
            FROM
                xpelunasan
            LEFT JOIN mcustomer ON mcustomer.kode = xpelunasan.ref_cust
            LEFT JOIN mgudang ON mgudang.kode = xpelunasan.ref_gud
            LEFT JOIN mjenbayar ON mjenbayar.kode = xpelunasan.ref_jenbayar
            WHERE xpelunasan.kode = '{$this->input->post('kode')}' ";
        $data   = $this->db->query($q)->row();
        echo json_encode($data);
    }

    function updatedata()
    {
        $this->db->trans_begin();
        $a['useru']     = $this->session->userdata('username');
        $a['dateu']     = 'now()';
        $a['ref_cust']  = $this->input->post('ref_cust');
        $a['tgl']       = date('Y-m-d', strtotime($this->input->post('tgl')));
        $a['total']     = $this->input->post('total');
        $a['bayar']     = $this->input->post('bayar');
        $a['ket']       = $this->input->post('ket');
        $a['ref_jual']  = $this->input->post('ref_order');
        $a['ref_jenbayar']  = $this->input->post('ref_jenbayar');
        $a['ref_bank']  = ien($this->input->post('ref_bank'));
        $kodepelun           = $this->input->post('kode');

        $result = $this->db->update('xpelunasan',$a,array('kode' => $kodepelun, ));
        $this->db->delete('xpelunasand',array('ref_pelun' => $kodepelun));
        $dataOrderd = $this->db->get_where('xorderd',array('ref_order' => $this->input->post('ref_order')))->result();
        foreach ($dataOrderd as $r) {
            $row    = array(
                "useru"     => $this->session->userdata('username'),
                "dateu"     => 'now()',
                "ref_pelun" => $kodepelun,
                "ref_brg"   => $r->ref_brg,
                "jumlah"    => $r->jumlah,
                "ref_satbrg"=> $r->ref_satbrg,
                "ket"       => $r->ket,
                "harga"     => $r->harga,
            );
            $b[] = $row;
        }
        $result = $this->db->insert_batch('xpelunasand',$b);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $r = array(
                'sukses' => 'fail',
            );
        }
        else {
            $this->db->trans_commit();
            $r = array(
                'sukses' => 'success'
                );
        }
        echo json_encode($r);
    }

    function cek_data_payment()
    {
        $ref_order = $this->input->post('ref_order');
        $q = "SELECT
                SUM ( xpelunasan.bayar ) bayar,
              	xpelunasan.total,
              	xpelunasan.total - SUM ( xpelunasan.bayar ) kurang
              FROM
              	xpelunasan
              WHERE
              	xpelunasan.ref_jual = '$ref_order'
              GROUP BY
              	xpelunasan.total";
        $r['data'] = $this->db->query($q)->row_array();
        echo json_encode($r);
    }

    function validdata() {
        $d['posted']    = 't';
        $w['id']        = $this->input->post('id');
        $result         = $this->db->update('xpelunasan',$d,$w);
        $r['sukses']    = $result ? 'success' : 'fail' ;
        echo json_encode($r);

    }

    function voiddata()
    {
        $d['void']  = 't';
        $d['tglvoid'] = 'now()';
        $w['id']    = $this->input->post('id');
        $result     = $this->db->update($this->table,$d,$w);
        $r['sukses'] = $result ? 'success' : 'fail' ;
        echo json_encode($r);

    }

}
