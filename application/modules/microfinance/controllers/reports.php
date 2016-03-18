<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once "./application/modules/microfinance/controllers/microfinance.php";

class Reports extends microfinance 
{
	
	function __construct()
	{
		parent:: __construct();
		
		$this->csv_path = realpath(APPPATH . '../assets/csv');
		$this->load->model('reports_model');
	}
	
	public function dashboard()
	{
		$data['content'] = $this->load->view('reports/dashboard', '', TRUE);
		
		$data['title'] = 'Dashboard';
		$data['sidebar'] = 'admin_sidebar';
		$this->load->view('admin/templates/general_page', $data);
	}
	
	function interest_revenue_totals($timestamp)
	{
		$date = gmdate("Y-m-d", ($timestamp/1000));
		$month = date('m',strtotime($date));
		$year = date('Y',strtotime($date));
		
		//initialize required variables
		$highest_bar = 0;
		
		//get outpatient total
		$total_interest_revenue = $this->reports_model->month_interest_payments($month, $year);
		$total_loan_payments = $this->reports_model->month_loan_payments($month, $year);
		$total_savings_payments = $this->reports_model->month_savings_payments($month, $year);
		//mark the highest bar
		$highest_bar = $total_interest_revenue;
		
		//prep data for the particular application type
		$result[strtolower('interest')] = $total_interest_revenue;
		$result[strtolower('loans')] = $total_loan_payments;
		$result[strtolower('savings')] = $total_savings_payments;
		
		$result['highest_bar'] = $highest_bar;//var_dump($result['bars']);
		echo json_encode($result);
	}
	
	function financial_totals()
	{	
		//get all loan_type types
		$loans_result = $this->reports_model->get_all_loan_types();
		
		//initialize required variables
		$totals = '';
		$names = '';
		$highest_bar = 0;
		$r = 1;
		
		if($loans_result->num_rows() > 0)
		{
			$result = $loans_result->result();
			
			foreach($result as $res)
			{
				$loan_type_status = $res->loan_type_status;
				$loan_type_name = $res->loan_type_name;
				
				//get loan_type total
				$total = $this->reports_model->get_loan_type_total($loan_type_status);
				
				//mark the highest bar
				if($total > $highest_bar)
				{
					$highest_bar = $total;
				}
				
				if($r == $loans_result->num_rows())
				{
					$totals .= $total;
					$names .= $loan_type_name;
				}
				
				else
				{
					$totals .= $total.',';
					$names .= $loan_type_name.',';
				}
				$r++;
			}
		}
		
		$result['total_loan_types'] = $loans_result->num_rows();
		$result['names'] = $names;
		$result['bars'] = $totals;
		$result['highest_bar'] = $highest_bar;
		echo json_encode($result);
	}
	
	function get_loan_applications()
	{	
		//get all appointments
		$applications_result = $this->reports_model->get_all_applications();
		
		//initialize required variables
		$totals = '';
		$highest_bar = 0;
		$r = 0;
		$data = array();
		
		if($applications_result->num_rows() > 0)
		{
			$result = $applications_result->result();
			
			foreach($result as $res)
			{
				$application_date = date('D M d Y',strtotime($res->application_date)); 
				$time_start = $application_date.' 00:00:00 GMT+0300'; 
				$time_end = $application_date.' 00:00:00 GMT+0300';
				$loan_application_status = $res->individual_loan_status;
				if($loan_application_status == 0)
				{
					$loan_application_status = 'Pending approval';
				}
				else
				{
					$loan_application_status = 'Approved';
				}
				
				$individual_id = $res->individual_id;
				//$color = $this->reception_model->random_color();
				$color = '#0088CC';
				
				$data['title'][$r] = $res->individual_fname.' '.$res->individual_mname.' '.$res->individual_lname.' '.$loan_application_status.' '.$res->proposed_amount;
				$data['start'][$r] = $time_start;
				$data['end'][$r] = $time_end;
				$data['backgroundColor'][$r] = $color;
				$data['borderColor'][$r] = $color;
				$data['allDay'][$r] = FALSE;
				$data['url'][$r] = site_url().'microfinance/edit-individual/'.$individual_id;
				$r++;
			}
		}
		
		$data['total_events'] = $r;
		echo json_encode($data);
	}
	
	public function loans()
	{
		
	}
}