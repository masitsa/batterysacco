<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once "./application/modules/microfinance/controllers/microfinance.php";

class Payments extends microfinance {

	public function __construct()
	{
		parent::__construct();
	}

	/*
	*
	*	Default action is to show all the loans_plan
	*
	*/
	public function index($order = 'id', $order_method = 'ASC') 
	{
		//if form conatins invalid data
		$smessage = $this->session->userdata('success_message');
		$emessage = $this->session->userdata('error_message');
		$v_data['customers'] = $this->individual_model->all_individual();

		$data = array('title' => 'Individual Payments');
		$v_data['title'] = $data['title'];
		$data['content'] = $this->load->view('payments/all_individual_payments', $v_data, true);
		$this->load->view('admin/templates/general_page', $data);
	}

	public function list_individuals()
	{
		$v_data['customers'] = $this->payments_model->all_individual();
		$data = array('title' => 'Choose an individual to view their payments');
		$v_data['title'] = $data['title'];
		$data['content'] = $this->load->view('payments/list_individual', $v_data, true);
		$this->load->view('admin/templates/general_page', $data);
	}
	public function show_individual_payment($id='0',$order = 'date_paid', $order_method = 'ASC')
	{
		if ($this->form_validation->run('list_payments')){
			// echo $this->input->post('customer_id');
			$gid = $this->input->post('customer_id');
			
			$row = $this->individual_model->get_individual($gid);
			$individual_details=$row->first_row();
			// print_r($groupdetails);

			// load groups data
			$where = 'individual_id = '.$gid.'';
			$table = 'individual_payments';
			//pagination
			$segment = 4;
			$this->load->library('pagination');
			$config['base_url'] = site_url().'microfinance/'.$order.'/'.$order_method;
			$config['total_rows'] = $this->users_model->count_items($table, $where);
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
			$query = $this->payments_model->all_individual_payment($table, $where, $config["per_page"], $page, $order, $order_method);
			
			//change of order method 
			if($order_method == 'DESC')
			{
				$order_method = 'ASC';
			}
			
			else
			{
				$order_method = 'DESC';
			}
			
			$data['title'] = $individual_details->individual_onames;
			$v_data['title'] = $data['title'];
			
			$v_data['order'] = $order;
			$v_data['order_method'] = $order_method;
			$v_data['query'] = $query;
			$v_data['page'] = $page;
	

			$data = array('title' => $individual_details->individual_onames.' payments');
			$v_data['title'] = $data['title'];
			$data['content'] = $this->load->view('payments/show_individual_payment', $v_data, true);
			$this->load->view('admin/templates/general_page', $data);
		}else 	if(isset($id) && $id > '0'){
			$gid = $id;
				// echo "fikad";
			$row = $this->individual_model->get_individual($gid);
			$individual_details=$row->first_row();
			// print_r($gid);

			// load groups data
			$where = 'individual_id = '.$gid.'';
			$table = 'individual_payments';
			//pagination
			$segment = 4;
			$this->load->library('pagination');
			$config['base_url'] = site_url().'microfinance/'.$order.'/'.$order_method;
			$config['total_rows'] = $this->users_model->count_items($table, $where);
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
			$query = $this->payments_model->all_individual_payment($table, $where, $config["per_page"], $page, $order, $order_method);
			
			//change of order method 
			if($order_method == 'DESC')
			{
				$order_method = 'ASC';
			}
			
			else
			{
				$order_method = 'DESC';
			}
			
			$data['title'] = $individual_details->individual_onames;
			$v_data['title'] = $data['title'];
			
			$v_data['order'] = $order;
			$v_data['order_method'] = $order_method;
			$v_data['query'] = $query;
			$v_data['page'] = $page;
	
			$data = array('title' => $individual_details->individual_onames.' payments');
			$v_data['title'] = $data['title'];
			$data['content'] = $this->load->view('payments/show_individual_payment', $v_data, true);
			$this->load->view('admin/templates/general_page', $data);
	
		}else{
			$this->list_individuals();
		}
		 
	}
	
	public function add_individual_payment($individual_id)
	{
		$this->form_validation->set_rules('payment_amount', 'Payment amount', 'required|xss_clean');
		$this->form_validation->set_rules('payment_date', 'Payment date', 'required|xss_clean');
		
		if ($this->form_validation->run('individual_payments'))
		{
			$indiviudal_payment_id = $this->payments_model->add_individual_payment($individual_id);
			if($indiviudal_payment_id != FALSE)
			{
				$this->session->set_userdata("success_message", "Individual payment recorded");
			}
			
			else
			{
				$this->session->set_userdata("error_message","Could not save individual payment. Please try again");
			}
		}else{
			$this->session->set_userdata("error_message",validation_errors());
		}
		
		redirect('microfinance/edit-individual/'.$individual_id);
		
	}
	
