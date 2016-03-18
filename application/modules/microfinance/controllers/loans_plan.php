<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once "./application/modules/microfinance/controllers/microfinance.php";

class Loans_plan extends microfinance 
{
	function __construct()
	{
		parent:: __construct();
	}
    
	/*
	*
	*	Default action is to show all the loans_plan
	*
	*/
	public function index($order = 'loans_plan_name', $order_method = 'ASC') 
	{
		$where = 'loans_plan.installment_type_id = installment_type.installment_type_id AND loans_plan.interest_id = interest.interest_id';
		$table = 'loans_plan, installment_type, interest';
		//pagination
		$segment = 5;
		$this->load->library('pagination');
		$config['base_url'] = site_url().'microfinance/'.$order.'/'.$order_method;
		$config['total_rows'] = $this->loans_plan_model->count_items($table, $where);
		$config['uri_segment'] = $segment;
		$config['per_page'] = 20;
		$config['num_links'] = 5;
		
		$config['full_tag_open'] = '<ul class="pagination pull-right">';
		$config['full_tag_close'] = '</ul>';
		
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		
		$config['next_tag_open'] = '<li>';
		$config['next_link'] = 'Next';
		$config['next_tag_close'] = '</span>';
		
		$config['prev_tag_open'] = '<li>';
		$config['prev_link'] = 'Prev';
		$config['prev_tag_close'] = '</li>';
		
		$config['cur_tag_open'] = '<li class="active">';
		$config['cur_tag_close'] = '</li>';
		
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$this->pagination->initialize($config);
		
		$page = ($this->uri->segment($segment)) ? $this->uri->segment($segment) : 0;
        $data["links"] = $this->pagination->create_links();
		$query = $this->loans_plan_model->get_all_loans_plan($table, $where, $config["per_page"], $page, $order, $order_method);
		
		//change of order method 
		if($order_method == 'DESC')
		{
			$order_method = 'ASC';
		}
		
		else
		{
			$order_method = 'DESC';
		}
		
		$data['title'] = 'Loan plan';
		$v_data['title'] = $data['title'];
		
		$v_data['order'] = $order;
		$v_data['order_method'] = $order_method;
		$v_data['query'] = $query;
		$v_data['page'] = $page;
		$data['content'] = $this->load->view('loans_plan/all_loans_plan', $v_data, true);
		
		$this->load->view('admin/templates/general_page', $data);
	}
    
