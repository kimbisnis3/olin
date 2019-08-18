<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Topsi {

        public function getopsi(){
            
        $ref_access_user = $this->session->userdata('ref_access_user');
        $get_ref_action_user = $this->T_akses->getaccessuser($title);
        $ref_action_user    = $get_ref_action_user->id;

        $get_i          = $this->T_akses->getopsi_i($ref_access_user,$ref_action_user);
        $get_u          = $this->T_akses->getopsi_u($ref_access_user,$ref_action_user);
        $get_d          = $this->T_akses->getopsi_d($ref_access_user,$ref_action_user);
        $get_o          = $this->T_akses->getopsi_o($ref_access_user,$ref_action_user);

        $i  = $get_i->i ;
        $u  = $get_u->u ;
        $d  = $get_d->d ;
        $o  = $get_o->o ;

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

        public function topsidata($title)
        {
        $ref_access_user = $this->session->userdata('ref_access_user');
        $get_ref_action_user = $this->T_akses->getaccessuser($title);
        $ref_action_user    = $get_ref_action_user->id;

        $i          = $this->T_akses->getopsi_i($ref_access_user,$ref_action_user)->i;
        $u          = $this->T_akses->getopsi_u($ref_access_user,$ref_action_user)->u;
        $d          = $this->T_akses->getopsi_d($ref_access_user,$ref_action_user)->d;
        $o          = $this->T_akses->getopsi_o($ref_access_user,$ref_action_user)->o;

        $i_button   = "style = 'display : '";
        $u_button   = "style = 'display : '";
        $d_button   = "style = 'display : '";
        $o_button   = "style = 'display : '";

        if ($i == 't') {
            $data['get_i_button'] = $i_button ;
        } else {
            $data['get_i_button'] =  "style = 'display : none'";
        };

        if ($u == 't') {
            $data['get_u_button'] = $u_button ;
        } else {
            $data['get_u_button'] =  "style = 'display : none'";
        };

        if ($d == 't') {
            $data['get_d_button'] = $d_button ;
        } else {
            $data['get_d_button'] =  "style = 'display : none'";
        };

        if ($o == 't') {
            $data['get_o_button'] = $o_button ;
        } else {
            $data['get_o_button'] =  "style = 'display : none'";
        };
        }
}