<?php 
    $issuper_access = $this->session->userdata('issuper_access');


    $this->load->model('M_sidebar'); 
    $this->load->helper('stringvar');
    $this->load->helper('indonesian_date');
    $this->load->helper('id_date');
    $this->load->helper('ien');

    
 ?>