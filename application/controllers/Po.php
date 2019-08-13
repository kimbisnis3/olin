<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Po extends CI_Controller {
    
    public $table       = 'xorder';
    public $foldername  = './uploads/po';
    public $indexpage   = 'po/v_po';

    function __construct() {
        parent::__construct();
    }
    function index(){
        include(APPPATH.'libraries/sessionakses.php');
        $data['mlayanan'] = $this->db->get('mlayanan')->result();
        $data['mkirim'] = $this->db->get('mkirim')->result();
        $this->load->view($this->indexpage,$data);  
    }

    public function getall(){
        $filterawal = date('Y-m-d', strtotime($this->input->post('filterawal')));
        $filterakhir = date('Y-m-d', strtotime($this->input->post('filterakhir')));
        $q = "SELECT
                xorder.id,
                xorder.kode,
                xorder.tgl,
                xorder.ket,
                xorder.pic,
                xorder.kgkirim,
                xorder.bykirim,
                xorder.ref_layanan,
                xorder.kurir,
                xorder.lokasidari,
                xorder.lokasike,
                xorder.pathcorel,
                xorder.pathimage,
                mcustomer.nama namacust,
                mkirim.nama mkirim_nama
            FROM
                xorder
            LEFT JOIN mcustomer ON mcustomer.kode = xorder.ref_cust
            LEFT JOIN mkirim ON mkirim.kode = xorder.ref_kirim
            WHERE xorder.void IS NOT TRUE
            AND
                xorder.tgl 
            BETWEEN '$filterawal' AND '$filterakhir'";
        $result     = $this->db->query($q)->result();
        $list       = [];
        foreach ($result as $i => $r) {
            $row['no']      = $i + 1;
            $row['id']          = $r->id;
            $row['kode']        = $r->kode;
            $row['namacust']    = $r->namacust;
            $row['kgkirim']     = $r->kgkirim;
            $row['bykirim']     = number_format($r->bykirim);
            $row['mkirim_nama'] = $r->mkirim_nama;
            $row['kurir']       = $r->kurir;
            $row['lokasidari']  = $r->lokasidari;
            $row['lokasike']    = $r->lokasike;
            $row['ket']         = $r->ket;
            $row['pathcorel']   = $r->pathcorel;
            $row['pathimage']   = $r->pathimage;
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
                mgudang.nama gudang
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
                            <th>Produk</th>
                            <th>Konv</th>
                            <th>Satuan</th>
                            <th>Harga</th>
                            <th>Gudang</th>
                            <th>Keterangan</th>
                        </tr>
                        <thead>';
        foreach ($brg as $i => $r) {
            $tabs    .= '<tbody>
                        <tr>
                            <td>'.($i + 1).'.</td>
                            <td>'.$r->nama.'</td>
                            <td>'.$r->konv.'</td>
                            <td>'.$r->satuan.'</td>
                            <td>'.number_format($r->harga).'</td>
                            <td>'.$r->gudang.'</td>
                            <td>'.$r->ket.'</td>
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
            $row['no']      = $i + 1;
            $row['id']          = $r->id;
            $row['kode']        = $r->kode;
            $row['elempathcorel']   = btndownload($r->pathcorel);
            $row['elempathimage']   = showimage($r->pathimage);
            $row['pathcorel']   = $r->pathcorel;
            $row['pathimage']   = $r->pathimage;
            $list[] = $row;
        }   
        echo json_encode(array('data' => $list));
    }

    public function savedata()
    {   
        $upcorel    = $this->libre->goUpload('corel','corel-'.time(),$this->foldername);
        $upimage    = $this->libre->goUpload('image','img-'.time(),$this->foldername);
        $this->db->trans_begin();
        $a['pathcorel'] = $upcorel;
        $a['pathimage'] = $upimage;
        $a['useri']     = $this->session->userdata('username');
        $a['ref_cust']  = $this->input->post('ref_cust');
        $a['tgl']       = date('Y-m-d', strtotime($this->input->post('tgl')));
        $a['ref_gud']   = $this->input->post('ref_gud');
        $a['ket']       = $this->input->post('ket');
        $a['ref_kirim'] = $this->input->post('ref_kirim');
        $a['ref_layanan'] = $this->input->post('ref_layanan');
        $a['kirimke']   = $this->input->post('kirimke');
        if ($this->input->post('ref_kirim') == 'GX0002') {    
            $a['kodeprovfrom']  = $this->input->post('provinsi');
            $a['kodeprovto']    = $this->input->post('provinsito');
            $a['kodecityfrom']  = $this->input->post('city');
            $a['kodecityto']    = $this->input->post('cityto');
            $a['lokasidari']= $this->input->post('mask-provinsi').' - '.$this->input->post('mask-city');
            $a['lokasike']  = $this->input->post('mask-provinsito').' - '.$this->input->post('mask-cityto');
            $a['kgkirim']   = $this->input->post('berat');
            $a['bykirim']   = $this->input->post('biaya');
            $a['kurir']     = $this->input->post('kodekurir');
        }
        $this->db->insert('xorder',$a);

        $idOrder = $this->db->insert_id();
        $kodeOrder = $this->db->get_where('xorder',array('id' => $idOrder))->row()->kode;
        $kodebrg = $this->input->post('kodebrg');
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
            AND mbarang.kode = '$kodebrg'")->row();
        $b['useri']     = $this->session->userdata('username');
        $b['ref_order'] = $kodeOrder;
        $b['ref_brg']   = $Brg->msatbrg_ref_brg;
        $b['jumlah']    = $this->input->post('jumlah');
        $b['ref_satbrg']= $Brg->msatbrg_kode;
        $b['harga']     = $Brg->msatbrg_harga;
        $b['ref_gud']   = $Brg->msatbrg_ref_gud;
        $b['ket']       = $Brg->msatbrg_ket;
        $this->db->insert('xorderd',$b);
        $idOrderd = $this->db->insert_id();
        $design = $this->db->get_where('mbarangs',array('ref_brg' => $kodebrg))->result();
        foreach ($design as $r) {
            $row    = array(
                "useri"         => $this->session->userdata('username'),
                "ref_orderd"    => $idOrderd,
                "ref_modesign"  => $r->model,
                "ref_warna"     => $r->warna,
                "ket"           => $r->ket
            );
            $c[] = $row;
        }
        if (count($design) > 0) {
            $this->db->insert_batch('xorderds',$c);
        }

        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            $this->libre->delFile($upcorel);
            $this->libre->delFile($upimage);
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

    public function updatedata() 
    {
        $this->db->trans_begin();
        $kodeorder      = $this->input->post('kode');
        $a['useru']     = $this->session->userdata('username');
        $a['dateu']     = 'now()';
        $a['ref_cust']  = $this->input->post('ref_cust');
        $a['tgl']       = date('Y-m-d', strtotime($this->input->post('tgl')));
        $a['ref_gud']   = $this->input->post('ref_gud');
        $a['ket']       = $this->input->post('ket');
        $a['ref_kirim'] = $this->input->post('ref_kirim');
        $a['ref_layanan'] = $this->input->post('ref_layanan');
        $a['kirimke']   = $this->input->post('kirimke');
        if ($this->input->post('ref_kirim') == 'GX0002') {
            $a['kodeprovfrom']  = $this->input->post('provinsi');
            $a['kodeprovto'] = $this->input->post('provinsito');
            $a['kodecityfrom']  = $this->input->post('city');
            $a['kodecityto']    = $this->input->post('cityto');
            $a['lokasidari']= $this->input->post('mask-provinsi').' - '.$this->input->post('mask-city');
            $a['lokasike']  = $this->input->post('mask-provinsito').' - '.$this->input->post('mask-cityto');
            $a['kgkirim']   = $this->input->post('berat');
            $a['bykirim']   = $this->input->post('biaya');
            $a['kurir']     = $this->input->post('kodekurir');
        }
        $this->db->update('xorder',$a,array('kode' => $kodeorder));
        $kodebrg = $this->input->post('kodebrg');
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
            AND mbarang.kode = '$kodebrg'")->row();
        $b['useru']     = $this->session->userdata('username');
        $b['dateu']     = 'now()';
        $b['ref_order'] = $kodeOrder;
        $b['ref_brg']   = $Brg->msatbrg_ref_brg;
        $b['jumlah']    = $this->input->post('jumlah');
        $b['ref_satbrg']= $Brg->msatbrg_kode;
        $b['harga']     = $Brg->msatbrg_harga;
        $b['ref_gud']   = $Brg->msatbrg_ref_gud;
        $b['ket']       = $Brg->msatbrg_ket;
        $this->db->update('xorderd',$b,array('ref_order' => $kodeorder));
        //get orderd id first
        $idOrderd = $this->db->get('xorderd',array('ref_order' => $kodeorder)) ;
        $design = $this->db->get_where('mbarangs',array('ref_brg' => $kodebrg))->result();
        foreach ($design as $r) {
            $row    = array(
                "useri"         => $this->session->userdata('username'),
                "ref_orderd"    => $idOrderd,
                "ref_modesign"  => $r->model,
                "ref_warna"     => $r->warna,
                "ket"           => $r->ket
            );
            $c[] = $row;
        }
        if (count($design) > 0) {
            $this->db->delete('xorderds',array('ref_orderd' => $idOrderd));
            $this->db->insert_batch('xorderds',$c);
        }

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

        $result = $this->db->update('xorder',$a,array('kode' => $this->input->post('editkodefile')));
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
            ) > 0";
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

            $list[] = $row;
        }   
        echo json_encode(array('data' => $list));
    }

    public function deletedata()
    {
        $d['void'] = 't';
        $w['id'] = $this->input->post('id');
        $result = $this->db->update($this->table,$d,$w);
        $r['sukses'] = $result ? 'success' : 'fail' ;
        echo json_encode($r);
    }

    function request_province() {
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://api.rajaongkir.com/starter/province",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET",
          CURLOPT_HTTPHEADER => array(
            "key: 5c8590c12ef6879e2b829c4ab6aa955e"
          ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
          echo "cURL Error #:" . $err;
        } else {
              $data = json_decode($response, true); 
              $op = "<option value=''>-</option>";
              for ($i=0; $i < count($data['rajaongkir']['results']); $i++) {  
                $op .="<option value='".$data['rajaongkir']['results'][$i]['province_id']."'>".$data['rajaongkir']['results'][$i]['province']."</option>";
              }  
                echo $op; 
        }
    }

    function request_city() {
        $province = $this->input->get('province');
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://api.rajaongkir.com/starter/city?province={$province}",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET",
          CURLOPT_HTTPHEADER => array(
            "key: 5c8590c12ef6879e2b829c4ab6aa955e"
          ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
          echo "cURL Error #:" . $err;
        } else {
          $data = json_decode($response, true); 
          $op = "<option value=''>-</option>";
              for ($i=0; $i < count($data['rajaongkir']['results']); $i++) { 
              $op .=  "<option value='".$data['rajaongkir']['results'][$i]['city_id']."'>".$data['rajaongkir']['results'][$i]['city_name']."</option>"; 
              }  
                  echo $op;

        }
    }

    function request_ongkir() {
        $origin         = $this->input->get('origin'); 
        $destination    = $this->input->get('destination'); 
        $weight         = $this->input->get('weight') * 1000;
        $courier        = $this->input->get('courier');
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => "origin={$origin}&destination={$destination}&weight={$weight}&courier={$courier}",
          // CURLOPT_POSTFIELDS => "origin=501&destination=114&weight=1700&courier=jne",
          CURLOPT_HTTPHEADER => array(
            "content-type: application/x-www-form-urlencoded",
            "key: 5c8590c12ef6879e2b829c4ab6aa955e"
          ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
          echo "cURL Error #:" . $err;
        } else {
          $data = json_decode($response, true); 
          $op = "<option value=''>-</option>";
              for ($i=0; $i < count($data['rajaongkir']['results'][0]['costs']); $i++) {  
                $res = $data['rajaongkir']['results'][0]['costs'][$i];
                $op .= "<option value='@".$res['service']."@?".$res['cost'][0]['value']."?'>".$res['service']." (".$res['description']." - ".number_format($res['cost'][0]['value']).")</option>";
              }
                  echo $op; 
              // echo $response;
        }
    }
    
}