<?php
class Auth extends MX_Controller 
{
	function __construct()
	{
		parent:: __construct();
		$this->load->model('auth/auth_model');
		$this->load->model('site/site_model');
		$this->load->model('admin/admin_model');
		$this->load->model('microfinance/messaging_model');
	}
	
	public function index()
	{
		if(!$this->auth_model->check_login())
		{
			redirect('mobile-member-login');
		}
		
		else
		{
			redirect('dashboard');
		}
	}
    
	/*
	*
	*	Login a member
	*
	*/
	public function login_member() 
	{
		$data['individual_password_error'] = '';
		$data['individual_username_error'] = '';
		
		//form validation rules
		//$this->form_validation->set_error_delimiters('', '');
		$this->form_validation->set_rules('individual_username', 'Username', 'required|xss_clean|exists[individual.individual_username]');
		$this->form_validation->set_rules('individual_password', 'Password', 'required|xss_clean');
		$this->form_validation->set_message('exists', 'Username not found. Please try again or contact an administrator.');
		
		//if form has been submitted
		if ($this->form_validation->run())
		{
			//check if individual has valid login credentials
			if($this->auth_model->validate_individual())
			{
				redirect('mobile-member-dashboard');
			}
			
			else
			{
				$this->session->set_userdata('login_error', 'The username or password provided is incorrect. Please try again');
				$data['individual_username'] = set_value('individual_username');
				$data['individual_password'] = set_value('individual_password');
			}
		}
		else
		{
			$validation_errors = validation_errors();
			//echo $validation_errors; die();
			//repopulate form data if validation errors are present
			if(!empty($validation_errors))
			{
				$this->session->set_userdata('login_error', '<h4>Oops. Something went wrong</h4>'.$validation_errors);
				//create errors
				$data['individual_password_error'] = form_error('individual_password');
				$data['individual_username_error'] = form_error('individual_username');
				
				//repopulate fields
				$data['individual_password'] = set_value('individual_password');
				$data['individual_username'] = set_value('individual_username');
			}
			
			//populate form data on initial load of page
			else
			{
				$data['individual_password'] = "";
				$data['individual_username'] = "";
			}
		}
		$data['title'] = $this->site_model->display_page_title();
		
		$data['content'] = $this->load->view('login/login_member', '', TRUE);
		$this->load->view('templates/mobile', $data);
	}
	
	public function logout_member()
	{
		$this->session->sess_destroy();
		redirect('member-login');
	}
	
	public function activate_member()
	{
		$data['individual_number_error'] = '';
		$data['individual_phone_error'] = '';
		$data['individual_username_error'] = '';
		$data['individual_email_error'] = '';
		
		//form validation rules
		//$this->form_validation->set_error_delimiters('', '');
		$this->form_validation->set_rules('individual_number', 'Member Number', 'required|xss_clean|exists[individual.individual_number]');
		$this->form_validation->set_rules('individual_username', 'Username', 'required|xss_clean|is_unique[individual.individual_username]');
		$this->form_validation->set_rules('individual_phone', 'Phone', 'required|xss_clean');
		$this->form_validation->set_rules('individual_email', 'Email', 'valid_email|xss_clean');
		$this->form_validation->set_message('is_unique', 'That username already exists. Please enter another one.');
		$this->form_validation->set_message('exists', 'Member number not found. Please try again or contact an administrator.');
		
		//if form has been submitted
		if ($this->form_validation->run())
		{
			//check if individual has valid login credentials
			if($this->auth_model->activate_individual())
			{
				$this->session->set_userdata('success_message', 'You have been successfully activated. Please login with the username entered and password sent to you by SMS.');
				redirect('mobile-member-login');
			}
			
			else
			{
				$this->session->set_userdata('login_error', 'Oops. Something went wrong. Please try again');
				$data['individual_number'] = set_value('individual_number');
				$data['individual_username'] = set_value('individual_username');
				$data['individual_phone'] = set_value('individual_phone');
				$data['individual_email'] = set_value('individual_email');
			}
		}
		else
		{
			$validation_errors = validation_errors();
			//echo $validation_errors; die();
			//repopulate form data if validation errors are present
			if(!empty($validation_errors))
			{
				$this->session->set_userdata('login_error', '<h4>Oops. Something went wrong</h4>'.$validation_errors);
				//create errors
				$data['individual_number_error'] = form_error('individual_number');
				$data['individual_phone_error'] = form_error('individual_phone');
				$data['individual_username_error'] = form_error('individual_username');
				$data['individual_email_error'] = form_error('individual_email');
				
				//repopulate fields
				$data['individual_number'] = set_value('individual_number');
				$data['individual_phone'] = set_value('individual_phone');
				$data['individual_username'] = set_value('individual_username');
				$data['individual_email'] = set_value('individual_email');
			}
			
			//populate form data on initial load of page
			else
			{
				$data['individual_number'] = "";
				$data['individual_phone'] = "";
				$data['individual_username'] = "";
				$data['individual_email'] = "";
			}
		}
		$data['title'] = $this->site_model->display_page_title();
		
		$data['content'] = $this->load->view('login/login_member', '', TRUE);
		$this->load->view('templates/mobile', $data);
	}
}
?>