	public function add_loan_payment($individual_id)
	{
		$this->form_validation->set_rules('payment_amount', 'Payment amount', 'required|xss_clean');
		$this->form_validation->set_rules('payment_amount', 'Interest amount', 'xss_clean');
		$this->form_validation->set_rules('payment_date', 'Payment date', 'required|xss_clean');
		
		if ($this->form_validation->run('individual_payments'))
		{
			$indiviudal_payment_id = $this->payments_model->add_loan_payment($individual_id);
			if($indiviudal_payment_id != FALSE)
			{
				$this->session->set_userdata("success_message", "Individual payment recorded");
			}
			
			else
			{
				$this->session->set_userdata("error_message","Could not save individual payment. Please try again");
			}
		}else{
			$this->session->set_userdata("error_message",validation_errors());
		}
		
		redirect('microfinance/edit-individual/'.$individual_id);
		
	}
	public function edit_individual_payment($id='0')
	{
		

		
		if ($this->form_validation->run('individual_payments'))
		{

			$flag = $this->payments_model->edit_individual_payment();

			if($flag != FALSE)
			{
				$id = $this->input->post('pid');

				$this->session->set_userdata("success_message", "Individual payment updated");
				redirect('microfinance/edit-individual-payment/'.$id.'');
				// var_dump($flag);
			}
			
			else
			{
				$this->session->set_userdata("error_message","Could not update individual payment details. Please try again");
			}
		}else{
			if ($id=='0') {
				$id = $this->input->post('pid');

			};
			$grouppaymentdetails    = $this->payments_model->get_individual_payment_details($id);
			$single                 = $grouppaymentdetails->first_row();
			// print_r($single);
			$v_data['id']             = $single->id;
			$v_data['customer_id']    = $single->individual_id;
			// $payment_type        = set_value('payment_type');
			$v_data['payment_amount'] = $single->amount;
			$v_data['slip_number']    = $single->slip_number;
			$v_data['date_paid']      = $single->date_paid;
			$v_data['payment_month']  = $single->month_paid_for;
			$v_data['customers']    = $this->payments_model->all_individual();
			
			$data            = array('title' => 'Inidividual Payments');
			$v_data['title'] = $data['title'];
			$data['content'] = $this->load->view('payments/edit_single_individual_payment', $v_data, true);
			$this->load->view('admin/templates/general_page', $data);
		}


	}
	public function delete_individual_payment($id, $individual_id)
	{
		if($this->payments_model->delete_individual_payment($id))
		{
			$this->session->set_userdata('success_message', 'Individuals payment has been deleted');
			redirect('microfinance/edit-individual/'.$individual_id);
			// print_r ($group_id);
		}
		
		else
		{			

			$this->session->set_userdata('error_message', 'Individuals payment could not be deleted');
			redirect('microfinance/edit-individual/'.$individual_id);
			// echo $group_id;
		}
		
	}
	public function group($order = 'id', $order_method = 'ASC') 
	{
		//if form conatins invalid data
		$smessage = $this->session->userdata('success_message');
		$emessage = $this->session->userdata('error_message');
		$v_data['customers'] = $this->group_model->all_groups_for_payment();

		$data = array('title' => 'Group Payments');
		$v_data['title'] = $data['title'];
		$data['content'] = $this->load->view('payments/all_group_payments', $v_data, true);
		$this->load->view('admin/templates/general_page', $data);
	}

	
	public function add_group_payment()
	{

		if ($this->form_validation->run('group_payments'))
		{

			$group_payment_id = $this->payments_model->add_group_payment();
			if($group_payment_id != FALSE)
			{
				$this->session->set_userdata("success_message", "group payment recorded");
				redirect('microfinance/add-group-payment');
			}
			
			else
			{
				$this->session->set_userdata("error_message","Could not save group payment. Please try again");
			}
		}else{
			$v_data['customers'] = $this->group_model->all_groups_for_payment();

			$data = array('title' => 'Group Payments');
			$v_data['title'] = $data['title'];
			$data['content'] = $this->load->view('payments/all_group_payments', $v_data, true);
			$this->load->view('admin/templates/general_page', $data);
		}
		
	}

	public function list_group()
	{
		$v_data['customers'] = $this->group_model->all_groups_for_payment();
		$data = array('title' => 'Choose a group to view its payments');
		$v_data['title'] = $data['title'];
		$data['content'] = $this->load->view('payments/list_group', $v_data, true);
		$this->load->view('admin/templates/general_page', $data);
	}

