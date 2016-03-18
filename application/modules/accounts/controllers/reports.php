<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once "./application/modules/accounts/controllers/accounts.php";

class Reports extends accounts 
{
	function __construct()
	{
		$this->load->model('reports_model');
		parent:: __construct();
	}
	
	public function profit_and_loss()
	{
		$data['title'] = 'Profit & loss';
		$v_data['title'] = $data['title'];
		$v_data['interests'] = $this->reports_model->get_loan_payments();
		$v_data['expenses'] = $this->reports_model->get_expenses();
		$v_data['contacts'] = $this->site_model->get_contacts();
		$v_data['parent_sections'] = $this->sections_model->all_parent_sections('section_position');
		$this->load->view('reports/profit_and_loss', $v_data);
	}
}
?>