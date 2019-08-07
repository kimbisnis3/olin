<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Level extends CI_Controller {
    
    public $table       = 'topsi';
    public $foldername  = '';
    public $indexpage   = 'cpanel/level/v_level';
    function __construct() {
        parent::__construct();
        // include(APPPATH.'libraries/sessionsuper.php');
    }
    function index(){
        $this->load->view($this->indexpage);  
    }

    public function getall(){
        $akses      = $this->input->post('akses');
        $sql    = 
        "SELECT
            taction.nama_action,
            topsi.id_opsi,
            topsi.i,
            topsi.u,
            topsi.d,
            topsi.o
        FROM
            topsi
        LEFT OUTER JOIN taction ON topsi.ref_action_opsi = taction.id_action
        WHERE
            taction.entity_action = 'web'";

        if ($akses) {
            $sql  .=" AND 
            topsi.ref_access_opsi = '$akses'";
        }

        $sql  .=" ORDER BY
            taction.id_action";

        $result = $this->db->query($sql)->result();
        $no         = 1;
        $list       = [];
        foreach ($result as $r) {
            $row['id_opsi'] = $r->id_opsi;
            $row['no']      = $no;
            $row['i']       = $r->i;
            $row['u']       = $r->u;
            $row['d']       = $r->d;
            $row['p']       = $r->o;

            $list[] = $row;
            $no++;
        }   
        echo json_encode(array('data' => $list));
    }

    public function savedata()
    {   
        $d['useri']             = ien($this->session->userdata('nama_user'));
        $d['ref_access_opsi']   = ien($this->session->userdata('ref_access_opsi'));
        $d['ref_action_opsi']   = ien($this->session->userdata('ref_action_opsi'));
        $d['i']                 = ien($this->session->userdata('i'));
        $d['u']                 = ien($this->session->userdata('u'));
        $d['d']                 = ien($this->session->userdata('d'));
        $d['o']                 = ien($this->session->userdata('o'));

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

        $d['useru'] = ien($this->session->userdata('nama_user'));
        $d['i']     = ien($this->session->userdata('i'));
        $d['u']     = ien($this->session->userdata('u'));
        $d['d']     = ien($this->session->userdata('d'));
        $d['o']     = ien($this->session->userdata('o'));

        $w['id_opsi'] = $this->input->post('id');
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