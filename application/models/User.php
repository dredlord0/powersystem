<?php
class User extends CI_Model {
	function login($username, $password) {
		$this->db->select ( 'id, username, password' );
		$this->db->from ( 'users' );
		$this->db->where ( 'username = ' . "'" . $username . "'" );
		$this->db->where ( 'password = ' . "'" . MD5 ( $password ) . "'" );
		$this->db->limit ( 1 );
		
		$query = $this->db->get ();
		
		if ($query->num_rows () == 1) {
			return $query->result ();
		} else {
			return false;
		}
	}
	function simpleAddNewCron($start, $stop, $id, $s_start, $s_stop) {
		$data = array (
				'id_powersocket' => $id,
				'time_start' => $start,
				'time_stop' => $stop,
				's_start' => $s_start,
				's_stop' => $s_stop,
				'crontab' => '' 
		);
		$this->db->insert ( 'cron', $data );
	}
	function simpleAddNewCrontab($id_cron, $command) {
		$data = array (
				'id_cron' => $id_cron,
				'command' => $command 
		);
		$this->db->insert ( 'crontab', $data );
	}
	function simpleUpdateCron($start, $stop, $id_cron, $id_powersocket) {
		$data = array (
				'id' => $id_cron,
				'id_powersocket' => $id_powersocket,
				'time_start' => $start,
				'time_stop' => $stop,
				'crontab' => '' 
		);
		$this->db->replace ( 'cron', $data );
	}
	function deleteFromCron($id) {
		$this->db->delete ( 'cron', array (
				'id' => $id 
		) );
	}
	function getDataMysqlId($table, $id) {
		$this->db->select ( '*' );
		$this->db->from ( $table );
		$this->db->where ( 'id = ' . "'" . $id . "'" );
		// $this->db->order_by("id", "desc");
		$query = $this->db->get ();
		
		if ($query->num_rows () == 1) {
			return $query->result ();
		} else {
			return false;
		}
	}
	function getTimesStartStopCron($time, $id_powersocket) {
		$this->db->select ( '*' );
		$this->db->from ( 'cron' );
		$this->db->where ( 'id_powersocket=' . $id_powersocket . ' AND (time_start = "' . $time . '"  OR time_stop ="' . $time . '")' );
		$query = $this->db->get ();
		
		if ($query->num_rows () == 0) {
			return true;
		} else {
			return false;
		}
	}
	function checkFreeGpio($x, $y) {
		$this->db->select ( 'gpio' );
		$this->db->from ( 'gpio' );
		$query = $this->db->get ();
		$a_gpio = range ( $x, $y );
		if ($query->num_rows () > 0) {
			foreach ( $query->result () as $row ) {
				if (($key = array_search ( $row->gpio, $a_gpio )) !== false) {
					unset ( $a_gpio [$key] );
				}
			}
			return $a_gpio;
		} else {
			return $a_gpio;
		}
	}
	function checkFreePowerSocket($x, $y) {
		$this->db->select ( 'powersocket' );
		$this->db->from ( 'powersocket' );
		$query = $this->db->get ();
		$a_powersocket = range ( $x, $y );
		if ($query->num_rows () > 0) {
			foreach ( $query->result () as $row ) {
				if (($key = array_search ( $row->powersocket, $a_powersocket )) !== false) {
					unset ( $a_powersocket [$key] );
				}
			}
			return $a_powersocket;
		} else {
			return $a_powersocket;
		}
	}
	function addNewPowerSocket($powersocket, $name_dev) {
		$data = array (
				'id' => null,
				'powersocket' => $powersocket,
				'name' => $name_dev,
				'scheduler_enabled ' => 0 
		);
		$this->db->insert ( 'powersocket', $data );
		$this->db->trans_complete ();
		return $this->db->insert_id ();
	}
	function addNewGpioPowerSocket($id_powersocket, $gpio, $desc) {
		$data = array (
				'id' => null,
				'id_powersocket' => $id_powersocket,
				'gpio' => $gpio,
				'description ' => $desc 
		);
		$this->db->insert ( 'gpio', $data );
	}
	function deletePowerSocket($id) {
		$this->db->delete ( 'powersocket', array (
				'id' => $id 
		) );
	}
	function timeToSec($time) {
		sscanf ( $time, "%d:%d:%d", $hours, $minutes, $seconds );
		return isset ( $seconds ) ? $hours * 3600 + $minutes * 60 + $seconds : $hours * 60 + $minutes;
	}
	function getCronStartStop($id_powersocket) {
		$this->db->select ( 's_start, s_stop' );
		$this->db->from ( 'cron' );
		$this->db->where ( 'id_powersocket=' . $id_powersocket . '' );
		$query = $this->db->get ();
		if ($query->num_rows () > 0) {
			return $query->result ();
		} else {
			return false;
		}
	}
	function poweronTimeInSec($start,$stop) {
		if ($start>$stop){
			return gmdate('H:i:s',86400-$start-$stop);
		} else {
			return gmdate('H:i:s',$stop-$start);
		}
	}
	
}
?>