<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once "./application/modules/microfinance/controllers/microfinance.php";

class Import extends microfinance 
{
	var $csv_path;
	
	function __construct()
	{
		parent:: __construct();
		
		$this->csv_path = realpath(APPPATH . '../assets/csv');
		$this->load->model('import_model');
	}
    
	/*
	*
	*	import individual
	*
	*/
	function import_individuals()
	{
		$v_data['title'] = $data['title'] = $this->site_model->display_page_title();
		
		$data['content'] = $this->load->view('import/import_individuals', $v_data, true);
		$this->load->view('admin/templates/general_page', $data);
	}
    
	/*
	*
	*	import individual template
	*
	*/
	function import_individuals_template()
	{
		//export products template in excel 
		$this->import_model->import_individuals_template();
	}
    
	/*
	*
	*	Do the actual individual import
	*
	*/
	function do_individuals_import()
	{
		if(isset($_FILES['import_csv']))
		{
			if(is_uploaded_file($_FILES['import_csv']['tmp_name']))
			{
				//import products from excel 
				$response = $this->import_model->import_csv_individuals($this->csv_path);
				
				if($response == FALSE)
				{
					$v_data['import_response_error'] = 'Something went wrong. Please try again.';
				}
				
				else
				{
					if($response['check'])
					{
						$v_data['import_response'] = $response['response'];
					}
					
					else
					{
						$v_data['import_response_error'] = $response['response'];
					}
				}
			}
			
			else
			{
				$v_data['import_response_error'] = 'Please select a file to import.';
			}
		}
		
		else
		{
			$v_data['import_response_error'] = 'Please select a file to import.';
		}
		
		$v_data['title'] = $data['title'] = $this->site_model->display_page_title();
		
		$data['content'] = $this->load->view('import/import_individuals', $v_data, true);
		$this->load->view('admin/templates/general_page', $data);
	}
    
	/*
	*
	*	import saving
	*
	*/
	function import_savings()
	{
		$v_data['title'] = $data['title'] = $this->site_model->display_page_title();
		
		$data['content'] = $this->load->view('import/import_savings', $v_data, true);
		$this->load->view('admin/templates/general_page', $data);
	}
	
	function import_cheque_disbursements()
	{
		$v_data['title'] = $data['title'] = $this->site_model->display_page_title();
		
		$data['content'] = $this->load->view('import/import_cheque_disbursements', $v_data, true);
		$this->load->view('admin/templates/general_page', $data);
	}
    
	/*
	*
	*	import saving template
	*
	*/
	function import_savings_template()
	{
		//export products template in excel 
		$this->import_model->import_savings_template();
	}
    
	//import cheques disbursed template
	function import_cheque_disbursed_template()
	{
		//export products template in excel 
		$this->import_model->import_cheque_disbursed_template();
	}
	
	/*
	*
	*	Do the actual saving import
	*
	*/
	function do_savings_import()
	{
		if(isset($_FILES['import_csv']))
		{
			if(is_uploaded_file($_FILES['import_csv']['tmp_name']))
			{
				//import products from excel 
				$response = $this->import_model->import_csv_savings($this->csv_path);
				
				if($response == FALSE)
				{
					$v_data['import_response_error'] = 'Something went wrong. Please try again.';
				}
				
				else
				{
					if($response['check'])
					{
						$v_data['import_response'] = $response['response'];
					}
					
					else
					{
						$v_data['import_response_error'] = $response['response'];
					}
				}
			}
			
			else
			{
				$v_data['import_response_error'] = 'Please select a file to import.';
			}
		}
		
		else
		{
			$v_data['import_response_error'] = 'Please select a file to import.';
		}
		
		$v_data['title'] = $data['title'] = $this->site_model->display_page_title();
		
		$data['content'] = $this->load->view('import/import_savings', $v_data, true);
		$this->load->view('admin/templates/general_page', $data);
	}
	
	
	function do_disbursement_import()
	{
		if(isset($_FILES['import_csv']))
		{
			if(is_uploaded_file($_FILES['import_csv']['tmp_name']))
			{
				//import products from excel 
				$response = $this->import_model->import_csv_disbursements($this->csv_path);
				
				if($response == FALSE)
				{
					$v_data['import_response_error'] = 'Something went wrong. Please try again.';
				}
				
				else
				{
					if($response['check'])
					{
						$v_data['import_response'] = $response['response'];
					}
					
					else
					{
						$v_data['import_response_error'] = $response['response'];
					}
				}
			}
			
			else
			{
				$v_data['import_response_error'] = 'Please select a file to import.';
			}
		}
		
		else
		{
			$v_data['import_response_error'] = 'Please select a file to import.';
		}
		
		$v_data['title'] = $data['title'] = $this->site_model->display_page_title();
		
		$data['content'] = $this->load->view('import/import_cheque_disbursements', $v_data, true);
		$this->load->view('admin/templates/general_page', $data);
	}
    
	/*
	*
	*	import loan
	*
	*/
	function import_loans()
	{
		$v_data['title'] = $data['title'] = $this->site_model->display_page_title();
		
		$data['content'] = $this->load->view('import/import_loans', $v_data, true);
		$this->load->view('admin/templates/general_page', $data);
	}
    
	/*
	*
	*	import loan template
	*
	*/
	function import_loans_template()
	{
		//export products template in excel 
		$this->import_model->import_loans_template();
	}
    
