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

	public function export_member_balances()
	{
		$this->load->library('excel');
		
		//get all transactions
		$individual_balance_search = $this->session->userdata('individual_balance_search');
		//$where = '(visit_type_id <> 2 OR visit_type_id <> 1) AND individual_delete = '.$delete;
		$where = 'individual.individual_id > 0 AND individual_type.individual_type_id = individual.individual_type_id';
		if(!empty($individual_balance_search))
		{
			$where .= $individual_balance_search;
		}
		
		$table = 'individual,individual_type';
		
		
		$this->db->where($where);
		$this->db->order_by('individual.individual_lname', 'ASC');
		$this->db->select('*');
		$individual_query = $this->db->get($table);
		
		$title = 'Individual Member Balances';
		
		if($individual_query->num_rows() > 0)
		{
			$count_items = 0;
			/*
				-----------------------------------------------------------------------------------------
				Document Header
				-----------------------------------------------------------------------------------------
			*/

			$row_count = 0;
			$report[$row_count][0] = '#';
			$report[$row_count][1] = 'Member Number';
			$report[$row_count][2] = 'Member Type';
			$report[$row_count][3] = 'Member Name';
			$report[$row_count][4] = 'Share Balance';
			$report[$row_count][5] = 'Last Share Contribution Date';
			$report[$row_count][6] = 'Loan Balance';
			$report[$row_count][7] = 'Last Repayment Date';
			//get & display all services
			
			//display all patient data in the leftmost columns
			foreach($individual_query->result() as $row)
			{
				$count_items++;
				$row_count++;
				$individual_id = $row->individual_id;
				$individual_fname = $row->individual_fname;
				$individual_mname = $row->individual_mname;
				$individual_lname = $row->individual_lname;
				$individual_username = $row->individual_username;
				$individual_phone = $row->individual_phone;
				$individual_email = $row->individual_email;
				$individual_status = $row->individual_status;
				$individual_number = $row->individual_number;
				$individual_type_name = $row->individual_type_name;
				$individual_name = $individual_fname.' '.$individual_lname;
				$outstanding_loan = $row->outstanding_loan;
				$total_savings = $row->total_savings;
				$individual_balance_data = $this->reports_model->get_individual_balance_data($individual_id, $total_savings, $outstanding_loan);
				
				//display the patient data
				$report[$row_count][0] = $count_items;
				$report[$row_count][1] = $individual_number;
				$report[$row_count][2] = $individual_type_name;
				$report[$row_count][3] = $individual_name;
				$report[$row_count][4] = number_format($individual_balance_data['running_balance_savings'],0);
				$report[$row_count][5] = date('d M Y',strtotime($individual_balance_data['last_transaction_date']));
				$report[$row_count][6] = number_format($individual_balance_data['running_balance_loans'],0);
				$report[$row_count][7] = $individual_balance_data['last_loan_payment_date'];
			}
		}
		
		//create the excel document
		$this->excel->addArray ( $report );
		$this->excel->generateXML ($title);
	}
	
	public function get_individual_balance_data($individual_id, $total_savings, $outstanding_loan)
	{
		//last transaction date
		$last_transaction_date = '';

		$individual_data = $this->individual_model->get_individual($individual_id);
		$all_savings_payments = $this->individual_model->get_savings_payments($individual_id);
		$individual_loan = $this->individual_model->get_individual_loans($individual_id);
		$payments = $this->individual_model->get_loan_payments($individual_id);
		$disbursments = $this->individual_model->get_disbursments($individual_id);
		
		//get all savings before date
		$total_credit = $running_balance = $total_savings;
		$total_debit = $total_credit = $running_balance_savings = 0;
		
		if($all_savings_payments->num_rows() > 0)
		{
			$count = 1;
			$total_payments = 0;
			foreach ($all_savings_payments->result() as $row2)
			{
				$savings_payment_id = $row2->savings_payment_id;
				$payment_amount = $row2->payment_amount;
				$payment_date = $row2->payment_date;
				$payment_type = $row2->payment_type;
				$description = $row2->description;
				$cheque_number = $row2->cheque_number;
				$last_transaction_date = $payment_date;
				$debit = $credit= '';
				if(empty($description))
				{
					$description = 'Shares deposit';
				}
				if ($payment_type == 1)
				{
					$debit = number_format($payment_amount, 2);
					$running_balance -= $payment_amount;
					$total_debit += $payment_amount;	
				}
				else
				{
					$credit = number_format($payment_amount, 2);
					$running_balance += $payment_amount;
					$total_credit += $payment_amount;	
				}
									
				if($payment_amount > 0)
				{
					$count++;
					if ($running_balance > 0)
					{
					}
				}
		
			}
			$running_balance_savings = $running_balance;
		}
		
		/*****************
		**	Loan Balance
		*****************/
		$last_loan_payment_date = '';
		$last_date = '';
		$count = 1;
		$total_debit = $running_balance = $outstanding_loan;
		$total_credit = $running_balance_loans = 0;
		$total_disbursments = $disbursments->num_rows();
		$disbursments_count = 0;
		
		if($total_disbursments > 0)
		{
			foreach ($disbursments->result() as $row)
			{
				$disbursement_date = $row->dibursement_date;
				$cheque_amount = $row->cheque_amount;
				$cheque_number = $row->cheque_number;
				//$disbursed_date = date('jS d M Y',strtotime($disbursement_date));
				$disbursments_count++;
				
				//get all loan deductions before date
				if($payments->num_rows() > 0)
				{
					foreach ($payments->result() as $row2)
					{
						$loan_payment_id = $row2->loan_payment_id;
						$personnel_fname = $row2->personnel_fname;
						$personnel_onames = $row2->personnel_onames;
						$payment_amount = $row2->payment_amount;
						$payment_interest = $row2->payment_interest;
						$created = date('jS M Y H:i:s',strtotime($row2->created));
						$payment_date = $row2->payment_date;
						
						if(($payment_date <= $disbursement_date) && ($payment_date > $last_date) && ($payment_amount > 0))
						{
							$last_loan_payment_date = date('d M Y',strtotime($payment_date));
							$count++;
							$running_balance -= $payment_amount;
							$total_credit += $payment_amount;
						}
					}
				}
				
				//display disbursment if cheque amount > 0
				if($cheque_amount > 0)
				{
					$running_balance += $cheque_amount;
					$total_debit += $cheque_amount;
					
					$count++;
				}
				
				//check if there are any more payments
				if($total_disbursments == $disbursments_count)
				{
					//get all loan deductions before date
					if($payments->num_rows() > 0)
					{
						foreach ($payments->result() as $row2)
						{
							$loan_payment_id = $row2->loan_payment_id;
							$personnel_fname = $row2->personnel_fname;
							$personnel_onames = $row2->personnel_onames;
							$payment_amount = $row2->payment_amount;
							$payment_interest = $row2->payment_interest;
							$created = date('jS M Y H:i:s',strtotime($row2->created));
							$payment_date = $row2->payment_date;
							
							if(($payment_date > $disbursement_date) && ($payment_amount > 0))
							{
								$last_loan_payment_date = date('d M Y',strtotime($payment_date));
								$count++;
								$running_balance -= $payment_amount;
								$total_credit += $payment_amount;
							}
						}
					}
				}
				$last_date = $disbursement_date;
			}
		}
		
		else
		{
			//get all loan deductions before date
			if($payments->num_rows() > 0)

			{
				foreach ($payments->result() as $row2)
				{
					$loan_payment_id = $row2->loan_payment_id;
					$personnel_fname = $row2->personnel_fname;
	
					$personnel_onames = $row2->personnel_onames;
					$payment_amount = $row2->payment_amount;
					$payment_interest = $row2->payment_interest;
					$created = date('jS M Y H:i:s',strtotime($row2->created));
					$payment_date = $row2->payment_date;
					$running_balance -= $payment_amount;
					
					$count++;
					if($payment_amount > 0)
					{
						$last_loan_payment_date = date('d M Y',strtotime($payment_date));
						$total_credit += $payment_amount;
					}
				}
			}
		}
		$running_balance_loans = $running_balance;
		
		$individual_balances = array(
			'running_balance_savings' => $running_balance_savings,
			'last_transaction_date' => $last_transaction_date,
			'running_balance_loans' => $running_balance_loans,
			'last_loan_payment_date' => $last_loan_payment_date,
		);
		
		return $individual_balances;
	}
}