	public function show_group_payment($id='0',$order = 'date_paid', $order_method = 'ASC')
	{
		if ($this->form_validation->run('list_payments')){
			// echo $this->input->post('customer_id');
			$gid = $this->input->post('customer_id');
			
			$row = $this->group_model->get_group($gid);
			$groupdetails=$row->first_row();
			// print_r($groupdetails);

			// load groups data
			$where = 'group_id = '.$gid.'';
			$table = 'group_payments';
			//pagination
			$segment = 4;
			$this->load->library('pagination');
			$config['base_url'] = site_url().'microfinance/'.$order.'/'.$order_method;
			$config['total_rows'] = $this->users_model->count_items($table, $where);
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
			$query = $this->payments_model->all_groups_payment($table, $where, $config["per_page"], $page, $order, $order_method);
			
			//change of order method 
			if($order_method == 'DESC')
			{
				$order_method = 'ASC';
			}
			
			else
			{
				$order_method = 'DESC';
			}
			
			$data['title'] = $groupdetails->group_name;
			$v_data['title'] = $data['title'];
			
			$v_data['order'] = $order;
			$v_data['order_method'] = $order_method;
			$v_data['query'] = $query;
			$v_data['page'] = $page;
	

			$data = array('title' => $groupdetails->group_name.' payments');
			$v_data['title'] = $data['title'];
			$data['content'] = $this->load->view('payments/show_group_payment', $v_data, true);
			$this->load->view('admin/templates/general_page', $data);
		}else 	if(isset($id) && $id > '0'){
				$gid = $id;
				// echo "fikad";
			
			$row = $this->group_model->get_group($gid);
			$groupdetails=$row->first_row();
			// print_r($groupdetails);

			// load groups data
			$where = 'group_id = '.$gid.'';
			$table = 'group_payments';
			//pagination
			$segment = 4;
			$this->load->library('pagination');
			$config['base_url'] = site_url().'microfinance/'.$order.'/'.$order_method;
			$config['total_rows'] = $this->users_model->count_items($table, $where);
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
			$query = $this->payments_model->all_groups_payment($table, $where, $config["per_page"], $page, $order, $order_method);
			
			//change of order method 
			if($order_method == 'DESC')
			{
				$order_method = 'ASC';
			}
			
			else
			{
				$order_method = 'DESC';
			}
			
			$data['title'] = $groupdetails->group_name;
			$v_data['title'] = $data['title'];
			
			$v_data['order'] = $order;
			$v_data['order_method'] = $order_method;
			$v_data['query'] = $query;
			$v_data['page'] = $page;
	

			$data = array('title' => $groupdetails->group_name.' payments');
			$v_data['title'] = $data['title'];
			$data['content'] = $this->load->view('payments/show_group_payment', $v_data, true);
			$this->load->view('admin/templates/general_page', $data);
		}else{
			$v_data['customers'] = $this->group_model->all_groups_for_payment();
			$data = array('title' => 'Choose group to edit');
			$v_data['title'] = $data['title'];
			$data['content'] = $this->load->view('payments/list_group', $v_data, true);
			$this->load->view('admin/templates/general_page', $data);
		}
		 
	}
	public function delete_group_payment($id)
	{
		if($group_id = $this->payments_model->delete_group_payment($id))
		{
			$this->session->set_userdata('success_message', 'Group payment has been deleted');
			redirect('microfinance/show-group-payment/'.$group_id['group_id']).'';
			// print_r ($group_id);
		}
		
		else
		{			

			$this->session->set_userdata('error_message', 'Group payment could not be deleted');
			redirect('microfinance/show-group-payment/'.$group_id['group_id']).'';
			// echo $group_id;
		}
		
	}
	public function edit_group_payment($id='0')
	{
		

		
		if ($this->form_validation->run('group_payments'))
		{

			$flag = $this->payments_model->edit_group_payment();

			if($flag != FALSE)
			{
				$id = $this->input->post('pid');

				$this->session->set_userdata("success_message", "group payment updated");
				redirect('microfinance/edit-group-payment/'.$id.'');
				// var_dump($flag);
			}
			
			else
			{
				$this->session->set_userdata("error_message","Could not update group payment details. Please try again");
			}
		}else{
			if ($id=='0') {
				$id = $this->input->post('pid');
			};
			$grouppaymentdetails    = $this->payments_model->get_payment_details($id);
			$single                 = $grouppaymentdetails->first_row();
			// print_r($single);
			$v_data['id']             = $single->id;
			$v_data['customer_id']    = $single->group_id;
			// $payment_type        = set_value('payment_type');
			$v_data['payment_amount'] = $single->amount;
			$v_data['slip_number']    = $single->slip_number;
			$v_data['date_paid']      = $single->date_paid;
			$v_data['payment_month']  = $single->month_paid_for;
			$v_data['customers']    = $this->group_model->all_groups_for_payment();
			
			$data            = array('title' => 'Group Payments');
			$v_data['title'] = $data['title'];
			$data['content'] = $this->load->view('payments/edit_single_group_payment', $v_data, true);
			$this->load->view('admin/templates/general_page', $data);
		}


	}
}
/* End of file payments.php */
/* Location: ./application/controllers/payments.php */