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
        $q = "SELECT
                xorder.id
            FROM
                xorder";
        $result     = $this->db->query($q)->result();
        $no         = 1;
        $list       = [];
        foreach ($result as $r) {
            $row['id']      = $r->id;
            $list[] = $row;
            $no++;
        }   
        echo json_encode(array('data' => $list));
    }

    public function savedata()
    {   
        $this->db->trans_begin();
        $upcorel    = $this->libre->goUpload('corel','corel-'.time(),$this->foldername);
        $upimage    = $this->libre->goUpload('image','img-'.time(),$this->foldername);
        $a['pathcorel'] = $upcorel;
        $a['pathimage'] = $upimage;
        $a['useri']     = $this->session->userdata('username');
        $a['ref_cust']  = $this->input->post('ref_cust');
        $a['tgl']       = date('Y-m-d', strtotime($this->input->post('tgl')));
        $a['ref_gud']   = $this->input->post('ref_gud');
        $a['ref_kirim'] = $this->input->post('ref_kirim');
        $a['ref_layanan'] = $this->input->post('ref_layanan');
        $a['ket']       = $this->input->post('ket');
        $a['lokasidari']= $this->input->post('provinsi').' - '.$this->input->post('city');
        $a['lokasike']  = $this->input->post('provinsito').' - '.$this->input->post('cityto');
        $a['kgkirim']   = $this->input->post('berat');
        $a['bykirim']   = $this->input->post('biaya');
        $a['kurir']     = $this->input->post('kodekurir');
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
        $design = $this->db->get_where('mbarangs',array('ref_brg' => $kodebrg,));
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

        $this->db->insert_batch('xorders',$c);

        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            $r['status'] = 'Tidak Sukses';
        }
        else
        {
            $this->db->trans_commit();
            $r['status'] = 'Sukses';
        }
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
                mbarang.id,
                mbarang.kode,
                mbarang.nama,
                mbarang.ket,
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
                mbarang
            LEFT JOIN msatbrg ON msatbrg.ref_brg = mbarang.kode
            LEFT JOIN msatuan ON msatuan.kode = msatbrg.ref_sat
            LEFT JOIN mgudang ON mgudang.kode = msatbrg.ref_gud
            WHERE
                msatbrg.def = 't'";
        $result     = $this->db->query($q)->result();
        $list       = [];
        foreach ($result as $i => $r) {
            $row['id']          = $r->id;
            $row['no']          = $i + 1;
            $row['nama']        = $r->nama;
            $row['kode']        = $r->kode;
            $row['ket']         = $r->ket;
            $row['namasatuan']  = $r->namasatuan;
            $row['harga']       = $r->harga;

            $list[] = $row;
        }   
        echo json_encode(array('data' => $list));
    }

    public function edit()
    {
        $w['id']= $this->input->post('id');
        $data   = $this->db->get_where($this->table,$w)->row();
        echo json_encode($data);
    }

    public function getselects()
    {
        $data   = $this->db->get($this->table)->result();
        echo json_encode($data);
    }

    function updatedata(){
        $d['useru']     = $this->session->userdata('username');
        $d['dateu']     = 'now()';
        $d['nama']      = $this->input->post('nama');
        $d['colorc']    = $this->input->post('kodewarna');
        $d['ket']       = $this->input->post('ket');
        $w['id'] = $this->input->post('id');
        $result = $this->db->update($this->table,$d,$w);
        $r['sukses'] = $result ? 'success' : 'fail' ;
        echo json_encode($r);
    }

    public function deletedata()
    {
        $w['id'] = $this->input->post('id');
        $result = $this->db->delete($this->table,$w);
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