<?php 
    $issuper_access = $this->session->userdata('issuper_access');

    if ($issuper_access != 1) {
        $sessionname    = $this->session->userdata('sioin');
        $session_web    = $this->session->userdata('session_web');
        $username       = $this->session->userdata('nama_user');
        $sessiontoken   = $this->T_akses->getsessiontoken($username)->session_web;
        if (($sessionname != TRUE))
        {
            $this->session->set_flashdata('messagelogin', '<div class="alert alert-danger alert-dismissible"><i class="fa fa-sign-in"></i> Silahkan Login Kembali
              </div>');
            redirect('auth');
        }
        if (($sessionname != TRUE and $session_web != $sessiontoken))
        {
            $this->session->set_flashdata('messagelogin', '<div class="alert alert-danger alert-dismissible"><i class="fa fa-sign-in"></i> Silahkan Login Kembali
              </div>');
            redirect('auth');
        }
        if (($sessionname == TRUE and $session_web != $sessiontoken))
        {
            $this->session->set_flashdata('messagelogin', '<div class="alert alert-danger alert-dismissible"><i class="fa fa-sign-in"></i> User Terdeteksi Login di Tempat Lain
              </div>');
            redirect('auth');
        }
        $ref_access_user = $this->session->userdata('ref_access_user');
        $get_ref_action_user = $this->T_akses->getaccessuser($title);
        $ref_action_user= $get_ref_action_user->id;
        $getgranted = $this->T_akses->grantedaccess($ref_access_user,$ref_action_user);
        $granted= $getgranted->jml;
        if ($granted == 0) {
        $this->session->set_flashdata('messageakses', '<script>messageakses("'.$title.'")</script>');
        redirect('landingpage'); 
        }
    }

    $this->load->model('M_sidebar'); 
    $this->load->helper('stringvar');
    $this->load->helper('indonesian_date');
    $this->load->helper('id_date');
    $this->load->helper('ien');

    
 ?>