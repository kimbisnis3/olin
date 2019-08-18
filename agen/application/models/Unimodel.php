<?php
class Unimodel extends CI_Model{

    function __construct() {
        parent::__construct();
    }

    function getaksesmenu_new(){
        $access     = $this->session->userdata("access");
        $issuper    = $this->session->userdata("issuper");
        $sql    = 
            "SELECT 
            taction_group.group_action,
            taction_group.icon_group,
            taction.nama_action nama,
            taction.icon_action icon,
            taction.kategori_menu kategori,
            taction.url
        FROM
            taction
        LEFT OUTER JOIN topsi ON taction.id_action = topsi.ref_action_opsi
        LEFT OUTER JOIN taction_group ON taction.group_action = taction_group.kode
        WHERE
            taction.entity_action = 'web' 
        ";

        if ($issuper !='1' or $issuper != '1') {
            $sql .= " AND topsi.ref_access_opsi = '$access'";
        }

        // if ($access == '1' or $access == '1') {
        // $sql .= " GROUP BY taction_group.icon_group,taction_group.sort_group, taction_group.group_action, taction.nama_action, taction.sort_menu,taction.icon_action,taction.kategori_menu,taction.url";
        // }
        $sql .= " ORDER BY taction_group.sort_group, taction.sort_menu ASC";


        $query = $this->db->query($sql);
        return $query->result();
    }
   

    function que_all($sql)
    {
        $query = $this->db->query($sql);
        return $query->result();
    }

    function getdata($table)
    {
        $query = $this->db->get($table);
        return $query->result();
    }

    function getdatawall($table,$where)
    {
        $this->db->where($where);
        $query = $this->db->get($table);
        return $query->result();
    }

    function getdataw($table,$where)
    {
        $query = $this->db->get($table,$where);
        return $query->row();
    }

    function save($table, $data)
    {
        $this->db->insert($table, $data);
        return $this->db->affected_rows();
    }

    function edit($table,$where)
    {
        $this->db->where($where);
        $query = $this->db->get($table);
        return $query->row();
    }

    function update($table, $data, $where)
    {
        $this->db->update($table, $data, $where);
        return $this->db->affected_rows();
    }

    function delete($table, $where)
    {
        $this->db->where($where);
        $this->db->delete($table);
        return $this->db->affected_rows();
    }

    function cek_auth($tb,$where)
    {
        return $this->db->get_where($tb,$where);
    }

    public function get_user_info($username)
    {
        $sql    = 
        "SELECT
            *
        FROM
            tuser
        LEFT JOIN taccess ON tuser.ref_access_user = taccess.id_access
        WHERE 
            tuser.nama_user='$username'";

        $query = $this->db->query($sql);
        return $query;
    }

    public function sessionkodeup($wheresession, $session_kode)
    {
        $this->db->update('tuser', $session_kode, $wheresession);
    }
    

    function getaccess(){
        $sql    = 
        "SELECT
            taccess.id_access,
            taccess.nama_access
        FROM
            taccess
        WHERE
            taccess.issuper_access = '0'";

        $query = $this->db->query($sql);
        return $query->result();
    }

    function getaction(){
        $sql    = 
        "SELECT
            taction.id_action,
            taction.nama_action,
            taction.application_handle
        FROM
            taction";

        $query = $this->db->query($sql);
        return $query->result();
    }


}
?>