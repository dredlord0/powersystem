<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Logout extends CI_Controller {
		
	public function index() {
		$this->load->helper('url');
		unset($_SESSION['logged_in']);
		redirect('dashboard', 'refresh');
	}
}

