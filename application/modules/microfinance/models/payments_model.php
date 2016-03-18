<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payments_model extends CI_Model {

	// public $variable;

	public function __construct()
	{
		parent::__construct();
		
	}
	public function all_individual()
	{
		// $this->db->where('individual_status = 0');
		$query = $this->db->get('individual');
		
		// var_dump($query);
		return $query;
	}
	public function add_individual_payment($individual_id)
	{
		$data = array(
			'individual_id'  => $individual_id,
			'payment_amount' => $this->input->post('payment_amount'),
			'payment_date'   => $this->input->post('payment_date'),
			'created'      => date('Y-m-d H:i:s'),
			'created_by' => $this->session->userdata('personnel_id'), 
			'modified_by' => $this->session->userdata('personnel_id'), 
		);
		if($this->db->insert('savings_payment', $data))
		{
			return $this->db->insert_id();
		}
		else{
			return FALSE;
		}
	}
	public function add_loan_payment($individual_id)
	{
		$data = array(
			'individual_id'  => $individual_id,
			'payment_amount' => $this->input->post('payment_amount'),
			'payment_interest' => $this->input->post('interest_amount'),
			'payment_date'   => $this->input->post('payment_date'),
			'created'      => date('Y-m-d H:i:s'),
			'created_by' => $this->session->userdata('personnel_id'), 
			'modified_by' => $this->session->userdata('personnel_id'), 
		);
		if($this->db->insert('loan_payment', $data))
		{
			return $this->db->insert_id();
		}
		else{
			return FALSE;
		}
	}
	public function all_individual_payment($table, $where, $per_page, $page, $order = 'date_paid', $order_method = 'ASC')
	{
		$this->db->from($table);
		$this->db->select('*');
		$this->db->where($where);
		$this->db->order_by($order, $order_method);
		$query = $this->db->get('', $per_page, $page);
		
		return $query;
	}
	public function add_group_payment()
	{
		$data = array(
			'group_id'  => $this->input->post('customer_id'),
			'amount'         => $this->input->post('payment_amount'),
			'slip_number'    => $this->input->post('slip_number'),
			'date_paid'      => $this->input->post('date_paid'),
			'month_paid_for' => $this->input->post('payment_month'), 
		);
		if($this->db->insert('group_payments', $data))
		{
			return $this->db->insert_id();
		}
		else{
			return FALSE;
		}
	}
	public function get_individual_payment_details($id)
	{
		$this->db->from('individual_payments');
		$this->db->select('*');
		$this->db->where('id = '.$id);
		$query = $this->db->get();
		
		return $query;
	}
	public function edit_individual_payment()
	{
		$data = array(
			'id'=>$this->input->post('pid'),
			'individual_id'=>$this->input->post('customer_id'),
			'amount'=>$this->input->post('payment_amount'),
			'slip_number'=>$this->input->post('slip_number'),
			'date_paid'=>$this->input->post('date_paid'),
			'month_paid_for' => $this->input->post('payment_month'),
		);
		print_r($data);
		$this->db->where('id', $data['id']);
		if($this->db->update('individual_payments', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	public function delete_individual_payment($id)
	{	
		$individual_id = $this->get_individual_id_by_paymentsid($id);
		if($this->db->delete('individual_payments', array('id' => $id)))
		{
			return $individual_id;
		}
		else{
			return FALSE;
		}
	}
	public function get_individual_id_by_paymentsid($id)
	{
		$this->db->from('individual_payments');
		$this->db->select('individual_id');
		$this->db->where('id = '.$id);
		$query = $this->db->get();
		$pid = $query->first_row('array');
		// var_dump($pid['group_id']);
		return $pid;
	}
	public function all_groups_payment($table, $where, $per_page, $page, $order = 'date_paid', $order_method = 'ASC')
	{
		$this->db->from($table);
		$this->db->select('*');
		$this->db->where($where);
		$this->db->order_by($order, $order_method);
		$query = $this->db->get('', $per_page, $page);
		
		return $query;
	}

	public function delete_group_payment($id)
	{	
		$group_id = $this->get_group_id_by_paymentsid($id);
		if($this->db->delete('group_payments', array('id' => $id)))
		{
			return $group_id;
		}
		else{
			return FALSE;
		}
	}
	public function get_payment_details($id)
	{
		$this->db->from('group_payments');
		$this->db->select('*');
		$this->db->where('id = '.$id);
		$query = $this->db->get();
		
		return $query;
	}
	public function get_group_id_by_paymentsid($id)
	{
		$this->db->from('group_payments');
		$this->db->select('group_id');
		$this->db->where('id = '.$id);
		$query = $this->db->get();
		$pid = $query->first_row('array');
		// var_dump($pid['group_id']);
		return $pid;
	}

	public function edit_group_payment()
	{
		$data = array(
			'id'=>$this->input->post('pid'),
			'group_id'=>$this->input->post('customer_id'),
			'amount'=>$this->input->post('payment_amount'),
			'slip_number'=>$this->input->post('slip_number'),
			'date_paid'=>$this->input->post('date_paid'),
			'month_paid_for' => $this->input->post('payment_month'),
		);
		// print_r($data);
		$this->db->where('id', $data['id']);
		if($this->db->update('group_payments', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
}

/* End of file payments_model.php */
/* Location: ./application/models/payments_model.php */