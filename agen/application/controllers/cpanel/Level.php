<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Level extends CI_Controller {
    
    public $table       = 'topsi';
    public $foldername  = '';
    public $indexpage   = 'cpanel/level/v_level';
    function __construct() {
        parent::__construct();
        include(APPPATH.'libraries/sessionsuper.php');
    }
    function index(){
        $level    = "SELECT * FROM taccess WHERE taccess.issuper_access != 1";
        $fitur    = "SELECT * FROM taction
        LEFT JOIN topsi ON taction.id_action = topsi.ref_action_opsi
        WHERE
            taction.id_action NOT IN (
                SELECT
                    topsi.ref_action_opsi
                FROM
                    topsi
                WHERE
                    ref_access_opsi = '{$this->session->userdata('access')}'
            )";
        $data['level'] = $this->db->query($level)->result();
        $data['fitur'] = $this->db->query($fitur)->result();
        $this->load->view($this->indexpage,$data);  
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
            $row['id'] = $r->id_opsi;
            $row['nama_action'] = $r->nama_action;
            $row['no']      = $no;
            $row['i']       = checkcolor($r->i);
            $row['u']       = checkcolor($r->u);
            $row['d']       = checkcolor($r->d);
            $row['o']       = checkcolor($r->o);

            $list[] = $row;
            $no++;
        }   
        echo json_encode(array('data' => $list));
    }

    public function savedata()
    {   
        $d['useri']             = ien($this->session->userdata('username'));
        $d['ref_access_opsi']   = ien($this->input->post('access'));
        $d['ref_action_opsi']   = ien($this->input->post('action'));
        $d['i']                 = ien($this->input->post('i'));
        $d['u']                 = ien($this->input->post('u'));
        $d['d']                 = ien($this->input->post('d'));
        $d['o']                 = ien($this->input->post('o'));

        $result = $this->db->insert($this->table,$d);
        $r['sukses'] = $result ? 'success' : 'fail' ;
        echo json_encode($r);
    }

    public function edit()
    {
        $w['id_opsi']= $this->input->post('id');
        $data   = $this->db->get_where($this->table,$w)->row();
        echo json_encode($data);
    }

    function updatedata(){

        $d['useru'] = ien($this->session->userdata('username'));
        $d['i']     = ien($this->input->post('i'));
        $d['u']     = ien($this->input->post('u'));
        $d['d']     = ien($this->input->post('d'));
        $d['o']     = ien($this->input->post('o'));

        $w['id_opsi'] = $this->input->post('id_opsi');
        $result = $this->db->update($this->table,$d,$w);
        $r['sukses'] = $result ? 'success' : 'fail' ;
        echo json_encode($r);
    }

    public function deletedata()
    {
        $w['id_opsi'] = $this->input->post('id');
        $result = $this->db->delete($this->table,$w);
        $r['sukses'] = $result ? 'success' : 'fail' ;
        echo json_encode($r);
    }
    
}