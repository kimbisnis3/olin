<?php
$session = $this->session->userdata('in_cl');
if ($session != TRUE)
{
    $this->session->set_flashdata('message', '<div style="color : red">Login Terlebih Dahulu</div>');
    redirect('auth');
}


?>