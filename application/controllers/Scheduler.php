<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Scheduler extends CI_Controller {
	function __construct() {
		parent::__construct ();
		$this->load->model ( 'user', '', TRUE );
		$this->load->model ( 'Header_model' );
		$this->config->load ( 'custom' );
	}
	public function showSimpleEdit($id_cron, $id_powersocket) {
		$this->load->helper ( 'html' );
		$this->load->helper ( 'url' );
		if (isset ( $_SESSION ['logged_in'] )) {
			$this->load->helper ( array (
					'form',
					'url' 
			) );
			$result = $this->user->getDataMysqlId ( 'powersocket', $id_powersocket );
			if ($result) {
				
				foreach ( $result as $row ) {
					$editjob_data ['name'] = $row->name;
					$editjob_data ['powersocket'] = $row->powersocket;
				}
				
				$result = $this->user->getDataMysqlId ( 'cron', $id_cron );
				if ($result) {
					
					foreach ( $result as $row ) {
						$editjob_data ['id_cron'] = $id_cron;
						$editjob_data ['time_start'] = $row->time_start;
						$editjob_data ['time_stop'] = $row->time_stop;
					}
					$header_data = $this->Header_model->setHeaderData ();
					$header_data ['active'] = 'dashboard';
					
					$t1 = explode ( ":", $editjob_data ['time_start'] );
					$editjob_data ['hstart'] = $t1 [0];
					$editjob_data ['mstart'] = $t1 [1];
					
					$t2 = explode ( ":", $editjob_data ['time_stop'] );
					$editjob_data ['hstop'] = $t2 [0];
					$editjob_data ['mstop'] = $t2 [1];
					
					// $editjob_data ['id_cron'] = '3';
					// $editjob_data ['desc'] = '3';
					$editjob_data ['id_powersocket'] = $id_powersocket;
					
					$this->load->view ( 'header', $header_data );
					$this->load->view ( 'editjob', $editjob_data );
					$this->load->view ( 'footer' );
				} else {
					redirect ( '/scheduler/showpowersocket/' . $id_powersocket . '', 'refresh' );
				}
			} else {
				redirect ( '/scheduler/showpowersocket/' . $id_powersocket . '', 'refresh' );
			}
		} else {
			redirect ( 'login', 'refresh' );
		}
	}
	public function doSimpleEdit() {
		$this->load->helper ( 'html' );
		$this->load->helper ( 'url' );
		if (isset ( $_SESSION ['logged_in'] )) {
			$this->load->helper ( array (
					'form',
					'url' 
			) );
			
			$id_powersocket = $this->input->post ( 'id_powersocket' );
			$id_cron = $this->input->post ( 'id_cron' );
			$time_start = $this->input->post ( 'hstart' ) . ':' . $this->input->post ( 'mstart' );
			$time_stop = $this->input->post ( 'hstop' ) . ':' . $this->input->post ( 'mstop' );
			
			if ($time_start != $time_stop) {
				$this->db->query ( 'UPDATE cron SET time_start="' . $time_start . '", time_stop="' . $time_stop . '" WHERE id=' . $id_cron . '' );
				
				$s_start = $this->user->timeToSec ( $time_start );
				$s_stop = $this->user->timeToSec ( $time_stop );
				
				// echo $s_start;
				$this->db->query ( 'UPDATE cron SET time_start="' . $time_start . '", time_stop="' . $time_stop . '", s_start=' . $s_start . ', s_stop=' . $s_stop . ' WHERE id=' . $id_cron . '' );
				$this->session->set_userdata('apply_button', 'true');
				redirect ( '/scheduler/showpowersocket/' . $id_powersocket . '', 'refresh' );
			} else {
				redirect ( '/scheduler/newjob/' . $id_powersocket . '', 'refresh' );
			}
		} else {
			redirect ( 'login', 'refresh' );
		}
	}
	public function doSimpleEdit2() {
		$this->load->helper ( 'html' );
		$this->load->helper ( 'url' );
		if (isset ( $_SESSION ['logged_in'] )) {
			
			$this->load->library ( 'form_validation' );
			
			$this->form_validation->set_rules ( 'hstart', 'Hours in PowerON', 'trim|required' );
			$this->form_validation->set_rules ( 'mstart', 'Minutes in PowerON', 'trim|required' );
			$this->form_validation->set_rules ( 'hstop', 'Hours in PowerOFF', 'trim|required' );
			$this->form_validation->set_rules ( 'mstop', 'Minutes in PowerOFF', 'trim|required' );
			
			$this->form_validation->set_rules ( 'hstart', 'PowerON', 'callback_checkHstartHstop' );
			
			if ($this->form_validation->run () == FALSE) {
				
				$header_data = $this->Header_model->setHeaderData ();
				$header_data ['active'] = 'dashboard';
				
				$id_cron = $this->input->post ( 'id_cron' );
				$id_powersocket = $this->input->post ( 'id_powersocket' );
				
				$editjob_data ['id'] = $this->input->post ( 'id' );
				$editjob_data ['name'] = $this->input->post ( 'name' );
				$editjob_data ['powersocket'] = $id_powersocket;
				$editjob_data ['id_cron'] = $id_cron;
				
				$result = $this->user->getDataMysqlId ( 'powersocket', $id_powersocket );
				if ($result) {
					
					foreach ( $result as $row ) {
						$editjob_data ['name'] = $row->name;
						$editjob_data ['powersocket'] = $row->powersocket;
					}
					$result = $this->user->getDataMysqlId ( 'cron', $id_cron );
					if ($result) {
						
						foreach ( $result as $row ) {
							$editjob_data ['time_start'] = $row->time_start;
							$editjob_data ['time_stop'] = $row->time_stop;
						}
						
						$t1 = explode ( ":", $editjob_data ['time_start'] );
						$editjob_data ['hstart'] = $t1 [0];
						$editjob_data ['mstart'] = $t1 [1];
						
						$t2 = explode ( ":", $editjob_data ['time_stop'] );
						$editjob_data ['hstop'] = $t2 [0];
						$editjob_data ['mstop'] = $t2 [1];
						
						$editjob_data ['id_powersocket'] = $id_powersocket;
						
						$this->load->helper ( array (
								'form',
								'url' 
						) );
						
						$this->load->view ( 'header', $header_data );
						$this->load->view ( 'editjob', $editjob_data );
						$this->load->view ( 'footer' );
					}
				}
			} else {
				$id_powersocket = $this->input->post ( 'id' );
				$id_cron = $this->input->post ( 'id_cron' );
				$time_start = $this->input->post ( 'hstart' ) . ':' . $this->input->post ( 'mstart' );
				$time_stop = $this->input->post ( 'hstop' ) . ':' . $this->input->post ( 'mstop' );
				$s_start = $this->user->timeToSec ( $time_start );
				$s_stop = $this->user->timeToSec ( $time_stop );
				
				echo $s_start;
				// $this->db->query ( 'UPDATE cron SET time_start="' . $time_start . '", time_stop="' . $time_stop . '", s_start='.$s_start.', s_stop='.$s_stop.' WHERE id=' . $id_cron . '' );
				// redirect ( '/scheduler/showpowersocket/' . $id_powersocket . '', 'refresh' );
			}
		} else {
			redirect ( 'login', 'refresh' );
		}
	}
	public function changeSchedulerStatus($id_powersocket, $status) {
		$this->load->helper ( 'html' );
		$this->load->helper ( 'url' );
		if (isset ( $_SESSION ['logged_in'] )) {
			$this->load->helper ( array (
					'form',
					'url' 
			) );
			switch ($status) {
				case 0 :
					$this->db->query ( 'UPDATE powersocket SET scheduler_enabled="1" WHERE id=' . $id_powersocket . '' );
					break;
				case 1 :
					$this->db->query ( 'UPDATE powersocket SET scheduler_enabled="0" WHERE id=' . $id_powersocket . '' );
					break;
				default :
					redirect ( '/dashboard', 'refresh' );
			}
			$this->session->set_userdata('apply_button', 'true');
			redirect ( '/scheduler/showpowersocket/' . $id_powersocket, 'refresh' );
		} else {
			redirect ( 'login', 'refresh' );
		}
	}
	public function simlpeAdd() {
		$this->load->helper ( 'html' );
		$this->load->helper ( 'url' );
		if (isset ( $_SESSION ['logged_in'] )) {
			
			$this->load->library ( 'form_validation' );
			
			$this->form_validation->set_rules ( 'hstart', 'Hours in PowerON', 'trim|required' );
			$this->form_validation->set_rules ( 'mstart', 'Minutes in PowerON', 'trim|required' );
			$this->form_validation->set_rules ( 'hstop', 'Hours in PowerOFF', 'trim|required' );
			$this->form_validation->set_rules ( 'mstop', 'Minutes in PowerOFF', 'trim|required' );
			
			$this->form_validation->set_rules ( 'hstart', 'PowerON', 'callback_checkHstartHstop' );
			
			if ($this->form_validation->run () == FALSE) {
				$header_data = $this->Header_model->setHeaderData ();
				$header_data ['active'] = 'dashboard';
				
				$this->load->helper ( array (
						'form',
						'url' 
				) );
				$newjob_data ['id'] = $this->input->post ( 'id' );
				$newjob_data ['powersocket'] = $this->input->post ( 'powersocket' );
				$newjob_data ['name'] = $this->input->post ( 'name' );
				
				echo $this->input->post ( 'id' );
		
				$this->load->view ( 'header', $header_data );
				$this->load->view ( 'newjob', $newjob_data );
				$this->load->view ( 'footer' );
				
			} else {
				$id_powersocket = $this->input->post ( 'id' );
				$time_start = $this->input->post ( 'hstart' ) . ':' . $this->input->post ( 'mstart' );
				$time_stop = $this->input->post ( 'hstop' ) . ':' . $this->input->post ( 'mstop' );
				
				$s_start = $this->user->timeToSec ( $time_start.':00' );
				$s_stop = $this->user->timeToSec ( $time_stop.':00' );
				
				
				$this->user->simpleAddNewCron ( $time_start, $time_stop, $id_powersocket, $s_start, $s_stop );
				$this->session->set_userdata('apply_button', 'true');
				redirect ( '/scheduler/showpowersocket/' . $id_powersocket . '', 'refresh' );
			}
		} else {
			redirect ( 'login', 'refresh' );
		}
	}
	public function checkHstartHstop() {
		$time_start = $this->input->post ( 'hstart' ) . ':' . $this->input->post ( 'mstart' );
		$time_stop = $this->input->post ( 'hstop' ) . ':' . $this->input->post ( 'mstop' );
		if ($time_start != $time_stop) {
			if ($this->user->getTimesStartStopCron ( $time_start, $this->input->post ( 'id' ) )) {
				if ($this->user->getTimesStartStopCron ( $time_stop, $this->input->post ( 'id' ) )) {
					return true;
				} else {
					$this->form_validation->set_message ( 'checkHstartHstop', '<i class="fa fa-exclamation "></i> The hour and minute are already are used.' );
					return FALSE;
				}
			} else {
				$this->form_validation->set_message ( 'checkHstartHstop', '<i class="fa fa-exclamation "></i> The hour and minute are already are used.' );
				return FALSE;
			}
		} else {
			$this->form_validation->set_message ( 'checkHstartHstop', '<i class="fa fa-exclamation "></i> PowerON and PowerOFF cannot be the same.' );
			return FALSE;
		}
	}
	public function checkHstartHsto2() {
		$time_start = $this->input->post ( 'hstart' ) . ':' . $this->input->post ( 'mstart' );
		$time_stop = $this->input->post ( 'hstop' ) . ':' . $this->input->post ( 'mstop' );
		
		$s_start = $this->user->timeToSec ( $time_start.':00' );
		$s_stop = $this->user->timeToSec ( $time_stop.'00' );
				
		if ($time_start != $time_stop) {
			$result = $this->user->getCronStartStop ( $this->input->post ( 'id' ) );
			if ($result) {
				$check = false;
				print_r($result);
				foreach ( $result as $row ) {
					echo $row->s_start.' ';
					if ((($row->s_start <= $s_start) and ($row->s_stop >= $s_start)) or (($row->s_start <= $s_stop) and ($row->s_stop >= $s_stop))) {
						
						$check = true;
						break;
					}
					if (($row->s_start >= $s_start) and ($row->s_stop <= $s_stop)) {
					
						$check = true;
						break;
					}
				}
				if ($check == true) {
					$this->form_validation->set_message ( 'checkHstartHstop', '<i class="fa fa-exclamation "></i> Selected time range is used.' );
					return false;
				} else {
					return true;
				}
			} else {
				return true;
			}
			return true;
		} else {
			$this->form_validation->set_message ( 'checkHstartHstop', '<i class="fa fa-exclamation "></i> PowerON and PowerOFF cannot be the same.' );
			return FALSE;
		}
	}
	public function deleteEntryScheduler($id, $id_powersocket) {
		$this->load->helper ( 'html' );
		$this->load->helper ( 'url' );
		if (isset ( $_SESSION ['logged_in'] )) {
			;
			$this->user->deleteFromCron ( $id );
			$this->session->set_userdata('apply_button', 'true');
			redirect ( '/scheduler/showpowersocket/' . $id_powersocket . '', 'refresh' );
		} else {
			redirect ( 'login', 'refresh' );
		}
	}
	public function newjob($id) {
		$this->load->helper ( 'html' );
		$this->load->helper ( 'url' );
		
		if (isset ( $_SESSION ['logged_in'] )) {
			$this->load->helper ( array (
					'form',
					'url' 
			) );
			// $result = $this->user->getPowersocket ( $id );
			$result = $this->user->getDataMysqlId ( 'powersocket', $id );
			
			if ($result) {
				foreach ( $result as $row ) {
					$newjob_data ['powersocket'] = $row->powersocket;
					$newjob_data ['name'] = $row->name;
				}
				
				$newjob_data ['id'] = $id;
				
				$header_data = $this->Header_model->setHeaderData ();
				$this->load->view ( 'header', $header_data );
				$this->load->view ( 'newjob', $newjob_data );
				$this->load->view ( 'footer' );
			} else {
				redirect ( 'dashboard', 'refresh' );
			}
		} else {
			redirect ( 'login', 'refresh' );
		}
	}
	public function showpowersocket($id) {
		$this->load->helper ( 'html' );
		$this->load->helper ( 'url' );
		
		$header_data = $this->Header_model->setHeaderData ();
		$header_data ['active'] = 'dashboard';
		
		$result = $this->user->getDataMysqlId ( 'powersocket', $id );
		
		if ($result) {
			foreach ( $result as $row ) {
				$scheduler_data ['powersocket'] = $row->powersocket;
				$scheduler_data ['name'] = $row->name;
				$scheduler_data ['scheduler_enabled'] = $row->scheduler_enabled;
			}
			if ($scheduler_data ['scheduler_enabled'] == 0) {
				$scheduler_data ['status'] = "inactive";
				$scheduler_data ['b_status'] = "Activate";
			} else {
				$scheduler_data ['status'] = "active";
				$scheduler_data ['b_status'] = "Deactivate";
			}
			
			$scheduler_data ['id'] = $id;
			
			$scheduler_data ['tr'] = '';
			
			$query = $this->db->query ( 'SELECT * FROM cron WHERE id_powersocket=' . $id . '' );
			
			$i = 1;
			foreach ( $query->result () as $row ) {
				$poweronTimeInSec=$this->user->poweronTimeInSec($row->s_start,$row->s_stop);
				$scheduler_data ['tr'] = $scheduler_data ['tr'] . '
			<tr>
				<td>' . $i ++ . '</td>
				<td>' . $row->time_start . '</td>
				<td>' . $row->time_stop . '</td>
				<!--<td>' . $row->crontab . '</td>-->
				<!--<td>' . $row->description . '</td>-->
						<td>'.$poweronTimeInSec.'</td>
				<td>' . $row->datecreate . '</td>
				<td>
						<form style="display:inline;" action="/scheduler/showSimpleEdit/' . $row->id . '/' . $id . '" method="post"><button class="btn btn-primary"><i class="fa fa-edit "></i> Edit</button> </form>
						<form style="display:inline;" action="/scheduler/deleteEntryScheduler/' . $row->id . '/' . $id . '" method="post"><button class="btn btn-danger"><i class="fa fa-times"></i> Delete</button></form>
				</td>
			</tr>';
			}
			
			$this->load->view ( 'header', $header_data );
			$this->load->view ( 'scheduler', $scheduler_data );
			$this->load->view ( 'footer' );
		} else {
			redirect ( 'dashboard', 'refresh' );
		}
	}
}

