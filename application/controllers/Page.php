<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Page extends CI_Controller {
		
	function __construct()
	{
		parent::__construct();
		$this->load->model('Header_model');
	
	}
	public function index() {

		$this->load->helper ( 'html' );
		$this->load->helper ( 'url' );

		
		$header_data=$this->Header_model->setHeaderData();
		$header_data['active']='page';
						
		$this->load->view ( 'header', $header_data );
		$this->load->view ( 'page' );
		$this->load->view ( 'footer' );
	}
}

