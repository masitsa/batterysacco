<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Withdrawals_model extends CI_Model {

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
	public function add_individual_withdrawal_old()
	{
		$data = array(
			'individual_id'  => $this->input->post('customer_id'),
			'amount'         => $this->input->post('withdrawal_amount'),
			'slip_number'    => $this->input->post('slip_number'),
			'date_paid'      => $this->input->post('date_paid'),
			'month_paid_for' => $this->input->post('withdrawal_month'), 
		);
		if($this->db->insert('individual_withdrawals', $data))
		{
			return $this->db->insert_id();
		}
		else{
			return FALSE;
		}
	}
	public function get_withdrawal_type()
	{
		$this->db->from('withdrawal_type');
		$this->db->select('*');
		$this->db->where('withdrawal_type_status = 1');
		$query = $this->db->get();
		return $query;
	}
	public function add_individual_withdrawal($individual_id)
	{
		$withdrawal_type_id = $this->input->post('withdrawal_type_id');
		$items['payment_type'] = $this->input->post('withdrawal_type_id');
		//$items['document_number'] = $this->input->post('document_number');
		$items['payment_date'] = $this->input->post('withdrawal_date');
		$items['payment_amount'] = $this->input->post('withdrawal_amount');
		$items['created'] = date('Y-m-d H:i:s');
		$items['created_by'] = $this->session->userdata('personnel_id');
		$items['modified_by'] = $this->session->userdata('personnel_id');
		$items['branch_code'] = $this->session->userdata('branch_code');
		$items['individual_id'] = $individual_id;
		
		if($this->db->insert('savings_payment', $items))
		{
			
			if ($withdrawal_type_id == 1)
			{
				//$loan_items['document_number'] = $this->input->post('document_number');
				$loan_items['payment_date'] = $this->input->post('withdrawal_date');
				$loan_items['payment_amount'] = $this->input->post('withdrawal_amount');
				$loan_items['created'] = date('Y-m-d H:i:s');
				$loan_items['last_modified'] = date('Y-m-d H:i:s');
				$loan_items['payment_interest']=0;
				$loan_items['payment_type']=1;
				$loan_items['created_by'] = $this->session->userdata('personnel_id');
				$loan_items['modified_by'] = $this->session->userdata('personnel_id');
				$loan_items['individual_id'] = $individual_id;
				
				if($this->db->insert('loan_payment', $loan_items))
				{ 	
					return TRUE;
				}
				else
				{
					return FALSE;
				}
			}
			
		}
		else{
			return FALSE;
		}
		
	}
	public function all_individual_withdrawal($table, $where, $per_page, $page, $order = 'date_paid', $order_method = 'ASC')
	{
		$this->db->from($table);
		$this->db->select('*');
		$this->db->where($where);
		$this->db->order_by($order, $order_method);
		$query = $this->db->get('', $per_page, $page);
		
		return $query;
	}
	public function add_group_withdrawal()
	{
		$data = array(
			'group_id'  => $this->input->post('customer_id'),
			'amount'         => $this->input->post('withdrawal_amount'),
			'slip_number'    => $this->input->post('slip_number'),
			'date_paid'      => $this->input->post('date_paid'),
			'month_paid_for' => $this->input->post('withdrawal_month'), 
		);
		if($this->db->insert('group_withdrawals', $data))
		{
			return $this->db->insert_id();
		}
		else{
			return FALSE;
		}
	}
	public function get_individual_withdrawal_details($id)
	{
		$this->db->from('individual_withdrawals');
		$this->db->select('*');
		$this->db->where('id = '.$id);
		$query = $this->db->get();
		
		return $query;
	}
	public function edit_individual_withdrawal()
	{
		$data = array(
			'id'=>$this->input->post('pid'),
			'individual_id'=>$this->input->post('customer_id'),
			'amount'=>$this->input->post('withdrawal_amount'),
			'slip_number'=>$this->input->post('slip_number'),
			'date_paid'=>$this->input->post('date_paid'),
			'month_paid_for' => $this->input->post('withdrawal_month'),
		);
		print_r($data);
		$this->db->where('id', $data['id']);
		if($this->db->update('individual_withdrawals', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	public function delete_individual_withdrawal($savings_withdrawal_id)
	{	
		if($this->db->delete('savings_withdrawal', array('savings_withdrawal_id' => $savings_withdrawal_id)))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	public function get_individual_id_by_withdrawalsid($id)
	{
		$this->db->from('individual_withdrawals');
		$this->db->select('individual_id');
		$this->db->where('id = '.$id);
		$query = $this->db->get();
		$pid = $query->first_row('array');
		// var_dump($pid['group_id']);
		return $pid;
	}
	public function all_groups_withdrawal($table, $where, $per_page, $page, $order = 'date_paid', $order_method = 'ASC')
	{
		$this->db->from($table);
		$this->db->select('*');
		$this->db->where($where);
		$this->db->order_by($order, $order_method);
		$query = $this->db->get('', $per_page, $page);
		
		return $query;
	}

	public function delete_group_withdrawal($id)
	{	
		$group_id = $this->get_group_id_by_withdrawalsid($id);
		if($this->db->delete('group_withdrawals', array('id' => $id)))
		{
			return $group_id;
		}
		else{
			return FALSE;
		}
	}
	public function get_withdrawal_details($id)
	{
		$this->db->from('group_withdrawals');
		$this->db->select('*');
		$this->db->where('id = '.$id);
		$query = $this->db->get();
		
		return $query;
	}
	public function get_group_id_by_withdrawalsid($id)
	{
		$this->db->from('group_withdrawals');
		$this->db->select('group_id');
		$this->db->where('id = '.$id);
		$query = $this->db->get();
		$pid = $query->first_row('array');
		// var_dump($pid['group_id']);
		return $pid;
	}

	public function edit_group_withdrawal()
	{
		$data = array(
			'id'=>$this->input->post('pid'),
			'group_id'=>$this->input->post('customer_id'),
			'amount'=>$this->input->post('withdrawal_amount'),
			'slip_number'=>$this->input->post('slip_number'),
			'date_paid'=>$this->input->post('date_paid'),
			'month_paid_for' => $this->input->post('withdrawal_month'),
		);
		// print_r($data);
		$this->db->where('id', $data['id']);
		if($this->db->update('group_withdrawals', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
}

/* End of file withdrawals_model.php */
/* Location: ./application/models/withdrawals_model.php */