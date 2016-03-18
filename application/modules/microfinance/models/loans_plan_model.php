<?php

class Loans_plan_model extends CI_Model 
{	


	/*
	*	Count all items from a table
	*	@param string $table
	* 	@param string $where
	*
	*/
	public function count_items($table, $where, $limit = NULL)
	{
		if($limit != NULL)
		{
			$this->db->limit($limit);
		}
		$this->db->from($table);
		$this->db->where($where);
		return $this->db->count_all_results();
	}
	
	/*
	*	Retrieve all loans_plan
	*
	*/
	public function all_loans_plan()
	{
		$this->db->where('loans_plan_status = 1');
		$this->db->order_by('loans_plan_name');
		$query = $this->db->get('loans_plan');
		
		return $query;
	}
	/*
	*	Retrieve all compounding_periods
	*
	*/
	public function get_compounding_periods()
	{
		$query = $this->db->get('compounding_period');
		
		return $query;
	}

	/*
	*	Retrieve all interest scheme
	*
	*/
	public function get_interest_scheme()
	{
		$this->db->order_by('interest_name');
		$query = $this->db->get('interest');
		return $query;
	}
	
	public function get_installment_types()
	{
		$this->db->order_by('installment_type_name');
		$query = $this->db->get('installment_type');
		return $query;
	}
	/*
	*	Retrieve all parent loans_plan
	*
	*/
	public function all_parent_loans_plan($order = 'loans_plan_name')
	{
		$this->db->where('loans_plan_status = 1 AND loans_plan_parent = 0');
		$this->db->order_by($order, 'ASC');
		$query = $this->db->get('loans_plan');
		
		return $query;
	}
	/*
	*	Retrieve all children loans_plan
	*
	*/
	public function all_child_loans_plan()
	{
		$this->db->where('loans_plan_status = 1 AND loans_plan_parent > 0');
		$this->db->order_by('loans_plan_name', 'ASC');
		$query = $this->db->get('loans_plan');
		
		return $query;
	}
	
	/*
	*	Retrieve all loans_plan
	*	@param string $table
	* 	@param string $where
	*
	*/
	public function get_all_loans_plan($table, $where, $per_page, $page, $order = 'loans_plan_name', $order_method = 'ASC')
	{
		//retrieve all users
		$this->db->from($table);
		$this->db->select('loans_plan.*, installment_type.installment_type_name, interest.interest_name');
		$this->db->where($where);
		$this->db->order_by($order, $order_method);
		$query = $this->db->get('', $per_page, $page);
		
		return $query;
	}
	
