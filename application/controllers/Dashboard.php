<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Dashboard extends CI_Controller {
	function __construct() {
		parent::__construct ();
		$this->load->model ( 'Header_model' );
		$this->config->load ( 'custom' );
		$this->load->model ( 'user', '', TRUE );
	}
	private $confErorCron = '';
	private function chekIfCanWork() {
		$gpioGroup = exec ( 'cat /etc/group | grep gpio' );
		if ($gpioGroup == '') {
			$this->confErorCron = 'sudo apt-get install python-rpi.gpio python-gpiozero python3-gpiozero python3-rpi.gpio wiringpi';
			return false;
		} else {
			if (preg_match ( '/www-data/', $gpioGroup )) {
				return true;
			} else
				$this->confErorCron = 'sudo adduser www-data gpio';
			return false;
		}
	}
	public function index() {
		$this->load->helper ( 'html' );
		$this->load->helper ( 'url' );
		
		$header_data = $this->Header_model->setHeaderData ();
		$header_data ['active'] = 'dashboard';
		
		if ($this->chekIfCanWork ()) {
			
			$dashboard_data ['row1'] = '';
			
			$query = $this->db->query ( 'SELECT g.gpio, p.* FROM gpio as g, powersocket as p WHERE p.id=g.id_powersocket AND g.status="1" ORDER BY powersocket ASC' );
			
			foreach ( $query->result () as $row ) {
				$status = exec ( '/opt/PowerSystem/application/third_party/python/readGpioOutput.py ' . $row->gpio . '' );
				if ($status == 1) {
					$color [0] = 'green';
					$color [1] = 'bolt';
					$status_desc = 'is ON';
					$b_power [0] = 'Poweroff';
					$b_power [1] = 'danger';
				} else {
					$color [0] = 'red';
					$color [1] = 'bolt';
					$status_desc = 'is OFF';
					$b_power [0] = 'Poweron';
					$b_power [1] = 'success';
				}
				
				if ($row->scheduler_enabled == 1) {
					$b_status [1] = 'primary';
				} else {
					$b_status [1] = 'default';
				}
				
				$dashboard_data ['row1'] = $dashboard_data ['row1'] . '
			<div class="col-md-3 col-sm-6 col-xs-6">
				<div class="panel panel-back noti-box">
					<span class="icon-box bg-color-' . $color [0] . ' set-icon"> <i class="fa fa-' . $color [1] . '"></i></span>
						<div class="text-box">Power socket ' . $row->powersocket . ' (' . $row->name . ')
							<p class="main-text">' . $status_desc . '</p>
						</div>
						<div class="panel-body">
									<a href="/dashboard/changeStatusPowerSocket/' . $row->id . '" class="btn btn-' . $b_power [1] . ' btn-xs">' . $b_power [0] . '</a>
									<a href="/scheduler/showpowersocket/' . $row->id . '" class="btn btn-' . $b_status [1] . ' btn-xs">Scheduler</a>
						</div>
				</div>
			</div>';
			}
			$dashboard_data ['version'] = $this->config->item ( 'version' );
			
			//$this->output->set_header('refresh:5; url=/');
			$this->load->view ( 'header', $header_data );
			$this->load->view ( 'dashboard', $dashboard_data );
			$this->load->view ( 'footer' );
		} else {
			$error_data ['confErorCron'] = $this->confErorCron;
			
			$this->load->view ( 'header', $header_data );
			$this->load->view ( 'error', $error_data );
			$this->load->view ( 'footer' );
		}
	}
	public function changeStatusPowerSocket($powersocket) {
		$this->load->helper ( 'html' );
		$this->load->helper ( 'url' );
		if (isset ( $_SESSION ['logged_in'] )) {
			
			$query = $this->db->query ( 'SELECT gpio FROM gpio WHERE id_powersocket=' . $powersocket . '' );
			
			$row = $query->row ();
			
			if (isset ( $row )) {
				exec ( '/opt/PowerSystem/application/third_party/python/changeOpposedGpioOutput.py ' . $row->gpio );
			}
			redirect ( 'dashboard', 'refresh' );
		} else {
			redirect ( 'login', 'refresh' );
		}
	}
}