<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Datapayment extends CI_Controller {

    public $table       = 'xpelunasan';
    public $foldername  = 'xpelunasan';
    public $indexpage   = 'datapayment/v_datapayment';
    function __construct() {
        parent::__construct();
        include(APPPATH.'libraries/sessionakses.php');
        include(APPPATH.'libraries/dbinclude.php');
    }
    function index(){
        $data['jenisbayar'] = $this->dbtwo->get('mjenbayar')->result();
        $data['cust'] = $this->dbtwo->get('mcustomer')->result();
        $this->load->view($this->indexpage,$data);
    }

    public function getall(){
        $filterawal = date('Y-m-d', strtotime($this->input->post('filterawal')));
        $filterakhir = date('Y-m-d', strtotime($this->input->post('filterakhir')));
        $filteragen = $this->input->post('filteragen');
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
                mcustomer.nama mcustomer_nama,
                mgudang.nama mgudang_nama,
                mjenbayar.nama mjenbayar_nama
            FROM
                xpelunasan
            LEFT JOIN mcustomer ON mcustomer.kode = xpelunasan.ref_cust
            LEFT JOIN mgudang ON mgudang.kode = xpelunasan.ref_gud
            LEFT JOIN mjenbayar ON mjenbayar.kode = xpelunasan.ref_jenbayar
            WHERE xpelunasan.void IS NOT TRUE
            AND
                xpelunasan.tgl
            BETWEEN '$filterawal' AND '$filterakhir'";
        if ($filteragen) {
            $q .= " AND ref_cust = '$filteragen'";
        }
        $result     = $this->dbtwo->query($q)->result();
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
        $result     = $this->dbtwo->query($q)->result();
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
        $q = "select qr.*, (COALESCE(qr.total,0))- (COALESCE(qr.dibayar,0)) kurang from (
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
                when 'GX0002' then xorder.total
                when 'GX0001' then xorder.total - xorder.bykirim
                end as total,
                (select sum(xpelunasan.bayar) from xpelunasan
                where xpelunasan.void is not true
                and xpelunasan.ref_jual = xorder.kode) dibayar
                from xorder
                join mcustomer on mcustomer.kode = xorder.ref_cust
                ) qr
                where (qr.total - (COALESCE(qr.dibayar,0))) > 0";
        $result     = $this->dbtwo->query($q)->result();
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
        $this->dbtwo->trans_begin();
        $a['useri']     = $this->session->userdata('username');
        $a['ref_cust']  = $this->input->post('ref_cust');
        $a['tgl']       = date('Y-m-d', strtotime($this->input->post('tgl')));
        $a['total']     = $this->input->post('total');
        $a['bayar']     = $this->input->post('bayar');
        $a['ket']       = $this->input->post('ket');
        $a['ref_jual']  = $this->input->post('ref_order');
        $a['ref_jenbayar']  = $this->input->post('ref_jenbayar');
        $a['ref_gud']   = $this->libre->gud_def();
        $a['posted']    = 'f';

        $result = $this->dbtwo->insert('xpelunasan',$a);
        // $idpelun = $this->dbtwo->insert_id();
        $idpelun = $this->dbtwo->insert_id('public."xpelunasan_id_seq"');
        $kodepelun = $this->dbtwo->get_where('xpelunasan',array('id' => $idpelun))->row()->kode;
        $kodeunik = $this->dbtwo->get_where('xpelunasan',array('id' => $idpelun))->row()->kodeunik;
        $dataOrderd = $this->dbtwo->get_where('xorderd',array('ref_order' => $this->input->post('ref_order')))->result();
        foreach ($dataOrderd as $r) {
            $row    = array(
                "useri"     => $this->session->userdata('username'),
                "ref_pelun" => $kodepelun,
                "ref_brg"   => $r->ref_brg,
                "jumlah"    => $r->jumlah,
                "ref_satbrg"=> $r->ref_satbrg,
                "ket"       => $r->ket,
                "harga"     => $r->harga,
            );
            $b[] = $row;
        }
        $result = $this->dbtwo->insert_batch('xpelunasand',$b);
        if ($this->dbtwo->trans_status() === FALSE) {
            $this->dbtwo->trans_rollback();
            $r = array(
                'sukses' => 'fail',
            );
        }
        else {
            $this->dbtwo->trans_commit();
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
                mcustomer.nama mcustomer_nama,
                mgudang.nama mgudang_nama,
                mjenbayar.nama mjenbayar_nama
            FROM
                xpelunasan
            LEFT JOIN mcustomer ON mcustomer.kode = xpelunasan.ref_cust
            LEFT JOIN mgudang ON mgudang.kode = xpelunasan.ref_gud
            LEFT JOIN mjenbayar ON mjenbayar.kode = xpelunasan.ref_jenbayar
            WHERE xpelunasan.kode = '{$this->input->post('kode')}' ";
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
        $a['total']     = $this->input->post('total');
        $a['bayar']     = $this->input->post('bayar');
        $a['ket']       = $this->input->post('ket');
        $a['ref_jual']  = $this->input->post('ref_order');
        $a['ref_jenbayar']  = $this->input->post('ref_jenbayar');
        $kodepelun           = $this->input->post('kode');

        $result = $this->dbtwo->update('xpelunasan',$a,array('kode' => $kodepelun, ));
        $this->dbtwo->delete('xpelunasand',array('ref_pelun' => $kodepelun));
        $dataOrderd = $this->dbtwo->get_where('xorderd',array('ref_order' => $this->input->post('ref_order')))->result();
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
        $result = $this->dbtwo->insert_batch('xpelunasand',$b);
        if ($this->dbtwo->trans_status() === FALSE) {
            $this->dbtwo->trans_rollback();
            $r = array(
                'sukses' => 'fail',
            );
        }
        else {
            $this->dbtwo->trans_commit();
            $r = array(
                'sukses' => 'success'
                );
        }
        echo json_encode($r);
    }

    function validdata() {
        $d['posted']    = 't';
        $d['tglposted'] = date("Y-m-d");
        $w['id']        = $this->input->post('id');
        $result         = $this->dbtwo->update('xpelunasan',$d,$w);
        $kodeorder      = $this->dbtwo->get_where('xpelunasan',$w)->row();
        $q = "SELECT
                xorder.kode,
                mmodesign.nama,
                xorderd.jumlah,
                xpelunasan.tglposted + INTEGER '15' tglposted,
                _product_id,
                _design_id,
                _order_id
              FROM
                xorder
              LEFT JOIN xpelunasan ON xorder.kode = xpelunasan.ref_jual
              LEFT JOIN xorderd ON xorder.kode = xorderd.ref_order
              LEFT JOIN xorderds ON xorderd. ID = xorderds.ref_orderd
              LEFT JOIN mmodesign ON mmodesign.kode = xorderds.ref_modesign
              WHERE
                xorder.kode = '$kodeorder->ref_jual'";
        $data['dataorder'] = $this->dbtwo->query($q)->result_array();
        $message = $this->load->view('datapayment/e_datapayment',$data, true);
        if ($kodeorder != NULL || $kodeorder != '')
        {
            $this->sendemail($kodeorder->ref_jual, $message);
        }
        $r['sukses']    = $result ? 'success' : 'fail' ;
        echo json_encode($r);
    }

    public function sendemail($kodeorder = '', $message)
    {
        $emailto        = 'ihsanwst@yahoo.com';
        // $emailto        = 'kimbisnis3@gmail.com';
        // adm_taspromo@yahoo.co.id
        $subject        = 'No Reply';
        // $message        = 'Pembayaran Untuk Pesanan '.$kodeorder.' Sudah divalidasi';
        $config_name    = 'Pabrik Tas Custom';
        $config_email   = 'gongsoft.olinbags@gmail.com';
        $config_pass    = 'gongsoft2019mkj';

        $config = Array(
                'protocol'  => 'smtp',
                'smtp_host' => 'ssl://smtp.gmail.com',
                'smtp_port' => 465,
                'smtp_user' => $config_email,
                'smtp_pass' => $config_pass,
                'mailtype'  => 'html',
                'charset'   => 'iso-8859-1',
                'wordwrap'  => TRUE
                );

        $this->load->library('email',$config);
        $this->email->set_newline("\r\n");
        $this->email->from($config_email, $config_name);
        $this->email->to($emailto);
        $this->email->subject($subject);
        $this->email->message($message);
        $this->email->send();
        if ($this->email->send()) {
                return 1;
        }else{
                return 0;
        }
    }

    function voiddata()
    {
        $d['void']  = 't';
        $d['tglvoid'] = 'now()';
        $w['id']    = $this->input->post('id');
        $result     = $this->dbtwo->update($this->table,$d,$w);
        $r['sukses'] = $result ? 'success' : 'fail' ;
        echo json_encode($r);

    }

    function html_email()
    {
        $q = "SELECT
                xorder.kode,
                mmodesign.nama,
                xorderd.jumlah,
                xpelunasan.tglposted + INTEGER '15' tglposted,
                _product_id,
                _design_id,
                _order_id
              FROM
                xorder
              LEFT JOIN xpelunasan ON xorder.kode = xpelunasan.ref_jual
              LEFT JOIN xorderd ON xorder.kode = xorderd.ref_order
              LEFT JOIN xorderds ON xorderd. ID = xorderds.ref_orderd
              LEFT JOIN mmodesign ON mmodesign.kode = xorderds.ref_modesign
              WHERE
                xorder.kode = '0038/PO/MKJ/XI/2019'";
        $data['dataorder'] = $this->dbtwo->query($q)->result_array();
        $message = $this->load->view('datapayment/e_datapayment',$data, true);
        $this->sendemail($kodeorder = '', $message);
    }

}
