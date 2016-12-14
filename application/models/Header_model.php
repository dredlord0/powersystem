<?php
Class Header_model extends CI_Model
{
	function setHeaderData(){
		$header_data['apply_button']='';
		if (isset ( $_SESSION ['logged_in'] )) {
			$button = 'LOGOUT';
			$button_href = '/logout';
			if (isset ( $_SESSION ['apply_button'] )) {
				$header_data['apply_button']='&nbsp;<a href="/apply" class="btn btn-warning square-btn-adjust">APPLY CHANGES</a>';
			} else {
				$header_data['apply_button']='&nbsp;<a href="/apply" class="btn btn-info square-btn-adjust">RE-APPLY CHANGES</a>';
			}
		} else {
			$button = 'LOGIN';
			$button_href = '/login';
		}
		
		
		$header_data ['active'] = '';
		$header_data ['button'] = $button;
		$header_data ['button_href'] = $button_href;
		$header_data ['title'] = 'PowerSystem';
		
		return $header_data;
	}
}
?>