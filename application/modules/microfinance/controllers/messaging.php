<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once "./application/modules/microfinance/controllers/microfinance.php";

class Messaging extends microfinance 
{
	
	function __construct()
	{
		parent:: __construct();
		$this->load->model('reports_model');
		$this->load->model('messaging_model');
		$this->load->model('individual_model');
		$this->load->model('admin/admin_model');
	}

	public function send_statement($individual_id)
	{
		$response = $this->messaging_model->send_statement($individual_id);
		$this->session->set_userdata("success_message", $response);
		/*if()
		{
			
		}
		else
		{
			$this->session->set_userdata("error_message", "Opps!! Something went wrong. Please try again");
		}*/
		redirect('microfinance/individual');
	}

	public function send_bulk_statements()
	{
		$query = $this->db->get('individual');
		$total_sent = 0;
		if($query->num_rows() > 0)
		{
			foreach($query->result() as $res)
			{
				$individual_id = $res->individual_id;
				$response = $this->messaging_model->send_statement($individual_id);
				if($response != 'Member phone number not found')
				{
					$total_sent++;
				}
			}
		}
		$this->session->set_userdata("success_message", $total_sent.'/'.$query->num_rows().' messages sent' );
		redirect('microfinance/individual');
	}
}