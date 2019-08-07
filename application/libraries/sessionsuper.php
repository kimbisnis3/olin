<?php
	$issuper = $this->session->userdata('issuper');
	$title = 'Tersebut';
	if ($issuper != 1) {
		$this->session->set_flashdata('messageakses', '<script>messageakses("'.$title.'")</script>');
	redirect('landingpage');
}
?>