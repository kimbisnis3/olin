<?php 

	$issuper_access = $this->session->userdata('issuper_access');
	if ($issuper_access != 1) {
		$ref_access_user = $this->session->userdata('ref_access_user');
        $get_ref_action_user = $this->T_akses->getaccessuser($title);
        $ref_action_user    = $get_ref_action_user->id;

        $i          = $this->T_akses->getopsi($ref_access_user,$ref_action_user)->i;
        $u          = $this->T_akses->getopsi($ref_access_user,$ref_action_user)->u;
        $d          = $this->T_akses->getopsi($ref_access_user,$ref_action_user)->d;
        $o          = $this->T_akses->getopsi($ref_access_user,$ref_action_user)->o;

        $i_button   = "style = 'display : '";
        $u_button   = "style = 'display : '";
        $d_button   = "style = 'display : '";
        $o_button   = "style = 'display : '";

        if ($i == 't') {
            $get_i_button = $i_button ;
        } else {
            $get_i_button =  "style = 'display : none'";
        };

        if ($u == 't') {
            $get_u_button = $u_button ;
        } else {
            $get_u_button =  "style = 'display : none'";
        };

        if ($d == 't') {
            $get_d_button = $d_button ;
        } else {
            $get_d_button =  "style = 'display : none'";
        };

        if ($o == 't') {
            $get_o_button = $o_button ;
        } else {
            $get_o_button =  "style = 'display : none'";
        };
    }else 
    {
    	$ref_access_user = '';
        $get_ref_action_user = $this->T_akses->getaccessuser($title);
        $ref_action_user    = $get_ref_action_user->id;

        /**
        $i          = $this->T_akses->getopsi($ref_access_user,$ref_action_user)->i;
        $u          = $this->T_akses->getopsi($ref_access_user,$ref_action_user)->u;
        $d          = $this->T_akses->getopsi($ref_access_user,$ref_action_user)->d;
        $o          = $this->T_akses->getopsi($ref_access_user,$ref_action_user)->o;
        **/
        $true = 't';
        
        $i          = $true;
        $u          = $true;
        $d          = $true;
        $o          = $true;

        $i_button   = "style = 'display : '";
        $u_button   = "style = 'display : '";
        $d_button   = "style = 'display : '";
        $o_button   = "style = 'display : '";

        if ($i == 't') {
            $get_i_button = $i_button ;
        } else {
            $get_i_button =  "style = 'display : none'";
        };

        if ($u == 't') {
            $get_u_button = $u_button ;
        } else {
            $get_u_button =  "style = 'display : none'";
        };

        if ($d == 't') {
            $get_d_button = $d_button ;
        } else {
            $get_d_button =  "style = 'display : none'";
        };

        if ($o == 't') {
            $get_o_button = $o_button ;
        } else {
            $get_o_button =  "style = 'display : none'";
        };
    }
 ?>