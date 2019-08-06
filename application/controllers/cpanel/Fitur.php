<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Fitur extends CI_Controller {
    
    public $table       = 'taction';
    public $foldername  = '';
    public $indexpage   = 'cpanel/fitur/v_fitur';
    function __construct() {
        parent::__construct();
        // include(APPPATH.'libraries/sessionakses.php');
    }
    function index(){
        $this->load->view($this->indexpage);  
    }

    public function getall(){
        $sql    = 
        "SELECT
            taction.nama_action,
            taction.id_action,
            taction.application_handle,
            taction.group_action,
            taction.icon_action,
            taction.sort_menu,
            taction.kategori_menu,
            taction_group.group_action namagroup
        FROM
            taction
        LEFT OUTER JOIN taction_group on taction.group_action = taction_group.kode 
        WHERE
            taction.entity_action ='web'
        ORDER BY
            taction.sort_menu";

        $result = $this->db->query($sql)->result();
        $no         = 1;
        $list       = [];
        foreach ($result as $r) {
            $row['id']                  = $r->id_action;
            $row['no']                  = $no;
            $row['nama_action']         = $r->nama_action;
            $row['application_handle']  = $r->application_handle;
            $row['group_action']        = $r->namagroup;
            $row['icon_action']         = $r->icon_action;
            $row['icon']               = "<i class='fa ". $r->icon_action."'></i>";
            $row['sort_menu']           = $r->sort_menu;
            $row['kategori_menu']       = $r->kategori_menu;

            $list[] = $row;
            $no++;
        }   
        echo json_encode(array('data' => $list));
    }

    public function savedata()
    {   
        $d['useri']             = $this->session->userdata('nama_user');
        $d['nama_action']       = $this->input->post('nama_action');
        $d['entity_action']     = 'web';
        $d['application_handle']= $this->input->post('application_handle');
        $d['group_action']      = $this->input->post('group_action');
        $d['icon_action']       = $this->input->post('icon_action');
        $d['sort_menu']         = $this->input->post('sort_menu');
        $d['kategori_menu']     = $this->input->post('kategori_menu');

        $result = $this->db->insert($this->table,$d);
        $r['sukses'] = $result ? 'success' : 'fail' ;
        echo json_encode($r);
    }

    public function edit()
    {
        $w['id_action']= $this->input->post('id');
        $data   = $this->db->get_where($this->table,$w)->row();
        echo json_encode($data);
    }

    function updatedata(){
        $d['useru']             = $this->session->userdata('nama_user');
        $d['dateu']             = 'now()';
        $d['nama_action']       = $this->input->post('nama_action');
        $d['entity_action']     = 'web';
        $d['application_handle']= $this->input->post('application_handle');
        $d['group_action']      = $this->input->post('group_action');
        $d['icon_action']       = $this->input->post('icon_action');
        $d['sort_menu']         = $this->input->post('sort_menu');
        $d['kategori_menu']     = $this->input->post('kategori_menu');

        $w['id_action'] = $this->input->post('id');
        $result = $this->db->update($this->table,$d,$w);
        $r['sukses'] = $result ? 'success' : 'fail' ;
        echo json_encode($r);
    }

    public function deletedata()
    {
        $w['id_action'] = $this->input->post('id');
        $result = $this->db->delete($this->table,$w);
        $r['sukses'] = $result ? 'success' : 'fail' ;
        echo json_encode($r);
    }
    
}