	/*
	*
	*	Add a new loans_plan
	*
	*/
	public function add_loans_plan() 
	{
		//form validation rules
		$this->form_validation->set_rules('interest_id', 'Interest type', 'required|xss_clean');
		$this->form_validation->set_rules('interest_rate', 'Interest rate', 'required|xss_clean');
		$this->form_validation->set_rules('loans_plan_name', 'Name', 'required|xss_clean');
		$this->form_validation->set_rules('installment_type_id', 'Installment type', 'required|xss_clean');
		$this->form_validation->set_rules('grace_period_minimum', 'Minimum grace period', 'numeric|xss_clean');
		$this->form_validation->set_rules('grace_period_maximum', 'Maximum grace period', 'numeric|xss_clean');
		$this->form_validation->set_rules('grace_period_default', 'Default grace period', 'numeric|xss_clean');
		$this->form_validation->set_rules('charge_interest_over_grace_period', 'Charge interest over grace period', 'xss_clean');
		$this->form_validation->set_rules('maximum_loan_amount', 'Maximum loan amount', 'numeric|xss_clean');
		$this->form_validation->set_rules('minimum_loan_amount', 'Minimum loan amount', 'numeric|xss_clean');
		$this->form_validation->set_rules('custom_loan_amount', 'Custom loan amount', 'numeric|xss_clean');
		$this->form_validation->set_rules('maximum_number_of_installments', 'Maximum number of installments', 'numeric|xss_clean');
		$this->form_validation->set_rules('minimum_number_of_installments', 'Minimum number of installments', 'numeric|xss_clean');
		$this->form_validation->set_rules('custom_number_of_installments', 'Custom number of installments', 'numeric|xss_clean');
		$this->form_validation->set_rules('minimum_late_fee_on_total_loan', 'Minimum late fee on total loan', 'numeric|xss_clean');
		$this->form_validation->set_rules('maximum_late_fee_on_total_loan', 'Maximum late fee on total loan', 'numeric|xss_clean');
		$this->form_validation->set_rules('custom_late_fee_on_total_loan', 'Custom late fee on total loan', 'numeric|xss_clean');
		$this->form_validation->set_rules('minimum_late_fee_on_overdue_principal', 'Minimum late fee on overdue principal', 'numeric|xss_clean');
		$this->form_validation->set_rules('maximum_late_fee_on_overdue_principal', 'Maximum late fee on overdue principal', 'numeric|xss_clean');
		$this->form_validation->set_rules('custom_late_fee_on_overdue_principal', 'Custom late fee on overdue principal', 'numeric|xss_clean');
		$this->form_validation->set_rules('minimum_late_fee_on_overdue_interest', 'Minimum late fee on overdue interest', 'numeric|xss_clean');
		$this->form_validation->set_rules('maximum_late_fee_on_overdue_interest', 'Maximum late fee on overdue interest', 'numeric|xss_clean');
		$this->form_validation->set_rules('custom_late_fee_on_overdue_interest', 'Custom late fee on overdue interest', 'numeric|xss_clean');
		$this->form_validation->set_rules('maximum_number_of_guarantors', 'Maximum number of guarantors', 'numeric|xss_clean');
		$this->form_validation->set_rules('minimum_number_of_guarantors', 'Minimum_ number of guarantors', 'numeric|xss_clean');
		$this->form_validation->set_rules('custom_number_of_guarantors', 'Custom number of guarantors', 'numeric|xss_clean');
		 
		//if form conatins invalid data
		if ($this->form_validation->run())
		{
			$loans_plan_id = $this->loans_plan_model->add_loans_plan();
			if($loans_plan_id != FALSE)
			{
				$this->session->set_userdata("success_message", "Loan plan added successfully");
				redirect('microfinance/loans');
			}
			
			else
			{
				$this->session->set_userdata("error_message","Could not add loan plan. Please try again");
			}
		}
		
		$v_data['interest_scheme'] = $this->loans_plan_model->get_interest_scheme();
		$v_data['installments'] = $this->loans_plan_model->get_installment_types();
		$data['title'] = 'Add loans plan';
		$v_data['title'] = $data['title'];
		$data['content'] = $this->load->view('loans_plan/add_loans_plan', $v_data, true);
		// print_r($v_data['interest_scheme']);
		$this->load->view('admin/templates/general_page', $data);
	}
    
