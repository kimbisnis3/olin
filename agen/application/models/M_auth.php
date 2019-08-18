<?php

class M_auth extends CI_Model{

  function cek_auth($tuser,$where){

    return $this->db->get_where($tuser,$where);

  }

      public function datauser($username)
        {
        $sql    = 
        "SELECT
            t_user.*
        FROM
            t_user
        WHERE 
            t_user.username='$username'
        ";

        $query = $this->db->query($sql);
        return $query->row();
    }

    public function sessionkodeup($wheresession, $session_kode)
    {
        $this->db->update('t_user', $session_kode, $wheresession);
    }
}
