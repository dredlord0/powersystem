<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Login extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('Header_model');
	
	}
	
	public function index() {

		$this->load->helper ( 'html' );
		$this->load->helper ( 'url' );
		$this->load->helper(array('form', 'url'));
		
		$header_data=$this->Header_model->setHeaderData();		
		$header_data ['active'] = '';
		
		$this->load->view ( 'header', $header_data );
		$this->load->view ( 'login' );
		$this->load->view ( 'footer' );
	}
}