	/*
	*
	*	Edit an existing loans_plan
	*	@param int $loans_plan_id
	*
	*/
	public function edit_loans_plan($loans_plan_id) 
	{	
		//form validation rules
		$this->form_validation->set_rules('interest_id', 'Interest type', 'required|xss_clean');
		$this->form_validation->set_rules('interest_rate', 'Interest rate', 'required|xss_clean');
		$this->form_validation->set_rules('loans_plan_name', 'Name', 'required|xss_clean');
		$this->form_validation->set_rules('installment_type_id', 'Installment type', 'required|xss_clean');
		$this->form_validation->set_rules('grace_period_minimum', 'Minimum grace period', 'numeric|xss_clean');
		$this->form_validation->set_rules('grace_period_maximum', 'Maximum grace period', 'numeric|xss_clean');
		$this->form_validation->set_rules('grace_period_default', 'Default grace period', 'numeric|xss_clean');
		$this->form_validation->set_rules('charge_interest_over_grace_period', 'Charge interest over grace period', 'xss_clean');
		$this->form_validation->set_rules('maximum_loan_amount', 'Maximum loan amount', 'numeric|xss_clean');
		$this->form_validation->set_rules('minimum_loan_amount', 'Minimum loan amount', 'numeric|xss_clean');
		$this->form_validation->set_rules('custom_loan_amount', 'Custom loan amount', 'numeric|xss_clean');
		$this->form_validation->set_rules('maximum_number_of_installments', 'Maximum number of installments', 'numeric|xss_clean');
		$this->form_validation->set_rules('minimum_number_of_installments', 'Minimum number of installments', 'numeric|xss_clean');
		$this->form_validation->set_rules('custom_number_of_installments', 'Custom number of installments', 'numeric|xss_clean');
		$this->form_validation->set_rules('minimum_late_fee_on_total_loan', 'Minimum late fee on total loan', 'numeric|xss_clean');
		$this->form_validation->set_rules('maximum_late_fee_on_total_loan', 'Maximum late fee on total loan', 'numeric|xss_clean');
		$this->form_validation->set_rules('custom_late_fee_on_total_loan', 'Custom late fee on total loan', 'numeric|xss_clean');
		$this->form_validation->set_rules('minimum_late_fee_on_overdue_principal', 'Minimum late fee on overdue principal', 'numeric|xss_clean');
		$this->form_validation->set_rules('maximum_late_fee_on_overdue_principal', 'Maximum late fee on overdue principal', 'numeric|xss_clean');
		$this->form_validation->set_rules('custom_late_fee_on_overdue_principal', 'Custom late fee on overdue principal', 'numeric|xss_clean');
		$this->form_validation->set_rules('minimum_late_fee_on_overdue_interest', 'Minimum late fee on overdue interest', 'numeric|xss_clean');
		$this->form_validation->set_rules('maximum_late_fee_on_overdue_interest', 'Maximum late fee on overdue interest', 'numeric|xss_clean');
		$this->form_validation->set_rules('custom_late_fee_on_overdue_interest', 'Custom late fee on overdue interest', 'numeric|xss_clean');
		$this->form_validation->set_rules('maximum_number_of_guarantors', 'Maximum number of guarantors', 'numeric|xss_clean');
		$this->form_validation->set_rules('minimum_number_of_guarantors', 'Minimum_ number of guarantors', 'numeric|xss_clean');
		$this->form_validation->set_rules('custom_number_of_guarantors', 'Custom number of guarantors', 'numeric|xss_clean');
		
		//if form conatins invalid data
		if ($this->form_validation->run())
		{
			//update loans_plan
			if($this->loans_plan_model->edit_loans_plan($loans_plan_id))
			{
				$this->session->set_userdata('success_message', 'Loan plan updated successfully');
				redirect('microfinance/loans_plan');
			}
			
			else
			{
				$this->session->set_userdata('error_message', 'Could not update loan plan. Please try again');
			}
		}
		
		//open the add new loans_plan
		$data['title'] = 'Edit loans plan';
		$v_data['title'] = $data['title'];
		
		$v_data['loans_plan_id'] = $loans_plan_id;
		$v_data['interest_scheme'] = $this->loans_plan_model->get_interest_scheme();
		$v_data['installments'] = $this->loans_plan_model->get_installment_types();
		$v_data['loans_plan'] = $this->loans_plan_model->get_loans_plan($loans_plan_id);
		$data['content'] = $this->load->view('loans_plan/edit_loans_plan', $v_data, true);
		
		$this->load->view('admin/templates/general_page', $data);
	}
    
	/*
	*
	*	Delete an existing loans_plan
	*	@param int $loans_plan_id
	*
	*/
	public function delete_loans_plan($loans_plan_id)
	{
		if($this->loans_plan_model->delete_loans_plan($loans_plan_id))
		{
			$this->session->set_userdata('success_message', 'Individual has been deleted');
		}
		
		else
		{
			$this->session->set_userdata('error_message', 'Individual could not deleted');
		}
		redirect('microfinance/loans_plan');
	}
    
	/*
	*
	*	Activate an existing loans_plan
	*	@param int $loans_plan_id
	*
	*/
	public function activate_loans_plan($loans_plan_id)
	{
		$this->loans_plan_model->activate_loans_plan($loans_plan_id);
		$this->session->set_userdata('success_message', 'Individual activated successfully');
		redirect('microfinance/loans_plan');
	}
    
	/*
	*
	*	Deactivate an existing loans_plan
	*	@param int $loans_plan_id
	*
	*/
	public function deactivate_loans_plan($loans_plan_id)
	{
		$this->loans_plan_model->deactivate_loans_plan($loans_plan_id);
		$this->session->set_userdata('success_message', 'Individual disabled successfully');
		redirect('microfinance/loans_plan');
	}
	
