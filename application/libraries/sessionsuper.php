<?php
	$issuper_access = $this->session->userdata('issuper_access');
	$title = 'Tersebut';
	if ($issuper_access != 1) {
		$this->session->set_flashdata('messageakses', '<script>messageakses("'.$title.'")</script>');
	redirect('landingpage');
}
?>