	/*
	*	Add a new loans_plan
	*	@param string $image_name
	*
	*/
	public function add_loans_plan()
	{
		$data = array(
			'interest_rate'                         =>$this->input->post('interest_rate'),
			'interest_id'                           =>$this->input->post('interest_id'),
			'loans_plan_name'               		=>$this->input->post('loans_plan_name'),
			'installment_type_id'               	=>$this->input->post('installment_type_id'),
			'grace_period_minimum'               	=>$this->input->post('grace_period_minimum'),
			'grace_period_maximum'           		=>$this->input->post('grace_period_maximum'),
			'grace_period_default'          		=>$this->input->post('grace_period_default'),
			'charge_interest_over_grace_period'		=>$this->input->post('charge_interest_over_grace_period'),
			'maximum_loan_amount'                   =>$this->input->post('maximum_loan_amount'),
			'minimum_loan_amount'					=>$this->input->post('minimum_loan_amount'),
			'custom_loan_amount'					=>$this->input->post('custom_loan_amount'),
			'maximum_number_of_installments'		=>$this->input->post('maximum_number_of_installments'),
			'minimum_number_of_installments'		=>$this->input->post('minimum_number_of_installments'),
			'custom_number_of_installments'			=>$this->input->post('custom_number_of_installments'),
			'minimum_late_fee_on_total_loan'		=>$this->input->post('minimum_late_fee_on_total_loan'),
			'maximum_late_fee_on_total_loan'		=>$this->input->post('maximum_late_fee_on_total_loan'),
			'custom_late_fee_on_total_loan'			=>$this->input->post('custom_late_fee_on_total_loan'),
			'minimum_late_fee_on_overdue_principal'	=>$this->input->post('minimum_late_fee_on_overdue_principal'),
			'maximum_late_fee_on_overdue_principal'	=>$this->input->post('maximum_late_fee_on_overdue_principal'),
			'custom_late_fee_on_overdue_principal'	=>$this->input->post('custom_late_fee_on_overdue_principal'),
			'minimum_late_fee_on_overdue_interest'	=>$this->input->post('minimum_late_fee_on_overdue_interest'),
			'maximum_late_fee_on_overdue_interest'	=>$this->input->post('maximum_late_fee_on_overdue_interest'),
			'custom_late_fee_on_overdue_interest'	=>$this->input->post('custom_late_fee_on_overdue_interest'),
			'maximum_number_of_guarantors'			=>$this->input->post('maximum_number_of_guarantors'),
			'minimum_number_of_guarantors'			=>$this->input->post('minimum_number_of_guarantors'),
			'custom_number_of_guarantors'			=>$this->input->post('custom_number_of_guarantors')
		);
		
		if($this->db->insert('loans_plan', $data))
		{
			return $this->db->insert_id();
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Update an existing loans_plan
	*	@param string $image_name
	*	@param int $loans_plan_id
	*
	*/
	public function edit_loans_plan($loans_plan_id)
	{
		$data = array(
			'interest_rate'                         =>$this->input->post('interest_rate'),
			'interest_id'                           =>$this->input->post('interest_id'),
			'loans_plan_name'               		=>$this->input->post('loans_plan_name'),
			'installment_type_id'               	=>$this->input->post('installment_type_id'),
			'grace_period_minimum'               	=>$this->input->post('grace_period_minimum'),
			'grace_period_maximum'           		=>$this->input->post('grace_period_maximum'),
			'grace_period_default'          		=>$this->input->post('grace_period_default'),
			'charge_interest_over_grace_period'		=>$this->input->post('charge_interest_over_grace_period'),
			'maximum_loan_amount'                   =>$this->input->post('maximum_loan_amount'),
			'minimum_loan_amount'					=>$this->input->post('minimum_loan_amount'),
			'custom_loan_amount'					=>$this->input->post('custom_loan_amount'),
			'maximum_number_of_installments'		=>$this->input->post('maximum_number_of_installments'),
			'minimum_number_of_installments'		=>$this->input->post('minimum_number_of_installments'),
			'custom_number_of_installments'			=>$this->input->post('custom_number_of_installments'),
			'minimum_late_fee_on_total_loan'		=>$this->input->post('minimum_late_fee_on_total_loan'),
			'maximum_late_fee_on_total_loan'		=>$this->input->post('maximum_late_fee_on_total_loan'),
			'custom_late_fee_on_total_loan'			=>$this->input->post('custom_late_fee_on_total_loan'),
			'minimum_late_fee_on_overdue_principal'	=>$this->input->post('minimum_late_fee_on_overdue_principal'),
			'maximum_late_fee_on_overdue_principal'	=>$this->input->post('maximum_late_fee_on_overdue_principal'),
			'custom_late_fee_on_overdue_principal'	=>$this->input->post('custom_late_fee_on_overdue_principal'),
			'minimum_late_fee_on_overdue_interest'	=>$this->input->post('minimum_late_fee_on_overdue_interest'),
			'maximum_late_fee_on_overdue_interest'	=>$this->input->post('maximum_late_fee_on_overdue_interest'),
			'custom_late_fee_on_overdue_interest'	=>$this->input->post('custom_late_fee_on_overdue_interest'),
			'maximum_number_of_guarantors'			=>$this->input->post('maximum_number_of_guarantors'),
			'minimum_number_of_guarantors'			=>$this->input->post('minimum_number_of_guarantors'),
			'custom_number_of_guarantors'			=>$this->input->post('custom_number_of_guarantors')
		);
		
		$this->db->where('loans_plan_id', $loans_plan_id);
		if($this->db->update('loans_plan', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	get a single loans_plan's children
	*	@param int $loans_plan_id
	*
	*/
	public function get_sub_loans_plan($loans_plan_id)
	{
		//retrieve all users
		$this->db->from('loans_plan');
		$this->db->select('*');
		$this->db->where('loans_plan_parent = '.$loans_plan_id);
		$query = $this->db->get();
		
		return $query;
	}
	
	/*
	*	get a single loans_plan's details
	*	@param int $loans_plan_id
	*
	*/
	public function get_loans_plan($loans_plan_id)
	{
		//retrieve all users
		$this->db->from('loans_plan');
		$this->db->select('*');
		$this->db->join('interest', 'interest.interest_id = loans_plan.interest_id', 'left');
		$this->db->join('installment_type', 'installment_type.installment_type_id = loans_plan.installment_type_id', 'left');
		$this->db->where('loans_plan_id = '.$loans_plan_id);
		$query = $this->db->get();
		
		return $query;
	}
	
	/*
	*	Delete an existing loans_plan
	*	@param int $loans_plan_id
	*
	*/
	public function delete_loans_plan($loans_plan_id)
	{
		//delete children
		if($this->db->delete('loans_plan', array('loans_plan_parent' => $loans_plan_id)))
		{
			//delete parent
			if($this->db->delete('loans_plan', array('loans_plan_id' => $loans_plan_id)))
			{
				return TRUE;
			}
			else{
				return FALSE;
			}
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Activate a deactivated loans_plan
	*	@param int $loans_plan_id
	*
	*/
	public function activate_loans_plan($loans_plan_id)
	{
		$data = array(
				'loans_plan_status' => 1
			);
		$this->db->where('loans_plan_id', $loans_plan_id);
		

		if($this->db->update('loans_plan', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Deactivate an activated loans_plan
	*	@param int $loans_plan_id
	*
	*/
	public function deactivate_loans_plan($loans_plan_id)
	{
		$data = array(
				'loans_plan_status' => 0
			);
		$this->db->where('loans_plan_id', $loans_plan_id);
		
		if($this->db->update('loans_plan', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Retrieve gender
	*
	*/
	public function get_gender()
	{
		$this->db->order_by('gender_name');
		$query = $this->db->get('gender');
		
		return $query;
	}
	
	/*
	*	Retrieve title
	*
	*/
	public function get_title()
	{
		$this->db->order_by('title_name');
		$query = $this->db->get('title');
		
		return $query;
	}
	
	/*
	*	Retrieve civil_status
	*
	*/
	public function get_civil_status()
	{
		$this->db->order_by('civil_status_name');
		$query = $this->db->get('civil_status');
		
		return $query;
	}
	
	/*
	*	Retrieve religion
	*
	*/
	public function get_religion()
	{
		$this->db->order_by('religion_name');
		$query = $this->db->get('religion');
		
		return $query;
	}
	
	/*
	*	Retrieve relationship
	*
	*/
	public function get_relationship()
	{
		$this->db->order_by('relationship_name');
		$query = $this->db->get('relationship');
		
		return $query;
	}
	
	/*
	*	Select get_job_titles
	*
	*/
	public function get_job_titles()
	{
		$this->db->select('*');
		$this->db->order_by('job_title_name', 'ASC');
		$query = $this->db->get('job_title');
		
		return $query;
	}
	
	/*
	*	get a single loans_plan's details
	*	@param int $loans_plan_id
	*
	*/
	public function get_emergency_contacts($loans_plan_id)
	{
		//retrieve all users
		$this->db->from('loans_plan_emergency');
		$this->db->select('*');
		$this->db->where(array('loans_plan_emergency.loans_plan_id' => $loans_plan_id, 'loans_plan_emergency.relationship_id' => 'relationship.relationship_id'));
		$this->db->order_by('loans_plan_emergency_fname');
		$query = $this->db->get();
		
		return $query;
	}
	
	/*
	*	get a single loans_plan's details
	*	@param int $loans_plan_id
	*
	*/
	public function get_loans_plan_dependants($loans_plan_id)
	{
		//retrieve all users
		$this->db->from('loans_plan_dependant');
		$this->db->select('*');
		$this->db->where(array('loans_plan_dependant.loans_plan_id' => $loans_plan_id, 'loans_plan_dependant.relationship_id' => 'relationship.relationship_id'));
		$this->db->order_by('loans_plan_dependant_fname');
		$query = $this->db->get();
		
		return $query;
	}
	
	/*
	*	get a single loans_plan's details
	*	@param int $loans_plan_id
	*
	*/
	public function get_loans_plan_jobs($loans_plan_id)
	{
		//retrieve all users
		$this->db->from('loans_plan_job');
		$this->db->select('loans_plan_job.*');
		$this->db->order_by('employment_date', 'DESC');
		$this->db->where(array('loans_plan_job.loans_plan_id' => $loans_plan_id));
		$query = $this->db->get();
		
		return $query;
	}
	
	public function get_leave_types()
	{
		$table = "leave_type";
		$where = "leave_type_status = 0";
		$items = "leave_type_id, leave_type_name";
		$order = "leave_type_name";
		
		$this->db->where($where);
		$this->db->order_by($order);
		$result = $this->db->get($table);
		
		return $result;
	}
	
	/*
	*	get a single loans_plan's leave details
	*	@param int $loans_plan_id
	*
	*/
	public function get_loans_plan_leave($loans_plan_id)
	{
		//retrieve all users
		$this->db->from('leave_duration, leave_type');
		$this->db->select('leave_duration.*, leave_type.leave_type_name');
		$this->db->order_by('start_date', 'DESC');
		$this->db->where(array('leave_duration.loans_plan_id' => $loans_plan_id, 'leave_duration.leave_type_id' => 'leave_type.leave_type_id'));
		$query = $this->db->get();
		
		return $query;
	}
	
	/*
	*	get a single loans_plan's roles
	*	@param int $loans_plan_id
	*
	*/
	public function get_loans_plan_roles($loans_plan_id)
	{
		//retrieve all users
		$this->db->from('loans_plan_section, section');
		$this->db->select('loans_plan_section.*, section.section_name, section.section_position');
		$this->db->order_by('section_position', 'ASC');
		$this->db->where(array('loans_plan_section.loans_plan_id' => $loans_plan_id, 'loans_plan_section.section_id' => 'section.section_id'));
		$query = $this->db->get();
		
		return $query;
	}
}
?>