	function add_leave()
	{
		$this->form_validation->set_rules('loans_plan_id', 'Individual', 'trim|numeric|required|xss_clean');
		$this->form_validation->set_rules('start_date', 'Start Date', 'trim|required|xss_clean');
		$this->form_validation->set_rules('end_date', 'End Date', 'trim|required|xss_clean');
		$this->form_validation->set_rules('leave_type_id', 'Leave Type', 'trim|numeric|required|xss_clean');

		if ($this->form_validation->run() == FALSE)//if there is an invalid item
		{
			$this->calender($_SESSION['navigation_id'], $_SESSION['sub_navigation_id']);
		}
		
		else//if the input is valid
		{
			$items = array(
						'loans_plan_id' => $this->input->post("loans_plan_id"),
						'start_date' => $this->input->post("start_date"),
						'end_date' => $this->input->post("end_date"),
						'leave_type_id' => $this->input->post("leave_type_id")
					);
			$result = $this->db->insert("leave_duration", $items);
			
			redirect("administration/calender/".$_SESSION['navigation_id']."/".$_SESSION['sub_navigation_id']);
		}
	}
	
	public function get_section_children($section_id)
	{
		$sub_sections = $this->sections_model->get_sub_sections($section_id);
		
		$children = '';
		
		if($sub_sections->num_rows() > 0)
		{
			foreach($sub_sections->result() as $res)
			{
				$section_id = $res->section_id;
				$section_name = $res->section_name;
				
				$children .= '<option value="'.$section_id.'" >'.$section_name.'</option>';
			}
		}
		
		else
		{
			$children = '<option value="" >--No sub sections--</option>';
		}
		
		echo $children;
	}
	