	/*
	*
	*	Do the actual loan import
	*
	*/
	function do_loans_import()
	{
		if(isset($_FILES['import_csv']))
		{
			if(is_uploaded_file($_FILES['import_csv']['tmp_name']))
			{
				//import products from excel 
				$response = $this->import_model->import_csv_loans($this->csv_path);
				
				if($response == FALSE)
				{
					$v_data['import_response_error'] = 'Something went wrong. Please try again.';
				}
				
				else
				{
					if($response['check'])
					{
						$v_data['import_response'] = $response['response'];
					}
					
					else
					{
						$v_data['import_response_error'] = $response['response'];
					}
				}
			}
			
			else
			{
				$v_data['import_response_error'] = 'Please select a file to import.';
			}
		}
		
		else
		{
			$v_data['import_response_error'] = 'Please select a file to import.';
		}
		
		$v_data['title'] = $data['title'] = $this->site_model->display_page_title();
		
		$data['content'] = $this->load->view('import/import_loans', $v_data, true);
		$this->load->view('admin/templates/general_page', $data);
	}
    
	/*
	*
	*	import loan_payment
	*
	*/
	function import_loan_payments()
	{
		$v_data['title'] = $data['title'] = $this->site_model->display_page_title();
		
		$data['content'] = $this->load->view('import/import_loan_payments', $v_data, true);
		$this->load->view('admin/templates/general_page', $data);
	}
    
	/*
	*
	*	import loan_payment template
	*
	*/
	function import_loan_payments_template()
	{
		//export products template in excel 
		$this->import_model->import_loan_payments_template();
	}
    
	/*
	*
	*	Do the actual loan_payment import
	*
	*/
	function do_loan_payments_import()
	{
		if(isset($_FILES['import_csv']))
		{
			if(is_uploaded_file($_FILES['import_csv']['tmp_name']))
			{
				//import products from excel 
				$response = $this->import_model->import_csv_loan_payments($this->csv_path);
				
				if($response == FALSE)
				{
					$v_data['import_response_error'] = 'Something went wrong. Please try again.';
				}
				
				else
				{
					if($response['check'])
					{
						$v_data['import_response'] = $response['response'];
					}
					
					else
					{
						$v_data['import_response_error'] = $response['response'];
					}
				}
			}
			
			else
			{
				$v_data['import_response_error'] = 'Please select a file to import.';
			}
		}
		
		else
		{
			$v_data['import_response_error'] = 'Please select a file to import.';
		}
		
		$v_data['title'] = $data['title'] = $this->site_model->display_page_title();
		
		$data['content'] = $this->load->view('import/import_loan_payments', $v_data, true);
		$this->load->view('admin/templates/general_page', $data);
	}
    
	/*
	*
	*	import withdrawals
	*
	*/
	function import_withdrawals()
	{
		$v_data['title'] = $data['title'] = $this->site_model->display_page_title();
		
		$data['content'] = $this->load->view('import/import_withdrawals', $v_data, true);
		$this->load->view('admin/templates/general_page', $data);
	}
    
	/*
	*
	*	import withdrawals template
	*
	*/
	function import_withdrawals_template()
	{
		//export products template in excel 
		$this->import_model->import_withdrawals_template();
	}
    
	/*
	*
	*	Do the actual withdrawals import
	*
	*/
	function do_withdrawals_import()
	{
		if(isset($_FILES['import_csv']))
		{
			if(is_uploaded_file($_FILES['import_csv']['tmp_name']))
			{
				//import products from excel 
				$response = $this->import_model->import_csv_withdrawals($this->csv_path);
				
				if($response == FALSE)
				{
					$v_data['import_response_error'] = 'Something went wrong. Please try again.';
				}
				
				else
				{
					if($response['check'])
					{
						$v_data['import_response'] = $response['response'];
					}
					
					else
					{
						$v_data['import_response_error'] = $response['response'];
					}
				}
			}
			
			else
			{
				$v_data['import_response_error'] = 'Please select a file to import.';
			}
		}
		
		else
		{
			$v_data['import_response_error'] = 'Please select a file to import.';
		}
		
		$v_data['title'] = $data['title'] = $this->site_model->display_page_title();
		
		$data['content'] = $this->load->view('import/import_withdrawals', $v_data, true);
		$this->load->view('admin/templates/general_page', $data);
	}
    
	/*
	*
	*	import individual
	*
	*/
	function import_individual_contacts()
	{
		$v_data['title'] = $data['title'] = $this->site_model->display_page_title();
		
		$data['content'] = $this->load->view('import/import_individual_contacts', $v_data, true);
		$this->load->view('admin/templates/general_page', $data);
	}
    
	/*
	*
	*	import individual template
	*
	*/
	function import_individual_contacts_template()
	{
		//export products template in excel 
		$this->import_model->import_individual_contacts_template();
	}
    
	/*
	*
	*	Do the actual individual import
	*
	*/
	function do_individual_contacts_import()
	{
		if(isset($_FILES['import_csv']))
		{
			if(is_uploaded_file($_FILES['import_csv']['tmp_name']))
			{
				//import products from excel 
				$response = $this->import_model->import_csv_individual_contacts($this->csv_path);
				
				if($response == FALSE)
				{
					$v_data['import_response_error'] = 'Something went wrong. Please try again.';
				}
				
				else
				{
					if($response['check'])
					{
						$v_data['import_response'] = $response['response'];
					}
					
					else
					{
						$v_data['import_response_error'] = $response['response'];
					}
				}
			}
			
			else
			{
				$v_data['import_response_error'] = 'Please select a file to import.';
			}
		}
		
		else
		{
			$v_data['import_response_error'] = 'Please select a file to import.';
		}
		
		$v_data['title'] = $data['title'] = $this->site_model->display_page_title();
		
		$data['content'] = $this->load->view('import/import_individual_contacts', $v_data, true);
		$this->load->view('admin/templates/general_page', $data);
	}
}
?>