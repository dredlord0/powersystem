<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Configuration extends CI_Controller {
	function __construct() {
		parent::__construct ();
		$this->load->model ( 'Header_model' );
		$this->load->model ( 'user', '', TRUE );
		$this->config->load ( 'custom' );
	}
	public function showNewPowerSocket() {
		$this->load->helper ( 'html' );
		$this->load->helper ( 'url' );
		if (isset ( $_SESSION ['logged_in'] )) {
			$header_data = $this->Header_model->setHeaderData ();
			$header_data ['active'] = 'configuration';
			
			$this->load->helper ( array (
					'form',
					'url' 
			) );
			
			$a_free_gpio = $this->user->checkFreeGpio ( '1', $this->config->item ( 'max_gpio' ) );
			$option_gpio = '';
			foreach ( $a_free_gpio as $row ) {
				$option_gpio = $option_gpio . ' <option>' . $row . '</option>';
			}
			$showNewGpio_data ['option_gpio'] = $option_gpio;
			
			$a_free_powersocket = $this->user->checkFreePowerSocket ( '1', $this->config->item ( 'max_powersocket' ) );
			$option_powersocket = '';
			foreach ( $a_free_powersocket as $row ) {
				$option_powersocket = $option_powersocket . ' <option>' . $row . '</option>';
			}
			$showNewGpio_data ['option_powersocket'] = $option_powersocket;
			
			$this->load->view ( 'header', $header_data );
			$this->load->view ( 'showNewPowerSocket', $showNewGpio_data );
			$this->load->view ( 'footer' );
		} else {
			redirect ( 'login', 'refresh' );
		}
	}
	public function showEditPowerSocket($id_powersocket) {
		$this->load->helper ( 'html' );
		$this->load->helper ( 'url' );
		if (isset ( $_SESSION ['logged_in'] )) {
			
			$header_data = $this->Header_model->setHeaderData ();
			$header_data ['active'] = 'configuration';
			
			$this->load->helper ( array (
					'form',
					'url'
			) );
			
			$query = $this->db->query ( 'SELECT g.*, p.powersocket,p.name,p.id as idpowersocket FROM gpio as g, powersocket as p WHERE p.id=g.id_powersocket AND p.id=' . $id_powersocket . '' );
			
			$row = $query->row ();
			
			if (isset ( $row )) {
				
				foreach ( $query->result () as $row ) {
					$gpio = $row->gpio;
					$powersocket = $row->powersocket;
					$showEditPowerSocket_data['desc']=$row->description;
					$showEditPowerSocket_data['name_dev']=$row->name;
					$showEditPowerSocket_data['id_gpio']=$row->id;
					$showEditPowerSocket_data['id_powersocket']=$row->idpowersocket;
				}
				
				$a_free_gpio = $this->user->checkFreeGpio ( '1', $this->config->item ( 'max_gpio' ) );
				$option_gpio ='<option selected>' . $gpio . '</option>';
				foreach ( $a_free_gpio as $row ) {
						$option_gpio = $option_gpio . ' <option>' . $row . '</option>';
				}

				$showEditPowerSocket_data ['option_gpio'] = $option_gpio;
				
				$a_free_powersocket = $this->user->checkFreePowerSocket ( '1', $this->config->item ( 'max_powersocket' ) );
				$option_powersocket = '<option selected>' . $powersocket . '</option>';
				foreach ( $a_free_powersocket as $row ) {
						$option_powersocket = $option_powersocket . ' <option>' . $row . '</option>';
				}
				$showEditPowerSocket_data ['option_powersocket'] = $option_powersocket;
				
				
				$this->load->view ( 'header', $header_data );
				$this->load->view ( 'showEditPowerSocket', $showEditPowerSocket_data );
				$this->load->view ( 'footer' );
			} else {
				redirect ( 'configuration/showConfPowerSocket', 'refresh' );
			}
		} else {
			redirect ( 'login', 'refresh' );
		}
	}
	public function verifyEditGpio() {
		$this->load->helper ( 'html' );
		$this->load->helper ( 'url' );
		if (isset ( $_SESSION ['logged_in'] )) {
			$header_data = $this->Header_model->setHeaderData ();
			$header_data ['active'] = 'configuration';
				
			$this->load->library ( 'form_validation' );
				
			$this->form_validation->set_rules ( 'gpio', 'Gpio', 'trim|required' );
			$this->form_validation->set_rules ( 'powersocket', 'Powersocket', 'trim|required' );
			$this->form_validation->set_rules ( 'name_dev', 'Device name', 'trim|required' );
			$this->form_validation->set_rules ( 'desc', 'desc', 'trim' );
			if ($this->form_validation->run () == FALSE) {
				$header_data = $this->Header_model->setHeaderData ();
				$header_data ['active'] = 'configuration';
	
				$this->load->helper ( array (
						'form',
						'url'
				) );
	
				$a_free_gpio = $this->user->checkFreeGpio ( '1', $this->config->item ( 'max_gpio' ) );
				$option_gpio = '';
				foreach ( $a_free_gpio as $row ) {
					$option_gpio = $option_gpio . ' <option>' . $row . '</option>';
				}
				$showEditGpio_data ['option_gpio'] = $option_gpio;
	
				$a_free_powersocket = $this->user->checkFreePowerSocket ( '1', $this->config->item ( 'max_powersocket' ) );
				$option_powersocket = '';
				foreach ( $a_free_powersocket as $row ) {
					$option_powersocket = $option_powersocket . ' <option>' . $row . '</option>';
				}
				$showEditGpio_data ['option_powersocket'] = $option_powersocket;
				
				$showEditGpio_data ['name_dev'] = $this->input->post('name_dev');
				$showEditGpio_data ['desc'] = $this->input->post('desc');
	
				$this->load->view ( 'header', $header_data );
				$this->load->view ( 'showEditPowerSocket', $showEditGpio_data );
				$this->load->view ( 'footer' );
			} else {
				
				$id_powersocket = $this->input->post ( 'id_powersocket' );
				$id_gpio = $this->input->post ( 'id_gpio' );
				$powersocket = $this->input->post ( 'powersocket' );
				$name_dev = $this->input->post ( 'name_dev' );
				$gpio = $this->input->post ( 'gpio' );
				$desc = $this->input->post ( 'desc' );
				
				//echo $id_powersocket.' '.$id_gpio;
				
				$this->db->query ( 'UPDATE gpio SET gpio="'.$gpio.'", description="'.$desc.'"  WHERE id=' . $id_gpio . '' );
				$this->db->query ( 'UPDATE powersocket SET powersocket="'.$powersocket.'", name="'.$name_dev.'" WHERE id=' . $id_powersocket . '' );
				$this->session->set_userdata('apply_button', 'true');
				redirect ( 'configuration/showConfPowerSocket', 'refresh' );

			}
		} else {
			redirect ( 'login', 'refresh' );
		}
	}
	
	
	public function showConfPowerSocket() {
		$this->load->helper ( 'html' );
		$this->load->helper ( 'url' );
		if (isset ( $_SESSION ['logged_in'] )) {
			
			$header_data = $this->Header_model->setHeaderData ();
			$header_data ['active'] = 'configuration';
			
			$showConfPowerSocket_data ['tr'] = '';
			
			$query = $this->db->query ( 'SELECT g.*, p.powersocket,p.name,p.id as idpowersocket FROM gpio as g, powersocket as p WHERE p.id=g.id_powersocket ORDER BY g.gpio ASC' );
			
			$i = 1;
			foreach ( $query->result () as $row ) {
			if ($row->status==0) {
				$status[0]='inactive';
				$status[1]='Activate';
			} else {
				$status[0]='active';
				$status[1]='Deactivate';
			}
				$showConfPowerSocket_data ['tr'] = $showConfPowerSocket_data ['tr'] . '
			<tr>
				<td>' . $i ++ . '</td>
				<td>' . $row->gpio . '</td>
				<td>' . $row->powersocket . '</td>
				<td>' . $status[0] . '</td>
				<td>' . $row->name . '</td>
				<td>' . $row->description . '</td>
				<td>
						<form style="display:inline;" action="/configuration/showEditPowerSocket/' . $row->idpowersocket . '" method="post"><button class="btn btn-primary"><i class="fa fa-edit "></i> Edit</button> </form>
						<form style="display:inline;" action="/configuration/deletePowerSokcet/' . $row->idpowersocket . '" method="post"><button class="btn btn-danger"><i class="fa fa-times"></i> Delete</button></form>
						<form style="display:inline;" action="/configuration/setStatusGpio/' . $row->id . '/'.$row->status.'" method="post"><button class="btn btn-warning"><i class="fa fa-cog"></i> '.$status[1].'</button></form>
				</td>
			</tr>';
			}
			
			$this->load->view ( 'header', $header_data );
			$this->load->view ( 'showConfPowerSocket', $showConfPowerSocket_data );
			$this->load->view ( 'footer' );
		} else {
			redirect ( 'login', 'refresh' );
		}
	}
	public function verifyNewGpio() {
		$this->load->helper ( 'html' );
		$this->load->helper ( 'url' );
		if (isset ( $_SESSION ['logged_in'] )) {
			$header_data = $this->Header_model->setHeaderData ();
			$header_data ['active'] = 'configuration';
			
			$this->load->library ( 'form_validation' );
			
			$this->form_validation->set_rules ( 'gpio', 'Gpio', 'trim|required|callback_check_gpio' );
			$this->form_validation->set_rules ( 'powersocket', 'Powersocket', 'trim|required|callback_check_powersocket' );
			$this->form_validation->set_rules ( 'name_dev', 'Device name', 'trim|required' );
			$this->form_validation->set_rules ( 'desc', 'desc', 'trim' );
			if ($this->form_validation->run () == FALSE) {
				$header_data = $this->Header_model->setHeaderData ();
				$header_data ['active'] = 'configuration';
				
				$this->load->helper ( array (
						'form',
						'url' 
				) );
				
				$a_free_gpio = $this->user->checkFreeGpio ( '1', $this->config->item ( 'max_gpio' ) );
				$option_gpio = '';
				foreach ( $a_free_gpio as $row ) {
					$option_gpio = $option_gpio . ' <option>' . $row . '</option>';
				}
				$showNewGpio_data ['option_gpio'] = $option_gpio;
				
				$a_free_powersocket = $this->user->checkFreePowerSocket ( '1', $this->config->item ( 'max_powersocket' ) );
				$option_powersocket = '';
				foreach ( $a_free_powersocket as $row ) {
					$option_powersocket = $option_powersocket . ' <option>' . $row . '</option>';
				}
				$showNewGpio_data ['option_powersocket'] = $option_powersocket;
				
				$this->load->view ( 'header', $header_data );
				$this->load->view ( 'showNewPowerSocket', $showNewGpio_data );
				$this->load->view ( 'footer' );
			} else {
				$powersocket = $this->input->post ( 'powersocket' );
				$name_dev = $this->input->post ( 'name_dev' );
				$gpio = $this->input->post ( 'gpio' );
				$desc = $this->input->post ( 'desc' );
				
				$id_powersocket = $this->user->addNewPowerSocket ( $powersocket, $name_dev );
				$this->user->addNewGpioPowerSocket ( $id_powersocket, $gpio, $desc );
				redirect ( 'configuration/showConfPowerSocket', 'refresh' );
			}
		} else {
			redirect ( 'login', 'refresh' );
		}
	}
	public function check_gpio($gpio) {
		$a = $this->user->checkFreeGpio ( '0', $this->config->item ( 'max_gpio' ) );
		if (array_search ( $gpio, $a ) == true) {
			return TRUE;
		} else {
			$this->form_validation->set_message ( 'check_gpio', '<i class="fa fa-exclamation "></i> gpio already selected or invalid' );
			return FALSE;
		}
	}
	public function check_powersocket($powersocket) {
		$a = $this->user->checkFreePowerSocket ( '0', $this->config->item ( 'max_powersocket' ) );
		if (array_search ( $powersocket, $a )) {
			return TRUE;
		} else {
			$this->form_validation->set_message ( 'check_powersocket', '<i class="fa fa-exclamation "></i> power socket already selected or invalid' );
			return FALSE;
		}
	}
	public function deletePowerSokcet($id) {
		$this->load->helper ( 'html' );
		$this->load->helper ( 'url' );
		if (isset ( $_SESSION ['logged_in'] )) {
			$this->user->deletePowerSocket ( $id );
			$this->session->set_userdata('apply_button', 'true');
			redirect ( 'configuration/showConfPowerSocket', 'refresh' );
		} else {
			redirect ( 'login', 'refresh' );
		}
	}
	public function setStatusGpio($id_gpio, $status) {
		$this->load->helper ( 'html' );
		$this->load->helper ( 'url' );
		if (isset ( $_SESSION ['logged_in'] )) {
			$this->load->helper ( array (
					'form',
					'url'
			) );
			switch ($status) {
				case 0 :
					$this->db->query ( 'UPDATE gpio SET status="1" WHERE id=' . $id_gpio . '' );
					break;
				case 1 :
					$this->db->query ( 'UPDATE gpio SET status="0" WHERE id=' . $id_gpio . '' );
					break;
				default :
					redirect ( 'configuration/showConfPowerSocket', 'refresh' );
			}
			$this->session->set_userdata('apply_button', 'true');
			redirect ( 'configuration/showConfPowerSocket', 'refresh' );
		} else {
			redirect ( 'login', 'refresh' );
		}
	}
}

