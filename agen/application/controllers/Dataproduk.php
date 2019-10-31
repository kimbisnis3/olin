<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Dataproduk extends CI_Controller {
    
    public $table       = 'msatbrg';
    public $foldername  = 'agen_msatbrg';
    public $indexpage   = 'dataproduk/v_dataproduk';
    function __construct() {
        parent::__construct();
        include(APPPATH.'libraries/sessionakses.php');
        include(APPPATH.'libraries/dbinclude.php');  
    }
    function index(){
        $data['satuan'] = $this->dbtwo->get('msatuan')->result();
        $data['design'] = $this->dbtwo->get('mmodesign')->result();
        $data['warna']  = $this->dbtwo->get('mwarna')->result();
        $data['ktg']    = $this->dbtwo->get('mkategori')->result();
        $komp = "SELECT
                mbarang.id,
                mbarang.kode,
                mbarang.ket,
                mbarang.nama,
                mkategori.nama kategori_nama
            FROM
                msatbrg
            LEFT JOIN mbarang ON mbarang.kode = msatbrg.ref_brg
            LEFT JOIN mkategori ON mkategori.kode = mbarang.ref_ktg
        ";
        $komp  .= " WHERE msatbrg.def = 't'";
        // $komp  .= " AND mbarang.ref_ktg = 'GX0002'";
        $komp  .= " ORDER BY msatbrg.id DESC";
        $data['komp']   = $this->dbtwo->query($komp)->result();
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
                mbarang.is_design,
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
        // if ($filterktg) {
        //     $q  .= " AND mbarang.ref_ktg = '$filterktg'";
        // }
        $q  .= " ORDER BY msatbrg.id DESC";
        $result     = $this->dbtwo->query($q)->result();   
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
        $result     = $this->dbtwo->query($q)->result();
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
        $result     = $this->dbtwo->insert('msatbrg',$d);
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
        $result = $this->dbtwo->update('msatbrg',$d,array('id' => $this->input->post('id') ));
        $r['sukses']= $result ? 'success' : 'fail' ;
        echo json_encode($r);
    }

    function editharga(){
        $w['id']= $this->input->post('id');
        $data   = $this->dbtwo->get_where('msatbrg',$w)->row();
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
        $result     = $this->dbtwo->query($q)->result();
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
        $result = $this->dbtwo->query($q)->result();
        echo json_encode(array('data' => $result));
    } 

    function getimage() 
    {
        $kode = $this->input->post('kode');
        $q= "SELECT * FROM mbarangpic WHERE ref_barang = '$kode'";
        $data = $this->dbtwo->query($q)->result();
        echo json_encode(array('data' => $data));
    }

    function saveimage()
    {
        $image          = $this->libre->goUpload('image','img-'.time(),$this->foldername);
        $a['image']     = $image;
        $a['ref_barang']= $this->input->post('kodebarang');
        $result = $this->dbtwo->insert('mbarangpic',$a);
        $r['sukses'] = $result ? 'success' : 'fail' ;
        echo json_encode($r);
    }

    function delimage()
    {
        $w['id'] = $this->input->post('id');
        $sql = "SELECT image FROM mbarangpic WHERE id = {$this->input->post('id')}";
        $path = $this->dbtwo->query($sql)->row()->image;
        
        @unlink('.'.$path);
        
        $w['id'] = $this->input->post('id');
        $result = $this->dbtwo->delete('mbarangpic',$w);
        $r['sukses'] = $result ? 'success' : 'fail' ;
        echo json_encode($r);
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
        $res = $this->dbtwo->query($q)->row();

        $d['ref_brgp']      = $this->input->post('ref_brgp');
        $d['ref_brg']       = $this->input->post('ref_brg');
        $d['ref_msatbrg']   = $res->kode;
        $result = $this->dbtwo->insert('mbarangd',$d);
        $r['sukses']= $result ? 'success' : 'fail' ;
        echo json_encode($r);
    }

    function delkomponen() {
        $w['id'] = $this->input->post('id');
        $result = $this->dbtwo->delete('mbarangd',$w);
        $r['sukses']= $result ? 'success' : 'fail' ;
        echo json_encode($r);
    }

    public function savedata()
    {   
        $this->dbtwo->trans_begin();
        $a['useri']     = $this->session->userdata('username');
        $a['nama']      = $this->input->post('nama');
        $a['kode']      = $this->input->post('kode');
        $a['ket']       = $this->input->post('ket');
        $a['bahan']     = $this->input->post('bahan');
        $a['dimensi']   = $this->input->post('dimensi');
        $a['kapasitas'] = $this->input->post('kapasitas');
        $a['ref_ktg']   = $this->input->post('ref_ktg');
        $this->dbtwo->insert('mbarang',$a);
        $idBrg = $this->dbtwo->insert_id();
        $kodeBrg = $this->dbtwo->get_where('mbarang',array('id' => $idBrg))->row()->kode;
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
        $result = $this->dbtwo->insert_batch('msatbrg',$b);
        $c['ref_brg']   = $kodeBrg;
        $c['sn']        = null;
        $c['model']     = $this->input->post('model');
        $c['warna']     = $this->input->post('warna');
        $c['ket']       = $this->input->post('ketspek');
        $result = $this->dbtwo->insert('mbarangs',$c);
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
                mbarang.bahan,
                mbarang.dimensi,
                mbarang.kapasitas,
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

        $data['barang'] = $this->dbtwo->query($barang)->row();
        $data['spek']   = $this->dbtwo->query($spek)->row();
        $data['harga']  = $this->dbtwo->query($harga)->result();
        echo json_encode($data);
    }

    function updatedata(){
        $this->dbtwo->trans_begin();
        $a['useru']     = $this->session->userdata('username');
        $a['dateu']     = 'now()';
        $a['nama']      = $this->input->post('nama');
        $a['kode']      = $this->input->post('kode');
        $a['ket']       = $this->input->post('ket');
        $a['bahan']     = $this->input->post('bahan');
        $a['dimensi']   = $this->input->post('dimensi');
        $a['kapasitas'] = $this->input->post('kapasitas');
        $a['ref_ktg']   = $this->input->post('ref_ktg');
        $kodeBrg        = $this->input->post('kode');
        $idBrg          = $this->input->post('idbarang');
        $this->dbtwo->update('mbarang',$a,array('id' => $idBrg ));
        $c['ref_brg']   = $kodeBrg;
        $c['sn']        = null;
        $c['model']     = $this->input->post('model');
        $c['warna']     = $this->input->post('warna');
        $c['ket']       = $this->input->post('ketspek');
        $result = $this->dbtwo->update('mbarangs',$c,array('ref_brg' => $kodeBrg ));
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
            );
        }
        echo json_encode($r);
    }

    public function deletedata()
    {
        $w['id']    = $this->input->post('id');
        $result     = $this->dbtwo->delete('mbarang',$w);
        $r['sukses'] = $result ? 'success' : 'fail' ;
        echo json_encode($r);
    }

    public function deleteharga()
    {
        $w['id']    = $this->input->post('id');
        $result     = $this->dbtwo->delete('msatbrg',$w);
        $r['sukses'] = $result ? 'success' : 'fail' ;
        echo json_encode($r);
    }

    public function default_data() 
    {
        $w['id']    = $this->input->post('id');
        $result     = $this->dbtwo->update('msatbrg',array('def' => 't' ),$w);
        $r['sukses'] = $result ? 'success' : 'fail' ;
        echo json_encode($r);
    }

    function custom_data()
    {
        $id             = $this->input->post('id');
        $sql            = "SELECT is_design FROM mbarang WHERE id = $id";
        $s              = $this->dbtwo->query($sql)->row()->is_design;
        $s == 't' ? $status = 'f' : $status = 't';
        $d['is_design'] = $status;
        $w['id']        = $id;
        $result         = $this->dbtwo->update('mbarang',$d,$w);
        $r['sukses']    = $result > 0 ? 'success' : 'fail' ;
        echo json_encode($r);
    }
}