<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Dbside extends CI_Controller {
    
    public $table       = 'customers';
    public $judul       = 'Dbside';
    public $aktifgrup   = 'dbside';
    public $aktifmenu   = 'dbside';
    public $foldername  = 'dbside';
    public $indexpage   = 'dbside/v_dbside';
    function __construct() {
        parent::__construct();
        // include(APPPATH.'libraries/sessionakses.php');
        $title      = $this->judul;
        $this->load->model('M_dbside','customers');
    }
    public function index(){
        $data['title']      = $this->judul;
        $data['aktifgrup']  = $this->aktifgrup;
        $data['aktifmenu']  = $this->aktifmenu;
        $title      = $this->judul;
        $this->load->view($this->indexpage, $data);  
    }

    public function fetchData()
    {
        $fields = $this->input->post('fields');
        foreach ($fields as $data) {
            $field[] = $data["field"];
        }
        $nama   = $this->input->post('nama');
        $limit  = $this->input->post('length');
        $offset = $this->input->post('start');
        $dtOrder = $this->input->post('order');
        $postOrder = $this->input->post('order_by');
        $getOrderCol = $dtOrder[0]['column'] == null ? "2" : $dtOrder[0]['column'] ;
        $orderCol = $field[$getOrderCol - 1]; //satu untuk kolom nomor
        $orderDir = $this->input->post('order')[0]['dir'];
        $sql    = "SELECT * FROM $this->table";
        if ($nama != '') {
            $sql .= "";
        }
        $sqlOrderBy = " ORDER BY $orderCol $orderDir";
        $sqlLimitOffset     = " LIMIT $limit OFFSET $offset";
        $total  = $this->db->query($sql)->num_rows();
        $list   = $this->db->query($sql.$sqlOrderBy.$sqlLimitOffset)->result();
        $no     = $this->input->post('start');
        $arr    = $field;
        $data   = array();
        foreach ($list as $customers) {
            $no++;
            $row = array();
            $row[] = $no;
            for ($i=0; $i < count($arr); $i++) { 
                $row[] = $customers->$arr[$i];
            }
            $row[] = 'button';
 
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $this->input->post('draw'),
                        "recordsTotal" => $total,
                        "recordsFiltered" => $total,
                        "data" => $data,
                        "order_by" => $orderCol
                );
        echo json_encode($output);
    }

    public function setView(){
        $result     = $this->Unimodel->getdata($this->table);
        $list       = array();
        $no         = 1;
        foreach ($result as $r) {
            if ($r->image == NULL ){
                $gambar = "(Noimage)";
            } else {
                $gambar = "<img style='max-width : 30px;' src='.".$r->image."'>";
            }
            $row    = array(
                        "no"        => $no,
                        "kode"      => $r->kode,
                        "judul"     => $r->judul,
                        "subjudul"  => $r->subjudul,
                        "artikel"   => $r->artikel,
                        "image"     => $gambar,
                        "ket"       => $r->ket,
                        "aktif"     => aktif($r->aktif),
                        "action"    => btnuda($r->id)
                        
            );
            $list[] = $row;
            $no++;
        }   
        echo json_encode(array('data' => $list));
    }

    public function ajax_listx()
    {
        $list = $this->customers->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $customers) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $customers->FirstName;
            $row[] = $customers->LastName;
            $row[] = $customers->phone;
            $row[] = $customers->address;
            $row[] = $customers->city;
            $row[] = $customers->country;
 
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->customers->count_all(),
                        "recordsFiltered" => $this->customers->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }

    public function backup()
    {
        $nama   = $this->input->post('nama');
        $limit  = $this->input->post('length');
        $offset = $this->input->post('start');
        $order  = $this->input->post('order');
        $sql    = "SELECT * FROM customers";
        if ($nama != '') {
            $sql .= " WHERE FirstName = 'Georg'";
        }
        
        $lo     = " LIMIT $limit OFFSET $offset";
        $total  = $this->db->query($sql)->num_rows();
        $list   = $this->db->query($sql.$lo)->result();
        $no     = $this->input->post('start');
        $arr    = ['FirstName','LastName','phone','address','city','country'];
        $data   = array();
        foreach ($list as $customers) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $customers->$arr[0];
            $row[] = $customers->$arr[1];
            $row[] = $customers->$arr[2];
            $row[] = $customers->$arr[3];
            $row[] = $customers->$arr[4];
            $row[] = $customers->$arr[5];
 
            $data[] = $row;
        }
        // $order['0']['column']
 
        $output = array(
                        "draw" => $this->input->post('draw'),
                        "recordsTotal" => $total,
                        "recordsFiltered" => $total,
                        "data" => $data,
                        "order_by" => count($arr)
                );
        echo json_encode($output);
    }

    
}