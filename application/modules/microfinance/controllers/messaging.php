<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once "./application/modules/microfinance/controllers/microfinance.php";

class Messaging extends microfinance 
{
	
	function __construct()
	{
		parent:: __construct();
		$this->load->model('messaging_model');
		$this->load->model('individual_model');
		$this->load->model('admin/admin_model');
	}

	public function send_statement($individual_id)
	{
		if($this->messaging_model->send_statement($individual_id))
		{
			$this->session->set_userdata("success_message", "Statement was sent successfully");
		}
		else
		{
			$this->session->set_userdata("error_message", "Opps!! Something went wrong. Please try again");
		}
		redirect('microfinance/individual');
	}
}