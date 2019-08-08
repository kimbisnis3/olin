<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Universe extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    function insert(){
        $jumlah_data = 500;
        for ($i=1;$i<=$jumlah_data;$i++){
            $data   =   array(
                "judul"     =>  "Judul Ke-".$i,
                "artikel"   =>  "artikel ke-".$i,
                "ket"       =>  '089699935552');
            $this->db->insert('fartikel',$data); 
        }
        echo $i.' Data Berhasil Di Insert';
    }

    function getAkses() {
        $w['akses']     = $this->session->userdata("access");
        $w['idmenu']    = $this->input->post("menu");

        $sql ="SELECT
            taction.nama_action,
            taction.id_action,
            taction_group.kode kodeinduk,
            topsi.i,
            topsi.u,
            topsi.d,
            topsi.o,
            topsi.ref_access_opsi akses,
            taccess.issuper_access super
        FROM
            topsi
        LEFT JOIN taction ON topsi.ref_action_opsi = taction.id_action
        LEFT JOIN taccess ON topsi.ref_access_opsi = taccess.id_access
        LEFT OUTER JOIN taction_group ON taction.group_action = taction_group.kode
        WHERE 
            nama_action = '{$this->input->post('menu')}'
        AND 
            topsi.ref_access_opsi = '{$this->session->userdata("access")}'";

        $r['res']       = $this->db->query($sql)->row();
        $r['super']     = $w['akses'];
        $r['akses']     = $this->db->query($sql)->num_rows() ;
        echo json_encode($r);

    }

    function getMenu() {
        $induk = "SELECT DISTINCT
            taction.kategori_menu,
            taction_group.group_action namainduk,
            taction_group.kode kodeinduk,
            taction_group.icon_group iconinduk
        FROM
            taction
        LEFT OUTER JOIN topsi ON taction.id_action = topsi.ref_action_opsi
        LEFT OUTER JOIN taction_group ON taction.group_action = taction_group.kode
        WHERE
            taction.entity_action = 'web'
        AND topsi.ref_access_opsi = {$this->session->userdata("access")}
        ORDER BY taction_group.kode ASC";

        $anak = "SELECT
            taction.kategori_menu,
            taction.id_action,
            taction.nama_action,
            taction.application_handle,
            taction.path,
            taction_group.group_action namainduk,
            taction_group.kode kodeinduk
        FROM
            taction
        LEFT OUTER JOIN topsi ON taction.id_action = topsi.ref_action_opsi
        LEFT OUTER JOIN taction_group ON taction.group_action = taction_group.kode
        WHERE
            taction.entity_action = 'web'
        AND topsi.ref_access_opsi = {$this->session->userdata("access")}
        ORDER BY
            kategori_menu";

        $r['induk'] = $this->db->query($induk)->result();
        $r['anak']  = $this->db->query($anak)->result();
        echo json_encode($r);

    }

    function getGroupMenu() {
        $r = $this->db->get('taction_group')->result();
        echo json_encode($r);
    }

    public function getAllUser()
    {
        $sql    = 
        "SELECT
            *
        FROM
            tuser
        LEFT JOIN taccess ON tuser.ref_access_user = taccess.id_access
        WHERE 
            taccess.issuper_access != 1";

        $r = $this->db->query($sql)->result();
        echo json_encode($r);
    }

    public function getAllLevel()
    {
        $sql    = 
        "SELECT
            *
        FROM
            taccess
        WHERE 
            taccess.issuper_access != 1";

        $r = $this->db->query($sql)->result();
        echo json_encode($r);
    }

    public function getAllFiturByUser()
    {
        $sql    = 
        "SELECT
            *
        FROM
            taction
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

        $r = $this->db->query($sql)->result();
        echo json_encode($r);
    }

    

}
