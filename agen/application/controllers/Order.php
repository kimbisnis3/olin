<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Order extends CI_Controller {

    public $table       = 'xorder';
    public $foldername  = 'order';
    public $indexpage   = 'order/v_order';
    public $printpage   = 'order/p_order';

    function __construct() {
        parent::__construct();
        include(APPPATH . 'libraries/dbinclude.php');
    }
    function index(){
        include(APPPATH.'libraries/sessionakses.php');
        $data['mlayanan'] = $this->dbtwo->get('mlayanan')->result();
        $data['mkirim'] = $this->dbtwo->get('mkirim')->result();
        $data['agen'] = $this->dbtwo->get('mcustomer')->result();
        $this->load->view($this->indexpage,$data);
    }

    public function getall(){
        $filterawal = date('Y-m-d', strtotime($this->input->post('filterawal')));
        $filterakhir = date('Y-m-d', strtotime($this->input->post('filterakhir')));
        $filteragen = $this->input->post('filteragen');
        $filterproses = $this->input->post('filterproses');
        $q = "SELECT
                xorder.*,
                mcustomer.nama namacust,
                mkirim.nama mkirim_nama,
                mlayanan.nama mlayanan_nama,
                (SELECT count(statusd) FROM xorderd WHERE xorderd.ref_order = xorder.kode) jmlorder,
                (SELECT count(statusd) FROM xorderd WHERE xorderd.ref_order = xorder.kode AND statusd=4) orderdone
            FROM
                xorder
            LEFT JOIN mcustomer ON mcustomer.kode = xorder.ref_cust
            LEFT JOIN mkirim ON mkirim.kode = xorder.ref_kirim
            LEFT JOIN mlayanan ON mlayanan.kode = xorder.ref_layanan
            WHERE xorder.void IS NOT TRUE
            AND
                xorder.tgl
            BETWEEN '$filterawal' AND '$filterakhir'";
        if ($filteragen) {
            $q .= " AND ref_cust = '$filteragen'";
        }
        if ($filterproses == '1') {
            $q .= " AND xorder.kode IN ( SELECT ref_order FROM xprocorder)";
        } else if ($filterproses == '0') {
            $q .= " AND xorder.kode NOT IN ( SELECT ref_order FROM xprocorder)";
        }
        $q .=" ORDER BY xorder.id DESC" ;
        $result     = $this->dbtwo->query($q)->result();
        $list       = [];
        foreach ($result as $i => $r) {
            $row['no']          = $i + 1;
            $row['id']          = $r->id;
            $row['kode']        = $r->kode;
            $row['tgl']         = normal_date($r->tgl);
            $row['namacust']    = $r->namacust;
            $row['kgkirim']     = $r->kgkirim;
            $row['bykirim']     = number_format($r->bykirim);
            $row['mkirim_nama'] = $r->mkirim_nama." - ".strtoupper($r->kurir);
            $row['lokasidari']  = $r->lokasidari;
            $row['lokasike']    = $r->lokasike;
            $row['ket']         = $r->ket;
            $row['pathcorel']   = $r->pathcorel;
            $row['pathimage']   = $r->pathimage;
            $row['kirimke']     = $r->kirimke;
            $row['mlayanan_nama']= $r->mlayanan_nama;
            $row['status']      = $this->status_po($r->status);
            $row['jmlorder']    = $r->jmlorder;
            $row['orderdone']   = $r->orderdone;
            $row['totalall']    = number_format($r->total + $r->bykirim);
            $row['statusorder'] = ($r->orderdone == $r->jmlorder) ? '<span class="label label-success">Selesai Semua</span>' : '<span class="label label-warning">Belum Selesai</span>' ;
            $list[] = $row;
        }
        echo json_encode(array('data' => $list));
    }

    public function getdetail()
    {
        $xorderkode = $this->input->post('xorderkode');
        $q = "SELECT
                mbarang.id,
                mbarang.kode,
                mbarang.nama,
                mbarang.ket,
                msatbrg.id idsatbarang,
                msatbrg.konv,
                msatbrg.ket ketsat,
                msatbrg.ref_brg,
                msatbrg.ref_sat,
                msatuan.nama satuan,
                mgudang.nama gudang,
                xorderd.harga,
                xorderd.jumlah,
                xorderd.statusd,
                xorderd.jumlah * xorderd.harga subtotal,
                xorderd._product_id,
                xorderd._design_id,
                xorderd._order_id
            FROM
                xorderd
            LEFT JOIN mbarang ON mbarang.kode = xorderd.ref_brg
            LEFT JOIN msatbrg ON msatbrg.kode = xorderd.ref_satbrg
            LEFT JOIN msatuan ON msatuan.kode = msatbrg.ref_sat
            LEFT JOIN mgudang ON mgudang.kode = msatbrg.ref_gud
            WHERE xorderd.ref_order = '$xorderkode'";
        $brg     = $this->dbtwo->query($q)->result();

        $p ="SELECT
                xorderds.id,
                xorderds.ket,
                mbarang.nama,
                mmodesign.nama mmodesign_nama,
                mmodesign.gambar mmodesign_gambar,
                mwarna.nama mwarna_nama,
                mwarna.colorc mwarna_colorc
            FROM
                xorderds
            LEFT JOIN mmodesign ON mmodesign.kode = xorderds.ref_modesign
            LEFT JOIN mwarna ON mwarna.kode = xorderds.ref_warna
            LEFT JOIN xorderd ON xorderd. ID = xorderds.ref_orderd
            LEFT JOIN mbarang ON mbarang.kode = xorderd.ref_brg
            LEFT JOIN xorder ON xorder.kode = xorderd.ref_order
            WHERE xorder.kode = '$xorderkode'";
        $spek    = $this->dbtwo->query($p)->result();
        $tabs   = '<div class="nav-tabs-custom fadeIn animated">
                  <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_1" data-toggle="tab">Data Produk</a></li>
                    <li style="display : none"><a href="#tab_2" data-toggle="tab">Data Spesifikasi</a></li>
                  </ul>
                  <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">';
        $tabs   .= '<table class="table">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode</th>
                            <th>Produk</th>
                            <th>Jumlah</th>
                            <th>Satuan</th>
                            <th>Harga</th>
                            <th>Subtotal</th>
                            <th>Keterangan</th>
                            <th>Status</th>
                            <th>Design</th>
                        </tr>
                        <thead>';
        foreach ($brg as $i => $r) {
            $tabs    .= '<tbody>
                        <tr>
                            <td>'.($i + 1).'.</td>
                            <td>'.$r->kode.'</td>
                            <td>'.$r->nama.'</td>
                            <td>'.$r->jumlah.'</td>
                            <td>'.$r->satuan.'</td>
                            <td>'.number_format($r->harga).'</td>
                            <td>'.number_format($r->subtotal).'</td>
                            <td>'.$r->ket.'</td>
                            <td>'.$this->status_po($r->statusd).'</td>
                            <td><button class="btn btn-success btn-flat btn-sm" onclick="grab_design(\''.$r->_product_id.'\',\''.$r->_design_id.'\',\''.$r->_order_id.'\')">Design</button></td>
                        </tr>
                        </tbody>';
        }
        $tabs .= '</table>';
        $tabs .=    '</div>
                    <div class="tab-pane" id="tab_2">';

        $tabs   .= '<table class="table">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Produk</th>
                            <th>Nama Spesifikasi</th>
                            <th>Gambar</th>
                            <th>Nama Warna</th>
                            <th>Warna</th>
                        </tr>
                        <thead>';
        foreach ($spek as $i => $r) {
            $tabs    .= '<tbody>
                        <tr>
                            <td>'.($i + 1).'.</td>
                            <td>'.$r->nama.'</td>
                            <td>'.$r->mmodesign_nama.'</td>
                            <td>'.showimage($r->mmodesign_gambar).'</td>
                            <td>'.$r->mwarna_nama.'</td>
                            <td><div style="witdh:10px; height:20px; background-color:'.$r->mwarna_colorc.'" ></div></td>

                        </tr>
                        </tbody>';
        }
        $tabs .= '</table>';
        $tabs .='   </div>
                  </div>
                </div>';
        echo $tabs;
    }

    public function status_po($s)
    {
        if ($s == 0) {
            $s = '<span class="label label-warning">Pending</span>';
        } else if($s == 1) {
            $s = '<span class="label label-success">Proses</span>';
        } else if($s >= 2) {
            $s = '<span class="label label-info">Sudah Dikirim</span>';
        }
        return $s;
    }

    function getstatus()
    {
        $kode = $this->input->post('kode');
        $result = $this->dbtwo->get_where('xorder',array('kode' => $kode))->row();
        echo json_encode($result);
    }

    function updatestatus()
    {
        $w['kode']      = $this->input->post('kode_po');
        $d['status']    = $this->input->post('status_po');
        $result = $this->dbtwo->update('xorder',$d,$w);
        $r['sukses'] = $result ? 'success' : 'fail' ;
        echo json_encode($r);
    }

    public function loadfilelist(){
        $q = "SELECT
                xorder.id,
                xorder.kode,
                xorder.pathcorel,
                xorder.pathimage
            FROM
                xorder
            WHERE xorder.kode = '{$this->input->post('xorderkode')}'";
        $result     = $this->dbtwo->query($q)->result();
        $list       = [];
        foreach ($result as $i => $r) {
            $row['no']      = $i + 1;
            $row['id']          = $r->id;
            $row['kode']        = $r->kode;
            $row['elempathcorel']   = btndownload($r->pathcorel);
            $row['elempathimage']   = dlimage($r->pathimage);
            $row['pathcorel']   = $r->pathcorel;
            $row['pathimage']   = imghandler($r->pathimage,60);
            $list[] = $row;
        }
        echo json_encode(array('data' => $list));
    }

    public function savedata()
    {
        $upcorel    = $this->libre->goUpload('corel','corel-'.time(),$this->foldername);
        $upimage    = $this->libre->goUpload('image','img-'.time(),$this->foldername);
        $this->dbtwo->trans_begin();
        $a['pathcorel'] = $upcorel;
        $a['pathimage'] = $upimage;
        $a['useri']     = $this->session->userdata('username');
        $a['ref_cust']  = $this->input->post('ref_cust');
        $a['tgl']       = date('Y-m-d', strtotime($this->input->post('tgl')));
        $a['ref_gud']   = $this->libre->gud_def();
        $a['ket']       = $this->input->post('ket');
        $a['ref_kirim'] = $this->input->post('ref_kirim');
        $a['ref_layanan'] = $this->input->post('ref_layanan');
        $a['kirimke']   = $this->input->post('kirimke');
        $a['alamat']    = $this->input->post('alamat');
        if ($this->input->post('ref_kirim') == 'GX0002') {
            $a['kodeprovfrom']  = $this->input->post('provinsi');
            $a['kodeprovto']    = $this->input->post('provinsito');
            $a['kodecityfrom']  = $this->input->post('city');
            $a['kodecityto']    = $this->input->post('cityto');
            $a['lokasidari']= $this->input->post('mask-provinsi').' - '.$this->input->post('mask-city');
            $a['lokasike']  = $this->input->post('mask-provinsito').' - '.$this->input->post('mask-cityto');
            $a['kgkirim']   = $this->input->post('berat');
            $a['bykirim']   = $this->input->post('biaya');
            $a['kodekurir'] = $this->input->post('kodekurir');
            $a['kurir']     = $this->input->post('kurir');
        }
        $this->dbtwo->insert('xorder',$a);

        $idOrder = $this->dbtwo->insert_id();
        $kodeOrder = $this->dbtwo->get_where('xorder',array('id' => $idOrder))->row()->kode;
        $kodebrg    = $this->input->post('kodebrg');
        $arr_produk = $this->input->post('arr_produk');
        foreach (json_decode($arr_produk) as $r) {
            $Brg = $this->dbtwo->query("
            SELECT
                msatbrg.kode msatbrg_kode,
                msatbrg.ref_brg msatbrg_ref_brg,
                msatbrg.harga msatbrg_harga,
                msatbrg.ref_gud msatbrg_ref_gud,
                msatbrg.ket msatbrg_ket
            FROM
                mbarang
            LEFT JOIN msatbrg ON msatbrg.ref_brg = mbarang.kode
            WHERE
                msatbrg.def = 't'
            AND mbarang.kode = '$r->kode'")->row();
            $rowb['useri']     = $this->session->userdata('username');
            $rowb['ref_order'] = $kodeOrder;
            $rowb['ref_brg']   = $Brg->msatbrg_ref_brg;
            $rowb['jumlah']    = $r->jumlah;
            $rowb['harga']     = str_replace(",","",$r->harga);
            $rowb['ref_satbrg']= $Brg->msatbrg_kode;
            $rowb['ref_gud']   = $Brg->msatbrg_ref_gud;
            $rowb['ket']       = $Brg->msatbrg_ket;
            $b[] = $rowb;
        }
        $this->dbtwo->delete('xorderd',array('ref_order' => $kodeOrder));
        $this->dbtwo->insert_batch('xorderd',$b);
        $idOrderd = $this->dbtwo->get_where('xorderd',array('ref_order' => $kodeOrder))->result();
        foreach ($idOrderd as $i) {
        $kodebarang = $this->dbtwo->get_where('xorderd',array('id' => $i->id))->row()->ref_brg;
        $design = $this->dbtwo->get_where('mbarangs',array('ref_brg' => $kodebarang))->result();
            foreach ($design as $r) {
                $row    = array(
                    "useri"         => $this->session->userdata('username'),
                    "ref_orderd"    => $i->id,
                    "ref_modesign"  => $r->model,
                    "ref_warna"     => $r->warna,
                    "ket"           => $r->ket
                );
                $c[] = $row;
            }
        }
        if (count($design) > 0) {
            $this->dbtwo->insert_batch('xorderds',$c);
        }
        $d['total'] = $this->input->post('total') + $this->input->post('biaya');
        $this->dbtwo->update('xorder',$d,array('kode' => $kodeOrder));

        if ($this->dbtwo->trans_status() === FALSE)
        {
            $this->dbtwo->trans_rollback();
            @unlink(".".$upcorel);
            @unlink(".".$upimage);
            $r = array(
                'sukses' => 'fail',
            );
        }
        else
        {
            $this->dbtwo->trans_commit();
            $r = array(
                'sukses' => 'success',
                );
        }
        echo json_encode($r);
    }

    public function edit()
    {
        $q_po = "SELECT
                xorder.*,
                xorder.id,
                xorder.kode,
                to_char(xorder.tgl, 'DD Mon YYYY') tgl,
                xorder.ref_cust,
                xorder.ref_gud,
                xorder.ket,
                xorder.total,
                xorder.pic,
                xorder.ref_kirim,
                xorder.kgkirim,
                xorder.bykirim,
                xorder.ref_layanan,
                xorder.kurir,
                xorder.lokasidari,
                xorder.lokasike,
                xorder.kodeprovfrom,
                xorder.kodeprovto,
                xorder.kodecityfrom,
                xorder.kodecityto,
                xorder.alamat,
                xorder.kirimke,
                mcustomer.nama mcustomer_nama
            FROM
                xorder
            LEFT JOIN mcustomer ON mcustomer.kode = xorder.ref_cust
            WHERE xorder.kode = '{$this->input->post('kode')}'";

        $q_barang ="SELECT
                xorderd.id,
                xorderd.jumlah,
                xorderd.harga,
                mbarang.nama,
                mbarang.kode,
                msatbrg.beratkg
            FROM
                xorderd
            LEFT JOIN mbarang ON mbarang.kode = xorderd.ref_brg
            LEFT JOIN msatbrg ON mbarang.kode = msatbrg.ref_brg
            WHERE xorderd.ref_order = '{$this->input->post('kode')}'";
        $q_barang .=" AND msatbrg.def = 't'";
        $po         = $this->dbtwo->query($q_po)->row();
        $barang     = $this->dbtwo->query($q_barang)->result();
        echo json_encode(
            array(
                'po'    => $po,
                'barang'=> $barang,
        ));
    }

    public function updatedata()
    {
        $this->dbtwo->trans_begin();
        $kodeorder      = $this->input->post('kode');
        $a['useru']     = $this->session->userdata('username');
        $a['dateu']     = 'now()';
        $a['ref_cust']  = $this->input->post('ref_cust');
        $a['tgl']       = date('Y-m-d', strtotime($this->input->post('tgl')));
        $a['ref_gud']   = $this->libre->gud_def();
        $a['ket']       = $this->input->post('ket');
        $a['ref_kirim'] = $this->input->post('ref_kirim');
        $a['ref_layanan'] = $this->input->post('ref_layanan');
        $a['kirimke']   = $this->input->post('kirimke');
        $a['alamat']    = $this->input->post('alamat');
        if ($this->input->post('ref_kirim') == 'GX0002') {
            $a['kodeprovfrom']  = $this->input->post('provinsi');
            $a['kodeprovto'] = $this->input->post('provinsito');
            $a['kodecityfrom']  = $this->input->post('city');
            $a['kodecityto']    = $this->input->post('cityto');
            $a['lokasidari']= $this->input->post('mask-provinsi').' - '.$this->input->post('mask-city');
            $a['lokasike']  = $this->input->post('mask-provinsito').' - '.$this->input->post('mask-cityto');
            $a['kgkirim']   = $this->input->post('berat');
            $a['bykirim']   = $this->input->post('biaya');
            $a['kodekurir'] = $this->input->post('kodekurir');
            $a['kurir']     = $this->input->post('kurir');
        }
        $this->dbtwo->update('xorder',$a,array('kode' => $kodeorder));
        $kodebrg = $this->input->post('kodebrg');
        $d['total'] = $this->input->post('total') + $this->input->post('biaya');
        $this->dbtwo->update('xorder',$d,array('kode' => $kodeorder));
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

    function updatefile()
    {
        if (!empty($_FILES['editcorel']['name'])) {
            $upcorel    = $this->libre->goUpload('editcorel','corel-'.time(),$this->foldername);
            $a['pathcorel'] = $upcorel;
            $oldpath = $this->input->post('editpathcorel');
            @unlink(".".$oldpath);
        } else {
            $a['pathcorel'] = $this->input->post('editpathcorel');
        }

        if (!empty($_FILES['editimage']['name'])) {
            $upcorel    = $this->libre->goUpload('editimage','image-'.time(),$this->foldername);
            $a['pathimage'] = $upcorel;
            $oldpath = $this->input->post('editpathimage');
            @unlink(".".$oldpath);
        } else {
            $a['pathimage'] = $this->input->post('editpathimage');
        }

        $result = $this->dbtwo->update('xorder',$a,array('kode' => $this->input->post('editkodefile')));
        $r['sukses']    = $result ? 'success' : 'fail' ;
        echo json_encode($r);
    }

    function loadcustomer(){
        $q = "SELECT
                mcustomer.id,
                mcustomer.kode,
                mcustomer.nama,
                mcustomer.alamat,
                mcustomer.telp,
                mcustomer.fax,
                mcustomer.email,
                mcustomer.pic,
                mcustomer.ket,
                mcustomer.aktif
            FROM
                mcustomer
            WHERE aktif = 't'";
        $result     = $this->dbtwo->query($q)->result();
        $list       = [];
        foreach ($result as $i => $r) {
            $row['id']      = $r->id;
            $row['no']      = $i + 1;
            $row['kode']    = $r->kode;
            $row['nama']    = $r->nama;
            $row['alamat']  = $r->alamat;
            $row['telp']    = $r->telp;
            $row['email']   = $r->email;

            $list[] = $row;
        }
        echo json_encode(array('data' => $list));
    }

    function loadbrg() {
        $q = "SELECT
                mbarang. ID,
                mbarang.kode,
                mbarang.nama,
                mbarang.ket,
                msatbrg. ID idsatbarang,
                msatbrg.konv,
                msatbrg.ket,
                msatbrg.harga,
                ( COALESCE( msatbrg.beratkg, 0 )) beratkg,
                msatbrg.ref_brg,
                msatbrg.ref_sat,
                msatbrg.ref_gud,
                msatuan.nama namasatuan,
                mgudang.nama namagudang,
                (
                    SELECT
                        COUNT (mbarangs. ID)
                    FROM
                        mbarangs
                    WHERE
                        mbarangs.ref_brg = mbarang.kode
                ) jumlahspek
            FROM
                mbarang
            LEFT JOIN msatbrg ON msatbrg.ref_brg = mbarang.kode
            LEFT JOIN msatuan ON msatuan.kode = msatbrg.ref_sat
            LEFT JOIN mgudang ON mgudang.kode = msatbrg.ref_gud
            WHERE
                msatbrg.def = 't'
            AND (
                SELECT
                    COUNT (mbarangs. ID)
                FROM
                    mbarangs
                WHERE
                    mbarangs.ref_brg = mbarang.kode
            ) > 0
            AND mbarang.ref_ktg != 'GX0002'";
        $result     = $this->dbtwo->query($q)->result();
        $list       = [];
        foreach ($result as $i => $r) {
            $row['id']          = $r->id;
            $row['no']          = $i + 1;
            $row['nama']        = $r->nama;
            $row['kode']        = $r->kode;
            $row['ket']         = $r->ket;
            $row['namasatuan']  = $r->namasatuan;
            $row['konv']        = $r->konv;
            $row['harga']       = $r->harga;
            $row['beratkg']     = $r->beratkg;

            $list[] = $row;
        }
        echo json_encode(array('data' => $list));
    }

    public function deletedata()
    {
        $d['void'] = 't';
        $d['tglvoid'] = 'now()';
        $w['id'] = $this->input->post('id');
        $result = $this->dbtwo->update($this->table,$d,$w);
        $r['sukses'] = $result ? 'success' : 'fail' ;
        echo json_encode($r);
    }

    public function addbarang()
    {
        $this->dbtwo->trans_begin();
        $kodebarang = $this->input->post('kode');
        $kodeorder  = $this->input->post('kodeorder');
        $Brg = $this->dbtwo->query("
            SELECT
                msatbrg.kode msatbrg_kode,
                msatbrg.ref_brg msatbrg_ref_brg,
                msatbrg.harga msatbrg_harga,
                msatbrg.ref_gud msatbrg_ref_gud,
                msatbrg.ket msatbrg_ket
            FROM
                mbarang
            LEFT JOIN msatbrg ON msatbrg.ref_brg = mbarang.kode
            WHERE
                msatbrg.def = 't'
            AND mbarang.kode = '$kodebarang'")->row();

        $a['useri']     = $this->session->userdata('username');
        $a['ref_order'] = $kodeorder;
        $a['ref_brg']   = $Brg->msatbrg_ref_brg;
        $a['jumlah']    = $this->input->post('jumlah');
        $a['harga']     = str_replace(",","",$this->input->post('harga'));
        $a['ref_satbrg']= $Brg->msatbrg_kode;
        $a['ref_gud']   = $Brg->msatbrg_ref_gud;
        $a['ket']       = $Brg->msatbrg_ket;
        $this->dbtwo->insert('xorderd',$a);
        // $idorderd= $this->dbtwo->insert_id();
        $idorderd = $this->dbtwo->insert_id('public."xorderd_id_seq"');
        $design  = $this->dbtwo->get_where('mbarangs',array('ref_brg' => $kodebarang))->result();
            foreach ($design as $r) {
                $row    = array(
                    "useri"         => $this->session->userdata('username'),
                    "ref_orderd"    => $idorderd,
                    "ref_modesign"  => $r->model,
                    "ref_warna"     => $r->warna,
                    "ket"           => $r->ket
                );
                $c[] = $row;
            }
        $this->dbtwo->delete('xorderds',array('ref_orderd' => $idorderd));
        if (count($design) > 0) {
            $this->dbtwo->insert_batch('xorderds',$c);
        }
        $q_barang = " SELECT
                xorderd.id,
                xorderd.jumlah,
                xorderd.harga,
                mbarang.nama,
                mbarang.kode,
                msatbrg.beratkg
            FROM
                xorderd
            LEFT JOIN mbarang ON mbarang.kode = xorderd.ref_brg
            LEFT JOIN msatbrg ON mbarang.kode = msatbrg.ref_brg
            WHERE xorderd.ref_order = '$kodeorder'";
        $q_barang .=" AND msatbrg.def = 't'";
        $barang = $this->dbtwo->query($q_barang)->result();
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
                'sukses' => 'success',
                'barang' => $barang,
            );
        }
        echo json_encode($r);
    }

    public function updatebarang() {
        $this->dbtwo->trans_begin();
        $kodebarang = $this->input->post('kode');
        $idorderd = $this->input->post('id');
        $kodeorder  = $this->input->post('kodeorder');
        $Brg = $this->dbtwo->query("
            SELECT
                msatbrg.kode msatbrg_kode,
                msatbrg.ref_brg msatbrg_ref_brg,
                msatbrg.harga msatbrg_harga,
                msatbrg.ref_gud msatbrg_ref_gud,
                msatbrg.ket msatbrg_ket
            FROM
                mbarang
            LEFT JOIN msatbrg ON msatbrg.ref_brg = mbarang.kode
            WHERE
                msatbrg.def = 't'
            AND mbarang.kode = '$kodebarang'")->row();

        $a['useru']     = $this->session->userdata('username');
        $a['dateu']     = 'now()';
        $a['ref_order'] = $kodeorder;
        $a['ref_brg']   = $Brg->msatbrg_ref_brg;
        $a['jumlah']    = $this->input->post('jumlah');
        $a['harga']     = str_replace(",","",$this->input->post('harga'));
        $a['ref_satbrg']= $Brg->msatbrg_kode;
        $a['ref_gud']   = $Brg->msatbrg_ref_gud;
        $a['ket']       = $Brg->msatbrg_ket;
        $w['id']        = $this->input->post('id');
        $this->dbtwo->update('xorderd',$a,$w);
        $design  = $this->dbtwo->get_where('mbarangs',array('ref_brg' => $kodebarang))->result();
            foreach ($design as $r) {
                $row    = array(
                    "useru"         => $this->session->userdata('username'),
                    "dateu"         => 'now()',
                    "ref_orderd"    => $idorderd,
                    "ref_modesign"  => $r->model,
                    "ref_warna"     => $r->warna,
                    "ket"           => $r->ket
                );
                $c[] = $row;
            }
        $this->dbtwo->delete('xorderds',array('ref_orderd' => $idorderd));
        if (count($design) > 0) {
            $this->dbtwo->insert_batch('xorderds',$c);
        }
        $q_barang = " SELECT
                xorderd.id,
                xorderd.jumlah,
                xorderd.harga,
                mbarang.nama,
                mbarang.kode,
                msatbrg.beratkg
            FROM
                xorderd
            LEFT JOIN mbarang ON mbarang.kode = xorderd.ref_brg
            LEFT JOIN msatbrg ON mbarang.kode = msatbrg.ref_brg
            WHERE xorderd.ref_order = '$kodeorder'";
        $q_barang .=" AND msatbrg.def = 't'";
        $barang = $this->dbtwo->query($q_barang)->result();
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
                'sukses' => 'success',
                'barang' => $barang,
            );
        }
        echo json_encode($r);
    }

    public function deletebarang()
    {
        $w['id'] = $this->input->post('id');
        $kodeorder = $this->dbtwo->get_where('xorderd',array('id' => $this->input->post('id')))->row()->ref_order;
        $z['total'] = $this->input->post('total');
        $result = $this->dbtwo->delete('xorderd',$w);
        $r['sukses'] = $result ? 'success' : 'fail' ;
        echo json_encode($r);
    }

    function request_province() {
        $response = $this->libre->get_province_ro();
        $data = json_decode($response, true);
        $op = "<option value=''>-</option>";
            for ($i=0; $i < count($data['rajaongkir']['results']); $i++) {
                $op .="<option value='".$data['rajaongkir']['results'][$i]['province_id']."'>".$data['rajaongkir']['results'][$i]['province']."</option>";
              }
        echo $op;

    }

    function request_city() {
        $provincecode = $this->input->get('province');
        $response = $this->libre->get_city_ro($provincecode);
        $data = json_decode($response, true);
        $op = "<option value=''>-</option>";
            for ($i=0; $i < count($data['rajaongkir']['results']); $i++) {
              $op .=  "<option value='".$data['rajaongkir']['results'][$i]['city_id']."'>".$data['rajaongkir']['results'][$i]['city_name']."</option>";
              }
        echo $op;

    }

    function request_ongkir() {
        $origin         = $this->input->get('origin');
        $destination    = $this->input->get('destination');
        // $weight         = $this->input->get('weight') * 1000;
        $weight         = 1 * 1000;
        $courier        = $this->input->get('courier');
        $response = $this->libre->get_ongkir_ro($origin,$destination,$weight,$courier);
        $data = json_decode($response, true);
        $op = "<option value=''>-</option>";
            for ($i=0; $i < count($data['rajaongkir']['results'][0]['costs']); $i++) {
            $res = $data['rajaongkir']['results'][0]['costs'][$i];
            $op .= "<option value='@".$res['service']."@?".$res['cost'][0]['value']."?'>".$res['service']." (".$res['description']." | Perkilo | ".number_format($res['cost'][0]['value']).")</option>";
            }
        echo $op;

    }

    function cetak() {
        $kode = $this->input->get('kode');
        $order  = "SELECT
                xorder.id,
                xorder.kode,
                xorder.tgl,
                xorder.ket,
                xorder.pic,
                xorder.kgkirim,
                xorder.kirimke,
                xorder.bykirim,
                xorder.ref_layanan,
                xorder.kurir,
                xorder.kodekurir,
                xorder.lokasidari,
                xorder.lokasike,
                xorder.pathcorel,
                xorder.pathimage,
                xorder.alamat,
                xorder.total,
                mcustomer.telp,
                mcustomer.nama namacust,
                mkirim.nama mkirim_nama,
                mlayanan.nama mlayanan_nama,
                mlayanan.harga mlayanan_harga
            FROM
                xorder
            LEFT JOIN mcustomer ON mcustomer.kode = xorder.ref_cust
            LEFT JOIN mkirim ON mkirim.kode = xorder.ref_kirim
            LEFT JOIN mlayanan ON mlayanan.kode = xorder.ref_layanan
            WHERE xorder.kode = '$kode'";

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
                xorderd
            LEFT JOIN mbarang ON mbarang.kode = xorderd.ref_brg
            LEFT JOIN mbarangs ON mbarang.kode = mbarangs.ref_brg
            LEFT JOIN msatbrg ON msatbrg.kode = xorderd.ref_satbrg
            LEFT JOIN msatuan ON msatuan.kode = msatbrg.ref_sat
            LEFT JOIN mgudang ON mgudang.kode = msatbrg.ref_gud
            LEFT JOIN xorderds ON xorderds.ref_orderd = xorderd. ID
            LEFT JOIN mmodesign ON mmodesign.kode = xorderds.ref_modesign
            LEFT JOIN mwarna ON mwarna.kode = xorderds.ref_warna
            WHERE xorderd.ref_order = '$kode'";

        $spek = "SELECT
                xorderds.id,
                xorderds.ket,
                mbarang.nama,
                mmodesign.kode mmodesign_kode,
                mmodesign.nama mmodesign_nama,
                mmodesign.gambar mmodesign_gambar,
                mwarna.nama mwarna_nama,
                mwarna.colorc mwarna_colorc
            FROM
                xorderds
            LEFT JOIN mmodesign ON mmodesign.kode = xorderds.ref_modesign
            LEFT JOIN mwarna ON mwarna.kode = xorderds.ref_warna
            LEFT JOIN xorderd ON xorderd. ID = xorderds.ref_orderd
            LEFT JOIN mbarang ON mbarang.kode = xorderd.ref_brg
            LEFT JOIN xorder ON xorder.kode = xorderd.ref_order
            WHERE xorder.kode = '$kode'";

        $resorder   = $this->dbtwo->query($order)->row();
        $resbarang  = $this->dbtwo->query($barang)->result();
        $resspek    = $this->dbtwo->query($spek)->row();

        $data['title']  = "Purchase Order";
        $data['order']  = $resorder;
        $data['barang'] = $resbarang;
        $data['spek']   = $resspek;
        $this->load->view($this->printpage,$data);
    }

}
