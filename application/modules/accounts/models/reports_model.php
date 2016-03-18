<?php

class Reports_model extends CI_Model 
{
	public function get_loan_payments()
	{
		$this->db->from('loan_payment');
		$this->db->select('loan_payment.*');
		$this->db->order_by('loan_payment.payment_date', 'ASC');
		$this->db->where('loan_payment.loan_payment_delete <> 1');
		$query = $this->db->get();
		
		return $query;
	}
	
	public function get_expenses()
	{
		$this->db->select('SUM(creditor_account_amount) AS expense_amount , creditor_name');
		$this->db->from('creditor_account, creditor');
		$this->db->where('creditor_account.creditor_id = creditor.creditor_id');
		$this->db->order_by('creditor_name', 'ASC');
		$this->db->group_by('creditor_name');
		$query = $this->db->get();
		
		return $query;
	}
}
?>