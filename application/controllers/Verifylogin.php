<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class VerifyLogin extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('user','',TRUE);
		$this->load->model('Header_model');

	}

	function index()
	{
		$this->load->helper ( 'url' );
		//This method will have the credentials validation
		$this->load->library('form_validation');

		$this->form_validation->set_rules('username', 'Username', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|callback_check_database');

		if($this->form_validation->run() == FALSE)
		{
			$this->load->helper ( 'html' );
			
			$header_data=$this->Header_model->setHeaderData();
			$header_data ['active'] = '';
			
			$this->load->view ( 'header', $header_data );
			$this->load->view ( 'login' );
			$this->load->view ( 'footer' );
		}
		else
		{
			redirect('dashboard', 'refresh');
		}

	}

	function check_database($password)
	{

		//Field validation succeeded.  Validate against database
		$username = $this->input->post('username');

		//query the database
		$result = $this->user->login($username, $password);
		//print_r($result);
		if($result)
		{
			$sess_array = array();
			foreach($result as $row)
			{
				$sess_array = array(
						'id' => $row->id,
						'username' => $row->username
				);
				$this->session->set_userdata('logged_in', $sess_array);
			}
			return TRUE;
		}
		else
		{
			$this->form_validation->set_message('check_database', '<i class="fa fa-exclamation "></i> Invalid username or password');
			return false;
		}
	}

}

?>