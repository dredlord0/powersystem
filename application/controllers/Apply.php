<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Apply extends CI_Controller {
	function __construct() {
		parent::__construct ();
		$this->load->model('Header_model');
		$this->load->model ( 'user', '', TRUE );
		$this->config->load ( 'custom' );
	}
	private $toSysCron = '';
	
	public function index() {
		$this->load->helper ( 'html' );
		$this->load->helper ( 'url' );
		if (isset ( $_SESSION ['logged_in'] )) {
				$this->clearCrontab ();
				$this->generateCrontab ();
				$this->applyToSystem ();
				$this->session->unset_userdata ( 'apply_button' );
				redirect ( 'dashboard', 'refresh' );			
		} else {
			redirect ( 'login', 'refresh' );
		}
	}
	
	private function generateCrontab() {
		$query = $this->db->query ( 'SELECT g.gpio, c.* FROM gpio as g, cron as c, powersocket as p WHERE g.id_powersocket=c.id_powersocket AND p.id=c.id_powersocket AND g.status=1 AND p.scheduler_enabled=1' );
		
		foreach ( $query->result () as $row ) {
			$gpio = $row->gpio;
			$id_cron = $row->id;
			$time_start = $row->time_start;
			$time_stop = $row->time_stop;
			
			$cron_sys_start = $this->simpleToCron ( $time_start, $gpio, 1 );
			$cron_sys_stop = $this->simpleToCron ( $time_stop, $gpio, 0 );
			
			$this->user->simpleAddNewCrontab ( $id_cron, $cron_sys_start );
			$this->user->simpleAddNewCrontab ( $id_cron, $cron_sys_stop );
			
			$this->toSysCron = $this->toSysCron . $cron_sys_start . PHP_EOL . $cron_sys_stop . PHP_EOL;
		}
	}
	private function simpleToCron($time, $gpio, $condition) {
		// retrun commnad crontab job
		$a_time = explode ( ":", $time );
		$command = $this->config->item ( 'gpioOutput' );
		return $a_time [1] . ' ' . $a_time [0] . ' * * * ' . $command . ' ' . $gpio . ' ' . $condition;
	}
	private function clearCrontab() {
		$this->db->truncate ( 'crontab' );
		echo exec ( 'crontab -u www-data -r' );
	}
	private function applyToSystem() {
		$output = shell_exec ( 'crontab -u www-data -l' );
		file_put_contents ( '/tmp/crontab.txt', $output . $this->toSysCron );
		echo exec ( 'crontab /tmp/crontab.txt' );
	}
}

