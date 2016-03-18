<?php

class Reports_model extends CI_Model 
{
	public function get_total_members($month = NULL, $year = NULL)
	{
		/*if($month == NULL)
		{
			$date = date('Y-m-d');
		}
		if($where == NULL)
		{
			$where = 'individual.created = \''.$date.'\'';
		}
		
		else
		{
			$where .= ' AND individual.created = \''.$date.'\' ';
		}*/
		
		$this->db->select('COUNT(individual.individual_id) AS individuals_total');
		//$this->db->where($where);
		$query = $this->db->get('individual');
		
		$result = $query->row();
		
		return $result->individuals_total;
	}
	
	public function month_interest_payments($month = NULL, $year = NULL)
	{
		if($month == NULL)
		{
			$month = date('m');
			$year = date('Y');
		}
		//select the user by email from the database
		$this->db->select('SUM(payment_interest) AS total_amount');
		$this->db->where('MONTH(payment_date) = \''.$month.'\' AND YEAR(payment_date) = \''.$year.'\'');
		$this->db->from('loan_payment');
		$query = $this->db->get();
		
		$result = $query->row();
		
		return $result->total_amount;
	}
	
	public function month_loan_payments($month = NULL, $year = NULL)
	{
		if($month == NULL)
		{
			$month = date('m');
			$year = date('Y');
		}
		//select the user by email from the database
		$this->db->select('SUM(payment_amount) AS total_amount');
		$this->db->where('MONTH(payment_date) = \''.$month.'\' AND YEAR(payment_date) = \''.$year.'\'');
		$this->db->from('loan_payment');
		$query = $this->db->get();
		
		$result = $query->row();
		
		return $result->total_amount;
	}
	
	public function month_savings_payments($month = NULL, $year = NULL)
	{
		if($month == NULL)
		{
			$month = date('m');
			$year = date('Y');
		}
		//select the user by email from the database
		$this->db->select('SUM(payment_amount) AS total_amount');
		$this->db->where('MONTH(payment_date) = \''.$month.'\' AND YEAR(payment_date) = \''.$year.'\'');
		$this->db->from('savings_payment');
		$query = $this->db->get();
		
		$result = $query->row();
		
		return $result->total_amount;
	}
	
	public function get_loan_type_total($loan_type_id, $date = NULL)
	{
		if($date == NULL)
		{
			$date = date('Y-m-d');
		}
		
		$table = 'individual_loan';
		
		$where = 'individual_loan.individual_loan_status = '.$loan_type_id;
		
		/*$visit_search = $this->session->userdata('all_departments_search');
		if(!empty($visit_search))
		{
			$where = 'individual_loans.individual_loan_status = '.$loan_type_id.' '. $visit_search;
			$table .= ', visit';
		}*/
		
		$this->db->select('COUNT(individual_loan_id) AS service_total');
		$this->db->where($where);
		$query = $this->db->get($table);
		
		$result = $query->row();
		$total = $result->service_total;;
		
		if($total == NULL)
		{
			$total = 0;
		}
		
		return $total;
	}
	
	public function get_all_loan_types()
	{
		$this->db->select('*');
		$this->db->order_by('loan_type_name');
		$query = $this->db->get('loan_type');
		
		return $query;
	}
	
	public function get_all_applications($date = NULL)
	{
		if($date == NULL)
		{
			$date = date('Y-m-d');
		}
		$where = 'individual.individual_id = individual_loan.individual_id AND individual_loan.individual_loan_status <> 2';
		
		$this->db->select('individual_loan.*, individual.*');
		$this->db->where($where);
		$query = $this->db->get('individual_loan, individual');
		
		return $query;
	}
	
	public function get_all_sessions($date = NULL)
	{
		if($date == NULL)
		{
			$date = date('Y-m-d');
		}
		$where = 'personnel.personnel_id = session.personnel_id AND session.session_name_id = session_name.session_name_id AND session_time LIKE \''.$date.'%\'';
		
		$this->db->select('session_name_name, session_time, personnel_fname, personnel_onames');
		$this->db->where($where);
		$this->db->order_by('session_time', 'DESC');
		$query = $this->db->get('session, session_name, personnel');
		
		return $query;
	}
}