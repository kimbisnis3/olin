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
        $w['iduser']    = $this->session->userdata("id");
        $w['idmenu']    = $this->input->post("menu");

        $sql ="SELECT
            taction.nama_action,
            taction.id_action,
            taction_group.kode kodeinduk,
            topsi.i,
            topsi.u,
            topsi.d,
            topsi.o
        FROM
            topsi
        LEFT JOIN taction ON topsi.ref_action_opsi = taction.id_action
        LEFT OUTER JOIN taction_group ON taction.group_action = taction_group.kode
        WHERE nama_action = '{$this->input->post('menu')}'";

        $r['res'] = $this->db->query($sql)->row();
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
        AND topsi.ref_access_opsi = {$this->session->userdata("access")}";

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

    

}
