<?php

defined('BASEPATH') or exit('No direct script access allowed');

class libre
{
    public $roapi = 'af0f53b5091a4d355a9a425cd6c802ac';

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

    public function ftp_akun()
    {
        $config['hostname'] = '127.0.0.1';
        $config['username'] = 'admin';
        $config['password'] = 'admin';
        $config['debug']    = TRUE;
        return $config;
    }

    function list_ftp($dir)
    {
        $ci=& get_instance();
        $ci->load->library('ftp');
        $ci->ftp->connect($this->ftp_akun());
        $list = $ci->ftp->list_files($dir);
        $ci->ftp->close();
        return $list;
    }

    function upload_ftp($source, $destination)
    {
        $ci=& get_instance();
        $ci->load->library('ftp');
        $ci->ftp->connect($this->ftp_akun());
        $ci->ftp->upload($source, $destination);
        $ci->ftp->close();
        // @unlink($source);
        return true;
    }

    function download_ftp($server, $local)
    {
        $ci=& get_instance();
        $ci->load->library('ftp');
        $ci->ftp->connect($this->ftp_akun());
        $ci->ftp->download($server, $local, 'ascii');
        $ci->ftp->close();
        return true;
    }

    function delete_ftp($file)
    {
        $ci=& get_instance();
        $ci->load->library('ftp');
        $ci->ftp->connect($this->ftp_akun());
        $ci->ftp->delete_file($file);
        $ci->ftp->close();
        return true;
    }

    function mirror_ftp($source, $destination)
    {
        $ci=& get_instance();
        $ci->load->library('ftp');
        $ci->ftp->connect($this->ftp_akun());
        $this->ftp->mirror($source, $destination);
        $ci->ftp->close();
        return true;
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

    function get_province_pro()
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://pro.rajaongkir.com/api/province",
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

    function get_city_pro($provincecode)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://pro.rajaongkir.com/api/city?province={$provincecode}",
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

    function get_dist_pro($citycode)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://pro.rajaongkir.com/api/subdistrict?city={$citycode}",
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

    function get_ongkir_pro($origin, $origintype, $destination, $destinationtype, $weight, $courier)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://pro.rajaongkir.com/api/cost",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => "origin={$origin}&originType={$origintype}&destination={$destination}&destinationType={$destinationtype}&weight={$weight}&courier={$courier}",
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
