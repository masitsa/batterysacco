<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once "./application/modules/microfinance/controllers/microfinance.php";

class Withdrawals extends microfinance {

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

		$data = array('title' => 'Individual Withdrawals');
		$v_data['title'] = $data['title'];
		$data['content'] = $this->load->view('withdrawals/all_individual_withdrawals', $v_data, true);
		$this->load->view('admin/templates/general_page', $data);
		
	}

	public function list_individuals()
	{
		$v_data['customers'] = $this->withdrawals_model->all_individual();
		$data = array('title' => 'Choose an individual to view their withdrawals');
		$v_data['title'] = $data['title'];
		$data['content'] = $this->load->view('withdrawals/list_individual', $v_data, true);
		$this->load->view('admin/templates/general_page', $data);
	}
	public function show_individual_withdrawal($id='0',$order = 'date_paid', $order_method = 'ASC')
	{
		if ($this->form_validation->run('list_withdrawals')){
			// echo $this->input->post('customer_id');
			$gid = $this->input->post('customer_id');
			
			$row = $this->individual_model->get_individual($gid);
			$individual_details=$row->first_row();
			// print_r($groupdetails);

			// load groups data
			$where = 'individual_id = '.$gid.'';
			$table = 'individual_withdrawals';
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
			$query = $this->withdrawals_model->all_individual_withdrawal($table, $where, $config["per_page"], $page, $order, $order_method);
			
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
	

			$data = array('title' => $individual_details->individual_onames.' withdrawals');
			$v_data['title'] = $data['title'];
			$data['content'] = $this->load->view('withdrawals/show_individual_withdrawal', $v_data, true);
			$this->load->view('admin/templates/general_page', $data);
		}else 	if(isset($id) && $id > '0'){
			$gid = $id;
				// echo "fikad";
			$row = $this->individual_model->get_individual($gid);
			$individual_details=$row->first_row();
			// print_r($gid);

			// load groups data
			$where = 'individual_id = '.$gid.'';
			$table = 'individual_withdrawals';
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
			$v_data['savings_withdrawals'] = $this->individual_model->get_savings_withdrawals($individual_id);
			$query = $this->withdrawals_model->all_individual_withdrawal($table, $where, $config["per_page"], $page, $order, $order_method);
			
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
	
			$data = array('title' => $individual_details->individual_onames.' withdrawals');
			$v_data['title'] = $data['title'];
			$data['content'] = $this->load->view('withdrawals/show_individual_withdrawal', $v_data, true);
			$this->load->view('admin/templates/general_page', $data);
	
		}else{
			$this->list_individuals();
		}
		 
	}
	public function add_individual_withdrawal($individual_id)
	{
		$this->form_validation->set_rules('withdrawal_amount', 'Withdrawal amount', 'required|xss_clean');
		$this->form_validation->set_rules('withdrawal_date', 'Withdrawal date', 'required|xss_clean');
		$this->form_validation->set_rules('withdrawal_type_id', 'Withdrawal Type', 'xss_clean');
		
		if ($this->form_validation->run('individual_withdrawals'))
		{

			$indiviudal_withdrawal_id = $this->withdrawals_model->add_individual_withdrawal($individual_id);
			if($indiviudal_withdrawal_id != FALSE)
			{
				$this->session->set_userdata("success_message", "Withdrawal added successfully");
			}
			
			else
			{
				$this->session->set_userdata("error_message","Could not save withdrawal. Please try again");
			}
		}
		
		else
		{
			$this->session->set_userdata("error_message", validation_errors());
		}
		
		redirect('microfinance/edit-individual/'.$individual_id);
		
	}
	
	public function edit_individual_withdrawal($id='0')
	{
		if ($this->form_validation->run('individual_withdrawals'))
		{

			$flag = $this->withdrawals_model->edit_individual_withdrawal();

			if($flag != FALSE)
			{
				$id = $this->input->post('pid');

				$this->session->set_userdata("success_message", "Individual withdrawal updated");
				redirect('microfinance/edit-individual-withdrawal/'.$id.'');
				// var_dump($flag);
			}
			
			else
			{
				$this->session->set_userdata("error_message","Could not update individual withdrawal details. Please try again");
			}
		}else{
			if ($id=='0') {
				$id = $this->input->post('pid');

			};
			$groupwithdrawaldetails    = $this->withdrawals_model->get_individual_withdrawal_details($id);
			$single                 = $groupwithdrawaldetails->first_row();
			// print_r($single);
			$v_data['id']             = $single->id;
			$v_data['customer_id']    = $single->individual_id;
			// $withdrawal_type        = set_value('withdrawal_type');
			$v_data['withdrawal_amount'] = $single->amount;
			$v_data['slip_number']    = $single->slip_number;
			$v_data['date_paid']      = $single->date_paid;
			$v_data['withdrawal_month']  = $single->month_paid_for;
			$v_data['customers']    = $this->withdrawals_model->all_individual();
			
			$data            = array('title' => 'Inidividual Withdrawals');
			$v_data['title'] = $data['title'];
			$data['content'] = $this->load->view('withdrawals/edit_single_individual_withdrawal', $v_data, true);
			$this->load->view('admin/templates/general_page', $data);
		}


	}
	public function delete_individual_withdrawal($savings_withdrawal_id, $individual_id)
	{
		if($this->withdrawals_model->delete_individual_withdrawal($savings_withdrawal_id))
		{
			$this->session->set_userdata('success_message', 'Withdrawal has been deleted');
		}
		
		else
		{			

			$this->session->set_userdata('error_message', 'Withdrawal could not be deleted');
		}
		redirect('microfinance/edit-individual/'.$individual_id).'';
		
	}
	public function group($order = 'id', $order_method = 'ASC') 
	{
		//if form conatins invalid data
		$smessage = $this->session->userdata('success_message');
		$emessage = $this->session->userdata('error_message');
		$v_data['customers'] = $this->group_model->all_groups_for_withdrawal();

		$data = array('title' => 'Group Withdrawals');
		$v_data['title'] = $data['title'];
		$data['content'] = $this->load->view('withdrawals/all_group_withdrawals', $v_data, true);
		$this->load->view('admin/templates/general_page', $data);
	}

	
	public function add_group_withdrawal()
	{

		if ($this->form_validation->run('group_withdrawals'))
		{

			$group_withdrawal_id = $this->withdrawals_model->add_group_withdrawal();
			if($group_withdrawal_id != FALSE)
			{
				$this->session->set_userdata("success_message", "group withdrawal recorded");
				redirect('microfinance/add-group-withdrawal');
			}
			
			else
			{
				$this->session->set_userdata("error_message","Could not save group withdrawal. Please try again");
			}
		}else{
			$v_data['customers'] = $this->group_model->all_groups_for_withdrawal();

			$data = array('title' => 'Group Withdrawals');
			$v_data['title'] = $data['title'];
			$data['content'] = $this->load->view('withdrawals/all_group_withdrawals', $v_data, true);
			$this->load->view('admin/templates/general_page', $data);
		}
		
	}

	public function list_group()
	{
		$v_data['customers'] = $this->group_model->all_groups_for_withdrawal();
		$data = array('title' => 'Choose a group to view its withdrawals');
		$v_data['title'] = $data['title'];
		$data['content'] = $this->load->view('withdrawals/list_group', $v_data, true);
		$this->load->view('admin/templates/general_page', $data);
	}

	public function show_group_withdrawal($id='0',$order = 'date_paid', $order_method = 'ASC')
	{
		if ($this->form_validation->run('list_withdrawals')){
			// echo $this->input->post('customer_id');
			$gid = $this->input->post('customer_id');
			
			$row = $this->group_model->get_group($gid);
			$groupdetails=$row->first_row();
			// print_r($groupdetails);

			// load groups data
			$where = 'group_id = '.$gid.'';
			$table = 'group_withdrawals';
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
			$query = $this->withdrawals_model->all_groups_withdrawal($table, $where, $config["per_page"], $page, $order, $order_method);
			
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
	

			$data = array('title' => $groupdetails->group_name.' withdrawals');
			$v_data['title'] = $data['title'];
			$data['content'] = $this->load->view('withdrawals/show_group_withdrawal', $v_data, true);
			$this->load->view('admin/templates/general_page', $data);
		}else 	if(isset($id) && $id > '0'){
				$gid = $id;
				// echo "fikad";
			
			$row = $this->group_model->get_group($gid);
			$groupdetails=$row->first_row();
			// print_r($groupdetails);

			// load groups data
			$where = 'group_id = '.$gid.'';
			$table = 'group_withdrawals';
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
			$query = $this->withdrawals_model->all_groups_withdrawal($table, $where, $config["per_page"], $page, $order, $order_method);
			
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
	

			$data = array('title' => $groupdetails->group_name.' withdrawals');
			$v_data['title'] = $data['title'];
			$data['content'] = $this->load->view('withdrawals/show_group_withdrawal', $v_data, true);
			$this->load->view('admin/templates/general_page', $data);
		}else{
			$v_data['customers'] = $this->group_model->all_groups_for_withdrawal();
			$data = array('title' => 'Choose group to edit');
			$v_data['title'] = $data['title'];
			$data['content'] = $this->load->view('withdrawals/list_group', $v_data, true);
			$this->load->view('admin/templates/general_page', $data);
		}
		 
	}
	public function delete_group_withdrawal($id)
	{
		if($group_id = $this->withdrawals_model->delete_group_withdrawal($id))
		{
			$this->session->set_userdata('success_message', 'Group withdrawal has been deleted');
			redirect('microfinance/show-group-withdrawal/'.$group_id['group_id']).'';
			// print_r ($group_id);
		}
		
		else
		{			

			$this->session->set_userdata('error_message', 'Group withdrawal could not be deleted');
			redirect('microfinance/show-group-withdrawal/'.$group_id['group_id']).'';
			// echo $group_id;
		}
		
	}
	public function edit_group_withdrawal($id='0')
	{
		

		
		if ($this->form_validation->run('group_withdrawals'))
		{

			$flag = $this->withdrawals_model->edit_group_withdrawal();

			if($flag != FALSE)
			{
				$id = $this->input->post('pid');

				$this->session->set_userdata("success_message", "group withdrawal updated");
				redirect('microfinance/edit-group-withdrawal/'.$id.'');
				// var_dump($flag);
			}
			
			else
			{
				$this->session->set_userdata("error_message","Could not update group withdrawal details. Please try again");
			}
		}else{
			if ($id=='0') {
				$id = $this->input->post('pid');
			};
			$groupwithdrawaldetails    = $this->withdrawals_model->get_withdrawal_details($id);
			$single                 = $groupwithdrawaldetails->first_row();
			// print_r($single);
			$v_data['id']             = $single->id;
			$v_data['customer_id']    = $single->group_id;
			// $withdrawal_type        = set_value('withdrawal_type');
			$v_data['withdrawal_amount'] = $single->amount;
			$v_data['slip_number']    = $single->slip_number;
			$v_data['date_paid']      = $single->date_paid;
			$v_data['withdrawal_month']  = $single->month_paid_for;
			$v_data['customers']    = $this->group_model->all_groups_for_withdrawal();
			
			$data            = array('title' => 'Group Withdrawals');
			$v_data['title'] = $data['title'];
			$data['content'] = $this->load->view('withdrawals/edit_single_group_withdrawal', $v_data, true);
			$this->load->view('admin/templates/general_page', $data);
		}


	}
}
/* End of file withdrawals.php */
/* Location: ./application/controllers/withdrawals.php */