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
        $data['ktg']    = $this->db->get('mkategori')->result();
        $komp = "SELECT
                mbarang.id,
                mbarang.kode,
                mbarang.ket,
                mbarang.nama
            FROM
                msatbrg
            LEFT JOIN mbarang ON mbarang.kode = msatbrg.ref_brg";
        $komp  .= " WHERE mbarang.ref_ktg = 'GX0002'";
        $komp  .= " AND msatbrg.def = 't'";
        $komp  .= " ORDER BY msatbrg.id DESC";
        $data['komp']   = $this->db->query($komp)->result();
        $this->load->view($this->indexpage,$data);  
    }

    public function getall(){
        $filterktg = $this->input->post('filterktg');
        $q = "SELECT
                msatbrg.id,
                msatbrg.konv,
                msatbrg.ket,
                msatbrg.harga,
                msatbrg.def,
                mbarang.id idbarang,
                mbarang.kode kodebarang,
                mbarang.ket ketbarang,
                mbarang.nama namabarang,
                msatuan.nama namasatuan,
                mgudang.nama namagudang,
                mmodesign.gambar gambardesign,
                mmodesign.nama namadesign,
                mwarna.colorc kodewarna,
                mkategori.nama kategori_nama
            FROM
                msatbrg
            LEFT JOIN mbarang ON mbarang.kode = msatbrg.ref_brg
            LEFT JOIN mkategori ON mkategori.kode = mbarang.ref_ktg
            LEFT JOIN mbarangs ON mbarang.kode = mbarangs.ref_brg
            LEFT JOIN mmodesign ON mmodesign.kode = mbarangs.model
            LEFT JOIN mwarna ON mwarna.kode = mbarangs.warna
            LEFT JOIN msatuan ON msatuan.kode = msatbrg.ref_sat
            LEFT JOIN mgudang ON mgudang.kode = msatbrg.ref_gud";
        $q  .= " WHERE msatbrg.def = 't'";
        // $q  .= " AND mbarang.ref_ktg != 'GX0002'";
        if ($filterktg) {
            $q  .= " AND mbarang.ref_ktg = '$filterktg'";
        }
        $q  .= " ORDER BY msatbrg.id DESC";
        $result     = $this->db->query($q)->result();   
        echo json_encode(array('data' => $result));
    }

    public function getdetailharga()
    {
        $kodebarang = $this->input->post('kodebarang');
        $q = "SELECT
                msatbrg.id,
                msatbrg.konv,
                msatbrg.ket,
                msatbrg.harga,
                msatbrg.ref_brg,
                msatbrg.ref_sat,
                msatbrg.beratkg,
                msatbrg.ref_gud,
                msatbrg.def,
                msatuan.nama namasatuan,
                mgudang.nama namagudang
            FROM
                msatbrg
            LEFT JOIN msatuan ON msatuan.kode = msatbrg.ref_sat
            LEFT JOIN mgudang ON mgudang.kode = msatbrg.ref_gud
            WHERE msatbrg.ref_brg = '$kodebarang'";
        $result     = $this->db->query($q)->result();
        foreach ($result as $i => $r) {
            $row['id']          = $r->id;
            $row['konv']        = $r->konv;
            $row['namasatuan']  = $r->namasatuan;
            $row['harga']       = $r->harga;
            $row['beratkg']     = $r->beratkg;
            $row['ket']         = $r->ket;
            $row['def']         = truefalse($r->def,'Default','');
            $row['btn']         = "
            <button class='btn btn-sm btn-warning btn-flat' id='editsat' onclick='edit_harga(".$r->id.")'><i class='fa fa-pencil'></i></button>
            <button class='btn btn-sm btn-danger btn-flat' id='hapussat' onclick='hapus_harga(".$r->id.")'><i class='fa fa-trash'></i></button>
            <button class='btn btn-sm btn-success btn-flat ".$this->tf($r->def)."' id='defsat' onclick='default_data(".$r->id.")'><i class='fa fa-check'></i></button>";
            $list[] = $row;
        }
        echo json_encode(array('data' => $list));
    }

    public function tf($def) {
        if ($def == 't') {
            return 'invisible';
        } else {
            return '';
        }
    }

    public function addharga() {
        $d = array(
                "useri"     => $this->session->userdata('username'),
                "ref_brg"   => $this->input->post('ref_brg'),
                "ref_sat"   => $this->input->post('ref_sat'),
                "konv"      => $this->input->post('konv'),
                "harga"     => $this->input->post('harga'),
                "ket"       => $this->input->post('ketsatuan'),
                "ref_gud"   => $this->libre->gud_def()
            );
        $result     = $this->db->insert('msatbrg',$d);
        $r['sukses']= $result ? 'success' : 'fail' ;
        echo json_encode($r);
    }

    public function updateharga() {
        $d = array(
                "useru"     => $this->session->userdata('username'),
                "dateu"     => 'now()',
                "ref_sat"   => $this->input->post('ref_sat'),
                "konv"      => $this->input->post('konv'),
                "harga"     => $this->input->post('harga'),
                "beratkg"   => $this->input->post('beratkg'),
                "ket"       => $this->input->post('ketsatuan'),
                "ref_gud"   => $this->libre->gud_def()
            );
        $result = $this->db->update('msatbrg',$d,array('id' => $this->input->post('id') ));
        $r['sukses']= $result ? 'success' : 'fail' ;
        echo json_encode($r);
    }

    function editharga(){
        $w['id']= $this->input->post('id');
        $data   = $this->db->get_where('msatbrg',$w)->row();
        echo json_encode($data);
    }

    public function getdetail()
    {
        $kodebarang = $this->input->post('kodebarang');
        $q = "SELECT
                mbarang.nama
            FROM
                mbarangd
            LEFT JOIN mbarang ON mbarang.kode = mbarangd.ref_brgp
            WHERE mbarangd.ref_brg = '$kodebarang'";
        $result     = $this->db->query($q)->result();
        $brg = '<table class="table">
                        <thead>
                        <tr>
                            <th>Nama</th>
                        </tr>
                        <thead>';
        foreach ($result as $i => $r) {
            $brg    .= '<tbody>
                        <tr>
                            <td>'.$r->nama.'</td>
                        </tr>
                        </tbody>';
        }
        $brg .='</table>';
        echo $brg;
    }

    function getkomponen() {
        $kode = $this->input->post('kode');
        $q  = "SELECT
                msatbrg. ID,
                msatbrg.konv,
                msatbrg.ket,
                msatbrg.harga,
                mbarang. ID idbarang,
                mbarang.kode kodebarang,
                mbarang.ket ketbarang,
                mbarang.nama namabarang,
                msatuan.nama namasatuan,
                mmodesign.gambar gambardesign,
                mmodesign.nama namadesign,
                mwarna.colorc kodewarna,
                mbarangd.id mbarangd_id
            FROM
                mbarangd
            LEFT JOIN msatbrg ON mbarangd.ref_brgp = msatbrg.ref_brg
            LEFT JOIN mbarang ON mbarangd.ref_brgp = mbarang.kode
            LEFT JOIN msatuan ON msatuan.kode = msatbrg.ref_sat
            LEFT JOIN mbarangs ON mbarang.kode = mbarangs.ref_brg
            LEFT JOIN mwarna ON mwarna.kode = mbarangs.warna
            LEFT JOIN mmodesign ON mmodesign.kode = mbarangs.model";
        $q  .= " WHERE mbarangd.ref_brg = '$kode'";
        $q  .= " ORDER BY msatbrg.id DESC";
        $result = $this->db->query($q)->result();
        echo json_encode(array('data' => $result));
    } 

    function addkomponen() {
        $q = "SELECT
                msatbrg.id,
                msatbrg.kode,
                mbarang.id idbarang,
                mbarang.kode kodebarang
            FROM
                msatbrg
            LEFT JOIN mbarang ON mbarang.kode = msatbrg.ref_brg";
        $q  .= " WHERE msatbrg.def = 't'";
        $q  .= " AND mbarang.ref_ktg = 'GX0002'";
        $q  .= " ORDER BY msatbrg.id DESC";
        $res = $this->db->query($q)->row();

        $d['ref_brgp']      = $this->input->post('ref_brgp');
        $d['ref_brg']       = $this->input->post('ref_brg');
        $d['ref_msatbrg']   = $res->kode;
        $result = $this->db->insert('mbarangd',$d);
        $r['sukses']= $result ? 'success' : 'fail' ;
        echo json_encode($r);
    }

    function delkomponen() {
        $w['id'] = $this->input->post('id');
        $result = $this->db->delete('mbarangd',$w);
        $r['sukses']= $result ? 'success' : 'fail' ;
        echo json_encode($r);
    }

    public function savedata()
    {   
        $this->db->trans_begin();
        $a['useri']     = $this->session->userdata('username');
        $a['nama']      = $this->input->post('nama');
        $a['kode']      = $this->input->post('kode');
        $a['ket']       = $this->input->post('ket');
        $a['ref_ktg']   = $this->input->post('ref_ktg');
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
                "beratkg"   => $r->beratkg,
                "ket"       => $r->ketsatuan,
                "def"       => ien($r->def),
                "ref_gud"   => $this->libre->gud_def(),
            );
            $b[] = $row;
        }
        $result = $this->db->insert_batch('msatbrg',$b);
        $c['ref_brg']   = $kodeBrg;
        $c['sn']        = null;
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
                mbarang.ket,
                mbarang.ref_ktg
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
        $a['kode']      = $this->input->post('kode');
        $a['ket']       = $this->input->post('ket');
        $a['ref_ktg']   = $this->input->post('ref_ktg');
        $kodeBrg        = $this->input->post('kode');
        $this->db->update('mbarang',$a,array('kode' => $kodeBrg ));
        $c['ref_brg']   = $kodeBrg;
        $c['sn']        = null;
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

    public function deleteharga()
    {
        $w['id']    = $this->input->post('id');
        $result     = $this->db->delete('msatbrg',$w);
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