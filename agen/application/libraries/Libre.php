<?php

defined('BASEPATH') or exit('No direct script access allowed');

class libre
{   
    public $roapi = '5c8590c12ef6879e2b829c4ab6aa955e';

    public function pathupload()
    {
      //upload diarahkan ke folder agen supaya agen tidak kesulitan menulis file ke folder di atas root webnya
      return './uploads/';
    }

    public function goUpload($field,$filename,$dir)
    {
        $ci=& get_instance();
        // chmod($this->pathupload(),0777);
        $config['upload_path'] = $this->pathupload().$dir;
        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, TRUE);
        }
        $config['allowed_types'] = '*';
        $config['file_name'] = $filename;
        $path = substr($config['upload_path'],1);
        $ci->upload->initialize($config);
        if ($ci->upload->do_upload($field)) {
            return $path.'/'.$ci->upload->data('file_name');
        } else {
            return null;
        }
    }

    public function delFile($link)
    {
        @unlink('.'.$link);
        return 'oke';
    }

    public function gud_def(){
        return 'GX0001';
    }

    public function appname(){
        return 'Olin';
    }

    function get_province_ro(){
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
            "key: $this->roapi"
          ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        return $response;
    }

    function get_city_ro($provincecode){
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://api.rajaongkir.com/starter/city?province={$provincecode}",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET",
          CURLOPT_HTTPHEADER => array(
            "key: $this->roapi"
          ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        return $response;
    }

    function get_ongkir_ro($origin, $destination, $weight, $courier){
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
          CURLOPT_HTTPHEADER => array(
            "content-type: application/x-www-form-urlencoded",
            "key: $this->roapi"
          ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
        return $response;

    }

    public function companydata() {
      $ci=& get_instance();
      $result = $ci->db->get('tcompany')->row();
      return $result;
    }
}
