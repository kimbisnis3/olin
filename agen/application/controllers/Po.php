<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Po extends CI_Controller {

    public $table       = 'xorder';
    public $foldername  = 'po';
    public $indexpage   = 'po_agen/v_po_agen';
    public $printpage   = 'po_agen/p_po_agen';

    function __construct() {
        parent::__construct();
        include(APPPATH . 'libraries/dbinclude.php');
    }
    function index(){
        include(APPPATH.'libraries/sessionakses.php');
        $data['mlayanan'] = $this->db->get('mlayanan')->result();
        $data['mkirim'] = $this->db->get('mkirim')->result();
        $data['mbank'] = $this->db->get('mbank')->result();
        $this->load->view($this->indexpage,$data);
    }

    public function getall(){
        $filterawal = date('Y-m-d', strtotime($this->input->post('filterawal')));
        $filterakhir = date('Y-m-d', strtotime($this->input->post('filterakhir')));
        $kodecust   = $this->session->userdata('kodecust');
        $q = "SELECT
                xorder.*,
                xpelunasan.posted lunas,
                xsuratjalan.noresi,
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
            LEFT JOIN xsuratjalan ON xsuratjalan.ref_order = xorder.kode
            LEFT JOIN xpelunasan ON xorder.kode = xpelunasan.ref_jual AND xpelunasan.void IS NOT TRUE
            WHERE xorder.void IS NOT TRUE
            AND
                xorder.tgl
            BETWEEN '$filterawal' AND '$filterakhir'";
        if ($kodecust) {
            $q .= " AND xorder.ref_cust = '$kodecust'";
        }
        $q .=" ORDER BY xorder.id DESC" ;
        $result     = $this->db->query($q)->result();
        $list       = [];
        foreach ($result as $i => $r) {
            $row['no']      = $i + 1;
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
            $row['noresi']      = $r->noresi;
            $row['status']      = $r->status;
            $row['jmlorder']    = $r->jmlorder;
            $row['orderdone']   = $r->orderdone;
            $row['totalall']    = number_format($r->total + $r->bykirim);
        	if ($r->status > 4) {
            	$row['statusorder'] = '<span class="label label-success">Sudah Kirim</span>';
            } else {
            	$row['statusorder'] = ($r->orderdone == $r->jmlorder) ? '<span class="label label-info">Ready Kirim</span>' : '<span class="label label-warning">Belum Selesai</span>' ;
            }
            $row['lunas']       = $r->lunas;
        	$row['validasi']   = $r->posted;
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
                msatbrg.harga,
                msatbrg.ref_brg,
                msatbrg.ref_sat,
                msatuan.nama satuan,
                mgudang.nama gudang,
                xorderd.jumlah,
                xorderd.kodepesanan,
                xorderd.statusd,
                xorderd._product_id,
                xorderd._design_id,
                xorderd._order_id,
                xorderd.jumlah * xorderd.harga subtotal
            FROM
                xorderd
            LEFT JOIN mbarang ON mbarang.kode = xorderd.ref_brg
            LEFT JOIN msatbrg ON msatbrg.kode = xorderd.ref_satbrg
            LEFT JOIN msatuan ON msatuan.kode = msatbrg.ref_sat
            LEFT JOIN mgudang ON mgudang.kode = msatbrg.ref_gud
            WHERE xorderd.ref_order = '$xorderkode'";
        $brg     = $this->db->query($q)->result();

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
        $spek    = $this->db->query($p)->result();
        $tabs   = '<div class="nav-tabs-custom fadeIn animated">
                  <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_1" data-toggle="tab">Data Produk</a></li>
                    <li><a href="#tab_2" data-toggle="tab">Data Spesifikasi</a></li>
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
                            <th>Kode Pesanan</th>
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
                            <td>'.$r->kodepesanan.'</td>
                            <td>'.statuspo($r->statusd).'</td>
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
                            <td>'.showimage(str_replace('/agen/','',$r->mmodesign_gambar)).'</td>
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

    public function getpesanan()
    {
        $arr_produk = $this->input->post('arr_produk');
        $ns = str_replace('[','',$arr_produk);
        $ns = str_replace(']','',$ns);
        $ns = str_replace('"',"'",$ns);
        $q = "SELECT
              	mbarang. ID,
              	mbarang.kode kodebrg,
              	mbarang.nama,
              	mbarang.ket,
              	msatbrg. ID idsatbarang,
              	msatbrg.konv,
              	msatbrg.ket ketsat,
              	msatuan.nama satuan,
              	mcustomer.nama customer_nama,
                xorder.tgl,
                xorder.kode kodeorder,
                xorderd.id xorderd_id,
              	xorderd.ref_order,
              	xorderd.harga,
              	xorderd.jumlah,
              	xorderd._product_id,
              	xorderd._design_id,
              	xorderd._order_id
              FROM
              	xorderd
              LEFT JOIN xorder ON xorder.kode = xorderd.ref_order
              LEFT JOIN mcustomer ON mcustomer.kode = xorder.ref_cust
              LEFT JOIN mbarang ON mbarang.kode = xorderd.ref_brg
              LEFT JOIN msatbrg ON msatbrg.kode = xorderd.ref_satbrg
              LEFT JOIN msatuan ON msatuan.kode = msatbrg.ref_sat";
        if ($ns != '') {
          $q .=" WHERE xorderd.id NOT IN ($ns)" ;
        }
        $q .=" ORDER BY xorder.id DESC" ;
        $result     = $this->dbtwo->query($q)->result();
        $list       = [];
        foreach ($result as $i => $r) {
            $row['no']          = $i + 1;
            $row['xorderd_id']  = $r->xorderd_id;
            $row['id']          = $r->id;
            $row['kodebrg']     = $r->kodebrg;
            $row['kodeorder']   = $r->kodeorder;
            $row['nama']        = $r->nama;
            $row['tgl']         = normal_date($r->tgl);
            $row['customer_nama']    = $r->customer_nama;
            $row['jumlah']      = $r->jumlah;
            $row['harga']       = $r->harga;
            $list[] = $row;
        }
        echo json_encode(
          array(
            'data' => $list,
            'produk' => $ns,
          )
      );
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
        $result     = $this->db->query($q)->result();
        $list       = [];
        foreach ($result as $i => $r) {
            $btn_corel ='';
            if (link_file_url($r->pathcorel) == '' || link_file_url($r->pathcorel) == null) {
              $btn_corel = 'kosong';
            } else {
              $btn_corel = dlcorel(file_url($r->pathcorel));
            }
            $row['no']              = $i + 1;
            $row['id']              = $r->id;
            $row['kode']            = $r->kode;
            // $row['elempathcorel']   = dlcorel(file_url($r->pathcorel));
            $row['elempathcorel']   = $btn_corel;
            $row['elempathimage']   = dlimage(file_url($r->pathimage));
            $row['pathcorel']       = link_file_url($r->pathcorel);
            $row['pathimage']       = link_file_url($r->pathimage);
            $list[] = $row;
        }
        echo json_encode(array('data' => $list));
    }

    function updatefile()
    {
        if (!empty($_FILES['editcorel']['name'])) {
            $upcorel    = $this->libre->goUpload('editcorel','corel-'.time(),$this->foldername);
            $a['pathcorel'] = '_agen'.$upcorel;
            $oldpath = $this->input->post('editpathcorel');
            @unlink(".".$oldpath);
        }
        if (!empty($_FILES['editimage']['name'])) {
            $upimage    = $this->libre->goUpload('editimage','image-'.time(),$this->foldername);
            $a['pathimage'] = '_agen'.$upimage;
            $oldpath = $this->input->post('editpathimage');
            @unlink(".".$oldpath);
        }
        if (isset($a)) {
            $result = $this->db->update('xorder',$a,array('kode' => $this->input->post('editkodefile')));
            $r['sukses']    = $result ? 'success' : 'fail' ;
            echo json_encode($r);
        } else {
            $r['sukses']    = 'success';
            echo json_encode($r);
        }
    }

    function gethargalayanan($ref_layanan)
    {
        $harga = $this->db->get_where('mlayanan',array('kode' => $ref_layanan))->row();
        return $harga->harga;
    }

    public function savedata()
    {
        $kodeprov   = 10; //jateng
        $kodecity   = 445; //solo
        $kodedist   = 6164; //laweyan
        $upcorel    = $this->libre->goUpload('corel','corel-'.time(),$this->foldername);
        $upimage    = $this->libre->goUpload('image','img-'.time(),$this->foldername);
        $this->db->trans_begin();
        $a['pathcorel'] = '_agen'.$upcorel;
        $a['pathimage'] = '_agen'.$upimage;
        $a['useri']     = $this->session->userdata('username');
        $a['ref_cust']  = $this->session->userdata('kodecust');
        $a['tgl']       = date('Y-m-d', strtotime($this->input->post('tgl')));
        $a['ref_gud']   = $this->libre->gud_def();
        $a['ket']       = $this->input->post('ket');
        $a['ref_kirim'] = $this->input->post('ref_kirim');
        $a['ref_layanan'] = $this->input->post('ref_layanan');
        $a['kirimke']   = $this->input->post('kirimke');
        $a['alamat']    = $this->input->post('alamat');
        $a['telp']      = $this->input->post('telp');
        $a['ref_bank']  = ien($this->input->post('ref_bank'));
        if ($this->input->post('ref_kirim') == 'GX0002') {
            // $a['kodeprovfrom']  = $this->input->post('provinsi');
            // $a['kodecityfrom']  = $this->input->post('city');
            // $a['kodedistfrom']  = $this->input->post('dist');
            $a['kodeprovfrom']  = $kodeprov;
            $a['kodecityfrom']  = $kodecity;
            $a['kodedistfrom']  = $kodedist;
            $a['kodeprovto']    = $this->input->post('provinsito');
            $a['kodecityto']    = $this->input->post('cityto');
            $a['kodedistto']    = $this->input->post('distto');
            $a['lokasidari']    = $this->input->post('mask-provinsi').' - '.$this->input->post('mask-city');
            $a['lokasike']      = $this->input->post('mask-provinsito').' - '.$this->input->post('mask-cityto');
            $a['kgkirim']       = $this->input->post('berat');
            $a['bykirim']       = $this->input->post('biaya');
            $a['kodekurir']     = $this->input->post('kodekurir');
            $a['kurir']         = $this->input->post('kurir');
            $a['namakirim']     = $this->input->post('namakirim');
            $a['hpkirim']       = $this->input->post('hpkirim');
        }
        $this->db->insert('xorder',$a);

        // $idOrder = $this->db->insert_id();
        $idOrder    = insert_id('xorder');
        $kodeOrder = $this->db->get_where('xorder',array('id' => $idOrder))->row()->kode;
        $kodebrg    = $this->input->post('kodebrg');
        $arr_produk = $this->input->post('arr_produk');
        foreach (json_decode($arr_produk) as $r) {
            $Brg = $this->db->query("
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
            $rowb['useri']            = $this->session->userdata('username');
            $rowb['ref_order']        = $kodeOrder;
            $rowb['ref_brg']          = $Brg->msatbrg_ref_brg;
            $rowb['jumlah']           = $r->jumlah;
            $rowb['kodepesanan']      = $r->kodepesanan;
            $rowb['harga']            = str_replace(",","",$r->harga);
            $rowb['ref_satbrg']       = $Brg->msatbrg_kode;
            $rowb['ref_gud']          = $Brg->msatbrg_ref_gud;
            $rowb['ket']              = $Brg->msatbrg_ket;
            if ($r->xorderd_id != null || $r->xorderd_id != '') {
              $rowb['_agen_orderd_id']  = $r->xorderd_id;
              $rowb['_product_id']      = $this->get_data_design($r->xorderd_id)->_product_id;
              $rowb['_design_id']       = $this->get_data_design($r->xorderd_id)->_design_id;
              $rowb['_order_id']        = $this->get_data_design($r->xorderd_id)->_order_id;
            } else {
              $rowb['_agen_orderd_id']  = '';
              $rowb['_product_id']      = '';
              $rowb['_design_id']       = '';
              $rowb['_order_id']        = '';
            }
            $b[] = $rowb;
        }
        $this->db->delete('xorderd',array('ref_order' => $kodeOrder));
        $this->db->insert_batch('xorderd',$b);
        $idOrderd = $this->db->get_where('xorderd',array('ref_order' => $kodeOrder))->result();
        foreach ($idOrderd as $i) {
        $kodebarang = $this->db->get_where('xorderd',array('id' => $i->id))->row()->ref_brg;
        $design = $this->db->get_where('mbarangs',array('ref_brg' => $kodebarang))->result();
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
            $this->db->insert_batch('xorderds',$c);
        }
        $hargalayanan = $this->gethargalayanan($this->input->post('ref_layanan'));
        $bykirim    = $this->input->post('bykirim') == null || $this->input->post('biaya') == '' ? 0 : $this->input->post('biaya') ;
        $d['total'] = $this->input->post('total') + $bykirim + $hargalayanan;
        // $d['total'] = $this->input->post('total_cart') + $bykirim  + $hargalayanan;
        // $d['total'] = $this->input->post('total') + $this->input->post('biaya');
        $this->db->update('xorder',$d,array('kode' => $kodeOrder));

        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            @unlink(".".$upcorel);
            @unlink(".".$upimage);
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

    public function get_data_design($agen_orderd_id)
    {
        $result = $this->dbtwo->get_where('xorderd',array('id' => $agen_orderd_id))->row();
        return $result;
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
                xorder.ref_bank,
                xorder.namakirim,
                xorder.hpkirim,
                mcustomer.nama mcustomer_nama
            FROM
                xorder
            LEFT JOIN mcustomer ON mcustomer.kode = xorder.ref_cust
            WHERE xorder.kode = '{$this->input->post('kode')}'";

        $q_barang ="SELECT
                xorderd.id,
                xorderd.jumlah,
                xorderd.harga,
                xorderd._agen_orderd_id xorderd_id,
                mbarang.nama,
                mbarang.kode,
                msatbrg.beratkg
            FROM
                xorderd
            LEFT JOIN mbarang ON mbarang.kode = xorderd.ref_brg
            LEFT JOIN msatbrg ON mbarang.kode = msatbrg.ref_brg
            WHERE xorderd.ref_order = '{$this->input->post('kode')}'";
        $q_barang .=" AND msatbrg.def = 't'";
        $po         = $this->db->query($q_po)->row();
        $barang     = $this->db->query($q_barang)->result();
        echo json_encode(
            array(
                'po'    => $po,
                'barang'=> $barang,
        ));
    }

    public function updatedata()
    {
        $kodeprov   = 10; //jateng
        $kodecity   = 445; //solo
        $kodedist   = 6164; //laweyan
        $this->db->trans_begin();
        $kodeorder        = $this->input->post('kode');
        $a['useru']       = $this->session->userdata('username');
        $a['dateu']       = 'now()';
        $a['ref_cust']    = $this->session->userdata('kodecust');
        $a['tgl']         = date('Y-m-d', strtotime($this->input->post('tgl')));
        $a['ref_gud']     = $this->libre->gud_def();
        $a['ket']         = $this->input->post('ket');
        $a['ref_kirim']   = $this->input->post('ref_kirim');
        $a['ref_layanan'] = $this->input->post('ref_layanan');
        $a['kirimke']     = $this->input->post('kirimke');
        $a['alamat']      = $this->input->post('alamat');
        $a['telp']        = $this->input->post('telp');
        $a['ref_bank']    = $this->input->post('ref_bank');
        if ($this->input->post('ref_kirim') == 'GX0002') {
            // $a['kodeprovfrom']  = $this->input->post('provinsi');
            // $a['kodecityfrom']  = $this->input->post('city');
            // $a['kodedistfrom']  = $this->input->post('dist');
            $a['kodeprovfrom']  = $kodeprov;
            $a['kodecityfrom']  = $kodecity;
            $a['kodedistfrom']  = $kodedist;
            $a['kodeprovto']    = $this->input->post('provinsito');
            $a['kodecityto']    = $this->input->post('cityto');
            $a['kodedistfrom']  = $this->input->post('dist');
            $a['kodedistto']    = $this->input->post('distto');
            $a['lokasidari']    = $this->input->post('mask-provinsi').' - '.$this->input->post('mask-city');
            $a['lokasike']      = $this->input->post('mask-provinsito').' - '.$this->input->post('mask-cityto');
            $a['kgkirim']       = $this->input->post('berat');
            $a['bykirim']       = $this->input->post('biaya');
            $a['kodekurir']     = $this->input->post('kodekurir');
            $a['kurir']         = $this->input->post('kurir');
            $a['namakirim']     = $this->input->post('namakirim');
            $a['hpkirim']       = $this->input->post('hpkirim');
        }
        $this->db->update('xorder',$a,array('kode' => $kodeorder));
        $kodebrg = $this->input->post('kodebrg');
        $hargalayanan = $this->gethargalayanan($this->input->post('ref_layanan'));
        $bykirim    = $this->input->post('bykirim') == null || $this->input->post('biaya') == '' ? 0 : $this->input->post('biaya') ;
        $d['total'] = $this->input->post('total') + $bykirim + $hargalayanan;
        // $d['total'] = $this->input->post('total_cart') + $bykirim  + $hargalayanan;
        // $d['total'] = $this->input->post('total') + $this->input->post('biaya');
        $this->db->update('xorder',$d,array('kode' => $kodeorder));
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

    // function updatefile()
    // {
    //     if (!empty($_FILES['editcorel']['name'])) {
    //         $upcorel    = $this->libre->goUpload('editcorel','corel-'.time(),$this->foldername);
    //         $a['pathcorel'] = '/agen'.$upcorel;
    //         $oldpath = $this->input->post('editpathcorel');
    //         @unlink(".".str_replace('/agen','',$oldpath));
    //     } else {
    //         $a['pathcorel'] = $this->input->post('editpathcorel');
    //     }
    //
    //     if (!empty($_FILES['editimage']['name'])) {
    //         $upcorel    = $this->libre->goUpload('editimage','image-'.time(),$this->foldername);
    //         $a['pathimage'] = '/agen'.$upcorel;
    //         $oldpath = $this->input->post('editpathimage');
    //         @unlink(".".str_replace('/agen','',$oldpath));
    //     } else {
    //         $a['pathimage'] = $this->input->post('editpathimage');
    //     }
    //
    //     $result = $this->db->update('xorder',$a,array('kode' => $this->input->post('editkodefile')));
    //     $r['sukses']    = $result ? 'success' : 'fail' ;
    //     echo json_encode($r);
    // }

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
        $result     = $this->db->query($q)->result();
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
        $result     = $this->db->query($q)->result();
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

    function loadbrgbykode() {
        $kodebrg    = $this->input->get('kodebrg');
        $kodeorder  = $this->input->get('kodeorder');
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

            $q .=" AND mbarang.kode = '$kodebrg'";

            $r['barang']  = $this->db->query($q)->row();
            $r['order']   = $this->dbtwo->get_where('xorder', array('kode' => $kodeorder))->row();
            echo json_encode($r);

    }

    public function deletedata()
    {
        $d['void'] = 't';
        $d['tglvoid'] = 'now()';
        $w['id'] = $this->input->post('id');
        $result = $this->db->update($this->table,$d,$w);
        $r['sukses'] = $result ? 'success' : 'fail' ;
        echo json_encode($r);
    }

    public function addbarang()
    {
        $this->db->trans_begin();
        $kodebarang = $this->input->post('kode');
        $kodeorder  = $this->input->post('kodeorder');
        $Brg = $this->db->query("
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
        $this->db->insert('xorderd',$a);
        // $idorderd= $this->db->insert_id();
        $idOrder    = insert_id('xorder');
        $design  = $this->db->get_where('mbarangs',array('ref_brg' => $kodebarang))->result();
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
        $this->db->delete('xorderds',array('ref_orderd' => $idorderd));
        if (count($design) > 0) {
            $this->db->insert_batch('xorderds',$c);
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
        $barang = $this->db->query($q_barang)->result();
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
                'barang' => $barang,
            );
        }
        echo json_encode($r);
    }

    public function updatebarang() {
        $this->db->trans_begin();
        $kodebarang = $this->input->post('kode');
        $idorderd = $this->input->post('id');
        $kodeorder  = $this->input->post('kodeorder');
        $Brg = $this->db->query("
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
        $a['kodepesanan']    = $this->input->post('kodepesanan');
        $a['harga']     = str_replace(",","",$this->input->post('harga'));
        $a['ref_satbrg']= $Brg->msatbrg_kode;
        $a['ref_gud']   = $Brg->msatbrg_ref_gud;
        $a['ket']       = $Brg->msatbrg_ket;
        $w['id']        = $this->input->post('id');
        $this->db->update('xorderd',$a,$w);
        $design  = $this->db->get_where('mbarangs',array('ref_brg' => $kodebarang))->result();
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
        $this->db->delete('xorderds',array('ref_orderd' => $idorderd));
        if (count($design) > 0) {
            $this->db->insert_batch('xorderds',$c);
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
        $barang = $this->db->query($q_barang)->result();
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
                'barang' => $barang,
            );
        }
        echo json_encode($r);
    }

    public function deletebarang()
    {
        $w['id'] = $this->input->post('id');
        $kodeorder = $this->db->get_where('xorderd',array('id' => $this->input->post('id')))->row()->ref_order;
        $z['total'] = $this->input->post('total');
        $result = $this->db->delete('xorderd',$w);
        $r['sukses'] = $result ? 'success' : 'fail' ;
        echo json_encode($r);
    }

    function request_province() {
        $response = $this->libre->get_province_pro();
        $data = json_decode($response, true);
        $op = "<option value=''>-</option>";
            for ($i=0; $i < count($data['rajaongkir']['results']); $i++) {
                $op .="<option value='".$data['rajaongkir']['results'][$i]['province_id']."'>".$data['rajaongkir']['results'][$i]['province']."</option>";
              }
        echo $op;

    }

    function request_city() {
        $provincecode = $this->input->get('province');
        $response = $this->libre->get_city_pro($provincecode);
        $data = json_decode($response, true);
        $op = "<option value=''>-</option>";
            for ($i=0; $i < count($data['rajaongkir']['results']); $i++) {
              $op .=  "<option value='".$data['rajaongkir']['results'][$i]['city_id']."'>".$data['rajaongkir']['results'][$i]['city_name']."</option>";
              }
        echo $op;

    }

    function request_dist() {
        $citycode   = $this->input->get('city');
        $response   = $this->libre->get_dist_pro($citycode);
        $data       = json_decode($response, true);
        $op = "<option value=''>-</option>";
            for ($i=0; $i < count($data['rajaongkir']['results']); $i++) {
              $op .=  "<option value='".$data['rajaongkir']['results'][$i]['subdistrict_id']."'>".$data['rajaongkir']['results'][$i]['subdistrict_name']."</option>";
              }
        echo $op;

    }

    function request_ongkir()
    {
        $origintype     = 'subdistrict';
        $destinationtype= 'subdistrict';
        $origin         = $this->input->get('origin');
        $destination    = $this->input->get('destination');
        // $weight         = $this->input->get('weight') * 1000;
        $weight         = 1 * 1000;
        $courier        = $this->input->get('courier');
        $response       = $this->libre->get_ongkir_pro($origin, $origintype, $destination, $destinationtype, $weight, $courier);
        $data           = json_decode($response, true);
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

        $resorder   = $this->db->query($order)->row();
        $resbarang  = $this->db->query($barang)->result();
        $resspek    = $this->db->query($spek)->row();

        $data['title']  = "Purchase Order";
        $data['order']  = $resorder;
        $data['barang'] = $resbarang;
        $data['spek']   = $resspek;
        $this->load->view($this->printpage,$data);
    }

}