	public function get_loan_details($loans_plan_id)
	{
		$loans_plan = $this->loans_plan_model->get_loans_plan($loans_plan_id);
		$result = '';
		
		if($loans_plan->num_rows() > 0)
		{
			$row = $loans_plan->row();
			$loans_plan_id = $row->loans_plan_id;
			$loans_plan_status = $row->loans_plan_status;
			$installment_type_name = $row->installment_type_name;
			$interest_name = $row->interest_name;
			$interest_id =$row->interest_id;
			$loans_plan_name =$row->loans_plan_name;
			$maximum_loan_amount =$row->maximum_loan_amount;
			$minimum_loan_amount =$row->minimum_loan_amount;
			$custom_loan_amount =$row->custom_loan_amount;
			$installment_type_id =$row->installment_type_id;
			$grace_period_minimum =$row->grace_period_minimum;
			$grace_period_maximum =$row->grace_period_maximum;
			$grace_period_default =$row->grace_period_default;
			$charge_interest_over_grace_period =$row->charge_interest_over_grace_period;
			$maximum_number_of_installments =$row->maximum_number_of_installments;
			$minimum_number_of_installments =$row->minimum_number_of_installments;
			$custom_number_of_installments =$row->custom_number_of_installments;
			$minimum_late_fee_on_total_loan =$row->minimum_late_fee_on_total_loan;
			$maximum_late_fee_on_total_loan =$row->maximum_late_fee_on_total_loan;
			$custom_late_fee_on_total_loan =$row->custom_late_fee_on_total_loan;
			$minimum_late_fee_on_overdue_principal =$row->minimum_late_fee_on_overdue_principal;
			$maximum_late_fee_on_overdue_principal =$row->maximum_late_fee_on_overdue_principal; 
			$custom_late_fee_on_overdue_principal =$row->custom_late_fee_on_overdue_principal;  
			$minimum_late_fee_on_overdue_interest =$row->minimum_late_fee_on_overdue_interest;
			$maximum_late_fee_on_overdue_interest =$row->maximum_late_fee_on_overdue_interest;
			$custom_late_fee_on_overdue_interest =$row->custom_late_fee_on_overdue_interest;
			$maximum_number_of_guarantors =$row->maximum_number_of_guarantors;
			$minimum_number_of_guarantors =$row->minimum_number_of_guarantors;
			$custom_number_of_guarantors =$row->custom_number_of_guarantors;
			$interest_rate =$row->interest_rate;
			
			if($charge_interest_over_grace_period == 1)
			{
				$charge_interest_over_grace_period = 'Yes';
			}
			else
			{
				$charge_interest_over_grace_period = 'No';
			}
			
			$result = 
			'
						<button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#more'.$loans_plan_id.'">
						<i class="fa fa-plus"></i> View details
						</button>
					<!-- Modal -->
					<div class="modal fade" id="more'.$loans_plan_id.'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
						<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
										<h4 class="modal-title">'.$loans_plan_name.'</h4>
									</div>
									<div class="modal-body">
										<table class="table table-bordered table-striped table-condensed">
											<tr>
												<th>Loan name</th>
												<td>'.$loans_plan_name.'</td>
											</tr>
											<tr>
												<th>Interest type</th>
												<td>'.$interest_name.'</td>
											</tr>
											<tr>
												<th>Interest rate</th>
												<td>'.$interest_rate.'</td>
											</tr>
											<tr>
												<th>Installment type</th>
												<td>'.$installment_type_name.'</td>
											</tr>
											<tr>
												<th>Minimum loan amount</th>
												<td>'.number_format($minimum_loan_amount, 2).'</td>
											</tr>
											<tr>
												<th>Maximum loan amount</th>
												<td>'.number_format($maximum_loan_amount, 2).'</td>
											</tr>
											<tr>
												<th>Fixed loan amount</th>
												<td>'.number_format($custom_loan_amount, 2).'</td>
											</tr>
											<tr>
												<th>Minimum grace period</th>
												<td>'.$grace_period_minimum.'</td>
											</tr>
											<tr>
												<th>Maximum grace period</th>
												<td>'.$grace_period_maximum.'</td>
											</tr>
											<tr>
												<th>Default grace period</th>
												<td>'.$grace_period_default.'</td>
											</tr>
											<tr>
												<th>Charge interest over grace period</th>
												<td>'.$charge_interest_over_grace_period.'</td>
											</tr>
											<tr>
												<th>Minimum number of installments</th>
												<td>'.$minimum_number_of_installments.'</td>
											</tr>
											<tr>
												<th>Maximum number of installments</th>
												<td>'.$maximum_number_of_installments.'</td>
											</tr>
											<tr>
												<th>Fixed number of installments</th>
												<td>'.$custom_number_of_installments.'</td>
											</tr>
											<tr>
												<th>Minimum late fee on total loan</th>
												<td>'.number_format($minimum_late_fee_on_total_loan, 2).'</td>
											</tr>
											<tr>
												<th>Maximum late fee on total loan</th>
												<td>'.number_format($maximum_late_fee_on_total_loan, 2).'</td>
											</tr>
											<tr>
												<th>Fixed late fee on total loan</th>
												<td>'.number_format($custom_late_fee_on_total_loan, 2).'</td>
											</tr>
											<tr>
												<th>Minimum late fee on overdue principal</th>
												<td>'.number_format($minimum_late_fee_on_overdue_principal, 2).'</td>
											</tr>
											<tr>
												<th>Maximum late fee on overdue principal</th>
												<td>'.number_format($maximum_late_fee_on_overdue_principal, 2).'</td>
											</tr>
											<tr>
												<th>Fixed late fee on overdue principal</th>
												<td>'.number_format($custom_late_fee_on_overdue_principal, 2).'</td>
											</tr>
											<tr>
												<th>Minimum late fee on overdue interest</th>
												<td>'.number_format($minimum_late_fee_on_overdue_interest, 2).'</td>
											</tr>
											<tr>
												<th>Maximum late fee on overdue interest</th>
												<td>'.number_format($maximum_late_fee_on_overdue_interest, 2).'</td>
											</tr>
											<tr>
												<th>Fixed late fee on overdue interest</th>
												<td>'.number_format($custom_late_fee_on_overdue_interest, 2).'</td>
											</tr>
											<tr>
												<th>Minimum number of guarantors</th>
												<td>'.$minimum_number_of_guarantors.'</td>
											</tr>
											<tr>
												<th>Maximum number of guarantors</th>
												<td>'.$maximum_number_of_guarantors.'</td>
											</tr>
											<tr>
												<th>Fixed number of guarantors</th>
												<td>'.$custom_number_of_guarantors.'</td>
											</tr>
										</table>
									</div>
								</div>
							</div>

						</div>
			';
		}
		
		echo $result;
	}
	
	public function amortize()
	{
		$v_data['individual_loan_id'] = 1;
		$v_data['individual_id'] = 95;
		$v_data['loan_amount'] = 100000;
		$v_data['no_of_repayments'] = 10;
		$v_data['first_date'] = '2015-11-16';
		$v_data['interest_id'] = '1';
		$v_data['interest_rate'] = '20';
		$v_data['installment_type_duration'] = '30';
		echo $this->load->view('individual/get_amortization_table', $v_data, true);
	}
}
?>